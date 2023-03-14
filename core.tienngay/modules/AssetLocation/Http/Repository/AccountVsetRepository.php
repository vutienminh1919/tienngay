<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Account_vset;

class AccountVsetRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Account_vset::class;
    }
}
