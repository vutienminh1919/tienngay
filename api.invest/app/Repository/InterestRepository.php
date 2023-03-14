<?php


namespace App\Repository;


use App\Models\Interest;

class InterestRepository extends BaseRepository implements InterestRepositoryInterface
{
    public function getModel()
    {
        return Interest::class;
    }

    public function get_interest_type_all()
    {
        return $this->model
            ->where(Interest::COLUMN_TYPE, Interest::TYPE_ALL)
            ->get();
    }

    public function get_interest_type_all_active()
    {
        return $this->model
            ->where(Interest::COLUMN_TYPE, Interest::TYPE_ALL)
            ->where(Interest::COLUMN_STATUS, Interest::STATUS_ACTIVE)
            ->first();
    }

    public function get_type_all()
    {
        return $this->model
            ->where(Interest::COLUMN_TYPE, Interest::TYPE_ALL)
            ->orderBy(Interest::COLUMN_STATUS, self::ASC)
            ->get();
    }

    public function find_interest($interest)
    {
        return $this->model
            ->where(Interest::COLUMN_INTEREST, $interest)
            ->get();
    }

    public function get_all_type_asc()
    {
        return $this->model
            ->where(Interest::COLUMN_TYPE, Interest::TYPE_ALL)
            ->orderBy(Interest::COLUMN_INTEREST, self::ASC)
            ->get();
    }

    public function get_interest_period()
    {
        return $this->model
            ->where(Interest::COLUMN_TYPE, Interest::TYPE_PERIOD)
            ->orderBy(Interest::COLUMN_PERIOD, self::ASC)
            ->get();
    }

    public function get_interest_period_type_interest($type_interest)
    {
        $model = $this->model;
        $model = $model->where(Interest::COLUMN_TYPE, Interest::TYPE_PERIOD);
        if ($type_interest == '') {
            $model = $model->whereNull(Interest::COLUMN_TYPE_INTEREST);
        } else {
            $model = $model->where(Interest::COLUMN_TYPE_INTEREST, $type_interest);
        }
        return $model->orderBy(Interest::COLUMN_PERIOD, self::ASC)
            ->get();
    }

    public function get_interest_period_type_interest_null($period)
    {
        return $this->model
            ->where(Interest::COLUMN_TYPE, Interest::TYPE_PERIOD)
            ->where(Interest::COLUMN_PERIOD, $period)
            ->where(Interest::COLUMN_STATUS, Interest::STATUS_ACTIVE)
            ->whereNull(Interest::COLUMN_TYPE_INTEREST)
            ->first();
    }
}
