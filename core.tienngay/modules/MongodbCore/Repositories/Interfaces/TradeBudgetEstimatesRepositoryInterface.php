<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface TradeBudgetEstimatesRepositoryInterface
{

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function index($conditions, $limit);


    /**
     * Store new data into collection
     * @param $attr array
     * @return collection
     * */
    public function store($attr);

    /**
     * find collection by Id
     * @param $attr id
     * @return collection
     * */
    public function fetch($id);

    /**
     * Update progress
     * @param $attr array
     * @return collection
     * */
    public function updateProgress($id, $attr);

    /**
     * Update trade's request order
     * @param $attr array
     * @return collection
     * */
    public function update($id, $attr);

    /**
     * Delete trade's request order
     * @param $attr array
     * @return collection
     * */
    public function delete($id, $attr);

    /**
    * Write user's log
    * @param $id String: trade_order collection's Id
    * @param $log array
    * @return void
    */
    public function wlog($id, $log);
}
