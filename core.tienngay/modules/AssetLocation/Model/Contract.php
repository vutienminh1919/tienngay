<?php


namespace Modules\AssetLocation\Model;


class Contract extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'contract';
    public $timestamps = FALSE;

    //column
    const STATUS = 'status';
    const DEVICE_ASSET_LOCATION_STATUS = 'device_asset_location_status';
    const STORE_ID = 'store.id';
    const CODE_CONTRACT = 'code_contract';
    const CODE_CONTRACT_DISBURSEMENT = 'code_contract_disbursement';
    const CUSTOMER_INFOR_NAME = 'customer_infor.customer_name';
    const PROPERTY_INFOR_LICENSE = 'property_infor.2.value';
    const DISBURSEMENT_DATE = 'disbursement_date';
    const LOAN_INFOR_PRODUCT_CODE = 'loan_infor.loan_product.code';
    const LOAN_INFOR_DEVICE_LOCATION_CODE = 'loan_infor.device_asset_location.code';
    const LOAN_INFOR_DEVICE_LOCATION_ID = 'loan_infor.device_asset_location.device_asset_location_id';
    const LOAN_INFOR_DEVICE_LOCATION_STATUS = 'loan_infor.device_asset_location.status_location';
    const DEBT_LATE_PAYMENT = 'debt.so_ngay_cham_tra';
    const EXPIRE_DATE = 'expire_date';
    const DEVICE_ASSET_LOCATION_STATUS_RECALL = 'device_asset_location_status_recall';
    const DEVICE_ASSET_LOCATION_ALARM = 'device_asset_location_alarm';

    //san pham vay
    const VAY_GAN_DINH_VI = '19';
    const VAY_CAVET_OTO = '7';

    //status dang vay
    const DANG_VAY = [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42];

    //status all status sau giai ngân
    const SAU_GIAI_NGAN = [11, 12, 13, 14, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42];

    const DA_TAT_TOAN = 19;
    const DA_GIAI_NGAN = 17;
}
