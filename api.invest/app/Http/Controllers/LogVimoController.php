<?php

namespace App\Http\Controllers;

use App\Models\LogVimo;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LogPayRepositoryInterface;
use App\Repository\LogVimoRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\NotificationService;
use App\Service\PayService;
use Illuminate\Http\Request;

class LogVimoController extends Controller
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
        LogVimoRepositoryInterface $log_vimo
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
        $this->log_vimo_model = $log_vimo;
    }

    public function create_log(Request $request)
    {
        $data = [
            LogVimo::COLUMN_REQUEST => $request->param,
            LogVimo::COLUMN_RESPONSE => $request->response,
            LogVimo::COLUMN_TYPE => $request->type,
            LogVimo::COLUMN_CREATED_BY => $request->created_by,
        ];
        $this->log_vimo_model->create($data);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function getLogVimo(Request $request)
    {
        $log = $this->log_vimo_model->getLogVimo($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success",
            'data' => $log,
        ], Controller::HTTP_OK);
    }
}
