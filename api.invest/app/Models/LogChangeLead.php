<?php


namespace App\Models;


class LogChangeLead extends BaseModel
{
    const COLUMN_TYPE = 'type';
    const COLUMN_REQUEST = 'request';
    const COLUMN_RESPONSE = 'response';
    const COLUMN_LEAD_INVESTOR_ID = 'lead_investor_id';
    const COLUMN_INVESTOR_ID = 'investor_id';

    protected $table = 'log_change_lead';
}
