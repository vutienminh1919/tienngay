<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\City;

class CityRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return City::class;
    }
}
