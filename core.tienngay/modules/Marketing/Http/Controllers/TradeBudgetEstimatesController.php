<?php

namespace Modules\Marketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\MongodbCore\Repositories\Interfaces\TradeOrderRepositoryInterface as TradeOrderRepository;
use Modules\MongodbCore\Entities\TradeBudgetEstimates;
use Modules\MongodbCore\Entities\TradeOrder;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepo;
use Modules\MongodbCore\Repositories\Interfaces\TradeBudgetEstimatesRepositoryInterface as TradeBudgetEstimatesRepository;
use Modules\Marketing\Service\MarketingApi;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\RoleRepository;

class TradeBudgetEstimatesController extends BaseController
{

    /**
     * Modules\MongodbCore\Repositories\TradeOrderRepository
     * */
    private $tradeOrderRepo;

    /**
     * Modules\MongodbCore\Repositories\TradeBudgetEstimatesRepository
     * */
    private $budgetEstimatesRepo;

    /**
     * Modules\MongodbCore\Repositories\StoreRepository
     * */
    private $storeRepo;
    private $groupRoleRepository;
    private $roleRepository;
    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Order Trade Item"
     * )
     */
    public function __construct(
        TradeOrderRepository $tradeOrderRepository,
        StoreRepo            $storeRepo,
        TradeBudgetEstimatesRepository $budgetEstimatesRepo,
        GroupRoleRepository $groupRoleRepository,
        RoleRepository $roleRepository
    ) {
        $this->tradeOrderRepo = $tradeOrderRepository;
        $this->storeRepo = $storeRepo;
        $this->budgetEstimatesRepo = $budgetEstimatesRepo;
        $this->groupRoleRepository = $groupRoleRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * add budget estimates status
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function removeBudgetEstimate(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('removeBudgetEstimate: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('removeBudgetEstimate data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'orderId'                           => 'required',
            'created_by'                        => 'required'
        ], [
            'orderId.required'                  => 'Không xác định được đối tượng',
            'created_by.required'               => 'Bạn chưa đăng nhập',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('removeBudgetEstimate validate failed: ' . print_r($response, true));
            return response()->json($response);
        }

        $orderId = $data['orderId'];
        $tradeOrder = $this->tradeOrderRepo->fetch($orderId);
        if (!$tradeOrder) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('removeBudgetEstimate data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataSave = [
            TradeOrder::BUDGET_ESTIMATES            => TradeOrder::BUDGET_ESTIMATES_REMOVED
        ];
        $log = [
            TradeOrder::CREATED_BY                  => $data['created_by'],
            TradeOrder::CREATED_AT                  => time(),
            TradeOrder::ACTION                      => TradeOrder::ACTION_UPDATE_BUDGET_ESTIMATES,
            TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_UPDATE_BUDGET_ESTIMATES),
            TradeOrder::STATUS                      => $tradeOrder['status'],
            TradeOrder::PROGRESS                    => $tradeOrder['progress'],
            TradeOrder::STATUS_LABEL                => TradeOrder::$budget_estimates_label[TradeOrder::BUDGET_ESTIMATES_REMOVED] . ' - Name: ' . $tradeOrder[TradeOrder::BUDGET_ESTIMATES_NAME]
        ];
        $this->tradeOrderRepo->wlog($orderId, $log);
        if ($update = $this->tradeOrderRepo->updateBudgetEstimatesStatus($orderId, $dataSave)) {
            $response = [
                'data' => $dataSave,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success')
            ];
            Log::channel('marketing')->info('removeBudgetEstimate data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('removeBudgetEstimate data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * add budget estimates status
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function addBudgetEstimate(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('addBudgetEstimate: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('addBudgetEstimate data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'orderId'                           => 'required',
            'created_by'                        => 'required'
        ], [
            'orderId.required'                  => 'Không xác định được đối tượng',
            'created_by.required'               => 'Bạn chưa đăng nhập',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('addBudgetEstimate validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        if (empty($data['budget_estimates_id'])) {
            if (empty($data['budget_estimates_name'])) {
                $response = [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Tên dự toán ngân sách không được để trống',
                    'data' => $data,
                    'errors' => ['budget_estimates_name' => ['Tên dự toán ngân sách không được để trống']]
                ];
                Log::channel('marketing')->info('addBudgetEstimate validate failed: ' . print_r($response, true));
                return response()->json($response);
            }
            // Tạo mới ngân sách
            $dataSave = [
                TradeBudgetEstimates::NAME                    => $data['budget_estimates_name'],
                TradeBudgetEstimates::CREATED_BY              => $data['created_by'],
                TradeBudgetEstimates::UPDATED_BY              => $data['created_by'],
            ];

            $log = [
                TradeBudgetEstimates::CREATED_BY                  => $data['created_by'],
                TradeBudgetEstimates::CREATED_AT                  => time(),
                TradeBudgetEstimates::ACTION                      => TradeBudgetEstimates::ACTION_CREATE,
                TradeBudgetEstimates::ACTION_LABEL                => TradeBudgetEstimates::actionLabel(TradeBudgetEstimates::ACTION_CREATE),
                TradeBudgetEstimates::STATUS                      => TradeBudgetEstimates::STATUS_NEW,
                TradeBudgetEstimates::PROGRESS                    => TradeBudgetEstimates::PROGRESS_CREATE_NEW,
                TradeBudgetEstimates::STATUS_LABEL                => TradeBudgetEstimates::StatusLabel(TradeBudgetEstimates::STATUS_NEW, TradeBudgetEstimates::PROGRESS_CREATE_NEW)
            ];
            $dataSave[TradeBudgetEstimates::LOGS][] = $log;
            if ($create = $this->budgetEstimatesRepo->store($dataSave)) {
                $budgetEstimateId = $create['_id'];
                $budgetEstimateName = $create['name'];
            } else {
                $response = [
                    'data' => $data,
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('Marketing::messages.errors')
                ];
                Log::channel('marketing')->info('addBudgetEstimate data errors: ' . print_r($response, true));
                return response()->json($response);
            }
            
        } else {
            $budgetEstimates = $this->budgetEstimatesRepo->fetch($data['budget_estimates_id']);
            if (!$budgetEstimates) {
                $response = [
                    'data' => $data,
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('Marketing::messages.not_found')
                ];
                Log::channel('marketing')->info('addBudgetEstimate data errors: ' . print_r($response, true));
                return response()->json($response);
            }
            $budgetEstimateId = $budgetEstimates['_id'];
            $budgetEstimateName = $budgetEstimates['name'];
        }

        $orderId = $data['orderId'];
        $tradeOrder = $this->tradeOrderRepo->fetch($orderId);
        if (!$tradeOrder) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('addBudgetEstimate data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataSave = [
            TradeOrder::BUDGET_ESTIMATES            => TradeOrder::BUDGET_ESTIMATES_ADDED,
            TradeOrder::BUDGET_ESTIMATES_ID         => $budgetEstimateId,
            TradeOrder::BUDGET_ESTIMATES_NAME       => $budgetEstimateName
        ];
        $log = [
            TradeOrder::CREATED_BY                  => $data['created_by'],
            TradeOrder::CREATED_AT                  => time(),
            TradeOrder::ACTION                      => TradeOrder::ACTION_UPDATE_BUDGET_ESTIMATES,
            TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_UPDATE_BUDGET_ESTIMATES),
            TradeOrder::STATUS                      => $tradeOrder['status'],
            TradeOrder::PROGRESS                    => $tradeOrder['progress'],
            TradeOrder::STATUS_LABEL                => TradeOrder::$budget_estimates_label[TradeOrder::BUDGET_ESTIMATES_ADDED] . ' - Name: ' . $budgetEstimateName
        ];
        $this->tradeOrderRepo->wlog($orderId, $log);
        if ($update = $this->tradeOrderRepo->updateBudgetEstimatesStatus($orderId, $dataSave)) {
            $response = [
                'data' => $dataSave,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success'),
                'id' => $budgetEstimateId
            ];
            Log::channel('marketing')->info('addBudgetEstimate data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('addBudgetEstimate data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Update customer goal
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function updateCustomerGoal(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('updateCustomerGoal: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('updateCustomerGoal data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'budgetEstimateId'                  => 'required',
            'customer_goal'                     => 'required',
            'created_by'                        => 'required'
        ], [
            'budgetEstimateId.required'         => 'Không xác định được đối tượng',
            'customer_goal.required'            => 'Nội dung không được để trống',
            'created_by.required'               => 'Bạn chưa đăng nhập',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('updateCustomerGoal validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        
        $budgetEstimate = $this->budgetEstimatesRepo->fetch($data['budgetEstimateId']);
        if (!$budgetEstimate) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('updateCustomerGoal data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        if ($this->budgetEstimatesRepo->updateCustomerGoal($data['budgetEstimateId'], $data['customer_goal'])) {
            $log = [
                TradeBudgetEstimates::CREATED_BY      => $data['created_by'],
                TradeBudgetEstimates::CREATED_AT      => time(),
                TradeBudgetEstimates::ACTION          => TradeBudgetEstimates::ACTION_UPDATE_CUSTOMER_GOAL,
                TradeBudgetEstimates::ACTION_LABEL    => TradeBudgetEstimates::actionLabel(TradeBudgetEstimates::ACTION_UPDATE_CUSTOMER_GOAL),
                TradeBudgetEstimates::STATUS          => $budgetEstimate[TradeBudgetEstimates::STATUS],
                TradeBudgetEstimates::PROGRESS        => $budgetEstimate[TradeBudgetEstimates::PROGRESS],
                TradeBudgetEstimates::STATUS_LABEL    => $data['customer_goal']
            ];
            $this->budgetEstimatesRepo->wlog($data['budgetEstimateId'], $log);
            $response = [
                'data' => $data,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success'),
                'id' => $data['budgetEstimateId']
            ];
            Log::channel('marketing')->info('updateCustomerGoal data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('updateCustomerGoal data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * add comment
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function addComment(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('addComment: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('addComment data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'budgetEstimateId'                  => 'required',
            'comment'                           => 'required',
            'created_by'                        => 'required'
        ], [
            'orderId.required'                  => 'Không xác định được đối tượng',
            'comment.required'                  => 'Nội dung không được để trống',
            'created_by.required'               => 'Bạn chưa đăng nhập',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('addComment validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $budgetEstimate = $this->budgetEstimatesRepo->fetch($data['budgetEstimateId']);
        if (!$budgetEstimate) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('addComment data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $log = [
            TradeBudgetEstimates::CREATED_BY      => $data['created_by'],
            TradeBudgetEstimates::CREATED_AT      => time(),
            TradeBudgetEstimates::ACTION          => TradeBudgetEstimates::ACTION_ADD_COMMENT,
            TradeBudgetEstimates::ACTION_LABEL    => TradeBudgetEstimates::actionLabel(TradeBudgetEstimates::ACTION_ADD_COMMENT),
            TradeBudgetEstimates::STATUS          => $budgetEstimate[TradeBudgetEstimates::STATUS],
            TradeBudgetEstimates::PROGRESS        => $budgetEstimate[TradeBudgetEstimates::PROGRESS],
            TradeBudgetEstimates::STATUS_LABEL    => $data['comment']
        ];
        if ($this->budgetEstimatesRepo->wlog($data['budgetEstimateId'], $log)) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success'),
                'id' => $data['budgetEstimateId']
            ];
            Log::channel('marketing')->info('addComment data success: ' . print_r($response, true));
            return response()->json($response);
        }
        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('addComment data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * update progress
     * @param $request Illuminate\Http\Request
     * @return json
     * 
     */
    public function updateProgress(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('TradeBudetEstimate updateProgress: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'id'                                => 'required',
            'status'                            => 'required|in:'.implode(",",TradeBudgetEstimates::$status),
            'isCCOAccept'                       => 'numeric',
            'isMKTAccept'                       => 'numeric',
            'created_by'                        => 'required',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $id = $data['id'];
        $note = !empty($data['note']) ? (PHP_EOL . " - Lý do: " . $data['note']) : "";
        $budgetEstimates = $this->budgetEstimatesRepo->fetch($id);
        if (!$budgetEstimates) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress data errors: ' . print_r($response, true));
            return response()->json($response);
        }

        if (
            $data['status'] == TradeBudgetEstimates::STATUS_CANCLED && (
                $budgetEstimates['progress'] == TradeBudgetEstimates::PROGRESS_GDKD_MKT ||
                $budgetEstimates['progress'] == TradeBudgetEstimates::PROGRESS_CFO
            )
        ) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.inprogress_cannot_cancel')
            ];
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress data errors: ' . print_r($response, true));
            return response()->json($response);
        }

        if(isset($data['isCCOAccept'])) {
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress isCCOAccept');
            $update = $this->budgetEstimatesRepo->update($id, [TradeBudgetEstimates::IS_CCO_ACCEPT => TradeBudgetEstimates::IS_CCO_ACCEPT_OK]);
            if ($update) {
                Log::channel('marketing')->info('TradeBudetEstimate updateProgress isCCOAccept success');
                $log = [
                    TradeBudgetEstimates::CREATED_BY                  => $data['created_by'],
                    TradeBudgetEstimates::CREATED_AT                  => time(),
                    TradeBudgetEstimates::ACTION                      => TradeBudgetEstimates::ACTION_CCO_ACCEPT,
                    TradeBudgetEstimates::ACTION_LABEL                => TradeBudgetEstimates::actionLabel(TradeBudgetEstimates::ACTION_UPDATE_PROGRESS),
                    TradeBudgetEstimates::STATUS                      => $data['status'],
                    TradeBudgetEstimates::PROGRESS                    => $budgetEstimates['progress'],
                    TradeBudgetEstimates::STATUS_LABEL                => 'Tôi đồng thuận.'
                ];
                $this->budgetEstimatesRepo->wlog($id, $log);
            } else {
                $response = [
                    'data' => $data,
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('Marketing::messages.errors')
                ];
                Log::channel('marketing')->info('TradeBudetEstimate updateProgress data errors: ' . print_r($response, true));
                return response()->json($response);
            }

        } else if (isset( $data['isMKTAccept'])) {
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress isMKTAccept');
            $update = $this->budgetEstimatesRepo->update($id, [TradeBudgetEstimates::IS_MKT_ACCEPT => TradeBudgetEstimates::IS_MKT_ACCEPT_OK]);
            if ($update) {
                Log::channel('marketing')->info('TradeBudetEstimate updateProgress isMKTAccept success');
                $log = [
                    TradeBudgetEstimates::CREATED_BY                  => $data['created_by'],
                    TradeBudgetEstimates::CREATED_AT                  => time(),
                    TradeBudgetEstimates::ACTION                      => TradeBudgetEstimates::ACTION_MKT_ACCEPT,
                    TradeBudgetEstimates::ACTION_LABEL                => TradeBudgetEstimates::actionLabel(TradeBudgetEstimates::ACTION_UPDATE_PROGRESS),
                    TradeBudgetEstimates::STATUS                      => $data['status'],
                    TradeBudgetEstimates::PROGRESS                    => $budgetEstimates['progress'],
                    TradeBudgetEstimates::STATUS_LABEL                => 'Tôi đồng thuận.'
                ];
                $this->budgetEstimatesRepo->wlog($id, $log);
            } else {
                $response = [
                'data' => $data,
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('Marketing::messages.errors')
                ];
                Log::channel('marketing')->info('TradeBudetEstimate updateProgress data errors: ' . print_r($response, true));
                return response()->json($response);
            }
        }
        $budgetEstimates = $this->budgetEstimatesRepo->fetch($id); // refresh model'data
        Log::channel('marketing')->info('TradeBudetEstimate updateProgress isMKTAccept: ' . $budgetEstimates[TradeBudgetEstimates::IS_MKT_ACCEPT]);
        Log::channel('marketing')->info('TradeBudetEstimate updateProgress isCCOAccept: ' . $budgetEstimates[TradeBudgetEstimates::IS_CCO_ACCEPT]);
        if ($budgetEstimates['progress'] == TradeBudgetEstimates::PROGRESS_GDKD_MKT && 
            $data['status'] == TradeBudgetEstimates::STATUS_APPROVED && !(
                $budgetEstimates[TradeBudgetEstimates::IS_MKT_ACCEPT] == TradeBudgetEstimates::IS_MKT_ACCEPT_OK && 
                $budgetEstimates[TradeBudgetEstimates::IS_CCO_ACCEPT] == TradeBudgetEstimates::IS_CCO_ACCEPT_OK
            )
        ) {
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress isMKTAccept or isCCOAccept');
            if (isset( $data['isMKTAccept']) || isset( $data['isCCOAccept'])) {
                $response = [
                    'data' => $data,
                    'status' => Response::HTTP_OK,
                    'message' => __('Marketing::messages.success')
                ];
                Log::channel('marketing')->info('TradeBudetEstimate updateProgress data success: ' . print_r($response, true));
                return response()->json($response);
            } else {
                $response = [
                    'data' => $data,
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('Marketing::messages.cco_and_mkt_not_confirmed_yet')
                ];
                Log::channel('marketing')->info('TradeBudetEstimate updateProgress data success: ' . print_r($response, true));
                return response()->json($response);
            }
            
        } else {
            $nextStep = TradeBudgetEstimates::getNextStep($data['status'], $budgetEstimates['progress']);
            if ($nextStep['progress'] < TradeBudgetEstimates::PROGRESS_GDKD_MKT) {
                // reset đồng thuận của GDKD và MKT
                $update = $this->budgetEstimatesRepo->update($id, [
                    TradeBudgetEstimates::IS_MKT_ACCEPT => TradeBudgetEstimates::IS_MKT_ACCEPT_NO,
                    TradeBudgetEstimates::IS_CCO_ACCEPT => TradeBudgetEstimates::IS_CCO_ACCEPT_NO
                ]);
            } else if (
                $nextStep['progress'] == TradeBudgetEstimates::PROGRESS_CFO && 
                $nextStep['status'] == TradeBudgetEstimates::STATUS_WAIT_APPROVE
            ) {
                $date = time();
                $update = $this->budgetEstimatesRepo->update($id, [
                    TradeBudgetEstimates::DATE => $date,
                ]);
                Log::channel('marketing')->info('TradeBudetEstimate update BE date: ' . $date);
            }
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress nextStep: ' . print_r($nextStep, true));
            $dataSave = [
                TradeBudgetEstimates::STATUS                      => $nextStep['status'],
                TradeBudgetEstimates::PROGRESS                    => $nextStep['progress'],
                TradeBudgetEstimates::UPDATED_BY                  => $data['created_by'],
            ];
            if ($update = $this->budgetEstimatesRepo->updateProgress($id, $dataSave)) {
                $log = [
                    TradeBudgetEstimates::CREATED_BY                  => $data['created_by'],
                    TradeBudgetEstimates::CREATED_AT                  => time(),
                    TradeBudgetEstimates::ACTION                      => TradeBudgetEstimates::ACTION_UPDATE_PROGRESS,
                    TradeBudgetEstimates::ACTION_LABEL                => TradeBudgetEstimates::actionLabel(TradeBudgetEstimates::ACTION_UPDATE_PROGRESS),
                    TradeBudgetEstimates::STATUS                      => $data['status'],
                    TradeBudgetEstimates::PROGRESS                    => $budgetEstimates['progress'],
                    TradeBudgetEstimates::STATUS_LABEL                => TradeBudgetEstimates::StatusLabel($data['status'], $budgetEstimates['progress']) . $note
                ];
                $this->budgetEstimatesRepo->wlog($id, $log);
                Log::channel('marketing')->info('TradeBudetEstimate updateProgress: ' . print_r($log, true));
                if ($dataSave[TradeBudgetEstimates::STATUS] == TradeBudgetEstimates::STATUS_CANCLED) {
                    $this->tradeOrderRemoveBE($id, $data);
                } else {
                    $this->tradeOrderUpdateProgress($id, $dataSave);
                }
                $response = [
                    'data' => $dataSave,
                    'status' => Response::HTTP_OK,
                    'message' => __('Marketing::messages.success')
                ];
                $detail = $this->budgetEstimatesRepo->fetch($id);

                if ($detail[TradeBudgetEstimates::STATUS] == TradeBudgetEstimates::STATUS_WAIT_APPROVE) {
                    //gửi cho CFO
                    if ($detail[TradeBudgetEstimates::IS_MKT_ACCEPT] == TradeBudgetEstimates::IS_MKT_ACCEPT_OK && 
                        $detail[TradeBudgetEstimates::IS_CCO_ACCEPT] == TradeBudgetEstimates::IS_CCO_ACCEPT_OK &&
                        $detail[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CFO
                    ) {
                        $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/budget-estimates/detail/" . "$id";
                        $user = config('marketing.CFO');
                        $dataSendEmail = [
                            'user' => array_unique($user),
                            'plan_name' => $detail['name'],
                            'url' => $url,
                        ];
                        $sendMail = MarketingApi::sendEmailToManager($dataSendEmail);
                    }

                    //Gửi cho gdkd và tpmkt
                    if ($detail[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_GDKD_MKT) {
                        $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/budget-estimates/detail/" . "$id";
                        $gdkd = $this->groupRoleRepository->getEmailGDKD();
                        $tpMkt = $this->roleRepository->getTPMKT();
                        $user = array_merge($gdkd, $tpMkt);
                        $dataSendEmail = [
                            'user' => array_unique($user),
                            'plan_name' => $detail['name'],
                            'url' => $url,
                        ];
                        $sendMail = MarketingApi::sendEmailToGdkdMkt($dataSendEmail);
                    }

                    //CFO gửi Trade
                    if ($detail[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CEO) {
                        $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/budget-estimates/detail/" . "$id";
                        $user = $this->groupRoleRepository->getEmailTradeMKT();
                        $dataSendEmail = [
                            'user' => array_unique($user),
                            'plan_name' => $detail['name'],
                            'url' => $url,
                        ];
                        $sendMail = MarketingApi::sendEmailToCeo($dataSendEmail);
                    }
                }

                if ($detail[TradeBudgetEstimates::STATUS] == TradeBudgetEstimates::STATUS_RETURNED) {
                    //CFO, gdkd hoặc mkt trả về cho trade
                    if ($detail[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CREATE_NEW) {
                        $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/budget-estimates/detail/" . "$id";
                        $user = $this->groupRoleRepository->getEmailTradeMKT();
                        $dataSendEmail = [
                            'user' => array_unique($user),
                            'plan_name' => $detail['name'],
                            'url' => $url,
                        ];
                        $sendMail = MarketingApi::sendRequestOrderReturn($dataSendEmail);
                    }

                }
                //Trade duyệt thay CEO gửi HCNS ()
                if ($detail[TradeBudgetEstimates::STATUS] == TradeBudgetEstimates::STATUS_APPROVED &&
                    $detail[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CEO
                ) {
                    $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/budget-estimates/detail/" . "$id";
                    $user = config('marketing.HCNS');
                    $dataSendEmail = [
                        'user' => array_unique($user),
                        'plan_name' => $detail['name'],
                        'url' => $url,
                    ];
                    $sendMail = MarketingApi::sendEmailToHcns($dataSendEmail);
                }


                //CEO cancel
                if ($detail[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CEO &&
                    $detail[TradeBudgetEstimates::STATUS] == TradeBudgetEstimates::STATUS_CANCLED
                ) {
                    $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/budget-estimates/detail/" . "$id";
                    // $record = $this->tradeOrderRepo->findRecordByBudgetEstimatesId($data['id']);
                    // $arrAsm = [];
                    // $arrRsm = [];
                    // foreach ($record as $key => $value) {
                    //     $asm = $this->roleRepository->findAsmByStoreId($value['store_id']);
                    //     $rsm = $this->roleRepository->findRsmByStoreId($value['store_id']);
                    //     $arrAsm+=$asm;
                    //     $arrRsm+=$rsm;
                    // }
                    $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
                    $gdkd = $this->groupRoleRepository->getEmailGDKD();
                    $tpMkt = $this->roleRepository->getTPMKT();
                    $cfo = config('marketing.CFO');
                    $user = array_merge($tradeMkt, $gdkd, $tpMkt, $cfo);
                    $dataSendEmail = [
                        'user' => array_unique($user),
                        'plan_name' => $detail['name'],
                        'url' => $url,
                    ];
                    $sendMail = MarketingApi::sendRequestOrderCancel($dataSendEmail);
                }

                Log::channel('marketing')->info('TradeBudetEstimate updateProgress data success: ' . print_r($response, true));
                return response()->json($response);
            }
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.errors')
            ];
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        
    }

    /**
     * remove trade order from budget estimate collection
     * @param $budgetEstimateId string
     * @return void
     * */
    protected function tradeOrderRemoveBE($budgetEstimateId, $data) {
        $tradeOrders = $this->tradeOrderRepo->fetchItemsByBudgetEstimateId($budgetEstimateId);
        foreach($tradeOrders as $tradeOrder) {
            $removeData = [
                TradeOrder::BUDGET_ESTIMATES            => TradeOrder::BUDGET_ESTIMATES_REMOVED,
                TradeOrder::PROGRESS => TradeOrder::PROGRESS_GDKD_MKT,
            ];
            $remove = $this->tradeOrderRepo->updateBudgetEstimatesStatus($tradeOrder['_id'], $removeData);
            Log::channel('marketing')->info('TradeBudetEstimate updateProgress tradeOrder BE ID : ' . $tradeOrder['_id']);
            $log = [
                TradeOrder::CREATED_BY                  => $data['created_by'],
                TradeOrder::CREATED_AT                  => time(),
                TradeOrder::ACTION                      => TradeOrder::ACTION_UPDATE_BUDGET_ESTIMATES,
                TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_UPDATE_BUDGET_ESTIMATES),
                TradeOrder::STATUS                      => $tradeOrder['status'],
                TradeOrder::PROGRESS                    => $tradeOrder['progress'],
                TradeOrder::STATUS_LABEL                => TradeOrder::$budget_estimates_label[TradeOrder::BUDGET_ESTIMATES_REMOVED] . ' - Name: ' . $tradeOrder[TradeOrder::BUDGET_ESTIMATES_NAME]
            ];
            $this->tradeOrderRepo->wlog($tradeOrder['_id'], $log);
        }
    }

    /**
     * remove trade order from budget estimate collection
     * @param $budgetEstimateId string
     * @return void
     * */
    protected function tradeOrderUpdateProgress($budgetEstimateId, $data) {
        if ($data['progress'] == TradeBudgetEstimates::PROGRESS_GDKD_MKT) {
            return;
        } else if ($data['status'] == TradeBudgetEstimates::STATUS_RETURNED) {
            $data['progress'] = TradeOrder::PROGRESS_GDKD_MKT;
            $data['status'] = TradeOrder::STATUS_WAIT_APPROVE;
        } else if (
            $data['status'] == TradeBudgetEstimates::STATUS_APPROVED && 
            $data['progress'] = TradeBudgetEstimates::PROGRESS_CEO
        ) {
            $data['progress'] = TradeOrder::PROGRESS_HCNS_BUYING;
            $data['status'] = TradeOrder::STATUS_WAIT_APPROVE;
        }

        $tradeOrderSave = [
            TradeOrder::PROGRESS                    => $data['progress'],
            TradeOrder::UPDATED_BY                  => $data['updated_by'],
            TradeOrder::STATUS                      => TradeOrder::STATUS_WAIT_APPROVE
        ];
        if ($data['progress'] == TradeOrder::PROGRESS_HCNS_BUYING) {
            // save ceo has accepted time
            $tradeOrderSave[TradeOrder::CEO_ACCEPTED_TIME] = time();
        }
        $tradeOrders = $this->tradeOrderRepo->fetchItemsByBudgetEstimateId($budgetEstimateId);
        foreach($tradeOrders as $tradeOrder) {
            $this->tradeOrderRepo->update($tradeOrder['_id'], $tradeOrderSave);
            $log = [
                TradeOrder::CREATED_BY                  => $data['updated_by'],
                TradeOrder::CREATED_AT                  => time(),
                TradeOrder::ACTION                      => TradeOrder::ACTION_UPDATE_PROGRESS,
                TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_UPDATE_PROGRESS),
                TradeOrder::STATUS                      => $data['status'],
                TradeOrder::PROGRESS                    => $data['progress'],
                TradeOrder::STATUS_LABEL                => TradeOrder::StatusLabel($data['status'], $data['progress'])
            ];
            $this->tradeOrderRepo->wlog($tradeOrder['_id'], $log);
            Log::channel('marketing')->info('TradeBudetEstimate tradeOrder updateProgress: ' . print_r($log, true));
        }
    }

    /**
     * delete order
     * @param $request Illuminate\Http\Request
     * @return json
     * 
     */
    public function deleteBE(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('deleteBE: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('deleteBE data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'id'                                => 'required',
            'reason'                            => 'required',
            'created_by'                        => 'required',
        ], [
            'reason.required'                   => 'Vui lòng nhập lý do xoá',
            'id.required'                       => 'Không xác định được đối tượng xoá',
            'created_by.required'               => 'Bạn chưa đăng nhập',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('deleteBE validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $id = $data['id'];
        $be = $this->budgetEstimatesRepo->fetch($id);
        if (!$be) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('deleteBE data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataSave = [
            TradeBudgetEstimates::DELETED_REASON                  => $data['reason'],
        ];
        $log = [
            TradeBudgetEstimates::CREATED_BY                  => $data['created_by'],
            TradeBudgetEstimates::CREATED_AT                  => time(),
            TradeBudgetEstimates::ACTION                      => TradeBudgetEstimates::ACTION_DELETE,
            TradeBudgetEstimates::ACTION_LABEL                => TradeBudgetEstimates::actionLabel(TradeBudgetEstimates::ACTION_DELETE),
            TradeBudgetEstimates::STATUS                      => $be['status'],
            TradeBudgetEstimates::PROGRESS                    => $be['progress'],
            TradeBudgetEstimates::STATUS_LABEL                => 'Xoá dự toán ngân sách'
        ];
        $this->budgetEstimatesRepo->wlog($id, $log);
        if ($update = $this->budgetEstimatesRepo->delete($id, $dataSave)) {
            $response = [
                'data' => $dataSave,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success')
            ];
            Log::channel('marketing')->info('deleteBE data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('deleteBE data errors: ' . print_r($response, true));
        return response()->json($response);
    }
}
