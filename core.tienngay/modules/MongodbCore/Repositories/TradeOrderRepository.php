<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\TradeOrder;
use Modules\MongodbCore\Repositories\Interfaces\TradeOrderRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TradeOrderRepository implements TradeOrderRepositoryInterface
{

    /**
     * @var Model
     */
     protected $model;

    /**
     * TradeOrderRepository constructor.
     *
     * @param $tradeOrder TradeOrder
     */
    public function __construct(TradeOrder $tradeOrder) {
        $this->model = $tradeOrder;
    }

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function index($conditions, $limit) {
        $projections = ['id', 'store_name', 'plan_name', 'plan_file', 'motivating_goal', 'status', 'progress', 'created_at'];
        $fetch = $this->model->where($conditions)->orderBy(TradeOrder::CREATED_AT, 'desc')->paginate($limit, $projections);
        return $fetch;
    }

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function searchByConditions($cond, $limit) {
        $projections = ['id', 'store_name', 'plan_name', 'plan_file', 'motivating_goal', 'status', 'progress', 'created_at'];
        $conditions = [];
        if (!empty($cond['plan_name'])) {
            $conditions[] = ['plan_name', 'like', '%'.trim($cond['plan_name']).'%'];
        }
        if (!empty($cond['start_date'])) {
            $conditions[] = ['created_at', '>=', strtotime($cond['start_date'] . '00:00:00')];
        }
        if (!empty($cond['end_date'])) {
            $conditions[] = ['created_at', '<=', strtotime($cond['end_date'] . '23:59:59')];
        }
        $fetch = $this->model->where($conditions);
        if (!empty($cond['store_id'])) {
            $fetch = $fetch->whereIn('store_id', $cond['store_id']);
        }
        if (!empty($cond['status'])) {
            $fetch = $fetch->whereIn('status', array_map('intval', $cond['status']));
        }
        if (!empty($cond['motivating_goal'])) {
            $fetch = $fetch->whereIn('motivating_goal', $cond['motivating_goal']);
        }
        $fetch = $fetch->orderBy(TradeOrder::CREATED_AT, 'desc')->paginate($limit, $projections);
        return $fetch;
    }

    /**
     * Store new data into collection
     * @param $attr array
     * @return collection
     * */
    public function store($attr) {
        $create = $this->model->create($attr);
        return $create;
    }

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function fetch($id) {
        $fetch = $this->model->find($id);
        return $fetch;
    }

    /**
     * Update progress
     * @param $attr array
     * @return collection
     * */
    public function updateProgress($id, $attr) {
        $update = $this->model->find($id);
        if ($update) {
            $update[TradeOrder::STATUS] = $attr[TradeOrder::STATUS];
            $update[TradeOrder::PROGRESS] = $attr[TradeOrder::PROGRESS];
            $update[TradeOrder::UPDATED_BY] = $attr[TradeOrder::UPDATED_BY];
            if ($update->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Update trade's request order
     * @param $attr array
     * @return collection
     * */
    public function update($id, $attr) {
        $update = $this->model->find($id);
        if ($update) {
            foreach($attr as $key => $value) {
                $update[$key] = $value;
            }
            if ($update->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Delete trade's request order
     * @param $attr array
     * @return collection
     * */
    public function delete($id, $attr) {
        $update = $this->model->find($id);
        if ($update) {
            foreach($attr as $key => $value) {
                $update[$key] = $value;
            }
            if ($update->delete()) {
                return true;
            }
        }
        return false;
    }

    /**
     * update budget estimates status
     * @param $attr array
     * @return collection
     * */
    public function updateBudgetEstimatesStatus($id, $attr) {
        $update = $this->model->find($id);
        if ($update) {
            if ($attr[TradeOrder::BUDGET_ESTIMATES] == TradeOrder::BUDGET_ESTIMATES_REMOVED) {
                $update[TradeOrder::BUDGET_ESTIMATES] = TradeOrder::BUDGET_ESTIMATES_REMOVED;
                $update[TradeOrder::BUDGET_ESTIMATES_ID] = "";
                $update[TradeOrder::BUDGET_ESTIMATES_NAME] = "";
                $update[TradeOrder::PROGRESS] = TradeOrder::PROGRESS_GDKD_MKT;
            } else if ($attr[TradeOrder::BUDGET_ESTIMATES] == TradeOrder::BUDGET_ESTIMATES_ADDED) {
                $update[TradeOrder::BUDGET_ESTIMATES] = TradeOrder::BUDGET_ESTIMATES_ADDED;
                $update[TradeOrder::BUDGET_ESTIMATES_ID] = $attr[TradeOrder::BUDGET_ESTIMATES_ID];
                $update[TradeOrder::BUDGET_ESTIMATES_NAME] = $attr[TradeOrder::BUDGET_ESTIMATES_NAME];
            }
            if ($update->save()) {
                return true;
            }
        }
        return false;
    }

    /**
    * Write user's log
    * @param $id String: trade_order collection's Id
    * @param $log array
    * @return void
    */
    public function wlog($id, $log) {
        $update = $this->model::where($this->model::ID, $id)
            ->push($this->model::LOGS, $log);
    }

    /**
    * calculate budget estimate
    * @param $id String: budget_estimates collection's Id
    * @return array
    */
    public function calculateBudgetEstimate($budgetEstimateId, $regions, $storeRepo) {

        $groupAreas = []; // Tính tổng chi phí theo từng vùng.
        $areaIndex = [
            'MB' => 1,
            'DB' => 2,
            'MN' => 3
        ]; // Đánh số thứ tự hiển thị cho từng vùng.

        $areaIndexCount = count($areaIndex) + 1; // nếu khu vực không có trong $areaIndex thì sẽ đánh số thứ tự hiển thị ngẫu nhiên.
        $debug = [];
        // Tính tổng chi phí từng vùng có trong hệ thống hiện tại
        foreach($regions as $region) {
            $group = [
                'region_code' => data_get($region, '_id.code', ''),
                'region_name' => data_get($region, '_id.name', ''),
                'areas' => [],
                'areaTotalExpecPrice' => 0
            ];
            $areas = data_get($region, 'kv', []);
            $areaTotalExpecPrice = 0;
            // dd($areas);
            foreach($areas as $area) {
                $areaCode = data_get($area, 'kv_code', '');
                $groupArea = $this->model::raw(function ($collection) use ($budgetEstimateId, $areaCode) {
                    return $collection->aggregate([
                        [ '$unwind' => '$items'],
                        ['$match' => (object)[
                                TradeOrder::BUDGET_ESTIMATES => TradeOrder::BUDGET_ESTIMATES_ADDED,
                                TradeOrder::BUDGET_ESTIMATES_ID => $budgetEstimateId,
                                TradeOrder::STATUS => ['$ne' => TradeOrder::STATUS_CANCLED],
                                TradeOrder::STORE_CODE_AREA => $areaCode
                            ]
                        ],
                        ['$group' => 
                            [
                                "_id" => '$store_code_area', 
                                "numberOfItem" => ['$sum' => '$items.item_quantity'],
                                "totalExpecPrice" => ['$sum' => ['$multiply' => ['$items.item_quantity', '$items.item_expec_price']]],
                                'itemCode' => ['$addToSet' => '$items.item_code']
                            ]
                        ],
                        ['$project' => 
                            [ 
                                'numberOfItem' => '$numberOfItem',
                                'totalExpecPrice' => '$totalExpecPrice',
                                'countItem' => ['$size' => '$itemCode'],
                                'itemCode' => '$itemCode'
                            ] 
                        ],
                        
                    ]);
                });
                $groupArea = $groupArea->toArray();
                $debug[] = $groupArea;
                if (!empty($groupArea)) {
                    $groupArea[0]['kv_name'] = data_get($area, 'kv_name', '');
                    if ($areaCode == 'KV_QN') {
                        $groupDB = [
                            'region_code' => 'DB',
                            'region_name' => 'Đông Bắc',
                            'areas' => [$groupArea[0]],
                            'areaTotalExpecPrice' => $groupArea[0]['totalExpecPrice']
                        ];
                        $index = isset($areaIndex[$groupDB['region_code']]) ? $areaIndex[$groupDB['region_code']] : null;
                        if ($index) {
                            $groupAreas[$index] = $groupDB;
                        } else {
                            $groupAreas[$areaIndexCount] = $groupDB;
                            $areaIndexCount++;
                        }
                        continue;
                    }
                    foreach ($groupArea as $key => $value) {
                        $group['areas'][] = $value;
                        $areaTotalExpecPrice += $value['totalExpecPrice'];
                    }
                    $group['areaTotalExpecPrice'] = $areaTotalExpecPrice;
                }
            }
            $index = isset($areaIndex[$group['region_code']]) ? $areaIndex[$group['region_code']] : null;
            if ($index) {
                $groupAreas[$index] = $group;
            } else {
                $groupAreas[$areaIndexCount] = $group;
                $areaIndexCount++;
            }

        }
        // dd($groupAreas);
        ksort($groupAreas); // sort lại index của array

        //============================================================
        // Tính tổng chi phí theo phòng giao dịch
        $groupPgd = $this->model::raw(function ($collection) use ($budgetEstimateId) {
            return $collection->aggregate([
                ['$unwind' => '$items'],
                ['$match' => (object)[
                        TradeOrder::BUDGET_ESTIMATES => TradeOrder::BUDGET_ESTIMATES_ADDED,
                        TradeOrder::BUDGET_ESTIMATES_ID => $budgetEstimateId,
                        TradeOrder::STATUS => ['$ne' => TradeOrder::STATUS_CANCLED]
                    ]
                ],
                ['$group' => 
                    [
                        "_id" => '$store_id', 
                        "totalExpecPrice" => ['$sum' => ['$multiply' => ['$items.item_quantity', '$items.item_expec_price']]],
                        'items' => ['$push' => '$items']
                    ]
                ],
                ['$sort' => ['_id' => 1]],
                ['$project' => 
                    [ 
                        'numberOfItem' => '$numberOfItem',
                        'totalExpecPrice' => '$totalExpecPrice',
                        'items' => '$items'
                    ] 
                ],
                
            ]);
        });
        $pgdReport = [
            TradeOrder::CATEGORY_PUBLICATION => [
                'key' => TradeOrder::CATEGORY_PUBLICATION,
                'name' => TradeOrder::$categories[TradeOrder::CATEGORY_PUBLICATION],
                'count' => 0,
                'items' => [
                    TradeOrder::IMPLEMENTATION_GOAL_DIRECT => [
                        'key' => TradeOrder::IMPLEMENTATION_GOAL_DIRECT,
                        'name' => TradeOrder::$implementationGoals[TradeOrder::IMPLEMENTATION_GOAL_DIRECT],
                        'count' => 0,
                        'items' => []
                    ],
                    TradeOrder::IMPLEMENTATION_GOAL_INDIRECT =>  [
                        'key' => TradeOrder::IMPLEMENTATION_GOAL_INDIRECT,
                        'name' => TradeOrder::$implementationGoals[TradeOrder::IMPLEMENTATION_GOAL_INDIRECT],
                        'count' => 0,
                        'items' => []
                    ]
                ]
            ],
            TradeOrder::CATEGORY_ITEM => [
                'key' => TradeOrder::CATEGORY_ITEM,
                'name' => TradeOrder::$categories[TradeOrder::CATEGORY_ITEM],
                'count' => 0,
                'items' => [
                    TradeOrder::IMPLEMENTATION_GOAL_DIRECT => [
                        'key' => TradeOrder::IMPLEMENTATION_GOAL_DIRECT,
                        'name' => TradeOrder::$implementationGoals[TradeOrder::IMPLEMENTATION_GOAL_DIRECT],
                        'count' => 0,
                        'items' => []
                    ],
                   TradeOrder::IMPLEMENTATION_GOAL_INDIRECT =>  [
                        'key' => TradeOrder::IMPLEMENTATION_GOAL_INDIRECT,
                        'name' => TradeOrder::$implementationGoals[TradeOrder::IMPLEMENTATION_GOAL_INDIRECT],
                        'count' => 0,
                        'items' => []
                    ]
                ]
            ],
            'pgds' => []
        ];
        foreach($groupPgd as $key => $pgd) {
            $pgdReport['pgds'][$pgd['_id']] = [
                'store_id' => $pgd['_id'],
                'store_name' => $storeRepo->getStoreName($pgd['_id']),
                'totalExpecPrice' => $pgd['totalExpecPrice'], 
                'item_ids' => []
            ];
            foreach($pgd['items'] as $key2 => $item) {
                $category = false;
                $goal = false;
                if (isset($pgdReport['pgds'][$pgd['_id']]['item_ids'][$item['item_id']])) {
                    $pgdReport['pgds'][$pgd['_id']]['item_ids'][$item['item_id']]['item_quantity'] += $item['item_quantity'];
                } else {
                    $pgdReport['pgds'][$pgd['_id']]['item_ids'][$item['item_id']] = $item;
                }
                if ($item['category'] == TradeOrder::CATEGORY_PUBLICATION) {
                    $category = TradeOrder::CATEGORY_PUBLICATION;
                } else if ($item['category'] == TradeOrder::CATEGORY_ITEM) {
                    $category = TradeOrder::CATEGORY_ITEM;
                }
                if ($item['implementation_goal'] == TradeOrder::IMPLEMENTATION_GOAL_DIRECT) {
                    $goal = TradeOrder::IMPLEMENTATION_GOAL_DIRECT;
                } else if ($item['implementation_goal'] == TradeOrder::IMPLEMENTATION_GOAL_INDIRECT) {
                    $goal = TradeOrder::IMPLEMENTATION_GOAL_INDIRECT;
                }
                if (!$category || !$goal) {
                    continue;
                }
                if (isset($pgdReport[$category]['items'][$goal]['items'][$item['item_id']])) {
                    continue;
                }
                $pgdReport[$category]['items'][$goal]['items'][$item['item_id']] = (array)$item;
                $pgdReport[$category]['count']++;
                $pgdReport[$category]['items'][$goal]['count']++;
                
            }
        }
        $items = [];
        foreach($pgdReport as $value) {
            if (!empty($value['items'][TradeOrder::IMPLEMENTATION_GOAL_DIRECT]['items'])) {
                foreach($value['items'][TradeOrder::IMPLEMENTATION_GOAL_DIRECT]['items'] as $value1) {
                    $items[] = $value1;
                }
            }
            if (!empty($value['items'][TradeOrder::IMPLEMENTATION_GOAL_INDIRECT]['items'])) {
                foreach($value['items'][TradeOrder::IMPLEMENTATION_GOAL_INDIRECT]['items'] as $value2) {
                    $items[] = $value2;
                }
            }
        }
        return ['groupKV' => $groupAreas, 'groupPgd' => $pgdReport, 'items' => $items];
    }

    /**
     * find collection reference by trade budget estimate id
     * @param $attr id
     * @return collection
     * */
    public function fetchItemsByBudgetEstimateId($budgetEstimateId) {
        // Tính tổng chi phí theo phòng giao dịch
        $fetch = $this->model::raw(function ($collection) use ($budgetEstimateId) {
            return $collection->aggregate([
                ['$unwind' => '$items'],
                ['$match' => (object)[
                        TradeOrder::BUDGET_ESTIMATES => TradeOrder::BUDGET_ESTIMATES_ADDED,
                        TradeOrder::BUDGET_ESTIMATES_ID => $budgetEstimateId,
                        TradeOrder::STATUS => ['$ne' => TradeOrder::STATUS_CANCLED]
                    ]
                ],
                ['$sort' => [TradeOrder::CREATED_AT => 1]],
                ['$group' => 
                    [
                        '_id' => '$_id',
                        'tradeItems' => ['$push' => '$items'],
                        'totalOfItem' => ['$sum' => '$items.item_quantity'],
                        'totalExpec_price' => ['$sum' => ['$multiply' => ['$items.item_quantity', '$items.item_expec_price']]],
                        'store_name' => ['$first' => '$store_name'],
                        'plan_name' => ['$first' => '$plan_name'],
                        'plan_file' => ['$first' => '$plan_file'],
                        'motivating_goal' => ['$first' => '$motivating_goal'],
                        'status' => ['$first' => '$status'],
                        'progress' => ['$first' => '$progress'],
                        'created_at' => ['$first' => '$created_at'],
                        'budget_estimates_name' => ['$first' => '$budget_estimates_name'],
                    ]
                ],
                ['$project' => 
                    [ 
                        'store_name' => '$store_name',
                        'plan_name' => '$plan_name',
                        'plan_file' => '$plan_file',
                        'motivating_goal' => '$motivating_goal',
                        'status' => '$status',
                        'progress' => '$progress',
                        'created_at' => '$created_at',
                        'totalOfItem' => '$totalOfItem',
                        'totalExpec_price' => '$totalExpec_price',
                        'budget_estimates_name' => '$budget_estimates_name',
                        'items' => '$tradeItems'
                    ] 
                ],
                
            ]);
        });
        return $fetch;
    }

    /**
     * fetch allotment of items
     * @param $attr id
     * @return array
     * */
    public function fetchLogsAllotment($id) {
        $projections = [TradeOrder::LOGS_ALLOTMENT];
        $fetch = $this->model->find(['_id' => new \MongoDB\BSON\ObjectID($id)], $projections)->first();
        if ($fetch) {
            return $fetch[TradeOrder::LOGS_ALLOTMENT];
        }
        return [];
    }

    /**
     * fetch allotment of items
     * @param $attr id
     * @return array
     * */
    public function fetchAllotment($id, $itemKey) {
        $fetch = $this->model::raw(function ($collection) use ($id, $itemKey) {
            return $collection->aggregate([
                ['$match' => (object)[
                    TradeOrder::ID => new \MongoDB\BSON\ObjectID($id),
                    TradeOrder::STATUS => ['$ne' => TradeOrder::STATUS_CANCLED],

                ]],
                ['$unwind' => '$logs_allotment'],
                ['$match' => (object)[
                    'logs_allotment.key' => $itemKey

                ]],
                ['$limit' => 1],
                ['$project' => [ 
                    '_id' => 1,
                    'logs_allotment' => 1
                ]]
            ]);
        });
        
        if (!empty($fetch[0])) {
            return $fetch[0][TradeOrder::LOGS_ALLOTMENT];
        }
        return [];
    }

    /**
     * fetch allotment of items
     * @param $attr id
     * @return array
     * */
    public function fetchRequestItem($id, $itemCode) {
        $fetch = $this->model::raw(function ($collection) use ($id, $itemCode) {
            return $collection->aggregate([
                ['$match' => (object)[
                    TradeOrder::ID => new \MongoDB\BSON\ObjectID($id),
                    TradeOrder::STATUS => ['$ne' => TradeOrder::STATUS_CANCLED],

                ]],
                ['$unwind' => '$items'],
                ['$match' => (object)[
                    'items.item_code' => $itemCode

                ]],
                ['$limit' => 1],
                ['$project' => [ 
                    '_id' => 1,
                    'items' => 1
                ]]
            ]);
        });
        
        if (!empty($fetch[0])) {
            return $fetch[0][TradeOrder::ITEMS];
        }
        return [];
    }

    /**
     * confirmed allotment item
     * @param $id string
     * @param $allotment Array
     * @return boolean
     * */
    public function updateAllotment($id, $allotment) {
        // Find element in array and remove
        $update = $this->model::raw(function ($collection) use ($id, $allotment) {
            return $collection->updateMany(
                [TradeOrder::ID => new \MongoDB\BSON\ObjectID($id)],
                ['$pull' => [TradeOrder::LOGS_ALLOTMENT => ['key' => $allotment['key']]]],
                ['upsert' => false],
                ["multi" => true]
            );
        });
        // repush removed item to array
        $push = $this->model->where(TradeOrder::ID, new \MongoDB\BSON\ObjectID($id))
        ->push(TradeOrder::LOGS_ALLOTMENT, $allotment);

        $item = $this->fetchRequestItem($id, $allotment[TradeOrder::ITEM_CODE]);
        if (!empty($item)) {
            $receivedAmount = !empty($item[TradeOrder::ITEM_RECEIVED_AMOUNT]) ? (int)$item[TradeOrder::ITEM_RECEIVED_AMOUNT] : 0;
            $item[TradeOrder::ITEM_RECEIVED_AMOUNT] = $receivedAmount + $allotment[TradeOrder::ALLOTMENT_QUANTITY];
            // Find element in array and remove
            $update = $this->model::raw(function ($collection) use ($id, $item) {
                return $collection->updateMany(
                    [TradeOrder::ID => new \MongoDB\BSON\ObjectID($id)],
                    ['$pull' => [TradeOrder::ITEMS => ['key' => $item['key']]]],
                    ['upsert' => false],
                    ["multi" => true]
                );
            });
            // repush removed item to array
            $push = $this->model->where(TradeOrder::ID, new \MongoDB\BSON\ObjectID($id))
            ->push(TradeOrder::ITEMS, $item);

            // Change status if enought all request's items
            $this->checkStatusDone($id);
        }
        return true;
    }

    /**
     * fetch request allotment of items
     * @param $attr id
     * @return array
     * */
    public function fetchRequestAllotment($id) {
        
        $projections = [TradeOrder::ITEMS];
        $fetch = $this->model->find(['_id' => new \MongoDB\BSON\ObjectID($id)], $projections)->first();
        if ($fetch) {
            return $fetch[TradeOrder::ITEMS];
        }
        return [];

        // $fetch = $this->model::raw(function ($collection) use ($id) {
        //     return $collection->aggregate([
        //         ['$match' => (object)[
        //             TradeOrder::ID => new \MongoDB\BSON\ObjectID($id),
        //             TradeOrder::STATUS => ['$ne' => TradeOrder::STATUS_CANCLED],

        //         ]],
        //         ['$unwind' => '$items'],
        //         ['$group' => 
        //             [
        //                 "_id" => '_id', 
        //                 'itemsArr' => ['$push' => [
        //                     '$cond' => [
        //                         ['$gt' => ['$items.received_amount', 0]],
        //                         '$items',
        //                         NULL
        //                     ]
        //                 ]
        //             ]
        //         ]],
        //         ['$project' => [ 
        //             '_id' => '$_id',
        //             'items' => ['$setDifference' => ['$itemsArr', [null]]],
        //         ]]
        //     ]);
        // });
        
        // if (!empty($fetch[0])) {
        //     return $fetch[0][TradeOrder::ITEMS];
        // }
        // return [];
    }

    /**
     * if get all items enought then change status to done
     * @param $id string
     * @return boolean
     * */
    public function checkStatusDone($id) {
        $fetch = $this->model::raw(function ($collection) use ($id) {
            return $collection->aggregate([
                ['$match' => (object)[
                    TradeOrder::ID => new \MongoDB\BSON\ObjectID($id),
                    TradeOrder::STATUS => ['$ne' => TradeOrder::STATUS_CANCLED],
                    TradeOrder::PROGRESS => ['$eq' => TradeOrder::PROGRESS_HCNS_BUYING],

                ]],
                ['$unwind' => '$items'],
                ['$group' => 
                    [
                        "_id" => '_id', 
                        'itemsArr' => ['$push' => [
                            '$cond' => [
                                ['$lt' => ['$items.received_amount', '$items.item_quantity']],
                                '$items',
                                NULL
                            ]
                        ]
                    ]
                ]],
                ['$project' => [ 
                    '_id' => '$_id',
                    'items' => ['$setDifference' => ['$itemsArr', [null]]],
                ]]
            ]);
        });
        if (count($fetch[0][TradeOrder::ITEMS]) == 0) {
            // Request done condition
            $update = $this->model->find($id);
            if ($update) {
                $update[TradeOrder::STATUS] = TradeOrder::STATUS_DONE;
                $update[TradeOrder::PROGRESS] = TradeOrder::PROGRESS_PGD_ACCEPT;
                $update[TradeOrder::UPDATED_BY] = TradeOrder::SYSTEM;
                if ($update->save()) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * auto close request if match condition
     * @return array
     * */
    public function closeRequest()
    {
        $targetTime = strtotime("-4 months");
        $currentTime = time();
        $log = [
            TradeOrder::CREATED_BY                  => TradeOrder::SYSTEM,
            TradeOrder::CREATED_AT                  => $currentTime,
            TradeOrder::ACTION                      => TradeOrder::ACTION_UPDATE_PROGRESS,
            TradeOrder::ACTION_LABEL                => TradeOrder::actionLabel(TradeOrder::ACTION_UPDATE_PROGRESS),
            TradeOrder::STATUS                      => TradeOrder::STATUS_DONE,
            TradeOrder::PROGRESS                    => TradeOrder::PROGRESS_PGD_ACCEPT,
            TradeOrder::STATUS_LABEL                => TradeOrder::statusLabel(TradeOrder::STATUS_DONE, TradeOrder::PROGRESS_PGD_ACCEPT)
        ];
        $update = $this->model::raw(function ($collection) use ($targetTime, $log, $currentTime) {
            return $collection->updateMany(
                [
                    TradeOrder::PROGRESS => TradeOrder::PROGRESS_HCNS_BUYING,
                    TradeOrder::CEO_ACCEPTED_TIME => ['$lte' =>  $targetTime]
                ],
                [
                    '$set' => [
                        TradeOrder::PROGRESS => TradeOrder::PROGRESS_PGD_ACCEPT,
                        TradeOrder::STATUS => TradeOrder::STATUS_DONE,
                        TradeOrder::AUTO_CLOSE_REQUEST => $currentTime,
                        TradeOrder::UPDATED_AT => $currentTime,
                        TradeOrder::UPDATED_BY => TradeOrder::SYSTEM,
                    ],
                    '$push' => [
                        TradeOrder::LOGS => $log,
                    ],
                ],
                ['upsert' => false],
                ["multi" => true]
            );
        });
        $projections = ['id', 'plan_name'];
        $fetch = $this->model->where([TradeOrder::AUTO_CLOSE_REQUEST => $currentTime])->get($projections);
        return $fetch->toArray();
    }

    /**
     * find record by budget_estimates_id
     * @param string $id
     * @return collection
     * */
    public function findRecordByBudgetEstimatesId($id){
        $result = $this->model->where(TradeOrder::BUDGET_ESTIMATES_ID, $id)
        ->get([TradeOrder::STORE_ID, TradeOrder::PLAN_NAME,]);
        if ($result) {
            return $result->toArray();
        }
        return false;
    }
}
