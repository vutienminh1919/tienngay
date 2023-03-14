<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class TradeOrder extends Model
{
    use SoftDeletes;

    protected $connection = "mongodb";

    protected $collection = "trade_order";

    protected $primarykey = "_id";

    protected $guarded = [];

    public $timestamps = false;

    const ID                    = '_id'; // primary key
    const STORE_ID              = 'store_id'; // id PGD
    const STORE_NAME            = 'store_name'; // tên PGD
    const STORE_CODE_AREA       = 'store_code_area'; // tên PGD
    const PLAN_NAME             = 'plan_name'; // tên kế hoạch
    const PLAN_FILE             = 'plan_file'; // file chi tiết kế hoạch
    const MOTIVATING_GOAL       = 'motivating_goal'; // mục tiêu thúc đẩy
    const STATUS                = 'status'; // trạng thái
    const STATUS_LABEL          = 'status_label'; // trạng thái
    const PROGRESS              = 'progress'; // tiến trình
    const ITEMS                 = 'items'; // danh sách các ấn phẩm
    const CATEGORY              = 'category'; // danh mục
    const IMPLEMENTATION_GOAL   = 'implementation_goal'; // mục tiêu triển khai
    const CEO_ACCEPTED_TIME     = 'ceo_accepted_time'; // thời gian CEO phê duyệt mua sắm.
    const ITEM_KEY              = 'key';
    const ITEM_ID               = 'item_id';
    const ITEM_CODE             = 'item_code';
    const ITEM_NAME             = 'item_name'; // tên ấn phẩm
    const ITEM_TYPE             = 'item_type'; // loại ấn phẩm
    const ITEM_SPECIFICATIONS   = 'item_specifications'; // quy cách đóng gói
    const ITEM_QUANTITY         = 'item_quantity'; // số lượng
    const ITEM_AREA             = 'item_area'; // khu vực triển khai
    const ITEM_TARGET_CUSTOMERS = 'item_target_customers'; // mục tiêu khách hàng
    const ITEM_PATH             = 'item_path'; // Ảnh sản phẩm
    const ITEM_EXPEC_PRICE      = 'item_expec_price'; // giá dự kiến
    const ITEM_RECEIVED_AMOUNT  = 'received_amount'; // số lượng nhập kho
    const LOGS                  = 'logs'; //lưu lịch sử
    const ACTION                = 'action'; //lưu lịch sử
    const ACTION_LABEL          = 'action_label'; //lưu lịch sử
    const DELETED_AT            = 'deleted_at'; // thời gian xoá
    const DELETED_REASON        = 'deleted_reason'; // lý do xoá
    const BUDGET_ESTIMATES      = 'budget_estimates'; // trạng thái thêm vào ngân sách dự toán
    const BUDGET_ESTIMATES_ID   = 'budget_estimates_id'; //  id
    const BUDGET_ESTIMATES_NAME = 'budget_estimates_name'; // ngân sách dự toán name
    const LOGS_ALLOTMENT        = 'logs_allotment'; // lịch sử phân bổ ấn phẩm
    const ALLOTMENT_IS_CONFIRMED  = 'isConfirmed'; // trạng thái nhập kho
    const ALLOTMENT_PATH        = 'path'; // trạng thái nhập kho
    const ALLOTMENT_QUANTITY    = 'quantity_import'; // Số lượng ấn phẩm được phân bổ
    const ALLOTMENT_NCC         = 'ncc'; // Nhà cung cấp
    const ALLOTMENT_ACTUAL_PRICE  = 'actual_price'; // Giá thực tế
    const AUTO_CLOSE_REQUEST    = 'auto_close_request'; //Thời gian tự động hoàn thành request 

    const CREATED_AT            = 'created_at';
    const CREATED_BY            = 'created_by';
    const UPDATED_AT            = 'updated_at';
    const UPDATED_BY            = 'updated_by';
    const CONFIRMED_AT          = 'confirmed_at';
    const CONFIRMED_BY          = 'confirmed_by';

    const ALLOTMENT_CONFIRMED   = 1; // Trạng thái đã nghiệm thu và nhập kho
    const STATUS_NEW            = 1; // trạng thái tạo mới
    const STATUS_APPROVED       = 2; // trạng thái đã duyệt
    const STATUS_WAIT_APPROVE   = 3; // trạng thái chờ duyệt
    const STATUS_RETURNED       = 4; // trạng thái đã trả về
    const STATUS_CANCLED        = 5; // trạng thái đã hủy
    const STATUS_SENT_APPROVE   = 6; // trạng thái gửi duyệt
    const STATUS_DONE           = 7; // hoàn tất

    const BUDGET_ESTIMATES_REMOVED = 1; // chưa thêm vào hoặc xoá bỏ ra khỏi dự toán ngân sách
    const BUDGET_ESTIMATES_ADDED = 2; // đã thêm vào dự toán ngân sách


    const PROGRESS_PGD_CREATE   = 1; // PGD tạo mới
    const PROGRESS_ASM          = 2; // ASM thao tác
    const PROGRESS_RSM          = 3; // RSM thao tác
    const PROGRESS_GDKD_MKT     = 4; // GDKD MKT thao tác
    const PROGRESS_CFO          = 5; // CFO thao tác
    const PROGRESS_CEO          = 6; // CEO thao tác
    const PROGRESS_HCNS_BUYING  = 7; // HCNS mua sắm
    const PROGRESS_PGD_ACCEPT   = 8; // PGD nghiệm thu


    const ACTION_CREATE             = 'action_create';
    const ACTION_UPDATE             = 'action_update';
    const ACTION_UPDATE_PROGRESS    = 'action_update_progress';
    const ACTION_DELETE             = 'action_delete';
    const ACTION_UPDATE_BUDGET_ESTIMATES = 'action_update_budget_estimates';
    const ACTION_ALLOTMENT_CONFIRMED = 'action_allotment_confirmed';

    const MOTIVATING_GOAL_OTO = 'DKOTO';
    const MOTIVATING_GOAL_XMAY = 'DKXM';
    const MOTIVATING_GOAL_OTHER = 'other';

    const CATEGORY_PUBLICATION = 'publication';
    const CATEGORY_ITEM = 'item';

    const IMPLEMENTATION_GOAL_DIRECT = 'direct';
    const IMPLEMENTATION_GOAL_INDIRECT = 'indirect';

    const SYSTEM = 'System';

    /**
     *  Progress list
     * */
    public static $progress = [
        self::PROGRESS_PGD_CREATE,
        self::PROGRESS_ASM,
        self::PROGRESS_RSM,
        self::PROGRESS_GDKD_MKT,
        self::PROGRESS_CFO,
        self::PROGRESS_CEO,
        self::PROGRESS_HCNS_BUYING,
        self::PROGRESS_PGD_ACCEPT
    ];

    /**
     *  Progress label
     * */
    public static $progressLabel = [
        self::PROGRESS_PGD_CREATE => "PGD",
        self::PROGRESS_ASM => "ASM",
        self::PROGRESS_RSM => "RSM",
        self::PROGRESS_GDKD_MKT => "GDKD và MKT",
        self::PROGRESS_CFO => "CFO",
        self::PROGRESS_CEO => "CEO",
        self::PROGRESS_HCNS_BUYING => "HCNS",
        self::PROGRESS_PGD_ACCEPT  => "PGD",
    ];

    /**
     *  status list
     * */
    public static $status = [
        self::STATUS_NEW,
        self::STATUS_APPROVED,
        self::STATUS_WAIT_APPROVE,
        self::STATUS_RETURNED,
        self::STATUS_CANCLED,
        self::STATUS_SENT_APPROVE,
        self::STATUS_DONE
    ];

    /**
     *  budget estimates status list
     * */
    public static $budget_estimates = [
        self::BUDGET_ESTIMATES_REMOVED,
        self::BUDGET_ESTIMATES_ADDED,
    ];

    /**
     *  budget estimates status label
     * */
    public static $budget_estimates_label = [
        self::BUDGET_ESTIMATES_REMOVED => 'Xoá khỏi dự toán ngân sách',
        self::BUDGET_ESTIMATES_ADDED => 'Thêm vào dự toán ngân sách',
    ];

    public static $statusAll = [
        self::STATUS_NEW => 'Mới',
        self::STATUS_WAIT_APPROVE => 'Chờ duyệt',
        self::STATUS_RETURNED => 'Trả về',
        self::STATUS_CANCLED => 'Huỷ',
        self::STATUS_DONE => 'Hoàn thành'
    ];

    /**
     *  motivating goals list
     * */
    public static $motivatingGoals = [
        self::MOTIVATING_GOAL_OTO => 'Đăng ký ôtô',
        self::MOTIVATING_GOAL_XMAY => 'Đăng ký xe máy',
        self::MOTIVATING_GOAL_OTHER => 'Khác'
    ];

    /**
     *  categories list
     * */
    public static $categories = [
        self::CATEGORY_PUBLICATION => 'Ấn phẩm',
        self::CATEGORY_ITEM => 'Vật phẩm'
    ];

    /**
     *  categories list value
     * */
    public static $categoriesValue = [
        self::CATEGORY_PUBLICATION,
        self::CATEGORY_ITEM
    ];

    /**
     *  implementation goals list
     * */
    public static $implementationGoals = [
        self::IMPLEMENTATION_GOAL_DIRECT => 'Trực tiếp',
        self::IMPLEMENTATION_GOAL_INDIRECT => 'Phủ nhận diện'
    ];

    /**
     *  implementation goals list value
     * */
    public static $implementationGoalsValue = [
        self::IMPLEMENTATION_GOAL_DIRECT,
        self::IMPLEMENTATION_GOAL_INDIRECT
    ];

    /**
     * get status label
     * @param $status int
     * @param $progress int
     * @return string
     * */
    public static function statusLabel($status, $progress) {

        $label = "";
        $progLabel = isset(self::$progressLabel[$progress]) ? self::$progressLabel[$progress] : "";
        switch ($status) {
            case self::STATUS_NEW:
                $label = $progLabel . " tạo mới";
                break;
            case self::STATUS_APPROVED:
                if ($progress == self::PROGRESS_HCNS_BUYING) {
                    $label = 'HCNS đã mua sắm';
                } else {
                    $label = $progLabel . " đã duyệt";
                }
                break;
            case self::STATUS_WAIT_APPROVE:
                if ($progress == self::PROGRESS_HCNS_BUYING) {
                    $label = 'Chờ HCNS mua sắm';
                } else {
                    $label = "Chờ " . $progLabel . ' duyệt';
                }
                break;
            case self::STATUS_RETURNED:
                $label = $progLabel. " trả về";
                break;
            case self::STATUS_CANCLED:
                $label = $progLabel . " đã huỷ";
                break;
            case self::STATUS_SENT_APPROVE:
                if ($progress !== self::PROGRESS_PGD_CREATE) {
                    $progress = $progress - 1;
                    $progLabel = isset(self::$progressLabel[$progress]) ? self::$progressLabel[$progress] : "";
                }
                $label = $progLabel . " gửi duyệt";
                break;
            case self::STATUS_DONE:
                $label = "Hoàn thành";
                break;
        }

        return $label;
    }

    /**
     * get next step
     * @param $status int
     * @param $progress int
     * @return [status, progress] array
     * */
    public static function getNextStep($status, $progress) {
        $nextStatus = 0;
        $nextProgress = 0;
        switch ($status) {
            case self::STATUS_NEW:
                $nextStatus = self::STATUS_NEW;
                $nextProgress = self::PROGRESS_PGD_CREATE;
                break;
            case self::STATUS_APPROVED:
                $nextStatus = self::STATUS_WAIT_APPROVE; // chờ gửi duyệt
                $nextProgress = $progress + 1;
                break;
            case self::STATUS_WAIT_APPROVE:
                $nextStatus = self::STATUS_WAIT_APPROVE;
                $nextProgress = $progress;
                break;
            case self::STATUS_RETURNED:
                $nextStatus = self::STATUS_RETURNED;
                $nextProgress = $progress;
                break;
            case self::STATUS_CANCLED:
                $nextStatus = self::STATUS_CANCLED;
                $nextProgress = $progress;
                break;
            case self::STATUS_SENT_APPROVE:
                $nextStatus = self::STATUS_WAIT_APPROVE;
                if ($progress == self::PROGRESS_PGD_CREATE) {
                    $nextProgress = $progress + 1;
                } else {
                    $nextProgress = $progress;
                }
                break;
        }
        if ($nextProgress > self::PROGRESS_PGD_ACCEPT) {
            return ['status' => $status, 'progress' => $progress];
        }

        return ['status' => $nextStatus, 'progress' => $nextProgress];
    }

    /**
     * get status label
     * @param $status int
     * @param $progress int
     * @return string
     * */
    public static function actionLabel($action) {

        $label = "";
        switch ($action) {
            case self::ACTION_CREATE:
                $label = "Tạo mới";
                break;
            case self::ACTION_UPDATE_PROGRESS:
                $label = "Update tiến trình";
                break;
            case self::ACTION_UPDATE:
                $label = "Cập nhật";
                break;
            case self::ACTION_DELETE:
                $label = "Xoá";
                break;
            case self::ACTION_UPDATE_BUDGET_ESTIMATES:
                $label = 'Cập nhật dự toán ngân sách';
                break;
            case self::ACTION_ALLOTMENT_CONFIRMED:
                $label = 'Nhập kho ấn phẩm';
                break;
        }

        return $label;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        self::STATUS => 'integer',
        self::PROGRESS => 'integer',
        self::CREATED_AT => 'integer',
        self::UPDATED_AT => 'integer'
    ];

    /**
     * handle event
     *
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->status = self::STATUS_NEW;
            $model->progress = self::PROGRESS_PGD_CREATE;
            $model->budget_estimates = self::BUDGET_ESTIMATES_REMOVED;
            $model->created_at = time();
            $model->updated_at = time();
            $model->ceo_accepted_time = 0;
        });
        static::updating(function ($model) {
            $model->updated_at = time();
        });
        static::deleting(function ($model) {
            $model->deleted_at = time();
        });
    }
}
