<?php


namespace App\Repository;


use App\Models\ContractInterest;

class ContractInterestRepository extends BaseRepository implements ContractInterestRepositoryInterface
{
    public function getModel()
    {
        return ContractInterest::class;
    }
}
