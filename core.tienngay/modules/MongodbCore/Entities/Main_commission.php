<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class Main_commission extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'main_commission';

    protected $guarded = [];

    public $timestamps = FALSE;

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'deactivate';
    /**
     * Column name table
     */

    const COLUMN_ID = "_id";
    const COLUMN_NAME = "name";
    const COLUMN_CODE = "code";
    const COLUMN_STATUS = "status";
    const COLUMN_PARENT_ID = "parent_id";
    const COLUMN_PROPERTIES = "properties";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_CREATED_BY = "created_by";

}
