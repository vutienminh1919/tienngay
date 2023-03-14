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
use Modules\MongodbCore\Entities\DeliveryBill;
use Modules\MongodbCore\Entities\TradeTransfer;
use Modules\MongodbCore\Entities\TradeHistory;
use CURLFile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\MongodbCore\Repositories\Interfaces\TransferRepositoryInterface as TransferRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface as TradeHistoryRepository;
use Modules\MongodbCore\Repositories\GroupRoleRepository;

class DeliveryBillController extends BaseController
{   
    protected $storeRepository;
    protected $deliveryBillRepository;
    protected $tradeItemRepository;
    protected $roleRepository;
    protected $areaRepository;
    protected $transferRepository;
    protected $tradeHistoryRepository;
    protected $groupRoleRepository;
    const PGD = "cua-hang-truong";
    const ASM = "quan-ly-khu-vuc";
    const RSM = "quan-ly-vung";
    const GDKD = "giam-doc-kinh-doanh";
    const MKT = "marketing";
    function __construct(
        StoreRepository $storeRepository, 
        DeliveryBillRepository $deliveryBillRepository, 
        TradeItemRepository $tradeItemRepository,
        AreaRepository $areaRepository,
        TransferRepository $transferRepository,
        RoleRepository $roleRepository,
        TradeHistoryRepository $tradeHistoryRepository,
        GroupRoleRepository $groupRoleRepository
    ) {
        $this->storeRepository = $storeRepository;
        $this->deliveryBillRepository = $deliveryBillRepository;
        $this->tradeItemRepository = $tradeItemRepository;
        $this->areaRepository = $areaRepository;
        $this->transferRepository = $transferRepository;
        $this->roleRepository = $roleRepository;
        $this->tradeHistoryRepository = $tradeHistoryRepository;
        $this->groupRoleRepository = $groupRoleRepository;
    }


    /**
    * Index (phiếu xuất kho, phiếu điều chuyển) 
    * @param Illuminate\Http\Request;
    * @return view
    * */
    public function pgdIndex(Request $request) {
        $user = session('user');
        $tab = !empty($request->tab) ? $request->tab : 'delivery';
        $dataSearch = $request->all();
        if ($tab == 'delivery') {
            $delivery = $this->deliveryBillRepository->getAllDelivery($dataSearch);
        }
        if ($tab == 'transfer') {
            $transfer = $this->transferRepository->getAllTransfer($dataSearch);
        }
        $status = DeliveryBill::$status;
        $status_transfer = TradeTransfer::$status;
        $isAdmin = (isset($user['is_superadmin']) && (int) $user['is_superadmin'] == 1) ? 1 : 0;
        $groupRole = $user['groupRole'];
        $pgdSelect = false;
        $statusSelect = false;
        $areaSelect = false;
        $domainSelect = false;
        if ($isAdmin) {
            $domainSelect = true;
            $areaSelect = true;
            $statusSelect = true;
            $pgdSelect = true;
        }
        else if ($user['roles']['tradeMKT']['filterDelivery']['domainSelect']) {
            $domainSelect = true;
            $areaSelect = true;
            $statusSelect = true;
            $pgdSelect = true;
        }
        else if ($user['roles']['tradeMKT']['filterDelivery']['areaSelect']) {
            $domainSelect = false;
            $areaSelect = true;
            $statusSelect = true;
            $pgdSelect = true;
        }
        else if ($user['roles']['tradeMKT']['filterDelivery']['pgdSelect']) {
            $domainSelect = false;
            $areaSelect = false;
            $statusSelect = true;
            $pgdSelect = true;
        }
        $stores = $this->storeRepository->getActiveList();
        $mkt = $this->roleRepository->getEmailMKT();
        $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
        $area = $this->areaRepository->getCodeArea();
        return view('viewcpanel::trade.delivery.pgd.index', [
            'delivery' => $delivery ?? "",
            'transfer' => $transfer ?? "",
            'user' => $user,
            'pgdSelect' => $pgdSelect,
            'statusSelect' => $statusSelect,
            'areaSelect' => $areaSelect,
            'domainSelect' => $domainSelect,
            'isAdmin'      => $isAdmin,
            'status'        => $status,
            'status_transfer' => $status_transfer,
            'stores' => $stores,
            'dataSearch' => $dataSearch,
            'mkt' => $mkt,
            'area' => $area,
            'cpanelPath'    => env('CPANEL_TN_PATH'),
            'cpanelCreateDelivery' => env('CPANEL_TN_PATH') . '/trade/tradeDeliveryCreate',
            'cpanelCreateTransfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransferCreate',
            'cpanelIndexDelivery'     => env('CPANEL_TN_PATH') . '/trade/tradeDelivery',
            'cpanelIndexTransfer'     => env('CPANEL_TN_PATH') . '/trade/tradeTransfer',
            'detail_delivery' => env('CPANEL_TN_PATH') . '/trade/tradeDeliveryDetail/',
            'detail_delivery_asm' => env('CPANEL_TN_PATH') . '/trade/tradeDeliveryAsmDetail/',
            'detail_transfer' => env('CPANEL_TN_PATH') . '/trade/tradeTransferDetail/',
            'update_transfer'=> env('CPANEL_TN_PATH') . '/trade/tradeTransferUpdate/',
            'tradeMkt' => $tradeMkt,
        ]);
    }

