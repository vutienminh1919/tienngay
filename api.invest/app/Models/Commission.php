<?php


namespace App\Models;


class Commission extends BaseModel
{
    //column
    const NAME = 'name';
    const SLUG = 'slug';
    const MIN = 'min';
    const MAX = 'max';
    const COMMISSION = 'commission';
    const STATUS = 'status';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const TYPE_REFERRAL = 'type_referral';
    const VERSION = 'version';

    //status
    const ACTIVE = 'active';
    const BLOCK = 'block';

    //type
    const APP = 'app';
    const CVKD = 'cvkd';

    //version
    const V1 = 1;
    const V2 = 2;

    protected $table = 'commission';
}
