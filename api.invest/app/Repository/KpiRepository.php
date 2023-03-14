<?php


namespace App\Repository;

use App\Models\Kpi;

class KpiRepository extends BaseRepository implements KpiRepositoryInterface
{
    public function getModel()
    {
        return Kpi::class;
    }

    public function findExistsKpi($condition)
    {
        return $this->model
            ->where(Kpi::MONTH, $condition['month'])
            ->where(Kpi::YEAR, $condition['year'])
            ->first();
    }
}
