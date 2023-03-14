<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Ward;

class WardRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Ward::class;
    }
}
