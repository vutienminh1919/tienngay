<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends BaseModel
{
    const COLUMN_CODE_CONTRACT = 'code_contract';
    const COLUMN_CODE_CONTRACT_DISBURSEMENT = 'code_contract_disbursement';
    const COLUMN_TYPE_LOAN = 'type_loan';
    const COLUMN_TYPE_PROPERTY = 'type_property';
    const COLUMN_NAME_PROPERTY = 'name_property';
    const COLUMN_AMOUNT_MONEY = 'amount_money';
    const COLUMN_AMOUNT_LOAN = 'amount_loan';
    const COLUMN_NUMBER_DAY_LOAN = 'number_day_loan';
    const COLUMN_INVESTMENT_AMOUNT = 'investment_amount';
    const COLUMN_INTEREST = 'interest';
    const COLUMN_INVESTOR_ID = 'investor_id';
    const COLUMN_INVESTOR_CODE = 'investor_code';
    const COLUMN_TYPE_INTEREST = 'type_interest';
    const COLUMN_INTEREST_ID = 'interest_id';
    const COLUMN_NOTE = 'note';
    const COLUMN_CONTRACT_INTEREST_ID = 'contract_interest_id';
    const COLUMN_TYPE_CONTRACT = 'type_contract';
    const COLUMN_PAYMENT_METHOD = 'payment_method';
    const COLUMN_STATUS = 'status';
    const COLUMN_STATUS_CONTRACT = 'status_contract';
    const COLUMN_INVESTMENT_CYCLE = 'investment_cycle';
    const COLUMN_INTEREST_CYCLE = 'interest_cycle';
    const COLUMN_MONTHLY_INTEREST_PAYMENT_DATE = 'monthly_interest_payment_date';
    const COLUMN_DATE_EXPIRE = 'date_expire';
    const COLUMN_START_DATE = 'start_date';
    const COLUMN_DUE_DATE = 'due_date';
    const COLUMN_TYPE_EXTEND = 'type_extend';
    const COLUMN_PARENT_ID = 'parent_id';

    const DU_NO_GIAM_DAN = '1';
    const LAI_HANG_THANG_GOC_CUOI_KY = '2';
    const LAI_3THANG_GOC_CUOI_KY = '3';
    const GOC_LAI_CUOI_KY = '4';
    const LAI_CUOI_THANG = '5';

    const NOTE_LAI_HANG_THANG_GOC_CUOI_KI = 1;
    const NOTE_LAI_GOC_CUOI_KI = 2;
    const NOTE_LAI_3_THANG_GOC_CUOI_KI = 3;

    const HOP_DONG_UY_QUYEN = 'UQ';
    const HOP_DONG_DAU_TU_APP = 'APP';

    const PAYMENT_METHOD_HANDMADE = '1';

    //status
    const SUCCESS = 'success';
    const BLOCK = 'block';
    const PENDING = 'pending';
    const NEW = 'new';

    //status contract
    const EFFECT = 1; // còn hiệu lực
    const EXPIRE = 2; // đã đáo hạn

    //type extend
    const ORIGINAL_REINVESTMENT = 2; //tái đầu tư gốc
    const REINVEST_1_PART_OF_THE_ORIGINAL = 3;  // tái đầu tư 1 phần gốc
    const REINVEST_THE_PRINCIPAL_INTEREST = 4;  // tái đầu tư gốc lãi

    //phat truoc han
    const PUNISH = 1;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contract';

    /**
     * @return BelongsTo
     */
    public function investor()
    {
        return $this->belongsTo(Investor::class, self::COLUMN_INVESTOR_ID);
    }

    /**
     * @return HasMany
     */
    public function pays()
    {
        return $this->hasMany(Pay::class, Pay::COLUMN_CONTRACT_ID);
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, Transaction::COLUMN_CONTRACT_ID);
    }

    /**
     * @return BelongsTo
     */
    public function interest()
    {
        return $this->belongsTo(Interest::class, self::COLUMN_INTEREST_ID);
    }

    public function contract_interest()
    {
        return $this->belongsTo(ContractInterest::class, self::COLUMN_CONTRACT_INTEREST_ID);
    }

}
