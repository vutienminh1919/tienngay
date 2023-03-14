<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class TradeBudgetEstimates extends Model
{
    use SoftDeletes;

    protected $connection = "mongodb";

    protected $collection = "trade_budget_estimates";

    protected $primarykey = "_id";

    protected $guarded = [];

    public $timestamps = false;

    const ID                    = '_id'; // primary key
    const NAME                  = 'name'; // id PGD
    const DATE                  = 'date'; // Ngày dự toán ngân sách (lấy ngày CFO duyệt)
    const STATUS                = 'status'; // trạng thái
    const CUSTOMER_GOAL         = 'customer_goal'; // mục tiêu khách hàng
    const IS_CCO_ACCEPT         = 'isCCOAccept'; // CCO đồng thuận
    const IS_MKT_ACCEPT         = 'isMKTAccept'; // MKT đồng thuận
    const STATUS_LABEL          = 'status_label'; // trạng thái
    
    const PROGRESS              = 'progress'; // tiến trình
    
    const LOGS                  = 'logs'; //lưu lịch sử
    const ACTION                = 'action'; //lưu lịch sử
    const ACTION_LABEL          = 'action_label'; //lưu lịch sử
    const RETURN_NOTE           = 'return_note'; // Lý do trả về
    const DELETED_AT            = 'deleted_at'; // thời gian xoá
    const DELETED_REASON        = 'deleted_reason'; // lý do xoá

    const CREATED_AT            = 'created_at';
    const CREATED_BY            = 'created_by';
    const UPDATED_AT            = 'updated_at';
    const UPDATED_BY            = 'updated_by';

    const STATUS_NEW            = 1; // trạng thái tạo mới
    const STATUS_APPROVED       = 2; // trạng thái đã duyệt
    const STATUS_WAIT_APPROVE   = 3; // trạng thái chờ duyệt
    const STATUS_RETURNED       = 4; // trạng thái đã trả về
    const STATUS_CANCLED        = 5; // trạng thái đã hủy
    const STATUS_SENT_APPROVE   = 6; // trạng thái gửi duyệt
    const STATUS_DONE           = 7; // hoàn tất

    const IS_CCO_ACCEPT_OK      = 1; //CCO đồng thuận
    const IS_CCO_ACCEPT_NO      = 0; //CCO không đồng thuận hoặc chưa đồng thuận

    const IS_MKT_ACCEPT_OK      = 1; //MKT đồng thuận
    const IS_MKT_ACCEPT_NO      = 0; //MKT không đồng thuận hoặc chưa đồng thuận
    

    const PROGRESS_CREATE_NEW   = 1; // tạo mới
    const PROGRESS_GDKD_MKT     = 4; // GDKD MKT thao tác
    const PROGRESS_CFO          = 5; // CFO thao tác
    const PROGRESS_CEO          = 6; // CEO thao tác


    const ACTION_CREATE             = 'action_create';
    const ACTION_UPDATE             = 'action_update';
    const ACTION_UPDATE_PROGRESS    = 'action_update_progress';
    const ACTION_DELETE             = 'action_delete';
    const ACTION_UPDATE_CUSTOMER_GOAL = 'action_update_customer_goal';
    const ACTION_UPDATE_BUDGET_ESTIMATES = 'action_update_budget_estimates';
    const ACTION_ADD_COMMENT = 'action_add_comment';
    const ACTION_CCO_ACCEPT    = 'action_cco_accept';
    const ACTION_MKT_ACCEPT    = 'action_mkt_accept';


    /**
     *  Progress list
     * */
    public static $progress = [
        self::PROGRESS_CREATE_NEW,
        self::PROGRESS_GDKD_MKT,
        self::PROGRESS_CFO,
        self::PROGRESS_CEO
    ];

    /**
     *  Progress label
     * */
    public static $progressLabel = [
        self::PROGRESS_CREATE_NEW => "",
        self::PROGRESS_GDKD_MKT => "GDKD và MKT",
        self::PROGRESS_CFO => "CFO",
        self::PROGRESS_CEO => "CEO"
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

    public static $statusAll = [
        self::STATUS_NEW => 'Mới',
        self::STATUS_WAIT_APPROVE => 'Chờ duyệt',
        self::STATUS_RETURNED => 'Trả về',
        self::STATUS_CANCLED => 'Huỷ',
        self::STATUS_DONE => 'Hoàn thành'
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
                $label = "Tạo mới";
                break;
            case self::STATUS_APPROVED:
                $label = $progLabel . " đã duyệt";
                break;
            case self::STATUS_WAIT_APPROVE:
                $label = "Chờ " . $progLabel . ' duyệt';
                break;
            case self::STATUS_RETURNED:
                $label = "Trả về";
                break;
            case self::STATUS_CANCLED:
                $label = "Đã huỷ";
                break;
            case self::STATUS_SENT_APPROVE:
                if ($progress !== self::PROGRESS_CREATE_NEW) {
                    $progress = $progress - 1;
                    $progLabel = isset(self::$progressLabel[$progress]) ? self::$progressLabel[$progress] : "";
                }
                $label = $progLabel . " gửi duyệt";
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
                $nextProgress = self::PROGRESS_CREATE_NEW;
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
                $nextProgress = self::PROGRESS_CREATE_NEW;
                break;
            case self::STATUS_CANCLED:
                $nextStatus = self::STATUS_CANCLED;
                $nextProgress = $progress;
                break;
            case self::STATUS_SENT_APPROVE:
                $nextStatus = self::STATUS_WAIT_APPROVE;
                if ($progress == self::PROGRESS_CREATE_NEW) {
                    $nextProgress = self::PROGRESS_GDKD_MKT;
                } else {
                    $nextProgress = $progress;
                }
                break;
        }
        if ($nextProgress > self::PROGRESS_CEO) {
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
            case self::ACTION_UPDATE_CUSTOMER_GOAL:
                $label = 'Cập nhật khách hàng mục tiêu';
                break;
            case self::ACTION_ADD_COMMENT:
                $label = 'Thêm ghi chú';
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
            $model->progress = self::PROGRESS_CREATE_NEW;
            $model->date = null;
            $model->customer_goal = "";
            $model->created_at = time();
            $model->updated_at = time();
            $model->isMKTAccept = self::IS_MKT_ACCEPT_NO;
            $model->isCCOAccept = self::IS_CCO_ACCEPT_NO;
        });
        static::updating(function ($model) {
            $model->updated_at = time();
        });
        static::deleting(function ($model) {
            $model->deleted_at = time();
        });
    }
}
