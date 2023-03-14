<?php


namespace App\Repository;


use App\Models\Log_vbee_ndt;

class LogVbeeNdtRepository extends BaseRepository
{

    public function getModel()
    {
        return Log_vbee_ndt::class;
    }


}
