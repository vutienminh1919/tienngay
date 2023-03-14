<?php


namespace Modules\AssetLocation\Http\Service;


use Modules\AssetLocation\Http\Repository\CityRepository;

class CityService extends BaseService
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function city()
    {
        return $this->cityRepository->getAll();
    }
}
