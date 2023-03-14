<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\LogAllotment;
use Modules\MongodbCore\Entities\TradeInventoryReport;
use Modules\MongodbCore\Repositories\Interfaces\TradeInventoryReportRepositoryInterface;

class TradeInventoryReportRepository implements TradeInventoryReportRepositoryInterface
{
    public function __construct(TradeInventoryReport $tradeInventoryReport, LogAllotment $logAllotment)
    {
        $this->tradeInventoryReport = $tradeInventoryReport;
        $this->logAllotment = $logAllotment;

    }

    public function getAll($dataSearch = [])
    {
        $result = $this->tradeInventoryReport;
        if (!empty($dataSearch['status'])) {
            $result = $result->where(TradeInventoryReport::STATUS, (int)$dataSearch['status']);
        }
        if (!empty($dataSearch['store'])) {
            $result = $result->where(TradeInventoryReport::STORE_ID, $dataSearch['store']);
        } elseif (!empty($dataSearch['pgds'])) {
            $arr = [];
            foreach ($dataSearch['pgds'] as $item) {
                $arr[] = $item['_id'];
            }
            $result = $result->whereIn(TradeInventoryReport::STORE_ID, $arr);
        }
        if (!empty($dataSearch['start_date'])) {
            $start_date = strtotime($dataSearch['start_date'] . '00:00:00');
            $result = $result->where(TradeInventoryReport::CREATED_AT, '>=', $start_date);
        }
        if (!empty($dataSearch['end_date'])) {
            $end_date = strtotime($dataSearch['end_date'] . "23:59:59");
            $result = $result->where(TradeInventoryReport::CREATED_AT, '<=', $end_date);
        }
        return $result->orderBy(TradeInventoryReport::CREATED_AT, 'desc')->paginate(10);

    }

    public function insert($data = [])
    {
        $result = [
            TradeInventoryReport::STORE_ID => $data['store']['id'],
            TradeInventoryReport::STORE_NAME => $data['store']['name'],
            TradeInventoryReport::ITEM => $data['item'],
            TradeInventoryReport::DESCRIPTION => $data['description'],
            TradeInventoryReport::LICENSE => $data['license'],
            TradeInventoryReport::CREATED_AT => time(),
            TradeInventoryReport::CREATED_BY => $data['created_by'],
            TradeInventoryReport::STATUS => TradeInventoryReport::STATUS_WAIT_FORCONTROL
        ];
        $create = $this->tradeInventoryReport->create($result);
        return $create;

    }

    public function update($data = [], $id)
    {
        $result = [
            TradeInventoryReport::STORE => $data['store'],
            TradeInventoryReport::ITEM => [],
            TradeInventoryReport::DESCRIPTION => $data['description'] ?? "",
            TradeInventoryReport::LICENSE => $data['license'],
            TradeInventoryReport::UPDATED_AT => time(),
            TradeInventoryReport::UPDATED_BY => 'System'
        ];
        $update = $this->tradeInventoryReport::where(TradeStorageReport::ID, $id)->update($result);
        return $update;

    }

