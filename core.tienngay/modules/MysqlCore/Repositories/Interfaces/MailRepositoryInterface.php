<?php

namespace Modules\MysqlCore\Repositories\Interfaces;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/
interface MailRepositoryInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return collection
     */
    public function store($attributes);
}
