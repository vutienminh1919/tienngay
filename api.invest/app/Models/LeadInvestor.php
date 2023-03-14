<?php


namespace App\Models;


class LeadInvestor extends BaseModel
{
    const COLUMN_NAME = 'name';
    const COLUMN_PHONE = 'phone';
    const COLUMN_PHONE_LINK = 'phone_link';
    const COLUMN_STATUS_CALL = 'status_call';
    const COLUMN_STATUS = 'status';
    const COLUMN_CITY = 'city';
    const COLUMN_IDENTITY = 'identity';
    const COLUMN_BIRTHDAY = 'birthday';
    const COLUMN_EMAIL = 'email';
    const COLUMN_SOURCE = 'source';
    const COLUMN_ASSIGN_CALL = 'assign_call';
    const COLUMN_UTM_LINK = 'utm_link';
    const COLUMN_UTM_CAMPAIGN = 'utm_campaign';
    const COLUMN_UTM_SOURCE = 'utm_source';
    const COLUMN_TIME_ASSIGN_CALL = 'time_assign_call';
    const COLUMN_PRIORITY = 'priority';
    const COLUMN_SCAN_DATE = 'scan_date';
    const COLUMN_DAY_CALL = 'day_call';
    const COLUMN_CALL_ID = 'call_id';
    const COLUMN_STATE = 'state';
    const COLUMN_VBEE_CALL = 'vbee_call';

    const COLUMN_PRIORITY_ONE = 1;//Độ ưu tiên cao
    const COLUMN_PRIORITY_TWO = 2;//Độ ưu tiên trung bình
    const COLUMN_PRIORITY_THREE = 3;//Độ ưu tiên thấp
    const COLUMN_PRIORITY_FOUR = 4;//Độ ưu tiên kém

    const COLUMN_SOURCE_VBEE = 4;

    //trạng thái lead gửi sang vbee ("0" là chưa đẩy,"1" là đã đẩy )

    const COLUMN_LEAD_STATUS = "lead_status"; // trạng thái cuộc gọi

    const COLUMN_LEAD_STATUS_BLOCK = 0;
    const COLUMN_LEAD_STATUS_ACTIVE = 1;


    protected $table = 'lead_investor';

    public function call()
    {
        return $this->hasOne(Call::class, Call::COLUMN_LEAD_INVESTOR_ID);
    }
}
