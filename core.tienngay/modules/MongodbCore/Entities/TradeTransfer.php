<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TradeTransfer extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'trade_transfer';

    protected $primarykey = "_id";

    public $timestamps = false;

    /**
     * Column name table
     */
    const ID = "_id";
    const STORES_ID = "id";
    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_BY = 'updated_by';
    const UPDATED_AT = 'updated_at';
    const STATUS     = 'status'; // trạng thái
    const TYPE_CATEGORY     = 'type_category'; //hạng mục
    const AMOUNT        = 'amount'; // số lượng
    const CATEGORY      = 'category'; // loại ấn phẩm
    const TAGET      = 'taget'; // mục tiêu triển khai
    const NAME          = 'name'; // tên ấn phẩm
    const SPECIFICATION = 'specification'; //quy cách
    const URL           = 'url'; //ảnh ấn phẩm
    const NOTE          = 'note'; //ghi chú
    const STORES          = 'stores'; //pgd
    const STORES_EXPORT          = 'stores_export';
    const STORES_IMPORT          = 'stores_import';
    const LIST           = 'list'; //ds ấn phẩm
    const LICENSE               = 'license'; //Chứng từ
    const TOTAL_ITEMS = 'total_items';
    const TOTAL_AMOUNT = 'total_amount';
    const REQUESTED_AT = 'requested_at';
    const DATE_EXPORT = 'date_export';
    const DATE_IMPORT = 'date_import';
    const LICENSE_EXPORT  = 'license_export'; //Chứng từ xuất
    const LICENSE_IMPORT  = 'license_import'; //Chứng từ nhận
    const REASON_CANCEL  = 'reason_cancel'; //Lý do hủy
    const DELETE = 'delete';
    const EXPORT_BY = 'export_by';
    const IMPORT_BY = 'import_by';
    const LOGS = "logs";

    const STATUS_NEW = 1;
    const STATUS_WAIT_EXPORT = 2;
    const STATUS_WAIT_IMPORT = 3;
    const STATUS_CANCEL = 4;
    const STATUS_COMPLETE= 5;

    const DELETED = 'deleted';

    protected $guarded = [];

    public static $status = [
        self::STATUS_NEW => 'Mới',
        self::STATUS_WAIT_EXPORT => 'Chờ xuất',
        self::STATUS_WAIT_IMPORT => 'Chờ nhận',
        self::STATUS_CANCEL => 'Hủy',
        self::STATUS_COMPLETE => 'Hoàn thành',
    ];
}
