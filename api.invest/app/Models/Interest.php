<?php


namespace App\Models;


class Interest extends BaseModel
{
    const COLUMN_INTEREST = 'interest';
    const COLUMN_DATE_START = 'date_start';
    const COLUMN_DATE_END = 'date_end';
    const COLUMN_STATUS = 'status';
    const COLUMN_TYPE = 'type';
    const COLUMN_PERIOD = 'period';
    const COLUMN_TYPE_INTEREST = 'type_interest';

    const TYPE_ALL = 'all';  //áp dụng chung
    const TYPE_PERIOD = 'period';  //áp dụng theo kì hạn vay
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';

    const DU_NO_GIAM_DAN = 1;
    const LAI_HANG_THANG_GOC_CUOI_KY = 2;
    const GOC_LAI_CUOI_KY = 4;

    protected $table = 'interest';

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function contractInterests()
    {
        return $this->hasMany(ContractInterest::class);
    }
}
