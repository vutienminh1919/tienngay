<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\TradeHistory;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use MongoDB\BSON\Regex;

class TradeHistoryRepository implements TradeHistoryRepositoryInterface
{
        /**
     * @var Model
     */
    protected $tradeHistoryModel;


    public function __construct(TradeHistory $tradeHistoryModel) {
       $this->tradeHistoryModel = $tradeHistoryModel;
    }

    public function getAllHistory($data=[]) {

        $result = $this->tradeHistoryModel;
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $startDate = strtotime(trim($data['start_date']) . '00:00:00');
            $endDate = strtotime(trim($data['end_date']) . '23:59:59');
            $result = $result->where(TradeHistory::CREATED_AT, '>=', $startDate)
            ->where(TradeHistory::CREATED_AT, '<=', $endDate);
        } else if (!empty($data['start_date']) && empty($data['end_date'])) {
            $startDate = strtotime(trim($data['start_date']) . '00:00:00');
            $result = $result->where(TradeHistory::CREATED_AT, '>=', $startDate);
        } else if (empty($data['start_date']) && !empty($data['end_date'])) {
            $endDate = strtotime(trim($data['end_date']) . '23:59:59');
            $result = $result->where(TradeHistory::CREATED_AT, '<=', $endDate);
        } else {
            $firstDate = date('Y-m-01', time());
            $startDate = strtotime($firstDate . '00:00:00');
            $lastDate = date('Y-m-t', time());
            $endDate = strtotime($lastDate . '23:59:59');
            $result = $result->where(TradeHistory::CREATED_AT, '>=', $startDate)
            ->where(TradeHistory::CREATED_AT, '<=', $endDate);
        }
        if (!empty($data['name'])) {
            $result = $result->where(TradeHistory::NAME, 'like', $data['name']);
        }
        if (!empty($data['code_item'])) {
            $result = $result->where(TradeHistory::CODE_ITEM, $data['code_item']);
        }
        if (!empty($data['transaction'])) {
            $action = (int)$data['transaction'];
            $result = $result->where(TradeHistory::ACTION, $action);
        }
        if (!empty($data['store_id'])) {
            $result = $result->where(TradeHistory::STORE_ID, $data['store_id']);
        }
        return $result
        ->orderBy($this->tradeHistoryModel::CREATED_AT, 'DESC')->get();
        // ->paginate(15);
        // $condition = [];
        // if (!empty($data['start_date']) && !empty($data['end_date'])) {
        //     $startDate = strtotime(trim($data['start_date']) . '00:00:00');
        //     $endDate = strtotime(trim($data['end_date']) . '23:59:59');
        // } else if (!empty($data['start_date']) && empty($data['end_date'])) {
        //     $startDate = strtotime(trim($data['start_date']) . '00:00:00');
        //     $endDate = null;
        // } else if (empty($data['start_date']) && !empty($data['end_date'])) {
        //     $endDate = strtotime(trim($data['end_date']) . '23:59:59');
        //     $startDate = null;
        // } else {
        //     $firstDate = date('Y-m-01', time());
        //     $startDate = strtotime($firstDate . '00:00:00');
        //     $lastDate = date('Y-m-t', time());
        //     $endDate = strtotime($lastDate . '23:59:59');
        // }
        // $name = $data['name'] ?? "";
        // $code_item = $data['code_item'] ?? "";
        // $store = $data['store'] ?? "";
        // $transaction = $data['transaction'] ?? "";
        // if ($startDate && $endDate) {
        //     $condition ['created_at'] = (object)['$gte' => $startDate, '$lte' => $endDate];
        // }
        // if ($name) {
        //     $condition['name'] = $name;
        // }
        // if ($code_item) {
        //     $condition['code_item'] = $code_item;
        // }
        // if ($store) {
        //     $condition['store_id'] = $store;
        // }
        // if ($transaction) {
        //     $condition['action'] = (int)$transaction;
        // }
        // // dd($condition);
        // $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
        //     return $collection->aggregate([
        //         [
        //             '$match' => (object)$condition
        //         ],
        //         ['$group' =>
        //             [
        //                 "_id" => '',
        //                 'items' => [
        //                     '$push' => [
        //                         "code_item" => '$code_item',
        //                         "name" => '$name',
        //                         "price" => ['$avg' => '$actual_price'],
        //                         "ncc" => '$ncc',
        //                         "action" => '$action',
        //                         "amount" => ['$sum' => '$amount'],
        //                     ],
        //                 ],
        //             ]
        //         ],
        //         ['$project' =>
        //             [
        //                 '_id' => 0,
        //                 'items' => 1,
        //             ]
        //         ],

        //     ]);
        // });

