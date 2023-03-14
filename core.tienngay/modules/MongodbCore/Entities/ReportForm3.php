<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class ReportForm3 extends Model
{
    protected $connection = 'mongodb_report';

    protected $collection = 'report_real_revenue';

    protected $primaryKey = '_id';

    const ID                    = "_id";
    const THANG_BAO_CAO         = "thang_bao_cao";
    const MA_PHIEU_GHI          = "ma_phieu_ghi";
    const MA_HOP_DONG           = "ma_hop_dong";
    const MA_HOP_DONG_GOC       = "ma_hop_dong_goc";
    const THOI_HAN_VAY_THANG    = "thoi_han_vay_thang";
    const THOI_HAN_VAY_NGAY     = "thoi_han_vay_ngay";
    const NGAY_GIAI_NGAN        = "ngay_giai_ngan";
    const NGAY_GIA_HAN          = "ngay_gia_han";
    const NGAY_DAO_HAN          = "ngay_dao_han";
    const NGAY_TAT_TOAN         = "ngay_tat_toan";
    const TEN_NGUOI_VAY         = "ten_nguoi_vay";
    const CMT_NGUOI_VAY         = "cmt_nguoi_vay";
    const MA_NGUOI_VAY          = "ma_nguoi_vay";
    const STORE                 = "store";
    const STORE_ID              = "store.id";
    const STORE_NAME            = "store.name";
    const HINH_THUC_CAM_CO      = "hinh_thuc_cam_co";
    const SO_TIEN_VAY           = "so_tien_vay";
    const HINH_THUC_TRA_LAI     = "hinh_thuc_tra_lai";
    const TI_LE_LAI_NHA_DAU_TU  = "ti_le_lai_nha_dau_tu";
    const TI_LE_PHI_TU_VAN      = "ti_le_phi_tu_van";
    const TI_LE_PHI_THAM_DINH   = "ti_le_phi_tham_dinh";
    const TI_LE_PHI_CHAM_TRA    = "ti_le_phi_cham_tra";
    const PHI_QUAN_LY_SO_TIEN_VAY_CHAM_TRA      = "phi_quan_ly_so_tien_vay_cham_tra";
    const TI_LE_PHI_THANH_TOAN_TRUOC_1_3_HAN    = "ti_le_phi_thanh_toan_truoc_1_3_han";
    const TI_LE_PHI_THANH_TOAN_TRUOC_2_3_HAN    = "ti_le_phi_thanh_toan_truoc_2_3_han";
    const TI_LE_PHI_THANH_TOAN_TRUOC_CAC_TRUONG_HOP_CON_LAI     = "ti_le_phi_thanh_toan_truoc_cac_truong_hop_con_lai";
    const SO_NGAY_TINH_LAI_THANG        = "so_ngay_tinh_lai_thang";
    const LAI_VAY_TRA_NHA_DAU_TU        = "lai_vay_tra_nha_dau_tu";
    const LAI_QUA_HAN                   = "lai_qua_han";
    const SO_NGAY_QUA_HAN               = "so_ngay_qua_han";
    const LAI_PHAT_SINH_TRONG_THANG     = "lai_phat_sinh_trong_thang";
    const PHI_TU_VAN                    = "phi_tu_van";
    const PHI_TU_VAN_THAM_DINH_DUOC_MIEN_GIAM       = "phi_tu_van_tham_dinh_duoc_mien_giam";
    const PHI_TU_VAN_THAM_DINH_PHAT_SINH            = "phi_tu_van_tham_dinh_phat_sinh";
    const PHI_QUA_HAN                   = "phi_qua_han";
    const PHI_GIA_HAN                   = "phi_gia_han";
    const PHI_CHAM_TRA                  = "phi_cham_tra";
    const PHI_TRA_TRUOC                 = "phi_tra_truoc";
    const PHI_QUA_HAN_DA_THU_HOI        = "phi_qua_han_da_thu_hoi";
    const PHI_QUA_HAN_LUY_KE            = "phi_qua_han_luy_ke";
    const LAI_QUA_HAN_LUY_KE            = "lai_qua_han_luy_ke";
    const CHENH_LECH_LAI_PHI            = "chenh_lech_lai_phi";
    const TONG_PHI_PHAT_SINH            = "tong_phi_phat_sinh";
    const TRANG_THAI                    = "trang_thai";
    const TRANG_THAI_HIEN_TAI           = "trang_thai_hien_tai";
    const CREATED_AT                    = "created_at";
    const UPDATED_AT                    = "updated_at";
    const FLAG_DUNG_TINH_LAI            = "flag_dung_tinh_lai";
    const NGAY_DUNG_TINH_LAI            = "ngay_dung_tinh_lai";
    const COLUMN_LOGS                   = "column_logs";
}
