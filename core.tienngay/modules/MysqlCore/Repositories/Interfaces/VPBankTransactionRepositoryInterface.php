<?php

namespace Modules\MysqlCore\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/

interface VPBankTransactionRepositoryInterface
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes);

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function find($id);

    /**
     * update transaction.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function update($id, $attributes);

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function findByTranctionId($transactionId);

    /**
     * @param $time fomat yyyy-mm-dd
     * get transaction by month
     * @return collection
     */
    public function getListByMonth($time);

    /**
     * Find the specified esource in storage.
     *
     * @param  Array  $condition
     * @return Collection
     */
    public function searchByConditions($conditions);
}
