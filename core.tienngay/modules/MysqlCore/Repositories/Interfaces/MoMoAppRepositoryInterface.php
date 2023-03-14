<?php

namespace Modules\MysqlCore\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/

interface MoMoAppRepositoryInterface
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes);


    /**
     * Update the specified resource in storage.
     *
     * @param  array $attributes
     * @param  int  $id
     * @return boolean
     */
    public function update($attributes, $id);

    /**
     * Update contract_transaction_id.
     *
     * @param  array $attributes
     * @param  int  $id
     * @return boolean
     */
    public function updateContractTransactionId($attributes, $id);

    /**
     * get all transaction
     * @return collection
     */
    public function all();

    /**
     * @param $time fomat yyyy-mm-dd
     * get transaction by month
     * @return collection
     */
    public function getListByMonth($time);

    /**
     * Find the specified esource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function find($id);

    /**
     * Find the specified esource in storage.
     *
     * @param  Array  $condition
     * @return Collection
     */
    public function searchByConditions($conditions);

    /**
     * @param $time fomat yyyy-mm-dd
     * get transaction by multiple ids
     * @return collection
     */
    public function summaryNotReconciliationByIds($ids) ;

    /**
     * @param $time fomat yyyy-mm-dd
     * update Reconciliation id
     * @return collection
     */
    public function updateReconciliationId($reconciliationId, $transactionIds);

    /**
     * Check contract has transaction which is in process
     * @param $contractTransactionId
     * @return int
     */
    public function checkTransactionInProcess($contractId);

    /**
     * Check contract has been complated
     * @param $contractTransactionId
     * @return boolean
     */
    public function isComplatedContract($contractId);

    /**
     * Check contract has transaction which is in process
     * @param $contractTransactionId
     * @return int
     */
    public function getTransactionsByReconciliationId($reconciliationId);

    public function removeReconciliationId($reconciliationId);

    /**
     * Find the specified esource in storage.
     *
     * @param  int  Momo TransactionId
     * @return boolean true: transaction has been done!, false: not done.
     */
    public function isStatusSuccess($transactionId);

    /**
     * confirm transactions.
     *
     * @param  Array $ids
     * @return Collection
     */
    public function autoConfirm($ids);
}
