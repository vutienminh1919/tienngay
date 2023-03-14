<?php

namespace Modules\Marketing\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Modules\MongodbCore\Repositories\StoreRepository;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\DeliveryBillRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface as TradeStorageRepository;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface as AreaRepository;
use Modules\MongodbCore\Repositories\Interfaces\TransferRepositoryInterface as TransferRepository;
use Modules\MongodbCore\Entities\TradeTransfer;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface as TradeHistoryRepository;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\Marketing\Service\MarketingApi;

class TransferController extends BaseController
{
    protected $storeRepository;
    protected $deliveryBillRepository;
    protected $tradeItemRepository;
    protected $tradeStorageRepository;
    protected $areaRepository;
    protected $roleRepository;
    protected $transferRepository;
    protected $tradeHistoryRepository;
    protected $groupRoleRepository;
    public function __construct(StoreRepository $storeRepository, 
        DeliveryBillRepository $deliveryBillRepository, 
        TradeItemRepository $tradeItemRepository,
        TradeStorageRepository $tradeStorageRepository,
        AreaRepository $areaRepository,
        RoleRepository $roleRepository,
        TransferRepository $transferRepository,
        TradeHistoryRepository $tradeHistoryRepository,
        GroupRoleRepository $groupRoleRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->deliveryBillRepository = $deliveryBillRepository;
        $this->tradeItemRepository = $tradeItemRepository;
        $this->tradeStorageRepository = $tradeStorageRepository;
        $this->areaRepository = $areaRepository;
        $this->roleRepository = $roleRepository;
        $this->transferRepository = $transferRepository;
        $this->tradeHistoryRepository = $tradeHistoryRepository;
        $this->groupRoleRepository = $groupRoleRepository;
    }

