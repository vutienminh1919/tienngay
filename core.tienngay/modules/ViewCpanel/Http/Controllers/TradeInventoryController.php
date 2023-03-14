<?php

namespace Modules\ViewCpanel\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\TradeAdjustment;
use Modules\MongodbCore\Entities\TradeHistory;
use Modules\MongodbCore\Entities\TradeInventoryReport;
use Modules\MongodbCore\Repositories\AreaRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeInventoryReportRepositoryInterface as TradeInventoryReportRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeAdjustmentRepositoryInterface as TradeAdjustmentRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface as TradeStorageRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MongodbCore\Repositories\Interfaces\DeliveryBillRepositoryInterface as DeliveryBillRepository;
use Modules\MongodbCore\Repositories\Interfaces\TransferRepositoryInterface as TransferRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface as TradeHistoryRepository;
use Modules\MongodbCore\Repositories\StoreRepository;


class TradeInventoryController extends BaseController
{
    const QLKV = 'quan-ly-khu-vuc';
    const CHT = 'cua-hang-truong';
    const GDV = 'giao-dich-vien';

    public function __construct(TradeInventoryReportRepository $tradeInventoryReportRepository,
                                TradeStorageRepository         $tradeStorageRepository,
                                TradeAdjustmentRepository      $tradeAdjustmentRepository,
                                TradeAdjustment                $tradeAdjustment, AreaRepository $areaRepository, StoreRepository $storeRepository, TradeInventoryReport $tradeInventoryReport,
                                TradeItemRepository            $tradeItemRepository,
                                DeliveryBillRepository         $deliveryBillRepository,
                                TransferRepository             $transferRepository,
                                TradeHistory                   $tradeHistory,
                                TradeHistoryRepository         $tradeHistoryRepository)
    {
        $this->tradeInventoryReportRepository = $tradeInventoryReportRepository;
        $this->tradeStorageRepository = $tradeStorageRepository;
        $this->tradeAdjustmentRepository = $tradeAdjustmentRepository;
        $this->areaRepository = $areaRepository;
        $this->storeRepository = $storeRepository;
        $this->tradeInventoryReport = $tradeInventoryReport;
        $this->tradeItemRepository = $tradeItemRepository;
        $this->deliveryBillRepository = $deliveryBillRepository;
        $this->transferRepository = $transferRepository;
        $this->tradeHistoryRepository = $tradeHistoryRepository;
        $this->tradeHistory = $tradeHistory;
    }

    public function uploadImg(Request $request)
    {
        $data = $request->all();
        if ($_FILES['file']['size'] > 10000000) {
            $response = array(
                'code' => 201,
                "msg" => 'Kích thước file không vượt quá 10MB',
            );
            echo json_encode($response);
            return;
        }
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        $cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
        $post = array('avatar' => $cfile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serviceUpload);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($result);
        $random = sha1(substr(md5(rand()), 0, 8));
        $data_con = array();
        if ($result1->path) {
            $data_con['url'] = $result1->path;
            $response = array(
                'code' => 200,
                "msg" => "success",
                'path' => $result1->path,
                'key' => $random,
                'raw_name' => $_FILES['file']['name']
            );
            echo json_encode($response);
            return;
        } else {
            $response = array(
                'code' => 201,
                "msg" => 'Upload không thành công hoặc định dạng không hợp lệ'
            );
            echo json_encode($response);
            return;
        }
    }

    public function index(Request $request)
    {
        $dataSearch = $request->all();
        $user = session('user');
        $pgds = $user['pgds'];
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['inventory']['index']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }

