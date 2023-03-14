<?php


namespace App\Http\Controllers\AppV2;


use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Pay;
use App\Models\Transaction;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InvestmentRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\ContractService;
use App\Service\DraftNlService;
use App\Service\InterestService;
use App\Service\InvestmentService;
use App\Service\LogsService;
use App\Service\NotificationService;
use App\Service\PayService;
use App\Service\TransactionService;
use App\Service\VoiceOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        NotificationService $notificationService,
        DraftNlService $draftNlService,
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
        $this->notificationService = $notificationService;
        $this->draftNlService = $draftNlService;
        $this->logsService = $logsService;
    }

    public function investment_confirmation_vimo(Request $request)
    {
        $investment = $this->investment_model->find($request->contract_id);
        $investor = $this->investor_model->find($request->id);
        if (!$investor) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Người dùng không đúng",
            ]);
        }
        if (!$investment) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Hợp đồng không tồn tại",
            ]);
        }
        $message = $this->contractService->check_invest($investor, $investment, $request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $message[0],
            ]);
        }
        $this->investment_model->update($request->contract_id, [Investment::COLUMN_INVESTOR_CONFIRM => $investor->code]);
        $contract = $this->contractService->app_create_contract_v2($investment, $investor, $request);
        $this->transactionService->app_create_transaction_v2($contract, $request);
        $this->payService->app_create_pay_v2($contract, $request);
        $this->notificationService->app_push_notification_investment($contract, $investor);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'contract_id' => $contract->id,
            'interest' => data_get(json_decode($contract->interest, true), 'interest')
        ]);
    }

    public function create_transaction_ngan_luong(Request $request)
    {
        if (empty($request->id) || empty($request->contract_id)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Thông tin không hợp lệ",
            ]);
        }

        if (empty($request->client_code)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Định dạng thiết bị đang trống",
            ]);
        }
        $investor = $this->investor_model->find($request->id);
        if (!$investor) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Người dùng không đúng",
            ]);
        }
        $investment = $this->investment_model->find($request->contract_id);
        if (!$investment) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Hợp đồng không tồn tại",
            ]);
        }
        $message = $this->contractService->check_investment_pay_nl($investor, $investment, $request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $message[0],
            ]);
        }
        try {
            $time_otp_invest = Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s');
            $this->investmentService->update_time_invest($time_otp_invest, $request);

            $bill = $this->draftNlService->create_bill($request);
            $url = $this->contractService->pay_out_nl($bill, $investor, $investment);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $url,
                'bill_id' => $bill['id'],
                'message' => 'success',
            ]);
        } catch (\Exception $exception) {
            $this->logsService->create($request, $exception, 'ContractController/create_transaction_ngan_luong');
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => Controller::FAIL,
            ]);
        }
    }

    public function cancel(Request $request)
    {
        $this->draftNlService->cancel($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'success',
        ]);
    }

    public function success_nl(Request $request)
    {
        $data = $this->contractService->success_nl($request);
        if (isset($data['contract'])) {
            $investor = $data['contract']->investor;
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
    }

    public function success(Request $request)
    {
        $this->contractService->success($request);
    }

    public function get_bill(Request $request)
    {
        $bill = $this->contractService->get_bill($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'success',
            'data' => $bill
        ]);
    }

    public function create_transaction_ngan_luong_v3(Request $request)
    {
        if (empty($request->id) || empty($request->contract_id)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Thông tin không hợp lệ",
            ]);
        }

        if (empty($request->client_code)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Định dạng thiết bị đang trống",
            ]);
        }
        $investor = $this->investor_model->find($request->id);
        if (!$investor) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Người dùng không đúng",
            ]);
        }
        $investment = $this->investment_model->find($request->contract_id);
        if (!$investment) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Hợp đồng không tồn tại",
            ]);
        }
        $message = $this->contractService->check_investment_pay_nl($investor, $investment, $request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $message[0],
            ]);
        }
        $time_otp_invest = Carbon::now()->addMinute(10)->format('Y-m-d H:i:s');
        $this->investmentService->update_time_invest($time_otp_invest, $request);

        $bill = $this->draftNlService->create_bill($request);
        $data = $this->contractService->nl_check_v3($bill, $investor, $investment);
        if (!empty($data['message'])) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $data['message'],
            ]);
        } else {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $data,
                'message' => 'success',
            ]);
        }
    }

    public function check_bill(Request $request)
    {
        $check = $this->draftNlService->check_bill($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $check,
            'message' => 'success',
        ]);
    }
}
