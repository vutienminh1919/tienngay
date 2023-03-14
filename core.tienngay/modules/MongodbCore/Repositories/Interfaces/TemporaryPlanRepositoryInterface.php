<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface TemporaryPlanRepositoryInterface
{

    /**
     * Lấy ngày thanh toán gần nhất
     *
     * @param string $contractCode
     * @return Collection
     */
    public function getCurrentDateOfPaymentTerm($contractCode);
}
