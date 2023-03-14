<?php


namespace Modules\AssetTienNgay\Model;


use Jenssegers\Mongodb\Eloquent\Model;

abstract class BaseModel extends Model
{
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
