<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Device;
use Modules\AssetLocation\Model\Warehouse;

class WarehouseRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Warehouse::class;
    }
}
