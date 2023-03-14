<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MistakenVpbankTransaction extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mistaken_vpbank_transactions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const ID                    = "_id";
    const CONTRACT_CODE         = "contract_code";
    const CODE_CONTRACT_DISBURSEMENT = "code_contract_disbursement";
    const TN_TRANCODE           = "tn_trancode";
    const DATE_PAY              = "date_pay";

    const TYPE                  = "type";
    // const PAYMENT_METHOD        = "payment_method";
    const TYPE_PAYMENT          = "type_payment";
    const STATUS                = "status";
    const APPROVE_NOTE          = "approve_note";
    const APPROVE_AT            = "approved_at";
    const APPROVE_BY            = "approved_by";
    const CREATED_AT            = "created_at";
    const UPDATED_AT            = "updated_at";
    const LOAI_THANH_TOAN_TEXT  = "type_payment_name";
    const STATUS_TEXT           = "status_text";
    const STORE_CODE_AREA       = "store_code_area";
    const STORE_ID              = "store_id";

    const PAYMENT_METHOD_CASH               = "1";
    const PAYMENT_METHOD_INTERNET_BANKING   = 2;
    const PAYMENT_METHOD_MOMO               = 'momo_app';
    const PAYMENT_METHOD_VPBANK             = 'VPBank';
    const PAYMENT_METHOD_NGAN_LUONG         = 'app_vfc_nl'; // thanh toán ngân lượng

    const STATUS_NEW                = 'new'; //trạng thái mới
    const STATUS_SUCCESS            = 1; // kế toán đã duyệt
    const STATUS_WAIT_CONFIRM       = 2; // chờ kế toán duyệt
    const STATUS_CANCLED            = 3; // kế toán huỷ
    const STATUS_HAVENT_EVIDENCE    = 4; // chưa tải chứng từ
    const STATUS_RETURNED           = 11; // Kế toán trả về

    const STATUS_NEW_TEXT           = 'Mới tạo'; //trạng thái mới
    const STATUS_SUCCESS_TEXT       = 'Đã duyệt'; // kế toán đã duyệt
    const STATUS_WAIT_CONFIRM_TEXT  = 'Chờ duyệt'; // chờ kế toán duyệt
    const STATUS_CANCLED_TEXT       = 'Đã hủy'; // kế toán huỷ
    const STATUS_HAVENT_EVIDENCE_TEXT = 'Chưa tải chứng từ'; // chưa tải chứng từ
    const STATUS_RETURNED_TEXT      = 'KT trả về'; // Kế toán trả về

    const TYPE_PAYMENT_TERM         = 1; //Thanh toán lãi kỳ
    const TYPE_PAYMENT_GH           = 2; //Phiếu thu gia hạn hợp đồng
    const TYPE_PAYMENT_CC           = 3; //Phiếu thu cơ cấu hợp đồng
    const TYPE_PAYMENT_THANHLY_HD   = 4; //Thanh toán hợp đồng đã thanh lý tài sản
    const TYPE_PAYMENT_BHTN         = 16; //Thanh toán bảo hiểm tai nạn

    const TYPE_THANH_TOAN_KY        = 4; // Thanh toán kỳ
    const TYPE_TAT_TOAN             = 3; // Tất toán

    const TYPE_TAT_TOAN_TEXT        = 'Tất toán'; // Tất toán
    const TYPE_THANH_TOAN_TEXT      = 'Thanh toán kỳ'; // Tất toán
    const TYPE_PAYMENT_CC_TEXT      = 'Cơ cấu'; // Tất toán
    const TYPE_PAYMENT_GH_TEXT      = 'Gia hạn'; // Tất toán
    const UNKNOW_TEXT               = 'Khác';

    /**
     * Get table name function
     *
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }


}
