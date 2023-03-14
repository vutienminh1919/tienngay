<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\VPBankVAN;
use Modules\MysqlCore\Entities\CustomerContract;
use Modules\MysqlCore\Repositories\Interfaces\VPBankVANRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;

class VPBankVANRepository implements VPBankVANRepositoryInterface
{

    /**      
     * @var Model
     */     
     protected $vanModel;

    /**
     * VPBankVANContractRepository constructor.
     *
     * @param VPBankVANContract $van
     */
    public function __construct(VPBankVAN $van) {
        $this->vanModel = $van;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return collection
     */
    public function store($attributes) {
        $van = $this->vanModel->create($attributes);
        return $van;
    }

    /**
     * get next id before save.
     *
     * @return numeric
     */
    public function getNewId($storeCode) {
        $max = $this->vanModel::withTrashed()->where(VPBankVAN::STORE_CODE, $storeCode)
                ->max(VPBankVAN::VIRTUAL_ACC_NO);
        if (!$max) {
            $intId = 0;
        } else {
            $intId = (int) substr($max, 8, 35);
        }
        
        return str_pad(($intId + 1), 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get van by customer table id
     * @param integer $customerId
     * @param boolean $isTCVDB (Tài Chính Việt or Tài Chính Việt Đông Bắc)
     * @return numeric
     */
    public function getVanByCusId($customerId, $isTCVDB = false) {
        if ($isTCVDB) {
            $company_name = VPBankVAN::TCVDB;
        } else {
            $company_name = VPBankVAN::TCV;
        }
        $van = $this->vanModel::where(VPBankVAN::COMPANY_NAME, $company_name)
               ->where(VPBankVAN::CUSTOMER_ID, $customerId)
               ->first();
        if ($van) {
            return $van[VPBankVAN::VIRTUAL_ACC_NO];
        }
        return false;
    }

    /**
     * Get customer_id by VAN
     * @param string $van
     * @return numeric
     */
    public function getCusIdByVan($van) {
        $van = $this->vanModel::where(VPBankVAN::VIRTUAL_ACC_NO, $van)
               ->first();
        if ($van) {
            return $van[VPBankVAN::CUSTOMER_ID];
        }
        return false;
    }

    /**
     * Get record by VAN
     * @param string $van
     * @return numeric
     */
    public function findByVan($van) {
        $result = $this->vanModel::where(VPBankVAN::VIRTUAL_ACC_NO, $van)
               ->first();
        return $result;
    }

    /**
     * Check the VAN is TCVDB or TCV
     * @param string $van
     * @return boolean
     */
    public function isTCVDB($van) {
        $result = $this->vanModel::where(VPBankVAN::VIRTUAL_ACC_NO, $van)
               ->where(VPBankVAN::COMPANY_NAME, VPBankVAN::TCVDB)
               ->first();
        if ($result) {
            return true;
        }
        return false;
    }

    /**
    * Get contract list by van
    * @param string $van
    * @return Array contract list
    */
    public function getContractsByVan($van) {
        $result = $this->vanModel::where(VPBankVAN::VIRTUAL_ACC_NO, $van)
               ->select('customer_contracts.' . CustomerContract::CONTRACT_CODE)
               ->leftJoin('customer_contracts', 
                    'vpbank_vans.'.VPBankVAN::CUSTOMER_ID, 
                    '=', 
                    'customer_contracts.'.CustomerContract::CUSTOMER_ID
                )
               ->where(VPBankVAN::VIRTUAL_ACC_NO, $van)
               ->get();
        return $result->pluck(CustomerContract::CONTRACT_CODE)->toArray();
    }

    /**
    * Get van by code contract
    * @param string $codeContract
    * @return Array contract list
    */
    public function getVanByCodeContract($codeContract, $isTCVDB) {
        if ($isTCVDB) {
            $company_name = VPBankVAN::TCVDB;
        } else {
            $company_name = VPBankVAN::TCV;
        }
        $result = $this->vanModel::select('vpbank_vans.' . VPBankVAN::VIRTUAL_ACC_NO)
               ->leftJoin('customer_contracts', 
                    'vpbank_vans.'.VPBankVAN::CUSTOMER_ID, 
                    '=', 
                    'customer_contracts.'.CustomerContract::CUSTOMER_ID
                )
               ->where('vpbank_vans.'.VPBankVAN::COMPANY_NAME, $company_name)
               ->where('customer_contracts.'.CustomerContract::CONTRACT_CODE, $codeContract)
               ->first();
        if ($result) {
            return $result[VPBankVAN::VIRTUAL_ACC_NO];
        }
        return false;
    }
}
