<?php


namespace Modules\AssetLocation\Http\Service;

use Modules\AssetLocation\Http\Repository\DistrictRepository;

class DistrictService extends BaseService
{
    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function district($request)
    {
        return $this->districtRepository->findMany(['parent_code' => $request->district]);
    }
}
