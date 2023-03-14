<?php

namespace Modules\MysqlCore\Repositories\Interfaces;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/
interface CustomerRepositoryInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes);

    /**
     * find object by customer_identity in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function findByIdentity($cusIdentity);

    /**
     * find object by id in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function find($id);
}
