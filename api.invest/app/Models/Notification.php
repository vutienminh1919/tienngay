<?php


namespace App\Models;


class Notification extends BaseModel
{
    const COLUMN_CODE_CONTRACT = 'code_contract';
    const COLUMN_ACTION = 'action';
    const COLUMN_STATUS = 'status';
    const COLUMN_LINK = 'link';
    const COLUMN_MESSAGE = 'message';
    const COLUMN_NOTE = 'note';
    const COLUMN_USER_ID = 'user_id';
    const COLUMN_IMAGE = 'image';
    const COLUMN_BANNER = 'banner';
    const COLUMN_TITLE = 'title';
    const COLUMN_START_DATE = 'start_date';
    const COLUMN_END_DATE = 'end_date';

    const UNREAD = 1;
    const READ = 2;

    const LOAI_DAU_TU = 'investor';
    const LOAI_THANH_TOAN = 'pay';
    const LOAI_XAC_THUC = 'auth';

    //type noti
    const PROMOTION = 1;
    const TRANSACTION = 2;
    const MAILBOX = 3;

    //group type noti
    const GROUP_PROMOTION = ['promotion', 'event'];
    const GROUP_TRANSACTION = ['investor', 'pay'];
    const GROUP_MAILBOX = ['auth', 'general'];

    protected $table = 'notification';

    public function user()
    {
        return $this->belongsTo(User::class, self::COLUMN_USER_ID);
    }


}
