<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\TradeAdjustment;
use Modules\MongodbCore\Repositories\Interfaces\TradeAdjustmentRepositoryInterface;

class TradeAdjustmentRepository implements TradeAdjustmentRepositoryInterface
{
    public function __construct(TradeAdjustment $tradeAdjustment)
    {
        $this->tradeAdjustment = $tradeAdjustment;
    }

    public function getAll($dataSearch)
    {
        $result = $this->tradeAdjustment;
        if (!empty($dataSearch['status'])) {
            $result = $result->where(TradeAdjustment::STATUS, (int)$dataSearch['status']);
        };
        if (!empty($dataSearch['store'])) {
            $result = $result->where(TradeAdjustment::STORE_ID, $dataSearch['store']);
        };
        if (!empty($dataSearch['start_date'])) {
            $start_date = strtotime($dataSearch['start_date'].'00:00:00');
            $result = $result->where(TradeAdjustment::CREATED_AT, '>=', $start_date);
        }
        if (!empty($dataSearch['end_date'])) {
            $end_date = strtotime($dataSearch['end_date']."23:59:59");
            $result = $result->where(TradeAdjustment::CREATED_AT, '<=', $end_date);
        }

        return $result->orderBy(TradeAdjustment::CREATED_AT, 'desc')->paginate(10);
    }

    public function insert($data = [])
    {
        $result = [
            TradeAdjustment::STORE_ID => $data['store']['id'] ?? "",
            TradeAdjustment::STORE_NAME => $data['store']['name'] ?? "",
            TradeAdjustment::ITEM => $data['item'],
            TradeAdjustment::DESCRIPTION => $data['description'] ?? "",
            TradeAdjustment::CREATED_AT => time(),
            TradeAdjustment::CREATED_BY => $data['created_by'] ?? "",
            TradeAdjustment::STATUS => TradeAdjustment::STATUS_PENDING,
        ];
        $create = $this->tradeAdjustment->create($result);
        return $create;
    }

    public function detail($id)
    {
        $detail = $this->tradeAdjustment::where(TradeAdjustment::ID, $id)->first();
        return $detail;

    }

    public function updateStatusDone($id)
    {
        $result = [
            TradeAdjustment::STATUS => TradeAdjustment::STATUS_DONE,
        ];
        $done = $this->tradeAdjustment::where(TradeAdjustment::ID, $id)->update($result);
        return $done;

    }

    public function updateStatusCancel($id)
    {
        $result = [
            TradeAdjustment::STATUS => TradeAdjustment::STATUS_CANCEL,
        ];
        $cancel = $this->tradeAdjustment::where(TradeAdjustment::ID, $id)->update($result);
        return $cancel;

    }

    public function wlog($id, $action, $createdBy) {
        $log = [
            'action'        => $action,
            'created_by'    => $createdBy,
            'created_at'    => time()
        ];
        $log = $this->tradeAdjustment::where(TradeAdjustment::ID, $id)
            ->push(TradeAdjustment::LOG, $log);
        return $log;

    }

}
