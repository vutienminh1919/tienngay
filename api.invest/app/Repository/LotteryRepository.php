<?php


namespace App\Repository;


use App\Models\Lottery;

class LotteryRepository extends BaseRepository implements LotteryRepositoryInterface
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Lottery::class;
    }
}
