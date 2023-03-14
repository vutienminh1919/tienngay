<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\Depreciation;
use Log;

class DepreciationRepository extends BaseRepository implements DepreciationBaseRepositoryInterface
{
    /**
     * get model
     */
    public function getModel()
    {
        return Depreciation::class;
    }

    /**
     * search  depreciations by some fields
     *
     * @param $data (array | object)
     *
     * @return Modules\MysqlCore\Entities\Depreciation
     */
    public function search($data, $getFirst = false) {
        // dd($data);
        $query = Depreciation::query();
        // search by  type
        if(data_get($data, Depreciation::COLUMN_CODE)) {
            $query->where(Depreciation::COLUMN_CODE, data_get($data, Depreciation::COLUMN_CODE));
        }
        // search by traffic type
        if(data_get($data, Depreciation::COLUMN_PROPERTY_TYPE)) {
            $query->where(Depreciation::COLUMN_PROPERTY_TYPE, data_get($data, Depreciation::COLUMN_PROPERTY_TYPE));
        }
        // search by  model
        if(data_get($data, Depreciation::COLUMN_PROPERTY_NAME)) {
            $query->where(Depreciation::COLUMN_PROPERTY_NAME, data_get($data, Depreciation::COLUMN_PROPERTY_NAME));
        }
        // search by  year old
        if(data_get($data, Depreciation::COLUMN_YEAR)) {
            $query->where(Depreciation::COLUMN_YEAR, data_get($data, Depreciation::COLUMN_YEAR));
        }
        // search by  segment
        if(data_get($data, Depreciation::COLUMN_PHAN_KHUC)) {
            $query->where(Depreciation::COLUMN_PHAN_KHUC, data_get($data, Depreciation::COLUMN_PHAN_KHUC));
        }

        if($getFirst) {
            return $query->first();
        } else {
            return $query->get();
        }
    }

    public function toggleActive($id)
    {
        // TODO: Implement toggleActive() method.
    }

    public function find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement find_foreignKey() method.
    }

    public function count_find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement count_find_foreignKey() method.
    }
}