    /**
    * pgd tạo phiếu xuất kho (phiếu xuất kho) 
    * @return view
    * */
    public function pgdCreate() {
        $user = session('user');
        $pgds = $user['pgds'];
        if ($pgds) {
            foreach ($pgds as $item) {
                $publications =  $this->tradeItemRepository->getItemsByStoreId($item['_id']);
                if ($publications) {
                    $itemByStoreId[] = $publications;
                } else {
                    continue;
                }
            } 
        }
        $category = DeliveryBill::$categories;
        $tagets = DeliveryBill::$taget_goal;
        return view('viewcpanel::trade.delivery.pgd.pgd_create',[
            'pgds' => $pgds,
            'category' => $category,
            'tagets' => $tagets,
            'itemByStoreId' => $itemByStoreId ?? "",
            'getItemsByStoreId' => route('viewcpanel::trade.getItemsByStoreId'),
            'cpanelPath'    => env('CPANEL_TN_PATH'),
            'cpanelCreateDelivery' => env('CPANEL_TN_PATH') . '/trade/tradeDeliveryCreate',
            'homeDelivery'     => env('CPANEL_TN_PATH') . '/trade/tradeDelivery?tab=delivery',
            'backToHome'     => env('CPANEL_TN_PATH') . '/trade/tradeDelivery?tab=delivery',
        ]);
    }

    /**
    * Tạo phiếu xuất kho (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function pgdSave(Request $request) {
        $dataRequest = $request->all();
        $user = session('user');
        Log::channel('cpanel')->info('data pgd save' . print_r($dataRequest, true));
        $dataRequest['created_by'] = $user['email'];
        $pgds = $user['pgds'];
        foreach ($pgds as $pgd) {
            if ($pgd['_id'] == $dataRequest['stores']) {
                $code_area = $this->storeRepository->getCodeAreaByStoreId($dataRequest['stores']);
                $domain = $this->areaRepository->getDomainByCodeArea($code_area);
                $dataRequest['stores'] = [
                    'id' => $pgd['_id'],
                    'name' => $pgd['name'],
                    'code_area' => $code_area,
                    'domain' => $domain['domain']['code'],
                ];
            }
        }
        $apiUrl = config('routes.trade.warehouse.pgd_save');
        Log::info('Call Api: ' . $apiUrl . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($apiUrl, $dataRequest);
        Log::info('Result Api: ' . $apiUrl . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            $this->deliveryBillRepository->wlog($result->json()['data']['_id'], config('viewcpanel.tradeMkt.deliveryBill.create'), $user['email']);
            foreach ($dataRequest['items'] as $item) {
                $input = [
                    TradeHistory::STORE_ID => $dataRequest['stores']['id'],
                    TradeHistory::STORE_NAME => $dataRequest['stores']['name'],
                    TradeHistory::CODE_ITEM => $item['name'],
                    TradeHistory::NAME => $item['name_item'],
                    TradeHistory::AMOUNT => $item['amount'],
                    TradeHistory::ACTION => TradeHistory::ACTION_DELIVERY, 
                    TradeHistory::CREATED_BY => $user['email'], 
                ];
                $create = $this->tradeHistoryRepository->create($input);
            }
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Thành công',
                "data" => [
                    'redirectURL' => route('viewcpanel::warehouse.pgdDetail', ['id' => $result->json()['data']['_id']]),
                ]
            ]);
        }
        return response()->json([
            "status" => BaseController::HTTP_BAD_REQUEST,
            "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
            "data" => []
        ]);
    }

    /**
    * Chi tiết phiếu xuất kho của pgd (phiếu xuất kho) 
    * @param String $id;
    * @return view
    * */
    public function pgdDetail($id) {
        $detail = $this->deliveryBillRepository->find($id);
        $category = DeliveryBill::$categories;
        $tagets = DeliveryBill::$taget_goal;
        return view('viewcpanel::trade.delivery.pgd.detail', [
            'detail' => $detail,
            'category' => $category,
            'tagets' => $tagets,
            'homeDelivery'     => env('CPANEL_TN_PATH') . '/trade/tradeDelivery?tab=delivery',
            'detailDelivery'     =>  env('CPANEL_TN_PATH') . '/trade/tradeDeliveryDetail/',
            'backHomeDelivery' => env('CPANEL_TN_PATH') . '/trade/tradeDelivery?tab=delivery',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
        ]);
    }

