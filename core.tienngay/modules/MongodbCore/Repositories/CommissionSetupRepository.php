<?php


namespace Modules\MongodbCore\Repositories;


use Modules\MongodbCore\Entities\Commission_setup;

class CommissionSetupRepository extends BaseRepository implements CommissionSetupRepositoryInterface
{

    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Commission_setup::class;
    }

    public function countProduct($product_type_id)
    {
        $query = $this->model;
        return $query
            ->where(Commission_setup::COLUMN_PRODUCT_TYPE_ID, $product_type_id)
            ->count();
    }

    public function getAllCommission()
    {
        $query = $this->model;
        return $query
            ->where(Commission_setup::COLUMN_STATUS, Commission_setup::STATUS_ACTIVE)
            ->get();
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
