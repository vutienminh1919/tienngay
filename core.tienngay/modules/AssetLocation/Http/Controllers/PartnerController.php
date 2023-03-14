<?php


namespace Modules\AssetLocation\Http\Controllers;


use Illuminate\Http\Request;
use Modules\AssetLocation\Http\Service\PartnerService;

class PartnerController extends BaseController
{
    protected $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function create(Request $request)
    {
        $data = $this->partnerService->create($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function list(Request $request)
    {
        $data = $this->partnerService->list();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }
}
