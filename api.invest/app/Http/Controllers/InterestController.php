<?php


namespace App\Http\Controllers;


use App\Models\Contract;
use App\Models\ContractInterest;
use App\Models\Interest;
use App\Models\LogInterest;
use App\Repository\ContractInterestRepository;
use App\Repository\ContractInterestRepositoryInterface;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InterestRepository;
use App\Repository\InterestRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LogInterestRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\InterestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;

class InterestController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        ContractRepositoryInterface $contract,
        InterestRepositoryInterface $interest,
        LogInterestRepositoryInterface $logInterest,
        ContractInterestRepositoryInterface $contractInterest,
        InterestService $interestService
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->contract_model = $contract;
        $this->interest_model = $interest;
        $this->logInterest_model = $logInterest;
        $this->contractInterest_model = $contractInterest;
        $this->interestService = $interestService;
    }

    public function get_interest(Request $request)
    {
        $interest = $this->interestService->get_interest_for_app($request);
//        $interest = $this->interest_model->get_interest_type_all_active($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $interest,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    /**
     * @OA\Post(path="/interest/create_interest_general",
     *   tags={"interest"},
     *   summary="create",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(property="interest",type="string"),
     *            example={"interest": "1.5"}
     *        )
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function create_interest_general(Request $request)
    {
        $interest = $this->interest_model->find_interest($request->interest);
        if (count($interest) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Lãi suất đã tồn tại"
            ]);
        }
        $interests = $this->interest_model->get_interest_type_all();
        foreach ($interests as $item) {
            $this->interest_model->update($item->id, [Interest::COLUMN_STATUS => Interest::STATUS_BLOCK]);
        }
        $data = [
            Interest::COLUMN_INTEREST => $request->interest,
            Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE,
            Interest::COLUMN_CREATED_BY => $request->created_by,
            Interest::COLUMN_TYPE => Interest::TYPE_ALL
        ];
        $interest_new = $this->interest_model->create($data);
        $data[Interest::COLUMN_ID] = $interest_new->id;
        $log = [
            LogInterest::COLUMN_TYPE => LogInterest::TYPE_CREATE,
            LogInterest::COLUMN_NEW => json_encode($data),
            LogInterest::COLUMN_CREATED_BY => $request->created_by
        ];
        $this->logInterest_model->create($log);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success"
        ]);
    }

    /**
     * @OA\Post(path="/interest/get_list_interest_general",
     *   tags={"interest"},
     *   summary="Lấy ds cài dặt lãi suất",
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function get_list_interest_general(Request $request)
    {
        $interest = $this->interest_model->get_type_all();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $interest,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    /**
     * @OA\Post(path="/interest/active_interest_general",
     *   tags={"interest"},
     *   summary="active",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(property="id",type="string"),
     *        )
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function active_interest_general(Request $request)
    {
        $interests = $this->interest_model->get_interest_type_all();
        foreach ($interests as $item) {
            if ($item['id'] != $request->id) {
                $this->interest_model->update($item->id, [Interest::COLUMN_STATUS => Interest::STATUS_BLOCK]);
            }
        }

        $interest = $this->interest_model->find($request->id);
        if ($interest['status'] == Interest::STATUS_BLOCK) {
            $this->interest_model->update($request->id, [Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE]);
        } else {
            $this->interest_model->update($request->id, [Interest::COLUMN_STATUS => Interest::STATUS_BLOCK]);
        }

        $data = [
            Interest::COLUMN_ID => $request->id,
            Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE,
            Interest::COLUMN_CREATED_BY => $request->created_by,
        ];
        $log = [
            LogInterest::COLUMN_TYPE => LogInterest::TYPE_ACTIVE,
            LogInterest::COLUMN_NEW => json_encode($data),
            LogInterest::COLUMN_CREATED_BY => $request->created_by
        ];
        $this->logInterest_model->create($log);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    /**
     * @OA\Post(path="/interest/thong_ke_hop_dong",
     *   tags={"interest"},
     *   summary="thong ke",
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function thong_ke_hop_dong(Request $request)
    {
        $interest_type_all = $this->interest_model->get_all_type_asc();
        $data = [];
        foreach ($interest_type_all as $value) {
            $total_contract = $this->contract_model->count_find_foreignKey($value->id, 'interest', Contract::COLUMN_INTEREST_ID);
            $data["$value->interest"] = $total_contract;
            $value->total_contract = $total_contract;
        }
        $interest_type_period = $this->interest_model->get_interest_period();
        $data1 = [];
        foreach ($interest_type_period as $item) {
            $item->total_contract_period = 0;
            foreach ($item->contractInterests as $contractInterest) {
                $total_contract_period = $this->contract_model->count_find_foreignKey($contractInterest->id, 'contract_interest', Contract::COLUMN_CONTRACT_INTEREST_ID);
                $data1["$contractInterest->interest"][] = $total_contract_period;
                $item->total_contract_period += $total_contract_period;
            }
        }
        $data2 = [];
        foreach ($data1 as $k1 => $v1) {
            $data2["$k1"] = array_sum($v1);
        }
        $data3 = [];
        foreach ($data as $k => $v) {
            $data3[$k][] = $v;
        }
        foreach ($data2 as $k2 => $v2) {
            $data3[$k2][] = $v2;
        }
        $data4 = [];
        foreach ($data3 as $k3 => $v3) {
            $data4[$k3] = array_sum($v3);
        }
        ksort($data4);
        return response()->json([
            self::STATUS => self::HTTP_OK,
            self::MESSAGE => self::SUCCESS,
            'bieu_do' => $data4,
//            'bieu_do2' => $data2,
            'thong_ke' => $interest_type_all,
            'thong_ke1' => $interest_type_period,
        ]);
    }

    /**
     * @OA\Post(path="/interest/show",
     *   tags={"interest"},
     *   summary="show",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(property="id",type="string"),
     *        )
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function show(Request $request)
    {
        $interest = $this->interest_model->find($request->id);
        $interest->contracts = $interest->contracts;
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success",
            'interest' => $interest
        ]);
    }

    /**
     * @OA\Post(path="/interest/show_detail",
     *   tags={"interest"},
     *   summary="show_detail",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(property="id",type="string"),
     *        )
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function show_contract(Request $request)
    {
        $contracts = $this->contract_model->find_interest_paginate($request->id);
        foreach ($contracts as $contract) {
            $contract->investor = $contract->investor;
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success",
            'contracts' => $contracts
        ]);
    }

    public function create_interest_period(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'interest' => 'required',
            'period' => 'required',
            'type_interest' => 'required',
        ], [
            'interest.required' => 'Lãi suất không để trống',
            'period.required' => 'Kì hạn không để trống',
            'type_interest.required' => 'Hình thức không để trống',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }
        $message = $this->interestService->create_period_new($request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $message[0]
            ]);
        } else {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công'
            ]);
        }
    }

    public function get_interest_period()
    {
        $interest = $this->interestService->get_interest_period();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $interest,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function update_interest_period(Request $request)
    {
        $this->interestService->update_interest_period($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function edit_add_interest_period(Request $request)
    {
        $this->interestService->edit_add_interest_period($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success"
        ]);
    }

}
