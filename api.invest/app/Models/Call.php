<?php


namespace App\Models;


class Call extends BaseModel
{
    const COLUMN_STATUS = 'status';
    const COLUMN_NOTE = 'note'; // ly do huy
    const COLUMN_INVESTOR_ID = 'investor_id';
    const COLUMN_CALL_NOTE = 'call_note'; // call ghi chu
    const COLUMN_LEAD_INVESTOR_ID = 'lead_investor_id'; // call ghi chu


    protected $table = 'call';

    public function log_call()
    {
        return $this->hasMany(LogCall::class, LogCall::COLUMN_CALL_ID);
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, self::COLUMN_INVESTOR_ID);
    }

    public function lead_investor()
    {
        return $this->belongsTo(LeadInvestor::class, self::COLUMN_LEAD_INVESTOR_ID);
    }


}
