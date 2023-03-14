<?php


namespace App\Repository;


use App\Models\LogPay;

class LogPayRepository extends BaseRepository implements LogPayRepositoryInterface
{
    public function getModel()
    {
        return LogPay::class;
    }
}
