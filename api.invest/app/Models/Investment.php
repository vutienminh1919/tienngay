<?php


namespace App\Models;


class Investment extends BaseModel
{
    const COLUMN_CODE_CONTRACT = 'code_contract';
    const COLUMN_CODE_CONTRACT_DISBURSEMENT = 'code_contract_disbursement';
    const COLUMN_AMOUNT_MONEY = 'amount_money';
    const COLUMN_NUMBER_DAY_LOAN = 'number_day_loan';
    const COLUMN_TYPE_INTEREST = 'type_interest';
    const COLUMN_TYPE = 'type';
    const COLUMN_CONTRACT_ID = 'contract_id';
    const COLUMN_INVESTOR_CONFIRM = 'investor_confirm';
    const COLUMN_NUMBER = 'number';
    const COLUMN_STATUS = 'status';
    const COLUMN_OTP_INVEST = 'otp_invest';
    const COLUMN_TIME_OTP_INVEST = 'time_otp_invest';
    const COLUMN_INVESTOR_CREATE_OTP = 'investor_create_otp';

    const DU_NO_GIAM_DAN = '1';
    const LAI_HANG_THANG_GOC_CUOI_KY = '2';

    //type
    const HOP_DONG_DA_GN = 1;
    const HOP_DONG_GOI_VON = 2;

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';

    protected $table = 'investment';
}
