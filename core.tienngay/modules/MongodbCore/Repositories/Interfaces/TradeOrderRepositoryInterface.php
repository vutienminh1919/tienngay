<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface TradeOrderRepositoryInterface
{

    /**
     * Store new data into collection
     * @param $attr array
     * @return collection
     * */
    public function store($attr);
}
