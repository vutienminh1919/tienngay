<?php

namespace Modules\MongodbCore\Repositories;

interface BaseRepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * Create or update
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function createOrUpdate($id = null, $attributes = []);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    public function toggleActive($id);

    public function find_foreignKey($id, $table, $collection);

    public function delete_field($field, $value);

    public function count_find_foreignKey($id, $table, $collection);

    public function findOne($condition);

    public function findMany($condition);

    public function findOneDesc($condition);

    public function findManySortColumn($condition, $colum, $sort);
}
