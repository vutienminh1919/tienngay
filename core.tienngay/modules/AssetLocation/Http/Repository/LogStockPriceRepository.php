<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\LogStockPrice;

class LogStockPriceRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogStockPrice::class;
    }
}
