<?php

namespace Modules\PTI\Service;

use Modules\PTI\Service\ApiCall;

class PTIApi
{

    /**
    * Tạo Form
    * @param Array $data
    */
    public static function createForm() {
        // Data
        $data = collect([]);
        $data->put("nv", env("PTI_NV"));
        // Call API
        $response = ApiCall::post(
            env('PTI_CREFORM_PATH'), 
            $data->toArray()
        );
        
        return $response;
    }

    /**
    * Tạo đơn BH
    * @param Array $input
    */
    public static function createOrder($input) {
        // Data
        $data = collect([]);
        $data->put("ten",           data_get($input, 'ten'));
        $data->put("dchi",          data_get($input, 'dchi'));
        $data->put("gioi",          data_get($input, 'gioi'));
        $data->put("ngay_sinh",     data_get($input, 'ngay_sinh'));
        $data->put("so_cmt",        data_get($input, 'so_cmt'));
        $data->put("phone",         data_get($input, 'phone'));
        $data->put("email",         data_get($input, 'email'));
        $data->put("ngay_hl",       data_get($input, 'ngay_hl'));
        $data->put("goi",           data_get($input, 'goi'));
        $data->put("suc_khoe",      data_get($input, 'suc_khoe'));
        $data->put("so_thang_bh",   data_get($input, 'so_thang_bh'));
        $data->put("qhe",           data_get($input, 'qhe'));
        $data->put("ttoan",         data_get($input, 'ttoan'));
        $data->put("ten_dn",        data_get($input, 'ten_dn'));
        $data->put("ma_thue",       data_get($input, 'ma_thue', ''));
        $data->put("phone_dn",      data_get($input, 'phone_dn'));
        $data->put("dchi_dn",       data_get($input, 'dchi_dn'));
        $data->put("dvi_sl",        data_get($input, 'dvi_sl'));
        $data->put("kieu_hd",       data_get($input, 'kieu_hd'));
        $data->put("so_hd_g",       data_get($input, 'so_hd_g', ''));
        $data->put("ngay_ht",       data_get($input, 'ngay_ht'));
        $data->put("ttrang",        data_get($input, 'ttrang'));
        $data->put("so_hd",         data_get($input, 'so_hd', ''));
        $data->put("kieu_hd",       data_get($input, 'kieu_hd'));
        $data->put("ma_kt",         data_get($input, 'ma_kt', ''));
        $data->put("cb_ql",         data_get($input, 'cb_ql', ''));
        $data->put("so_id",         data_get($input, 'so_id'));
        $data->put("so_id_d",       data_get($input, 'so_id_d'));
        $data->put("nv",            data_get($input, 'nv', ''));
        $data->put("email_dn",      data_get($input, 'email_dn', ''));
        // Call API
        $response = ApiCall::post(
            env('PTI_CREORDER_PATH'), 
            $data->toArray()
        );
        
        return $response;
    }

    /**
    * xác nhận đơn BH đã tạo
    * @param Array $data
    */
    public static function confirmOrder($input) {
        // Data
        $data = collect([]);
        $data->put("dvi_sl",            data_get($input, 'dvi_sl'));
        $data->put("so_id",             data_get($input, 'so_id'));
        $data->put("so_hd",             data_get($input, 'so_hd'));
        $data->put("nv",                data_get($input, 'nv'));
        // Call API
        $response = ApiCall::post(
            env('PTI_CONFORDER_PATH'), 
            $data->toArray()
        );
        return $response;
    }

    /**
    * Ký số đơn bảo hiểm
    * @param Array $data
    */
    public static function signatureOrder($input) {
        // Data
        $data = collect([]);
        $data->put("ma_bc",             data_get($input, 'ma_bc'));
        $data->put("nv",                data_get($input, 'nv'));
        $data->put("so_id",             data_get($input, 'so_id'));
        $data->put("dvi_sl",            data_get($input, 'dvi_sl'));
        $data->put("so_id_dt",          data_get($input, 'so_id_dt'));
        $data->put("loai_in",           data_get($input, 'loai_in'));
        $data->put("api",               data_get($input, 'api'));
        // Call API
        $response = ApiCall::post(
            env('PTI_SIGNORDER_PATH'), 
            $data->toArray()
        );
        return $response;
    } 


