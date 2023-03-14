<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface PaymentHolidayRepositoryInterface
{

    /**
     * Store new payment holidays data into collection
     * @param $attr array
     * @return collection
     * */
    public function store($attr);

    /**
     * Update payment holidays
     * @param $id string, $arr Array
     * @return boolean
     * */
    public function update($id, $arr);

    /**
     * get data by conditions
     * @param $conditions Array
     * @return collection
     * */
    public function index($conditions, $limit);
}
