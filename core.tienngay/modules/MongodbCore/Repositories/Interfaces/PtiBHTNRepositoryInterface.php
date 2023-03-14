<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface PtiBHTNRepositoryInterface
{

    /**
     * @param $time fomat yyyy-mm-dd
     * get list by month
     * @return collection
     */
    public function getListByMonth($time);
}
