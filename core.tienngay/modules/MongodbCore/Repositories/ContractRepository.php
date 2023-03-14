<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\Contract;
use Modules\MongodbCore\Repositories\Interfaces\ContractRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Entities\TemporaryPlanContract as PlanContract;

class ContractRepository implements ContractRepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $contractModel;

    /**
     * ContractRepository constructor.
     *
     * @param Contract $contractModel
     */
    public function __construct(Contract $contractModel) {
        $this->contractModel = $contractModel;
    }

    /**
     * Find the specified resource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function find($id) {
        $contract = $this->contractModel::find($id);
        $temporaryPlanContract = PlanContract::where(
            PlanContract::CODE_CONTRACT, $contract[$this->contractModel::CODE_CONTRACT]
        )->get();
        $countPaidTerm = PlanContract::where(
            PlanContract::CODE_CONTRACT, $contract[$this->contractModel::CODE_CONTRACT]
        )->where(
            PlanContract::STATUS, PlanContract::NOT_PAID
        )->count();
        $contract["temporaryPlanContract"] = $temporaryPlanContract;
        if ($countPaidTerm > 1) {
            $contract["isLastTerm"] = PlanContract::NOT_LAST_TERM;
        } else {
            $contract["isLastTerm"] = PlanContract::LAST_TERM;
        }
        return $contract;
    }

    /**
     * Find the specified resource by identity card in storage.
     *
     * @param  string  $identityCard
     * @return Collection
     */
    public function findContractByIdentityCard($identityCard) {
        $contracts = $this->contractModel::where($this->contractModel::CUSTOMER_IDENTITY_CARD, $identityCard)
            ->orWhere($this->contractModel::CUSTOMER_IDENTITY_CARD_OLD, $identityCard)
            ->whereIn($this->contractModel::STATUS, $this->contractModel::list_array_trang_thai_dang_vay())
            ->where($this->contractModel::CODE_CONTRACT_PARENT_GH, 'exists', false)
            ->where($this->contractModel::CODE_CONTRACT_PARENT_CC, 'exists', false)
            ->get();
        return $contracts;
    }

    /**
     * Find the specified resource by contract code in storage.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function findContractByContractCode($contractCode) {
        $contract = $this->contractModel::where($this->contractModel::CODE_CONTRACT, $contractCode)
            ->whereIn($this->contractModel::STATUS, $this->contractModel::list_array_trang_thai_dang_vay())
            ->first();
        return $contract;
    }

    /**
     * Find the specified resource by contract code in storage.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function findContractByContractCodeWithNoStatus($contractCode) {
        $contract = $this->contractModel::where($this->contractModel::CODE_CONTRACT, $contractCode)
            ->first();
        return $contract;
    }

    /**
     * Get customer contract info by contract_code.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function getCustomerInfoByContractCode($contractCode) {
        $contract = $this->contractModel::where($this->contractModel::CODE_CONTRACT, $contractCode)
            ->first();
        $data = $contract["customer_infor"];
        $data["current_address"] = data_get($contract, 'current_address.current_stay', '')
                                   .', '.data_get($contract, 'current_address.ward_name', '')
                                   .', '.data_get($contract, 'current_address.district_name', '')
                                   .', '.data_get($contract, 'current_address.province_name', '');
        $data["household_address"] = data_get($contract, 'houseHold_address.address_household', '')
                                   .', '.data_get($contract, 'houseHold_address.ward_name', '')
                                   .', '.data_get($contract, 'houseHold_address.district_name', '')
                                   .', '.data_get($contract, 'houseHold_address.province_name', '');
        return $data;
    }

    /**
     * Get contracts by contract codes in storage.
     *
     * @param  string  $contractCodes
     * @return Collection
     */
    public function getContractsByMultipleContractCode($contractCodes) {
        $contract = $this->contractModel::whereIn($this->contractModel::CODE_CONTRACT, $contractCodes)
            ->whereIn($this->contractModel::STATUS, $this->contractModel::list_array_trang_thai_dang_vay())
            ->get();
        return $contract;
    }

    /**
     * Find closed contract by contract code in storage.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function closedContract($contractCode) {
        $contract = $this->contractModel::where($this->contractModel::CODE_CONTRACT, $contractCode)
            ->whereIn($this->contractModel::STATUS, [
                $this->contractModel::DA_HUY,
                $this->contractModel::TAT_TOAN,
                $this->contractModel::DA_THANH_LY
            ])
            ->first();
        if ($contract) {
            return true;
        }
        return false;
    }

    /**
     * Find the specified resource by identity card in storage.
     *
     * @param  string  $identityCard
     * @return Collection
     */
    public function getContractByIdentityCard($identityCard) {
        $contracts = $this->contractModel::where($this->contractModel::CUSTOMER_IDENTITY_CARD, $identityCard)
            ->select(
                $this->contractModel::CODE_CONTRACT,
                $this->contractModel::CODE_CONTRACT_DISBURSEMENT,
                $this->contractModel::CUSTOMER_IDENTITY_CARD,
                $this->contractModel::CUSTOMER_PHONE_NUMBER,
                $this->contractModel::CUSTOMER_NAME
            )
            ->orWhere($this->contractModel::CUSTOMER_IDENTITY_CARD_OLD, $identityCard)
            ->whereIn($this->contractModel::STATUS, $this->contractModel::list_array_trang_thai_dang_vay())
            ->get();
        return $contracts->toArray();
    }

    /**
     * Get contracts by contract codes in storage.
     *
     * @param  string  $contractCodes
     * @return Collection
     */
    public function getContractsByContractCodes($contractCodes) {
        $contracts = $this->contractModel::whereIn($this->contractModel::CODE_CONTRACT, $contractCodes)
            ->select(
                $this->contractModel::CODE_CONTRACT,
                $this->contractModel::CODE_CONTRACT_DISBURSEMENT,
                $this->contractModel::CUSTOMER_IDENTITY_CARD,
                $this->contractModel::CUSTOMER_PHONE_NUMBER,
                $this->contractModel::CUSTOMER_NAME
            )
            ->whereIn($this->contractModel::STATUS, $this->contractModel::list_array_trang_thai_dang_vay())
            ->get();
        return $contracts->toArray();
    }

    /**
     * get the specified resource by contract code in storage.
     *
     * @param  string  $contractCode
     * @return Collection
     */
    public function getContractByContractCode($contractCode) {
        $contract = $this->contractModel::where($this->contractModel::CODE_CONTRACT, $contractCode)
            ->select(
                $this->contractModel::CODE_CONTRACT,
                $this->contractModel::CODE_CONTRACT_DISBURSEMENT,
                $this->contractModel::CUSTOMER_IDENTITY_CARD,
                $this->contractModel::CUSTOMER_PHONE_NUMBER,
                $this->contractModel::CUSTOMER_NAME
            )
            ->whereIn($this->contractModel::STATUS, $this->contractModel::list_array_trang_thai_dang_vay())
            ->first();
        if (!$contract) {
            return false;
        }
        return $contract->toArray();
    }

}
