<?php

namespace Modules\ViewCpanel\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\MongodbCore\Entities\TradeItem;
use Modules\MongodbCore\Repositories\AreaRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MongodbCore\Repositories\StoreRepository;


class TradeItemController extends BaseController
{
    public function __construct(TradeItemRepository $tradeItemRepository,
                                StoreRepository     $storeRepository,
                                AreaRepository      $areaRepository,
                                TradeItem $tradeItem)
    {
        $this->tradeItemRepository = $tradeItemRepository;
        $this->storeRepository = $storeRepository;
        $this->areaRepository = $areaRepository;
        $this->tradeItem = $tradeItem;

    }

    public function createItem(Request $request)
    {
        $data = $request->all();
        $stores = $this->storeRepository->getActiveList();
        $arrStores = [];
        foreach ($stores as $item) {
            $title = $this->areaRepository->getCodeAreaTitle($item['code_area']);
            $arrStores[$title['title']] = $this->storeRepository->getStoreByArea($item['code_area']);
        }
        $name_all = $this->tradeItemRepository->getAllName();
        $name = [];
        if (!empty($name_all)) {
            foreach ($name_all as $item) {
                $name[] = $item['detail']['name'];
            }
            $name = array_values(array_unique($name));
        }
        return view('viewcpanel::trade.item.create', [
            'urlInsert' => route('viewcpanel::trade.insertItem'),
            'urlUpload' => route('viewcpanel::trade.uploadImg'),
            'name' => $name,
            'arrStores' => $arrStores,
            'cpanelUrl' => route('viewcpanel::trade.listItem'),
            'cpanelPath' => env('CPANEL_TN_PATH'),
        ]);
    }

