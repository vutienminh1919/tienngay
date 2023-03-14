<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\TradeItemDetail;

class TradeItemDetailRepository
{
    public function __construct(TradeItemDetail $tradeItemDetail)
    {
        $this->tradeItemDetail = $tradeItemDetail;
    }

    public function insert($data)
    {
        $specification = $data['size'] . ',' . $data['material'] . ',' . $data['tech'];
        $detail = [[
            TradeItemDetail::TYPE => $data['type'] ?? "",
            TradeItemDetail::PRICE => (int)$data['price'] ?? "",
            TradeItemDetail::SPECIFICATION => $specification,
            TradeItemDetail::STATUS => TradeItemDetail::STATUS_ACTIVE,
            TradeItemDetail::DATE => !empty($data['date']) ? strtotime($data['date']) : "",
            TradeItemDetail::CREATED_AT => time(),
            TradeItemDetail::CREATED_BY => $data['created_by'] ?? "",
            TradeItemDetail::IMAGE => $data['path'] ?? "",
            TradeItemDetail::STORE => $data['store'] ?? "",
        ]];
        $result = [
            TradeItemDetail::ITEM_ID => $data['item_id'],
            TradeItemDetail::SLUG_NAME => slugify($data['name']),
            TradeItemDetail::DETAIL => $detail,
            TradeItemDetail::CREATED_AT => time(),
            TradeItemDetail::CREATED_BY => $data['created_by'] ?? "",
            TradeItemDetail::STATUS => TradeItemDetail::STATUS_ACTIVE,
        ];
        $create = $this->tradeItemDetail->insert($result);
        return $create;
    }

    public function updateInsertDetail($data, $item_id)
    {
        $specification = $data['size'] . ',' . $data['material'] . ',' . $data['tech'];
        $detail = [
            TradeItemDetail::TYPE => $data['type'] ?? "",
            TradeItemDetail::PRICE => (int)$data['price'] ?? "",
            TradeItemDetail::SPECIFICATION => $specification,
            TradeItemDetail::STATUS => TradeItemDetail::STATUS_ACTIVE,
            TradeItemDetail::DATE => !empty($data['date']) ? strtotime($data['date']) : "",
            TradeItemDetail::CREATED_AT => time(),
            TradeItemDetail::CREATED_BY => $data['created_by'] ?? "",
            TradeItemDetail::IMAGE => $data['path'] ?? "",
            TradeItemDetail::STORE => $data['store'] ?? "",
        ];
        $push = $this->tradeItemDetail::where(TradeItemDetail::ITEM_ID, $item_id)->push(TradeItemDetail::DETAIL, $detail);
        return $push;

    }

}
