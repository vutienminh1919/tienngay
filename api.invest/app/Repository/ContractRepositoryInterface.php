<?php


namespace App\Repository;


use App\Models\Contract;

interface ContractRepositoryInterface extends BaseRepositoryInterface
{
    public function get_contract_investor_app($condition, $offset, $limit);

    public function getContract($condition);

    public function findCode($code);

    public function financial_report_contract($condition);

    public function find_interest_paginate($interest_id);

    public function getAllContract($condition);

    public function getSumNdtByTelesales($id_tls, $from_date, $to_date);

    public function get_contract_to_check_status();

    public function get_contract_by_promotions($fdate, $tdate);

    public function find_contract($code_contract);

    public function excel_all_contract($condition);

    public function report_contract_uq($request);
}
