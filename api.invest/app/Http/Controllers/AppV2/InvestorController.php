<?php


namespace App\Http\Controllers\AppV2;


use App\Http\Controllers\Controller;
use App\Repository\CallRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LogCallRepositoryInterface;
use App\Repository\LogInvestorRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\InvestorService;
use App\Service\LogCallService;
use App\Service\LogInvestorService;
use App\Service\NotificationService;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        NotificationService $notificationService,
        LogInvestorRepositoryInterface $logInvest,
        CallRepositoryInterface $call,
        LogCallRepositoryInterface $logCall,
        LogCallService $logCallService,
        LogInvestorService $logInvestorService,
        InvestorService $investorService
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->logInvest_model = $logInvest;
        $this->notificationService = $notificationService;
        $this->call_model = $call;
        $this->log_call_service = $logCallService;
        $this->log_investor_service = $logInvestorService;
        $this->investor_service = $investorService;
        $this->logCall_model = $logCall;
    }

    public function target_account_receiving_interest(Request $request)
    {
        $message = $this->investor_service->check_account_receiving_interest($request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $message[0],
            ]);
        } else {
            $this->investor_service->target_account_receiving_interest($request);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => "Cập nhật thành công",
            ]);
        }
    }

}
