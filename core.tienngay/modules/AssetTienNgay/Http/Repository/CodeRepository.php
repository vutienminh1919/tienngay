<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\CodeAsset;

class CodeRepository extends BaseRepository
{
    public function getModel()
    {
        return CodeAsset::class;
    }
}
