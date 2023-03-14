<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\LogLocationAsset;

class LogLocationAssetRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogLocationAsset::class;
    }
}