        if (isset($dataSearch['domain']) && (!isset($dataSearch['area']) && !isset($dataSearch['store']))) {
            $areaSearch = $this->areaRepository->getCodeAreaByDomain($dataSearch['domain']);
            $data['areaSearch'] = $areaSearch;
            $storeSearch = [];
            $areaSearch = $this->areaRepository->getCodeAreaByDomain($dataSearch['domain']);
            if ($areaSearch) {
                foreach ($areaSearch as $item) {
                    $storeSearch[] = $this->storeRepository->getStoreByArea($item['code']);
                }
            }
            $a = [];
            foreach ($storeSearch as $st) {
                foreach ($st as $s) {
                    $a[] = $s;
                }
            }
            $arr_store = array_column($a, '_id');
            $dataSearch['store'] = $arr_store;
        }
        if (isset($dataSearch['domain']) && isset($dataSearch['area']) && !isset($dataSearch['store'])) {
            $storeSearch = $this->storeRepository->getStoreByArea($dataSearch['area']);
            $data['storeSearch'] = $storeSearch;
            $storeSearch = $this->storeRepository->getStoreByArea($dataSearch['area']);
            $arr_store = array_column($storeSearch, '_id');
            $dataSearch['store'] = $arr_store;
        }

        if (isset($dataSearch['domain']) && isset($dataSearch['area'])) {
            $areaSearch = $this->areaRepository->getCodeAreaByDomain($dataSearch['domain']);
            $data['areaSearch'] = $areaSearch;
        }
        if (isset($dataSearch['area']) && isset($dataSearch['store'])) {
            $storeSearch = $this->storeRepository->getStoreByArea($dataSearch['area']);
            $data['storeSearch'] = $storeSearch;
        }
        $items = $this->tradeStorageRepository->getAllItem($dataSearch)->toArray();
        $itemExportDelivery = $this->tradeHistoryRepository->findByActionGroupByCode(TradeHistory::ACTION_DELIVERY)->toArray();
        $itemImportDelivery = $this->tradeHistoryRepository->findByActionGroupByCode(TradeHistory::ACTION_BUY)->toArray();
        $itemTransfer = $this->tradeHistoryRepository->findByActionGroupByCode(TradeHistory::ACTION_TRANSFER)->toArray();
        $itemAdjustment = $this->tradeHistoryRepository->findByActionGroupByCode(TradeHistory::ACTION_ADJUST)->toArray();
        foreach ($items as $key => $item) {
            if (!empty($itemImportDelivery)) {
                foreach ($itemImportDelivery as $qt) {
                    if ($item['_id'] == $qt['_id']) {
                        $items[$key]['quantity_import'] = $qt['quantity'];
                    }
                }
            }
            if (!empty($itemExportDelivery)) {
                foreach ($itemExportDelivery as $qt) {
                    if ($item['_id'] == $qt['_id']) {
                        $items[$key]['quantity_export'] = $qt['quantity'];
                    }
                }
            }
            if (!empty($itemTransfer)) {
                foreach ($itemTransfer as $qt) {
                    if ($item['_id'] == $qt['_id']) {
                        $items[$key]['quantity_export_transfer'] = $qt['quantity'];
                        $items[$key]['quantity_import_transfer'] = $qt['quantity'];
                    }
                }
            }
        }

        $storeExportDelivery = $this->tradeHistoryRepository->findByActionGroupByStore(TradeHistory::ACTION_DELIVERY)->toArray();
        $storeExportTransfer = $this->tradeHistoryRepository->findByActionGroupByStoreFixed(TradeHistory::ACTION_TRANSFER, 'export')->toArray();
        $storeImport = $this->tradeHistoryRepository->findByActionGroupByStore(TradeHistory::ACTION_BUY)->toArray();
        $storeImportTransfer = $this->tradeHistoryRepository->findByActionGroupByStoreFixed(TradeHistory::ACTION_TRANSFER, 'import')->toArray();
        $quantityImport = $this->tradeInventoryReportRepository->getAllItemImportAllotment()->toArray();
        $quantityImportStore = $this->tradeInventoryReportRepository->getAllItemImportAllotmentByStore()->toArray();

        $report = $this->tradeInventoryReportRepository->getAll();

        $quantityExportDelivery = $this->deliveryBillRepository->getAllBillCompleted()->toArray();
//        dd($quantityExportDelivery);
        $quantityTransfer = $this->transferRepository->getallItemExportCompleted()->toArray();

