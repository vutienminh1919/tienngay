<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface TransactionRepositoryInterface
{

    /**
     * Get transaction which has paid by cash is exist and not confirmed yet
     *
     * @param  string  $contractCode
     * @return collection
     */
    public function getCashTran($contractCode);

    /**
     * update transaction which has paid by cash
     *
     * @param string $id
     * @param array $data
     * @return collection
     */
    public function updateCashTran($id, $data);
}
