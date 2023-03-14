<?php


namespace App\Models;


class LogConfigCall extends BaseModel
{
    const COLUMN_TYPE = 'type';
    const COLUMN_REQUEST = 'request';
    const COLUMN_RESPONSE = 'response';
    const COLUMN_CONFIG_CALL_ID = 'config_call_id';

    protected $table = 'log_config_call';
}
