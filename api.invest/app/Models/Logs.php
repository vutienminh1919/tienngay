<?php


namespace App\Models;


class Logs extends BaseModel
{
    protected $table = 'logs';

    const REQUEST = 'request';
    const RESPONSE = 'response';
    const FUNCTION = 'function';
}