    public function detail($id)
    {
        $result = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $id)->first();
        if ($result) {
            return $result->toArray();
        }
        return [];
    }

    public function getByStoreId($storeId)
    {
        $result = $this->tradeInventoryReport::where(TradeInventoryReport::STORE_ID, $storeId)
            ->orderBy(TradeInventoryReport::CREATED_AT, 'desc')
            ->get();
        return $result;

    }

    public function insertExplanation($data)
    {
        $result = [
            TradeInventoryReport::EXPLANATION . '.' . TradeInventoryReport::ITEM => $data['item'],
            TradeInventoryReport::EXPLANATION . '.' . TradeInventoryReport::CREATED_AT => time(),
            TradeInventoryReport::EXPLANATION . '.' . TradeInventoryReport::CREATED_BY => $data['created_by'],
            TradeInventoryReport::STATUS => TradeInventoryReport::STATUS_WAIT_ADJUSTMENT
        ];
        $create = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $data['id'])->update($result);
        return $create;
    }

    public function adjustmentInsert($data)
    {
        $result = [
            TradeInventoryReport::ITEM => $data['item'],
            TradeInventoryReport::CREATED_AT => time(),
            TradeInventoryReport::CREATED_BY => $data['created_by'],
            TradeInventoryReport::ITEM_ID => $data['id'],
            TradeInventoryReport::NOTE => $data['note'],
            TradeInventoryReport::STATUS => TradeInventoryReport::STATUS_ADJUSTMENT_NEW
        ];
        $status = [
            TradeInventoryReport::STATUS => TradeInventoryReport::STATUS_WAIT_APPROVED_ADJUSTMENT,
        ];
        $this->tradeInventoryReport::where(TradeInventoryReport::ID, $data['id_report'])->update($status);
        $create = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $data['id_report'])->push('adjustment', $result);
        return $create;

    }

    public function updateAdjustmentDone($data, $ad)
    {
        $update = $this->tradeInventoryReport::raw(function ($collection) use ($data, $ad) {
            return $collection->updateMany(
                [TradeInventoryReport::ID => new \MongoDB\BSON\ObjectID($data['id_report'])],
                ['$pull' => ["adjustment" => ['id' => $data['id']]]],
                ['upsert' => false],
                ["multi" => true]
            );
        });
        $push = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $data['id_report'])
            ->push('adjustment', $ad);
        $result = [
            TradeInventoryReport::STATUS => TradeInventoryReport::STATUS_DONE,
        ];
        $done = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $data['id_report'])->update($result);
        return $done;
    }

    public function updateAdjustmentCancel($data, $ad)
    {
        $update = $this->tradeInventoryReport::raw(function ($collection) use ($data, $ad) {
            return $collection->updateMany(
                [TradeInventoryReport::ID => new \MongoDB\BSON\ObjectID($data['id_report'])],
                ['$pull' => ["adjustment" => ['id' => $data['id']]]],
                ['upsert' => false],
                ["multi" => true]
            );
        });
        $push = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $data['id_report'])
            ->push('adjustment', $ad);
        $result = [TradeInventoryReport::ADJUSTMENT => $data['adjustment']];
        $cancel = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $data['id_report'])->update($result);
        return $cancel;
    }

    public function getReportByStoreId($id)
    {
        $result = $this->tradeInventoryReport::where(TradeInventoryReport::STATUS, TradeInventoryReport::STATUS_WAIT_FORCONTROL)
            ->first();
        if ($result) {
            return $result->toArray();
        }
        return [];
    }

    public function reportForControl($id, $diff = true)
    {
        if ($diff) {
            $result = [
                TradeInventoryReport::STATUS => TradeInventoryReport::STATUS_WAIT_EXPLANATION,
                TradeInventoryReport::FOR_CONTROL => [
                    TradeInventoryReport::CREATED_AT => time(),
                    TradeInventoryReport::CREATED_BY => TradeInventoryReport::SYSTEM,
                    TradeInventoryReport::DIFF => TradeInventoryReport::DIFF_TRUE,
//                    TradeInventoryReport::DATA => $data,
                ],
            ];
        } else {
            $result = [
                TradeInventoryReport::STATUS => TradeInventoryReport::STATUS_DONE,
                TradeInventoryReport::FOR_CONTROL => [
                    TradeInventoryReport::CREATED_AT => time(),
                    TradeInventoryReport::CREATED_BY => TradeInventoryReport::SYSTEM,
                    TradeInventoryReport::DIFF => TradeInventoryReport::DIFF_FALSE,
//                    TradeInventoryReport::DATA => $data,
                ],

            ];
        }
        $update = $this->tradeInventoryReport::where(TradeInventoryReport::ID, $id)->update($result);
        return $update;

    }

    public function getAllItemImportAllotment()
    {
        $group = $this->logAllotment::raw(function ($collection) {
            return $collection->aggregate([
                ['$group' =>
                    [
                        "_id" => '$code_item',
                        "quantity_import" => ['$sum' => '$quantity_import']
                    ]
                ],
                ['$project' =>
                    [
                        'quantity_import' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    public function getAllItemImportAllotmentByStore()
    {
        $group = $this->logAllotment::raw(function ($collection) {
            return $collection->aggregate([
                ['$group' =>
                    [
                        "_id" => '$store_id',
                        "quantity_import" => ['$sum' => '$quantity_import']
                    ]
                ],
                ['$project' =>
                    [
                        'quantity_import' => 1,
                    ]
                ],

            ]);
        });

        return $group;

    }

    public function getLastestReportForControlExist($store_id)
    {
        $result = $this->tradeInventoryReport::where(TradeInventoryReport::STATUS, TradeInventoryReport::STATUS_WAIT_EXPLANATION)
            ->where(TradeInventoryReport::STORE_ID, $store_id)
            ->where(TradeInventoryReport::FOR_CONTROL, '$exists', true)
            ->where(TradeInventoryReport::FOR_CONTROL . '.' . TradeInventoryReport::DIFF, TradeInventoryReport::DIFF_TRUE)
            ->orderBy(TradeInventoryReport::CREATED_AT, 'desc')
            ->limit(1)
            ->get()->toArray();
        return $result;
    }

}
