<?php


namespace App\Repository;


use App\Models\LogInterest;

class LogInterestRepository extends BaseRepository implements LogInterestRepositoryInterface
{
    public function getModel()
    {
        return LogInterest::class;
    }
}
