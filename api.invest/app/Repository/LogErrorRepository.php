<?php


namespace App\Repository;


use App\Models\LogError;

class LogErrorRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogError::class;
    }
}
