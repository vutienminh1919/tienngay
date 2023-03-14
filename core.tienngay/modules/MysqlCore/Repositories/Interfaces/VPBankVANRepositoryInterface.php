<?php

namespace Modules\MysqlCore\Repositories\Interfaces;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/
interface VPBankVANRepositoryInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return collection
     */
    public function store($attributes);

    /**
     * get next id before save.
     *
     * @return numeric
     */
    public function getNewId($storeCode);

    /**
     * Get van by customer table id
     * @param integer $customerId
     * @param boolean $isTCVDB (Tài Chính Việt or Tài Chính Việt Đông Bắc)
     * @return numeric
     */
    public function getVanByCusId($customerId, $isTCVDB = false);

    /**
     * Get customer_id by VAN
     * @param string $van
     * @return numeric
     */
    public function getCusIdByVan($van);

    /**
     * Get record by VAN
     * @param string $van
     * @return numeric
     */
    public function findByVan($van);

    /**
     * Check the VAN is TCVDB or TCV
     * @param string $van
     * @return boolean
     */
    public function isTCVDB($van);
}
