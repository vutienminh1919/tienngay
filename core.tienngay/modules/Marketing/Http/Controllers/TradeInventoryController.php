<?php

namespace Modules\Marketing\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Marketing\Service\MarketingApi;
use Modules\MongodbCore\Entities\TradeHistory;
use Modules\MongodbCore\Entities\TradeStorage;
use Modules\MongodbCore\Repositories\AreaRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface as TradeStorageRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeInventoryReportRepositoryInterface as TradeInventoryReportRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface as TradeHistoryRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;

class TradeInventoryController extends BaseController
{
    public function __construct(TradeStorageRepository         $tradeStorageRepository,
                                StoreRepository                $storeRepository,
                                TradeInventoryReportRepository $tradeInventoryReportRepository,
                                AreaRepository $areaRepository,
                                TradeHistoryRepository $tradeHistoryRepository,
                                TradeHistory $tradeHistory,
                                TradeItemRepository $tradeItemRepository)
    {
        $this->tradeStorageRepository = $tradeStorageRepository;
        $this->tradeInventoryReportRepository = $tradeInventoryReportRepository;
        $this->storeRepository = $storeRepository;
        $this->areaRepository = $areaRepository;
        $this->tradeHistoryRepository = $tradeHistoryRepository;
        $this->tradeHistory = $tradeHistory;
        $this->tradeItemRepository = $tradeItemRepository;
    }

    public function getItemByStoreId(Request $request)
    {
        $dataRequest = $request->all();
        $result = $this->tradeStorageRepository->getItemByStoreId($dataRequest['store_id']);
        if ($result) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $result,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    public function insertInventoryReport(Request $request)
    {
        $data = $request->all();
        $dataStore = $this->storeRepository->getStoreNameandCodeArea($data['store']);
        $store = [
            'id' => $data['store'],
            'name' => $dataStore['name'],
            'code_area' => $dataStore['code_area']
        ];
        $data['store'] = $store;
        $create = $this->tradeInventoryReportRepository->insert($data);
        $dataEmail = [];
        $id = $create['_id'];
        $userEmail = ['minhvt@tienngay.vn'];
        $url = env('CPANEL_TN_PATH') . "/trade/inventory?target=" . "cpanel/trade/inventory/reportDetail/$id";
        $dataEmail = [
            'user' => $userEmail,
            'url' => $url,
            'store_name' => $create['store_name']
        ];
        $mail = MarketingApi::sendCreateReport($dataEmail);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $create,
        ];
        return response()->json($response);

    }

