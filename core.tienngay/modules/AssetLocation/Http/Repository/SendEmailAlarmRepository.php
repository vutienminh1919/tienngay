<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\SendEmailAlarm;

class SendEmailAlarmRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return SendEmailAlarm::class;
    }
}
