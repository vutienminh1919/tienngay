<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class Qlpublications extends Model
{
    protected $connection = "mongodb";

    protected $collection = "qlpublications";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID = "_id";

    //thông tin chung
    const COLUMN_SUPPLIER = 'supplier';//nhà cung cấp ấn phẩm
    const COLUMN_OTHER_COTS = 'other_costs';//chi phí khác
    const COLUMN_DATE_ACCEPTANCE = 'date_acceptance';//ngày nghiệm thu dự kiến

    //thông tin ấn phẩm
    const COLUMN_ITEM_ID = 'item_id';//mã ấn phẩm
    const COLUMN_TOTAL = 'total';//số lượng ấn phẩm
    const COLUMN_IMAGE_DETAIL = 'image_detail';//ảnh mô tả ấn phẩm

    //mô tả ấn phẩm
    const COLUMN_NAME_PUBLICATIONS = 'name_publications';//tên ấn phẩm
    const COLUMN_TECH = 'tech';//quy cách ấn phẩm
    const COLUMN_MATERIAL = 'material';//quy cách ấn phẩm
    const COLUMN_SIZE = 'size';//quy cách ấn phẩm
    const COLUMN_TYPE = 'type';//loại ấn phẩm
    const COLUMN_MONEY_PUBLICATIONS = 'money_publications';//đơn giá thực tế
    const COLUMN_SPECIFICATION = 'specification';//quy cách chung
    const COLUMN_MONEY_TOTAL = 'money_total';//Tổng chi phis
    const COLUMN_PRICE = 'price';//giá dự kiến


    const COLUMN_LEAD_PUBLICATIONS = 'lead_publications';//danh sách ấn phẩm
    const COLUMN_KEY_ID = 'key_id';
    const COLUMN_STATUS = 'status';
    const COLUMN_TOTAL_ACCEPTANCE = 'total_acceptance';//số lượng nghiệm thu
    const COLUMN_LOG = 'log';//log
    const COLUMN_NOTE = 'note';//ghi chú
    const COLUMN_DESCRIPTION = 'description';//mô tả ghi chú
    const COLUMN_NOTE_PUBLICATIONS = 'note_description';//lead ghi chú
    const COLUMN_DATE_ORDER = 'date_order';//ngày đặt hàng
    const COLUMN_DATE_ACCEPTANCE_COMPLETE = 'date_acceptance_complete';//ngày nghiệm thu hoàn thành
    const COLUMN_DESCRIPTION_PUBLICATIONS = 'description_publications';//Mô tả ghi chú của từng phiếu mua hàng
    const COLUMN_TITLE_NOTE_PUBLICATIONS = 'title_note_publications';//tiêu đề ghi của từng phiếu mua hàng
    const COLUMN_LEAD_NOTE = 'lead_note';//Danh sách ghi chú của từng phiếu đặt ấn phẩm
    const COLUMN_SUM_ITEM_ID = 'sum_item_id';//Số loại ấn phấm được yêu cầu
    const COLUMN_SUM_MONEY_PUBLICATIONS = 'sum_money_publications';//Tổng chi phí thực thế của tất cả ấn phẩm
    const COLUMN_SUM_TOTAL = 'sum_total';//Tổng số lượng ấn phẩm
    const COLUMN_TOTAL_CLONE = 'total_clone';// dữ số lượng ấn phẩm ban đầu
    const COLUMN_ID_PUBLICATION = 'id_publication';// id của từng ấn phẩm
    const COLUMN_TOTAL_ALLOTMENT = 'total_allotment';// số lượng đã nghiệm thu
    const COLUMN_TOTAL_QUANTITY_TESTED = 'total_quantity_tested';// số lượng có thể phân bổ



    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';

    const STATUS_NEW = 1;//new , trạng thái mới
    const STATUS_ORDERED = 2;//ordered , đã đặt hàng
    const STATUS_ACCEPTANCE = 3;//acceptance ,chờ mkt nghiệm thu
    const STATUS_ACCEPTANCE_END = 4;//đang nghiệm thu
    const STATUS_COMPLETE = 5;//complete ,nghiệm thu hoàn thành
    const STATUS_BLOCK = 6;//xóa mềm


    protected $casts = [
        self::CREATED_AT => 'integer',
        self::UPDATED_AT => 'integer',
        self::COLUMN_TOTAL_ACCEPTANCE => 'integer',
        self::COLUMN_TOTAL => 'integer'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = time();
            $model->updated_at = time();
            $model->total = "";
            $model->total_acceptance = "";
        });
        static::updating(function ($model) {
            $model->updated_at = time();
        });
    }

}
