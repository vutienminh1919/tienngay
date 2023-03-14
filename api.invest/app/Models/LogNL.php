<?php


namespace App\Models;


class LogNL extends BaseModel
{
    const COLUMN_REQUEST = 'request';
    const COLUMN_RESPONSE = 'response';
    const COLUMN_TYPE = 'type';
    const COLUMN_FLOW = 'flow';
    const COLUMN_DRAFT_NL_ID = 'draft_nl_id';
    const COLUMN_ORDER_CODE = 'order_code';

    //flow
    const PAYOUT = 'payout';
    const PAYIN = 'payin';

    protected $table = 'log_nl';
}


