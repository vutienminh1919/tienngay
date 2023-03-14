<?php


namespace App\Repository;


use App\Models\Logs;

class LogsRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Logs::class;
    }
}
