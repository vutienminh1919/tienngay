<?php


namespace App\Models;


class LogPay extends BaseModel
{
    const COLUMN_REQUEST = 'request';
    const COLUMN_RESPONSE = 'response';
    const COLUMN_TYPE = 'type';
    const COLUMN_PAY_ID = 'pay_id';

    protected $table = 'log_pay';
}
