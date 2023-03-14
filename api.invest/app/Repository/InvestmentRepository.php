<?php


namespace App\Repository;


use App\Models\Investment;

class InvestmentRepository extends BaseRepository implements InvestmentRepositoryInterface
{
    public function getModel()
    {
        return Investment::class;
    }

    public function so_luong_hd_tao_trong_thang()
    {
        $date = date('Y-m-01 H:i:s');
        return $this->model
            ->where(Investment::COLUMN_TYPE, Investment::HOP_DONG_GOI_VON)
            ->where(Investment::COLUMN_CREATED_AT, '>=', $date)
            ->count();
    }

    public function get_investment_app($condition, $offset, $limit)
    {
        $skip = !empty($offset) ? (int)$offset : 0;
        $per = !empty($limit) ? (int)$limit : 5;
        $query = $this->model;
        if (!empty($condition['minLoan']) && !empty($condition['maxLoan'])) {
            $query = $query->whereBetween(Investment::COLUMN_AMOUNT_MONEY, [$condition['minLoan'], $condition['maxLoan']]);
        }
        if (!empty($condition['text'])) {
            $query = $query->where(Investment::COLUMN_AMOUNT_MONEY, $condition['text']);
        }
        if (!empty($condition['loan'])) {
            $query = $query->where(Investment::COLUMN_NUMBER_DAY_LOAN, $condition['loan']);
        }
        if (!empty($condition['type_interest'])) {
            $query = $query->where(Investment::COLUMN_TYPE_INTEREST, $condition['type_interest']);
        }
        return $query
            ->whereNull(Investment::COLUMN_INVESTOR_CONFIRM)
            ->where(Investment::COLUMN_STATUS, Investment::STATUS_ACTIVE)
//            ->whereNotIn(Investment::COLUMN_NUMBER_DAY_LOAN, [720])
            ->orderBy(Investment::COLUMN_NUMBER_DAY_LOAN, self::DESC)
            ->orderBy(Investment::COLUMN_AMOUNT_MONEY, self::DESC)
            ->orderBy(Investment::CREATED_AT, self::DESC)
            ->offset($skip)
            ->limit($per)
            ->get();
    }

    public function get_investment()
    {
        $query = $this->model;
        return $query
            ->where(Investment::COLUMN_TYPE, Investment::HOP_DONG_GOI_VON)
            ->where(Investment::COLUMN_STATUS, Investment::STATUS_ACTIVE)
            ->orderBy(Investment::COLUMN_INVESTOR_CONFIRM, self::ASC)
            ->orderBy(Investment::COLUMN_AMOUNT_MONEY, self::ASC)
            ->orderBy(Investment::COLUMN_CREATED_AT, self::DESC)
            ->paginate();
    }

    public function get_over_10_day($limit)
    {
        $query = $this->model;
        return $query
            ->whereNull(Investment::COLUMN_INVESTOR_CONFIRM)
            ->where(Investment::COLUMN_CREATED_AT, '<=', $limit)
            ->get();
    }
}
