<?php


namespace Modules\AssetLocation\Model;


class District extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'district';
    public $timestamps = FALSE;
}
