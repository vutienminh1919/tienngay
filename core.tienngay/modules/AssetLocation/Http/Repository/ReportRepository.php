<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Report;

class ReportRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Report::class;
    }

    public function report_all($request, $column)
    {
        $model = $this->model;

        $model = $model->where('month', $request->month);
        return $model->sum($column);

    }
}
