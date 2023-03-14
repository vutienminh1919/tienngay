<?php


namespace Modules\AssetLocation\Model;


class Role extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'role';
    public $timestamps = FALSE;

    const BLOCK_EMAIL_TLS = ['ngochtm@tienngay.vn', 'loanntp@tienngay.vn'];
}
