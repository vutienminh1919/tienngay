<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\EquipmentAsset;

class EquipmentRepository extends BaseRepository
{
    public function getModel()
    {
        return EquipmentAsset::class;
    }
}
