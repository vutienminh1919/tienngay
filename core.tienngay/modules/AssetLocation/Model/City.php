<?php


namespace Modules\AssetLocation\Model;


class City extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'province';
    public $timestamps = FALSE;
}
