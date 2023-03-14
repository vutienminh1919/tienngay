<?php


namespace App\Service;


use App\Models\LogKpi;
use App\Repository\LogKpiRepository;
use App\Repository\LogKpiRepositoryInterface;

class LogKpiService extends BaseService
{
    protected $log_kpi_model;
    public function __construct(
        LogKpiRepositoryInterface $logKpiRepository
    )
    {
        $this->log_kpi_model = $logKpiRepository;
    }

    public function insert_log_kpi($data_new, $data_old = array())
    {
        $dataInsert = [
            LogKpi::COLUMN_ID_KPI => $data_old['id'],
            LogKpi::COLUMN_ACTION => $data_new['action'],
            LogKpi::COLUMN_TYPE => $data_new['type'],
            LogKpi::COLUMN_NEW => json_encode($data_new),
            LogKpi::COLUMN_OLD => json_encode($data_old),
            LogKpi::COLUMN_CREATED_BY => $data_new['created_by']
        ];
        $this->log_kpi_model->create($dataInsert);
    }
}
