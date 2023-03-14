<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'transaction';

    protected $primaryKey = '_id';

    protected $guarded = [];

    public $timestamps = false;

    const ID                    = "_id";
    const CODE_CONTRACT         = "code_contract";
    const TOTAL                 = "total";
    const AMOUNT_TOTAL          = "amount_total";
    const CODE                  = "code";
    const TYPE                  = "type";
    const PAYMENT_METHOD        = "payment_method";
    const STATUS                = "status";
    const BANK_REMARK           = "bank_remark";
    const DATE_PAY              = "date_pay";
    const NOTE                  = "note";
    const CODE_TRANSACTION_BANK = "code_transaction_bank";
    const TYPE_PAYMENT          = "type_payment";
    const BANK                  = "bank";
    const BANK_APPROVE_TIME     = "bank_approve_time";
    const CUSTOMER_BILL_NAME    = "customer_bill_name";
    const CUSTOMER_BILL_PHONE   = "customer_bill_phone";
    const LOAI_KHACH            = "loai_khach";
    const APPROVE_NOTE          = "approve_note";
    const APPROVE_AT            = "approved_at";
    const APPROVE_BY            = "approved_by";
    const CREATED_BY            = "created_by";
    const CREATED_AT            = "created_at";
    const UPDATED_BY            = "updated_by";
    const UPDATED_AT            = "updated_at";
    const GOI                   = "goi"; // Tên gói BH
    const STORE                 = "store"; // Tên gói BH
    const STATUS_EMAIL          = "status_email";
    const CUSTOMER_NAME         = "customer_name";
    const CODE_CONTRACT_DISBURSEMENT = "code_contract_disbursement";

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

    const TYPE_PAYMENT_TERM         = 1; //Thanh toán lãi kỳ
    const TYPE_PAYMENT_GH           = 2; //Phiếu thu gia hạn hợp đồng
    const TYPE_PAYMENT_CC           = 3; //Phiếu thu cơ cấu hợp đồng
    const TYPE_PAYMENT_THANHLY_HD   = 4; //Thanh toán hợp đồng đã thanh lý tài sản
    const TYPE_PAYMENT_BHTN         = 16; //Thanh toán bảo hiểm tai nạn

    const LOAI_KHACH_BN             = "BN"; //khách bán ngoài

    const STATUS_EMAIL_SEND         = 1; //Đã gửi email thông báo
    const STATUS_EMAIL_WAITING      = 2; //Đang chờ gửi email
    const STATUS_EMAIL_CANCEL       = 3; //Hủy gửi email

    const TYPE_THANH_TOAN_KY        = 4; // Thanh toán kỳ
    const TYPE_TAT_TOAN             = 3; // Tất toán

    public static function getTypePaymentName($typePayment, $type) {
        if ($typePayment == self::TYPE_PAYMENT_TERM) {
            if ($type == self::TYPE_THANH_TOAN_KY) {
                return 'Thanh toán kỳ';
            } else if ($type == self::TYPE_TAT_TOAN) {
                return 'Tất toán';
            } else {
                'Khác';
            }
        } else if ($typePayment == self::TYPE_PAYMENT_GH) {
            return 'Gia hạn';
        } else if ($typePayment == self::TYPE_PAYMENT_CC) {
            return 'Cơ cấu';
        } else if ($typePayment == self::TYPE_PAYMENT_THANHLY_HD) {
            return 'Thanh lý tài sản';
        } else {
            return 'Khác';
        }
    }

}
