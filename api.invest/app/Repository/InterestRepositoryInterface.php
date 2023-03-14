<?php


namespace App\Repository;


interface InterestRepositoryInterface extends BaseRepositoryInterface
{
    public function get_interest_type_all();

    public function get_interest_type_all_active();

    public function get_type_all();

    public function find_interest($interest);

    public function get_all_type_asc();

    public function get_interest_period();

    public function get_interest_period_type_interest($type_interest);

    public function get_interest_period_type_interest_null($period);
}
