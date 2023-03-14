<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Investor;
use App\Models\LogPay;
use App\Models\Pay;
use App\Models\Transaction;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LogPayRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\LogNlService;
use App\Service\LogPayService;
use App\Service\LogsService;
use App\Service\NganLuongPayOut;
use App\Service\NotificationService;
use App\Service\PayService;
use App\Service\TransactionService;
use App\Service\Vimo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        ContractRepositoryInterface $contract,
        InvestorRepositoryInterface $interest,
        PayRepositoryInterface $pay,
        PayService $payService,
        TransactionRepositoryInterface $transaction,
        NotificationService $notificationService,
        LogPayRepositoryInterface $log_pay,
        LogPayService $log_pay_service,
        TransactionService $transactionService,
        Vimo $vimo,
        NganLuongPayOut $nganLuongPayOut,
        LogNlService $logNlService,
        LogsService $logsService
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->contract_model = $contract;
        $this->interest_model = $interest;
        $this->pay_model = $pay;
        $this->payService = $payService;
        $this->transaction_model = $transaction;
        $this->notificationService = $notificationService;
        $this->log_pay_model = $log_pay;
        $this->log_pay_service = $log_pay_service;
        $this->transaction_service = $transactionService;
        $this->vimo = $vimo;
        $this->nganLuongPayOut = $nganLuongPayOut;
        $this->logNlService = $logNlService;
        $this->logsService = $logsService;

    }

    public function create_pay_interest(Request $request)
    {
        $this->payService->create($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function get_all_pay_paginate(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'code_contract', 'investor_code', 'type', 'full_name');
        $overView = $this->payService->overView($condition);
        $pays = $this->pay_model->get_all_pay_paginate($condition);
        foreach ($pays as $pay) {
            $pay->contract = $pay->contract()->with('investor')->first();
            if ($pay->contract->type_contract == Contract::HOP_DONG_UY_QUYEN) {
                if (date('Y-m-d', $pay->interest_period) == date('Y-m-d', $pay->contract->due_date)) {
                    $pay->ky_cuoi = true;
                } else {
                    $pay->ky_cuoi = false;
                }
            }
            $pay->so_ky_thanh_toan = $this->pay_model->count([Pay::COLUMN_CONTRACT_ID => $pay->contract->id, Pay::COLUMN_STATUS => Pay::CHUA_THANH_TOAN]);
            $pay->transaction = $pay->transaction()->first();
            if (in_array($pay->status, [
                Pay::CHO_NGAN_LUONG_XU_LY,
                Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI,
                Pay::NGAN_LUONG_DA_HOAN_TRA,
                Pay::THANH_TOAN_TU_DONG_THAT_BAI
            ])) {
                $pay->log = $this->log_pay_model->findOneDesc([LogPay::COLUMN_PAY_ID => $pay->id, LogPay::COLUMN_TYPE => 'pay_fail']);
            }

        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success",
            'data' => $pays,
            'overview' => $overView
        ]);
    }

    public function detail_paypal(Request $request)
    {
        $pay = $this->pay_model->find($request->id);
        $pay->contract = $pay->contract()->with('investor', 'pays')->first();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success",
            'data' => $pay,
        ]);
    }

    public function paypal_investor(Request $request, Vimo $vimo)
    {
        $pay = $this->pay_model->find($request->id);
        $this->pay_model->update($request->id, [Pay::COLUMN_STATUS => Pay::DANG_XU_LY]);
        if (in_array($pay->status, [Pay::DA_THANH_TOAN, Pay::DANG_XU_LY])) {
            $note['error_code'] = '2000';
            $note['error_description'] = 'Payment has been paid or process';
            $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Kì hiên tại đã thanh toán hoặc đang xử lý",
            ]);
        }

        $contract = $this->contract_model->find($pay->contract_id);
        if (!$contract) {
            $note['error_code'] = '3001';
            $note['error_description'] = 'Contract does not exist';
            $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Contract does not exist",
            ]);
        }
        if ($contract['status_contract'] != Contract::EFFECT) {
            $note['error_code'] = '3000';
            $note['error_description'] = 'Contract expire';
            $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Contract expire",
            ]);
        }

        if ($contract['status'] != Contract::SUCCESS) {
            $note['error_code'] = '3002';
            $note['error_description'] = 'Contract block or pending';
            $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Contract block or pending",
            ]);
        }
        $investor = $this->investor_model->findOne([Investor::COLUMN_ID => $contract['investor_id'], 'status' => 'active']);
        if (empty($investor)) {
            $note['error_code'] = '2001';
            $note['error_description'] = 'Investor is not activated or locked';
            $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Nhà đầu tư chưa được kích hoạt",
            ]);
        }

        if ($pay->status == Pay::CHO_NGAN_LUONG_XU_LY) {
            $note['error_code'] = '2006';
            $note['error_description'] = 'Transaction pending';
            $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Giao dịch đang chờ Ngân lượng xử lý",
            ]);
        }

        if (empty($investor->type_interest_receiving_account)) {
            $note['error_code'] = '2003';
            $note['error_description'] = 'The form of receiving interest has not been updated yet';
            $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Nhà đầu tư chưa cập nhật hình thức nhận lãi",
            ]);
        } else {
            if ($investor->type_interest_receiving_account == Investor::TYPE_PAYMENT_VIMO) {
                $note['error_code'] = '2006';
                $note['error_description'] = 'Payment method not found';
                $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    'message' => "Thanh toán không khả dụng",
                ]);
