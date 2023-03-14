<?php
namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use CURLFile;
use Illuminate\Support\Facades\Validator;
use Modules\ViewCpanel\Service\ApiCall;
use Modules\MongodbCore\Repositories\Interfaces\MacomRepositoryInterface as macomRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as storeRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as roleRepository;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface as userCpanelRepository;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface as areaRepository;
use Modules\MongodbCore\Repositories\Interfaces\HistoryMacomRepositoryInterface as historyMacomRepository;


class MacomController extends BaseController
{

    private $macomRepository;
    private $storeRepository;
    private $roleRepository;
    private $userCpanelRepository;
    private $areaRepository;
    private $historyMacomRepository;
    /**
    * Modules\MongodbCore\Repositories\MacomRepository
    */
    public function __construct(
        MacomRepository $macomRepository,
        StoreRepository $storeRepository,
        RoleRepository $roleRepository,
        UserCpanelRepository $userCpanelRepository,
        AreaRepository $areaRepository,
        HistoryMacomRepository $historyMacomRepository
    )
    {
        $this->macomRepository = $macomRepository;
        $this->storeRepository = $storeRepository;
        $this->roleRepository = $roleRepository;
        $this->userCpanelRepository = $userCpanelRepository;
        $this->areaRepository = $areaRepository;
        $this->historyMacomRepository = $historyMacomRepository;
    }

