<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class PaymentPeriod extends Model
{
    protected $connection = "mongodb";
    protected $collection = 'paymentperiod';
    protected $primarykey = "_id";
    public $timestamps = false;

    const COLUMN_ID = "_id";
    const COLUMN_CODE_CONTRACT = 'code_contract';//mã hợp đồng
    const COLUMN_DATE_CONTRACT = "date_contract"; // ngày kí hợp đồng
    const COLUMN_CONTRACT_EXPIRY_DATE = "contract_expiry_date"; //thời hạn thuê
    const COLUMN_START_DATE_CONTRACT = "start_date_contract"; //Ngày bắt đầu tính tiền thuê nhà
    const COLUMN_END_DATE_CONTRACT = "end_date_contract";//Ngày kết thúc HĐ
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_UPDATED_BY = "updated_by";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_STATUS = 'status';
    const COLUMN_ONE_MONTH_RENT = "one_month_rent";//giá thuê/tháng(giá thuê đang áp dụng)
    const COLUMN_KY_TRA = 'ky_tra';
    const COLUMN_CUSTOMER_INFOR = "customer_infor";//thông tin chủ nhà
    const COLUMN_TEN_CHU_NHA = "customer_infor.ten_chu_nha";//họ và tên(chủ nhà)
    const COLUMN_SDT_CHU_NHA = "customer_infor.sdt_chu_nha";//phone
    const COLUMN_NGAY_THANH_TOAN = "ngay_thanh_toan";
    const COLUMN_HOP_DONG_SO = 'hop_dong_so';
    const COLUMN_TIEN_THUE = 'tien_thue';
    const COLUMN_STATUS_THUE = 'status_thue';
    const COLUMN_NOTE = 'note';//ghi chú từng bản ghi
    const COLUMN_NOTE_DESCRIPTION = 'note_description';//nội dung ghi chú
    const COLUMN_NGAY_THANH_TOAN_THUE = 'ngay_thanh_toan_thue';//ngày thanh toán thuế
    const COLUMN_NGAY_THANH_TOAN_TT = 'ngay_thanh_toan_tt';//ngày thanh toán kỳ thực tế
    const COLUMN_NGAY_DEN_HAN_TT_THUE = 'ngay_den_han_tt_thue';//ngày đến hạn thanh toán thuế
    const COLUMN_CONTRACT_ID = 'contract_id';//ngày đến hạn thanh toán thuế
    const COLUMN_IMAGE_THUE = 'image_thue';//ảnh chứng từ thuế
    const COLUMN_NGUOI_NOP_THUE = "nguoi_nop_thue";//Trách nhiệm kê khai/nộp thuế
    const COLUMN_START_DATE_CONTRACT_UNI = 'start_date_contract_uni';// convert time Ngày bắt đầu tính tiền thuê nhà
    const COLUMN_END_DATE_CONTRACT_UNI = 'start_date_contract_uni';// convert time Ngày kết thúc  thuê nhà
    const COLUMN_NGAY_THANH_TOAN_UNIX = 'ngay_thanh_toan_unix';// convert time ngày thanh toán
    const COLUMN_NGAY_BAT_DAU_KY = 'ngay_bat_dau_ky';//ngày bắt đầu kỳ
    const COLUMN_NGAY_KET_THUC_KY = 'ngay_ket_thuc_ky';//ngày kết thúc kỳ
    const COLUMN_KY_THANH_TOAN = 'ky_thanh_toan';//kỳ thanh toán số(1,2,3...)


    const COLUMN_BLOCK = 'chua_thanh_toan';
    const COLUMN_ACTIVE = 'da_thanh_toan';

    const COLUMN_BLOCK_THUE = 'chua_thanh_toan';
    const COLUMN_ACTIVE_THUE = 'da_thanh_toan';
    const COLUMN_HOP_DONG_THANH_LY = 'hop_dong_thanh_ly';
    const COLUMN_TLHD_AND_COC = 'tlhd_and_coc';
    const COLUMN_NGAY_TLHD = 'ngay_tlhd';
    const COLUMN_COC_BCTT = 'coc_bctt';// tiền cọc bên cho thuê trả
    const COLUMN_COC_CAN_THUA = 'coc_can_thua';
    const COLUMN_TIEN_CAN_COC = 'tien_can_coc';
    const COLUMN_LOGS = 'logs';//ghi log dữ liệu
    const DESC = 'DESC';
    const ASC = 'ASC';
    //nguoi_nop_thue
    const COLUMN_CTY = '1';
    const COLUMN_CHU_NHA = '2';

    const COLUMN_GOC = 1;
    protected $fillable = [
        self::COLUMN_KY_THANH_TOAN,
        self::COLUMN_NGAY_KET_THUC_KY,
        self::COLUMN_NGAY_BAT_DAU_KY,
        self::COLUMN_NGAY_THANH_TOAN_UNIX,
        self::COLUMN_END_DATE_CONTRACT_UNI,
        self::COLUMN_START_DATE_CONTRACT_UNI,
        self::COLUMN_NGUOI_NOP_THUE,
        self::COLUMN_LOGS,
        self::COLUMN_IMAGE_THUE,
        self::COLUMN_CONTRACT_ID,
        self::COLUMN_NGAY_THANH_TOAN_THUE,
        self::COLUMN_NGAY_DEN_HAN_TT_THUE,
        self::COLUMN_NGAY_THANH_TOAN_TT,
        self::COLUMN_NOTE_DESCRIPTION,
        self::COLUMN_NOTE,
        self::COLUMN_COC_CAN_THUA,
        self::COLUMN_TIEN_CAN_COC,
        self::COLUMN_COC_BCTT,
        self::COLUMN_NGAY_TLHD,
        self::COLUMN_STATUS_THUE,
        self::COLUMN_TIEN_THUE,
        self::COLUMN_HOP_DONG_SO,
        self::COLUMN_CODE_CONTRACT,
        self::COLUMN_DATE_CONTRACT,
        self::COLUMN_DATE_CONTRACT,
        self::COLUMN_CONTRACT_EXPIRY_DATE,
        self::COLUMN_START_DATE_CONTRACT,
        self::COLUMN_END_DATE_CONTRACT,
        self::COLUMN_STATUS,
        self::COLUMN_ONE_MONTH_RENT,
        self::COLUMN_KY_TRA,
        self::COLUMN_CUSTOMER_INFOR,
        self::COLUMN_TEN_CHU_NHA,
        self::COLUMN_SDT_CHU_NHA,
        self::COLUMN_NGAY_THANH_TOAN
    ];
}
