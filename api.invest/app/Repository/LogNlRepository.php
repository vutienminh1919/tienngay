<?php


namespace App\Repository;


use App\Models\LogNL;

class LogNlRepository extends BaseRepository implements LogNlRepositoryInterface
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogNL::class;
    }
}
