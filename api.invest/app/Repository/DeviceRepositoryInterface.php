<?php


namespace App\Repository;


interface DeviceRepositoryInterface extends BaseRepositoryInterface
{
    public function get_device_user($user_id);
}
