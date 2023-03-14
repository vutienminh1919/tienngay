<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Partner;

class PartnerRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Partner::class;
    }
}