    public function adjustmentInsert(Request $request)
    {
        $data = $request->all();
        $create = $this->tradeInventoryReportRepository->adjustmentInsert($data);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $create,
        ];
        return response()->json($response);

    }

    public function updateAdjustmentDone(Request $request)
    {
        $data = $request->all();
        $detail = $this->tradeInventoryReportRepository->detail($data['id_report']);
        if (isset($detail['adjustment'])) {

            $adjustment = $detail['adjustment'];
            $adjustment_update = [];
            foreach ($adjustment as $key => $ad) {
                if ($data['id'] == $ad['id']) {
                    $ad['status'] = 'done';
                    $ad['approved_at'] = time();
                    $ad['approved_by'] = $data['approved_by'];
                }
                $adjustment_update = $ad;
            }
            $done = $this->tradeInventoryReportRepository->updateAdjustmentDone($data, $adjustment_update);
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => "ERROR",
            ];
            return response()->json($response);
        }
        if (isset($detail['adjustment'])) {
            $arr_item = [];
            foreach ($detail['adjustment'] as $i) {
                if ($i['id'] == $data['id']) {
                    $arr_item = $i['item'];
                }
            }
            $storage = $this->tradeStorageRepository->getByStoreId($detail['store_id']);
            foreach ($storage['items'] as $key => $st) {
                foreach ($arr_item as $it) {
                    if ($st['code_item'] == $it['code']) {
//                        $storage['items'][$key]['quantity_stock'] = $it['quantity_stock_storage'];
//                        $storage['items'][$key]['quantity_broken'] = $it['quantity_broken'];
                        $st['quantity_stock'] = $it['quantity_stock_storage'];
                        $st['quantity_broken'] = $it['quantity_broken'];
                    }
                }
                $this->tradeStorageRepository->updateQuantityStorage($storage, $st);
            }
            foreach ($arr_item as $it) {
                $name = $this->tradeItemRepository->detailByCodeItem($it['code']);
                $name = $name['detail']['name'];
                $dataLog = [
                    'code_item' => $it['code'],
                    'name' => $name,
                    'amount' => $it['quantity_stock_storage'],
                    'store_id' => $detail['store_id'],
                    'store_name' => $detail['store_name'],
                    'created_by' => $data['approved_by'],
                    'created_at' => time(),
                    'action' => TradeHistory::ACTION_ADJUST
                ];
                $this->tradeHistoryRepository->create($dataLog);
            }

        }
        $dataEmail = [];
        $id = $detail['_id'];
        $userEmail = ['minhvt@tienngay.vn'];
        $url = env('CPANEL_TN_PATH') . "/trade/inventory?target=" . "cpanel/trade/inventory/reportDetail/$id";
        $dataEmail = [
            'user' => $userEmail,
            'url' => $url,
            'store_name' => $detail['store_name'],
            'type' => "được duyệt"
        ];
        $mail = MarketingApi::sendAdjustmentReport($dataEmail);

        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $done,
        ];
        return response()->json($response);

    }

    public function updateAdjustmentCancel(Request $request)
    {
        $data = $request->all();
        $detail = $this->tradeInventoryReportRepository->detail($data['id_report']);
        if (isset($detail['adjustment'])) {
            $adjustment = $detail['adjustment'];
//            foreach ($adjustment as $key => $ad) {
//                if ($data['id'] == $ad['id']) {
//                    $ad['status'] = 'cancel';
//                    $ad['canceled_at'] = time();
//                    $ad['canceled_by'] = $data['canceled_by'];
//                }
//                $adjustment[$key] = $ad;
//            }
            foreach ($adjustment as $key => $ad) {
                if ($data['id'] == $ad['id']) {
                    $ad['status'] = 'cancel';
                    $ad['canceled_at'] = time();
                    $ad['canceled_by'] = $data['canceled_by'];
                }
                $adjustment_update = $ad;
            }
            $cancel = $this->tradeInventoryReportRepository->updateAdjustmentCancel($data, $adjustment_update);
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => "ERROR",
            ];
            return response()->json($response);
        }
        $data['adjustment'] = $adjustment;
        $cancel = $this->tradeInventoryReportRepository->updateAdjustmentCancel($data);

        $dataEmail = [];
        $id = $detail['_id'];
        $userEmail = ['minhvt@tienngay.vn'];
        $url = env('CPANEL_TN_PATH') . "/trade/inventory?target=" . "cpanel/trade/inventory/reportDetail/$id";
        $dataEmail = [
            'user' => $userEmail,
            'url' => $url,
            'store_name' => $detail['store_name'],
            'type' => "hủy"
        ];
        $mail = MarketingApi::sendAdjustmentReport($dataEmail);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $cancel,
        ];
        return response()->json($response);

    }

    public function getAreaByDomain(Request $request)
    {
        $data = $request->all();
        $domain = $data['domain'] ?? "";
        $area = $this->areaRepository->getCodeAreaByDomain($domain);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $area,
        ];
        return response()->json($response);
    }

    public function getStoreByCodeArea(Request $request)
    {
        $data = $request->all();
        $code = $data['code'];
        $store = $this->storeRepository->getStoreByArea($code);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $store,
        ];
        return response()->json($response);

    }

    public function insertExplanation(Request $request)
    {
        $data = $request->all();
        $create = $this->tradeInventoryReportRepository->insertExplanation($data);
        $detail = $this->tradeInventoryReportRepository->detail($data['id']);
        $dataEmail = [];
        $id = $data['id'];
        $userEmail = ['minhvt@tienngay.vn'];
        $url = env('CPANEL_TN_PATH') . "/trade/inventory?target=" . "cpanel/trade/inventory/reportDetail/$id";
        $dataEmail = [
            'user' => $userEmail,
            'url' => $url,
            'store_name' => $detail['store_name']
        ];
        $mail = MarketingApi::sendExplanationReport($dataEmail);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $create,
        ];
        return response()->json($response);

    }

    public function getSumAdjustment(Request  $request)
    {
        $data = $request->all();
        $result = $this->tradeInventoryReportRepository->getSumAdjustment($data['store_id']);
         return response()->json($result);

    }

    public function forControlStorageReport()
    {
        $store = $this->tradeStorageRepository->getAllStore();
        foreach ($store as $st) {
            $arr = '';
            $diff = false;
            $items = [];
            $items_report = [];
            $report = $this->tradeInventoryReportRepository->getReportByStoreId($st['store_id']);
            if ($report) {
                foreach ($report['item'] as $it) {
                    $items_report[$it['code']] = $it['quantity_stock'];
                }
                foreach ($st['items'] as $it) {
                    $items[$it['code_item']] = $it['quantity_stock'];
                }
                $arr = array_diff($items_report, $items);
                if(!empty($arr)){
                    $diff = true;
                    $this->tradeInventoryReportRepository->reportForControl($report['_id'], $diff);
                }elseif(empty($arr)){
                    $diff = false;
                    $b = $this->tradeInventoryReportRepository->reportForControl($report['_id'], $diff);
                }
            }
        }
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "Đối soát thành công",
        ];
        return response()->json($response);

    }

}
