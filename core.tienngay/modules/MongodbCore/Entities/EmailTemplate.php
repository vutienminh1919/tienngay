<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'email_template';

    protected $primarykey = "_id";

    public $timestamps = false;

    const ID = '_id';
    const CODE = 'code';
    const CODE_NAME = 'code_name';
    const FROM = 'from';
    const FROM_NAME = 'from_name';
    const SUBJECT = 'subject';
    const MESSAGE = 'message';
    const STATUS = 'status';
    const TYPE = 'type';
    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const FLAG = 'flag';
    const STORE = 'store';
    const STORE_NAME = 'store_name';
    const UPDATED_BY = 'updated_by';
    const UPDATED_AT = 'updated_at';
    const SLUG = 'slug';

    protected $guarded = [];

    const STATUS_ACTIVE = 'active';
    const TYPE_NEW = '1';
    const FLAG_MKT = 'marketting';
    const FLAG_CSKH = 'cskh';
    const FLAG_NĐT = 'ndt';
    const MKT = 4;
    const CSKH = 5;
    const NDT = 6;
}
