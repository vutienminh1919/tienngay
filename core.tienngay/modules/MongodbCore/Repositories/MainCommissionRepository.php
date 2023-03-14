<?php


namespace Modules\MongodbCore\Repositories;


use Modules\MongodbCore\Entities\Main_commission;

class MainCommissionRepository extends BaseRepository implements MainCommissionRepositoryInterface
{
    public function getModel()
    {
        return Main_commission::class;
    }

    public function getMainProduct()
    {
        $query = $this->model;
        return $query
            ->where(Main_commission::COLUMN_PARENT_ID, "")
            ->where(Main_commission::COLUMN_STATUS, Main_commission::STATUS_ACTIVE)
            ->orderBy(Main_commission::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function getProduct($id)
    {
        $query = $this->model;
        $id_product = $id['id'];
        return $query
            ->where(Main_commission::COLUMN_ID, $id_product)
            ->where(Main_commission::COLUMN_PARENT_ID, "")
            ->where(Main_commission::COLUMN_STATUS, Main_commission::STATUS_ACTIVE)
            ->first();
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
