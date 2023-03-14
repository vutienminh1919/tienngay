<?php


namespace App\Repository;


interface InvestorRepositoryInterface extends BaseRepositoryInterface
{
    public function getListPaginate($filter);

    public function getListNewPaginate($filter, $per_page);

    public function findConfirmNew($id);

    public function find_identity($identity);

    public function findInvestor($id);

    public function findCode($code);

    public function getListNdtUyQuyenPaginate($filter);

    public function getALlActive();

    public function getAllListNew($filter);

    public function get_investor_different_active();

    public function get_investor_active();

    public function get_investor_null_assign();

    public function findLastLead();

    public function get_investor_active_assign_call();

    public function get_list_null_type_interest_receving();

    public function get_investor_no_process();

    public function assign_call_investor_active();

    public function get_investor_send_mkt();

    public function getCountListNewPaginate($filter);

    public function excel_getAllListNew($filter);

    public function getIdTelesales();

    public function getEmailTelesales($id);

    public function getLeadBackLogToSave($time_end, $id);

    public function total_excel_call($filter);

    public function excel_call_v2($filter);

    public function getALlActive_v2();

    public function total_investor_activate_new_dash($filter);

    public function total_investor_activated_invested($filter);

    public function total_investor_activated_not_invested_yet($filter);

}
