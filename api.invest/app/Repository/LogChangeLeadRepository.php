<?php


namespace App\Repository;


use App\Models\LogChangeLead;

class LogChangeLeadRepository extends BaseRepository implements LogChangeLeadRepositoryInterface
{
    public function getModel()
    {
        return LogChangeLead::class;
    }
}
