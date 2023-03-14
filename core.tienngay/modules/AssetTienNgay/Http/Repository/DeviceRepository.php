<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\DeviceAsset;

class DeviceRepository extends BaseRepository
{
    public function getModel()
    {
        return DeviceAsset::class;
    }
}