    /**
    * Tạo, lưu phiếu điều chuyển (phiếu điều chuyển ấn phẩm) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function save(Request $request) {
        $dataRequest = $request->all();
        log::channel('marketing')->info('data save transfer' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'items.*.code_item' => 'required',
            'items.*.name' => 'required',
            'items.*.amount' => 'required',
            'items.*.specification' => 'required',
            'items.*.type' => 'required',
            'stores_export' => 'required',
            'stores_import' => 'required',
            'total_items' => 'required',
            'total_amount' => 'required',
        ], [
            'items.*.code_item.required' => 'Mã ấn phẩm không để trống',
            'items.*.name.required' => 'Tên ấn phẩm không để trống',
            'items.*.amount.required' => 'Số lượng không để trống',
            'items.*.specification.required' => 'Quy cách không để trống',
            'items.*.type.required' => 'Loại ấn phẩm không để trống',
            'stores_export.required' => 'Phòng giao dịch xuất không để trống',
            'stores_import.required' => 'Phòng giao dịch nhận không để trống',
            'total_items.required' => 'Tổng số sản phẩm không để trống',
            'total_amount.required' => 'Tổng số lượng ấn phẩm không để trống',
        ]);
        if ($validator->fails()) {
            Log::channel('marketing')->info('create transfer bill validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
                'errors'                => $validator->errors(),
            ]);
        }
        foreach ($dataRequest['items'] as $item) {
            $list[] =$item;
        }
        $store_name_export = $this->storeRepository->getStoreName($dataRequest['stores_export']);
        $area_export = $this->storeRepository->getCodeAreaByStoreId($dataRequest['stores_export']);
        if ($area_export) {
            $domain = $this->areaRepository->getDomainByCodeArea($area_export);
            $dataRequest['stores_export'] = [
                'id' => $dataRequest['stores_export'],
                'name' => $store_name_export,
                'code_area' => $area_export,
                'domain' => $domain['domain']['code'],
            ];
        }

        $store_name_import = $this->storeRepository->getStoreName($dataRequest['stores_import']);
        $area_import = $this->storeRepository->getCodeAreaByStoreId($dataRequest['stores_import']);
        if ($area_import) {
            $domain = $this->areaRepository->getDomainByCodeArea($area_import);
            $dataRequest['stores_import'] = [
                'id' => $dataRequest['stores_import'],
                'name' => $store_name_import,
                'code_area' => $area_import,
                'domain' => $domain['domain']['code'],
            ];
        }
        $input = [
            TradeTransfer::CREATED_BY           => $dataRequest['created_by'] ?? "",
            TradeTransfer::TOTAL_ITEMS          => $dataRequest['total_items'] ?? "",
            TradeTransfer::TOTAL_AMOUNT         => $dataRequest['total_amount'] ?? "",
            TradeTransfer::STORES_EXPORT        => $dataRequest['stores_export'] ?? "",
            TradeTransfer::STORES_IMPORT        => $dataRequest['stores_import'] ?? "",
            TradeTransfer::LIST                 => $list ?? [],
        ];

        if ($dataRequest['button'] && $dataRequest['button'] == 'create') {
            $input[TradeTransfer::STATUS] = TradeTransfer::STATUS_WAIT_EXPORT;
            $input[TradeTransfer::REQUESTED_AT] = time();
        }
        if ($dataRequest['button'] && $dataRequest['button'] == 'save') {
            $input[TradeTransfer::STATUS] = TradeTransfer::STATUS_NEW;
        }
        
        Log::channel('marketing')->info('data input' .print_r($input, true));
        $create = $this->transferRepository->create($input);
        if ($create) {
            if ($create->status == TradeTransfer::STATUS_WAIT_EXPORT) {
                $url = env("CPANEL_TN_PATH") . "/trade/tradeTransfer/" . "?target=" . "cpanel/trade/transfer/detail/" . $create['_id'];
                $tpgdExport =  $this->roleRepository->getChtByStoreId($create['stores_export']['id']);
                $tpgdImport =  $this->roleRepository->getChtByStoreId($create['stores_import']['id']);
                $user = array_merge($tpgdExport, $tpgdImport);
                $created = "1";
                $dataSendEmail = [
                    'user' => array_unique($user),
                    'store_export' => $store_name_export,
                    'store_import' => $store_name_import,
                    'url' => $url,
                    'create' => $created,
                ];
                $sendMail = MarketingApi::sendRequestTransfer($dataSendEmail);
            }
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $create,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * Update phiếu điều chuyển (phiếu điều chuyển ấn phẩm) 
    * @param Illuminate\Http\Request;
    * @param String $id;
    * @return json
    * */
    public function update(Request $request, $id) {
        $dataRequest = $request->all();
        log::channel('marketing')->info('data update transfer' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'items.*.code_item' => 'required',
            'items.*.name' => 'required',
            'items.*.amount' => 'required',
            'items.*.specification' => 'required',
            'items.*.type' => 'required',
            'stores_export' => 'required',
            'stores_import' => 'required',
            'total_items' => 'required',
            'total_amount' => 'required',
        ], [
            'items.*.code_item.required' => 'Mã ấn phẩm không để trống',
            'items.*.name.required' => 'Tên ấn phẩm không để trống',
            'items.*.amount.required' => 'Số lượng không để trống',
            'items.*.specification.required' => 'Quy cách không để trống',
            'items.*.type.required' => 'Loại ấn phẩm không để trống',
            'stores_export.required' => 'Phòng giao dịch xuất không để trống',
            'stores_import.required' => 'Phòng giao dịch nhận không để trống',
            'total_items.required' => 'Tổng số sản phẩm không để trống',
            'total_amount.required' => 'Tổng số lượng ấn phẩm không để trống',
        ]);
        if ($validator->fails()) {
            Log::channel('marketing')->info('update transfer bill validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
                'errors'                => $validator->errors(),
            ]);
        }
        foreach ($dataRequest['items'] as $item) {
            $list[] =$item;
        }

        $store_name_import = $this->storeRepository->getStoreName($dataRequest['stores_import']);
        $area_import = $this->storeRepository->getCodeAreaByStoreId($dataRequest['stores_import']);
        if ($area_import) {
            $domain = $this->areaRepository->getDomainByCodeArea($area_import);
            $dataRequest['stores_import'] = [
                'id' => $dataRequest['stores_import'],
                'name' => $store_name_import,
                'code_area' => $area_import,
                'domain' => $domain['domain']['code'],
            ];
        }

        $input = [
            TradeTransfer::UPDATED_BY           => $dataRequest['updated_by'] ?? "",
            TradeTransfer::TOTAL_ITEMS          => $dataRequest['total_items'] ?? "",
            TradeTransfer::TOTAL_AMOUNT         => $dataRequest['total_amount'] ?? "",
            TradeTransfer::STORES_IMPORT        => $dataRequest['stores_import'] ?? "",
            TradeTransfer::LIST                 => $list ?? [],
        ];
        Log::channel('marketing')->info('data input' .print_r($input, true));
        $update = $this->transferRepository->update($input, $id);
        if ($update) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $update,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * Hủy phiếu điều chuyển (phiếu điều chuyển ấn phẩm) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function cancel(Request $request) {
        $dataRequest = $request->all();
        log::channel('marketing')->info('data transfer reason cancel' . print_r($dataRequest, true));
        $detail = $this->transferRepository->find($dataRequest['id']);
        $items_storage = $this->tradeStorageRepository->getItemByStoreIdToArray($detail['stores_export']['id']);
        if ($detail['status'] == TradeTransfer::STATUS_WAIT_IMPORT) {
            if ($items_storage) {
                foreach ($items_storage['items'] as $key => $item) {
                    foreach ($detail['list'] as $i) {
                        if ($i['code_item'] == $item['code_item']) {
                            $quantity_stock = $item['quantity_stock'] + $i['amount'];
                            $item['quantity_stock'] = $quantity_stock;
                        } else {
                            continue;
                        }
                    }
                    $items_storage['items'][$key] = $item;
                }
                $update = $this->tradeStorageRepository->updateQuantity($items_storage);
            }
        }
        $reason = $this->transferRepository->updateReasonCancel($dataRequest['reason_cancel'], $dataRequest['id']);
        if ($reason) {
            $url = env("CPANEL_TN_PATH") . "/trade/tradeTransfer/" . "?target=" . "cpanel/trade/transfer/detail/" . $dataRequest['id'];
            $store_name_export = $this->storeRepository->getStoreName($detail['stores_export']['id']);
            $store_name_import = $this->storeRepository->getStoreName($detail['stores_import']['id']);
            $tpgdImport =  $this->roleRepository->getChtByStoreId($detail['stores_import']['id']);
            $tpgdExport =  $this->roleRepository->getChtByStoreId($detail['stores_export']['id']);
            $user = array_merge($tpgdImport, $tpgdExport);
            $reason_cancel = $dataRequest['reason_cancel'];
            $dataSendEmail = [
                'user' => array_unique($user),
                'store_export' => $store_name_export,
                'store_import' => $store_name_import,
                'url' => $url,
                'reason_cancel' => $reason_cancel,
            ];
            $sendMail = MarketingApi::sendRequestTransfer($dataSendEmail);
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $reason,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * Xóa phiếu điều chuyển (phiếu điều chuyển ấn phẩm) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function deleteItem(Request $request) {
        $dataRequest = $request->all();
        $update = $this->transferRepository->deleteItem($dataRequest['id']);
        if ($update) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $update,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * Xác nhận xuất (phiếu điều chuyển ấn phẩm) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function confirmExport(Request $request) {
        $dataRequest = $request->all();
        $detail = $this->transferRepository->find($dataRequest['id']);
        $items_storage = $this->tradeStorageRepository->getItemByStoreIdToArray($detail['stores_export']['id']);
        if ($items_storage) {
            foreach ($items_storage['items'] as $key => $item) {
                foreach ($detail['list'] as $i) {
                    if ($i['code_item'] == $item['code_item']) {
                        $quantity_stock = $item['quantity_stock'] - $i['amount'];
                        $item['quantity_stock'] = $quantity_stock;
                    } else {
                        continue;
                    }
                }
                $items_storage['items'][$key] = $item; 
            }
            $update = $this->tradeStorageRepository->updateQuantity($items_storage);
        }
        $confirm = $this->transferRepository->confirmExport($dataRequest);
        if ($confirm) {
            $url = env("CPANEL_TN_PATH") . "/trade/tradeTransfer/" . "?target=" . "cpanel/trade/transfer/detail/" . $dataRequest['id'];
            $store_name_export = $this->storeRepository->getStoreName($detail['stores_export']['id']);
            $store_name_import = $this->storeRepository->getStoreName($detail['stores_import']['id']);
            $tpgdImport =  $this->roleRepository->getChtByStoreId($detail['stores_import']['id']);
            $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
            $user = array_merge($tpgdImport, $tradeMkt);
            $export = '1';
            $dataSendEmail = [
                'user' => array_unique($user),
                'store_export' => $store_name_export,
                'store_import' => $store_name_import,
                'url' => $url,
                'export' => $export,
            ];
            $sendMail = MarketingApi::sendRequestTransfer($dataSendEmail);
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $confirm,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * Xác nhận nhập (phiếu điều chuyển ấn phẩm) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function confirmImport(Request $request) {
        $dataRequest = $request->all();
        $detail = $this->transferRepository->find($dataRequest['id']);
        if ($detail) {
            $items_storage = $this->tradeStorageRepository->getItemByStoreIdToArray($detail['stores_import']['id']);
            if (!$items_storage) {
                foreach ($detail['list'] as $key => $item) {
                    $item['quantity_stock'] = (int)$item['amount'];
                    unset($item['amount']);
                    $detail['list'][$key] = $item;
                }
                $nameStoreImport = $this->storeRepository->getStoreName($detail['stores_import']['id']);
                $input = [
                    'store_id' => $detail['stores_import']['id'],
                    'store_name' => $nameStoreImport,
                    'items' => $detail['list'],
                    'logs' => [],
                    'created_by' => $dataRequest['import_by']
                ];
                $create = $this->tradeStorageRepository->create($input);
                if ($create) {
                    $confirm = $this->transferRepository->confirmImport($dataRequest);
                    if ($confirm) {
                        return response()->json([
                            BaseController::STATUS => BaseController::HTTP_OK,
                            BaseController::MESSAGE => BaseController::SUCCESS,
                            BaseController::DATA => $confirm,
                        ]);
                    }
                    return response()->json([
                        BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                        BaseController::MESSAGE => BaseController::FAIL,
                        BaseController::DATA => [],
                    ]);
                }
            } else {
                $existsCodeItem = $this->tradeStorageRepository->findExistsItem($detail['stores_import']['id']);
                $arrCodeItem = [];
                foreach ($existsCodeItem as $code) {
                    $arrCodeItem = iterator_to_array($code['code_item']);
                }
                foreach ($items_storage['items'] as $key => $item) {
                    foreach ($detail['list'] as $k => $i) {
                        if (in_array($i['code_item'], $arrCodeItem)) {
                            if ($i['code_item'] == $item['code_item']) {
                                $quantity_stock = $item['quantity_stock'] + $i['amount'];
                                $item['quantity_stock'] = $quantity_stock;
                            }
                            $items_storage['items'][$key] = $item;
                            $update = $this->tradeStorageRepository->updateQuantity($items_storage);
                        } else {
                            $i['quantity_stock'] = $i['amount'];
                            if (!$this->tradeStorageRepository->findExistsCodeItem($detail['stores_import']['id'], $i['code_item'])) {
                                $create = $this->tradeStorageRepository->pushItem($detail['stores_import']['id'], $i);
                            }
                        } 
                    }
                }
            }
            $confirm = $this->transferRepository->confirmImport($dataRequest);
            if ($confirm) {
                $url = env("CPANEL_TN_PATH") . "/trade/tradeTransfer/" . "?target=" . "cpanel/trade/transfer/detail/" . $dataRequest['id'];
                $store_name_export = $this->storeRepository->getStoreName($detail['stores_export']['id']);
                $store_name_import = $this->storeRepository->getStoreName($detail['stores_import']['id']);
                $tpgdExport =  $this->roleRepository->getChtByStoreId($detail['stores_export']['id']);
                $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
                $user = array_merge($tpgdExport, $tradeMkt);
                $import = "1";
                $dataSendEmail = [
                    'user' => array_unique($user),
                    'store_export' => $store_name_export,
                    'store_import' => $store_name_import,
                    'url' => $url,
                    'import' => $import,
                ];
                $sendMail = MarketingApi::sendRequestTransfer($dataSendEmail);
                return response()->json([
                    BaseController::STATUS => BaseController::HTTP_OK,
                    BaseController::MESSAGE => BaseController::SUCCESS,
                    BaseController::DATA => $confirm,
                ]);
            }
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * Xác nhận tạo (phiếu điều chuyển ấn phẩm) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function confirmCreate(Request $request) {
        $dataRequest = $request->all();
        $confirm = $this->transferRepository->confirmCreate($dataRequest);
        if ($confirm) {
            $detail = $this->transferRepository->find($dataRequest['id']);
            $url = env("CPANEL_TN_PATH") . "/trade/tradeTransfer/" . "?target=" . "cpanel/trade/transfer/detail/" . $dataRequest['id'];
            $store_name_export = $this->storeRepository->getStoreName($detail['stores_export']['id']);
            $store_name_import = $this->storeRepository->getStoreName($detail['stores_import']['id']);
            $tpgdExport =  $this->roleRepository->getChtByStoreId($detail['stores_export']['id']);
            $tpgdImport =  $this->roleRepository->getChtByStoreId($detail['stores_import']['id']);
            $user = array_merge($tpgdExport, $tpgdImport);
            $create = "1";
            $dataSendEmail = [
                'user' => array_unique($user),
                'store_export' => $store_name_export,
                'store_import' => $store_name_import,
                'url' => $url,
                'create' => $create,
            ];
            $sendMail = MarketingApi::sendRequestTransfer($dataSendEmail);
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $confirm,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    public function getAllHistory(Request $request) {
        $dataRequest = $request->all();
        $res = $this->tradeHistoryRepository->getAllHistory($dataRequest);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $res,
        ]);
    }

    public function getAvgByCodeItem(Request $request) {
        $dataRequest = $request->all();
        $res = $this->tradeHistoryRepository->getAvgByCodeItem($dataRequest['code_item']);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $res,
        ]);
    }
}
