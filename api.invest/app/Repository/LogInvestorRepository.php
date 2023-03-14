<?php


namespace App\Repository;


use App\Models\LogInvestor;

class LogInvestorRepository extends BaseRepository implements LogInvestorRepositoryInterface
{
    public function getModel()
    {
        return LogInvestor::class;
    }
}
