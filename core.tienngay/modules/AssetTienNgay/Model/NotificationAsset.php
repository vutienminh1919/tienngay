<?php


namespace Modules\AssetTienNgay\Model;


class NotificationAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const USER_ID = 'user_id';
    const MESSAGE = 'message';
    const STATUS = 'status';
    const ACTION = 'action';
    const LINK = 'link';
    const NOTE = 'note';
    const SUPPLIES_ID = 'supplies_id';
    const TITLE = 'title';

    //trang thai doc
    const UNREAD = 1;
    const READ = 2;

    //action
    const CREATE = 1;
    const UPDATE = 2;
    const ERROR = 3;
    const ASSIGN = 4;
    const STORAGE = 5;
    const CHANGE = 6;
    const SEND = 7;
    const BROKEN = 8;

    protected $collection = 'notification_asset';
}
