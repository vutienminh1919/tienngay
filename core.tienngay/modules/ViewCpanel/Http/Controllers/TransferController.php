<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Modules\MongodbCore\Repositories\Interfaces\DeliveryBillRepositoryInterface as DeliveryBillRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface as AreaRepository;
use Modules\MongodbCore\Repositories\Interfaces\TransferRepositoryInterface as TransferRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface as TradeStorageRepository;
use Modules\MongodbCore\Entities\TradeTransfer;
use Modules\MongodbCore\Entities\TradeHistory;
use CURLFile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface as TradeHistoryRepository;

class TransferController extends BaseController
{
    protected $storeRepository;
    protected $deliveryBillRepository;
    protected $tradeItemRepository;
    protected $roleRepository;
    protected $areaRepository;
    protected $transferRepository;
    protected $tradeStorageRepository;
    protected $tradeHistoryRepository;

    const PGD = "cua-hang-truong";
    const ASM = "quan-ly-khu-vuc";
    const RSM = "quan-ly-vung";
    const GDKD = "giam-doc-kinh-doanh";
    const MKT = "marketing";

    function __construct(StoreRepository $storeRepository,
        DeliveryBillRepository $deliveryBillRepository,
        TradeItemRepository $tradeItemRepository,
        AreaRepository $areaRepository,
        TransferRepository $transferRepository,
        TradeStorageRepository $tradeStorageRepository,
        RoleRepository $roleRepository,
        TradeHistoryRepository $tradeHistoryRepository) {
        $this->storeRepository = $storeRepository;
        $this->deliveryBillRepository = $deliveryBillRepository;
        $this->tradeItemRepository = $tradeItemRepository;
        $this->areaRepository = $areaRepository;
        $this->transferRepository = $transferRepository;
        $this->tradeStorageRepository = $tradeStorageRepository;
        $this->roleRepository = $roleRepository;
        $this->tradeHistoryRepository = $tradeHistoryRepository;
    }

    /**
    * Tạo phiếu điều chuyển (phiếu điều chuyển)
    * @return view
    * */
    public function create() {
        $stores = $this->storeRepository->getActiveList();
        return view('viewcpanel::trade.transfer.create', [
            'stores' => $stores,
            'homeTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransfer?tab=transfer',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
            'createTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransferCreate',
            'cancelTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransfer?tab=transfer',
        ]);
    }

    /**
    * Tạo phiếu điều chuyển (phiếu điều chuyển)
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function save(Request $request) {
        $dataRequest = $request->all();
        $user = session('user');
        Log::channel('cpanel')->info('data transfer bill' . print_r($dataRequest, true));
        $dataRequest['created_by'] = $user['email'];
        $apiUrl = config('routes.trade.transfer.save');
        Log::info('Call Api: ' . $apiUrl . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            $this->transferRepository->wlog($result->json()['data']['_id'], config('viewcpanel.tradeMkt.transfer.create'), $user['email']);
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Thành công',
                "data" => [
                    'redirectURL' => route('viewcpanel::transfer.detail', ['id' => $result->json()['data']['_id']]),
                ]
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => "Thất bại",
                'data' => [],
            ]);
        }
    }

    /**
    * Sửa phiếu điều chuyển (phiếu điều chuyển)
    * @return view
    * */
    public function edit($id) {
        $detail = $this->transferRepository->find($id);
        $storages = $this->tradeStorageRepository->getItemByStoreId($detail['stores_export']['id']);
        $arr = [];
        $arr['store_id'] = $storages['store_id'];
        $arr['store_name'] = $storages['store_name'];
        foreach ($storages['items'] as $key => $item) {
            $detailItem = $this->tradeItemRepository->detailByCodeItem($item['code_item']);
            $item['path'] = $detailItem['path'];
            $arr['items'][] = $item;
        }
        $stores = $this->storeRepository->getActiveList();
        return view('viewcpanel::trade.transfer.update', [
            'detail' => $detail,
            'stores' => $stores,
            'storages' => $arr,
            'homeTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransfer?tab=transfer',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
            'cancelTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransfer?tab=transfer',
            'updateTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransferUpdate/',
        ]);
    }

