<?php


namespace App\Models;


class Transaction extends BaseModel
{
    //type
    const DAU_TU = '1';
    const TRA_LAI = '2';

    //column
    const COLUMN_CONTRACT_ID = 'contract_id';
    const COLUMN_TYPE = 'type';
    const COLUMN_CODE_CONTRACT = 'code_contract';
    const COLUMN_INVESTMENT_AMOUNT = 'investment_amount';
    const COLUMN_INVESTOR_CODE = 'investor_code';
    const COLUMN_ACCOUNT_BALANCE = 'account_balance';
    const COLUMN_TRANSACTION_VIMO = 'transaction_vimo';
    const COLUMN_TYPE_METHOD = 'type_method';
    const COLUMN_STATUS = 'status';
    const COLUMN_TIEN_GOC = 'tien_goc';
    const COLUMN_TIEN_LAI = 'tien_lai';
    const COLUMN_INTEREST = 'interest';
    const COLUMN_NOTE = 'note';
    const COLUMN_PAY_ID = 'pay_id';
    const COLUMN_TONG_GOC_LAI = 'tong_goc_lai';
    const COLUMN_DATE_PAY = 'date_pay';
    const COLUMN_PAYMENT_METHOD = 'payment_method';
    const COLUMN_APPLICABLE_INTEREST = 'applicable_interest';
    const COLUMN_TYPE_PAYMENT_METHOD = 'type_payment_method';
    const COLUMN_DATE_DIFF = 'date_diff';
    const COLUMN_PAYMENT_SOURCE = 'payment_source';
    const COLUMN_TRADING_CODE = 'trading_code';
    const COLUMN_INTEREST_EARLY = 'interest_early';  //lai phai tra khi dao truoc han
    const COLUMN_INTEREST_PAID = 'interest_paid';  //lai da tra truoc khi dao truoc han

    //status
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 2;
    const STATUS_WARNING = 3;

    const FORM_AUTO = 1;
    const FORM_HANDMADE = 2;

    const PAYMENT_SOURCE_MOMO = 'momo';
    const PAYMENT_SOURCE_VIMO = 'vimo';
    const PAYMENT_SOURCE_NGAN_LUONG = 'nganluong';

    /**
     * @var string
     */
    protected $table = 'transaction';

    public function contract()
    {
        return $this->belongsTo(Contract::class, self::COLUMN_CONTRACT_ID);
    }

    public function pay()
    {
        return $this->belongsTo(Pay::class);
    }
}
