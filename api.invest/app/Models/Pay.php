<?php


namespace App\Models;


class Pay extends BaseModel
{
    const COLUMN_CONTRACT_ID = 'contract_id';
    const COLUMN_CODE_CONTRACT = 'code_contract';
    const COLUMN_INVESTOR_CODE = 'investor_code';
    const COLUMN_INTEREST = 'interest';
    const COLUMN_TYPE = 'type';
    const COLUMN_KI_TRA = 'ky_tra';
    const COLUMN_NGAY_KY_TRA = 'ngay_ky_tra';
    const COLUMN_GOC_LAI_1KY = 'goc_lai_1ky';
    const COLUMN_TIEN_GOC_1KY = 'tien_goc_1ky';
    const COLUMN_TIEN_GOC_CON = 'tien_goc_con';
    const COLUMN_LAI_KY = 'lai_ky';
    const COLUMN_STATUS = 'status';
    const COLUMN_TIEN_GOC_1KY_PHAI_TRA = 'tien_goc_1ky_phai_tra';
    const COLUMN_TIEN_LAI_1KY_PHAI_TRA = 'tien_lai_1ky_phai_tra';
    const COLUMN_DAYS = 'days';
    const COLUMN_INTEREST_PERIOD = 'interest_period';

    const DA_THANH_TOAN = 2;
    const CHUA_THANH_TOAN = 1;
    const THANH_TOAN_TU_DONG_THAT_BAI = 3; //vimo
    const CHO_NGAN_LUONG_XU_LY = 4;
    const THANH_TOAN_NGAN_LUONG_THAT_BAI = 5;
    const NGAN_LUONG_DA_HOAN_TRA = 6;
    const DANG_XU_LY = 7;
    const HUY = 8;


    protected $table = 'pay';

    public function contract()
    {
        return $this->belongsTo(Contract::class, self::COLUMN_CONTRACT_ID);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

}