    /**
    * Tạo đơn BH tai nạn
    * @param Array $input
    */
    public static function createOrderBHTN($input, $channel = "pti") {
        // Data
        $data = collect([]);
        $data->put("dvi_sl",        data_get($input, 'dvi_sl'));
        $data->put("ma_cn",         data_get($input, 'ma_cn', ''));
        $data->put("ma_khoi",       data_get($input, 'ma_khoi', ''));
        $data->put("nv",            data_get($input, 'nv', ''));
        $data->put("so_id_kenh",    data_get($input, 'so_id_kenh'));
        $data->put("so_hd",         data_get($input, 'so_hd', ''));
        $data->put("kieu_hd",       data_get($input, 'kieu_hd', ''));
        $data->put("ngay_ht",       data_get($input, 'ngay_ht'));
        $data->put("email",         data_get($input, 'email'));
        $data->put("goi",           data_get($input, 'goi'));
        $data->put("ten",           strtoupper(data_get($input, 'ten')));
        $data->put("dchi",          data_get($input, 'dchi'));
        $data->put("so_cmt",        data_get($input, 'so_cmt'));
        $data->put("phone",         data_get($input, 'phone'));
        $data->put("ngay_sinh",     (int)data_get($input, 'ngay_sinh'));
        $data->put("tien_bh",       (int)data_get($input, 'tien_bh'));
        $data->put("phi",           (int)data_get($input, 'phi'));
        $data->put("ttoan",         (int)data_get($input, 'ttoan'));
        $data->put("ngay_hl",       data_get($input, 'ngay_hl'));
        $data->put("ngay_kt",       data_get($input, 'ngay_kt'));
        $data->put("gio_hl",        data_get($input, 'gio_hl'));
        $data->put("gio_kt",        data_get($input, 'gio_kt'));
        $data->put("ngay_cap",      (int)data_get($input, 'ngay_cap'));
        $ds_dk = data_get($input, 'ds_dk');
        foreach ($ds_dk as &$value) {
            if ($value['loai'] == 'A1' || $value['loai'] == 'A2') {
                $value['tien'] = (string)data_get($input, 'tien_bh');
            } else {
                continue;
            }
        }
        // Call API
        $response = ApiCall::postBHTN(
            env('PTI_BHTN_CREORDER_PATH'), 
            [
                'data' => $data->toArray(),
                'ds_dk' => $ds_dk,
                'ds_tra' => data_get($input, 'ds_tra'),
                'encrypt' => data_get($input, 'encrypt'),
            ],
            [],
            $channel
        );
        
        return $response;
    }

    /**
    * KẾT XUẤT GIẤY CHỨNG NHẬN BHTN
    * @param Array $data
    */
    public static function getBHTNGCN($input, $channel = "pti") {
        // Data
        $data = collect([]);
        $data->put("ma_bc",             data_get($input, 'ma_bc'));
        $data->put("nv",                data_get($input, 'nv'));
        $data->put("so_id",             data_get($input, 'so_id'));
        $data->put("dvi_sl",            data_get($input, 'dvi_sl'));
        $data->put("so_id_dt",          data_get($input, 'so_id_dt'));
        $data->put("loai_in",           data_get($input, 'loai_in'));
        $data->put("api",               data_get($input, 'api'));
        // Call API
        $response = ApiCall::getBHTNGCN(
            env('PTI_SIGNORDER_PATH'), 
            $data->toArray(),
            [],
            $channel
        );
        return $response;
    }

    /**
    * xác nhận đơn BH đã tạo
    * @param Array $data
    */
    public static function confirmBHTN($input, $channel = "pti") {
        // Data
        $data = collect([]);
        $data->put("dvi_sl",            data_get($input, 'dvi_sl'));
        $data->put("so_id",             data_get($input, 'so_id'));
        $data->put("so_hd",             data_get($input, 'so_hd'));
        $data->put("nv",                data_get($input, 'nv'));
        // Call API
        $response = ApiCall::confirmBHTN(
            env('PTI_CONFORDER_PATH'), 
            $data->toArray(),
            ['BranchUnit' => 0],
            $channel
        );
        return $response;
    }
}