        $storage = $this->tradeStorageRepository->getAll($dataSearch);
        $a = [];
        foreach ($storage as $key => $st) {
//            $quantityExportDeliveryStore = $this->deliveryBillRepository->getAllItembyStoreIdCompleted($st['store_id'])->toArray();
            foreach ($storeExportDelivery as $qt) {
                if ($qt['_id'] == $st['store_id']) {
                    $storage[$key]['quantity_export'] = $qt['quantity'];
                }
            }

            if ($storeImport) {
                foreach ($storeImport as $qt) {
                    if ($qt['_id'] == $st['store_id']) {
                        $storage[$key]['quantity_import'] = $qt['quantity'];
                    }
                }
            }

//            $quantityExportTransferStore = $this->transferRepository->getExportAllItembyStoreIdCompleted($st['store_id'])->toArray();
            foreach ($storeExportTransfer as $qt) {
                if ($qt['_id'] == $st['store_id']) {
                    $storage[$key]['quantity_export_transfer'] = $qt['quantity'];
                }
            }

//            $quantityImportTransferStore = $this->transferRepository->getImportAllItembyStoreIdCompleted($st['store_id'])->toArray();
            foreach ($storeImportTransfer as $qt) {
                if ($qt['_id'] == $st['store_id']) {
                    $storage[$key]['quantity_import_transfer'] = $qt['quantity'];
                }
            }

            $diff = $this->tradeInventoryReportRepository->getLastestReportForControlExist($st['store_id']);
            if ($diff) {
                $storage[$key]['alert'] = 1;
            }
        }
//        dd($storage);
        $names = $this->tradeStorageRepository->getALlNameItemStorage()->toArray();
        if ($names) {
            foreach ($names as $key => $name) {
                $type = iterator_to_array($name['type']);
                $names[$key]['type'] = $type;
            }
            $data['name'] = $names;
        } else {
            $data['name'] = [];
        }

