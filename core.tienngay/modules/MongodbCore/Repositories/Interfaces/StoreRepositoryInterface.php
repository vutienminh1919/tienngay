<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface StoreRepositoryInterface
{

    /**
     * Get vpb_store_code
     *
     * @param  string  $storeId
     * @return boolean
     */
    public function getVpbStoreCode($storeId);

    /**
     * Find collection by vpb_store_code
     *
     * @param  string  $storeCode
     * @return collection
     */
    public function findByVpbStoreCode($storeCode);
}
