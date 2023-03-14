<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\LogMenuAsset;

class LogMenuAssetRepository extends BaseRepository
{
    public function getModel()
    {
        return LogMenuAsset::class;
    }
}
