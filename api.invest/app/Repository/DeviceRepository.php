<?php


namespace App\Repository;


use App\Models\Device;

class DeviceRepository extends BaseRepository implements DeviceRepositoryInterface
{
    public function getModel()
    {
        return Device::class;
    }

    public function get_device_user($user_id)
    {
        return $this->model
            ->where(Device::COLUMN_USER_ID, $user_id)
            ->first();
    }
}
