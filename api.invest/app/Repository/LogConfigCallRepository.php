<?php


namespace App\Repository;


use App\Models\LogConfigCall;

class LogConfigCallRepository extends BaseRepository implements LogConfigCallRepositoryInterface
{
    public function getModel()
    {
        return LogConfigCall::class;
    }
}