    /**
     * lấy ấn phẩm trong kho pgd
     * @param $request Illuminate\Http\Request;
     * @return json
     * */
    public function getItemStorageByStoreId(Request $request)
    {
        $url = config('routes.trade.warehouse.getItem');
        $dataRequest = $request->all();
        $dataPost = [
            'id' => $dataRequest['id'],
        ];
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        return response()->json($result->json());
    }

    /**
    * upload image
    * @param Request $request
    * @return json
    */
    public function uploadLisence(Request $request) {
        $data = $request->all();
        if($_FILES['file']['size'] > 10000000) {
            $response = array(
                'code' => BaseController::FAIL,
                "msg" => 'Kích thước file không vượt quá 10MB',
            );
            echo json_encode($response);
            return ;
        }
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        $cfile = new \CURLFile($_FILES['file']["tmp_name"],$_FILES['file']["type"],$_FILES['file']["name"]);
        $post = array('avatar'=> $cfile );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$serviceUpload);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec ($ch);
        curl_close ($ch);
        $result1 = json_decode($result);
        $random = sha1(substr(md5(rand()), 0, 8));
        $data_con = array();
        if ($result1->path) {
            $data_con['url'] = $result1->path;
            $response = array(
                'code' => 200,
                "msg"=>"success",
                'path' => $result1->path,
                'key' => $random,
                'raw_name' => $_FILES['file']['name']
            );
            echo json_encode($response);
            return ;
        } else {
            $response = array(
                'code' => 201,
                "msg" => 'Upload không thành công hoặc định dạng không hợp lệ'
            );
            echo json_encode($response);
            return ;
        }
    }

    /**
    * update chứng từ (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @param String $id;
    * @return json
    * */
    public function updateLisence(Request $request, $id) {
        $user = session('user');
        $url = config('routes.trade.warehouse.updateLisence')."/$id";
        $dataRequest = $request->all();
        $image = json_decode($dataRequest['path']);
        $dataRequest['path'] = $image;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataRequest, true));
        $result = Http::withBody(json_encode($dataRequest), 'application/json')->post($url, $dataRequest);
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $this->deliveryBillRepository->wlog($id, config('viewcpanel.tradeMkt.deliveryBill.updateLisence'), $user['email']);
        }
        return response()->json($result->json());
    }

    /**
    * lấy khu vực theo vùng (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function getAreaByDomain(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.trade.warehouse.getAreaByDomain');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
    * lấy pgd theo khu vực (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function getStoreByArea(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.trade.warehouse.getStoreByArea');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
    * Chi tiết phiếu  xuất kho của asm, mkt, rsm, gdkd (phiếu xuất kho) 
    * @param String $id;
    * @return view
    * */
    public function detail($id) {
        $detail = $this->deliveryBillRepository->find($id);
        $category = DeliveryBill::$categories;
        $tagets = DeliveryBill::$taget_goal;
        $paginate = $this->paginate($detail['list']);
        $detail['list'] = collect($detail['list']);
        $detail['list'] = $this->paginate($detail['list']);
        $detail['list']->withPath('');
        return view('viewcpanel::trade.delivery.asm.detail',[
            'detail' => $detail,
            'category' => $category,
            'tagets' => $tagets,
            'paginate' => $detail['list'],
            'homeDelivery'     => env('CPANEL_TN_PATH') . '/trade/tradeDelivery?tab=delivery',
            'detailDelivery'     =>  env('CPANEL_TN_PATH') . '/trade/tradeDeliveryAsmDetail/',
            'backHomeDelivery' => env('CPANEL_TN_PATH') . '/trade/tradeDelivery?tab=delivery',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
        ]);
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
}
