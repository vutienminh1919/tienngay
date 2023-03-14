<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class MultiQr extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'multi_qr';

    protected $fillable = ['request_id', 'ios', 'android', 'other', 'created_at', 'deleted_at'];

    public $timestamps = false;

    /**
     * initial constants
     */
    const ID                    = '_id';
    const REQUEST_ID            = 'request_id';
    const IOS                   = 'ios';
    const ANDROID               = 'android';
    const OTHER                 = 'other';
    const CREATED_AT            = 'created_at';
    const DELETED_AT            = 'deleted_at';
}
