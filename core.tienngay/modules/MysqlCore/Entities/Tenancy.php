<?php


namespace Modules\MysqlCore\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenancy extends Model
{
    protected $connection = "mongodb";
     use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $collection = 'tenancy';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    public $timestamps = true;


    const COLUMN_ID = "_id";
    const COLUMN_CONTRACT = 'contract';//mã hợp đồng
    const COLUMN_DATE_CONTRACT = "date_contract"; // ngày kí hợp đồng
    const COLUMN_CONTRACT_EXPIRY_DATE = "contract_expiry_date"; //thời hạn thuê
    const COLUMN_START_DATE_CONTRACT = "start_date_contract"; //Ngày bắt đầu tính tiền thuê nhà
    const COLUMN_END_DATE_CONTRACT = "end_date_contract";//Ngày kết thúc HĐ
    const COLUMN_STORE = "store";//Tên phòng giao dịch
    const COLUMN_ADDRESS = "store.address";//địa chỉ cụ thể
    const COLUMN_NAME_CTY = "name_cty";//tên công ty hoặc chi nhánh
    const COLUMN_STAFF_PTMB = "staff_ptmb";//nhân viên phụ trách phát triển mặt bằng
    const COLUMN_ONE_MONTH_RENT = "one_month_rent";//giá thuê/tháng(giá thuê đang áp dụng)
    const COLUMN_KY_TRA = "ky_tra";//kỳ hạn thanh toán(tháng)
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
    const COLUMN_NGUOI_NOP_THUE = "nguoi_nop_thuê";//Trách nhiệm kê khai/nộp thuế
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_UPDATED_BY = "updated_by";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_STATUS = 'status';



    //status
    const COLUMN_BLOCK = 'block';
    const COLUMN_ACTIVE = 'active';

    protected $fillable = [
        self::COLUMN_CONTRACT,
        self::COLUMN_DATE_CONTRACT,
        self::COLUMN_CONTRACT_EXPIRY_DATE,
        self::COLUMN_START_DATE_CONTRACT,
        self::COLUMN_END_DATE_CONTRACT,
        self::COLUMN_STORE,
        self::COLUMN_ADDRESS,
        self::COLUMN_NAME_CTY,
        self::COLUMN_STAFF_PTMB,
        self::COLUMN_ONE_MONTH_RENT,
        self::COLUMN_KY_TRA,
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
    ];

}
