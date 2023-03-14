<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface RoleRepositoryInterface
{

    /**
     * Check the store is TCVDB or TCV.
     *
     * @param  string  $storeId
     * @return boolean
     */
    public function isTCVDB($storeId);

    public function getAllHcns();
}
