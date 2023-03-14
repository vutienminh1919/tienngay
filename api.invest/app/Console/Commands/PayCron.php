<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Investor;
use App\Models\Pay;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Service\LogNlService;
use App\Service\LogPayService;
use App\Service\NganLuongPayOut;
use App\Service\NotificationService;
use App\Service\TransactionService;
use App\Service\Vimo;
use Illuminate\Console\Command;

class PayCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay:investor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto payment to investors ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Vimo $vimo,
                                PayRepositoryInterface $pay,
                                InvestorRepositoryInterface $investor,
                                LogPayService $log_pay_service,
                                TransactionService $transactionService,
                                NotificationService $notificationService,
                                ContractRepositoryInterface $contract,
                                NganLuongPayOut $nganLuongPayOut,
                                LogNlService $logNlService)
    {
        parent::__construct();
        $this->vimo = $vimo;
        $this->pay_model = $pay;
        $this->investor_model = $investor;
        $this->log_pay_service = $log_pay_service;
        $this->transaction_service = $transactionService;
        $this->notificationService = $notificationService;
        $this->contract_model = $contract;
        $this->nganLuongPayOut = $nganLuongPayOut;
        $this->logNlService = $logNlService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pays = $this->pay_model->danh_sach_thanh_toan_tu_dong();
        if (count($pays) > 0) {
            foreach ($pays as $pay) {
                $contract = $this->contract_model->find($pay->contract_id);
                if (!$contract) {
                    $note['error_code'] = '3001';
                    $note['error_description'] = 'Contract does not exist';
                    $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::HUY]);
                    continue;
                }

                if ($contract['status_contract'] != Contract::EFFECT) {
                    $note['error_code'] = '3000';
                    $note['error_description'] = 'Contract expire';
                    $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::HUY]);
                    continue;
                }

                if ($contract['status'] != Contract::SUCCESS) {
                    $note['error_code'] = '3002';
                    $note['error_description'] = 'Contract block or pending';
                    $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::HUY]);
                    continue;
                }

                $investor = $this->investor_model->findOne(['id' => $contract['investor_id'], Investor::COLUMN_STATUS => Investor::STATUS_ACTIVE]);
                if (empty($investor)) {
                    $note['error_code'] = '2001';
                    $note['error_description'] = 'Investor is not activated or locked';
                    $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::HUY]);
                    continue;
                }

                if (empty($investor->type_interest_receiving_account)) {
                    $note['error_code'] = '2003';
                    $note['error_description'] = 'The form of receiving interest has not been updated yet';
                    $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_TU_DONG_THAT_BAI]);
                    continue;
                }

                $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::DANG_XU_LY]);
                if (in_array($pay->status, [Pay::DA_THANH_TOAN, Pay::DANG_XU_LY])) {
                    $note['error_code'] = '2000';
                    $note['error_description'] = 'Payment has been paid or process';
                    $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_TU_DONG_THAT_BAI]);
                    continue;
                }

                //thanh toan qua vimo
                if ($investor->type_interest_receiving_account == Investor::TYPE_PAYMENT_VIMO) {
                    $note['error_code'] = '2006';
                    $note['error_description'] = 'Payment method not found';
                    $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_TU_DONG_THAT_BAI]);
                    continue;


