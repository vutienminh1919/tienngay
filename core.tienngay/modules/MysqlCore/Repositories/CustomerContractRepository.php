<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\CustomerContract;
use Modules\MysqlCore\Repositories\Interfaces\CustomerContractRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;

class CustomerContractRepository implements CustomerContractRepositoryInterface
{

    /**      
     * @var Model
     */     
     protected $cusContractModel;

    /**
     * CustomerContractRepository constructor.
     *
     * @param CustomerContract $customerContract
     */
    public function __construct(CustomerContract $customerContract) {
        $this->cusContractModel = $customerContract;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return collection
     */
    public function store($attributes) {
        $cusContract = $this->cusContractModel->create($attributes);
        return $cusContract;
    }

    /**
     * Check exists contract_code in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function existsContractCode($contractCode) {
        $result = $this->cusContractModel->where(CustomerContract::CONTRACT_CODE, $contractCode)->first();
        return $result;
    }

    /**
     * find object by contract_code in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function findByContractCode($contractCode) {
        $result = $this->cusContractModel->where(CustomerContract::CONTRACT_CODE, $contractCode)->first();
        return $result;
    }

    /**
     * delete object in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function delete($id) {
        $result = $this->cusContractModel->find($id)->delete();
        return $result;
    }

    /**
     * find object by customer_id in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function getContractCodesByCusId($customerId) {
        $result = $this->cusContractModel->where(CustomerContract::CUSTOMER_ID, $customerId)->get();
        $data = [];
        if ($result->count() > 0) {
            foreach ($result as $key => $value) {
                $data[] = $value[CustomerContract::CONTRACT_CODE];
            }
        }
        return $data;
    }
}
