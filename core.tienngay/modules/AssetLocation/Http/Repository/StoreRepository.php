<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Store;

class StoreRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Store::class;
    }
}
