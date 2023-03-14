<?php


namespace Modules\AssetLocation\Http\Repository;


abstract class BaseRepository
{
    const DESC = 'DESC';
    const ASC = 'ASC';

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $data->attributesToArray();
        } else {
            return null;
        }

    }

    public function create($attributes = [])
    {
        $data = $this->model->create($attributes);
        return $data->attributesToArray();
    }

    public function update($id, $attributes = [])
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($attributes);
            return $result->attributesToArray();
        }
        return false;
    }

    public function delete($id)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    public function findOne($where = [])
    {
        $query = $this->model;
        if (count($where) > 0) {
            foreach ($where as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        return $query->first();
    }

    public function findOneSortColumn($where = [], $column_sort, $sort)
    {
        $query = $this->model;
        if (count($where) > 0) {
            foreach ($where as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        return $query
            ->orderBy($column_sort, $sort)
            ->first();
    }

    public function findManySortColumn($where = [], $column_sort, $sort)
    {
        $query = $this->model;
        if (count($where) > 0) {
            foreach ($where as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        return $query
            ->orderBy($column_sort, $sort)
            ->get();
    }

    public function count($where = [])
    {
        $query = $this->model;
        if (count($where) > 0) {
            foreach ($where as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        return $query->count();
    }

    public function paginate($where = [], $per_page, $column_sort, $sort)
    {
        $query = $this->model;
        if (count($where) > 0) {
            foreach ($where as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        return $query
            ->orderBy($column_sort, $sort)
            ->paginate((int)$per_page);
    }

    public function findMany($where = [])
    {
        $query = $this->model;
        if (count($where) > 0) {
            foreach ($where as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        return $query->get();
    }

    public function whereIn($column, $in = [])
    {
        $query = $this->model;
        $query = $query->whereIn($column, $in);
        return $query->get();
    }
}
