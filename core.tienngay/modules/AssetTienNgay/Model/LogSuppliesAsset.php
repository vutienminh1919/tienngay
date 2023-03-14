<?php


namespace Modules\AssetTienNgay\Model;


class LogSuppliesAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const OLD = 'old';
    const OLD_STATUS = 'old_status';
    const NEW = 'new';
    const NEW_STATUS = 'new_status';
    const TYPE = 'type';
    const SUPPLIES_ID = 'supplies_id';
    const NOTE = 'note';
    const USER_RECEIVE = 'user_receive';
    const DELIVERY_DATE = 'delivery_date';  //ngày bàn giao
    const DATE_STORAGE = 'date_storage';  //ngày lưu kho
    const IMAGE_DESCRIPTION = 'image_description';
    const INVENTORY_DATE = 'inventory_date';  //ngày kiểm kê
    const DATE_STATUS_RECEIVE = 'date_status_receive'; // ngay nhan thiet bi

    //type
    const CREATE = 1;
    const UPDATE = 2;
    const ERROR = 3;
    const ASSIGN = 4;
    const STORAGE = 5;
    const CHANGE = 6;
    const SEND = 7;
    const BROKEN = 8;
    const ACCEPT = 9;
    const INVENTORY = 10;
    const VERIFIED = 11;
    const CONFIRM = 12;
    const IMPORT = 13;
    const OFFICE_CONFIRM = 14;
    const SWITCH_STATUS = 15;
    protected $collection = 'log_supplies_asset';
}
