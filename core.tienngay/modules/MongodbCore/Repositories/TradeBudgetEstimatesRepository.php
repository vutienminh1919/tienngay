<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\TradeBudgetEstimates;
use Modules\MongodbCore\Repositories\Interfaces\TradeBudgetEstimatesRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TradeBudgetEstimatesRepository implements TradeBudgetEstimatesRepositoryInterface
{

    /**
     * @var Model
     */
     protected $model;

    /**
     * TradeBudgetEstimatesRepository constructor.
     *
     * @param $tradeBudgetEstimates TradeBudgetEstimates
     */
    public function __construct(TradeBudgetEstimates $tradeBudgetEstimates) {
        $this->model = $tradeBudgetEstimates;
    }

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function index($conditions, $limit) {
        $projections = ['id', 'name', 'date', 'created_by', 'created_at', 'status', 'progress'];
        $fetch = $this->model->where($conditions)->orderBy(TradeBudgetEstimates::CREATED_AT, 'desc')->paginate($limit, $projections);
        return $fetch;
    }

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function newAll() {
        $fetch = $this->model->where([
            [TradeBudgetEstimates::STATUS, '=', TradeBudgetEstimates::STATUS_NEW],
            [TradeBudgetEstimates::PROGRESS, '=', TradeBudgetEstimates::PROGRESS_CREATE_NEW]
        ])
        ->orWhere(TradeBudgetEstimates::STATUS, TradeBudgetEstimates::STATUS_RETURNED)
        ->orderBy(TradeBudgetEstimates::CREATED_AT, 'desc')->get(['id', 'name']);
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
            $update[TradeBudgetEstimates::STATUS] = $attr[TradeBudgetEstimates::STATUS];
            $update[TradeBudgetEstimates::PROGRESS] = $attr[TradeBudgetEstimates::PROGRESS];
            $update[TradeBudgetEstimates::UPDATED_BY] = $attr[TradeBudgetEstimates::UPDATED_BY];
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
     * Delete 
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
    * Write user's log
    * @param $id String: trade_order collection's Id
    * @param $log array
    * @return boolean
    */
    public function wlog($id, $log) {
        $update = $this->model::where($this->model::ID, $id)
            ->push($this->model::LOGS, $log);
        if ($update) {
            return true;
        }
        return false;
    }

    /**
     * Update customer goal
     * @param $customerGoal string
     * @return collection
     * */
    public function updateCustomerGoal($id, $customerGoal) {
        $update = $this->model->find($id);
        if ($update) {
            $update[TradeBudgetEstimates::CUSTOMER_GOAL] = $customerGoal;
            if ($update->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get comment
     * @param $id string
     * @param $limit number
     * @return collection
     * */
    public function fetchComment($id) {
        $comments = $this->model::raw(function ($collection) use ($id) {
            return $collection->aggregate([
                ['$match' => [
                    '_id' => new \MongoDB\BSON\ObjectID($id)
                ]],
                ['$project' => 
                    [ 
                        "comments" => [ '$filter' => [
                            "input" => '$logs', 
                            "as" => "log", 
                            "cond" => ['$eq' => [ '$$log.action', TradeBudgetEstimates::ACTION_ADD_COMMENT]] 
                        ]]
                    ]
                ],
                
            ]);
        });
        return $comments->toArray();
    }

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function searchByConditions($conds, $limit) {
        $conditions = [];
        if (!empty($conds['status'])) {
            $conditions['status'] = ['$in' => array_map('intval', $conds['status'])];
        }
        if (!empty($conds['start_date']) && !empty($conds['end_date'])) {
            $conditions['date'] = [
                '$gte' => strtotime($conds['start_date']. ' 00:00:00'),
                '$lte' => strtotime($conds['end_date']. ' 23:59:59')
            ];
        } else {
            if (!empty($conds['start_date'])) {
                $conditions['date'] = ['$gte' => strtotime($conds['start_date']. ' 00:00:00')];
            }
            if (!empty($conds['end_date'])) {
                $conditions['date'] = ['$lte' => strtotime($conds['end_date']. ' 23:59:59')];
            }
        }
        
        if (empty($conditions['date'])) {
            unset($conditions['date']);
        }
        $conditions['deleted_at'] = ['$exists' => false];
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $total = $this->model::where($conditions)->count();
        $fetch = $this->model::raw(function ($collection) use ($conditions, $limit, $page) {
            return $collection->aggregate([
                ['$addFields'=> ['main_id' => ['$toString' => '$_id']]],
                ['$match' => (object)$conditions],
                ['$lookup' => [
                    'from' => 'trade_order',
                    'localField' => 'main_id',
                    'foreignField' => 'budget_estimates_id',
                    'as' => 'trade_orders'
                    ]
                ],
                ['$unwind' => [
                    'path' => '$trade_orders',
                    'preserveNullAndEmptyArrays' => true
                ]],
                ['$unwind' => [
                    'path' => '$trade_orders.items',
                    'preserveNullAndEmptyArrays' => true
                ]],
                ['$group' => 
                    [
                        '_id' => '$_id',
                        'totalExpec_price' => ['$sum' => ['$multiply' => ['$trade_orders.items.item_quantity', '$trade_orders.items.item_expec_price']]],
                        'status' => ['$first' => '$status'],
                        'progress' => ['$first' => '$progress'],
                        'created_at' => ['$first' => '$created_at'],
                        'created_by' => ['$first' => '$created_by'],
                        'date' => ['$first' => '$date'],
                        'name' => ['$first' => '$name'],
                    ]
                ],
                ['$project' => 
                    [ 
                        'name' => '$name',
                        'totalExpec_price' => '$totalExpec_price',
                        'status' => '$status',
                        'progress' => '$progress',
                        'created_at' => '$created_at',
                        'created_by' => '$created_by',
                        'date' => '$date'
                    ]
                ],
                ['$sort' => [TradeBudgetEstimates::CREATED_AT => -1]],
                ['$skip' => ($page - 1) * $limit],
                ['$limit' => $limit],
            ]);
        });
        $result = new \Illuminate\Pagination\LengthAwarePaginator($fetch, $total, $limit, $page, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
        ]);
        return $result;
    }
}
