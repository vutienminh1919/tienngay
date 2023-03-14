<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\RoleAsset;

class RoleRepository extends BaseRepository
{
    public function getModel()
    {
        return RoleAsset::class;
    }
}
