<?php


namespace App\Repository;

use App\Models\LogCall;
class LogCallRepository extends BaseRepository implements LogCallRepositoryInterface
{
    public function getModel()
    {
        return LogCall::class;
    }
}
