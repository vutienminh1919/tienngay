<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\TradeItem;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface;

class TradeItemRepository implements TradeItemRepositoryInterface
{
    protected $tradeItem;

    public function __construct(TradeItem $tradeItem)
    {
        $this->tradeItem = $tradeItem;
    }

    public function getMaxItemId()
    {
        $result = $this->tradeItem
            ->orderBy(TradeItem::CREATED_AT, 'desc')
            ->first();
        return $result;

    }

    public function getALlItem($dataSearch = [], $export = false)
    {

        $listRecord = $this->tradeItem;
        if (!empty($dataSearch['item_id'])) {
            $listRecord = $listRecord->where(TradeItem::ITEM_ID, '$regex', '/' .trim($dataSearch['item_id']). '/i');
        }
        if (!empty($dataSearch['store'])) {
            $listRecord = $listRecord->where(TradeItem::STORE . '.' . TradeItem::STORE_ID, $dataSearch['store']);
        }
        if (!empty($dataSearch['name'])) {
            $listRecord = $listRecord->where(TradeItem::DETAIL . '.' . TradeItem::NAME, $dataSearch['name']);
        }
        if (!empty($dataSearch['type'])) {
            $listRecord = $listRecord->where(TradeItem::DETAIL . '.' . TradeItem::TYPE, $dataSearch['type']);
        }
        if (!empty($dataSearch['category'])) {
            $listRecord = $listRecord->where(TradeItem::CATEGORY, $dataSearch['category']);
        }
        if (!empty($dataSearch['target_goal'])) {
            $listRecord = $listRecord->where(TradeItem::TARGET_GOAL, $dataSearch['target_goal']);
        }
        if (!empty($dataSearch['motivating_goal'])) {
            $listRecord = $listRecord->where(TradeItem::MOTIVATING_GOAL, 'all', $dataSearch['motivating_goal']);
        }
        $listRecord = $listRecord->where(TradeItem::STATUS, TradeItem::STATUS_ACTIVE);
        if ($export) {
            return $listRecord->orderBy(TradeItem::CREATED_AT, 'desc')
                ->get();
        } else {
            return $listRecord->orderBy(TradeItem::CREATED_AT, 'desc')
                ->get();
        }

    }

    public function insert($data = [])
    {
        $specification = $data['size'] . ',' . $data['material'] . ',' . $data['tech'];
        $detail = [
            TradeItem::NAME => $data['name'] ?? "",
            TradeItem::SLUG_NAME => !empty($data['name']) ? slugify($data['name']) : "",
            TradeItem::TYPE => $data['type'] ?? "",
            TradeItem::PRICE => (int)$data['price'] ?? "",
            TradeItem::SPECIFICATION => $specification,
        ];

        $result = [
            TradeItem::ITEM_ID => $data['item_id'],
            TradeItem::CATEGORY      => $data['category'] ?? "",
            TradeItem::TARGET_GOAL => $data['target_goal'] ?? "",
            TradeItem::MOTIVATING_GOAL => $data['motivating_goal'] ?? "",
            TradeItem::DETAIL => $detail,
            TradeItem::STORE => $data['store'] ?? "",
            TradeItem::IMAGE => $data['path'] ?? "",
            TradeItem::STATUS => TradeItem::STATUS_ACTIVE,
            TradeItem::CREATED_AT => time(),
            TradeItem::CREATED_BY => $data['created_by'] ?? "",
            TradeItem::DATE => !empty($data['date']) ? strtotime($data['date']) : "",
        ];
        $create = $this->tradeItem->create($result);
        return $create;

    }

    public function update($data = [], $id)
    {

        $result = [
            TradeItem::DETAIL . '.' . TradeItem::PRICE => (int)$data['price'] ?? "",
            TradeItem::IMAGE => $data['path'] ?? "",
            TradeItem::STORE => $data['store'] ?? "",
            TradeItem::DATE => !empty($data['date']) ? strtotime($data['date']) : "",
            TradeItem::UPDATED_AT => time(),
            TradeItem::UPDATED_BY => $data['created_by'] ?? ""
        ];
        $update = $this->tradeItem::where(TradeItem::ID, $id)->update($result);
        return $update;

    }

    public function blockItem($data)
    {
        $result = [
            TradeItem::STATUS => TradeItem::STATUS_BLOCK,
            TradeItem::UPDATED_BY => $data['created_by'] ?? "",
            TradeItem::UPDATED_AT => time(),
        ];
        $block = $this->tradeItem::where(TradeItem::ID, $data['id'])->update($result);
        return $block;

    }

    public function detailItem($id)
    {
        $result = $this->tradeItem::where(TradeItem::ID, $id)
            ->first();
        if ($result) {
            return $result->toArray();
        }
        return [];
    }

