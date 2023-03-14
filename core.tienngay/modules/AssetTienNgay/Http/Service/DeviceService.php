<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Repository\BaseRepository;
use Modules\AssetTienNgay\Http\Repository\DeviceRepository;
use Modules\AssetTienNgay\Model\DeviceAsset;

class DeviceService extends BaseService
{
    protected $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    public function device($request)
    {
        $device_user = $this->deviceRepository->findOne([DeviceAsset::USER_ID => (string)$request->user_info->_id]);
        if ($device_user) {
            $this->deviceRepository->update($device_user->_id, [DeviceAsset::DEVICE => $request->device, DeviceAsset::UPDATED_AT => time()]);
        } else {
            $data = [
                DeviceAsset::USER_ID => (string)$request->user_info->_id,
                DeviceAsset::DEVICE => $request->device,
                DeviceAsset::CREATED_AT => time()
            ];
            $this->deviceRepository->create($data);
        }

    }
}
