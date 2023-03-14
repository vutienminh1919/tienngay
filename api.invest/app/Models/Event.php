<?php


namespace App\Models;


class Event extends BaseModel
{
    protected $table = 'event';

    const EVENT = 'event';
    const SLUG = 'slug';
    const TITLE = 'title';
    const SHORT_DESCRIPTION = 'short_description';
    const LONG_DESCRIPTION = 'long_description';
    const CHANNEL = 'channel';
    const OBJECT = 'object';
    const DAY = 'day';
    const HOUR = 'hour';
    const STATUS = 'status';
    const IMAGE = 'image';
    const MONTH = 'month';
    const REPEAT = 'repeat';
    const EVENT_DAY = 'event_day';

    //status
    const ACTIVE = 'active';
    const BLOCK = 'block';

    //object
    const ALL = '1';
    const NO_ACTIVE = '2';
    const ACTIVE_AND_INVESTMENT = '3';
    const ACTIVE_AND_NO_INVESTMENT = '4';
    const EXPIRE_AND_NO_INVESTMENT = '5';
    const BIRTHDAY = '6';

    //repeat
    const DAILY = '1';
    const WEEKLY = '2';
    const MONTHLY = '3';
    const ANNUAL = '4';

    //month
    const ONE_TIME_A_MONTH = '1';
    const TWO_TIMES_A_MONTH = '2';

    //day by month
    const DAY_ONE_BY_MONTH = 1;
    const SIXTEENTH_DAY_OF_THE_MONTH = 16;
}
