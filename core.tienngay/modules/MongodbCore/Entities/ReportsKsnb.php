<?php
namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class ReportsKsnb extends Model
{
    protected $connection = "mongodb";

    protected $collection = "reportsksnb";

    protected $primarykey = "_id";

    public $timestamps = true;

    /**
     * Column name table
     */
    const COLUMN_ID = "_id";
    const COLUMN_STATUS = "status";
    const COLUMN_PROCESS = "process";//tiến trình
    const COLUMN_CODE_ERROR = "code_error";//mã lỗi
    const COLUMN_DESCRIPTION = "description";
    const COLUMN_TYPE = "type";//nhóm vi phạm
    const COLUMN_PUNISHMENT = "punishment";//chế tài
    const COLUMN_DISCIPLINE = "discipline";//hình thức kỷ luật
    const COLUMN_CREATED_BY = "created_by";//
    const COLUMN_UPDATED_BY = "updated_by";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_IMAGE_PATH = "path";
    const COLUMN_IMAGE_NAME = "file_name";
    const COLUMN_IMAGE_TYPE = "file_type";
    const COLUMN_USER_EMAIL = "user_email";
    const COLUMN_USER_NAME = "user_name";
    const COLUMN_STORE_NAME = "store_name";//tên phòng giao dịch
    const COLUMN_STORE_EMAIL_TPGD = "email_tpgd";
    const COLUMN_STORE_EMAIL_ASM = "email_asm";
    const COLUMN_LOG_UPDATE = "log_updated_by";
    const COLUMN_LOG_EMAIL = "log_email";
    const COLUMN_LOG_NAME = "log_name";
    const COLUMN_COMMENT = "comment"; //phản hồi của nv vi phạm
    const COLUMN_INFER = "infer"; //kết luận của TPB
    const COLUMN_LOGS = "logs"; // ghi log
    const COLUMN_STORE_ID = "store_id"; // ghi log
    const COLUMN_KSNB_COMMENT = "ksnb_comment"; //phản hồi của bên ksnb
    const COLUMN_WAIT_FEEDBACK_TIME  = "wait_feedback_time";  //thời gian chờ phản hồi của nv vp
    const COLUMN_REASON_NOT_CONFIRM = "reason_not_confirm"; //lý do không duyệt của TBP
    const COLUMN_MONTH = "month";
    const COLUMN_CEO_CONFIRM = 'ceo_confirm';
    const COLUMN_CEO_NOT_CONFIRM = 'ceo_not_confirm';

    const COLUMN_DESCRIPTION_ERROR = "description_error"; // chi tiết lỗi vi phạm của nv
    const COLUMN_DISCIPLINE_NAME = "discipline_name";
    const COLUMN_PUNISHMENT_NAME = "punishment_name";
    const COLUMN_TYPE_NAME = "type_name";

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

    const COLUMN_ID_ROOM = "id_room";

    const COLUMN_QUOTE_DOCUMENT = 'quote_document';
    const COLUMN_NO = 'no';
    const COLUMN_SIGN_DAY = 'sign_day';
    const COLUMN_CONTENT = 'content';
    const COLUMN_FLAG  = 'flag';
    const COLUMN_USER_NAME_NOTE = 'user_name_note';   
    const COLUMN_USER_EMAIL_NOTE = 'user_email_note';    
    const COLUMN_STORE_NAME_NOTE = 'store_name_note';   
    const COLUMN_STORE_ID_NOTE  = 'store_id_note';       
    const COLUMN_TITLE          = 'title';       
    const COLUMN_NAME_NOTE      = 'name_note';       
    const COLUMN_EMAIL_NOTE     = 'email_note';           

    protected $guarded = [];

    const COLUMN_STATUS_NEW = "1"; //New
    const COLUMN_STATUS_ACTIVE = "2"; //Còn hiệu lực
    const COLUMN_STATUS_BLOCK = "3"; //Hết hiệu lực
    const COLUMN_STATUS_NOT_ACTIVE = "4"; //TBP không duyệt
    const COULUMN_STATUS_DELETE = "5";//hủy biên bản

    const COLUMN_PROCESS_NEW = "1"; //Chờ duyệt
    const COLUMN_PROCESS_ACTIVE = "2"; // Đã gửi, chờ phản hồi
    const COLUMN_PROCESS_BLOCK = "3"; // Kết luận
    const COLUMN_PROCESS_NOT_ACTIVE = "4"; //TBP không duyệt
    const COLUMN_PROCESS_FEEDBACK = "5"; //Đã phản hồi (ng vp đã phản hồi)
    const COLUMN_PROCESS_NOT_FEEDBACK = "6"; //Quá thời gian phản hồi, chờ kết luận
    const COULUMN_PROCESS_RECONFIRM = "7"; //Chờ xác nhận lại
    const COLUMN_PROCESS_WAIT_CONFRIM = "8"; //gửi duyệt khi tạo mới, chờ gửi duyệt
    const COLUMN_PROCESS_WAIT_FEEDBACK = "9"; // chờ phản hồi của ng vp (sau khi ksnb phản hồi lại)
    const COLUMN_PROCESS_WAIT_INFER = '10' ;//chờ kết luận(sau khi ksnb thỏa mãn phản hồi của nv vp thì ấn xác nhận trở về trạng thái này);
    const COLUMN_PROCESS_END_TIME = '6' ;//hết thời gian phản hồi(quá thời gian phản hồi );
    const COLUMN_PROCESS_SEND_CEO = '11' ;//đã gửi cho CEO xác nhận;
    const COLUMN_PROCESS_CEO_CONFIRM = '12' ;//CEO đồng ý;
    const COLUMN_PROCESS_CEO_NOT_CONFIRM = '13' ;//CEO chưa đồng ý;
}
?>
