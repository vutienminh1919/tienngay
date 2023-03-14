<?php

namespace App\Models;

class LogInvestor extends BaseModel
{

    protected $table = 'log_investor';


    const COLUMN_REQUEST = 'request';
    const COLUMN_RESPONSE = 'response';
    const COLUMN_URL = 'url';
    const COLUMN_TYPE = 'type';

}