    /**
    * Sửa phiếu điều chuyển (phiếu điều chuyển)
    * @param Illuminate\Http\Request;
    * @param String $id;
    * @return json
    * */
    public function update(Request $request, $id) {
        $dataRequest = $request->all();
        $user = session('user');
        Log::channel('cpanel')->info('data pgd update' . print_r($dataRequest, true));
        $dataRequest['updated_by'] = $user['email'];
        $apiUrl = config('routes.trade.transfer.update')."/$id";
        Log::info('Call Api: ' . $apiUrl . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $this->transferRepository->wlog($id, config('viewcpanel.tradeMkt.transfer.edit'), $user['email']);
        }
        return response()->json($result->json());
    }

    /**
    * Chi tiết phiếu điều chuyển (phiếu điều chuyển)
    * @return view
    * */
    public function detail($id) {
        $user = session('user');
        $isAdmin = (isset($user['is_superadmin']) && (int) $user['is_superadmin'] == 1) ? 1 : 0;
        $detail = $this->transferRepository->find($id);
        $status = TradeTransfer::$status;
        $mkt = $this->roleRepository->getEmailMKT();
        $exportButton = false;
        $importButton = false;
        $importCreate = false;
        switch ($detail['status']) {
            case TradeTransfer::STATUS_NEW:
                $exportButton = false;
                $importButton = false;
                $importCreate = true;
                break;
            case TradeTransfer::STATUS_WAIT_EXPORT:
                $exportButton = true;
                $importButton = false;
                $importCreate = false;
                break;
            case TradeTransfer::STATUS_WAIT_IMPORT:
                $exportButton = false;
                $importButton = true;
                $importCreate = false;
                break;
            case TradeTransfer::STATUS_CANCEL:
                $exportButton = false;
                $importButton = false;
                $importCreate = false;
                break;
            case TradeTransfer::STATUS_COMPLETE:
                $exportButton = false;
                $importButton = false;
                $importCreate = false;
                break;
        }
        $paginate = $this->paginate($detail['list']);
        $detail['list'] = collect($detail['list']);
        $detail['list'] = $this->paginate($detail['list']);
        $detail['list']->withPath('');
        $mine = ['image/jpeg', 'image/png', 'image/jpg'];
        if (count($detail['license_export']) > 0) {
            foreach($detail['license_export'] as $item){
                if(in_array($item['file_type'], $mine)){
                    $imgExport[] = $item;
                }else{
                    $documentExport[] = $item;
                }
            }
        }
        if (count($detail['license_import']) > 0) {
            foreach($detail['license_import'] as $item){
                if(in_array($item['file_type'], $mine)){
                    $imgImport[] = $item;
                }else{
                    $documentImport[] = $item;
                }
            }
        }
        return view('viewcpanel::trade.transfer.detail', [
            'detail' => $detail,
            'status' => $status,
            'user'   => $user,
            'mkt'    => $mkt,
            'isAdmin' => $isAdmin,
            'exportButton' => $exportButton,
            'importButton' => $importButton,
            'importCreate' => $importCreate,
            'homeTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransfer?tab=transfer',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
            'detailTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransferDetail/',
            'backToHome' => env('CPANEL_TN_PATH') . '/trade/tradeTransfer?tab=transfer',
            'imgExport' => $imgExport ?? [],
            'documentExport' => $documentExport ?? [],
            'imgImport' => $imgImport ?? [],
            'documentImport' => $documentImport ?? [],
        ]);
    }

