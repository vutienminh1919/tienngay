<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\TradeStorage;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use MongoDB\BSON\Regex;

class TradeStorageRepository implements TradeStorageRepositoryInterface
{
    /**
     * @var Model
     */
    protected $tradeStorageModel;


    /**
     * HcnsRepository .
     *
     * @param
     */
    public function __construct(TradeStorage $tradeStorageModel)
    {
        $this->tradeStorageModel = $tradeStorageModel;
    }

    /**
     * get item by store id
     * @param $id string
     * @return array
     * */

    public function getItemByStoreId($id)
    {
        $result = $this->tradeStorageModel->where('store_id', $id)->first();
        if ($result) {
            return $result;
        }
        return false;
    }

    /**
     * get all
     * @param $dataSearch array
     * @return array
     * */

    public function getAll($dataSearch)
    {
        $result = $this->tradeStorageModel;
        if (!empty($dataSearch['store'])) {
            if (is_array($dataSearch['store'])) {
                $result = $result->whereIn(TradeStorage::STORE_ID, $dataSearch['store']);
            } else {
                $result = $result->where(TradeStorage::STORE_ID, $dataSearch['store']);
            }
        }
        $result = $result->orderBy(TradeStorage::CREATED_AT, 'desc')
            ->get()->toArray();
        return $result;
    }

    /**
     * get all item
     * @param $data array
     * @return array
     * */

