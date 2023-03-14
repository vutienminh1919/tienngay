<?php


namespace App\Models;


class ContractInterest extends BaseModel
{
    const COLUMN_INTEREST_ID = 'interest_id';
    const COLUMN_INTEREST = 'interest';
    const COLUMN_MONEY = 'money';
    const COLUMN_STATUS = 'status';

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';
    protected $table = 'contract_interest';

    public function contracts()
    {
        return $this->hasMany(Contract::class, Contract::COLUMN_CONTRACT_INTEREST_ID);
    }

    public function interest()
    {
        return $this->belongsTo(Interest::class, self::COLUMN_INTEREST_ID);
    }
}
