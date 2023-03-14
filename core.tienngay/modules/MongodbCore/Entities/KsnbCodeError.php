<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class KsnbCodeError extends Model {
    protected $connection = "mongodb";

    protected $collection = "code_errors";

    protected $primarykey = "_id";

    public $timestamps = true;

    /**
     * Column name table
    */
    const COLUMN_ID = "_id";

    const COLUMN_CODE_ERROR = "code_error";//mã lỗi
    const COLUMN_DESCRIPTION = "description";
    const COLUMN_TYPE = "type";//nhóm vi phạm
    const COLUMN_TYPE_NAME = "type_name";//nhóm vi phạm
    const COLUMN_PUNISHMENT = "punishment";//chế tài phạt
    const COLUMN_PUNISHMENT_NAME = "punishment_name";//chế tài phạt
    const COLUMN_DISCIPLINE = "discipline";//hình thức kỷ luật
    const COLUMN_DISCIPLINE_NAME = "discipline_name";//hình thức kỷ luật
    const COLUMN_STATUS = 'status';
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_UPDATED_BY = "updated_by";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_QUOTE_DOCUMENT = "quote_document";
    const COLUMN_NO = "no";
    const COLUMN_SIGN_DAY = 'sign_day';


//protected $guarded = [];

    protected $fillable = [
        self::COLUMN_CODE_ERROR,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_TYPE,
        self::COLUMN_TYPE_NAME,
        self::COLUMN_PUNISHMENT,
        self::COLUMN_PUNISHMENT_NAME,
        self::COLUMN_DISCIPLINE,
        self::COLUMN_DISCIPLINE_NAME,
        self::COLUMN_STATUS,
        self::COLUMN_CREATED_BY,
        self::COLUMN_UPDATED_BY,
        self::COLUMN_UPDATED_AT,
        self::COLUMN_CREATED_AT,
        self::COLUMN_QUOTE_DOCUMENT,
        self::COLUMN_NO,
        self::COLUMN_SIGN_DAY,
    ];

    //status
    const COLUMN_BLOCK = 'block';
    const COLUMN_ACTIVE = 'active';

    //type
    const COLUMN_TYPE_ONE = '1';//Vi phạm nội quy công ty
    const COLUMN_TYPE_TWO = '2';//Vi phạm liên quan đến khách hàng
    const COLUMN_TYPE_THREE = '3';//Vi phạm liên quan đến hoạt động phòng giao dịch
    const COLUMN_TYPE_FOUR = '4';//Các vi phạm khác

    //discipline
    const COLUMN_DISCIPLINE_ONE = '1';//Khiển trách
    const COLUMN_DISCIPLINE_TWO = '2';//Kéo dài thời hạn tăng lương/Cách chức
    const COLUMN_DISCIPLINE_THREE = '3';//Kéo dài thời hạn tăng lương/Sa thải
    const COLUMN_DISCIPLINE_FOUR = '4';//Sa thải
    const COLUMN_DISCIPLINE_FIVE = '5';//Từng sự vụ

    //punishment
    const COLUMN_PUNISHMENT_ONE = '1';//10% kpi
    const COLUMN_PUNISHMENT_TWO = '2';//20% kpi
    const COLUMN_PUNISHMENT_THREE ='3';//30% kpi
    const COLUMN_PUNISHMENT_FOUR = '4';//Sa thải
    const COLUMN_PUNISHMENT_FIVE = '5';//Từng sự vụ

    public static function getTypeName($type) {
        $arr = [
            self::COLUMN_TYPE_ONE       => 'Vi phạm nội quy công ty',
            self::COLUMN_TYPE_TWO       => 'Vi phạm liên quan đến khách hàng',
            self::COLUMN_TYPE_THREE     => 'Vi phạm liên quan đến hoạt động phòng giao dịch',
            self::COLUMN_TYPE_FOUR      => 'Các vi phạm khác',
        ];
        if (isset($arr[$type])) {
            return $arr[$type];
        }
        return '';
    }

    public static function getPunishmentName($punishment)
    {
        $arr = [
            self::COLUMN_PUNISHMENT_ONE => '10%',
            self::COLUMN_PUNISHMENT_TWO => '20%',
            self::COLUMN_PUNISHMENT_THREE => '30%',
            self::COLUMN_PUNISHMENT_FOUR => 'Sa thải(Chờ họp hội đồng kỷ luật)',
            self::COLUMN_PUNISHMENT_FIVE => 'Từng sự vụ',
        ];
        if (isset($arr[$punishment])){
            return $arr[$punishment];
        }
        return '';
    }

    public static function getDisciplineName($discipline)
    {
        $arr = [
            self::COLUMN_DISCIPLINE_ONE => 'Khiển trách',
            self::COLUMN_DISCIPLINE_TWO => 'Kéo dài thời hạn tăng lương hoặc Cách chức',
            self::COLUMN_DISCIPLINE_THREE => 'Kéo dài thời hạn tăng lương hoặc Sa thải',
            self::COLUMN_DISCIPLINE_FOUR => 'Sa thải(Chờ họp hội đồng kỷ luật)',
            self::COLUMN_DISCIPLINE_FIVE => 'Từng sự vụ',
        ];
        if (isset($arr[$discipline])) {
            return $arr[$discipline];
        }
        return '';
    }



}

