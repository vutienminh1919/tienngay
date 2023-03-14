<?php


namespace App\Repository;


interface PayRepositoryInterface extends BaseRepositoryInterface
{
    public function get_all_pay_paginate($condition);

    public function total_pay($condition);

    public function total_money_pay($condition);

    public function tong_ky_chua_tra($condition);

    public function tong_tien_ki_chua_tra($condition);

    public function tong_ky_da_tra($condition);

    public function tong_tien_ki_da_tra($condition);

    public function tong_ky_den_han_tra($condition);

    public function tong_tien_ky_den_han_tra($condition);

    public function findPayTimeToNow($contractId, $time);

    public function tong_tien_lai_hop_dong($contract_id);

    public function danh_sach_thanh_toan_tu_dong();

    public function lay_ki_tra_theo_ngay($date);

    public function get_all_pay_app($condition);

    public function dashboard_investor($investor_id, $column, $type = []);

    public function get_pay_not_payment($contract_id);

    public function get_all_pay_app_v2($condition);

    public function tong_tien_lai_hop_dong_v2($contract_id);
}
