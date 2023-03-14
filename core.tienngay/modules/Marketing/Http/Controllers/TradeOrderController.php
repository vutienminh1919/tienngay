<?php

namespace Modules\Marketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\MongodbCore\Repositories\Interfaces\TradeOrderRepositoryInterface as TradeOrderRepository;
use Modules\MongodbCore\Entities\TradeOrder;
use Modules\MongodbCore\Entities\TradeStorage;
use Modules\MongodbCore\Entities\TradeHistory;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepo;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface as TradeStorageRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface as TradeHistoryRepository;
use Modules\Marketing\Service\MarketingApi;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\GroupRoleRepository;

class TradeOrderController extends BaseController
{

    /**
     * Modules\MongodbCore\Repositories\TradeOrderRepository
     * */
    private $tradeOrderRepo;

    /**
     * Modules\MongodbCore\Repositories\StoreRepository
     * */
    private $storeRepo;

    /**
     * Modules\MongodbCore\Repositories\TradeItemRepository
     * */
    private $tradeItemRepo;

    /**
     * Modules\MongodbCore\Repositories\TradeStorageRepository
     * */
    private $tradeStorageRepo;

    /**
     * Modules\MongodbCore\Repositories\TradeHistoryRepository
     * */
    private $tradeHistoryRepo;

