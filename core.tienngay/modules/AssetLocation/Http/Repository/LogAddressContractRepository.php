<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\LogAddressContract;

class LogAddressContractRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogAddressContract::class;
    }
}
