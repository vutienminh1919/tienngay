<?php


namespace App\Repository;


use App\Models\Rate;

class RateRepository extends BaseRepository implements RateInterfaceRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Rate::class;
    }
}
