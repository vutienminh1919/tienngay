<?php

namespace Modules\Marketing\Http\Controllers;

use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MongodbCore\Repositories\StoreRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemDetailRepositoryInterface as TradeItemDetailRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class TradeItemController extends BaseController
{
    public function __construct(TradeItemRepository $tradeItemRepository,
                                StoreRepository     $storeRepository)
    {
        $this->tradeItemRepository = $tradeItemRepository;
        $this->storeRepository = $storeRepository;

    }

    public function getALlItem(Request $request)
    {
        $data = $request->all();
        $name = $data['name'] ?? "";
        $result = $this->tradeItemRepository->groupByName($name);
        return response()->json($result);

    }

    public function insert(Request $request)
    {

        $item_id = "";
        $data = $request->all();
//        return response()->json($data);
//        $a = $this->random_string(8);
//        dd($a);
        $item_id = "AP" . time();
        $data['item_id'] = $item_id;
        foreach ($data['store'] as $item) {
            $dataStore = $this->storeRepository->getStoreNameandCodeArea($item);
            $store[] = [
                'id' => $item,
                'name' => $dataStore['name'],
                'code_area' => $dataStore['code_area']
            ];
        };
        $data['store'] = $store;
//        $detailDuplicateBlocked = $this->tradeItemRepository->checkDuplicateBlocked($data);
////        dd($detailDuplicateBlocked);

        $detailDuplicateActive = $this->tradeItemRepository->checkDuplicateActived($data);
//        if ($detailDuplicateBlocked) {
//            $this->tradeItemRepository->updateActive($detailDuplicateBlocked);
//            $this->tradeItemRepository->wlog($detailDuplicateBlocked['_id'], 'active', $data['created_by']);
//            $response = [
//                BaseController::STATUS => BaseController::HTTP_OK,
//                BaseController::MESSAGE => "Kích hoạt sản phẩm cũ thành công",
//            ];
//            return response()->json($response);
//        }
        if ($detailDuplicateActive) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => "Ấn phẩm đã tồn tại, không thể thêm mới. Vui lòng kiểm tra lại!",
            ];
            return response()->json($response);
        }
        $result = $this->tradeItemRepository->insert($data);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $result,
        ];
        return response()->json($response);

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        foreach ($data['store'] as $item) {
            $dataStore = $this->storeRepository->getStoreNameandCodeArea($item);
            $store[] = [
                'id' => $item,
                'name' => $dataStore['name'],
                'code_area' => $dataStore['code_area']
            ];
        };

        $data['store'] = $store;
        $update = $this->tradeItemRepository->update($data, $id);
        $this->tradeItemRepository->wlog($id, 'chỉnh sửa', $data['created_by']);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "Chỉnh sửa thành công",
            BaseController::DATA => $update,
        ];
        return response()->json($response);

    }

    public function blockItem(Request $request)
    {
        $data = $request->all();
        $block = $this->tradeItemRepository->blockItem($data);
        $detail = $this->tradeItemRepository->detailItem($data['id']);
        $this->tradeItemRepository->wlog($data['id'], 'block', $detail['updated_by']);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $block,
        ];
        return response()->json($response);
    }

    public function getTypeByName(Request $request)
    {
        $data = $request->all();
        $name = $data['name'];
        $result = $this->tradeItemRepository->groupByName($name);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $result,
        ];
        return response()->json($response);

    }

    public function random_string($length)
    {
        $a = hash_hmac('SHA256', uniqid(), mt_rand());
        $random = substr(strtoupper(md5($a)), 0, $length);
        return $random;
    }

    /**
     * get trade's item list by storeId
     * @param $request Illuminate\Http\Request;
     * @return json
     * */
    public function getItemsByStoreId(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        Log::channel('marketing')->info('tradeItems getItemsByStoreId: ' . print_r($data, true));
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Marketing::messages.format_data_is_not_correct'),
                'data' => $data
            ];
            Log::channel('marketing')->info('tradeItems getItemsByStoreId data is not an array: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'store_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => $data,
                'errors' => $validator->errors()
            ];
            Log::channel('marketing')->info('tradeItems getItemsByStoreId validate failed: ' . print_r($response, true));
            return response()->json($response);
        }
        $storeId = $data['store_id'];
        $items = $this->tradeItemRepository->getItemsByStoreId($storeId);
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('Marketing::messages.success'),
            'data' => $items,
        ];
        Log::channel('marketing')->info('tradeItems getItemsByStoreId validate failed: ' . print_r($response, true));
        return response()->json($response);
    }

    public function getItemByItemId(Request $request)
    {
        $data = $request->all();
        $result = $this->tradeItemRepository->detailByCodeItem($data['item_id']);
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => "OK",
            BaseController::DATA => $result,
        ];
        return response()->json($response);

    }

}