    public function getAllItem($data)
    {
        $condition = [];
        $name = $data['name'] ?? "";
        $code_item = $data['code_item'] ?? "";
        $type = $data['type'] ?? "";
        if($name){
            $condition ['items.name'] =  $name;
        }
        if($code_item){
            $condition ['items.code_item'] =  $code_item;
        }
        if($type){
            $condition ['items.type'] =  $type;
        }
        $group = $this->tradeStorageModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$unwind' => '$items'],
                    ['$match' => (object)$condition
                    ],
                ['$group' =>
                    [
                        "_id" => '$items.code_item',
                        "quantity_stock" => ['$sum' => '$items.quantity_stock'],
                        "quantity_broken" => ['$sum' => '$items.quantity_broken'],
                        "name" => ['$addToSet' => '$items.name'],
                        "type" => ['$addToSet' => '$items.type'],
                        "specification" => ['$addToSet' => '$items.specification'],
                    ]
                ],
                ['$sort' => ['_id' => 1]],
                ['$project' =>
                    [
                        'quantity_stock' => 1,
                        'quantity_broken' => 1,
                        'name' => 1,
                        'type' => 1,
                        'specification' => 1,
                    ]
                ],

            ]);
        });

        return $group;
    }

    /**
     * detail storage
     * @param $id string
     * @return array
     * */

    public function detail($id)
    {
        $result = $this->tradeStorageModel::where(TradeStorage::ID, $id)->first();
        if ($result) {
            return $result->toArray();
        }
        return [];
    }

    /**
     * get by store id
     * @param $storeId string
     * @return array
     * */

    public function getByStoreId($storeId)
    {
        $result = $this->tradeStorageModel::where(TradeStorage::STORE_ID, $storeId)->first();
        if ($result) {
            return $result->toArray();
        }
        return [];

    }

    public function getItemByStoreIdToArray($id) {
        $result = $this->tradeStorageModel->where('store_id', $id)->first();
        if ($result) {
            return $result->toArray();
        }
        return false;
    }

    public function updateQuantity($data=[]) {
        $result = $this->tradeStorageModel::where(TradeStorage::ID, $data['_id'])->update([TradeStorage::ITEMS => $data['items']]);
        if ($result) {
            return $result;
        }
        return false;
    }

    public function create($data=[]) {
        if (empty($data)) {
            return false;
        }
        $input = [
            TradeStorage::STORE_ID          => $data['store_id'],
            TradeStorage::STORE_NAME        => $data['store_name'],
            TradeStorage::ITEMS             => $data['items'] ?? [],
            TradeStorage::LOGS              => $data['logs'] ?? [],
            TradeStorage::CREATED_BY        => $data['created_by'] ?? "",
        ];
        $create = $this->tradeStorageModel->create($input);
        if ($create) {
            return $create;
        }
        return false;
    }

    /**
     * find all item
     * @param $id string
     * @return array
     * */

    public function findExistsItem($id) {
        $codeItems = $this->tradeStorageModel::raw(function ($collection) use ($id) {
            return $collection->aggregate([
                [ '$unwind' => '$items'],
                ['$match' => [
                    'store_id' => $id,
                ]],
                ['$group' => [
                    "_id" => "",
                    "code_item" => [
                        '$push' => '$items.code_item' ,
                    ]
                ]],
                ['$project' =>
                    [
                        'code_item' => 1,
                        '_id' => 0,
                    ]
                ],

            ]);
        });
        return $codeItems->toArray();
    }

    public function pushItem($storeId, $item) {
        $data = [
            TradeStorage::ITEM_KEY              => data_get($item, 'key', time().'1'),
            TradeStorage::ITEM_ID               => $item['item_id'],
            TradeStorage::ITEM_CODE             => $item['code_item'],
            TradeStorage::ITEM_NAME             => $item['name'],
            TradeStorage::ITEM_TYPE             => $item['type'],
            TradeStorage::ITEM_SPECIFICATIONS   => $item['specification'],
            TradeStorage::ITEM_QUANTITY_STOCK   => $item['quantity_stock'] ?? 0,
            TradeStorage::ITEM_QUANTITY_BROKEN  => $item['quantity_broken'] ?? 0,
            TradeStorage::ITEM_CATEGORY         => $item['category'],
            TradeStorage::ITEM_TARGET           => $item['taget_goal'],
            TradeStorage::CREATED_AT            => time()
        ];
        $push = $this->tradeStorageModel::where(TradeStorage::STORE_ID, $storeId)
        ->push(TradeStorage::ITEMS, $data);
        if ($push) {
            return $push;
        }
        return false;
    }

    /**
     * get all store storage
     * @return array
     * */

    public function getAllStore()
    {
        $result = $this->tradeStorageModel;
        return $result->select('store_id', 'items')->get()->toArray();

    }

     /**
     * update quantity storage item
     * @param $data array
     * @param $item array
     * @return boolean
     * */

    public function updateQuantityStorage($data, $item)
    {
        $update = $this->tradeStorageModel::raw(function ($collection) use ($data, $item) {
            return $collection->updateMany(
                [TradeStorage::ID => new \MongoDB\BSON\ObjectID($data['_id'])],
                ['$pull' => ["items" => ['key' => $item['key']]]],
                ['upsert' => false],
                ["multi" => true]
            );
        });
        $push = $this->tradeStorageModel::where(TradeStorage::ID, $data['_id'])
            ->push('items', $item);
        return $push;
    }

     /**
     * get all name item and type
     * @return array
     * */
    public function getALlNameItemStorage()
    {
         $nameItems = $this->tradeStorageModel::raw(function ($collection) {
             return $collection->aggregate([
                 ['$unwind' => '$items'],
                 ['$group' => [
                     "_id" => '$items.name',
                     "type" =>
                         ['$addToSet' => '$items.type'],

                 ]],
                 ['$project' =>
                     [
                         'type' => 1,
                         '_id' => 1,
                     ]
                 ],

             ]);
         });
        return $nameItems;

    }

    /**
     * fetch storage item
     * @param $storeId string
     * @param $itemCode string
     * @return array
     * */
    public function fetchItem($storeId, $itemCode) {
        $fetch = $this->tradeStorageModel::raw(function ($collection) use ($storeId, $itemCode) {
            return $collection->aggregate([
                ['$match' => (object)[
                    TradeStorage::STORE_ID => $storeId
                ]],
                ['$unwind' => '$items'],
                ['$match' => (object)[
                    'items.code_item' => $itemCode

                ]],
                ['$limit' => 1],
                ['$project' => [
                    '_id' => 1,
                    'items' => 1
                ]]
            ]);
        });

        if (!empty($fetch[0][TradeStorage::ITEMS])) {
            return $fetch[0][TradeStorage::ITEMS];
        }
        return [];
    }

    /**
     * update iteam's stock
     * @param $storeId string
     * @param $itemCode string
     * @param $stock number
     * @return boolean
     * */
    public function updateQuantityStock($storeId, $itemCode, $stock) {

        $existedItem = $this->fetchItem($storeId, $itemCode);
        if (empty($existedItem)) {
            return false;
        }
        $existedItem[TradeStorage::ITEM_QUANTITY_STOCK] = (int)($existedItem[TradeStorage::ITEM_QUANTITY_STOCK] + $stock);
        $existedItem[TradeStorage::UPDATED_AT] = time();

        // Find element in array and remove
        $update = $this->tradeStorageModel::raw(function ($collection) use ($storeId, $existedItem) {
            return $collection->updateMany(
                [TradeStorage::STORE_ID => $storeId],
                ['$pull' => [TradeStorage::ITEMS =>
                    [TradeStorage::ITEM_CODE => $existedItem[TradeStorage::ITEM_CODE]]]
                ],
                ['upsert' => false],
                ["multi" => true]
            );
        });
        // // repush removed item to array
        $push = $this->tradeStorageModel->where(TradeStorage::STORE_ID, $storeId)
        ->push(TradeStorage::ITEMS, $existedItem);
        return true;
    }


    public function findExistsCodeItem($storeId, $code_item) {
        $fetch = $this->tradeStorageModel::raw(function ($collection) use ($storeId, $code_item) {
            return $collection->aggregate([
                ['$match' => (object)[
                    TradeStorage::STORE_ID => $storeId
                ]],
                ['$unwind' => '$items'],
                ['$match' => (object)[
                    'items.code_item' => $code_item

                ]],
                ['$limit' => 1],
                ['$project' => [
                    '_id' => 1,
                    'items' => 1
                ]]
            ]);
        });
        if (!empty($fetch[0][TradeStorage::ITEMS])) {
            return true;
        }
        return false;
    }

}

