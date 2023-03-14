<?php


namespace App\Repository;


use App\Models\Commission;
use Carbon\Carbon;

class CommissionRepository extends BaseRepository implements CommissionRepositoryInterface
{
    public function getModel()
    {
        return Commission::class;
    }

    public function findCommission($total, $type_referral, $request)
    {
        $model = $this->model;
        return $model->where(Commission::MIN, '<=', $total)
            ->where(Commission::MAX, '>=', $total)
            ->where(Commission::START_DATE, '<=', $request->fdate)
            ->where(Commission::END_DATE, '>=', $request->tdate)
            ->where(Commission::STATUS, Commission::ACTIVE)
            ->where(Commission::TYPE_REFERRAL, $type_referral)
            ->first();
    }
}