//                    if ($investor->token_id_vimo === '') {
//                        $note['error_code'] = '2002';
//                        $note['error_description'] = 'Wallet link not found';
//                        $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
//                        $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_TU_DONG_THAT_BAI]);
//                        continue;
//                    }
//                    $code = "TN_" . time() . '_' . uniqid();
//                    $param = [
//                        'order_code' => $code,
//                        'amount' => round($pay->goc_lai_1ky),
//                        'mobile' => $investor->phone_vimo,
//                        'description' => "TienNgay.vn thanh toán NĐT " . $investor->name
//                    ];
//                    //type = 1 chuyen tien tu merchant sang vi vimo
//                    $type = 1;
//                    $result = $this->vimo->createWithdrawal($param, $type);
//                    $param['pay'] = $pay;
//                    if ($result['error_code'] == '00') {
//                        $this->log_pay_service->create_log_auto($param, $result, $pay->id, 'pay');
//                        $this->transaction_service->create_paypal_auto($param, $pay, $result);
//                        $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::DA_THANH_TOAN]);
//                        $user = $pay->contract->investor->user;
//                        $noti = [
//                            'note' => $param['description'],
//                            'created_by' => 'automatic system'
//                        ];
//                        $this->notificationService->push_notification_paypal_investor_auto($noti, $user, $pay);
//                        continue;
//                    } else {
//                        $this->log_pay_service->create_log_auto($param, $result, $pay->id, 'pay_fail');
//                        $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_TU_DONG_THAT_BAI]);
//                        continue;
//                    }
                    // thanh toan bank qua ngan luong
                } elseif ($investor->type_interest_receiving_account == Investor::TYPE_PAYMENT_BANK) {
                    if (empty($investor->interest_receiving_account)) {
                        $note['error_code'] = '2004';
                        $note['error_description'] = 'No bank account yet';
                        $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                        $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_TU_DONG_THAT_BAI]);
                        continue;
                    }

                    if (empty($investor->name_bank_account)) {
                        $note['error_code'] = '2005';
                        $note['error_description'] = 'No name bank account yet';
                        $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                        $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_TU_DONG_THAT_BAI]);
                        continue;
                    }

                    if ($investor->type_card == Investor::THE_ATM) {
                        $account_type = 2;
                    } else {
                        $account_type = 3;
                    }

                    $ref_code = 'TN' . date('Ymd') . '_' . uniqid();
                    $data = [
                        'account_type' => $account_type,
                        'card_fullname' => $investor->name_bank_account,
                        'card_number' => $investor->interest_receiving_account,
                        'bank_code' => $investor->bank_name,
                        'ref_code' => $ref_code,
                        'total_amount' => round($pay->goc_lai_1ky),
                        'card_month' => '',
                        'card_year' => '',
                        'branch_name' => '',
                        'reason' => 'TienNgay thanh toán NĐT ' . $investor->name
                    ];

                    try {
                        $result = $this->nganLuongPayOut->SetCashoutRequest($data);
                        $this->logNlService->create_payout($data, $result, 'payment', $ref_code);
                        if ($result->error_code == '00') {
                            if ($result->transaction_status == '00') {
                                $result->error_description = "Thành công";
                                $this->log_pay_service->create_log_auto($data, $result, $pay->id, 'pay');
                                $this->transaction_service->create_paypal_nl_auto($data, $pay, $result);
                                $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::DA_THANH_TOAN]);
                                $user = $pay->contract->investor->user;
                                $noti = [
                                    'note' => 'TienNgay thanh toán NĐT ' . $investor->name,
                                    'created_by' => 'automatic system'
                                ];
                                $this->notificationService->push_notification_paypal_investor_auto($noti, $user, $pay);
                                continue;
                            } else {
                                if ($result->transaction_status == '01') {
                                    $result->error_description = 'Chờ ngân lượng xử lý';
                                    $status = Pay::CHO_NGAN_LUONG_XU_LY;
                                } elseif ($result->transaction_status == '02') {
                                    $result->error_description = 'Giao dịch không thành công';
                                    $status = Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI;
                                } elseif ($result->transaction_status == '03') {
                                    $result->error_description = 'Giao dịch đã hoàn trả';
                                    $status = Pay::NGAN_LUONG_DA_HOAN_TRA;
                                }
                                $this->log_pay_service->create_log_auto($data, $result, $pay->id, 'pay_fail');
                                $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => $status]);
                                continue;
                            }
                        } else {
                            $result->error_description = isset($result->error_message) ? $result->error_message : "Thanh toán ngân lượng không thành công";
                            $this->log_pay_service->create_log_auto($data, $result, $pay->id, 'pay_fail');
                            $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI]);
                            continue;
                        }
                    } catch (\Exception $exception) {
                        $note['error_description'] = $exception->getMessage();
                        $this->log_pay_service->create_log_auto($pay, $note, $pay->id, 'pay_fail');
                        $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI]);
                        continue;
                    }
                }
            }
        }
    }
}
