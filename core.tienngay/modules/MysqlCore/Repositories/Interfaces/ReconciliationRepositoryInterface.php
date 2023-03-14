<?php

namespace Modules\MysqlCore\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/

interface ReconciliationRepositoryInterface
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes);

    /**
     * Find the specified esource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function find($id);

    /**
     * Soft delete the specified esource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function delete($id);

    /**
     * Find all element in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function all();

    /**
     * @param $time fomat yyyy-mm-dd
     * get list by month
     * @return collection
     */
    public function getListByMonth($time);

    public function sendingEmailStatus($id);
}
