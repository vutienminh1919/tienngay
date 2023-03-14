<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class ReportForm23 extends Model
{
    protected $connection = 'mongodb_report';

    protected $collection = 'report_form23';

    protected $primaryKey = '_id';

    const THANG_BAO_CAO =       "thang_bao_cao";
    const MA_PHIEU_GHI =        "ma_phieu_ghi";
    const MA_HOP_DONG =         "ma_hop_dong";
    const MA_HOP_DONG_GOC =     "ma_hop_dong_goc";
    const NGAY_GIAI_NGAN =      "ngay_giai_ngan";
    const NGAY_GIA_HAN =        "ngay_gia_han";
    const NGAY_CO_CAU =         "ngay_co_cau";
    const THOI_HAN_VAY_NGAY =   "thoi_han_vay_ngay";
    const THOI_HAN_VAY_THANG =  "thoi_han_vay_thang";
    const NGAY_DAO_HAN =        "ngay_dao_han";
    const NGAY_TAT_TOAN =       "ngay_tat_toan";
    const TEN_NGUOI_VAY =       "ten_nguoi_vay";
    const CMT_NGUOI_VAY =       "cmt_nguoi_vay";
    const MA_NGUOI_VAY =        "ma_nguoi_vay";
    const TEN_NDT =             "ten_ndt";
    const MA_NDT =              "ma_ndt";
    const CONG_TY =             "cong_ty";
    const NGAY_CHAM_TRA =       "ngay_cham_tra";
    const LAI_QUA_HAN =         "lai_qua_han";
    const TIEN_LAI_KY =         "tien_lai_ky";
    const STORE_ID =            "store_id";
    const STORE_NAME =          "store_name";
    const SO_TIEN_VAY =         "so_tien_vay";
    const HINH_THUC_TRA_LAI =   "hinh_thuc_tra_lai";
    const CREATED_AT =          "created_at";
    const UPDATED_AT =          "updated_at";
    const LAI_PHAT_SINH_TRONG_THANG =               "lai_phat_sinh_trong_thang";
    const TONG_PHI_PHAT_SINH =                      "tong_phi_phat_sinh";
    const SO_TIEN_PHI_PHAI_TRA_HANG_KY =            "so_tien_phi_phai_tra_hang_ky";
    const SO_TIEN_LAI_NDT_PHAI_TRA_HANG_KY =        "so_tien_lai_NDT_phai_tra_hang_ky";
}