    /**
    * upload img, video, file
    * 
    * @param Illuminate\Http\Request;
    * @return view
    */
    public function uploadLicense(Request $request){
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
    * index
    * 
    * @param Illuminate\Http\Request;
    * @return view
    */
    public function index(Request $request) {
        $user = session('user');
        $email = $user['email'];
        $dataSearch = $request->all();

        //dữ liệu bảng tổng (bảng ko đổi kể cả theo filter) trang index
        $mien_bac = $this->macomRepository->get_domain_MB($dataSearch);
        $mien_nam = $this->macomRepository->get_domain_MN($dataSearch);
        $dong_bac = $this->macomRepository->get_domain_DB($dataSearch);
        $total = [
            'all_social' => ($mien_bac['all_social'] + $mien_nam['all_social'] + $dong_bac['all_social']),
            'all_pr' => ($mien_bac['all_pr'] + $mien_nam['all_pr'] + $dong_bac['all_pr']),
            'all_kol' => ($mien_bac['all_kol'] + $mien_nam['all_kol'] + $dong_bac['all_kol']),
            'all_ooh' => ($mien_bac['all_ooh'] + $mien_nam['all_ooh'] + $dong_bac['all_ooh']),
            'all_other' => ($mien_bac['all_other'] + $mien_nam['all_other'] + $dong_bac['all_other']),
        ];
        $all_mien_bac = $mien_bac['all_social'] + $mien_bac['all_pr'] + $mien_bac['all_kol']+ $mien_bac['all_ooh'] + $mien_bac['all_other'];
        $all_mien_nam = $mien_nam['all_social'] + $mien_nam['all_pr'] + $mien_nam['all_kol']+ $mien_nam['all_ooh'] + $mien_nam['all_other'];
        $all_dong_bac = $dong_bac['all_social'] + $dong_bac['all_pr'] + $dong_bac['all_kol']+ $dong_bac['all_ooh'] + $dong_bac['all_other'];
        $all_total    = array_sum($total);
        //dữ liệu bảng tổng kết thúc

        $all_domain = $this->macomRepository->get_all_domain();
        $code_area = $this->areaRepository->getCodeArea();
        $stores = $this->storeRepository->getActiveList();

        //dữ liệu không lọc theo filter
        $arrStores = [];
        $groupById = $this->macomRepository->groupByStoresId();
        foreach ($stores as $item) {
            $title = $this->areaRepository->getCodeAreaName($item['code_area']);
            $arrStores[$title['title']] = $this->storeRepository->getByCodeArea($item['code_area'])['result'];
            $arrStores[$title['title']]['count'] = $this->storeRepository->getByCodeArea($item['code_area'])['count'];
            $idStore[] = $item['_id'];
        }
        foreach ($groupById as $i) {
            $arrId[] = $i['_id'];
        }
        //dữ liệu không lọc theo filter

        //dữ liệu được lọc theo filter
        $history = $this->macomRepository->groupByCodeArea($dataSearch);
        $dataFilter = [];
        foreach ($history as $i) {
            $title = $this->areaRepository->getCodeAreaName($i['code_area'][0]);
            if ($i['code_area'][0] == $title['code']) {
                $dataFilter[$title['title']][] = [
                    'id' => $i['_id'],
                    'store' => $i['store'][0],
                    'social_media' => $i['social_media'],
                    'pr_tv' => $i['pr_tv'],
                    'kol_koc' => $i['kol_koc'],
                    'ooh' => $i['ooh'],
                    'other' => $i['other'],
                ];
            }
        }
        // dd($dataFilter);
        //dữ liệu được lọc theo filter kết thúc
        $emailKT = $this->roleRepository->getEmailKeToan();
        return view('viewcpanel::macom.cost.index', [
            'mien_bac'      => $mien_bac,
            'all_mien_bac'  => $all_mien_bac,
            'mien_nam'      => $mien_nam,
            'all_mien_nam'  => $all_mien_nam,
            'dong_bac'      => $dong_bac,
            'all_dong_bac'  => $all_dong_bac,
            'total'         => $total,
            'all_total'     => $all_total,    
            'dataSearch'    => $dataSearch,
            'all_domain'    => $all_domain,
            'code_area'     => $code_area,
            'history'       => $history,
            'stores'        => $stores,
            'arrStores'     => $arrStores,
            'groupById'     => $groupById,
            'arrId'         => $arrId ?? [],
            'dataFilter'    => $dataFilter ?? [],
            'cpanelPath'    => env('CPANEL_TN_PATH'),
            'cpanelUrl'     => env('CPANEL_TN_PATH') . '/macom/index',
            'cpanelCreate'  => env('CPANEL_TN_PATH') . '/macom/create',
            'cpanelHistory'  => env('CPANEL_TN_PATH') . '/macom/history',
            'email'         => $email,
            'emailKT'       => $emailKT,
        ]);
    }

    /**
    * create
    * 
    * @param
    * @return view
    */
    public function create() {
        $user = session('user');
        $code_area = $this->areaRepository->getCodeArea();
        $create = route('viewcpanel::macom.cost.save');
        $dataName = $this->macomRepository->getCampaignName();
        return view('viewcpanel::macom.cost.create', [
            'user' => $user,
            'code_area' => $code_area,
            'create' => $create,
            'dataName' => $dataName,
            'cpanelUrl'  => env('CPANEL_TN_PATH') . '/macom/index/',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
        ]);
    } 

    /**
    * save
    * 
    * @param Illuminate\Http\Request;
    * @return json
    */
    public function save(Request $request) {
        $user = session('user');
        $dataRequest = $request->all();
        Log::channel('cpanel')->info('data save' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            "campaign_name"     => "required",
            "code_area"         => "required",
            "store_id"          => "required",
            "url"               => "required",
        ], [
            "campaign_name.required"    => "Tên chiến dịch đang để trống",
            "code_area.required"        => "Chưa có vùng nào được chọn",
            "store_id.required"         => "Chưa có phòng giao dịch nào được chọn",
            "url.required"              => "Chưa upload chứng từ",
        ]);
        if($validator->fails()) {
            Log::channel('cpanel')->info('data save validate' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors(),
            ]);
        }
        $dataName = $this->macomRepository->getCampaignName();
        if ($dataName) {
            $arrName = [];
            foreach ($dataName as $name) {
                $arrName[] = $name['campaign_name']; 
            }
            if (in_array(trim($dataRequest['campaign_name']), $arrName)) {
                return response()->json([
                    "status" => BaseController::HTTP_BAD_REQUEST,
                    "message" => "Tên chiến dịch đã tồn tại!",
                ]);
            }
        }
        $store = explode("," , $dataRequest['store_id']);
        $dataRequest['store'] = $store;
        $url = json_decode($dataRequest['url']);
        $dataRequest['url'] = $url;
        $dataRequest['created_by'] = $user['email'];
        $urlApi = config("routes.macom.save");
        Log::channel('cpanel')->info('Call Api: ' . $urlApi . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($urlApi, $dataRequest);
        Log::channel('cpanel')->info('Result Api: ' . $urlApi . ' ' . print_r($result->json(), true));
        if ($result->json()['data']['_id']) {
            $logs = $this->historyMacomRepository->wlog($result->json()['data']['_id'], config('viewcpanel.action_macom.create'), $dataRequest['created_by']);
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Nhập liệu thành công',
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }
    }

