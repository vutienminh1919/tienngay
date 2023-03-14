<?php


namespace App\Repository;


interface TransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function history_transaction_investor($condition, $limit, $offset);

    public function get_proceeds($condition);

//    public function financial_report_transaction($condition);

    public function tong_tien_dau_tu($contract_id);

    public function tong_tien_lai($contract_id);

    public function money_payment($condition);

    public function sum_tra_lai($condition, $date);

    public function get_proceeds_all($condition);

    public function financial_report_contract($condition);

    public function tong_tien_thu_duoc($condition);

    public function tong_giao_dich($condition);

    public function tong_tien_thu_duoc_theo_thang($condition);

    public function tong_giao_dich_theo_thang($condition);

    public function tong_tien_thu_duoc_theo_ngay($condition);

    public function tong_giao_dich_theo_ngay($condition);

    public function tong_giao_dich_theo_nam($condition);

    public function tong_tien_thu_duoc_theo_nam($condition);

    public function money_payment_all($condition);

    public function dashboard_investor($investor_id, $column, $type);

    public function tong_tien_thu_duoc_theo_tung_thang($condition);

    public function get_proceeds_v2($condition);

    public function total_money_invest_by_month($i);

    public function total_money_payment_by_month($i);

    public function total_investment_by_time($condition);

    public function total_money_invest_by_day_on_month($date);

    public function total_money_payment_by_day_on_month($date);

    public function financial_report_contract_v2($investor_id, $year, $type, $i);

    public function dashboard_investor_v2($investor_id);

}
