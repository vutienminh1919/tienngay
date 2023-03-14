<?php


namespace App\Models;


class LogCall extends BaseModel
{
    const COLUMN_OLD = 'old';
    const COLUMN_NEW = 'new';
    const COLUMN_CALL_ID = 'call_id';

    protected $table = 'log_call';


    public function call()
    {
        return $this->belongsTo(Call::class, self::COLUMN_CALL_ID);
    }
}