    /**
    * Hủy phiếu điều chuyển (phiếu điều chuyển)
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function cancel(Request $request) {
        $dataRequest = $request->all();
        $user = session('user');
        Log::channel('cpanel')->info('data reason cancel' . print_r($dataRequest, true));
        $dataRequest['created_by'] = $user['email'];
        $apiUrl = config('routes.trade.transfer.cancel');
        Log::info('Call Api: ' . $apiUrl . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $this->transferRepository->wlog($dataRequest['id'], config('viewcpanel.tradeMkt.transfer.cancel'), $user['email']);
            $detail = $this->transferRepository->find($dataRequest['id']);
            foreach ($detail['list'] as $item) {
                $input = [
                    TradeHistory::ID_TRANSFER => $detail['_id'],
                    TradeHistory::STORE_ID => $detail['stores_export']['id'],
                    TradeHistory::STORE_NAME => $detail['stores_export']['name'],
                    TradeHistory::CODE_ITEM => $item['code_item'],
                    TradeHistory::NAME => $item['name'],
                    TradeHistory::AMOUNT => $item['amount'],
                    TradeHistory::ACTION => TradeHistory::ACTION_TRANSFER,
                    TradeHistory::CREATED_BY => $user['email'],
                    TradeHistory::IS_CONFIRMED  => 2,
                    TradeHistory::TYPE_REPORT => TradeHistory::CANCEL
                ];
                $create = $this->tradeHistoryRepository->create($input);
            }
        }
        return response()->json($result->json());
    }

    /**
    * Xóa phiếu điều chuyển (phiếu điều chuyển)
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function delete(Request $request) {
        $user = session('user');
        $dataRequest = $request->all();
        $apiUrl = config('routes.trade.transfer.delete');
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $this->transferRepository->wlog($dataRequest['id'], config('viewcpanel.tradeMkt.transfer.delete'), $user['email']);
        }
        return response()->json($result->json());
    }

    /**
    * Xác nhận xuất phiếu điều chuyển (phiếu điều chuyển)
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function confirmExport(Request $request) {
        $user = session('user');
        $dataRequest = $request->all();
        $url = json_decode($dataRequest['url']);
        $dataRequest['url'] = $url;
        $dataRequest['export_by'] = $user['email'];
        Log::channel('cpanel')->info('confirmExport' . print_r($dataRequest, true));
        $apiUrl = config('routes.trade.transfer.confirmExport');
        Log::info('Call Api: ' . $apiUrl . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $this->transferRepository->wlog($dataRequest['id'], config('viewcpanel.tradeMkt.transfer.updateExport'), $user['email']);
            $detail = $this->transferRepository->find($dataRequest['id']);
            foreach ($detail['list'] as $item) {
                $input = [
                    TradeHistory::ID_TRANSFER => $detail['_id'],
                    TradeHistory::STORE_ID => $detail['stores_export']['id'],
                    TradeHistory::STORE_NAME => $detail['stores_export']['name'],
                    TradeHistory::CODE_ITEM => $item['code_item'],
                    TradeHistory::NAME => $item['name'],
                    TradeHistory::AMOUNT => $item['amount'],
                    TradeHistory::ACTION => TradeHistory::ACTION_TRANSFER,
                    TradeHistory::CREATED_BY => $user['email'],
                    TradeHistory::IS_CONFIRMED  => 1,
                    TradeHistory::TYPE_REPORT => TradeHistory::EXPORT
                ];
                $create = $this->tradeHistoryRepository->create($input);
            }
        }
        return response()->json($result->json());
    }

    /**
    * Xác nhận nhận phiếu điều chuyển (phiếu điều chuyển)
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function confirmImport(Request $request) {
        $dataRequest = $request->all();
        $user = session('user');
        $url = json_decode($dataRequest['url']);
        $dataRequest['url'] = $url;
        $dataRequest['import_by'] = $user['email'];
        Log::channel('cpanel')->info('confirmImport' . print_r($dataRequest, true));
        $apiUrl = config('routes.trade.transfer.confirmImport');
        Log::info('Call Api: ' . $apiUrl . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $this->transferRepository->wlog($dataRequest['id'], config('viewcpanel.tradeMkt.transfer.updateImport'), $user['email']);
            $detail = $this->transferRepository->find($dataRequest['id']);
            foreach ($detail['list'] as $item) {
                $input = [
                    TradeHistory::ID_TRANSFER => $detail['_id'],
                    TradeHistory::STORE_ID => $detail['stores_import']['id'],
                    TradeHistory::STORE_NAME => $detail['stores_import']['name'],
                    TradeHistory::CODE_ITEM => $item['code_item'],
                    TradeHistory::NAME => $item['name'],
                    TradeHistory::AMOUNT => $item['amount'],
                    TradeHistory::ACTION => TradeHistory::ACTION_TRANSFER,
                    TradeHistory::CREATED_BY => $user['email'],
                    TradeHistory::IS_CONFIRMED => 1,
                    TradeHistory::TYPE_REPORT => TradeHistory::IMPORT
                ];
                $create = $this->tradeHistoryRepository->create($input);
            }
        }
        return response()->json($result->json());
    }

    /**
    * Paginate
    * @param $item, $perPage, $page, $option = []
    * @return Renderable
    */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
    * Xác tạo phiếu điều chuyển (phiếu điều chuyển)
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function confirmCreate(Request $request) {
        $dataRequest = $request->all();
        $user = session('user');
        Log::channel('cpanel')->info('confirmCreate' . print_r($dataRequest, true));
        $apiUrl = config('routes.trade.transfer.confirmCreate');
        Log::info('Call Api: ' . $apiUrl . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }
}