    private $roleRepository;
    private $groupRoleRepository;
     /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Order Trade Item"
     * )
     */
    public function __construct(
        TradeOrderRepository $tradeOrderRepository,
        StoreRepo            $storeRepo,
        TradeItemRepository  $tradeItemRepo,
        TradeStorageRepository $tradeStorageRepo,
        TradeHistoryRepository $tradeHistoryRepo,
        RoleRepository  $roleRepository,
        GroupRoleRepository $groupRoleRepository
    ) {
        $this->tradeOrderRepo = $tradeOrderRepository;
        $this->storeRepo = $storeRepo;
        $this->tradeItemRepo = $tradeItemRepo;
        $this->tradeStorageRepo = $tradeStorageRepo;
        $this->tradeHistoryRepo = $tradeHistoryRepo;
        $this->roleRepository = $roleRepository;
        $this->groupRoleRepository = $groupRoleRepository;
    }

    /**
     * request order trade's item
     * @param $request Illuminate\Http\Request
     * @return json
     * 
     */
    public function requestOrder(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('requestOrder: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('requestOrder data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'store_id'                          => 'required',
            'plan_name'                         => 'required',
            'plan_file'                         => 'required',
            'created_by'                        => 'required',
            'motivating_goal'                   => 'required|array',
            'items'                             => 'required|array|min:1',
            'items.*.category'                  => 'required|in:'.implode(',', TradeOrder::$categoriesValue),
            'items.*.implementation_goal'       => 'required|in:'.implode(',', TradeOrder::$implementationGoalsValue),
            'items.*.item_id'                   => 'required|string',
            'items.*.item_quantity'             => 'required|numeric|min:1',
            'items.*.item_area'                 => 'required|string',
            'items.*.item_target_customers'     => 'required',
        ], [
            'store_id.required'                          => 'Phòng giao dịch không được để trống',
            'plan_name.required'                         => 'Tên kế hoạch không được để trống',
            'plan_file.required'                         => 'Chưa upload file chi tiết kế hoạch',
            'created_by.required'                        => 'Tên người tạo không được để trống',
            'motivating_goal.required'                   => 'Mục tiêu thúc đẩy không được để trống',
            'motivating_goal.array'                      => 'Mục tiêu thúc đẩy không đúng định dạng mảng',
            'items.required'                             => 'Không có ấn phẩm nào được chọn',
            'items.*.category.required'                  => 'Hạng mục không được để trống',
            'items.*.implementation_goal.required'       => 'Mục tiêu triển khai không được để trống',
            'items.*.item_id.required'                   => 'Tên ấn phẩm không được để trống',
            'items.*.item_quantity.required'             => 'Số lượng ấn phẩm không được để trống',
            'items.*.item_area.required'                 => 'Khu vực triển khai không được để trống',
            'items.*.item_target_customers.required'     => 'Mục tiêu khách hàng không được để trống',
            'items.*.category.in'                        => 'Hạng mục được trọn không có trong danh mục cho phép',
            'items.*.implementation_goal.in'             => 'Mục tiêu triển khai được chọn không có trong danh mục cho phép',
            'items.*.item_quantity.numeric'              => 'Số lượng ấn phẩm phải là số',
            'items.*.item_quantity.in'                   => 'Số lượng ấn phẩm tối thiểu là 1',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('requestOrder validate failed: ' . print_r($response, true));
            return response()->json($response);
        }

        $errors = [];
        $storeName = $this->storeRepo->getStoreName($data['store_id']);
        $storeCodeArea = $this->storeRepo->getStoreCodeArea($data['store_id']);
        if (!$storeName) {
            $errors['store_id'] = ['Phòng giao dịch không có trong danh mục cho phép'];
        }

        $dataSave = [
            TradeOrder::STORE_ID                => $data['store_id'],
            TradeOrder::STORE_NAME              => $storeName,
            TradeOrder::STORE_CODE_AREA         => $storeCodeArea,
            TradeOrder::PLAN_NAME               => $data['plan_name'],
            TradeOrder::PLAN_FILE               => $data['plan_file'],
            TradeOrder::MOTIVATING_GOAL         => $data['motivating_goal'],
            TradeOrder::CREATED_BY              => $data['created_by'],
            TradeOrder::UPDATED_BY              => $data['created_by'],
        ];
        foreach($data['items'] as $key => $value) {
            $tradeItem = $this->tradeItemRepo->detailItem($value['item_id']);
            if (empty($tradeItem)) {
                $errors['items.'.$key.'.item_id'] = ['Tên ấn phẩm không có trong danh mục cho phép'];
                continue;
            }
            $id = time() . $key;
            $item = [
                TradeOrder::ITEM_KEY                => $id,
                TradeOrder::CATEGORY                => $value['category'],
                TradeOrder::IMPLEMENTATION_GOAL     => $value['implementation_goal'],
                TradeOrder::ITEM_ID                 => $value['item_id'],
                TradeOrder::ITEM_CODE               => $tradeItem['item_id'],
                TradeOrder::ITEM_NAME               => $tradeItem['detail']['name'],
                TradeOrder::ITEM_TYPE               => $tradeItem['detail']['type'],
                TradeOrder::ITEM_SPECIFICATIONS     => $tradeItem['detail']['specification'],
                TradeOrder::ITEM_PATH               => $tradeItem['path'],
                TradeOrder::ITEM_EXPEC_PRICE        => $tradeItem['detail']['price'],
                TradeOrder::ITEM_QUANTITY           => (int)$value['item_quantity'],
                TradeOrder::ITEM_AREA               => $value['item_area'],
                TradeOrder::ITEM_TARGET_CUSTOMERS   => $value['item_target_customers'],
                TradeOrder::ITEM_RECEIVED_AMOUNT   => 0
            ];
            $dataSave[TradeOrder::ITEMS][] = $item;
        }
        if (!empty($errors)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.errors'),
                'data' => $data,
                'errors' => $errors
            ];
            Log::channel('marketing')->info('requestOrder validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $log = [
            TradeOrder::CREATED_BY                  => $data['created_by'],
            TradeOrder::CREATED_AT                  => time(),
            TradeOrder::ACTION                      => TradeOrder::ACTION_CREATE,
            TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_CREATE),
            TradeOrder::STATUS                      => TradeOrder::STATUS_NEW,
            TradeOrder::PROGRESS                    => TradeOrder::PROGRESS_PGD_CREATE,
            TradeOrder::STATUS_LABEL                => TradeOrder::StatusLabel(TradeOrder::STATUS_NEW, TradeOrder::PROGRESS_PGD_CREATE)
        ];
        $dataSave[TradeOrder::LOGS][] = $log;
        if ($create = $this->tradeOrderRepo->store($dataSave)) {
            $response = [
                'data' => $create,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success')
            ];
            Log::channel('marketing')->info('requestOrder data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('requestOrder data errors: ' . print_r($response, true));
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
        Log::channel('marketing')->info('updateProgress: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('updateProgress data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'id'                                => 'required',
            'status'                            => 'required|in:'.implode(",",TradeOrder::$status),
            'created_by'                        => 'required',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('updateProgress validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $id = $data['id'];
        $note = !empty($data['note']) ? (PHP_EOL . " - Lý do: " . $data['note']) : "";
        $tradeOrder = $this->tradeOrderRepo->fetch($id);
        if (!$tradeOrder) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('updateProgress data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $nextStep = TradeOrder::getNextStep($data['status'], $tradeOrder['progress']);
        $dataSave = [
            TradeOrder::STATUS                      => $nextStep['status'],
            TradeOrder::PROGRESS                    => $nextStep['progress'],
            TradeOrder::UPDATED_BY                  => $data['created_by'],
        ];
        $statusLabel = TradeOrder::StatusLabel($data['status'], $tradeOrder['progress']) . $note;
        if (
            $data['status'] == TradeOrder::STATUS_CANCLED && 
            $tradeOrder[TradeOrder::STATUS] == TradeOrder::STATUS_RETURNED
        ) {
            $dataSave[TradeOrder::PROGRESS] = $dataSave[TradeOrder::PROGRESS] - 1;
            if ($dataSave[TradeOrder::PROGRESS] < TradeOrder::PROGRESS_PGD_CREATE) {
                $dataSave[TradeOrder::PROGRESS] = TradeOrder::PROGRESS_PGD_CREATE;
            }
            $statusLabel = TradeOrder::StatusLabel($data['status'], $dataSave[TradeOrder::PROGRESS]) . $note;
        }

        if ($update = $this->tradeOrderRepo->updateProgress($id, $dataSave)) {
            $log = [
                TradeOrder::CREATED_BY                  => $data['created_by'],
                TradeOrder::CREATED_AT                  => time(),
                TradeOrder::ACTION                      => TradeOrder::ACTION_UPDATE_PROGRESS,
                TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_UPDATE_PROGRESS),
                TradeOrder::STATUS                      => $data['status'],
                TradeOrder::PROGRESS                    => $tradeOrder['progress'],
                TradeOrder::STATUS_LABEL                => $statusLabel
            ];
            $this->tradeOrderRepo->wlog($id, $log);
            $detail = $this->tradeOrderRepo->fetch($id);
            //phiếu được duyệt
            if ($detail[TradeOrder::STATUS] == TradeOrder::STATUS_WAIT_APPROVE) {
                //tpgd tạo gửi duyệt cho asm
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_ASM) {
                    $user = $this->roleRepository->findAsmByStoreId($detail['store_id']);
                }
                //asm ấn duyệt gửi rsm
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_RSM) {
                    $user = $this->roleRepository->findRsmByStoreId($detail['store_id']);
                }
                //rsm ấn duyệt gửi trade
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_GDKD_MKT) {
                    $user = $this->groupRoleRepository->getEmailTradeMKT();
                }
                $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/trade-order/detail/" . "$id";
                $dataSendEmail = [
                    'user' => array_unique($user),
                    'store_name' => $detail['store_name'],
                    'plan_name' => $detail['plan_name'],
                    'url' => $url
                ];
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_ASM) {
                    $sendMail = MarketingApi::sendRequestOrder($dataSendEmail);
                }  
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_RSM || $detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_GDKD_MKT) {
                    $sendMail = MarketingApi::sendConfirmRequestOrder($dataSendEmail);
                }
            }


            // phiếu bị trả về
            if ($detail[TradeOrder::STATUS] == TradeOrder::STATUS_RETURNED) {
                //asm trả về cho tpgd
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_ASM) {
                    $user = $this->roleRepository->getChtByStoreId($detail['store_id']);
                }
                //rsm trả về cho asm
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_RSM) {
                    $user = $this->roleRepository->findAsmByStoreId($detail['store_id']);
                }
                //trade trả về cho rsm
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_GDKD_MKT) {
                    $user = $this->roleRepository->findRsmByStoreId($detail['store_id']);
                }        
                $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/trade-order/detail/" . "$id";
                $dataSendEmail = [
                    'user' => array_unique($user),
                    'store_name' => $detail['store_name'],
                    'plan_name' => $detail['plan_name'],
                    'url' => $url
                ];
                $sendMail = MarketingApi::sendRequestOrderReturn($dataSendEmail);
            }

            //phiếu bị hủy bỏ
            if ($detail[TradeOrder::STATUS] == TradeOrder::STATUS_CANCLED && $detail[TradeOrder::PROGRESS] != TradeOrder::PROGRESS_PGD_CREATE) {
                //asm hủy gửi đến tpgd
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_ASM) {
                    $user = $this->roleRepository->getChtByStoreId($detail['store_id']);
                }
                //rsm hủy gửi đến asm, tpgd
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_RSM) {
                    $tpgd = $this->roleRepository->getChtByStoreId($detail['store_id']);
                    $asm = $this->roleRepository->findAsmByStoreId($detail['store_id']);
                    $user = array_merge($tpgd, $asm);
                }
                if ($detail[TradeOrder::PROGRESS] == TradeOrder::PROGRESS_GDKD_MKT) {
                    $tpgd = $this->roleRepository->getChtByStoreId($detail['store_id']);
                    $asm = $this->roleRepository->findAsmByStoreId($detail['store_id']);
                    $rsm = $this->roleRepository->findRsmByStoreId($detail['store_id']);
                    $user = array_merge($tpgd, $asm, $rsm);
                }
                $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/trade-order/detail/" . "$id";
                $dataSendEmail = [
                    'user' => array_unique($user),
                    'store_name' => $detail['store_name'],
                    'plan_name' => $detail['plan_name'],
                    'url' => $url
                ];
                $sendMail = MarketingApi::sendRequestOrderCancel($dataSendEmail);
            }
 
            $response = [
                'data' => $dataSave,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success')
            ];
            Log::channel('marketing')->info('updateProgress data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('updateProgress data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * request order trade's item
     * @param $request Illuminate\Http\Request
     * @return json
     * 
     */
    public function updateOrder(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('updateOrder: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('updateOrder data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'store_id'                          => 'required',
            'id'                                => 'required',
            'plan_name'                         => 'required',
            'plan_file'                         => 'required',
            'created_by'                        => 'required',
            'motivating_goal'                   => 'required|array',
            'items'                             => 'required|array|min:1',
            'items.*.category'                  => 'required|in:'.implode(',', TradeOrder::$categoriesValue),
            'items.*.implementation_goal'       => 'required|in:'.implode(',', TradeOrder::$implementationGoalsValue),
            'items.*.item_id'                   => 'required|string',
            'items.*.item_quantity'             => 'required|numeric|min:1',
            'items.*.item_area'                 => 'required|string',
            'items.*.item_target_customers'     => 'required',
        ], [
            'id.required'                                => 'ID yêu cầu ấn phẩm không được để trống',
            'store_id.required'                          => 'Phòng giao dịch không được để trống',
            'plan_name.required'                         => 'Tên kế hoạch không được để trống',
            'plan_file.required'                         => 'Chưa upload file chi tiết kế hoạch',
            'created_by.required'                        => 'Tên người tạo không được để trống',
            'motivating_goal.required'                   => 'Mục tiêu thúc đẩy không được để trống',
            'motivating_goal.array'                      => 'Mục tiêu thúc đẩy không đúng định dạng mảng',
            'items.required'                             => 'Không có ấn phẩm nào được chọn',
            'items.*.category.required'                  => 'Hạng mục không được để trống',
            'items.*.implementation_goal.required'       => 'Mục tiêu triển khai không được để trống',
            'items.*.item_id.required'                   => 'Tên ấn phẩm không được để trống',
            'items.*.item_quantity.required'             => 'Số lượng ấn phẩm không được để trống',
            'items.*.item_area.required'                 => 'Khu vực triển khai không được để trống',
            'items.*.item_target_customers.required'     => 'Mục tiêu khách hàng không được để trống',
            'items.*.category.in'                        => 'Hạng mục được trọn không có trong danh mục cho phép',
            'items.*.implementation_goal.in'             => 'Mục tiêu triển khai được chọn không có trong danh mục cho phép',
            'items.*.item_quantity.numeric'              => 'Số lượng ấn phẩm phải là số',
            'items.*.item_quantity.in'                   => 'Số lượng ấn phẩm tối thiểu là 1',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('updateOrder validate failed: ' . print_r($response, true));
            return response()->json($response);
        }

        $errors = [];
        $storeName = $this->storeRepo->getStoreName($data['store_id']);
        $storeCodeArea = $this->storeRepo->getStoreCodeArea($data['store_id']);
        if (!$storeName) {
            $errors['store_id'] = ['Phòng giao dịch không có trong danh mục cho phép'];
        }
        $id = $data['id'];
        $tradeOrder = $this->tradeOrderRepo->fetch($id);
        if (!$tradeOrder) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('updateProgress data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataSave = [
            TradeOrder::STORE_ID                => $data['store_id'],
            TradeOrder::STORE_NAME              => $storeName,
            TradeOrder::STORE_CODE_AREA         => $storeCodeArea,
            TradeOrder::PLAN_NAME               => $data['plan_name'],
            TradeOrder::PLAN_FILE               => $data['plan_file'],
            TradeOrder::MOTIVATING_GOAL         => $data['motivating_goal'],
            TradeOrder::UPDATED_BY              => $data['created_by'],
        ];
        foreach($data['items'] as $key => $value) {
            $tradeItem = $this->tradeItemRepo->detailItem($value['item_id']);
            if (empty($tradeItem)) {
                $errors['items.'.$key.'.item_id'] = ['Tên ấn phẩm không có trong danh mục cho phép'];
                continue;
            }
            $item = [
                TradeOrder::ITEM_KEY                => (string)$key,
                TradeOrder::CATEGORY                => $value['category'],
                TradeOrder::IMPLEMENTATION_GOAL     => $value['implementation_goal'],
                TradeOrder::ITEM_ID                 => $value['item_id'],
                TradeOrder::ITEM_CODE               => $tradeItem['item_id'],
                TradeOrder::ITEM_NAME               => $tradeItem['detail']['name'],
                TradeOrder::ITEM_TYPE               => $tradeItem['detail']['type'],
                TradeOrder::ITEM_SPECIFICATIONS     => $tradeItem['detail']['specification'],
                TradeOrder::ITEM_PATH               => $tradeItem['path'],
                TradeOrder::ITEM_EXPEC_PRICE        => $tradeItem['detail']['price'],
                TradeOrder::ITEM_QUANTITY           => (int)$value['item_quantity'],
                TradeOrder::ITEM_AREA               => $value['item_area'],
                TradeOrder::ITEM_TARGET_CUSTOMERS   => $value['item_target_customers'],
                TradeOrder::ITEM_RECEIVED_AMOUNT   => 0
            ];
            $dataSave[TradeOrder::ITEMS][] = $item;
        }
        if (!empty($errors)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.errors'),
                'data' => $data,
                'errors' => $errors
            ];
            Log::channel('marketing')->info('updateOrder validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        if ($update = $this->tradeOrderRepo->update($id, $dataSave)) {
            $log = [
                TradeOrder::CREATED_BY                  => $data['created_by'],
                TradeOrder::CREATED_AT                  => time(),
                TradeOrder::ACTION                      => TradeOrder::ACTION_UPDATE,
                TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_UPDATE),
                TradeOrder::STATUS                      => $tradeOrder[TradeOrder::STATUS],
                TradeOrder::PROGRESS                    => $tradeOrder[TradeOrder::PROGRESS],
                TradeOrder::STATUS_LABEL                => 'Cập nhật thông tin yêu cầu ấn phẩm'
            ];
            $this->tradeOrderRepo->wlog($id, $log);
            $response = [
                'data' => $dataSave,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success')
            ];
            Log::channel('marketing')->info('updateOrder data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('updateOrder data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * delete order
     * @param $request Illuminate\Http\Request
     * @return json
     * 
     */
    public function deleteOrder(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('deleteOrder: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('deleteOrder data is not an array: ' . print_r($response, true));
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
            Log::channel('marketing')->info('deleteOrder validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $id = $data['id'];
        $tradeOrder = $this->tradeOrderRepo->fetch($id);
        if (!$tradeOrder) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('deleteOrder data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataSave = [
            TradeOrder::DELETED_REASON                  => $data['reason'],
        ];
        $log = [
            TradeOrder::CREATED_BY                  => $data['created_by'],
            TradeOrder::CREATED_AT                  => time(),
            TradeOrder::ACTION                      => TradeOrder::ACTION_DELETE,
            TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_DELETE),
            TradeOrder::STATUS                      => $tradeOrder['status'],
            TradeOrder::PROGRESS                    => $tradeOrder['progress'],
            TradeOrder::STATUS_LABEL                => 'Xoá yêu cầu ấn phẩm'
        ];
        $this->tradeOrderRepo->wlog($id, $log);
        if ($update = $this->tradeOrderRepo->delete($id, $dataSave)) {
            $response = [
                'data' => $dataSave,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success')
            ];
            Log::channel('marketing')->info('deleteOrder data success: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('deleteOrder data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * confirm item's allotment then put item into storage
     * @param $request Illuminate\Http\Request
     * @return json
     * 
     */
    public function confirmedAllotment(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('confirmedAllotment: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('confirmedAllotment data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'id'                                => 'required',
            'created_by'                        => 'required',
            'item_key'                          => 'required',
            'item_path'                         => 'required',
        ], [
            'id.required'                       => 'Không xác định được đối nhập kho',
            'created_by.required'               => 'Bạn chưa đăng nhập',
            'item_key.required'                 => 'Không xác định được đối nhập kho',
            'item_path.required'                => 'Bạn chưa upload chứng từ',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('confirmedAllotment validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $id = $data['id'];
        $itemKey = $data['item_key'];
        $tradeOrder = $this->tradeOrderRepo->fetch($id);
        $allotment = $this->tradeOrderRepo->fetchAllotment($id, $itemKey);
        if (empty($allotment) || empty($tradeOrder)) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.not_found')
            ];
            Log::channel('marketing')->info('confirmedAllotment data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        if (
            isset($allotment[TradeOrder::ALLOTMENT_IS_CONFIRMED]) && 
            $allotment[TradeOrder::ALLOTMENT_IS_CONFIRMED] == TradeOrder::ALLOTMENT_CONFIRMED
        ) {
            $response = [
                'data' => $data,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.allotment_is_confirmed')
            ];
            Log::channel('marketing')->info('confirmedAllotment data errors: ' . print_r($response, true));
            return response()->json($response);
        }
        $allotment[TradeOrder::UPDATED_AT] = time();
        $allotment[TradeOrder::CONFIRMED_AT] = time();
        $allotment[TradeOrder::CONFIRMED_BY] = $data['created_by'];
        $allotment[TradeOrder::ALLOTMENT_PATH] = $data['item_path'];
        $allotment[TradeOrder::ALLOTMENT_IS_CONFIRMED] = TradeOrder::ALLOTMENT_CONFIRMED;

        if ($update = $this->tradeOrderRepo->updateAllotment($id, $allotment)) {
            $storage = $this->tradeStorageRepo->getItemByStoreId($tradeOrder[TradeOrder::STORE_ID]);

            $requestItem = $this->tradeOrderRepo->fetchRequestItem($id, $allotment[TradeOrder::ITEM_CODE]);
            $amount = $allotment[TradeOrder::ALLOTMENT_QUANTITY];
            $this->saveItemToStorage($tradeOrder[TradeOrder::STORE_ID], $requestItem, $amount, $allotment);
            $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/trade-order/detail/" . "$id";
            $namePGD = $this->storeRepo->getStoreName($tradeOrder['store_id']);
            $requestItem['store_name'] = $namePGD;
            $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
            $tpMkt = $this->roleRepository->getTPMKT();
            $user = array_merge($tradeMkt, $tpMkt);
            $dataSendEmail = [
                'publication' => $requestItem,
                'user' => array_unique($user),
                'url' => $url,
                'flag' => '6',
            ];
            $sendMail = MarketingApi::sendEmailPublication($dataSendEmail);
            

            $log = [
                TradeOrder::CREATED_BY                  => $data['created_by'],
                TradeOrder::CREATED_AT                  => time(),
                TradeOrder::ACTION                      => TradeOrder::ACTION_ALLOTMENT_CONFIRMED,
                TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_ALLOTMENT_CONFIRMED),
                TradeOrder::STATUS                      => $tradeOrder[TradeOrder::STATUS],
                TradeOrder::PROGRESS                    => $tradeOrder[TradeOrder::PROGRESS],
                TradeOrder::STATUS_LABEL                => "Nhập ấn phẩm '".$allotment[TradeOrder::ITEM_NAME]."' vào kho. SL: " . $allotment['quantity_import']
            ];
            $this->tradeOrderRepo->wlog($id, $log);
            $response = [
                'data' => $allotment,
                'status' => Response::HTTP_OK,
                'message' => __('Marketing::messages.success')
            ];
            Log::channel('marketing')->info('confirmedAllotment data success: ' . print_r($response, true));
            return response()->json($response);
        }
        $response = [
            'data' => $data,
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('Marketing::messages.errors')
        ];
        Log::channel('marketing')->info('confirmedAllotment data errors: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * confirm item's allotment then put item into storage
     * @param $storeId String
     * @param $storeName String
     * @param $item Array
     * @return void
     * 
     */
    protected function saveItemToStorage($storeId, $item, $amount, $allotment) {
        Log::channel('marketing')->info('TradeOrderController saveItemToStorage begin');
        $storage = $this->tradeStorageRepo->getItemByStoreId($storeId);
        if (!$storage) {
            // Create new storage
            $storeName = $this->storeRepo->getStoreName($storeId);
            $storagesData = [
                TradeStorage::STORE_ID          => $storeId,
                TradeStorage::STORE_NAME        => $storeName,
                TradeStorage::ITEMS             => [],
                TradeStorage::LOGS              => [],
                TradeStorage::CREATED_BY        => TradeStorage::SYSTEM,
            ];
            $this->tradeStorageRepo->create($storagesData);
            $storage = $this->tradeStorageRepo->getItemByStoreId($storeId);
        }
        $existedItem = $this->tradeStorageRepo->fetchItem($storeId, $item[TradeOrder::ITEM_CODE]);
        
        if (!$existedItem) {
            // save new item to storage
            $data = [
                'key'               => time().'1',
                'item_id'           => $item[TradeOrder::ITEM_ID],
                'code_item'         => $item[TradeOrder::ITEM_CODE],
                'name'              => $item[TradeOrder::ITEM_NAME],
                'type'              => $item[TradeOrder::ITEM_TYPE],
                'specification'     => $item[TradeOrder::ITEM_SPECIFICATIONS],
                'quantity_stock'    => $amount,
                'quantity_broken'   => 0,
                'category'          => $item[TradeOrder::CATEGORY],
                'taget_goal'        => $item[TradeOrder::IMPLEMENTATION_GOAL]
            ];
            $this->tradeStorageRepo->pushItem($storeId, $data);
            $existedItem = $this->tradeStorageRepo->fetchItem($storeId, $item[TradeOrder::ITEM_CODE]);
            Log::channel('marketing')->info('TradeOrderController saveItemToStorage save new item' . $item[TradeOrder::ITEM_CODE]);
        } else {
            $dataUpdate = [
                'quantity_stock'    => $amount,
            ];
            $this->tradeStorageRepo->updateQuantityStock($storeId, $item[TradeOrder::ITEM_CODE], $amount);
            Log::channel('marketing')->info('TradeOrderController saveItemToStorage update stock item' . $item[TradeOrder::ITEM_CODE]);
        }
        $historyData = [
            TradeHistory::STORE_ID              => $storage[TradeStorage::STORE_ID],
            TradeHistory::STORE_NAME            => $storage[TradeStorage::STORE_NAME],
            TradeHistory::CODE_ITEM             => $existedItem[TradeStorage::ITEM_CODE],
            TradeHistory::NAME                  => $existedItem[TradeStorage::NAME],
            TradeHistory::AMOUNT                => $amount,
            TradeHistory::ACTION                => TradeHistory::ACTION_BUY,
            TradeHistory::CREATED_BY            => TradeHistory::SYSTEM,
            TradeHistory::NCC                   => $allotment[TradeOrder::ALLOTMENT_NCC],
            TradeHistory::ACTUAL_PRICE          => $allotment[TradeOrder::ALLOTMENT_ACTUAL_PRICE]
        ];
        $this->tradeHistoryRepo->create($historyData);
        Log::channel('marketing')->info('TradeOrderController saveItemToStorage push history' . print_r($existedItem, true));
    }

    /**
     * auto close request if match condition
     * @param $channel string
     * @return void
     * */
    public function closeRequest($channel)
    {
        Log::channel($channel)->info('TradeOrderController closeRequest begin');
        $result = $this->tradeOrderRepo->closeRequest();
        Log::channel($channel)->info('TradeOrderController closeRequest end' . print_r($result, true));
    }
}
