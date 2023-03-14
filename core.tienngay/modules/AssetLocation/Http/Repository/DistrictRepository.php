<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\District;

class DistrictRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return District::class;
    }
}
