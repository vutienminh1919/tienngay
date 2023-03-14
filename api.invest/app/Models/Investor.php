<?php


namespace App\Models;


class Investor extends BaseModel
{
    const COLUMN_CODE = 'code';
    const COLUMN_NAME = 'name';
    const COLUMN_IDENTITY = 'identity';
    const COLUMN_PHONE_NUMBER = 'phone_number';
    const COLUMN_EMAIL = 'email';
    const COLUMN_STATUS = 'status';
    const COLUMN_PHONE_VIMO = 'phone_vimo';
    const COLUMN_LINKED_ID_VIMO = 'linked_id_vimo';
    const COLUMN_TOKEN_ID_VIMO = 'token_id_vimo';
    const COLUMN_USER_ID = 'user_id';
    const COLUMN_FRONT_CARD = 'front_facing_card';
    const COLUMN_CARD_BACK = 'card_back';
    const COLUMN_AVATAR = 'avatar';
    const COLUMN_ACTIVE_AT = 'active_at';
    const COLUMN_INVESTOR_REVIEWS = 'investor_reviews';
    const COLUMN_BIRTHDAY = 'birthday';
    const COLUMN_CITY = 'city';
    const COLUMN_STATUS_CALL = 'status_call';
    const COLUMN_ASSIGN_CALL = 'assign_call';
    const COLUMN_INVESTMENT_STATUS = 'investment_status';
    const COLUMN_INTEREST_RECEIVING_ACCOUNT = 'interest_receiving_account';
    const COLUMN_TYPE_INTEREST_RECEIVING_ACCOUNT = 'type_interest_receiving_account';
    const COLUMN_BANK_NAME = 'bank_name';
    const COLUMN_NAME_BANK_ACCOUNT = 'name_bank_account';
    const COLUMN_TYPE_CARD = 'type_card';
    const COLUMN_TIME_ASSIGN_CALL = 'time_assign_call';
    const COLUMN_ADDRESS = 'address';
    const COLUMN_JOB = 'job';


    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';
    const STATUS_DEACTIVE = 'deactive';

    const REVIEWS_MEMBER = 'member';
    const REVIEWS_BRONZE = 'bronze';
    const REVIEWS_SILVER = 'silver';
    const REVIEWS_GOLD = 'gold';
    const REVIEWS_DIAMON = 'diamon';

    //investment status
    const DA_DAU_TU = 1;
    const CHUA_DAU_TU = 2;

    //hinh thuc nhan lai cua ndt
    const TYPE_PAYMENT_VIMO = 'vimo';
    const TYPE_PAYMENT_BANK = 'bank';
    const TYPE_PAYMENT_MOMO = 'momo';

    const TAI_KHOAN_BANK = 1;
    const THE_ATM = 2;

    const STATUS_CALL_BACKLOG = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'investor';

//    protected $dates = [self::COLUMN_ACTIVE_AT];

    public function contracts()
    {
        return $this->hasMany(Contract::class, Contract::COLUMN_INVESTOR_ID);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Contract::class);
    }

    public function call()
    {
        return $this->hasOne(Call::class, Call::COLUMN_INVESTOR_ID);
    }

    public function lotteries()
    {
        return $this->hasMany(Lottery::class, Lottery::COLUMN_INVESTOR_ID);
    }

}
