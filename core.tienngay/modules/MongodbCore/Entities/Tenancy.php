<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class Tenancy extends Model
{
    protected $connection = "mongodb";
    protected $collection = 'tenancy';

    protected $primarykey = "_id";
    public $timestamps = false;


    const COLUMN_ID = "_id";
    const COLUMN_CODE_CONTRACT = 'code_contract';//mã hợp đồng
    const COLUMN_DATE_CONTRACT = "date_contract"; // ngày kí hợp đồng
    const COLUMN_CONTRACT_EXPIRY_DATE = "contract_expiry_date"; //thời hạn thuê
    const COLUMN_START_DATE_CONTRACT = "start_date_contract"; //Ngày bắt đầu tính tiền thuê nhà
    const COLUMN_END_DATE_CONTRACT = "end_date_contract";//Ngày kết thúc HĐ
    const COLUMN_STORE = "store";// phòng giao dịch
    const COLUMN_STORE_NAME = "store.store_name";//Tên phòng giao dịch
    const COLUMN_ADDRESS = "store.address";//địa chỉ cụ thể
    const COLUMN_NAME_CTY = "name_cty";//tên công ty hoặc chi nhánh
    const COLUMN_STAFF_PTMB = "staff_ptmb";//nhân viên phụ trách phát triển mặt bằng
    const COLUMN_ONE_MONTH_RENT = "one_month_rent";//giá thuê/tháng(giá thuê đang áp dụng)
    const COLUMN_KY_HAN = "ky_han";//kỳ hạn thanh toán(tháng)
    const COLUMN_CUSTOMER_INFOR = "customer_infor";//thông tin chủ nhà
    const COLUMN_TEN_CHU_NHA = "customer_infor.ten_chu_nha";//họ và tên(chủ nhà)
    const COLUMN_SDT_CHU_NHA = "customer_infor.sdt_chu_nha";//phone
    const COLUMN_TEN_TK_CHU_NHA = "customer_infor.ten_tk_chu_nha";//chủ tài khoản
    const COLUMN_SO_TK_CHU_NHA = "customer_infor.so_tk_chu_nha";//Stk nhận thanh toán
    const COLUMN_BANK_NAME = "customer_infor.bank_name";//Tên ngân hàng
    const COLUMN_TIEN_COC = "tien_coc";//Tiền đặt cọc
    const COLUMN_NGAY_DAT_COC = "ngay_dat_coc";//ngày đặt cọc
    const COLUMN_TIEN_COC_THUA = "tien_coc_thua";//Tiền đặt cọc còn lại
    const COLUMN_MA_SO_THUE = "ma_so_thue";//Mã số thuế
    const COLUMN_NGUOI_NOP_THUE = "nguoi_nop_thue";//Trách nhiệm kê khai/nộp thuế
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_UPDATED_BY = "updated_by";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_STATUS = 'status';
    const COLUMN_KY_TRA = 'ky_tra';
    const COLUMN_TONG_KY_TRA = 'tong_ky_tra';
    const COLUMN_HOP_DONG_SO = 'hop_dong_so';
    const COLUMN_TIEN_THUE = 'tien_thue';
    const COLUMN_NGAY_TLHD = 'ngay_tlhd';//ngày thanh lý hợp đồng
    const COLUMN_COC_BCTT = 'coc_bctt';// tiền cọc bên cho thuê trả,
    const COLUMN_COC_CAN_THUA = 'coc_can_thua';// số tiền cọc bên thuê được cấn trừ
    const COLUMN_TIEN_CAN_COC = 'tien_can_coc';//tiền cấn cọc
    const COLUMN_LOGS = 'logs';//ghi log dữ liệu
    const COLUMN_IMAGE_TENANCY = 'image_tenancy';// ảnh scan hợp đồng
    const COLUMN_STATUS_KY_HAN = 'status_ky_han';// trạng thái kỳ hạn
    const COLUMN_DIEN_TICH = 'dien_tich';// diện tích sử dụng
    const COLUMN_START_DATE_CONTRACT_UNI = 'start_date_contract_uni';// convert time Ngày bắt đầu tính tiền thuê nhà
    const COLUMN_END_DATE_CONTRACT_UNI = 'end_date_contract_uni';// convert time Ngày kết thúc  thuê nhà
    const COLUMN_TIEN_COC_CHU_NHA = 'tien_coc_chu_nha';// tiền cọc chủ nhà thanh toán
    const COLUMN_NGAY_THANH_TOAN_COC = 'ngay_thanh_toan_coc';// ngày thanh toán cọc chủ nhà thanh toán
    const COLUMN_NGAY_THANH_LY = 'ngay_thanh_ly';// ngày thanh lý hợp đồng
    const COLUMN_KY_THANH_TOAN = 'ky_thanh_toan';

    //status
    const COLUMN_BLOCK = 'block';
    const COLUMN_ACTIVE = 'active';
    const COLUMN_HOP_DONG_THANH_LY = 'hop_dong_thanh_ly';
    //status_ky_han
    const COLUMN_BLOCK_KY_HAN = '1';
    const COLUMN_ACTIVE_KY_HAN = '2';
    const COLUMN_GOC = 1;
    const DESC = 'DESC';
    const ASC = 'ASC';
    //nguoi_nop_thue
    const COLUMN_CTY = '1';
    const COLUMN_CHU_NHA = '2';


    protected $fillable = [
        self::COLUMN_KY_THANH_TOAN,
        self::COLUMN_NGAY_THANH_LY,
        self::COLUMN_CREATED_AT,
        self::COLUMN_NGAY_THANH_TOAN_COC,
        self::COLUMN_TIEN_COC_CHU_NHA,
        self::COLUMN_END_DATE_CONTRACT_UNI,
        self::COLUMN_START_DATE_CONTRACT_UNI,
        self::COLUMN_LOGS,
        self::COLUMN_DIEN_TICH,
        self::COLUMN_TEN_TK_CHU_NHA,
        self::COLUMN_STATUS_KY_HAN,
        self::COLUMN_IMAGE_TENANCY,
        self::COLUMN_STORE_NAME,
        self::COLUMN_COC_CAN_THUA,
        self::COLUMN_TIEN_CAN_COC,
        self::COLUMN_COC_BCTT,
        self::COLUMN_NGAY_TLHD,
        self::COLUMN_TIEN_THUE,
        self::COLUMN_HOP_DONG_SO,
        self::COLUMN_CODE_CONTRACT,
        self::COLUMN_DATE_CONTRACT,
        self::COLUMN_CONTRACT_EXPIRY_DATE,
        self::COLUMN_START_DATE_CONTRACT,
        self::COLUMN_END_DATE_CONTRACT,
        self::COLUMN_STORE,
        self::COLUMN_ADDRESS,
        self::COLUMN_NAME_CTY,
        self::COLUMN_STAFF_PTMB,
        self::COLUMN_ONE_MONTH_RENT,
        self::COLUMN_KY_HAN,
        self::COLUMN_CUSTOMER_INFOR,
        self::COLUMN_TEN_CHU_NHA,
        self::COLUMN_SDT_CHU_NHA,
        self::COLUMN_SO_TK_CHU_NHA,
        self::COLUMN_BANK_NAME,
        self::COLUMN_TIEN_COC,
        self::COLUMN_NGAY_DAT_COC,
        self::COLUMN_TIEN_COC_THUA,
        self::COLUMN_MA_SO_THUE,
        self::COLUMN_NGUOI_NOP_THUE,
        self::COLUMN_STATUS,
        self::COLUMN_CREATED_BY,
        self::COLUMN_UPDATED_BY,
        self::COLUMN_KY_TRA,
        self::COLUMN_TONG_KY_TRA
    ];


}
