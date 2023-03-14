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
use Modules\MongodbCore\Entities\DeliveryBill;

class DeliveryBillController extends BaseController
{
    protected $storeRepository;
    protected $deliveryBillRepository;
    protected $tradeItemRepository;
    protected $tradeStorageRepository;
    protected $areaRepository;
    protected $roleRepository;
    public function __construct(StoreRepository $storeRepository, 
                                DeliveryBillRepository $deliveryBillRepository, 
                                TradeItemRepository $tradeItemRepository,
                                TradeStorageRepository $tradeStorageRepository,
                                AreaRepository $areaRepository,
                                RoleRepository $roleRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->deliveryBillRepository = $deliveryBillRepository;
        $this->tradeItemRepository = $tradeItemRepository;
        $this->tradeStorageRepository = $tradeStorageRepository;
        $this->areaRepository = $areaRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
    * Tạo phiếu xuất kho (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @param String $id;
    * @return json
    * */
    public function pgdSave(Request $request) {
        $dataRequest = $request->all();
        log::channel('marketing')->info('data save ' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'items.*.category' => 'required',
            'items.*.name' => 'required',
            'items.*.amount' => 'required',
            'items.*.specification' => 'required',
            'items.*.taget_goal' => 'required',
            'stores' => 'required',
            'url' => 'required'
        ], [
            'items.*.category.required' => 'Hạng mục không để trống',
            'items.*.name.required' => 'Tên sản phẩm không để trống',
            'items.*.amount.required' => 'Số lượng không để trống',
            'items.*.specification.required' => 'Quy cách không để trống',
            'items.*.taget_goal.required' => 'Mục tiêu triển khai không để trống',
            'stores.required' => 'Phòng giao dịch không để trống',
            'url.required' => 'Chứng từ không để trống',
        ]);
        if ($validator->fails()) {
            Log::channel('marketing')->info('create_bill_from_pgd validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
                'errors'                => $validator->errors(),
            ]);
        }
        foreach ($dataRequest['items'] as $item) {
            $list[] =$item;
        }
        $items_storage = $this->tradeStorageRepository->getItemByStoreIdToArray($dataRequest['stores']['id']);
        if ($items_storage) {
            foreach ($items_storage['items'] as $key => $item) {
                foreach ($list as $i) {
                    if ($i['name'] == $item['code_item']) {
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
        $input = [
            DeliveryBill::CREATED_BY        => $dataRequest['created_by'] ?? "",
            DeliveryBill::STORES            => $dataRequest['stores'] ?? "",
            DeliveryBill::NOTE              => $dataRequest['note'] ?? "",
            'list'                          => $list ?? [],
            'url'                           => $dataRequest['url'] ?? [],
        ];
        Log::channel('marketing')->info('data input' .print_r($input, true));
        $create = $this->deliveryBillRepository->create($input);
        if ($create) {
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
    * lấy ấn phẩm thuộc của pgd (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function getItemByStore(Request $request) {
        $dataRequest = $request->all();
        $result = $this->tradeStorageRepository->getItemByStoreId($dataRequest['id']);
        if ($result) {
            $arr = [];
            $arr['store_id'] = $result['store_id'];
            $arr['store_name'] = $result['store_name'];
            foreach ($result['items'] as $key => $item) {
                $detailItem = $this->tradeItemRepository->detailByCodeItem($item['code_item']);
                $item['path'] = $detailItem['path'];
                $arr['items'][] = $item;
            }
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $arr,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * update chứng từ (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @param String $id;
    * @return json
    * */
    public function updateLisence(Request $request, $id) {
        $dataRequest = $request->all();
        log::channel('marketing')->info('data save ' . print_r($dataRequest, true));
        $update = $this->deliveryBillRepository->updateLisence($dataRequest['path'], $id);
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
    * Lấy khu vục theo vùng (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function getAreaByDomain(Request $request) {
        $dataRequest = $request->all();
        $domain = $this->areaRepository->getAreaByDomain($dataRequest['domain']);
        if ($domain) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $domain,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }

    /**
    * Lấy pgd theo khu vực (phiếu xuất kho) 
    * @param Illuminate\Http\Request;
    * @return json
    * */
    public function getStoreByArea(Request $request) {
        $dataRequest = $request->all();
        $code_area = $this->storeRepository->getStoreByArea($dataRequest['code_area']);
        if ($code_area) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $code_area,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => [],
        ]);
    }
}
