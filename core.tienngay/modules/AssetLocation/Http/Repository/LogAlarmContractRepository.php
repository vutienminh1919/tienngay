<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Device;
use Modules\AssetLocation\Model\LogAlarmContract;

class LogAlarmContractRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogAlarmContract::class;
    }

    public function log_alarm_fencein_by_contract($start_time, $end_time, $code_contract)
    {
        $model = $this->model;
        $model = $model
            ->where('code_contract', $code_contract)
            ->whereBetween('created_at', [$start_time, $end_time])
            ->where('alarmCode', Device::ALARM_FENCEIN)
            ->first();
        return $model;
    }
}
