<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Banner extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'banner';
    protected $guarded = [];

//    protected $fillable = ['_id', 'page', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    /**
     * initial constants
     */
    const COLUMN_ID = "_id";
    const COLUMN_PAGE = "page";
    const COLUMN_STATUS = "status";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_UPDATED_BY = "updated_by";

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';

    /**
     * end initial constants
     */
}
