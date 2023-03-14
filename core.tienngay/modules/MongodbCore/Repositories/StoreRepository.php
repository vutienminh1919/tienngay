<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\Store;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class StoreRepository implements StoreRepositoryInterface
{

    /**
     * @var Model
     */
     protected $storeModel;

    /**
     * StoreRepository constructor.
     *
     * @param Store $store
     */
    public function __construct(Store $store) {
        $this->storeModel = $store;
    }

    /**
     * Get vpb_store_code
     *
     * @param  string  $storeId
     * @return boolean
     */
    public function getVpbStoreCode($storeId) {
        $result = $this->storeModel::where("_id", $storeId)
            ->first();
        if ($result) {
            return data_get($result, Store::VPB_STORE_CODE, NULL);
        }
        return false;
    }

    /**
     * Find collection by vpb_store_code
     *
     * @param  string  $storeCode
     * @return collection
     */
    public function findByVpbStoreCode($storeCode) {
        $result = $this->storeModel::where(Store::VPB_STORE_CODE, $storeCode)
            ->first();

        return $result;
    }

    /**
     * Get All collection
     *
     * @return collection
     */
    public function getAll() {
        $result = $this->storeModel::all();

        return $result;
    }

    /**
     * Get All collection
     *
     * @return collection
     */
    public function getActiveList() {
        $result = $this->storeModel::where(Store::STATUS, Store::ACTIVE)->where(Store::TYPE_PGD, Store::PGD_HD)->get([Store::ID, Store::NAME, Store::CODE_AREA]);
        return $result;
    }

    /**
     * Get All collection active in the list ids
     *
     * @return collection
     */
    public function fillterActiveList($ids) {
        $result = $this->storeModel::where(Store::STATUS, Store::ACTIVE)->where(Store::TYPE_PGD, Store::PGD_HD)
        ->whereIn(Store::ID, $ids)
        ->get([Store::ID, Store::NAME, Store::CODE_AREA]);
        return $result;
    }

    /**
     * Get store name
     *
     * @param  string  $storeId
     * @return boolean
     */
    public function getStoreName($storeId) {
        $result = $this->storeModel::where("_id", $storeId)
            ->first();
        if ($result) {
            return data_get($result, Store::NAME, NULL);
        }
        return NULL;
    }

    /**
     * Get store's code area
     *
     * @param  string  $storeId
     * @return boolean
     */
    public function getStoreCodeArea($storeId) {
        $result = $this->storeModel::where("_id", $storeId)
            ->first();
        if ($result) {
            return data_get($result, Store::CODE_AREA, NULL);
        }
        return NULL;
    }

    /**
     * Get store name
     *
     * @param  string  $storeId
     * @return boolean
     */
    public function getCodeAreaList() {
        $result = $this->storeModel::where(Store::CODE_AREA, '$exists', true)->groupBy(Store::CODE_AREA)
            ->get([Store::CODE_AREA]);
        if ($result) {
            $array = Arr::pluck($result->toArray(), Store::CODE_AREA);
            return $array;
        }
        return [];
    }

    /**
     * Get code_area
     *
     * @param  string  $storeId
     * @return boolean
     */
    public function getCodeAreaById($storeId) {
        $result = $this->storeModel::where("_id", $storeId)
            ->first();
        if ($result) {
            return data_get($result, Store::CODE_AREA, NULL);
        }
        return NULL;
    }

    /**
     * Get store by code area
     * dont'n fix function
     * @param  string  $code
     * @return boolean
     */
    public function getStoreByCodeArea($code) {
        $result = $this->storeModel::where(Store::CODE_AREA, $code)
        ->where(Store::STATUS, Store::ACTIVE)
        ->where(Store::TYPE_PGD, Store::PGD_HD)
        ->get([Store::ID, Store::NAME]);
        if ($result) {
            return $result;
        }
        return NULL;
    }

    public function getStoreByArea($code)
    {
        $result = $this->storeModel::where(Store::CODE_AREA, '$exists', true)
            ->where(Store::STATUS, Store::ACTIVE)
            ->where(Store::TYPE_PGD, Store::PGD_HD)
            ->where(Store::CODE_AREA, $code)
            ->select(Store::ID, Store::NAME, Store::CODE_AREA)
            ->get()->toArray();
        return $result;
    }

    public function getStoreNameandCodeArea($storeId)
    {
        $result = $this->storeModel::where("_id", $storeId)
            ->select('name', 'code_area')
            ->first();
        if ($result) {
            return $result;
        }
        return NULL;
    }

    public function getByCodeArea($code) {
        $result = $this->storeModel::where(Store::CODE_AREA, $code)
        ->where(Store::STATUS, Store::ACTIVE)
        ->where(Store::TYPE_PGD, Store::PGD_HD)
        ->get([Store::ID, Store::NAME, Store::CODE_AREA])->toArray();
        if ($result) {
            return $data = [
                'result' => $result,
                'count' => count($result),
            ];
        }
        return NULL;
    }

    public function getCodeAreaByStoreId($id) {
        $result = $this->storeModel::where(Store::CODE_AREA, '$exists', true)
        ->where(Store::STATUS, Store::ACTIVE)
        ->where(Store::ID, $id)
        ->select(Store::CODE_AREA)->first();
        if ($result) {
            return $result['code_area'];
        }
        return false;
    }

    /**
     * Get TCV stores
     * @return array
     */
    public function getTcvStores() {
        $result = $this->storeModel::where([
            '$or' => [
                [Store::COMPANY => ['$eq' => Store::COMPANY_TCV]],
                [Store::COMPANY => ['$exists' => false]]
            ]
        ])->get(['_id']);
        if ($result) {
            return $result->pluck(Store::ID);
        }
        return [];
    }

    /**
     * Get TCV Dong Bac stores
     * @return array
     */
    public function getTcvDbStores() {
        $result = $this->storeModel::where(Store::COMPANY, Store::COMPANY_TCV_DB)
            ->get(['_id']);
        if ($result) {
            return $result->pluck(Store::ID);
        }
        return [];
    }

    /**
     * Get TCV Ho Chi Minh stores
     * @return array
     */
    public function getTcvHcmStores() {
        $result = $this->storeModel::where(Store::COMPANY, Store::COMPANY_TCV_HCM)
            ->get(['_id']);
        if ($result) {
            return $result->pluck(Store::ID);
        }
        return [];
    }
}
