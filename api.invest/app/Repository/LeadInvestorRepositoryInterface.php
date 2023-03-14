<?php


namespace App\Repository;


interface LeadInvestorRepositoryInterface extends BaseRepositoryInterface
{
    public function get_list_lead_investor($request);

    public function getAllListNew($filter);

    public function get_all_lead();

    public function get_lead_null_assign();

    public function findLastLead();

    public function total_excel_call_lead($filter);

    public function excel_call_lead_v2($filter);
}
