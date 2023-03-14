<?php


namespace App\Models;


class LogKpi extends BaseModel
{
    protected $table = 'log_kpi';

    const COLUMN_ACTION = 'action';
    const COLUMN_TYPE = 'type';
    const COLUMN_OLD = 'old';
    const COLUMN_NEW = 'new';
    const COLUMN_ID_KPI = 'id_kpi';
    const COLUMN_CREATED_BY = 'created_by';
}
