<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\HeyuStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use MongoDB\BSON\Regex;
use Modules\MongodbCore\Repositories\Interfaces\HeyuStoreRepositoryInterface;

class HeyuStoreRepository implements HeyuStoreRepositoryInterface
{
    /**
     * @var Model
     */
    protected $heyuModel;


    /**
     * HeyuStoreRepository .
     *
     * @param HeyuStore
     */
    public function __construct(HeyuStore $heyuStoreModel)
    {
        $this->heyuStoreModel = $heyuStoreModel;
    }

    public function getAll($dataSearch, $export = false)
    {
        $listRecord = $this->heyuStoreModel;
        if (!empty($dataSearch['store'])) {
            $listRecord = $listRecord->whereIn('store.id', $dataSearch['store']);
            return $listRecord
                ->where(HeyuStore::STATUS, HeyuStore::ACTIVE)
                ->orderBy(HeyuStore::CREATED_AT, 'DESC')
//            ->paginate(10);
                ->get();
        }else{
            return [];
        }
    }

    public function detailById($id)
    {
        $result = HeyuStore::where(HeyuStore::ID, $id)->first()->toArray();
        return $result;

    }

    public function insert($data)
    {
        $detail = [
            HeyuStore::COAT => [
                HeyuStore::SIZE_S => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_S] ?? 0,
                HeyuStore::SIZE_M => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_M] ?? 0,
                HeyuStore::SIZE_L => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_L] ?? 0,
                HeyuStore::SIZE_XL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XL] ?? 0,
                HeyuStore::SIZE_XXL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XXL] ?? 0,
                HeyuStore::SIZE_XXXL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XXXL] ?? 0,
            ],
            HeyuStore::HELMET => (int)$data['helmet'] ?? 0,
            HeyuStore::SHIRT => [
                HeyuStore::SIZE_S => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_S] ?? 0,
                HeyuStore::SIZE_M => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_M] ?? 0,
                HeyuStore::SIZE_L => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_L] ?? 0,
                HeyuStore::SIZE_XL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XL] ?? 0,
                HeyuStore::SIZE_XXL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XXL] ?? 0,
                HeyuStore::SIZE_XXXL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XXXL] ?? 0,
            ],
        ];
        $store = [
            HeyuStore::STORE_ID => $data[HeyuStore::STORE][HeyuStore::STORE_ID],
            HeyuStore::STORE_NAME => $data[HeyuStore::STORE][HeyuStore::STORE_NAME]
        ];
        $result = [
            HeyuStore::STORE => $store,
            HeyuStore::TOTAL_COAT  => (int)$data[HeyuStore::TOTAL_COAT],
            HeyuStore::TOTAL_SHIRT => (int)$data[HeyuStore::TOTAL_SHIRT],
            HeyuStore::DETAIL => $detail,
            HeyuStore::STATUS => HeyuStore::ACTIVE,
            HeyuStore::CREATED_AT => time(),
            HeyuStore::CREATED_BY => $data['created_by'],
        ];
        $create = $this->heyuStoreModel->create($result);
        return $create;
    }

    public function updateStoreTienngay($data)
    {
        $detailById = HeyuStore::where('store.id', $data['store']['id'])->first();
        $result = [];
        $detail = [
            HeyuStore::COAT => [
                HeyuStore::SIZE_S => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_S] + (int)$detailById['detail'][HeyuStore::COAT][HeyuStore::SIZE_S],
                HeyuStore::SIZE_M => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_M] + (int)$detailById['detail'][HeyuStore::COAT][HeyuStore::SIZE_M],
                HeyuStore::SIZE_L => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_L] + (int)$detailById['detail'][HeyuStore::COAT][HeyuStore::SIZE_L],
                HeyuStore::SIZE_XL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XL] + (int)$detailById['detail'][HeyuStore::COAT][HeyuStore::SIZE_XL],
                HeyuStore::SIZE_XXL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XXL] + (int)$detailById['detail'][HeyuStore::COAT][HeyuStore::SIZE_XXL] ,
                HeyuStore::SIZE_XXXL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XXXL] + (int)$detailById['detail'][HeyuStore::COAT][HeyuStore::SIZE_XXXL],
            ],
            HeyuStore::HELMET => (int)$data['helmet'] + (int)$detailById['detail']['helmet'],
            HeyuStore::SHIRT => [
                HeyuStore::SIZE_S => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_S] + (int)$detailById['detail'][HeyuStore::SHIRT][HeyuStore::SIZE_S],
                HeyuStore::SIZE_M => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_M] + (int)$detailById['detail'][HeyuStore::SHIRT][HeyuStore::SIZE_M],
                HeyuStore::SIZE_L => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_L] + (int)$detailById['detail'][HeyuStore::SHIRT][HeyuStore::SIZE_L],
                HeyuStore::SIZE_XL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XL] + (int)$detailById['detail'][HeyuStore::SHIRT][HeyuStore::SIZE_XL],
                HeyuStore::SIZE_XXL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XXL] + (int)$detailById['detail'][HeyuStore::SHIRT][HeyuStore::SIZE_XXL],
                HeyuStore::SIZE_XXXL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XXXL] + (int)$detailById['detail'][HeyuStore::SHIRT][HeyuStore::SIZE_XXXL],
            ],
        ];
        $result = [
            HeyuStore::TOTAL_COAT  => (int)$data[HeyuStore::TOTAL_COAT] + (int)$detailById[HeyuStore::TOTAL_COAT],
            HeyuStore::TOTAL_SHIRT => (int)$data[HeyuStore::TOTAL_SHIRT] + (int)$detailById[HeyuStore::TOTAL_SHIRT],
            HeyuStore::DETAIL => $detail,
            HeyuStore::STATUS => HeyuStore::ACTIVE,
            HeyuStore::UPDATED_AT => time(),
            HeyuStore::UPDATED_BY => $data['updated_by']
        ];
        $update = HeyuStore::where('store.id', $data['store']['id'])->update($result);
        return $update;

    }

    public function logs($id, $action, $createdBy, $data)
    {
        $log = [
            'action' => $action,
            'created_by' => $createdBy,
            'created_at' => time(),
            'data' => $data,
        ];
        $updateLog = HeyuStore::where('store.id', $id)
            ->push(HeyuStore::LOG, $log);
    }

    public function logID($id, $action, $createdBy, $data)
    {
        $log = [
            'action' => $action,
            'created_by' => $createdBy,
            'created_at' => time(),
            'data' => $data,
        ];
        $updateLog = HeyuStore::where(HeyuStore::ID, $id)
            ->push(HeyuStore::LOG, $log);
    }

    public function getAllCreatedStorePgd()
    {
        $result = HeyuStore::where(HeyuStore::STATUS, HeyuStore::ACTIVE)
            ->select('store')
            ->get()->toArray();
        return $result;

    }

    public function getLogsByStoreId($storeId)
    {
        $result = HeyuStore::where('store.id', $storeId)
            ->select('logs')
            ->first()->toArray();
        return $result;
    }

    public function edit($data)
    {
        $result = [];
        $detail = [
            HeyuStore::COAT => [
                HeyuStore::SIZE_S => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_S],
                HeyuStore::SIZE_M => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_M],
                HeyuStore::SIZE_L => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_L],
                HeyuStore::SIZE_XL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XL],
                HeyuStore::SIZE_XXL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XXL],
                HeyuStore::SIZE_XXXL => (int)$data[HeyuStore::COAT][HeyuStore::SIZE_XXXL],
            ],
            HeyuStore::HELMET => (int)$data['helmet'],
            HeyuStore::SHIRT => [
                HeyuStore::SIZE_S => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_S],
                HeyuStore::SIZE_M => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_M],
                HeyuStore::SIZE_L => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_L],
                HeyuStore::SIZE_XL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XL],
                HeyuStore::SIZE_XXL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XXL],
                HeyuStore::SIZE_XXXL => (int)$data[HeyuStore::SHIRT][HeyuStore::SIZE_XXXL],
            ],
        ];
        $result = [
            HeyuStore::TOTAL_COAT => (int)$data[HeyuStore::TOTAL_COAT],
            HeyuStore::TOTAL_SHIRT => (int)$data[HeyuStore::TOTAL_SHIRT],
            HeyuStore::DETAIL => $detail,
            HeyuStore::STATUS => HeyuStore::ACTIVE,
            HeyuStore::UPDATED_AT => time(),
            HeyuStore::UPDATED_BY => $data['updated_by']
        ];
        $update = HeyuStore::where(HeyuStore::ID, $data['id'])->update($result);
        return $update;

    }

    public function getHistory($id)
    {
        $history = HeyuStore::where(HeyuStore::ID, $id)
            ->where(HeyuStore::STATUS, HeyuStore::ACTIVE)
            ->select('logs', 'store')
            ->first()->toArray();
        return $history;


    }

    /**
     * Find special source by store's id
     * @param $storeId string
     * @return array
     * */
    public function detailByStoreId($storeId)
    {
        $result = HeyuStore::where(HeyuStore::STORE .'.'. HeyuStore::STORE_ID, $storeId)->first([HeyuStore::DETAIL]);
        if ($result) {
            return $result->toArray();
        }
        return [];
    }

    /**
     * Update storage by store's id
     * @param $storeId string
     * @return boolean
     * */
    public function updateStorage($storeId, $update)
    {
        $update = HeyuStore::where(HeyuStore::STORE .'.'. HeyuStore::STORE_ID, $storeId)->update(['$set' => [
            HeyuStore::TOTAL_COAT => array_sum($update['coat']),
            HeyuStore::TOTAL_SHIRT => array_sum($update['shirt']),
            HeyuStore::DETAIL .'.'.HeyuStore::COAT  => $update['coat'],
            HeyuStore::DETAIL .'.'.HeyuStore::SHIRT  => $update['shirt']
        ]]);
        return $update;
    }
}
