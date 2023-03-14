<?php


namespace Modules\AssetLocation\Model;


class Account_vset extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'account_vset';
    public $timestamps = FALSE;

    //column
    const ACCESS_TOKEN = 'access_token';
    const APP_ID = 'app_id';
    const KEY = 'key';
}
