<?php


namespace App\Models;


class Lottery extends BaseModel
{
    protected $table = 'lottery';

    const COLUMN_PROGRAM = 'program';
    const COLUMN_SLUG = 'slug';
    const COLUMN_NAME = 'name';
    const COLUMN_PHONE = 'phone';
    const COLUMN_EMAIL = 'email';
    const COLUMN_IDENTITY = 'identity';
    const COLUMN_INVESTOR_ID = 'investor_id';
    const COLUMN_CODE = 'code';
    const COLUMN_NUMBER_CODE = 'number_code';
    const COLUMN_TIME = 'time';
    const COLUMN_TOTAL_MONEY = 'total_money';
    const COLUMN_START_DATE = 'start_date';
    const COLUMN_END_DATE = 'end_date';
    const COLUMN_STATUS = 'status';
    const COLUMN_ADDRESS= 'address';

    public function investor() {
        return $this->belongsTo(Investor::class, self::COLUMN_INVESTOR_ID);
    }
}
