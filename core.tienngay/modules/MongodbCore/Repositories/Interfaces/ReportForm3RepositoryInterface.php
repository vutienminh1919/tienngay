<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface ReportForm3RepositoryInterface
{
    /**
     * @param $time fomat yyyy-mm-dd
     * get list by month
     * @return collection
     */
    public function getListByMonth($time);
}
