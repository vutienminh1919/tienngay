<?php

namespace Modules\MongodbCore\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* 
* @package Modules\MysqlCore\Repositories\Interfaces
*/

interface ContractRepositoryInterface
{

    /**
     * Find the specified esource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function find($id);

    /**
     * Find the specified resource by identity card in storage.
     *
     * @param  string  $identityCard
     * @return Collection
     */
    public function findContractByIdentityCard($identityCard);

    /**
     * Find the specified resource by contract code in storage.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function findContractByContractCode($contractCode);

    /**
     * Find the specified resource by contract code in storage.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function findContractByContractCodeWithNoStatus($contractCode);

    /**
     * Get customer contract info by contract_code.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function getCustomerInfoByContractCode($contractCode);

    /**
     * Get contracts by contract codes in storage.
     *
     * @param  string  $contractCodes
     * @return Collection
     */
    public function getContractsByMultipleContractCode($contractCodes);

    /**
     * Find closed contract by contract code in storage.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function closedContract($contractCode);
}
