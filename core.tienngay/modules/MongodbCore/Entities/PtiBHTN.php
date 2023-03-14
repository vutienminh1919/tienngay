<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class PtiBHTN extends Model
{

    public $timestamps = false;

    protected $guarded = [];
    
    protected $connection = 'mongodb';

    protected $collection = 'pti_bhtn';

    protected $primaryKey = '_id';


    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    const ID                            = "_id";
    const CODE_CONTRACT                 = "code_contract";
    const CODE_CONTRACT_DISBURSEMENT    = "code_contract_disbursement";
    const STATUS                        = 'status'; // Tạo đơn thành công
    const TEN_KH                        = 'pti_request.ten'; // Tên KH
    const CONTRACT_AMOUNT               = 'pti_request.contract_amount'; // Số tiền vay
    const IDENTITY                      = 'pti_request.so_cmt'; // Tên KH
    const SO_ID_PTI                     = 'pti_info.so_id_pti'; // Tên KH
    const CREATED_AT                    = 'created_at'; //Tạo mới đơn BH
    const UPDATED_AT                    = 'updated_at';
    const PTI_REQUEST                   = 'pti_request';
    const PTI_INFO                      = 'pti_info';
    const CREATED_BY                    = 'created_by';
    const UPDATED_BY                    = 'updated_by';
    const BANK_REMARK                   = 'bankRemark';
    const BANK_TRANSID                  = 'bankTransId';
    const BANK_NAME                     = 'bankName';
    const TYPE                          = 'type';
    const DIEUKHOAN1                    = 'dieukhoan1';
    const DIEUKHOAN2                    = 'dieukhoan2';
    const STORE                         = 'store';


    const STATUS_SUCCESS            = 'success'; // Tạo đơn thành công
    const STATUS_ERRORS             = 'errors'; // Tạo đơn thất bại
    const STATUS_WAITPAYMENT        = 'waitPayment'; // Chờ Thanh Toán
    const STATUS_PAYMENTSUCCESS     = 'paymentSuccess'; // Thanh Toán Thành Công
    const STATUS_CALLORDER          = 'callingOrder'; // Đang tạo đơn

    const PROCESS_DONE              = 'done'; //Đã ký số đơn BH
    const PROCESS_CONFIRMED         = 'confirmed'; //Đã xác nhận đơn BH
    const PROCESS_NEW               = 'new'; //Tạo mới đơn BH

    const TYPE_BN                   = 'BN';
    const TYPE_HD                   = 'HD';
    
}