    /**
    * update
    * 
    * @param Illuminate\Http\Request;
    * @param string $id
    * @return json
    */
    public function update(Request $request, $id) {
        $user = session('user');
        $dataRequest = $request->all();
        Log::channel('cpanel')->info('data update' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            "campaign_name"     => "required",
            "code_area"         => "required",
            "store_id"          => "required",
            "url"               => "required",
        ], [
            "campaign_name.required"    => "Tên chiến dịch đang để trống",
            "code_area.required"        => "Chưa có vùng nào được chọn",
            "store_id.required"         => "Chưa có phòng giao dịch nào được chọn",
            "url.required"              => "Chưa upload chứng từ",
        ]);
        if($validator->fails()) {
            Log::channel('cpanel')->info('data update validate' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors(),
            ]);
        }
        $store = explode("," , $dataRequest['store_id']);
        $dataRequest['store'] = $store;
        if (!empty($store)) {
            foreach ($store as $i) {
                $store_name = $this->storeRepository->getStoreName($i);
                $store_new[] = [
                    'id' => $i,
                    'store' => $store_name,
                ];
            }
        }
        $url = json_decode($dataRequest['url']);
        $dataRequest['url'] = $url;
        $detail_history = $this->historyMacomRepository->findById($id);
        $data_old = [
            'social_media' => $detail_history['social_media'],
            'pr_tv' => $detail_history['pr_tv'],
            'kol_koc' => $detail_history['kol_koc'],
            'ooh' => $detail_history['ooh'],
            'other' => $detail_history['other'],
            'stores' => $detail_history['stores'],
            'url' => $detail_history['url'],
            'hits'  => $detail_history['hits'],
        ];
        $dataRequest['updated_by'] = $user['email'];
        $urlApi = config("routes.macom.update") ."/$id";
        Log::channel('cpanel')->info('Call Api: ' . $urlApi . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::post($urlApi, $dataRequest);
        Log::channel('cpanel')->info('Result Api: ' . $urlApi . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $logs = $this->historyMacomRepository->wlog($id, config('viewcpanel.action_macom.update'), $dataRequest['updated_by'], $data_old);
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Nhập liệu thành công',
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }
    }

    /**
    * history
    * 
    * @param Illuminate\Http\Request;
    * @return view
    */
    public function history(Request $request) {
        $user = session('user');
        $email = $user['email'];
        $emailKT = $this->roleRepository->getEmailKeToan();
        $dataSearch = $request->all();
        $history = $this->macomRepository->get_all_history($dataSearch);
        $array = $history->toArray();
        $page = $array['current_page'];
        $perPage = $array['per_page'];
        $perPage = ($page - 1) * $perPage;
        $code_area = $this->areaRepository->getCodeArea();
        $stores = $this->storeRepository->getActiveList();
        return view('viewcpanel::macom.cost.history', [
            'history' => $history,
            'code_area' => $code_area,
            'dataSearch' => $dataSearch,
            'stores'    => $stores,
            'perPage' => $perPage,
            'cpanelPath'    => env('CPANEL_TN_PATH'),
            'cpanelUrl'     => env('CPANEL_TN_PATH') . '/macom/index',
            'cpanelDetail'  => env('CPANEL_TN_PATH') . '/macom/detail/',
            'cpanelUpdate'  => env('CPANEL_TN_PATH') . '/macom/edit/',
            'cpanelHistory'  => env('CPANEL_TN_PATH') . '/macom/history/',
            'email'         => $email,
            'emailKT'       => $emailKT,
        ]);
    }

    /**
    * detail
    * 
    * @param string $id
    * @return view
    */
    public function detail($id) {
        $detail = $this->macomRepository->findById($id);
        $stores = $this->storeRepository->getStoreByCodeArea($detail['code_area']);
        $logs =   $this->historyMacomRepository->findLog($id);
        return view('viewcpanel::macom.cost.detail', [
            'detail' => $detail,
            'stores' => $stores,
            'logs'   => $logs,
            'cpanelHistory'  => env('CPANEL_TN_PATH') . '/macom/history/',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
        ]);
    }

    /**
    * index
    * 
    * @param string $id
    * @return view
    */
    public function edit($id) {
        $detail = $this->macomRepository->findById($id);
        $stores = $this->storeRepository->getStoreByCodeArea($detail['code_area']);
        $code_area = $this->areaRepository->getCodeArea();
        return view('viewcpanel::macom.cost.update', [
            'detail' => $detail,
            'code_area' => $code_area,
            'stores' => $stores,
            'cpanelHistory'  => env('CPANEL_TN_PATH') . '/macom/history/',
            'cpanelPath'    => env('CPANEL_TN_PATH'),
        ]);
    }

    /**
    * getStoreByCodeArea
    * 
    * @param Illuminate\Http\Request;
    * @return json
    */
    public function getStoreByCodeArea(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.macom.getStoreByCodeArea');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
    * getAreaByDomain
    * 
    * @param Illuminate\Http\Request;
    * @return json
    */
    public function getAreaByDomain(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.macom.getAreaByDomain');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }
}