        // return $group;
    }


    public function create($data = []) {
        if (empty($data)) {
            return false;
        }
        $result = [
            TradeHistory::STORE_ID              => $data[TradeHistory::STORE_ID],
            TradeHistory::STORE_NAME            => $data[TradeHistory::STORE_NAME],
            TradeHistory::CODE_ITEM             => $data[TradeHistory::CODE_ITEM] ,
            TradeHistory::NAME                  => $data[TradeHistory::NAME],
            TradeHistory::AMOUNT                => (int)$data[TradeHistory::AMOUNT],
            TradeHistory::ACTION                => $data[TradeHistory::ACTION],
            TradeHistory::CREATED_BY            => $data[TradeHistory::CREATED_BY],
            TradeHistory::NCC                   => $data[TradeHistory::NCC] ?? NULL,
            TradeHistory::ACTUAL_PRICE          => $data[TradeHistory::ACTUAL_PRICE] ?? NULL,
            TradeHistory::TYPE_REPORT           => $data[TradeHistory::TYPE_REPORT] ?? NULL,
            TradeHistory::IS_CONFIRMED          => $data[TradeHistory::IS_CONFIRMED] ?? NULL,
            TradeHistory::ID_TRANSFER           => $data[TradeHistory::ID_TRANSFER] ?? NULL,
        ];
        $create = $this->tradeHistoryModel->create($result);
        if ($create) {
            return $create;
        }
        return false;
    }

    /**
     * find all log by action & group by code
     * @param $action int
     * @param $item array
     * @return array
     * */

    public function findByActionGroupByCode($action)
    {
        $condition = [];
        $condition['action'] = $action;
        $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$match' => (object)$condition],
                ['$group' =>
                    [
                        "_id" => '$code_item',
                        "quantity" => ['$sum' => '$amount'],
                    ]
                ],
                ['$project' =>
                    [   '_id' => 1,
                        'quantity' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    public function findByActionGroupByCodeandStoreId($action, $store_id)
    {
        $condition = [];
        $condition['action'] = $action;
        $condition['store_id'] = $store_id;
        $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$match' => (object)$condition],
                ['$group' =>
                    [
                        "_id" => '$code_item',
                        "quantity" => ['$sum' => '$amount'],
                    ]
                ],
                ['$project' =>
                    [   '_id' => 1,
                        'quantity' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    public function findByActionGroupByCodeStoreIdAndType($action, $store_id, $type_report)
    {
        $condition = [];
        $condition['action'] = $action;
        $condition['store_id'] = $store_id;
        $condition['type_report'] = $type_report;
        $condition['is_confirmed'] = 1;
        $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$match' => (object)$condition],
                ['$group' =>
                    [
                        "_id" => '$code_item',
                        "quantity" => ['$sum' => '$amount'],
                    ]
                ],
                ['$project' =>
                    [   '_id' => 1,
                        'quantity' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    /**
     * find all log by action & group by store
     * @param $action int
     * @return array
     * */

    public function findByActionGroupByStore($action)
    {
        $condition = [];
        $condition['action'] = $action;
//        $condition['store_id'] = $store;
        $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$match' => (object)$condition],
                ['$group' =>
                    [
                        "_id" => '$store_id',
                        "quantity" => ['$sum' => '$amount'],
                    ]
                ],
                ['$project' =>
                    [   '_id' => 1,
                        'quantity' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    public function findByActionGroupByStoreFixed($action, $type)
    {
        $condition = [];
        $condition['action'] = $action;
        $condition['is_confirmed'] = 1;
        $condition['type_report'] = $type;

        $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$match' => (object)$condition],
                ['$group' =>
                    [
                        "_id" => '$store_id',
                        "quantity" => ['$sum' => '$amount'],
                    ]
                ],
                ['$project' =>
                    [   '_id' => 1,
                        'quantity' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    /**
     * find all import log by store & group by store
     * @param $store_id string
     * @return array
     * */

    public function getItemImportByStoreId($store_id)
    {
        $condition = [];
        $condition['action'] = TradeHistory::ACTION_BUY;
        $condition['store_id'] = $store_id;
        $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$match' => (object)$condition],
                ['$group' =>
                    [
                        "_id" => '$code_item',
                        "quantity" => ['$sum' => '$amount'],
                    ]
                ],
                ['$project' =>
                    [   '_id' => 1,
                        'quantity' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    public function getAvgByCodeItem($code) {
        $condition = [];
        $condition['code_item'] = $code;
        $condition['action'] = TradeHistory::ACTION_BUY;
        $group = $this->tradeHistoryModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$match' => (object)$condition],
                [ '$sort' => ['created_at' => 1]],
                ['$group' =>
                    [
                        "_id" => 'code_item',
                        'price' => ['$last' => '$actual_price'],
                    ]
                ],
                [ '$limit' => 1 ],
                ['$project' =>
                    [   '_id' => 0,
                        'price' => '$price',
                    ]
                ],

            ]);
        });
        return $group;
    }

    public function update($data)
    {
        $result = [
            TradeHistory::IS_CONFIRMED => 2
        ];
        $update = $this->tradeHistoryModel::where(TradeHistory::ID_TRANSFER, $data[TradeHistory::ID_TRANSFER])->update($result);
        return $update;

    }


}
