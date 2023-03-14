<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\PaymentHoliday as Model;
use Modules\MongodbCore\Repositories\Interfaces\PaymentHolidayRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PaymentHolidayRepository implements PaymentHolidayRepositoryInterface
{

    /**
     * @var Model
     */
     protected $model;

    /**
     * PaymentHolidayRepository constructor.
     *
     * @param PaymentHoliday $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * Store new payment holidays data into collection
     * @param $attr array
     * @return collection
     * */
    public function store($attr) {
        $data = [
            Model::NAME                 => $attr[Model::NAME],
            Model::DESCRIPTION          => $attr[Model::DESCRIPTION],
            Model::START_DATE           => $attr[Model::START_DATE],
            Model::END_DATE             => $attr[Model::END_DATE],
            Model::CREATED_BY           => $attr[Model::CREATED_BY],
            Model::UPDATED_BY           => $attr[Model::CREATED_BY]
        ];
        $create = $this->model->create($data);
        return $create;
    }

    /**
     * get a payment holidays by id
     * @param $id string
     * @return collection
     * */
    public function fetch($id) {
        $holiday = $this->model->find($id);
        return $holiday;
    }

    /**
     * Update payment holidays
     * @param $id string, $arr Array
     * @return boolean
     * */
    public function update($id, $arr) {
        $update = $this->model->find($id);
        if ($update) {
            foreach($arr as $key => $value) {
                $update[$key] = $value;
            }
            if ($update->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Delete payment holidays
     * @param $id string, $arr Array
     * @return boolean
     * */
    public function delete($id, $arr) {
        $update = $this->model->find($id);
        if ($update) {
            foreach($arr as $key => $value) {
                $update[$key] = $value;
            }
            if ($update->save() && $update->delete()) {
                return true;
            }
        }
        return false;
    }

    /**
     * get data by conditions
     * @param $conditions Array
     * @return collection
     * */
    public function index($conditions, $limit)
    {

        $filter = [];
        $listRecord = $this->model;

        if (!empty($conditions['name'])) {
            $filter[] = [Model::NAME, 'like', '%'.trim($conditions['name']).'%'];
        }
        if (!empty($conditions['status'])) {
            $filter[] = [Model::STATUS, '=', (int)$conditions['status']];
        }
        
        if (!empty($filter)) {
            $listRecord = $listRecord->where($filter);
        }
        if (!empty($conditions['start_date']) && !empty($conditions['end_date'])) {
            $listRecord = $listRecord->where(function ($query) use ($conditions) {
                return $query
                    ->orWhere(function ($query1) use ($conditions) {
                        return $query1
                            ->where(Model::START_DATE, '<=', strtotime($conditions['start_date']))
                            ->where(Model::END_DATE, '>=', strtotime($conditions['start_date']));
                    })
                    ->orWhere(function ($query2) use ($conditions) {
                        return $query2
                            ->where(Model::START_DATE, '<=', strtotime($conditions['end_date']))
                            ->where(Model::END_DATE, '>=', strtotime($conditions['end_date']));
                    });
                
            });

        } else {
            if (!empty($conditions['start_date'])) {
                $listRecord = $listRecord->where(function ($query) use ($conditions) {
                    return $query
                        ->where(Model::START_DATE, '<=', strtotime($conditions['start_date']))
                        ->where(Model::END_DATE, '>=', strtotime($conditions['start_date']));
                });
            }
            if (!empty($conditions['end_date'])) {
                $listRecord = $listRecord->where(function ($query) use ($conditions) {
                    return $query
                        ->where(Model::START_DATE, '<=', strtotime($conditions['end_date']))
                        ->where(Model::END_DATE, '>=', strtotime($conditions['end_date']));
                });
            }
        }
        
        return $listRecord
            ->orderBy(Model::START_DATE, 'DESC')
            ->paginate($limit);

    }
}
