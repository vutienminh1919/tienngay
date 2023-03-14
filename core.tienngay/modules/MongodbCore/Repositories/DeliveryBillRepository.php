<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\DeliveryBill;
use Modules\MongodbCore\Repositories\Interfaces\DeliveryBillRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use MongoDB\BSON\Regex;

class DeliveryBillRepository implements DeliveryBillRepositoryInterface
{
    /**
     * @var Model
     */
    protected $deliveryBillModel;


    /**
     * HcnsRepository .
     *
     * @param Hcns
     */
    public function __construct(DeliveryBill $deliveryBillModel)
    {
        $this->deliveryBillModel = $deliveryBillModel;
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }
        $input = [
            DeliveryBill::CREATED_AT    => time(),
            DeliveryBill::CREATED_BY    => $data['created_by'] ?? "",
            DeliveryBill::CREATED_BY    => $data['created_by'] ?? "",
            DeliveryBill::NOTE          => $data['note'] ?? "",
            DeliveryBill::LIST          => $data['list'] ?? "",
            DeliveryBill::STORES        => $data['stores'] ?? "",
            DeliveryBill::LICENSE       => $data['url'] ?? "",
            DeliveryBill::STATUS        => DeliveryBill::STATUS_COMPLETE,
            DeliveryBill::LOGS          => [],
        ];
        $create = $this->deliveryBillModel->create($input);
        if ($create) {
            return $create;
        }
        return false;
    }

    public function find($id)
    {
        $result = $this->deliveryBillModel->where(DeliveryBill::ID, $id)->find($id);
        if ($result) {
            return $result;
        }
        return false;
    }

    public function updateLisence($data = [], $id)
    {
        $push = $this->deliveryBillModel::where(DeliveryBill::ID, $id)->push(DeliveryBill::LICENSE, $data);
        $result = [];
        $result[DeliveryBill::STATUS] = DeliveryBill::STATUS_COMPLETE;
        $update = $this->deliveryBillModel::where(DeliveryBill::ID, $id)->update($result);
        if ($push) {
            return $push;
        }
        return false;
    }

    public function getAllDelivery($data = [])
    {
        $delivery = $this->deliveryBillModel;
        if (!empty($data['start_date'])) {
            $start_date = strtotime($data['start_date'] . '00:00:00');
            $delivery = $delivery->where(DeliveryBill::CREATED_AT, '>=', $start_date);
        }
        if (!empty($data['end_date'])) {
            $end_date = strtotime($data['end_date'] . "23:59:59");
            $delivery = $delivery->where(DeliveryBill::CREATED_AT, '<=', $end_date);
        }
        if (!empty($data['stores'])) {
            $delivery = $delivery->where(DeliveryBill::STORES . '.' . '_id', $data['stores']);
        }
        if (!empty($data['code_area'])) {
            $delivery = $delivery->where(DeliveryBill::STORES . '.' . 'code_area', $data['code_area']);
        }
        if (!empty($data['domain'])) {
            $delivery = $delivery->where(DeliveryBill::STORES . '.' . 'domain', $data['domain']);
        }
        if (!empty($data['status'])) {
            $delivery = $delivery->where(DeliveryBill::STATUS, $data['status']);
        }
        return $delivery
            ->orderBy(DeliveryBill::CREATED_AT, 'DESC')
            ->paginate(10);
    }

    public function wlog($id, $action, $email) {
        $log = [
            'action'        => $action ?? "",
            'created_by'    => $email ?? "",
            'created_at'    => time(),
        ];
        $push = $this->deliveryBillModel->where(DeliveryBill::ID, $id)
        ->push(DeliveryBill::LOGS, $log);
        if ($push) {
            return $push;
        }
        return false;
    }
    
    public function getBillByStoreId($storeId)
    {
        $result = $this->deliveryBillModel::where(DeliveryBill::STORES . '.' . DeliveryBill::STORES_ID, $storeId)
            ->where(DeliveryBill::STATUS, DeliveryBill::STATUS_COMPLETE)
            ->get();
        return $result->toArray();
    }

    public function getAllBillCompleted()
    {
        $condition = [];
        $condition ['status'] =  DeliveryBill::STATUS_COMPLETE;
        $group = $this->deliveryBillModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$unwind' => '$list'],
                    ['$match' => (object)$condition
                    ],
                ['$group' =>
                    [
                        "_id" => '$list.name',
                        "quantity_export" => ['$sum' => '$list.amount'],
                    ]
                ],
                ['$project' =>
                    [
                        'quantity_export' => 1,
                    ]
                ],

            ]);
        });
        return $group;


    }

    public function getAllItembyStoreIdCompleted($store_id)
    {
        $condition = [];
        $condition ['status'] =  DeliveryBill::STATUS_COMPLETE;
        $group = $this->deliveryBillModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$unwind' => '$list'],
                    ['$match' => (object)$condition
                    ],
                ['$group' =>
                    [
                        "_id" => '$stores.id',
                        "quantity_export" => ['$sum' => '$list.amount'],
                    ]
                ],
                ['$project' =>
                    [
                        'quantity_export' => 1,
                    ]
                ],

            ]);
        });
        return $group;

    }

}
