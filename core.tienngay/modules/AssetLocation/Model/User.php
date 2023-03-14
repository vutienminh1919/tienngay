<?php


namespace Modules\AssetLocation\Model;


class User extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    //column
    const EMAIL = 'email';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const PHONE_NUMBER = 'phone_number';
    const FULL_NAME = 'full_name';
    const IDENTIFY = 'identify';
    const STATUS = 'status';
    const TYPE = 'type';
    const TOKEN_WEB = 'token_web';
    const TOKEN_APP = 'token_app';

    //status
    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';

    protected $collection = 'user';
}
