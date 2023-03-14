<?php


namespace App\Repository;


use App\Models\DraftNl;

class DraftNlRepository extends BaseRepository implements DraftNlRepositoryInterface
{
    public function getModel()
    {
        return DraftNl::class;
    }
}