    public function getTypeByName(Request $request)
    {
        $dataPost = $request->all();
        $url = config('routes.trade.item.getTypeByName');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function insertItem(Request $request)
    {
        $user = session('user');
        $email = $user['email'];
        $data = $request->all();
        $validate = Validator::make($data, [
            'category' => 'required',
            'target_goal' => 'required',
            'motivating_goal' => 'required',
            'store' => 'required',
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'size' => 'required',
            'material' => 'required',
            'tech' => 'required',
            'path' => 'required',
        ],
            [
                'category.required' => "Hạng mục không được để trống !",
                'target_goal.required' => "Mục tiêu triển khai không được để trống !",
                'motivating_goal.required' => "Mục tiêu thúc đẩy không được để trống !",
                'store.required' => "Khu vực áp dụng không được để trống !",
                'name.required' => "Tên ấn phẩm không được để trống !",
                'type.required' => "Loại ấn phẩm không được để trống !",
                'price.required' => "Đơn giá dự kiến không được để trống !",
                'size.required' => "Kích cỡ ấn phẩm không được để trống !",
                'material.required' => "Chất liệu ấn phẩm không được để trống !",
                'tech.required' => "Kĩ thuật ấn phẩm không được để trống !",
                'path.required' => "Ảnh không được để trống !",
            ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        $dataPost = [
            'category' => $data['category'],
            'target_goal' => $data['target_goal'],
            'motivating_goal' => explode(',', $data['motivating_goal']),
            'store' => explode(',', $data['store']),
            'name' => $data['name'],
            'type' => $data['type'],
            'price' => $data['price'],
            'size' => $data['size'],
            'material' => $data['material'],
            'tech' => $data['tech'],
            'path' => explode(',', $data['path']),
            'created_by' => $email,
            'date' => $data['date'] ?? ""
        ];
        $url = config('routes.trade.item.insert');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == "200") {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => $result->json()['message'],
                "data" => $result->json()['data']
            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" => $result->json()['message'] ?? "Thất bại",
            ]);
        }


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

    public function listItem(Request $request)
    {
        $dataSearch = $request->all();
        $result = $this->tradeItemRepository->getALlItem($dataSearch)->toArray();
        $stores = $this->storeRepository->getActiveList();
        $typeSearch = [];
        if(!empty($dataSearch['name'])){
            $nameSearch = $dataSearch['name'];
            $typeSearch = $this->tradeItemRepository->groupByName($nameSearch);
            $typeSearch = iterator_to_array($typeSearch);
        }
        $motivating_goal_search = [];
        if(!empty($dataSearch['motivating_goal'])){
            $motivating_goal_search = $dataSearch['motivating_goal'];
        }
        foreach ($result as $key => $item) {
            $arrStores = [];
            $arrName = [];
            foreach ($item['store'] as $i) {
                $title = $this->areaRepository->getCodeAreaTitle($i['code_area']);
                $store = $this->storeRepository->getStoreNameandCodeArea($i['id']);
                if ($store) {
                    $arrStores[$title['title']][] = $store->toArray();
                }
                $arrName[] = $this->storeRepository->getStoreName($i['id']);
            }
            $result[$key]['store'] = $arrStores;
            $result[$key]['storeExport'] = is_array($arrName) ? implode(', ', $arrName) : $arrName;
            foreach ($item['motivating_goal'] as &$k) {
                if ($k == "DKXM") {
                    $k = TradeItem::DKXM;
                } elseif ($k == "DKOTO") {
                    $k = TradeItem::DKOTO;
                } else {
                    $k = TradeItem::OTHER;
                }
            }
            unset($k);
            $result[$key]['motivating_goal'] = $item['motivating_goal'];
            if ($item['category'] == "item") {
                $result[$key]['category'] = TradeItem::ITEM;
            } else {
                $result[$key]['category'] = TradeItem::PUBLICATION;
            }
            if ($item['target_goal'] == "direct") {
                $result[$key]['target_goal'] = TradeItem::DIRECT;
            } else {
                $result[$key]['target_goal'] = TradeItem::INDIRECT;
            }
        }

        $name_all = $this->tradeItemRepository->getAllName();
        $name = [];
        if (!empty($name_all)) {
            foreach ($name_all as $item) {
                $name[] = $item['detail']['name'];
            }
            $name = array_values(array_unique($name));
        }
        $storeList = $this->storeRepository->getActiveList();
        $data['store'] = $storeList;
        $data['blockItemUrl'] = route('viewcpanel::trade.blockItem');
        $data['listItemExport'] = $result;
        $result = collect($result);
        $result = $this->paginate($result);
        $data['listItem'] = $result;
        $data['listItem']->withPath('');
        $data['arrStores'] = $arrStores ?? [];
        $data['name'] = $name;
        $data['cpanelPath'] = env('CPANEL_TN_PATH');
        $data['cpanelUrl'] = route('viewcpanel::trade.listItem');
        $data['cpanelCreate'] = route('viewcpanel::trade.createItem');
        $data['urlSearch'] = route('viewcpanel::trade.listItem');
        $data['typeSearch'] = $typeSearch;
        $data['motivating_goal_search'] = $motivating_goal_search;
        $data['moti'] = TradeItem::$motivating_goal;
//        $data['cpanelDetail'] = env('CPANEL_TN_PATH') . '/trade/itemDetail/';
//        $data['cpanelUpdate'] = env('CPANEL_TN_PATH') . '/trade/itemUpdate/';
        $data['dataSearch'] = $dataSearch;
        return view('viewcpanel::trade.item.list', $data);

    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function blockItem(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.item.blockItem');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::post($url, $data);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    public function detailItem($id)
    {
        $detail = $this->tradeItemRepository->detailItem($id);
        $countStore = count($detail['store']);
        $arr = [];
        foreach ($detail['store'] as $item) {
            $title = $this->areaRepository->getCodeAreaTitle($item['code_area']);
            $store = $this->storeRepository->getStoreNameandCodeArea($item['id']);
            if ($store) {
                $arr[$title['title']][] = $store->toArray();
            }
        }
        $detail['store'] = $arr;
        foreach ($detail['motivating_goal'] as &$item) {
            if ($item == "DKXM") {
                $item = TradeItem::DKXM;
            } elseif ($item == "DKOTO") {
                $item = TradeItem::DKOTO;
            } else {
                $item = TradeItem::OTHER;
            }
        }
        unset($item);
        if($detail['category'] == "item"){
            $detail['category'] = TradeItem::ITEM;
        }else{
            $detail['category'] = TradeItem::PUBLICATION;
        }

        if($detail['target_goal'] == "direct"){
            $detail['target_goal'] = TradeItem::DIRECT;
        }else{
            $detail['target_goal'] = TradeItem::INDIRECT;
        }
        $stores = $this->storeRepository->getActiveList();
        $arrStores = [];
        foreach ($stores as $item) {
            $title = $this->areaRepository->getCodeAreaTitle($item['code_area']);
            $arrStores[$title['title']] = $this->storeRepository->getStoreByArea($item['code_area']);
        }
        $specification = explode(',', $detail['detail']['specification']);
        $detail['detail']['size'] = $specification[0];
        $detail['detail']['material'] = $specification[1];
        $detail['detail']['tech'] = $specification[2];
        return view('viewcpanel::trade.item.detail',
            [
                'detail' => $detail,
                'arrStores' => $arrStores,
                'cpanelPath' => env('CPANEL_TN_PATH'),
                'cpanelUrl' => route('viewcpanel::trade.listItem'),
                'blockItemUrl' => route('viewcpanel::trade.blockItem'),
                'countStore' => $countStore,
            ]);

    }

    public function editItem($id)
    {
        $detail = $this->tradeItemRepository->detailItem($id);
        $stores = $this->storeRepository->getActiveList();
        $detail['store'] = array_column($detail['store'], 'id');
        $arrStores = [];
        foreach ($stores as $item) {
            $title = $this->areaRepository->getCodeAreaTitle($item['code_area']);
            $arrStores[$title['title']] = $this->storeRepository->getStoreByArea($item['code_area']);
        }

        foreach ($detail['motivating_goal'] as &$item) {
            if ($item == "DKXM") {
                $item = TradeItem::DKXM;
            } elseif ($item == "DKOTO") {
                $item = TradeItem::DKOTO;
            } else {
                $item = TradeItem::OTHER;
            }
        }
        unset($item);
        if($detail['category'] == "item"){
            $detail['category'] = TradeItem::ITEM;
        }else{
            $detail['category'] = TradeItem::PUBLICATION;
        }

        if($detail['target_goal'] == "direct"){
            $detail['target_goal'] = TradeItem::DIRECT;
        }else{
            $detail['target_goal'] = TradeItem::INDIRECT;
        }
        unset($ct);
        $specification = explode(',', $detail['detail']['specification']);
        $detail['detail']['size'] = $specification[0];
        $detail['detail']['material'] = $specification[1];
        $detail['detail']['tech'] = $specification[2];
        return view('viewcpanel::trade.item.edit',
            [
                'detail' => $detail,
                'arrStores' => $arrStores,
                'urlUpload' => route('viewcpanel::trade.uploadImg'),
                'cpanelPath' => env('CPANEL_TN_PATH'),
                'cpanelUrl' => route('viewcpanel::trade.listItem'),
                'detailUrl' => route('viewcpanel::trade.detailItem', ['id' => $id])
            ]);

    }

    public function updateItem(Request $request, $id)
    {
        $data = $request->all();
        Log::channel('cpanel')->info('TradeItem updateItem ' . print_r($data, true));
        $user = session('user');
        $email = $user['email'];
        $validate = Validator::make($data, [
            'price' => 'required',
            'store' => 'required',
            'path' => 'required',
        ],
            [
                'price.required' => "Đơn giá không được để trống !",
                'store.required' => "Khu vực áp dụng không được để trống !",
                'path.required' => "Ảnh mô tả không được để trống !",
            ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        $dataPost = [
            'store' => explode(',', $data['store']),
            'price' => $data['price'],
            'path' => explode(',', $data['path']),
            'created_by' => $email,
            'date' => $data['date'] ?? ""
        ];
        $url = config('routes.trade.item.update') . "/" . $id;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());

    }

    /**
     * get trade's item list
     * @param $request Illuminate\Http\Request;
     * @return json
     * */
    public function getItemsByStoreId(Request $request)
    {
        $url = config('routes.trade.item.getItemsByStoreId');
        $storeId = $request->input('store_id');
        $dataPost = [
            'store_id' => $storeId
        ];
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        return response()->json($result->json());
    }

}
