<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class Commission_setup extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'commission_setup';

    protected $guarded = [];

    public $timestamps = FALSE;

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'deactivate';
    /**
     * Column name table
     */

    const COLUMN_ID = "_id";
    const COLUMN_PRODUCT_TYPE = "product_type";
    const COLUMN_PRODUCT_TYPE_ID = "product_type.id";
    const COLUMN_TITLE_COMMISSION = "title_commission";
    const COLUMN_GROUP_CTV = "group_ctv";
    const COLUMN_APPLICATION_CTV_INDIVIDUAL = "application_ctv_individual";
    const COLUMN_START_DATE = "start_date";
    const COLUMN_END_DATE = "end_date";
    const COLUMN_NOTE_COMMISSION = "note_commission";
    const COLUMN_PRODUCT_LIST = "product_list";
    const COLUMN_STATUS = "status";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_CREATED_BY = "created_by";
}
