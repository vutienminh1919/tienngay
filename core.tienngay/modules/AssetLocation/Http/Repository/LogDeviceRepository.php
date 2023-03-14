<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\LogDevice;

class LogDeviceRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogDevice::class;
    }
}
