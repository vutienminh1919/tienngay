<?php

namespace Modules\MysqlCore\Repositories\Interfaces;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/
interface CustomerContractRepositoryInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes);

    /**
     * Check exists contract_code in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function existsContractCode($contractCode);

    /**
     * find object by contract_code in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function findByContractCode($contractCode);

    /**
     * delete object in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function delete($id);

    /**
     * find object by customer_id in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function getContractCodesByCusId($customerId);
}
