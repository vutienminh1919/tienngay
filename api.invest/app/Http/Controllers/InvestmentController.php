<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\Investment;
use App\Repository\InterestRepository;
use App\Repository\InvestmentRepositoryInterface;
use App\Service\InterestService;
use App\Service\InvestmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function __construct(InvestmentRepositoryInterface $investment,
                                InvestmentService $investmentService,
                                InterestService $interestService,
                                InterestRepository $interestRepository)
    {
        $this->investment_model = $investment;
        $this->investmentService = $investmentService;
        $this->interestService = $interestService;
        $this->interestRepository = $interestRepository;
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount_money' => 'required',
            'type_interest' => 'required',
            'month' => 'required',
            'quantity' => 'required',
        ], [
            'amount_money.required' => 'Số tiền không để trống',
            'type_interest.required' => 'Hình thức không để trống',
            'month.required' => 'Kì hạn không để trống',
            'quantity.required' => 'Số lượng không để trống',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }

        $interest = $this->interestRepository->findOne([
            Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE,
            Interest::COLUMN_PERIOD => $request->month,
            Interest::COLUMN_TYPE_INTEREST => $request->type_interest
        ]);
        if (!$interest) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Tạo không thành công. Không tìm thấy lãi suất hợp lệ"
            ]);
        }
        $quantity = $request->quantity;
        for ($i = 1; $i <= $quantity; $i++) {
            $this->investmentService->create($request);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS
        ]);
    }

    public function get_investment_app(Request $request)
    {
        $condition = $request->only('minLoan', 'maxLoan', 'text', 'loan', 'type_interest');
        $contracts = $this->investment_model->get_investment_app($condition, $request->offset, $request->limit);
        foreach ($contracts as $contract) {
            $interest = $this->interestService->get_interest_for_investment($contract);
            $contract->interest = $interest;
        }
        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $contracts
        ];
        return response()->json($response, 200);
    }

    public function show(Request $request)
    {
        $contract = $this->investment_model->find($request->id);
        $interest = $this->interestService->get_interest_for_investment($contract);
        $contract->interest = $interest;
        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $contract
        ];
        return response()->json($response, 200);
    }

    public function investor_confirm(Request $request)
    {
        $this->investment_model->update($request->id, [Investment::COLUMN_INVESTOR_CONFIRM => $request->investor_code]);
        $response = [
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS
        ];
        return response()->json($response, 200);
    }

    public function create_cpanel(Request $request)
    {
        $this->investmentService->create_cpanel($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS
        ]);
    }

    public function get_investment()
    {
        $investments = $this->investment_model->get_investment();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $investments
        ]);
    }
}
