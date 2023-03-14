<?php


namespace App\Models;


class LogVimo extends BaseModel
{
    const COLUMN_REQUEST = 'request';
    const COLUMN_RESPONSE = 'response';
    const COLUMN_TYPE = 'type';

    protected $table = 'log_vimo';
}
