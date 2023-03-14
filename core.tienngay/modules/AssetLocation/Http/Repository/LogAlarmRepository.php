<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\LogAlarm;

class LogAlarmRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogAlarm::class;
    }
}
