<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportLogTransaction extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report_log_transactions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const ID                    = "id";
    const CREATED_AT            = "created_at";
    const UPDATED_AT            = "updated_at";
    const DELETED_AT            = "deleted_at";
    const REQUEST_ID            = "request_id";
    const REQUEST_BY            = "request_by";
    const REQUEST_TIME          = "request_time";
    const APPROVE_BY            = "approve_by";
    const APPROVE_TIME          = "approve_time";
    const ACTION_NAME           = "action_name";
    const APPROVE_NOTE          = "approve_note";
    const APPROVE_COUNT         = "approve_count";
    const TRANCODE              = "trancode";
    const CONTRACT_CODE         = "contract_code";
    const CODE_CONTRACT_DISBURSEMENT = "code_contract_disbursement";
    const AMOUNT                = "amount";
    const STORE_ID              = "store_id";
    const STORE_NAME            = "store_name";
    const CUSTOMER_NAME         = "customer_name";
    const ACTION_DUYET_TIME     = "action_duyet_time";
    const ACTION_TRA_VE_TIME    = "action_tra_ve_time";
    const ACTION_HUY_TIME       = "action_huy_time";
    const REQUEST_BEFORE_16H    = "request_before_16h";
    const REQUEST_AFTER_16H     = "request_after_16h";
    const APPROVE_BEFORE_17H30  = "approve_before_17h30";
    const APPROVE_AFTER_17H30   = "approve_after_17h30";
    const FIRST_CLICK_TIME      = "first_click_time";

    const APPROVE_HOUR          = "approve_hour";
    const APPROVE_MINUTE        = "approve_minute";
    const APPROVE_DAY_OF_WEEK   = "approve_day_of_week";
    const PROCESS_MINUTES_TIME  = "process_minutes_time";
    const PROCESS_HOUR_TIME     = "process_hour_time"; // Thời gian chờ xử lý phiếu thu
    const APPROVE_OVER_TIME     = "approve_over_time"; // Thời gian kế toán duyệt quá khung giờ xử lý (phút)

    const TYPE                  = "type";
    const TYPE_PAYMENT          = "type_payment";
    const PAYMENT_METHOD        = "payment_method";
    const TRANSACTION_TYPE      = "transaction_type";
    const BANK_DATE             = "bank_date";
    const PAID_DATE             = "paid_date";
    const FIRST_REQUEST_TIME    = "first_request_time";
    const RESEND_REQUEST_TIME   = "resend_request_time"; // Thời gian PGD xử lý sau khi kế toán trả về
    const TOTAL_DEDUCTIBLE      = "total_deductible";
    const REQUEST_DAY_OF_WEEK   = "request_day_of_week";
    const REQUIRE_NOTE          = "approve_require_note"; //Lý do huỷ hoặc trả về
    const CANCEL_NOTE           = "cancel"; //Lý do huỷ
    const RETURN_NOTE           = "return"; //Lý do trả về


    const ACTION_GUI_DUYET      = "gui_kt_duyet";
    const ACTION_TRA_VE         = "tra_ve";
    const ACTION_DUYET          = "duyet_giao_dich";
    const ACTION_HUY            = "huy_giao_dich";

    const STATUS_WAITING        = "Chờ xử lý";
    const STATUS_PROGRESSING    = "Đang xử lý";
    const STATUS_DONE           = "Đã xử lý";



    const TYPE_PAYMENT_GH = 2; // phieu thu gia han
    const TYPE_PAYMENT_CC = 3; // phieu thu gia han
    const TYPE_PAYMENT_NORMAL = 1; // phieu thu bình thường
    const TYPE_PAYMENT_TLTS = 4; // phieu thu thanh lý tài sản
    const TYPE_TAT_TOAN = 3; // phieu thu tất toán
    const TYPE_THANH_TOAN = 4; // phieu thu thanh toán
    const TYPE_HEYU = 7; // phieu thu thanh toán

    const LOAI_THANH_TOAN_GH = 'Gia hạn';
    const LOAI_THANH_TOAN_CC = 'Cơ cấu';
    const LOAI_THANH_TOAN_TT = 'Tất toán';
    const LOAI_THANH_TOAN = 'Thanh toán kỳ';
    const LOAI_THANH_LY_TAI_SAN = 'Thanh lý tài sản';
    const LOAI_THANH_TOAN_HEYU = 'Phiếu thu Heyu';
    const LOAI_THANH_TOAN_KHAC = 'khác';

    // Lý do huỷ
    const CANCEL_TRUNG_LENH                         = 1; //Trùng lệnh
    const CANCEL_SAI_SO_TIEN                        = 2; //Sai số tiền
    const CANCEL_SAI_PHUONG_THUC_THANH_TOAN         = 3; //Sai phương thức thanh toán
    const CANCEL_SAI_LOAI_THANH_TOAN                = 4; //Sai loại thanh toán
    const CANCEL_SAI_THONG_TIN_MG                   = 5; //Sai thông tin miễn giảm
    const CANCEL_LOI_GD_DUYET_DINH_DANH             = 6; //Lỗi GD duyệt định danh
    const CANCEL_LOI_GOP_GD_NGAN_HANG               = 7; //Lỗi gộp GD ngân hàng
    const CANCEL_SAI_NGAY_THANH_TOAN                = 8; //Sai ngày thanh toán
    const CANCEL_HUY_PT_HEYU                        = 9; //Huỷ phiếu thu HeyU

    // Lý do trả về
    const RETURN_THIEU_CHUNG_TU                     = 1; //Thiếu chứng từ
    const RETURN_SAI_THONG_TIN_MG                   = 2; //Sai thông tin miễn giảm
    const RETURN_SAI_THONG_TIN_GH                   = 3; //Sai thông tin liên quan tới gia hạn
    const RETURN_THONG_TIN_CC                       = 4; //Sai thông tin liên quan tới cơ cấu
    const RETURN_SAI_THONG_TIN_HEYU                 = 5; //Sai thông tin PT HeyU
    const RETURN_BO_SUNG_XN_HUY_PT_TU_QL            = 6; //Bổ sung xác nhận huỷ PT tiền mặt của quản lý

    /**
     * Get table name function
     *
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }


}
