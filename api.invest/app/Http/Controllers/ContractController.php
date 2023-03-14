<?php


namespace App\Http\Controllers;


use App\Models\Contract;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Lottery;
use App\Models\Pay;
use App\Models\Transaction;
use App\Models\User;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InvestmentRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LotteryRepository;
use App\Repository\LotteryRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\ContractService;
use App\Service\InterestService;
use App\Service\InvestmentService;
use App\Service\LogNlService;
use App\Service\LogsService;
use App\Service\PayService;
use App\Service\TransactionService;
use App\Service\VoiceOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        ContractRepositoryInterface $contract,
        TransactionRepositoryInterface $transaction,
        ContractService $contractService,
        TransactionService $transactionService,
        PayService $payService,
        PayRepositoryInterface $pay,
        VoiceOtp $voiceOtp,
        InvestmentRepositoryInterface $investment,
        InterestService $interestService,
        InvestmentService $investmentService,
        LogNlService $logNlService,
        LotteryRepositoryInterface $lotteryRepository,
        LogsService $logsService
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->contract_model = $contract;
        $this->transaction_model = $transaction;
        $this->contractService = $contractService;
        $this->transactionService = $transactionService;
        $this->payService = $payService;
        $this->pay_model = $pay;
        $this->voice_otp = $voiceOtp;
        $this->investment_model = $investment;
        $this->interestService = $interestService;
        $this->investmentService = $investmentService;
        $this->logNlService = $logNlService;
        $this->lotteryRepository = $lotteryRepository;
        $this->logsService = $logsService;
    }

    public function get_contract_investor_app(Request $request)
    {
        //id : investor_id
        $condition = $request->only('id', 'start', 'end', 'minLoan', 'maxLoan', 'text', 'option', 'type_interest');
        $contracts = $this->contract_model->get_contract_investor_app($condition, $request->offset, $request->limit);
        foreach ($contracts as $contract) {
            $contract->ki_tra_lai = $this->pay_model->findMany([Pay::COLUMN_CONTRACT_ID => $contract->id]);
        }
        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $contracts
        ];
        return response()->json($response, 200);
    }

    public function sum_money_investor(Request $request)
    {
//        $tong_tien_dau_tu = $this->transaction_model->dashboard_investor($request->id, Transaction::COLUMN_INVESTMENT_AMOUNT, Transaction::DAU_TU);
//        $tong_tien_lai = $this->transaction_model->dashboard_investor($request->id, Transaction::COLUMN_TIEN_LAI, Transaction::TRA_LAI);
//        $tong_goc_da_tra = $this->transaction_model->dashboard_investor($request->id, Transaction::COLUMN_TIEN_GOC, Transaction::TRA_LAI);
        $tong_tien = $this->transaction_model->dashboard_investor_v2($request->id);
        $tong_tien_dau_tu = $tong_tien->tong_tien_dau_tu ?? 0;
        $tong_goc_da_tra = $tong_tien->goc_da_tra ?? 0;
        $tong_tien_lai = $tong_tien->lai_da_tra ?? 0;
        $tong_lai_con_lai = $this->pay_model->dashboard_investor(
            $request->id, Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA,
            [
                Pay::CHUA_THANH_TOAN,
                Pay::THANH_TOAN_TU_DONG_THAT_BAI,
                Pay::CHO_NGAN_LUONG_XU_LY,
                Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI,
                Pay::NGAN_LUONG_DA_HOAN_TRA,
            ]
        );
        $investor = $this->investor_model->find($request->id);
        $this->user_model->update($investor['user_id'], [User::LAST_LOGIN => Carbon::now()]);
        $response = [
            'status' => Controller::HTTP_OK,
            'tong_tien_dau_tu' => $tong_tien_dau_tu,
            'tong_tien_lai' => $tong_tien_lai,
            'tong_goc_da_tra' => $tong_goc_da_tra,
            'tong_goc_con_lai' => $tong_tien_dau_tu - $tong_goc_da_tra,
            'tong_lai_con_lai' => round($tong_lai_con_lai),
        ];
        return response()->json($response);
    }

    public function confirm_investor_contract(Request $request)
    {
        $contract = $this->contractService->create_contract($request);
        $id = $contract->id;
        return response()->json([
            'status' => Controller::HTTP_OK,
            'id_contract' => $id,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function show_contract(Request $request)
    {
        $contract = $this->contract_model->find($request->id);
        $pay = $this->pay_model->findManySortColumn([Pay::COLUMN_CONTRACT_ID => $request->id], Pay::COLUMN_NGAY_KY_TRA, 'ASC');
        return response()->json([
            'status' => Controller::HTTP_OK,
            'contract' => $contract,
            'pay' => $pay,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function get_all_contract(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'code_contract', 'investor_code', 'type', 'status', 'action');
        $contracts = $this->contract_model->get_contract_paginate($condition);
        if (!empty($condition['type']) && $condition['type'] == Contract::HOP_DONG_UY_QUYEN) {
            foreach ($contracts as $contract) {
                $da_thanh_toan = $this->transaction_model->transaction_has_been_paid($contract->id);
                $contract->goc_da_tra = $da_thanh_toan->tien_goc;
                $contract->lai_da_tra = $da_thanh_toan->tien_lai;
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $contracts
        ]);
    }

    public function contract_payment_schedule(Request $request)
    {
        $contract = $this->contract_model->findCode($request->code);
        $contract->interest = json_decode($contract->interest);
        $contract->pays = $contract->pays;
        $contract->investor = $contract->investor;
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $contract,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function financial_report_app(Request $request)
    {
        $condition = $request->only('id', 'start', 'end');
        $transactions = $this->transaction_model->financial_report_contract($condition);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $transactions,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function get_all()
    {
        $contracts = $this->contract_model->getAll();
        foreach ($contracts as $contract) {
            $contract->interest = json_decode($contract->interest);
            $contract->investor = $contract->investor;
            $contract->pays = $contract->pays;
            $da_tra = 0;
            foreach ($contract->pays as $pay) {
                if ($pay->status == 2) {
                    $da_tra += 1;
                }
            }
            $contract->da_tra = $da_tra;
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $contracts,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function excel_all_contract(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'code_contract', 'investor_code', 'type', 'status');
        $contracts = $this->contract_model->excel_all_contract($condition);
        $contracts = $contracts->each(function ($value, $key) {
            $pay = $this->contract_model->excel_contract($value->id, Pay::DA_THANH_TOAN);
            $value->da_tra = $pay->da_tra;
            $value->lai_da_tra = $pay->lai_da_tra;
            $value->goc_da_tra = $pay->goc_da_tra;
        });
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $contracts
        ]);
    }

    public function import_contract_ndt_uy_quyen(Request $request)
    {
        $investor = $this->investor_model->findOne([Investor::COLUMN_CODE => $request->code]);
        if (!$investor) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                "message" => "NDT không tìm thấy",
                'data' => $request->key
            ]);
        }
        $validate = $this->contractService->validate_contract_ndt_uy_quyen($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                "message" => $validate->errors()->first(),
                'data' => $request->key
            ]);
        } else {
            DB::beginTransaction();
            try {
                $contract = $this->contractService->create_contract_ndt_uy_quyen($request, $investor);
                $transaction = $this->transactionService->create_transaction_ndt_uy_quyen($request, $contract, $investor);
                $res = $this->payService->create_pay_ndt_uy_quyen($request, $contract, $investor);
                DB::commit();
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => 'success',
                ]);
            } catch (\Exception $exception) {
                $this->logsService->create($request, $exception, 'ContractController/import_contract_ndt_uy_quyen');
                DB::rollBack();
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => 'fail',
                ]);
            }

        }
    }

    public function them_phu_luc_ndt_uy_quyen(Request $request)
    {
        $validate = $this->contractService->validate_phu_luc_ndt_uy_quyen($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }
        if (isset($request->date_pay)) {
            if ((int)$request->date_pay <= 0 || (int)$request->date_pay >= 28) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    "message" => "Ngày thanh toán không hợp lệ",
                ]);
            }
        }
        DB::beginTransaction();
        try {
            $investor = $this->investor_model->find($request->id);
            $contract = $this->contractService->create_contract_ndt_uy_quyen($request, $investor);
            $transaction = $this->transactionService->create_transaction_ndt_uy_quyen($request, $contract, $investor);
            $this->payService->create_pay_ndt_uy_quyen($request, $contract, $investor);
            DB::commit();
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'success',
            ]);
        } catch (\Exception $exception) {
            $this->logsService->create($request, $exception, 'PayController/cap_nhat_ki_thanh_toan_ndt_uq');
            DB::rollBack();
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'fail',
            ]);
        }

    }

    public function send_otp_invest(Request $request)
    {
        $investor = $this->investor_model->find($request->id);
        $investment = $this->investment_model->find($request->contract_id);
        $message = $this->contractService->check_invest($investor, $investment, $request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $message[0],
            ]);
        }
        $user = $this->user_model->findOne(['id' => $investor->user_id]);
        $otp_invest = rand(100000, 999999);
        $time_otp_invest = Carbon::now()->addMinute(2)->format('Y-m-d H:i:s');
        if (isset($investment->otp_invest)) {
            if (time() <= strtotime($investment->time_otp_invest)) {
                $otp = $investment->otp_invest;
                $this->investmentService->update_otp($otp, $time_otp_invest, $request);
            } else {
                $this->investmentService->update_otp($otp_invest, $time_otp_invest, $request);
                $otp = $otp_invest;
            }
        } else {
            $this->investmentService->update_otp($otp_invest, $time_otp_invest, $request);
            $otp = $otp_invest;
        }
        $send_otp = $this->voice_otp->send_sms_voice_otp_v2($user->phone, $otp);
        if (isset($send_otp->sendError) && $send_otp->sendError == false) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Mã xác thực sẽ được cung cấp thông qua cuộc gọi',
                'contract_id' => $request->contract_id
            ]);
        } else {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => isset($send_otp->sendErrorMsg) ? $send_otp->sendErrorMsg : 'Gửi OTP thất bại',
                'contract_id' => $request->contract_id
            ]);
        }
    }

    public function xac_nhan_dau_tu(Request $request)
    {
        $otp = $request->otp_invest;
        $investor = $this->investor_model->find($request->id);
        $investment = $this->investment_model->find($request->contract_id);
        $message = $this->contractService->check_invest($investor, $investment, $request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $message[0],
            ]);
        }
        if ($otp != $investment->otp_invest) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => 'Mã xác thực không đúng',
            ]);
        }
        if (time() > strtotime($investment->time_otp_invest)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => 'Mã xác thực hết hạn',
            ]);
        }
        if ($request->id != $investment->investor_create_otp) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => 'Người dùng không hợp lệ',
            ]);
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function run_low_interest_contract_again(Request $request)
    {
        $this->contractService->run_low_interest_contract_again($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function clear_contract_uy_quyen(Request $request)
    {
        $this->contractService->clear_contract_uy_quyen($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function active_contract()
    {
        $contracts = $this->contract_model->getAll();
        foreach ($contracts as $contract) {
            if (empty($contract['status'])) {
                $this->contract_model->update($contract['id'], [Contract::COLUMN_STATUS => Contract::SUCCESS]);
                $transaction_payin = $this->transaction_model->findOne([
                    Transaction::COLUMN_CONTRACT_ID => $contract['id'],
                    Transaction::COLUMN_TYPE => Transaction::DAU_TU,
                ]);
                if (empty($transaction_payin['status'])) {
                    $this->transaction_model->update($transaction_payin['id'], [Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS]);
                }
            }
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function check_transaction_nl(Request $request)
    {
        try {
            $data = $this->contractService->check_transaction_nl($request);
            if (isset($data['contract'])) {
                $investor = $this->investor_model->find($data['contract']['investor_id']);
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => 'Thành công',
                    'contract' => $data['contract'],
                    'interest' => data_get(json_decode($data['contract']['interest'], true), 'interest'),
                    'investor' => $investor,
                ]);
            } else {
                return response()->json([
                    'status' => Controller::HTTP_UNAUTHORIZED,
                    'message' => $data['message'],
                ]);
            }
        } catch (\Exception $exception) {
            $this->logNlService->create_log($exception->getMessage(), 'error');
        }
    }

    public function get_contract_to_check_status()
    {
        $this->contractService->get_contract_to_check_status();
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function clear_contract_uq()
    {
        $this->contractService->clear_contract_uq();
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function payment_many(Request $request)
    {
        $validate = $this->contractService->validate_payment_many($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }
        $this->contractService->payment_many($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function get_contract_by_promotions(Request $request)
    {
        $data = $this->contractService->get_contract_by_promotions($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function get_promotions()
    {
        $data = $this->lotteryRepository->findMany([Lottery::COLUMN_STATUS => 'active']);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function update_promotions(Request $request)
    {
        $data = $this->lotteryRepository->update($request->id, [Lottery::COLUMN_STATUS => 'block']);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function financial_report_app_v2(Request $request)
    {
        //id : investor_id
        $condition = $request->only('id', 'year');
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $tong_dau_tu = $this->transaction_model->financial_report_contract_v2($condition['id'], $condition['year'] ?? date('Y'), Transaction::DAU_TU, $i);
            $tong_goc_lai_tra = $this->transaction_model->financial_report_contract_v2($condition['id'], $condition['year'] ?? date('Y'), Transaction::TRA_LAI, $i);
            $data[] = [
                'nam' => (int)($condition['year'] ?? date('Y')),
                'thang' => $i,
                'dau_tu' => (int)$tong_dau_tu->dau_tu ?? 0,
                'goc_tra' => $tong_goc_lai_tra->tien_goc ?? 0,
                'lai_tra' => $tong_goc_lai_tra->tien_lai ?? 0,
            ];
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function update_code_contract(Request $request)
    {
        if (!empty($request->id) && !empty($request->code)) {
            Contract::where(Contract::COLUMN_ID, $request->id)
                ->update([
                    Contract::COLUMN_CODE_CONTRACT => $request->code,
                    Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT => $request->code
                ]);

            Transaction::where(Transaction::COLUMN_CONTRACT_ID, $request->id)
                ->update([Transaction::COLUMN_CODE_CONTRACT => $request->code]);

            Pay::where(Pay::COLUMN_CONTRACT_ID, $request->id)
                ->update([Pay::COLUMN_CODE_CONTRACT => $request->code]);
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function report_contract(Request $request)
    {
        $contracts = $this->contractService->report_contract($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $contracts);
    }

    public function expire_contract(Request $request)
    {
        $validate = $this->contractService->validate_expire_contract($request);
        if ($validate->fails()) {
            return Controller::send_response(Controller::HTTP_BAD_REQUEST, $validate->errors()->first());
        }

        $check = $this->contractService->check_expire_contract($request);
        if (count($check) > 0) {
            return Controller::send_response(Controller::HTTP_BAD_REQUEST, $check[0]);
        }

        $result = $this->contractService->expire_contract($request);
        if ($result == true) {
            return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
        } else {
            return Controller::send_response(Controller::HTTP_BAD_REQUEST, Controller::FAIL);
        }

    }

    public function report_contract_uq(Request $request)
    {
        $data = $this->contractService->report_contract_uq($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function calculator_due_before_maturity(Request $request)
    {
        $check = $this->contractService->check_calculator_due_before_maturity($request);
        if (count($check) > 0) {
            return Controller::send_response(Controller::HTTP_BAD_REQUEST, $check[0]);
        }
        $result = $this->contractService->calculator_due_before_maturity($request);
        if ($result) {
            return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $result);
        } else {
            return Controller::send_response(Controller::HTTP_BAD_REQUEST, Controller::FAIL);
        }
    }

    public function detail_contract(Request $request)
    {
        $contract = $this->contract_model->find($request->id);
        $contract->investor = $contract->investor()->first();
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $contract);
    }

    public function due_before_maturity(Request $request)
    {
        $check = $this->contractService->check_calculator_due_before_maturity($request);
        if (count($check) > 0) {
            return Controller::send_response(Controller::HTTP_BAD_REQUEST, $check[0]);
        }
        $result = $this->contractService->due_before_maturity($request);
        if ($result) {
            return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $result);
        } else {
            return Controller::send_response(Controller::HTTP_BAD_REQUEST, Controller::FAIL);
        }
    }
}
