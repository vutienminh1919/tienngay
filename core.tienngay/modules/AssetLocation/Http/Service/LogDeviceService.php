<?php


namespace Modules\AssetLocation\Http\Service;


use Carbon\Carbon;
use Modules\AssetLocation\Http\Repository\LogDeviceRepository;
use Modules\AssetLocation\Model\LogDevice;

class LogDeviceService extends BaseService
{
    protected $logDeviceRepository;

    public function __construct(LogDeviceRepository $logDeviceRepository)
    {
        $this->logDeviceRepository = $logDeviceRepository;
    }

    public function create($old, $new, $type, $request)
    {
        $data = [
            LogDevice::OLD => $old,
            LogDevice::NEW => $new,
            LogDevice::TYPE => $type,
            LogDevice::DEVICE_ASSET_LOCATION_ID => $new['_id'],
            LogDevice::CREATED_AT => Carbon::now()->unix(),
            LogDevice::CREATED_BY => $request->user->email ?? null
        ];
        $this->logDeviceRepository->create($data);
    }
}
