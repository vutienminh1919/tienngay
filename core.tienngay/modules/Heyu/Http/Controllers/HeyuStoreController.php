<?php

namespace Modules\Heyu\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\HeyuStoreRepository;
use Modules\MongodbCore\Repositories\StoreRepository;

class HeyuStoreController extends BaseController
{

    private $heyuStoreRepository;
    public function __construct(HeyuStoreRepository $heyuStoreRepository,
                                StoreRepository $storeRepository)
    {
       $this->heyuStoreRepository = $heyuStoreRepository;
       $this->storeRepository = $storeRepository;
    }

    /**
    * Lấy tất cả đồng phục
    * @param  Illuminate\Http\Request
    * @return $response json
    */

    public function getAllUniform()
    {
        $result = $this->heyuStoreRepository->getAll();
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('Heyu::messages.success'),
            'data' => $result
        ];
        Log::channel('heyu')->info('Heyu getAllUniform response: ' . print_r($response, true));
        return response()->json($response);
    }

     /**
    * Nhập kho đồng phục (nếu chưa có thì tạo mới)
    * @param $request Illuminate\Http\Request
    * @return $response json
    */

    public function updateOrInsertStoreTienngay(Request $request)
    {
        $data = $request->all();
        $store = $this->heyuStoreRepository->getAllCreatedStorePgd();
        $arrStoreId = [];
        foreach($store as $item){
            $arrStoreId[] = $item['store']['id'];
        }
        if (in_array($data['store']['id'], $arrStoreId)) {
            $result = $this->heyuStoreRepository->updateStoreTienngay($data);
            $this->heyuStoreRepository->logs($data['store']['id'], config('heyu.store.action.updated'), $data['updated_by'], $data);
        } else {
            $result = $this->heyuStoreRepository->insert($data);
            $this->heyuStoreRepository->logs($result->store['id'],  config('heyu.store.action.updated'), $data['created_by'], $data);
        }
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('Heyu::messages.success'),
            'data' => $result
        ];
        Log::channel('heyu')->info('Heyu update response: ' . print_r($response, true));
        return response()->json($response);

    }

     /**
    * Chỉnh sửa kho đồng phục
    * @param $request Illuminate\Http\Request
    * @return $response json
    */

    public function editStoreTienngay(Request $request)
    {
        $data = $request->all();
        $result = $this->heyuStoreRepository->edit($data);
        $this->heyuStoreRepository->logID($data['id'],  config('heyu.store.action.edited'), $data['updated_by'], $data);
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('Heyu::messages.success'),
            'data' => $result
        ];
        Log::channel('heyu')->info('Heyu update response: ' . print_r($response, true));
        return response()->json($response);
    }


}
