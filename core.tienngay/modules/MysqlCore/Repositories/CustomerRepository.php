<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\Customer;
use Modules\MysqlCore\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;

class CustomerRepository implements CustomerRepositoryInterface
{

    /**      
     * @var Model
     */     
     protected $cusModel;

    /**
     * CustomerRepository constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer) {
        $this->cusModel = $customer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return collection
     */
    public function store($attributes) {
        $data = [
            Customer::NAME                    => data_get($attributes, 'customer_name', ''),
            Customer::EMAIL                   => data_get($attributes, 'customer_email', ''),
            Customer::PHONE                   => data_get($attributes, 'customer_phone_number', ''),
            Customer::CUSTOMER_IDENTITY       => data_get($attributes, 'customer_identify', ''),
            Customer::CUSTOMER_IDENTITY_OLD   => data_get($attributes, 'customer_identify_old', ''),
            Customer::PASSPORT                => data_get($attributes, 'passport_number', ''),
            Customer::DATE_OF_BIRTH           => data_get($attributes, 'customer_BOD', ''),
            Customer::CURRENT_ADDRESS         => data_get($attributes, 'current_address', ''),
            Customer::HOUSEHOLD_ADDRESS       => data_get($attributes, 'household_address', ''),
        ];
        $customer = $this->findByIdentity($data[Customer::CUSTOMER_IDENTITY]);
        if (!$customer) {
            $customer = $this->cusModel->create($data);
        }
        return $customer;
    }

    /**
     * find object by customer_identity in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function findByIdentity($cusIdentity) {
        $result = $this->cusModel->where(Customer::CUSTOMER_IDENTITY, $cusIdentity)
                ->orWhere(Customer::CUSTOMER_IDENTITY_OLD, $cusIdentity)
                ->first();
        return $result;
    }

    /**
     * find object by id in storage.
     *
     * @param  array $attributes
     * @return boolean or object
     */
    public function find($id) {
        $result = $this->cusModel->find($id);
        return $result;
    }

}
