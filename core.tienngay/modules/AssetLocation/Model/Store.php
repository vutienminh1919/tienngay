<?php


namespace Modules\AssetLocation\Model;


class Store extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'store';
    public $timestamps = FALSE;
}
