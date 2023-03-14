<?php


namespace Modules\AssetLocation\Http\Controllers;


use Illuminate\Http\Request;
use Modules\AssetLocation\Http\Service\CityService;
use Modules\AssetLocation\Http\Service\DistrictService;
use Modules\AssetLocation\Http\Service\WardService;

class AddressController extends BaseController
{
    public $cityService;
    public $districtService;
    public $wardService;

    public function __construct(CityService $cityService,
                                DistrictService $districtService,
                                WardService $wardService)
    {
        $this->cityService = $cityService;
        $this->districtService = $districtService;
        $this->wardService = $wardService;
    }

    public function city(Request $request)
    {
        $data = $this->cityService->city();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function district(Request $request)
    {
        $data = $this->districtService->district($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function ward(Request $request)
    {
        $data = $this->wardService->ward($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

}
