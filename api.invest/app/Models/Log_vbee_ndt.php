<?php


namespace App\Models;


class Log_vbee_ndt extends BaseModel
{
       const COLUMN_CAMPAIGN_ID = 'campaign_id';
       const COLUMN_CALL_ID = 'call_id';
       const COLUMN_DUARATION = 'duration';
       const COLUMN_NOTE = 'note';
       const COLUMN_STATE = 'state';
       const COLUMN_END_CODE = 'end_code';
       const COLUMN_KEY_PRESS = 'key_press';

       protected $table = 'log_vbee_ndt';

}
