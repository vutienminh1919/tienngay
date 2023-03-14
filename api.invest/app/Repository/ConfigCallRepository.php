<?php


namespace App\Repository;


use App\Models\ConfigCall;

class ConfigCallRepository extends BaseRepository implements ConfigCallRepositoryInterface
{
    public function getModel()
    {
        return ConfigCall::class;
    }
}