    public function detailByCodeItem($item_id)
    {
        $result = $this->tradeItem::where(TradeItem::ITEM_ID, $item_id)
            ->first();
        if ($result) {
            return $result->toArray();
        }
        return [];
    }

    public function checkDuplicateBlocked($data)
    {
        $detail = $this->tradeItem::where(TradeItem::CATEGORY, $data['category'])
            ->where(TradeItem::STATUS, TradeItem::STATUS_BLOCK)
            ->where(TradeItem::TARGET_GOAL, $data['target_goal'])
            ->where(TradeItem::MOTIVATING_GOAL, $data['motivating_goal'])
            ->where(TradeItem::STORE, $data['store'])
            ->where(TradeItem::DETAIL . '.' . TradeItem::NAME, $data['name'])
            ->where(TradeItem::DETAIL . '.' . TradeItem::TYPE, $data['type'])
            ->where(TradeItem::DETAIL . '.' . TradeItem::PRICE, (int)$data['price'])
            ->where(TradeItem::DETAIL . '.' . TradeItem::SIZE, $data['size'])
            ->where(TradeItem::DETAIL . '.' . TradeItem::MATERIAL, $data['material'])
            ->where(TradeItem::DETAIL . '.' . TradeItem::TECH, $data['tech'])
            ->first();

        if ($detail) {
            return $detail->toArray();
        } else {
            return [];
        }

    }

    public function checkDuplicateActived($data)
    {
        $specification = $data['size'] . ',' . $data['material'] . ',' . $data['tech'];
        $detail = $this->tradeItem::where(TradeItem::STATUS, TradeItem::STATUS_ACTIVE)
            ->where(TradeItem::DETAIL . '.' . TradeItem::SLUG_NAME, slugify($data['name']))
            ->where(TradeItem::DETAIL . '.' . TradeItem::SPECIFICATION, $specification)
            ->first();
        if ($detail) {
            return $detail->toArray();
        } else {
            return [];
        }

    }

    public function updateActive($data)
    {
        $result = [
            TradeItem::STATUS => TradeItem::STATUS_ACTIVE,
            TradeItem::UPDATED_AT => time(),
            TradeItem::UPDATED_BY => $data['created_by']
        ];
        $active = $this->tradeItem::where(TradeItem::ID, $data['_id'])->update($result);
        return $active;

    }

    public function wlog($id, $action, $createdBy) {
        $log = [
            'action'        => $action,
            'created_by'    => $createdBy,
            'created_at'    => time()
        ];
        $updateKsnb = $this->tradeItem::where(TradeItem::ID, $id)
            ->push(TradeItem::LOG, $log);
    }


    public function getAllName()
    {
        $result = $this->tradeItem::where(TradeItem::STATUS, TradeItem::STATUS_ACTIVE)
            ->select('detail.name')
            ->get();
        if($result){
            return $result->toArray();
        }
        return [];
    }

    public function groupByName($name)
    {
        if($name){
            $condition['detail.name'] = $name;
        }else{
            return [];
        }
        $condition['status'] = TradeItem::STATUS_ACTIVE;
        $result = $this->tradeItem::raw(function ($collection) use ($condition){
            return $collection->aggregate([
                ['$unwind' => '$detail'],
                ['$match' => (object)$condition],
                ['$group' => [
                    "_id" => '$detail.name',
                    "type" => ['$addToSet' => '$detail.type'],
                ],
                ],
            ]);
        });
        if ($result) {
            return $result->toArray()[0]['type'];
        }
        return [];
    }

    public function getAllCategory()
    {
        $result = $this->tradeItem::where(TradeItem::STATUS, TradeItem::STATUS_ACTIVE)
            ->select('category')
            ->get();
        if($result){
            return $result->toArray();
        }
        return [];
    }

    /**
     *  Get trade's item list by storeId
     * @param $storeId string
     * @return Collection
     * */
    public function getItemsByStoreId($storeId) {
        $result = $this->tradeItem::raw(function ($collection) use ($storeId) {
            return $collection->aggregate([
                [
                    '$match' => [
                        TradeItem::STATUS => TradeItem::STATUS_ACTIVE,
                        '$or' => [
                            [TradeItem::DATE => ['$gte' => time()]],
                            [TradeItem::DATE => ""]
                        ],
                        TradeItem::STORE => [
                            '$elemMatch' => [
                                'id' => $storeId
                            ]
                        ]
                    ],
                ],
                [
                    '$sort' => [
                        TradeItem::CREATED_AT => -1
                    ],
                ],
                [
                    '$project' => [
                        TradeItem::ID => 1,
                        TradeItem::ITEM_ID => 1,
                        TradeItem::CATEGORY => 1,
                        TradeItem::TARGET_GOAL => 1,
                        TradeItem::MOTIVATING_GOAL => 1,
                        TradeItem::DETAIL => 1,
                        TradeItem::IMAGE => 1
                    ],
                ]
            ]);
        });
        return $result->toArray();
    }

}