        $data['report'] = $report;
        $data['storage'] = $storage;
        $data['item_export'] = $items;
        $data['items'] = collect($items);
        $data['items'] = $this->paginate($data['items']);
        $data['items']->withPath('');
        $data['storage'] = collect($storage);
        $data['storage'] = $this->paginate($data['storage']);
        $data['storage']->withPath('');
        $data['pgds'] = $pgds;
        $data['domain'] = TradeInventoryReport::$domain;
        $data['dataSearch'] = $dataSearch;
        $data['cpanelPath'] = env('CPANEL_TN_PATH');
        $data['cpanelUrl'] = env('CPANEL_TN_PATH') . '/trade/inventory';
        $data['cpanelDetail'] = env('CPANEL_TN_PATH') . '/trade/inventoryStorageDetail/';
        $stores = $this->storeRepository->getActiveList();
        $data['listStore'] = $stores;
        $historys = $this->tradeHistoryRepository->getAllHistory($dataSearch);
        $transactionType = TradeHistory::$transactionType;
        $data['transactionType'] = $transactionType;
        $arrTotalAmountBuy = [];
        $arrTotalPriceItemBuy = [];
        $arrTotalPriceItemDelivery = [];
        $arrTotalAmountDelivery = [];
        if (!empty($historys->toArray())) {
            foreach ($historys->toArray() as $key => $i) {
                $detailItem = $this->tradeItemRepository->detailByCodeItem($i['code_item']);
                $i['type'] = $detailItem['detail']['type'];
                $i['specification'] = $detailItem['detail']['specification'];
                $avg = $this->tradeHistoryRepository->getAvgByCodeItem($i['code_item']);
                if (count($avg) > 0 && $i['action'] != TradeHistory::ACTION_BUY) {
                    $i['avg'] = $avg[0]['price'];
                    $i['total_price_item'] = $i['avg'] * $i['amount'];
                }
                if ($i['action'] == TradeHistory::ACTION_BUY) {
                    $i['avg'] = $i['actual_price'];
                    $i['total_price_item'] = $i['avg'] * $i['amount'];
                }
                if (count($avg) == 0 || count($avg) < 0){
                    $i['avg'] = 0;
                    $i['total_price_item'] = 0;
                }
                $historys[$key] = $i;
                if ($i['action'] == TradeHistory::ACTION_BUY || ($i['action'] == TradeHistory::ACTION_TRANSFER && $i['type_report'] == "import")) {
                    $arrTotalAmountBuy[] = $i['amount'];
                    $arrTotalPriceItemBuy[] = $i['total_price_item'];
                }
                if ($i['action'] == TradeHistory::ACTION_DELIVERY || ($i['action'] == TradeHistory::ACTION_TRANSFER && $i['type_report'] == "export")) {
                    $arrTotalAmountDelivery[] = $i['amount'];
                    $arrTotalPriceItemDelivery[] = $i['total_price_item'];
                }
            }
            $totalPriceBuy = array_sum($arrTotalPriceItemBuy);
            $totalAmountBuy = array_sum($arrTotalAmountBuy);
            $totalPriceDelivery = array_sum($arrTotalPriceItemDelivery);
            $totalAmountDelivery = array_sum($arrTotalAmountDelivery);
        }
        $data['totalPriceBuy'] = $totalPriceBuy ?? 0;
        $data['totalAmountBuy'] = $totalAmountBuy ?? 0;
        $data['totalPriceDelivery'] = $totalPriceDelivery ?? 0;
        $data['totalAmountDelivery'] = $totalAmountDelivery ?? 0;
        $data['historyTrade'] = $historys ?? [];
        $data['historyTrade'] = collect($data['historyTrade']);
        $data['historyTrade'] = $this->paginate($data['historyTrade']);
        $data['historyTrade']->withPath('');
        return view('viewcpanel::trade.inventory.index', $data);
    }

    public function adjustmentCreate($id)
    {
        $user = session('user');
        $email = $user['email'];
        $data = [];
        $detail = $this->tradeInventoryReportRepository->detail($id);
        if (isset($detail['explanation'])) {
            $data['item'] = $detail['explanation']['item'];
            foreach ($data['item'] as $key => $item) {
                $a = $this->tradeItemRepository->detailByCodeItem($item['code']);
                $data['item'][$key]['path'] = $a['path'];
            }
        }
        $data['detail'] = $detail;
        $data['id'] = $id;
        $data['cpanelPath'] = env('CPANEL_TN_PATH');
        $data['cpanelUrl'] = env('CPANEL_TN_PATH') . '/trade/inventory';
        $data['cpanelReportDetail'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportDetail/';
        return view('viewcpanel::trade.inventory.adjustmentCreate', $data);
    }

    public function adjustmentInsert(Request $request)
    {
        $data = $request->all();
        $user = session('user');
        $data['created_by'] = $user['email'];
        $uid = md5(uniqid());
        $data['id'] = $uid;
        $data['item'] = json_decode($data['item']);
        $url = config('routes.trade.inventory.adjustmentInsert');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function getItembyStoreId(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.inventory.getItemByStoreId');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function reportCreate()
    {
        $data = [];
        $user = session('user');
        $pgds = $user['pgds'];
        if (count($pgds) == 0) {
            echo "Permission denied!";
            exit;
        }
        if (count($pgds) == 1) {
            $items = $this->tradeStorageRepository->getItemByStoreId($pgds[0]['_id']);
            $data['items'] = $items;
        }
        $data['urlInsert'] = route('viewcpanel::trade.inventory.reportInsert');
        $data['pgds'] = $pgds;
        $data['cpanelPath'] = env('CPANEL_TN_PATH');
        $data['cpanelUrl'] = env('CPANEL_TN_PATH') . '/trade/inventory';
        $data['cpanelReportList'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportList';
        $data['cpanelReportCreate'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportCreate';
        return view('viewcpanel::trade.inventory.reportCreate', $data);

    }

    public function reportInsert(Request $request)
    {
        $data = $request->all();
        $user = session('user');
        $validate = Validator::make($data, [
            'store' => 'required',
        ],
            [
                'store.required' => "Phòng giao dịch không được để trống!",
            ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        if ($data['license'] == "[]") {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "errors" => "Chứng từ không được để trống!"
            ]);
        }

        if (($data['item'] == "[]") || (count(json_decode($data['item'])) != $data['countItem'])) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "errors" => "error"
            ]);
        }
        $data['created_by'] = $user['email'];
        $data['item'] = json_decode($data['item']);
        $data['license'] = json_decode($data['license']);
        $url = config('routes.trade.inventory.reportCreate');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    public function reportList(Request $request)
    {
        $user = session('user');
        $dataSearch  = $request->all();
        $reportCreateBtn  = false;
        if( $user['roles']['tradeMKT']['inventory']['reportCreateBtn']){
            $reportCreateBtn = true;
        }
        $searchStartDate = "";
        $searchEndDate = "";
        if (!empty($dataSearch['start_date'])) {
            $searchStartDate = $dataSearch['start_date'];
            $dataSearch['start_date'] = $this->convertDate($dataSearch['start_date']);
        }
        if (!empty($dataSearch['end_date'])) {
            $searchEndDate = $dataSearch['end_date'];
            $dataSearch['end_date'] = $this->convertDate($dataSearch['end_date']);
        }
        $dataSearch['pgds'] = $user['pgds'];
        $result = $this->tradeInventoryReportRepository->getAll($dataSearch);
        $data['listReport'] = $result;
        $data['pgds'] = $user['pgds'];
        $dataSearch['start_date'] = $searchStartDate;
        $dataSearch['end_date'] = $searchEndDate;
        $data['dataSearch'] = $dataSearch;
        $data['reportCreateBtn'] = $reportCreateBtn;
        $page = $result->currentPage();
        $perPage = $result->perPage();
        $perPage = ($page - 1) * $perPage;
        $data['perPage'] = $perPage;
        $status = TradeInventoryReport::$status;
        $data['status'] = $status;
        $data['cpanelPath'] = env('CPANEL_TN_PATH');
        $data['cpanelUrl'] = env('CPANEL_TN_PATH') . '/trade/inventory';
        $data['cpanelReportList'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportList';
        $data['cpanelReportCreate'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportCreate';
        $data['cpanelReportDetail'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportDetail/';
        return view('viewcpanel::trade.inventory.reportList', $data);

    }

    public function reportDetail($id)
    {
        $user = session('user');
        $isAdmin = (isset($user['is_superadmin']) && (int)$user['is_superadmin'] == 1) ? 1 : 0;
        $detail = $this->tradeInventoryReportRepository->detail($id);
        $create_adjustment = $user['roles']['tradeMKT']['inventory']['adjustmentCreate'];
        $create_explanation = $user['roles']['tradeMKT']['inventory']['explanationCreate'];
        $explanationItemListCVKD = $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'];
        $explanationItemListMKT = $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'];
        $explanationItemListASM = $user['roles']['tradeMKT']['inventory']['explanationItemListASM'];
        $itemDifferentMKT = $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'];
        $adjustmentDetail = $user['roles']['tradeMKT']['inventory']['adjustmentDetail'];
        $adjustmentDone = $user['roles']['tradeMKT']['inventory']['adjustmentDone'];
        $adjustmentCancel = $user['roles']['tradeMKT']['inventory']['adjustmentCancel'];
        $reportDetailMkt = $user['roles']['tradeMKT']['inventory']['reportDetailMkt'];

        $create_explanation = $create_explanation && (
            $detail['status'] != TradeInventoryReport::STATUS_DONE &&
            $detail['status'] != TradeInventoryReport::STATUS_WAIT_FORCONTROL
        );

        $create_adjustment = $create_adjustment && $detail['status'] != TradeInventoryReport::STATUS_DONE;

        $itemDifferentMKT = $itemDifferentMKT && in_array($detail['status'], [TradeInventoryReport::STATUS_WAIT_EXPLANATION]);

        $storage = $this->tradeStorageRepository->getByStoreId($detail['store_id']);
        $data['detail'] = $detail;
        $data['item'] = [];
        $a = [];
        foreach ($detail['item'] as $item) {
            $a['code'] = $item['code'];
            $a['quantity_stock_report'] = $item['quantity_stock'];
            $a['name'] = $item['name'];
            $a['type'] = $item['type'];
            $a['specification'] = $item['specification'];
            foreach ($storage['items'] as $i) {
                if ($item['code'] == $i['code_item']) {
                    $a['quantity_stock_storage'] = $i['quantity_stock'];
                }
            }
            $data['item'][] = $a;
        };
        $status = TradeInventoryReport::$status;
        $statusAdjustment = TradeInventoryReport::$status_adjustment;
        $data['status_adjustment'] = $statusAdjustment;
        $data['status'] = $status;
        if (isset($detail['explanation'])) {
//            $create_explanation = false;
            $data['explanation'] = $detail['explanation'];
            $code_explanation = array_column($data['explanation']['item'], 'code');
            foreach ($data['item'] as $y => $it) {
                if (!in_array($it['code'], $code_explanation)) {
                    array_push($data['explanation']['item'], $it);
                }
            }
            foreach ($data['explanation']['item'] as $key => $ex) {
                foreach ($storage['items'] as $st) {
                    if ($ex['code'] == $st['code_item']) {
                        $data['explanation']['item'][$key]['quantity_stock'] = !empty($st['quantity_stock']) ? $st['quantity_stock'] : "";
                        $data['explanation']['item'][$key]['quantity_broken'] = !empty($st['quantity_broken']) ? $st['quantity_broken'] : "";
                    }
                }
            }
        }
        $showStockRealAndBroken = false;
        if (isset($detail['adjustment'])) {
            $data['adjustment'] = $detail['adjustment'];
            $arr_status = array_column($detail['adjustment'], 'status');
            if (in_array('done', $arr_status)) {
                $create_adjustment = false;
                $showStockRealAndBroken = true;
            }
            foreach ($data['adjustment'] as $key => $ad) {
                foreach ($ad['item'] as $k => $b) {
                    $a = $this->tradeItemRepository->detailByCodeItem($b['code']);
                    $data['adjustment'][$key]['item'][$k]['name'] = $a['detail']['name'];
                    $data['adjustment'][$key]['item'][$k]['type'] = $a['detail']['type'];
                    $data['adjustment'][$key]['item'][$k]['specification'] = $a['detail']['specification'];
                }
            }
        }
        $data['storage'] = $storage;
        $data['create_adjustment'] = $create_adjustment;
        $data['create_explanation'] = $create_explanation;
        $data['explanationItemListCVKD'] = $explanationItemListCVKD;
        $data['explanationItemListMKT'] = $explanationItemListMKT;
        $data['explanationItemListASM'] = $explanationItemListASM;
        $data['itemDifferentMKT'] = $itemDifferentMKT;
        $data['adjustmentDetail'] = $adjustmentDetail;
        $data['adjustmentDone'] = $adjustmentDone;
        $data['adjustmentCancel'] = $adjustmentCancel;
        $data['reportDetailMkt'] = $reportDetailMkt;
        $data['showStockRealAndBroken'] = $showStockRealAndBroken;
        $data['cpanelPath'] = env('CPANEL_TN_PATH');

//        $data['cpanelUrl'] = route('viewcpanel::trade.inventory');
//        $data['cpanelStorageDetail'] = env('CPANEL_TN_PATH') . '/trade/inventoryStorageDetail/';
//        $data['cpanelAdjustmentCreate'] = env('CPANEL_TN_PATH') . '/trade/inventoryAdjustmentCreate/';
//        $data['cpanelReportList'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportList';

        return view('viewcpanel::trade.inventory.reportDetail', $data);

    }

    public function adjustmentList(Request $request)
    {
        $dataSearch = $request->all();
        $dataSearch['tab'] = !empty($dataSearch['tab']) ? $dataSearch['tab'] : "adjustment";
        if (isset($dataSearch['tab']) && $dataSearch['tab'] == "adjustment") {
            $adjustment = $this->tradeAdjustmentRepository->getAll($dataSearch);
            $data['adjustment'] = $adjustment;
        }
        if (isset($dataSearch['domain'])) {
            $areaSearch = $this->areaRepository->getCodeAreaByDomain($dataSearch['domain']);
            $data['areaSearch'] = $areaSearch;
        }
        if (isset($dataSearch['area'])) {
            $storeSearch = $this->storeRepository->getStoreByArea($dataSearch['area']);
            $data['storeSearch'] = $storeSearch;
        }

        $data['status'] = TradeAdjustment::$status;
        $data['dataSearch'] = $dataSearch;
        $data['domain'] = TradeAdjustment::$domain;
        return view('viewcpanel::trade.inventory.adjustment.list', $data);
    }

    public function adjustmentDetail($id)
    {
        $detail = $this->tradeAdjustmentRepository->detail($id);
        $done = true;
        $cancel = true;
        $showApproveAndCancel = true;
        if ($detail['status'] == 1) {
            $done = true;
            $cancel = true;
            $showApproveAndCancel = false;
        } else {
            $done = false;
            $cancel = false;
        }
        if (isset($detail['log'])) {
            foreach ($detail['log'] as $log) {
                if (($detail['status'] == 2) && $log['action'] == 'approved') {
                    $action_by = $log['created_by'];
                    $action_at = $log['created_at'];
                } elseif (($detail['status'] == 3) && $log['action'] == 'canceled') {
                    $action_by = $log['created_by'];
                    $action_at = $log['created_at'];
                }
            }
        }
        $data['action_by'] = $action_by ?? "";
        $data['action_at'] = $action_at ?? "";
        $data['done'] = $done;
        $data['cancel'] = $cancel;
        $data['detail'] = $detail;
        $data['showApproveAndCancel'] = $showApproveAndCancel;
        $data['status'] = TradeAdjustment::$status;
        $data['item'] = $detail['item'];
        $data['item'] = collect($data['item']);
        $data['item'] = $this->paginate($data['item']);
        $data['item']->withPath('');
        return view('viewcpanel::trade.inventory.adjustment.billDetail', $data);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function updateAdjustmentDone(Request $request)
    {
        $data = $request->all();
        $user = session('user');
        $data['approved_by'] = $user['email'];
        $url = config('routes.trade.inventory.updateAdjustmentDone');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function updateAdjustmentCancel(Request $request)
    {
        $data = $request->all();
        $user = session('user');
        $data['canceled_by'] = $user['email'];
        $url = config('routes.trade.inventory.updateAdjustmentCancel');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function getAreaByDomain(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.inventory.getAreaByDomain');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function getStoreByCodeArea(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.inventory.getStoreByCodeArea');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function getItemByItemId(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.item.getItemByItemId');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function storageDetail($id)
    {
        $detail = $this->tradeStorageRepository->detail($id);
        $report = $this->tradeInventoryReportRepository->getByStoreId($detail['store_id']);
        $bill = $this->deliveryBillRepository->getBillByStoreId($detail['store_id']);
        $itemExport = $this->transferRepository->getItemExportByStoreId($detail['store_id']);
        $itemImport = $this->transferRepository->getItemImportByStoreId($detail['store_id']);
        $itemImportStore = $this->tradeHistoryRepository->getItemImportByStoreId($detail['store_id'])->toArray();

        $itemExportDelivery = $this->tradeHistoryRepository->findByActionGroupByCodeandStoreId(TradeHistory::ACTION_DELIVERY, $detail['store_id'])->toArray();
//        dd($itemExportDelivery);
        $itemImport = $this->tradeHistoryRepository->findByActionGroupByCodeandStoreId(TradeHistory::ACTION_BUY, $detail['store_id'])->toArray();
//        dd($itemImport);
        $itemTransferExport = $this->tradeHistoryRepository->findByActionGroupByCodeStoreIdAndType(TradeHistory::ACTION_TRANSFER, $detail['store_id'], 'export')->toArray();
//        dd($itemTransferExport);
        $itemTransferImport = $this->tradeHistoryRepository->findByActionGroupByCodeStoreIdAndType(TradeHistory::ACTION_TRANSFER, $detail['store_id'], 'import')->toArray();
//        dd($itemTransferImport);

        if ($itemImportStore) {
            $listImportItem = [];
            foreach ($itemImportStore as $im) {
                $listImportItem[$im['_id']][] = $im['quantity'];
            }
        }
        if ($itemImport) {
            $import = array_column($itemImport, 'list');
            $listImport = [];
            foreach ($import as $im) {
                foreach ($im as $i) {
                    $listImport[$i['code_item']][] = $i['amount'];
                }
            }
        }
        if ($itemExportDelivery) {
            $export = array_column($itemExportDelivery, 'list');
            $listExport = [];
            foreach ($export as $ex) {
                foreach ($ex as $e) {
                    $listExport[$e['code_item']][] = $e['amount'];
                }
            }
        }
        $listitem = [];
        if ($bill) {
            $listItemExport = array_column($bill, 'list');
            foreach ($listItemExport as $list) {
                foreach ($list as $ls) {
                    $listitem[$ls['name']][] = $ls['amount'];
                }
            }
        }


        $adjustment = array_column($report->toArray(), 'adjustment');
        $items = [];
        foreach ($adjustment as $key => $ad) {
            foreach ($ad as $i) {
                if ($i['status'] == "done") {
                    $items[] = $i['item'];
                }
            }
        }
        $a = [];
        foreach ($items as $item) {
            foreach ($item as $it) {
                $a[$it['code']][] = $it['quantity_stock_storage'];
            }
        }
        $status = TradeInventoryReport::$status;
        $data['detail'] = $detail;
        $data['items'] = $detail['items'];


//        dd($data['items']);


        foreach ($data['items'] as $key => $l) {
            if (!empty($a)) {
                foreach ($a as $k => $b) {
                    if ($k == $l['code_item']) {
                        $data['items'][$key]['quantity_diff'] = array_sum($b);
                    }
                }
            }

            if (!empty($itemExportDelivery)) {
                foreach ($itemExportDelivery as $li) {
                    if ($li['_id'] == $l['code_item']) {
                        $data['items'][$key]['quantity_export'] = $li['quantity'];
                    }
                }
            }
            if (!empty($itemTransferExport)) {
                foreach ($itemTransferExport as $ex) {
                    if ($ex['_id'] == $l['code_item']) {
                        $data['items'][$key]['quantity_export_1'] = $ex['quantity'];
                    }
                }
            }
            if (!empty($itemTransferImport)) {
                foreach ($itemTransferImport as  $im) {
                    if ($im['_id'] == $l['code_item']) {
                        $data['items'][$key]['quantity_import_1'] = $im['quantity'];
                    }
                }
            }

            if (!empty($itemImport)) {
                foreach ($itemImport as $im) {
                    if ($im['_id'] == $l['code_item']) {
                        $data['items'][$key]['quantity_import'] = $im['quantity'];
                    }
                }
            }
        }
//        dd($data['items']);
        $data['items'] = collect($data['items']);
        $data['items'] = $this->paginate1($data['items']);
        $data['items']->setPageName('item');
        $data['items']->withPath('');
        $data['report'] = $report;
        $data['report'] = collect($report);
        $data['report'] = $this->paginate2($data['report']);
        $data['report']->setPageName('report');
        $data['report']->withPath('');
        $data['status'] = $status;
        $data['cpanelPath'] = env('CPANEL_TN_PATH');
        $data['cpanelUrl'] = env('CPANEL_TN_PATH') . '/trade/inventory';
        $data['cpanelReportDetail'] = env('CPANEL_TN_PATH') . '/trade/inventoryReportDetail/';
        return view('viewcpanel::trade.inventory.storageDetail', $data);

    }

    public function paginate1($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage('item') ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function paginate2($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage('report') ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function insertExplanation(Request $request)
    {
        $user = session('user');
        $email = $user['email'];
        $data = $request->all();
        $data['item'] = json_decode($data['item']);
        foreach ((array)$data['item'] as $key => $item) {
            $path = json_decode($item->license);
            $data['item'][$key]->license = $path;
        }
        $data['created_by'] = $email;
        $url = config('routes.trade.inventory.insertExplanation');
        Log::info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function convertDate($date)
    {
        $date = explode("-", $date);
        $newDate = [$date[2], $date[1], $date[0]];
        $newDate = implode("-", $newDate);
        return $newDate;

    }


}
