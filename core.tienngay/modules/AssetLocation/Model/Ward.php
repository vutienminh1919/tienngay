<?php


namespace Modules\AssetLocation\Model;


class Ward extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'ward';
    public $timestamps = FALSE;
}
