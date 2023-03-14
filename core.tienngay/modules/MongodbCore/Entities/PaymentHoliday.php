<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class PaymentHoliday extends Model
{
    use SoftDeletes;
    protected $connection = "mongodb";

    protected $collection = "payment_holidays";

    protected $primarykey = "_id";

    protected $guarded = [];

    public $timestamps = false;

    const ID                    = '_id'; // primary key
    const NAME                  = 'name';
    const DESCRIPTION           = 'description';
    const START_DATE            = 'start_date';
    const END_DATE              = 'end_date';
    const STATUS                = 'status';
    const DELETED_AT            = 'deleted_at';
    const CREATED_BY            = 'created_by';
    const UPDATED_BY            = 'updated_by';
    const CREATED_AT            = 'created_at';
    const UPDATED_AT            = 'updated_at';

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;


    public static $statusAll = [
        self::STATUS_ENABLE,
        self::STATUS_DISABLE
    ];
    

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        self::STATUS => 'integer',
        self::CREATED_AT => 'integer',
        self::UPDATED_AT => 'integer',
        self::START_DATE => 'integer',
        self::END_DATE => 'integer'
    ];

    /**
     * handle event
     *
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->status = self::STATUS_ENABLE;
            $model->created_at = time();
            $model->updated_at = time();
        });
        static::updating(function ($model) {
            $model->updated_at = time();
        });
        static::deleting(function ($model) {
            $model->deleted_at = time();
        });
    }
}
