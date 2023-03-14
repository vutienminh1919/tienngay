<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Entities\TemporaryPlanContract as PlanContract;
use Modules\MongodbCore\Repositories\Interfaces\TemporaryPlanRepositoryInterface;

class TemporaryPlanRepository implements TemporaryPlanRepositoryInterface
{

    /**
     * @var Model
     */
     protected $temporaryPlanModel;

    /**
     * TemporaryPlanRepository constructor.
     *
     * @param TemporaryPlanContract $temporaryPlan
     */
    public function __construct(PlanContract $temporaryPlan) {
        $this->temporaryPlanModel = $temporaryPlan;
    }

    /**
     * Lấy ngày thanh toán gần nhất
     *
     * @param string $contractCode
     * @return Collection
     */
    public function getCurrentDateOfPaymentTerm($contractCode) {
        $temporaryPlanContract = $this->temporaryPlanModel::where($this->temporaryPlanModel::CODE_CONTRACT, $contractCode)
        ->where($this->temporaryPlanModel::STATUS, $this->temporaryPlanModel::NOT_PAID)
        ->orderBy($this->temporaryPlanModel::NGAY_KY_TRA, 'ASC')
        ->get();
        if ($temporaryPlanContract) {
            return $temporaryPlanContract->first()[$this->temporaryPlanModel::NGAY_KY_TRA];
        }
        return false;
    }

    /**
     * Lấy số tiền thanh toán của kỳ gần nhất
     *
     * @param string $contractCode
     * @return Collection
     */
    public function getAmountOfPaymentTerm($contractCode) {
        $temporaryPlanContract = $this->temporaryPlanModel::where($this->temporaryPlanModel::CODE_CONTRACT, $contractCode)
        ->where($this->temporaryPlanModel::STATUS, $this->temporaryPlanModel::NOT_PAID)
        ->orderBy($this->temporaryPlanModel::NGAY_KY_TRA, 'ASC')
        ->get();
        if ($temporaryPlanContract) {
            return $temporaryPlanContract->first()[$this->temporaryPlanModel::TIEN_TRA_1_KY];
        }
        return false;
    }
}
