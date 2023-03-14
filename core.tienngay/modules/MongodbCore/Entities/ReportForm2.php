<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class ReportForm2 extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'report_history_transaction';

    protected $primaryKey = '_id';

    const ID                            = "_id";
    const MA_PHIEU_THU                  = "ma_phieu_thu";
    const NGAY_THANH_TOAN               = "ngay_thanh_toan";
    const MA_GIAO_DICH_NGAN_HANG        = "ma_giao_dich_ngan_hang";
    const NGAN_HANG                     = "ngan_hang";
    const PHONG_GIAO_DICH_NAME          = "phong_giao_dich.name";
    const MA_PHIEU_GHI                  = "ma_phieu_ghi";
    const MA_HOP_DONG                   = "ma_hop_dong";
    const MA_HOP_DONG_GOC               = "ma_hop_dong_goc";
    const TEN_NGUOI_VAY                 = "ten_nguoi_vay";
    const CMT_NGUOI_VAY                 = "cmt_nguoi_vay";
    const TIEN_GOC_DA_THU_HOI           = "tien_goc_da_thu_hoi";
    const TIEN_LAI_DA_THU_HOI           = "tien_lai_da_thu_hoi";
    const TIEN_PHI_DA_THU_HOI           = "tien_phi_da_thu_hoi";
    const TIEN_PHI_GIA_HAN_DA_THU_HOI   = "tien_phi_gia_han_da_thu_hoi";
    const TIEN_PHI_CHAM_TRA_DA_THU_HOI  = "tien_phi_cham_tra_da_thu_hoi";
    const TIEN_PHI_TRUOC_HAN_DA_THU_HOI = "tien_phi_truoc_han_da_thu_hoi";
    const TIEN_PHI_QUA_HAN_DA_THU_HOI   = "tien_phi_qua_han_da_thu_hoi";
    const TONG_PHI_DA_THU_HOI           = "tong_phi_da_thu_hoi";
    const TONG_THU_HOI_THUC_TE          = "tong_thu_hoi_thuc_te";
    const TONG_THU_HOI_LUY_KE           = "tong_thu_hoi_luy_ke";
    const TIEN_MIEN_GIAM                = "tien_mien_giam";
    const TIEN_THUA                     = "tien_thua";
    const TIEN_GOC_GHCC_DA_THU_HOI      = "tien_goc_ghcc_da_thu_hoi";
    const TIEN_LAI_GHCC_DA_THU_HOI      = "tien_lai_ghcc_da_thu_hoi";
    const TIEN_PHI_GHCC_DA_THU_HOI      = "tien_phi_ghcc_da_thu_hoi";
    const TIEN_GHCC_CON_PHAI_THU        = "tien_ghcc_con_phai_thu";
    const TIEN_THUA_KHI_GHCC            = "tien_thua_khi_ghcc";
    const PHUONG_THUC_THANH_TOAN        = "phuong_thuc_thanh_toan";
    const LOAI_THANH_TOAN               = "loai_thanh_toan";
    const HINH_THUC_TRA_LAI             = "hinh_thuc_tra_lai";
    const TINH_TRANG_THANH_LY           = "tinh_trang_thanh_ly";
    const CREATED_AT                    = "created_at";
    const UPDATED_AT                    = "updated_at";
}
