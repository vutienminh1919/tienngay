<?php


namespace Modules\AssetLocation\Model;


use Jenssegers\Mongodb\Eloquent\Model;

abstract class BaseMongoModel extends Model
{
    const ID = '_id';
    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
    }
}
