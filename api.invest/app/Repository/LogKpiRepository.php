<?php


namespace App\Repository;


use App\Models\LogKpi;

class LogKpiRepository extends BaseRepository implements LogKpiRepositoryInterface
{
    public function getModel()
    {
        return LogKpi::class;
    }

    public function get_all_log_kpi_sv($filter)
    {
        $model = $this->model;
        if (isset($filter['from_date']) && isset($filter['to_date'])) {
            $from_date = $filter['from_date'] . ' 00:00:00' ?? date('Y-m-d 00:00:00', time());
            $to_date = $filter['to_date'] . ' 23:59:59' ?? date('Y-m-d 23:59:59', time());
            $model = $model->whereBetween(LogKpi::CREATED_AT, [$from_date, $to_date]);
        }
        return $model
            ->orderBy(LogKpi::CREATED_AT, self::DESC)
            ->paginate();
    }
}
