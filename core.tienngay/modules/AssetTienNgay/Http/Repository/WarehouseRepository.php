<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\WarehouseAsset;

class WarehouseRepository extends BaseRepository
{
    public function getModel()
    {
        return WarehouseAsset::class;
    }
}
