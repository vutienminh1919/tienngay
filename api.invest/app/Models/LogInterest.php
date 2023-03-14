<?php


namespace App\Models;


class LogInterest extends BaseModel
{
    const COLUMN_OLD = 'old';
    const COLUMN_NEW = 'new';
    const COLUMN_TYPE = 'type';

    const TYPE_CREATE = 'create';
    const TYPE_UPDATE = 'update';
    const TYPE_ACTIVE = 'active';

    protected $table = 'log_interest';
}
