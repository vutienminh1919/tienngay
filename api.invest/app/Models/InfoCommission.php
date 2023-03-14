<?php


namespace App\Models;


class InfoCommission extends BaseModel
{
    protected $table = 'info_commission';

    const USER_ID = 'user_id';
    const DETAIL_ID = 'detail_id';
    const COMMISSION = 'commission';
    const TIME = 'time';
    const TOTAL_MONEY = 'total_money';
    const MONEY_COMMISSION = 'money_commission';
    const CONTRACT_ID = 'contract_id';
    const DAY = 'day';

    public function user()
    {
        return $this->belongsTo(User::class, self::USER_ID);
    }
}
