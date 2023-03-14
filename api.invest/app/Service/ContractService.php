<?php


namespace App\Service;


use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\DraftNl;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\LogNL;
use App\Models\LogPay;
use App\Models\Lottery;
use App\Models\Pay;
use App\Models\Transaction;
use App\Models\User;
use App\Repository\ContractRepositoryInterface;
use App\Repository\DraftNlRepository;
use App\Repository\DraftNlRepositoryInterface;
use App\Repository\InvestmentRepositoryInterface;
use App\Repository\InvestorRepository;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LogNlRepository;
use App\Repository\LogNlRepositoryInterface;
use App\Repository\LogPayRepository;
use App\Repository\LogsRepository;
use App\Repository\LotteryRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepository;
use App\Repository\TransactionRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContractService extends BaseService
{
    protected $contractRepository;
    protected $investorRepository;
    protected $payReposiroty;
    protected $investmentReposiroty;
    protected $nlPayIn;
    protected $logNlRepository;
    protected $draftRepository;
    protected $logNlService;
    protected $transactionService;
    protected $payService;
    protected $notificationService;
    protected $transactionReposiroty;
    protected $logPayReposiroty;
    protected $nlCheckoutV3;
    protected $lotteryRepository;
    protected $logsService;

    public function __construct(ContractRepositoryInterface $contractRepository,
                                InvestorRepositoryInterface $investorRepository,
                                InterestService $interestService,
                                PayRepositoryInterface $payRepository,
                                InvestmentRepositoryInterface $investmentReposiroty,
                                NganLuongPayIn $nlPayIn,
                                LogNlRepository $logNlRepository,
                                DraftNlRepositoryInterface $draftNlRepository,
                                LogNlService $logNlService,
                                TransactionService $transactionService,
                                PayService $payService,
                                NotificationService $notificationService,
                                TransactionRepositoryInterface $transactionRepository,
                                LogPayRepository $logPayReposiroty,
                                NL_Checkoutv3 $nlCheckoutV3,
                                LotteryRepositoryInterface $lotteryRepository,
                                LogsService $logsService)
    {
        $this->contractRepository = $contractRepository;
        $this->investorRepository = $investorRepository;
        $this->interestService = $interestService;
        $this->payRepository = $payRepository;
        $this->investmentReposiroty = $investmentReposiroty;
        $this->nlPayIn = $nlPayIn;
        $this->logNlRepository = $logNlRepository;
        $this->draftRepository = $draftNlRepository;
        $this->logNlService = $logNlService;
        $this->transactionService = $transactionService;
        $this->payService = $payService;
        $this->notificationService = $notificationService;
        $this->transactionRepository = $transactionRepository;
        $this->logPayReposiroty = $logPayReposiroty;
        $this->nlCheckoutV3 = $nlCheckoutV3;
        $this->lotteryRepository = $lotteryRepository;
        $this->logsService = $logsService;
    }

    public function create_contract($request)
    {
        $data = [
            Contract::COLUMN_INVESTOR_ID => $request->id,
            Contract::COLUMN_CODE_CONTRACT => $request->code_contract,
            Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT => $request->code_contract_disbursement,
            Contract::COLUMN_TYPE_LOAN => $request->type_loan,
            Contract::COLUMN_TYPE_PROPERTY => $request->type_property,
            Contract::COLUMN_NAME_PROPERTY => $request->name_property,
            Contract::COLUMN_INVESTOR_CODE => $request->investor_code,
            Contract::COLUMN_INVESTMENT_AMOUNT => $request->investment_amount,
            Contract::COLUMN_AMOUNT_MONEY => $request->amount_money,
            Contract::COLUMN_AMOUNT_LOAN => $request->amount_loan,
            Contract::COLUMN_NUMBER_DAY_LOAN => $request->number_day_loan,
            Contract::COLUMN_INTEREST => $request->interest,
            Contract::COLUMN_TYPE_INTEREST => $request->type_interest,
            Contract::COLUMN_CREATED_BY => $request->created_by,
            Contract::COLUMN_INTEREST_ID => $request->interest_id,
            Contract::COLUMN_CONTRACT_INTEREST_ID => $request->contract_interest_id,
            Contract::COLUMN_TYPE_CONTRACT => Contract::HOP_DONG_DAU_TU_APP,
            Contract::COLUMN_STATUS => Contract::SUCCESS,
            Contract::COLUMN_STATUS_CONTRACT => Contract::EFFECT
        ];
        if (!empty($request->created_at)) {
            $data[Contract::COLUMN_CREATED_AT] = $request->created_at;
        }
        $contract = $this->contractRepository->create($data);
        return $contract;
    }

    public function validate_contract_ndt_uy_quyen($request)
    {
        $validate = Validator::make($request->all(), [
            Contract::COLUMN_CODE_CONTRACT => 'required|unique:contract',
            Contract::COLUMN_AMOUNT_MONEY => 'required',
            Contract::COLUMN_NUMBER_DAY_LOAN => 'required',
            Contract::COLUMN_INTEREST => 'required',
            Investor::COLUMN_CODE => 'required',
            Contract::COLUMN_TYPE_INTEREST => 'required',
            Contract::COLUMN_CREATED_AT => 'required|date',
            'date_interest' => 'required',
        ]);
        return $validate;
    }

    public function create_contract_ndt_uy_quyen($request, $investor)
    {
        $interest = $request->interest / 12;
        $data = [
            Contract::COLUMN_INVESTOR_ID => $investor->id,
            Contract::COLUMN_CODE_CONTRACT => $request->code_contract,
            Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT => $request->code_contract,
            Contract::COLUMN_INVESTOR_CODE => $investor->code,
            Contract::COLUMN_INVESTMENT_AMOUNT => $request->amount_money,
            Contract::COLUMN_AMOUNT_MONEY => $request->amount_money,
            Contract::COLUMN_AMOUNT_LOAN => $request->amount_money,
            Contract::COLUMN_NUMBER_DAY_LOAN => $request->number_day_loan,
            Contract::COLUMN_INTEREST => json_encode(['interest' => $interest, 'interest_year' => $request->interest]),
            Contract::COLUMN_TYPE_INTEREST => $request->type_interest,
            Contract::COLUMN_CREATED_BY => current_user()->email,
            Contract::COLUMN_CREATED_AT => $request->created_at,
            Contract::COLUMN_TYPE_CONTRACT => Contract::HOP_DONG_UY_QUYEN,
            Contract::COLUMN_PAYMENT_METHOD => !empty($request->payment_method) ? $request->payment_method : Contract::PAYMENT_METHOD_HANDMADE,
            Contract::COLUMN_STATUS => Contract::SUCCESS,
            Contract::COLUMN_STATUS_CONTRACT => Contract::EFFECT,
            Contract::COLUMN_INVESTMENT_CYCLE => $request->investment_cycle ?? null,
            Contract::COLUMN_INTEREST_CYCLE => $request->date_interest ?? null,
            Contract::COLUMN_MONTHLY_INTEREST_PAYMENT_DATE => $request->date_pay ?? null,
            Contract::COLUMN_TYPE_EXTEND => $request->type_extend ?? null,
            Contract::COLUMN_PARENT_ID => $request->parent_id ?? null
        ];
        $contract = $this->contractRepository->create($data);
        return $contract;
    }

    public function validate_phu_luc_ndt_uy_quyen($request)
    {
        $validate = Validator::make($request->all(), [
            'code_contract' => 'required|unique:contract',
            'amount_money' => 'required',
            'number_day_loan' => 'required',
            'interest' => 'required',
            'type_interest' => 'required',
            'created_at' => 'required|date',
            'id' => 'required',
        ], [
            'code_contract.required' => 'Mã phụ lục không để trống',
            'code_contract.unique' => 'Mã phụ lục đã tồn tại',
            'amount_money.required' => 'Số tiền đầu tư không để trống',
            'number_day_loan.required' => 'Thời gian đầu tư không để trống',
            'interest.required' => 'Lãi suất không để trống',
            'type_interest.required' => 'Hình thức trả lãi không để trống',
            'created_at.required' => 'Ngày đầu tư không để trống',
            'id.required' => 'Không tìm thấy nhà đầu tư',
        ]);
        return $validate;
    }

    public function check_invest($investor, $investment, $request)
    {
        $message = [];
        if ($investor->status != Investor::STATUS_ACTIVE) {
            $message[] = 'Tài khoản của bạn đang trong quá trình xác nhận. Liên hệ 19006907 để được hỗ trợ sớm nhất. Xin cảm ơn!';
        }
//        if (empty($investor->type_interest_receiving_account)) {
//            $message[] = 'Để được hỗ trợ tốt nhất, bạn vui lòng chọn hình thức nhận lãi trước khi đầu tư';
//        }
        if ($investor->token_id_vimo == "") {
            $message[] = 'Bạn chưa liên kết ví vimo!';
        }
        if ($investment->status == Investment::STATUS_BLOCK) {
            $message[] = 'Hợp đồng đã có đầu tư';
        }
        if (!empty($investment->investor_confirm)) {
            if ($investment->investor_confirm == $investor->code) {
                $message[] = 'Bạn đã đầu tư Gói đầu tư này';
            } else {
                $message[] = 'Gói đầu tư đã được đầu tư bởi nhà đầu tư khác';
            }
        }
        if (time() < strtotime($investment->time_otp_investment)) {
            if ($request->id != $investment->investor_create_otp) {
                $message[] = 'Gói đầu tư đang được đầu tư bởi nhà đầu tư khác';
            }
        }

        return $message;
    }

    public function check_invest_momo($investor, $investment, $request)
    {
        $message = [];
        if ($investor->status != Investor::STATUS_ACTIVE) {
            $message[] = 'Tài khoản của bạn đang trong quá trình xác nhận. Liên hệ 19006907 để được hỗ trợ sớm nhất. Xin cảm ơn!';
        }
        if ($investment->status == Investment::STATUS_BLOCK) {
            $message[] = 'Hợp đồng đã có đầu tư';
        }
        if (!empty($investment->investor_confirm)) {
            if ($investment->investor_confirm == $investor->code) {
                $message[] = 'Bạn đã đầu tư Gói đầu tư này';
            } else {
                $message[] = 'Gói đầu tư đã được đầu tư bởi nhà đầu tư khác';
            }
        }
        if (time() < strtotime($investment->time_otp_invest)) {
            if ($request->id != $investment->investor_create_otp) {
                $message[] = 'Gói đầu tư đang được đầu tư bởi nhà đầu tư khác';
            }
        }
        return $message;
    }

    public function app_create_contract_v2($investment, $investor, $request)
    {
        $request->period = (int)$investment->number_day_loan / 30;
        $interest = $this->interestService->get_interest_for_investment($investment);
        $data = [
            Contract::COLUMN_INVESTOR_ID => $investor->id,
            Contract::COLUMN_CODE_CONTRACT => $investment->code_contract,
            Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT => $investment->code_contract_disbursement,
            Contract::COLUMN_INVESTOR_CODE => $investor->code,
            Contract::COLUMN_INVESTMENT_AMOUNT => $investment->amount_money,
            Contract::COLUMN_AMOUNT_MONEY => $investment->amount_money,
            Contract::COLUMN_AMOUNT_LOAN => $investment->amount_money,
            Contract::COLUMN_NUMBER_DAY_LOAN => $investment->number_day_loan,
            Contract::COLUMN_INTEREST => json_encode($interest),
            Contract::COLUMN_TYPE_INTEREST => $investment->type_interest,
            Contract::COLUMN_CREATED_BY => $investor->phone_number,
            Contract::COLUMN_INTEREST_ID => $interest->id,
            Contract::COLUMN_CONTRACT_INTEREST_ID => !empty($interest->contract_interest_id) ? $interest->contract_interest_id : NULL,
            Contract::COLUMN_TYPE_CONTRACT => Contract::HOP_DONG_DAU_TU_APP,
            Contract::COLUMN_STATUS => Contract::SUCCESS,
            Contract::COLUMN_STATUS_CONTRACT => Contract::EFFECT
        ];
        if (!empty($request->created_at)) {
            $data[Contract::COLUMN_CREATED_AT] = $request->created_at;
        }
        $contract = $this->contractRepository->create($data);
        return $contract;
    }

    public function run_low_interest_contract_again($request)
    {
        $contract = $this->contractRepository->find($request->id);
        if ($contract['type_interest'] == 2) {
            $pays = $this->payRepository->findMany([Pay::COLUMN_CONTRACT_ID => $contract['id']]);
            foreach ($pays as $pay) {
                $this->payRepository->delete($pay['id']);
            }
            $month = (int)$contract['number_day_loan'] / 30;
            $interest = data_get(json_decode($contract['interest'], true), 'interest');
            $tong_lai = $contract['amount_money'] * ($interest / 100) * $month;
            $this->payRepository->create(
                [
                    Pay::COLUMN_CODE_CONTRACT => $contract['code_contract'],
                    Pay::COLUMN_INVESTOR_CODE => $contract['investor_code'],
                    Pay::COLUMN_INTEREST => $interest,
                    Pay::COLUMN_TYPE => $contract['type_interest'],
                    Pay::COLUMN_KI_TRA => 1,
                    Pay::COLUMN_NGAY_KY_TRA => strtotime(date('Y-m-d', strtotime($contract['created_at'])) . " +$month month"),
                    Pay::COLUMN_STATUS => 1,
                    Pay::COLUMN_CONTRACT_ID => $contract['id'],
                    Pay::COLUMN_CREATED_BY => current_user()->email,
                    Pay::COLUMN_TIEN_GOC_1KY => $contract['amount_money'],
                    Pay::COLUMN_TIEN_GOC_CON => 0,
                    Pay::COLUMN_LAI_KY => $tong_lai,
                    Pay::COLUMN_GOC_LAI_1KY => $contract['amount_money'] + $tong_lai,
                    Pay::COLUMN_TIEN_GOC_CON => 0,
                    Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => $contract['amount_money'],
                    Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => $tong_lai,
                ]
            );
        }

    }

    public function clear_contract_uy_quyen($request)
    {
        $investor = $this->investorRepository->findOne(['code' => $request->code]);
        if ($investor) {
            $contracts = $this->contractRepository->findMany([Contract::COLUMN_INVESTOR_ID => $investor['id'], Contract::COLUMN_TYPE_CONTRACT => Contract::HOP_DONG_UY_QUYEN]);
            if ($contracts) {
                foreach ($contracts as $contract) {
                    $transactions = $this->transactionRepository->findMany([Transaction::COLUMN_CONTRACT_ID => $contract['id']]);
                    foreach ($transactions as $transaction) {
                        $this->transactionRepository->delete($transaction['id']);
                    }
                    $pays = $this->payRepository->findMany([Pay::COLUMN_CONTRACT_ID => $contract['id']]);
                    foreach ($pays as $pay) {
                        $this->payRepository->delete($pay['id']);
                    }
                    $this->contractRepository->delete($contract['id']);
                }
            }
        }
    }

    public function check_investment_pay_nl($investor, $investment, $request)
    {
        $message = [];
        if ($investor->status != Investor::STATUS_ACTIVE) {
            $message[] = 'Tài khoản của bạn đang trong quá trình xác nhận. Liên hệ 19006907 để được hỗ trợ sớm nhất. Xin cảm ơn!';
        }

        if (empty($investor->type_interest_receiving_account)) {
            $message[] = 'Để được hỗ trợ tốt nhất, bạn vui lòng chọn hình thức nhận lãi trước khi đầu tư';
        }

        if ($investment->status == Investment::STATUS_BLOCK) {
            $message[] = 'Hợp đồng đã có đầu tư';
        }
        if (!empty($investment->investor_confirm)) {
            if ($investment->investor_confirm == $investor->code) {
                $message[] = 'Bạn đã đầu tư Gói đầu tư này';
            } else {
                $message[] = 'Gói đầu tư đã được đầu tư bởi nhà đầu tư khác';
            }
        }

        if (time() < strtotime($investment->time_otp_invest)) {
            if ($request->id != $investment->investor_create_otp) {
                $message[] = 'Gói đầu tư đang được đầu tư bởi nhà đầu tư khác';
            }
        }
        return $message;
    }

    public function pay_out_nl($bill, $investor, $investment)
    {
        $title = 'Đầu tư';
        $param = array(
            "merchant_site_code" => strval($this->nlPayIn->merchant_site_code),
            "return_url" => strval(env('SERVE_APP') . 'V2/contract/success_nl_' . $bill['client_code']),
            "receiver" => strval($this->nlPayIn->receiver),
            "transaction_info" => strval("Đầu tư"),
            "order_code" => strval($bill['order_code']),
            "price" => strval($investment['amount_money']),
            "currency" => strval("vnd"),
            "quantity" => strval(1),
            'tax' => strval(0),
            'discount' => strval(0),
            'fee_cal' => strval(0),
            'fee_shipping' => strval(0),
            'order_description' => strval($title . '-' . $investor['phone_number'] . '-' . $investment['code_contract']),
            'buyer_info' => strval($investor['name'] . "*|*" . $investor['email'] . "*|*" . $investor['phone_number']),
            "affiliate_code" => strval("")
        );

        // create link checkout
        $url = $this->nlPayIn->buildCheckoutUrlExpand($param);
        $url_cancel = strval(env('SERVE_APP') . 'V2/contract/cancel?bill=' . $bill['id']);
        $notify_url = strval(env('SERVE_URL') . 'v2/contract/success');
        $url .= '&cancel_url=' . $url_cancel . '&notify_url=' . $notify_url;

        // ghi log
        $this->logNlService->create_payin($param, $url, 'create', $bill['order_code']);
        return $url;
    }

    public function success_nl($request)
    {
        $data = [];
        $transaction_info = !empty($request->transaction_info) ? $request->transaction_info : "";
        $order_code = !empty($request->order_code) ? $request->order_code : "";
        $price = !empty($request->price) ? $request->price : "";
        $payment_id = !empty($request->payment_id) ? $request->payment_id : "";
        $payment_type = !empty($request->payment_type) ? $request->payment_type : "";
        $error_text = !empty($request->error_text) ? $request->error_text : "";
        $secure_code = !empty($request->secure_code) ? $request->secure_code : "";

        // check tính đồng nhất dữ liệu
        $check = $this->nlPayIn->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);
        $bill = $this->draftRepository->findOne([DraftNl::COLUMN_ORDER_CODE => $order_code]);

        // tạo log
        $this->logNlService->create_payin([], $check, 'check', $order_code);
        if ($check == true) {

            // gọi trạng thái giao dịch với ngân lượng
            $resNL = $this->nlPayIn->web_getTransactionDetails($order_code);
            $resNL1 = json_decode($resNL);
            $this->logNlService->create_payin([], $resNL1, 'result', $order_code);
        } else {
            $this->draftRepository->update($bill['id'], [DraftNl::COLUMN_STATUS => DraftNl::PENDING]);
            $data['message'] = 'Thất bại';
        }
        return $data;
    }

    public function success($request)
    {
        $data = $request->all();
        $order_code = !empty($request->order_code) ? $request->order_code : "";
        $this->logNlService->create_payin([], $data, 'notify', $order_code);
    }

    public function app_create_contract_nl($investment, $investor, $request)
    {
        $request->period = (int)$investment->number_day_loan / 30;
        $interest = $this->interestService->get_interest_for_investment($investment);
        $data = [
            Contract::COLUMN_INVESTOR_ID => $investor->id,
            Contract::COLUMN_CODE_CONTRACT => $investment->code_contract,
            Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT => $investment->code_contract_disbursement,
            Contract::COLUMN_INVESTOR_CODE => $investor->code,
            Contract::COLUMN_INVESTMENT_AMOUNT => $request->amount,
            Contract::COLUMN_AMOUNT_MONEY => $request->amount,
            Contract::COLUMN_AMOUNT_LOAN => $request->amount,
            Contract::COLUMN_NUMBER_DAY_LOAN => $investment->number_day_loan,
            Contract::COLUMN_INTEREST => json_encode($interest),
            Contract::COLUMN_TYPE_INTEREST => $investment->type_interest,
            Contract::COLUMN_CREATED_BY => $investor->phone_number,
            Contract::COLUMN_INTEREST_ID => $interest->id,
            Contract::COLUMN_CONTRACT_INTEREST_ID => !empty($interest->contract_interest_id) ? $interest->contract_interest_id : NULL,
            Contract::COLUMN_TYPE_CONTRACT => Contract::HOP_DONG_DAU_TU_APP,
            Contract::COLUMN_STATUS => Contract::SUCCESS,
            Contract::COLUMN_STATUS_CONTRACT => Contract::EFFECT
        ];
        if (!empty($request->created_at)) {
            $data[Contract::COLUMN_CREATED_AT] = $request->created_at;
        }
        $contract = $this->contractRepository->create($data);
        return $contract;
    }

    //check giao dich ngan luong
    public function check_transaction_nl($request)
    {
        $data = [];
        if (empty($request->id)) {
            $data['message'] = 'id trống';
        }
        $bill = $this->draftRepository->find($request->id);
        DB::beginTransaction();
        try {
            if ($bill['status'] == DraftNl::PENDING || $bill['status'] == DraftNl::SUCCESS) {
                $data['message'] = 'Giao dịch Không hợp lệ';
                $this->logNlService->cron_log($bill, $data, 'error', $bill['order_code']);
            } else {
                $time = Carbon::now()->subDays(1);
                if (strtotime($bill['created_at']) < strtotime($time)) {
                    $this->draftRepository->update($bill['id'], [DraftNl::COLUMN_STATUS => DraftNl::PENDING]);
                    $data['message'] = 'Giao dịch hết hiệu lực';
                    $this->logNlService->cron_log($bill, $data, 'error', $bill['order_code']);
                } else {
                    $investment = $this->investmentReposiroty->find($bill['investment_id']);
                    $investor = $this->investorRepository->find($bill['investor_id']);
                    $resNL = $this->nlPayIn->getTransactionDetails($bill['order_code']);
                    $resNL1 = json_decode($resNL);;
                    if ($resNL1->error_code == "00") {
                        if ($resNL1->data->transaction_status == '00') {
                            //update bill
                            $this->draftRepository->update($bill['id'], [DraftNl::COLUMN_STATUS => DraftNl::SUCCESS]);

                            //update investment
                            $this->investmentReposiroty->update($investment['id'], [Investment::COLUMN_INVESTOR_CONFIRM => $investor['code']]);

                            //create contract
                            $amount = $resNL1->data->total_amount;
                            $request->amount = $amount;
                            $contract = $this->app_create_contract_nl($investment, $investor, $request);

                            //update contract_id bill
                            $this->draftRepository->update($bill['id'], [DraftNl::COLUMN_CONTRACT_ID => $contract['id']]);

                            //create transaction
                            $transaction_id = $resNL1->data->transaction_id;
                            $this->transactionService->app_create_transaction_nl($contract, $transaction_id);

                            //create bang lãi kỳ
                            $this->payService->app_create_pay_v2($contract);

                            //push notification
                            $this->notificationService->app_push_notification_investment($contract, $investor);
                            $data['contract'] = $contract;
                            $this->logNlService->cron_log($bill, $data, 'success', $bill['order_code']);
                        } else if ($resNL1->error_code != "81") {
                            $data['message'] = $resNL1->data->transaction_status;
                        }
                    } else {
                        $data['message'] = $resNL1->error_code;
                    }
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $data['message'] = 'msg =>' . $exception->getMessage() . ', line =>' . $exception->getLine() . ', file =>' . $exception->getFile();
            $this->logNlService->cron_log($bill, $data, 'error', $bill['order_code']);
        }
        return $data;

    }

    public function get_bill($request)
    {
        $bill = $this->draftRepository->find($request->id);
        return $bill;
    }

    public function get_contract_to_check_status()
    {
        $contracts = $this->contractRepository->get_contract_to_check_status();
        foreach ($contracts as $contract) {
            $pays = $this->payRepository->get_pay_not_payment($contract['id']);
            if (count($pays) == 0) {
                $this->contractRepository->update($contract['id'], [Contract::COLUMN_STATUS_CONTRACT => Contract::EXPIRE]);
            }
        }
        return;
    }

    public function nl_check_v3($bill, $investor, $investment)
    {
        $order_code = $bill['order_code'];
        $total = $investment['amount_money'];
        $bank_code = env('BANK_CHECKOUT_V3');
        $bin_code = env('BIN_BANK_CHECKOUT_V3');
        $note = "Đầu tư-" . $investor['name'] . '-' . $investment['code_contract_disbursement'];
        $return_url = strval(env('SERVE_APP') . 'V2/contract/success_nl_' . $bill['client_code']);
        $url_cancel = strval(env('SERVE_APP') . 'V2/contract/cancel?bill=' . $bill['id']);
        $notify_url = strval(env('SERVE_URL') . 'v2/contract/success');
        $full_name = $investor['full_name'] ?? '';
        $email = $investor['email'] ?? '';
        $phone = $investor['phone'] ?? '';
        $address = $investor['address'] ?? '';
        $result = $this->nlCheckoutV3->BTO_NLCheckout($order_code, $total, $bank_code, $note, $return_url, $url_cancel, $full_name, $email, $phone, $address, $notify_url);
        $end_result = json_decode(json_encode($result), true);
        $data = [];
        if ($end_result && $end_result['error_code'] == "00") {
            $info_payment = $end_result['bank_transfer_online'];
            $this->draftRepository->update($bill['id'], [DraftNl::COLUMN_BANK_TRANSFER_ONLINE => json_encode($info_payment), DraftNl::COLUMN_TOKEN_BANK_TRANSFER_NL => $end_result['token'], DraftNl::COLUMN_BANK_CODE_NL => $bank_code]);
            $data['bill'] = [
                'name_bank' => $info_payment['bank_name'],
                'name_account' => $info_payment['account_name'],
                'account' => $info_payment['account_number'],
                'money' => number_format_vn($info_payment['amount']) . ' VND',
                'description' => $info_payment['content'],
                'bank_code' => $bank_code == "MB" ? "MSB" : $bank_code,
                'bin' => $bin_code,
                'id' => $bill['id']
            ];
        } else {
            $data['message'] = !empty($end_result['description']) ? $end_result['description'] : 'Tạo giao dịch không thành công';

        }
        $this->logNlService->create_payin($bill, $data, 'create', $bill['order_code']);
        return $data;
    }

    public function clear_contract_uq()
    {
        DB::beginTransaction();
        try {
            $contracts = $this->contractRepository->findMany([Contract::COLUMN_TYPE_CONTRACT => Contract::HOP_DONG_UY_QUYEN]);
            foreach ($contracts as $contract) {
                if ($contract['type_contract'] == Contract::HOP_DONG_UY_QUYEN) {
                    $pays = $this->payRepository->findMany([Pay::COLUMN_CONTRACT_ID => $contract['id']]);
                    foreach ($pays as $pay) {
                        $this->payRepository->delete($pay['id']);
                    }
                    $transactions = $this->transactionRepository->findMany([Pay::COLUMN_CONTRACT_ID => $contract['id']]);
                    foreach ($transactions as $transaction) {
                        $this->transactionRepository->delete($transaction['id']);
                    }
                    $this->contractRepository->delete($contract['id']);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->logsService->create([], $exception, 'ContractService/clear_contract_uq');
        }
        return;
    }

    public function validate_payment_many($request)
    {
        $validate = Validator::make($request->all(), [
            'contract_id' => 'required'
        ], [
            "contract_id.required" => "Hợp đồng cần thanh toán đang trống",
        ]);

        return $validate;
    }

    public function payment_many($request)
    {
        DB::beginTransaction();
        try {
            $contract_id = $request->contract_id;
            foreach ($contract_id as $id) {
                $contract = $this->contractRepository->find($id);
                if ($contract) {
                    if ($contract['type_interest'] == Contract::GOC_LAI_CUOI_KY) continue;
                    if ($contract['type_contract'] == Contract::HOP_DONG_UY_QUYEN && $contract['status_contract'] == Contract::EFFECT) {
                        $pays = $contract->pays()
                            ->whereNotIn(Pay::COLUMN_STATUS, [Pay::DA_THANH_TOAN])
                            ->where(Pay::COLUMN_NGAY_KY_TRA, '<', strtotime(date('Y-m-d', $contract['due_date'])))
                            ->get();
                        if ($pays) {
                            foreach ($pays as $key => $pay) {
                                if (($contract['number_day_loan'] / 30) == $pay['ky_tra']) continue;
                                $this->logNlRepository->create(
                                    [
                                        LogPay::COLUMN_TYPE => 'pay_uq',
                                        LogPay::COLUMN_REQUEST => json_encode($pay),
                                        LogPay::COLUMN_PAY_ID => $pay['id'],
                                        LogPay::COLUMN_CREATED_BY => current_user()->email,
                                    ]
                                );
                                $transaction = $this->transactionService->transaction_pay_ndt_uy_quyen($contract, $pay, time());
                                $chua_thanh_toan = $contract->pays()->whereNotIn(Pay::COLUMN_STATUS, [Pay::DA_THANH_TOAN])->count();
                                if ($chua_thanh_toan == 0) {
                                    $this->contractRepository->update($contract['id'], [
                                        Contract::COLUMN_STATUS_CONTRACT => Contract:: EXPIRE,
                                        Contract::COLUMN_DATE_EXPIRE => $contract['due_date']
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->logsService->create($request, $exception, 'ContractService/payment_many');
        }
        return;
    }

    public function sumPayNdtHopTac($startDay, $endDay, $status)
    {

        $sumPayNdtHopTac = DB::table('contract')
            ->join('pay', 'contract.id', 'pay.contract_id')
            ->where('contract.type_contract', '=', "$status")
            ->whereBetween('pay.ngay_ky_tra', [$startDay, $endDay])
            ->sum('pay.goc_lai_1ky');

        return $sumPayNdtHopTac;
    }

    public function sumPayNdt($startDay, $endDay, $status)
    {

        $sumPayNdtNL = DB::table('contract')
            ->join('pay', 'contract.id', 'pay.contract_id')
            ->join('investor', 'pay.investor_code', 'investor.code')
            ->whereBetween('pay.ngay_ky_tra', [$startDay, $endDay])
            ->where('contract.type_contract', '=', "APP")
            ->where('investor.type_interest_receiving_account', '=', "$status")
            ->sum('pay.goc_lai_1ky');

        return $sumPayNdtNL;
    }

    public function get_contract_by_promotions()
    {
        $date = date('Y-m');
        $start_date = '2022-10-12 00:00:00';
        if ($date == '2022-10') {
            $end_date = '2022-10-30 00:00:00';
        } elseif ($date == '2022-11') {
            $end_date = '2022-11-30 23:59:59';
        } elseif ($date == '2022-12') {
            $end_date = '2022-12-31 23:59:59';
        } else {
            $end_date = '';
        }
        $data = $this->contractRepository->get_contract_by_promotions($start_date, $end_date);
        $i = 0;
        if ($data) {
            foreach ($data as $key => $datum) {
                $total_invest = (int)$datum->total_invest;
                if ($total_invest >= 50000000) {
                    $quantity = floor($total_invest / 50000000);
                    $total_lottery = $this->lotteryRepository->count([Lottery::COLUMN_INVESTOR_ID => $datum->investor_id]);
                    if ($quantity > $total_lottery) {
                        for ($i = $total_lottery + 1; $i <= $quantity; $i++) {
                            $number = $this->get_number(0);
                            $program = 'ĐẦU TƯ TIỆN NGAY - RINH IPHONE 14 PROMAX LIỀN TAY';
                            $this->lotteryRepository->create([
                                Lottery::COLUMN_PROGRAM => $program,
                                Lottery::COLUMN_SLUG => slugify($program),
                                Lottery::COLUMN_INVESTOR_ID => $datum->investor_id,
                                Lottery::COLUMN_NUMBER_CODE => $number,
                                Lottery::COLUMN_CODE => 'TN' . $number,
                                Lottery::COLUMN_NAME => $datum->name,
                                Lottery::COLUMN_EMAIL => $datum->email,
                                Lottery::COLUMN_PHONE => $datum->phone_number,
                                Lottery::COLUMN_IDENTITY => $datum->identity,
                                Lottery::COLUMN_TIME => $i,
                                Lottery::COLUMN_TOTAL_MONEY => $total_invest,
                                Lottery::COLUMN_START_DATE => $start_date,
                                Lottery::COLUMN_END_DATE => $end_date,
                                Lottery::COLUMN_STATUS => 'active',
                                Lottery::COLUMN_ADDRESS => !empty($datum->city) ? get_province_name_by_code($datum->city) : ''
                            ]);
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function get_number($time = 0)
    {
        $number = rand(1000, 9999);
        $lottery = $this->lotteryRepository->findOne([Lottery::COLUMN_NUMBER_CODE => $number]);
        if ($lottery) {
            if ($time > 5) {
                return;
            } else {
                return $this->get_number(++$time);
            }
        }
        return $number;
    }

    public function report_contract($request)
    {
        $contracts = $this->contractRepository->report_contract($request);
        return $contracts;
    }

    public function validate_expire_contract($request)
    {
        $validate = Validator::make($request->all(), [
            'code_contract' => 'required',
            'type_interest' => 'required',
            'number_day_loan' => 'required',
            'interest' => 'required',
            'pay_id' => 'required',
            'type_extend' => 'required',
            'created_at' => 'required'
        ], [
            'code_contract.required' => 'Mã phụ lục mới không để trống',
            'type_interest.required' => 'Hình thức không để trống',
            'number_day_loan.required' => 'Kì hạn không để trống',
            'interest.required' => 'Lãi suất không để trống',
            'pay_id.required' => 'Hợp đồng cũ không để trống',
            'type_extend.required' => 'Loại đáo hạn không để trống',
            'created_at.required' => 'Ngày đáo hạn không để trống',
        ]);

        return $validate;
    }

    public function check_expire_contract($request)
    {
        $message = [];
        $pay = $this->payRepository->find($request->pay_id);
        if (!$pay) {
            $message[] = "Không tìm thấy hợp đồng cần đáo hạn";
            return $message;
        } else {
            if ($pay['status'] != Pay::CHUA_THANH_TOAN) {
                $message[] = "Yêu cầu không hợp lệ";
                return $message;
            }

            if ($pay['ngay_ky_tra'] > $request->created_at) {
                $message[] = "Ngày gia hạn không hợp lệ ";
                return $message;
            }
        }

        $contract = $this->contractRepository->find($pay['contract_id']);
        if ($request->type_extend == Contract::REINVEST_1_PART_OF_THE_ORIGINAL) {
            if (empty($request->amount_money)) {
                $message[] = "Số tiền tái đầu tư không để trống";
            } else {
                if ($request->amount_money >= $contract['amount_money']) {
                    $message[] = "Số tiền tái đầu tư không lớn hơn hợp đồng gốc";
                }
            }
        }
        return $message;
    }

    public function expire_contract($request)
    {
        DB::beginTransaction();
        try {
            $pay = $this->payRepository->find($request->pay_id);
            $contract = $pay->contract()->first();
            //tạo giao dịch
            $transaction = $this->transactionService->transaction_pay_ndt_uy_quyen($contract, $pay, $request->created_at);
            //đáo hạn hợp đồng
            $this->contractRepository->update($contract['id'], [
                Contract::COLUMN_STATUS_CONTRACT => Contract::EXPIRE,
                Contract::COLUMN_DATE_EXPIRE => $contract['due_date']
            ]);
            $investor = $this->investorRepository->find($contract['investor_id']);
            $request->parent_id = $contract['id'];
            $request->created_at = date('Y-m-d', $request->created_at);

            if ($request->type_extend == Contract::REINVEST_1_PART_OF_THE_ORIGINAL) {
                $request->amount_money = $request->amount_money;
            } elseif ($request->type_extend == Contract::REINVEST_THE_PRINCIPAL_INTEREST) {
                $request->amount_money = $pay['goc_lai_1ky'];
            } else {
                $request->amount_money = $contract['amount_money'];
            }

            //tạo hợp đồng mới
            $contract_new = $this->create_contract_ndt_uy_quyen($request, $investor);
            //tạo giao dịch mới
            $transaction_new = $this->transactionService->create_transaction_ndt_uy_quyen($request, $contract_new, $investor);
            //tạo kỳ thanh toán mới
            $res = $this->payService->create_pay_ndt_uy_quyen($request, $contract_new, $investor);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->logsService->create($request, $exception, 'ContractService/expire_contract');
            return false;
        }

    }

    public function report_contract_uq($request)
    {
        $contracts = $this->contractRepository->report_contract_uq($request);
        $month = $request->month ?? date('Y-m');
        $start_date = Carbon::parse($month)->startOfMonth();
        $end_date = Carbon::parse($month)->endOfMonth();
        foreach ($contracts as $contract) {
            $date_diff = $this->date_interest_in_month($contract, $start_date, $end_date);
            $contract->date_diff = $date_diff;

            $nav_month = $this->nav_month($contract->amount_money, data_get(json_decode($contract->interest, true), 'interest_year'));
            $interest_profit = $nav_month / (Carbon::parse($month)->daysInMonth) * $date_diff;
            $contract->interest_profit = round($interest_profit);
        }
        return $contracts;
    }

    public function date_interest_in_month($contract, $start_date, $end_date)
    {
        $contract_start_date = date('Y-m-d', $contract->start_date);
        $contract_due_date = date('Y-m-d', $contract->due_date);
        $contract_expire_date = !empty($contract->date_expire) ? date('Y-m-d', $contract->date_expire) : '';

        $end = 0;
        if (!empty($contract_expire_date)) {
            if (strtotime($contract->date_expire) > strtotime($end_date)) {
                $end = $end_date;
            } else {
                $end = Carbon::parse($contract_expire_date);
            }
        } else {
            if (strtotime($contract_due_date) > strtotime($end_date)) {
                $end = $end_date;
            } else {
                $end = Carbon::parse($contract_due_date);
            }
        }

        $start = 0;
        if (strtotime($contract_start_date) < strtotime($start_date)) {
            $start = $start_date;
        } else {
            $start = Carbon::parse($contract_start_date)->addDay();
        }

        if (strtotime($contract_due_date) <= strtotime($start)) {
            $date_diff = 0;
        } else {
            $date_diff = $end->diffInDays($start) + 1;
        }
        return $date_diff;
    }

    public function nav_month($amount, $interest)
    {
        $interest_one_month = $amount * $interest / 100 / 12;
        return $interest_one_month;
    }

    public function calculator_due_before_maturity($request)
    {
        $data = [];
        $contract = $this->contractRepository->find($request->id);
        //lai da thanh toan
        $data['interest_paid'] = round($contract->transactions()
            ->where(Transaction::COLUMN_TYPE, Transaction::TRA_LAI)
            ->sum(Transaction::COLUMN_TIEN_LAI));
        //lai dao som
        $data['interest_early'] = 0;
        if ($request->punish == Contract::PUNISH) {
            $start_date = date('Y-m-d', $contract['start_date']);
            $expire_date = $request->expire_date;
            $date_diff = Carbon::parse($request->expire_date)->diffInDays($start_date);
            $data['interest_early'] = round($contract['amount_money'] * $request->early_interest / 100 / 365 * $date_diff);
        } else {
            $period = [];
            $interest_contract = data_get(json_decode($contract['interest'], true), 'interest_year');
            for ($i = 1; $i <= ($contract['number_day_loan'] / 30); $i++) {
                $start = $i == 1 ? $contract['start_date'] : $this->payService->periodDays(date('Y-m-d', $contract['start_date']), ($i - 1))['date'];
                $end = $this->payService->periodDays(date('Y-m-d', $contract['start_date']), $i)['date'];
                $period[] = [
                    'period' => $i,
                    'one_period_profit' => $contract['amount_money'] * $interest_contract / 100 / 12,
                    'start' => $start,
                    'end' => $end,
                    'day' => Carbon::parse(date('Y-m-d', $end))->diffInDays(date('Y-m-d', $start))
                ];
            }
            foreach ($period as $value) {
                if ($value['end'] <= strtotime($request->expire_date)) {
                    $data['interest_early'] += round($value['one_period_profit']);
                } else {
                    if ($value['start'] <= strtotime($request->expire_date) && $value['end'] >= strtotime($request->expire_date)) {
                        $date_diff = Carbon::parse($request->expire_date)->diffInDays(date('Y-m-d', $value['start']));
                        $data['interest_early'] += round($value['one_period_profit'] / $value['day'] * $date_diff);
                    }
                }
            }
        }
        //lai con phai tra
        $data['interest_payable'] = round($data['interest_early'] - $data['interest_paid']);
        //can tru goc
        $data['total_payable'] = round($contract['amount_money'] + $data['interest_payable']);
        return $data;
    }

    public function check_calculator_due_before_maturity($request)
    {
        $message = [];
        if (empty($request->id)) {
            $message[] = 'Không tìm thấy hợp đồng';
            return $message;
        } else {
            $contract = $this->contractRepository->find($request->id);
            if (!$contract) {
                $message[] = 'Không tìm thấy hợp đồng';
                return $message;
            } else {
                if ($contract['status_contract'] == Contract::EXPIRE) {
                    $message[] = 'Hợp đồng đã đáo hạn';
                    return $message;
                }
            }
        }

        if (empty($request->expire_date)) {
            $message[] = 'Ngày đáo hạn không để trống';
            return $message;
        } else {
            if (date('Y-m-d', strtotime($request->expire_date)) !== $request->expire_date) {
                $message[] = 'Ngày đáo hạn không đúng định dạng';
                return $message;
            } else {
                if (strtotime(date('Y-m-d', strtotime($request->expire_date))) < strtotime(date('Y-m-d', $contract['start_date']))) {
                    $message[] = 'Ngày đáo hạn không bé hơn ngày bắt đầu đầu tư';
                    return $message;
                } elseif (strtotime(date('Y-m-d', strtotime($request->expire_date))) > strtotime(date('Y-m-d', $contract['due_date']))) {
                    $message[] = 'Ngày đáo hạn không lớn hơn ngày kết thúc đầu tư';
                    return $message;
                }
            }
        }
        return $message;
    }

    //đáo hạn trước hạn
    public function due_before_maturity($request)
    {
        $data_payment = $this->calculator_due_before_maturity($request);
        DB::beginTransaction();
        try {
            $contract_old = $this->contractRepository->find($request->id);
            $interest = json_decode($contract_old['interest']);
            $interest->early_interest_year = $request->punish == Contract::PUNISH ? $request->early_interest : $interest->interest;
            //đáo hạn hợp đồng
            $contract_new = $this->contractRepository->update($request->id, [
                Contract::COLUMN_STATUS_CONTRACT => Contract::EXPIRE,
                Contract::COLUMN_DATE_EXPIRE => strtotime($request->expire_date),
                Contract::COLUMN_INTEREST => json_encode($interest)
            ]);

            //gạch kỳ thanh toán
            $pay_chua_thanh_toan = $contract_new->pays()
                ->where(Pay::COLUMN_STATUS, Pay::CHUA_THANH_TOAN)
                ->update([Pay::COLUMN_STATUS => Pay::DA_THANH_TOAN]);

            //tạo giao dịch
            $transaction = $this->transactionRepository->create([
                Transaction::COLUMN_TYPE => Transaction::TRA_LAI,
                Transaction::COLUMN_TYPE_METHOD => Transaction::FORM_HANDMADE,  //1 tu dong, 2 kt tra tay
                Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS,//1 thanh cong, 2 that bai
                Transaction::COLUMN_CODE_CONTRACT => $contract_new['code_contract'],
                Transaction::COLUMN_INVESTMENT_AMOUNT => round($data_payment['total_payable']),
                Transaction::COLUMN_TIEN_GOC => round($contract_new['amount_money']),
                Transaction::COLUMN_TIEN_LAI => round($data_payment['interest_payable']),
                Transaction::COLUMN_INVESTOR_CODE => $contract_new->investor->code,
                Transaction::COLUMN_NOTE => 'Trả lãi NDT ủy quyền',
                Transaction::COLUMN_CREATED_BY => current_user()->email,
                Transaction::COLUMN_CONTRACT_ID => $contract_new['id'],
                Transaction::COLUMN_TONG_GOC_LAI => round($data_payment['total_payable']),
                Transaction::COLUMN_DATE_PAY => strtotime($request->expire_date),
                Transaction::COLUMN_INTEREST_EARLY => round($data_payment['interest_early']),
                Transaction::COLUMN_INTEREST_PAID => round($data_payment['interest_paid']),
            ]);
            DB::commit();
            return $transaction;
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->logsService->create($request, $exception, 'ContractService/due_before_maturity');
            return null;
        }

    }

}
