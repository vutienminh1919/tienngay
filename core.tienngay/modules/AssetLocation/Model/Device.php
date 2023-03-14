<?php


namespace Modules\AssetLocation\Model;


class Device extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'device_asset_location';
    public $timestamps = FALSE;

    //column
    const NAME = 'name';
    const CODE = 'code';
    const STATUS = 'status';
    const STATUS_LOCATION = 'status_location';
    const STATUS_ALARM = 'status_alarm';
    const PURCHASE_DATE = 'purchase_date';
    const IMPORT_PRICE = 'import_price';
    const STOCK_PRICE = 'stock_price';
    const INSTALLATION_FEES = 'installation_fees';
    const SIM_CARD_FEES = 'sim_card_fee';
    const NUMBER_SIM_CARD = 'number_sim_card';
    const SERVICE_FEES = 'service_fees';
    const WARRANTY_PERIOD = 'warranty_period';
    const WARRANTY_EXPIRATION_DATE = 'warranty_expiration_date';
    const FILE = 'file';
    const STORAGE_DATE = 'storage_date';
    const DATA_STATUS_LOCATION = 'data_status_location';
    const DATA_ALARM = 'data_alarm';
    const WAREHOUSE_ASSET_LOCATION = 'warehouse_asset_location';
    const WAREHOUSE_ASSET_LOCATION_ID = 'warehouse_asset_location.id';
    const WAREHOUSE_ASSET_LOCATION_NAME = 'warehouse_asset_location.name';
    const PARTNER_ASSET_LOCATION = 'partner_asset_location';
    const PARTNER_ASSET_LOCATION_ID = 'partner_asset_location.id';
    const PARTNER_ASSET_LOCATION_NAME = 'partner_asset_location.name';
    const EXPORT_DATE = 'export_date';
    const TRANSFER = 'transfer';
    const EXPORT_DATE_STATUS_NEW = 'export_date_status_new';
    const PRICE_EXPORT_DATE_STATUS_NEW = 'price_export_date_status_new';
    const SECONDHAND = 'secondhand';  //hinh thuc cũ hay mới

    //status
    const NEW = 1;
    const OLD = 2;
    const ACTIVE = 3;
    const RECALL = 4;
    const NOT_RECALL = 5;
    const BROKEN = 6;

    //status location
    const LOCATION_STATIC = 1;
    const LOCATION_MOVE = 2;
    const LOCATION_OFFLINE = 3;
    const LOCATION_INACTIVE = 4;
    const LOCATION_SLEEP = 5;

    //alarm
    const ALARM_REMOVE = 1;   //giả mạo, báo động đèn, tắt xăng
    const ALARM_LOWVOT = 2;   //Pin yếu
    const ALARM_ERYA = 3;
    const ALARM_FENCEIN = 4;  //trong hàng rào
    const ALARM_FENCEOUT = 5;//Ngoài hàng rào
    const ALARM_SEP = 6;
    const ALARM_SOS = 7;     //sos
    const ALARM_OVERSPEED = 8;   //Báo động quá tốc độ
    const ALARM_HOME = 9;       //Permanent residence irregular(Home)
    const ALARM_COMPANY = 10;      //Permanent residence irregular(Company)
    const ALARM_SHAKE = 11;
    const ALARM_STAYTIMEOUT = 12;
    const ALARM_AREAOUT = 13;
    const ALARM_AREAIN = 14;
    const ALARM_ACCOFF = 15;
    const ALARM_ACCON = 16;
    const ALARM_REMOVECONTINUOUSLY = 17;
    const ALARM_ABNORMALACCUMULATION = 18;
    const ALARM_VINMISMATCH = 19;
    const ALARM_TURNOVER = 20;
    const ALARM_CRASH = 21;
    const ALARM_SHARPTURN = 22;
    const ALARM_FASTACCELERATION = 23;
    const ALARM_FASTDECELERATION = 24;
    const ALARM_SHIFT = 25;

}
