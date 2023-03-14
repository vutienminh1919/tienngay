<?php


namespace App\Repository;


interface InvestmentRepositoryInterface extends BaseRepositoryInterface
{
    public function so_luong_hd_tao_trong_thang();

    public function get_investment_app($condition, $offset, $limit);

    public function get_investment();

    public function get_over_10_day($limit);
}
