<?php


namespace App\Models;


class ConfigCall extends BaseModel
{
    const COLUMN_TELESALES = 'telesales';
    const COLUMN_START_TIME = 'start_time';
    const COLUMN_END_TIME = 'end_time';
    const COLUMN_DATE = 'date';

    protected $table = 'config_call';
}