//                if ($investor->token_id_vimo === '') {
//                    $note['error_code'] = '2002';
//                    $note['error_description'] = 'Wallet link not found';
//                    $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
//                    return response()->json([
//                        'status' => Controller::HTTP_BAD_REQUEST,
//                        'message' => "Nhà đầu tư chưa có liên kết ví VIMO",
//                    ]);
//                }
//                $code = "TIENNGAY_" . date('Ymd') . '_' . uniqid();
//                $param = [
//                    'order_code' => $code,
//                    'amount' => round($pay->goc_lai_1ky),
//                    'mobile' => $investor->phone_vimo,
//                    'description' => !empty($request->note) ? $request->note : 'TienNgay thanh toán NĐT ' . $investor->name
//                ];
//
//                //type = 1 chuyen tien tu merchant sang vi vimo
//                $type = 1;
//                $result = $vimo->web_createWithdrawal($param, $type);
//                if ($result['error_code'] == '00') {
//                    $this->log_pay_service->create($request, $param, $result, 'pay');
//                    $this->transaction_service->create_paypal($request, $pay, $result);
//                    $this->pay_model->update($request->id, [Pay::COLUMN_STATUS => Pay::DA_THANH_TOAN]);
//                    $user = $pay->contract->investor->user;
//                    $this->notificationService->push_notification_paypal_investor($request, $user, $pay);
//                    return response()->json([
//                        'status' => Controller::HTTP_OK,
//                        'message' => "Thanh toán thành công",
//                    ]);
//                } else {
//                    $this->log_pay_service->create($request, $param, $result, 'pay_fail');
//                    return response()->json([
//                        'status' => Controller::HTTP_BAD_REQUEST,
//                        'message' => isset($result['error_description']) ? $result['error_description'] : "Thanh toán không thành công",
//                    ]);
//                }
            } elseif ($investor->type_interest_receiving_account == Investor::TYPE_PAYMENT_BANK) {
                if (empty($investor->interest_receiving_account)) {
                    $note['error_code'] = '2004';
                    $note['error_description'] = 'No bank account yet';
                    $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        'message' => "Nhà đầu tư chưa cập nhật tài khoản ngân hàng nhận lãi",
                    ]);
                }

                if (empty($investor->name_bank_account)) {
                    $note['error_code'] = '2005';
                    $note['error_description'] = 'No name bank account yet';
                    $this->log_pay_service->create($request, $pay, $note, 'pay_fail');
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        'message' => "Nhà đầu tư chưa cập nhật tên tài khoản ngân hàng nhận lãi",
                    ]);
                }

                if ($investor->type_card == Investor::THE_ATM) {
                    $account_type = 2;
                } else {
                    $account_type = 3;
                }
                $ref_code = 'TIENNGAY' . date('Ymd') . '_' . uniqid();
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
                    'reason' => !empty($request->note) ? $request->note : 'TienNgay thanh toán NĐT ' . $investor->name
                ];
                try {
                    $result = $this->nganLuongPayOut->web_SetCashoutRequest($data);
                    $this->logNlService->create_payout($data, $result, 'payment', $ref_code);
                    if ($result->error_code == '00') {
                        if ($result->transaction_status == '00') {
                            $result->error_description = "Thành công";
                            $this->log_pay_service->create($request, $data, $result, 'pay');
                            $this->transaction_service->create_paypal_nl($request, $pay, $result);
                            $this->pay_model->update($request->id, [Pay::COLUMN_STATUS => Pay::DA_THANH_TOAN]);
                            $user = $pay->contract->investor->user;
                            $this->notificationService->push_notification_paypal_investor($request, $user, $pay);
                            return response()->json([
                                'status' => Controller::HTTP_OK,
                                'message' => "Thanh toán thành công",
                            ]);
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
                            $this->log_pay_service->create($request, $data, $result, 'pay_fail');
                            $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => $status]);
                            return response()->json([
                                'status' => Controller::HTTP_BAD_REQUEST,
                                'message' => $result->error_description,
                            ]);
                        }
                    } else {
                        $result->error_description = isset($result->error_message) ? $result->error_message : "Thanh toán ngân lượng không thành công";
                        $this->log_pay_service->create($request, $data, $result, 'pay_fail');
                        $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI]);
                        return response()->json([
                            'status' => Controller::HTTP_BAD_REQUEST,
                            'message' => $result->error_description,
                        ]);
                    }
                } catch (\Exception $exception) {
                    $result = $exception->getMessage();
                    $this->log_pay_service->create($request, $data, $result, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI]);
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        'message' => $exception->getMessage(),
                    ]);
                }

            }
        }
    }

    public function gach_no_ndt_uy_quyen(Request $request)
    {
        $contract = $this->contract_model->findCode($request->code_contract);
        if (!$contract) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Hợp đồng không tồn tại",
            ]);
        }
        $this->payService->gach_no_ndt_uy_quyen($contract);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "success",
        ]);
    }

    public function lay_ki_tra_theo_ngay(Request $request)
    {
        $pays = $this->pay_model->lay_ki_tra_theo_ngay($request->date);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "success",
            'data' => $pays
        ]);
    }

    public function cap_nhat_ki_thanh_toan_ndt_uq(Request $request)
    {
        if (empty($request->date_pay)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Ngày thanh toán không để trống",
            ]);
        } else {
            $pay = $this->pay_model->find($request->id);
            if (!$pay) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    'message' => "Kỳ thanh toán không tồn tại",
                ]);
            } else {
                if ($pay['status'] != Pay::CHUA_THANH_TOAN) {
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        'message' => "Kỳ thanh toán đã thanh toán hoặc đang trong quá trinh xử lý",
                    ]);
                }
            }
            DB::beginTransaction();
            try {
                $contract = $pay->contract()->first();
                $this->log_pay_model->create(
                    [
                        LogPay::COLUMN_TYPE => 'pay_uq',
                        LogPay::COLUMN_REQUEST => json_encode($pay),
                        LogPay::COLUMN_PAY_ID => $request->id,
                        LogPay::COLUMN_CREATED_BY => current_user()->email,
                    ]
                );
                $transaction = $this->transaction_service->transaction_pay_ndt_uy_quyen($contract, $pay, $request->date_pay);
                $chua_thanh_toan = $contract->pays()->whereNotIn(Pay::COLUMN_STATUS, [Pay::DA_THANH_TOAN])->count();
                if ($chua_thanh_toan == 0) {
                    $this->contract_model->update($contract['id'], [
                        Contract::COLUMN_STATUS_CONTRACT => Contract::EXPIRE,
                        Contract::COLUMN_DATE_EXPIRE => ($contract['number_day_loan'] / 30) == $pay['ky_tra'] ? $contract['dua_date'] : $request->date_pay
                    ]);
                }
                DB::commit();
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => "success",
                ]);
            } catch (\Exception $exception) {
                $this->logsService->create($request, $exception, 'PayController/cap_nhat_ki_thanh_toan_ndt_uq');
                DB::rollBack();
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => "fail",
                ]);
            }
        }
    }

    public function get_all_pay_app(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'code_contract', 'investor_code', 'type');
        $pays = $this->pay_model->get_all_pay_app($condition);
        foreach ($pays as $pay) {
            $pay->contract = $pay->contract;
            $pay->transaction = $pay->transaction;
            $pay->investor = $pay->contract->investor;
            if ($pay->status == Pay::THANH_TOAN_TU_DONG_THAT_BAI) {
                $pay->log = $this->log_pay_model->findOneDesc([LogPay::COLUMN_PAY_ID => $pay->id, LogPay::COLUMN_TYPE => 'pay_fail']);
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success",
            'data' => $pays,
        ]);
    }

    public function check_transaction_nl(Request $request)
    {
        $pay = $this->pay_model->find($request->id);
        $logNew = $this->log_pay_model->findOneDesc([LogPay::COLUMN_PAY_ID => $request->id, LogPay::COLUMN_TYPE => 'pay_fail']);
        if (!$logNew) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => 'Thao tác không hợp lệ'
            ]);
        }
        $ref_code = data_get(json_decode($logNew->response), 'ref_code');
        $transaction_id = data_get(json_decode($logNew->response), 'transaction_id');
        try {
            $result = $this->nganLuongPayOut->web_CheckCashout($ref_code, $transaction_id);
            $this->logNlService->create_payout($pay, $result, 'check_payment', $ref_code);
            if ($result->error_code == '00') {
                if ($result->transaction_status == '00') {
                    $result->error_description = "Thành công";
                    $this->log_pay_service->create($request, $pay, $result, 'pay');
                    $this->transaction_service->create_paypal_nl($request, $pay, $result);
                    $this->pay_model->update($request->id, [Pay::COLUMN_STATUS => Pay::DA_THANH_TOAN]);
                    $user = $pay->contract->investor->user;
//                    $this->notificationService->push_notification_paypal_investor_replay($request, $user, $pay);
                    return response()->json([
                        'status' => Controller::HTTP_OK,
                        'message' => $result->error_description,
                    ]);
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
                    $this->log_pay_service->create($request, $pay, $result, 'pay_fail');
                    $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => $status]);
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        'message' => $result->error_description,
                    ]);
                }
            } else {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    'message' => 'Thao tác không thành công'
                ]);
            }
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
            $this->log_pay_service->create($request, $data, $result, 'pay_fail');
            $this->pay_model->update($pay->id, [Pay::COLUMN_STATUS => Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI]);
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function get_all_pay_app_v2(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'code_contract', 'investor_code', 'type', 'excel', 'full_name', 'status');
        $overView = [];
        if (empty($condition['excel'])) {
            $overView = $this->payService->overView($condition);
        }
        $pays = $this->pay_model->get_all_pay_app_v2($condition);
        if (empty($condition['excel'])) {
            foreach ($pays as $pay) {
                $pay->so_ky_thanh_toan = $this->pay_model->count([Pay::COLUMN_CONTRACT_ID => $pay->contract_id, Pay::COLUMN_STATUS => Pay::CHUA_THANH_TOAN]);
                if (in_array($pay->status, [
                    Pay::CHO_NGAN_LUONG_XU_LY,
                    Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI,
                    Pay::NGAN_LUONG_DA_HOAN_TRA,
                    Pay::THANH_TOAN_TU_DONG_THAT_BAI
                ])) {
                    $pay->log = $this->log_pay_model->findOneDesc([LogPay::COLUMN_PAY_ID => $pay->id, LogPay::COLUMN_TYPE => 'pay_fail']);
                }
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success",
            'data' => $pays,
            'overview' => $overView
        ]);
    }
}
