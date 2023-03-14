<?php


namespace Modules\AssetLocation\Http\Controllers;


use Illuminate\Http\Request;
use Modules\AssetLocation\Http\Repository\AccountVsetRepository;
use Modules\AssetLocation\Http\Service\AccountVsetService;
use Modules\AssetLocation\Http\Service\DeviceService;
use Modules\AssetLocation\Http\Service\LogAlarmService;
use Modules\AssetLocation\Http\Service\Vsetcomgps;
use Modules\AssetLocation\Model\Account_vset;

class DeviceController extends BaseController
{
    protected $deviceService;
    protected $vsetcomgps;
    protected $accountVsetService;
    protected $logAlarmService;

    public function __construct(DeviceService $deviceService,
                                Vsetcomgps $vsetcomgps,
                                AccountVsetService $accountVsetService,
                                LogAlarmService $logAlarmService,
                                AccountVsetRepository $accountVsetRepository)
    {
        $this->deviceService = $deviceService;
        $this->vsetcomgps = $vsetcomgps;
        $this->accountVsetService = $accountVsetService;
        $this->logAlarmService = $logAlarmService;
        $this->accountVsetRepository = $accountVsetRepository;
    }

    public function import_device(Request $request)
    {
        $data = $this->deviceService->import_create($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    public function miles(Request $request)
    {
        $acc = $this->accountVsetRepository->findOne([Account_vset::APP_ID => env('VSET_APPID')]);
        $data = $this->vsetcomgps->miles($acc['access_token'], $request->imei);
        if ($data && $data->code == 0) {
            return BaseController::send_response(self::HTTP_OK, Vsetcomgps::error_code($data->code), $data);
        } else {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, !empty($data->code) ? Vsetcomgps::error_code($data->code) : self::FAIL);
        }
    }

    public function auth_vset()
    {
        $data = $this->accountVsetService->auth();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);

    }

    public function location(Request $request)
    {
        $acc = $this->accountVsetRepository->findOne([Account_vset::APP_ID => env('VSET_APPID')]);
        $data = $this->vsetcomgps->location($acc['access_token'], $request->imei);
        if ($data && $data->code == 0) {
            return BaseController::send_response(self::HTTP_OK, Vsetcomgps::error_code($data->code), $data);
        } else {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, !empty($data->code) ? Vsetcomgps::error_code($data->code) : self::FAIL);
        }
    }

    public function check_status_device_active()
    {
        $this->deviceService->check_status_device_active();
        return;
    }

    public function alarm(Request $request)
    {
        $this->logAlarmService->create($request);
        return BaseController::send_response(self::HTTP_OK, 'success');
    }

    public function detail(Request $request)
    {
        $data = $this->deviceService->detail($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function calculate_stock_price(Request $request)
    {
        $data = $this->deviceService->calculate_stock_price($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function check_import_device(Request $request)
    {
        $validate = $this->deviceService->validate_import_device($request);
        if (count($validate) > 0) {
            return BaseController::send_response(self::HTTP_OK, $validate[0], $request->key);
        }
    }

    public function transfer(Request $request)
    {
        $data = $this->deviceService->transfer($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    public function check_transfer(Request $request)
    {
        $validate = $this->deviceService->check_transfer($request);
        if (count($validate) > 0) {
            return BaseController::send_response(self::HTTP_OK, $validate[0], $request->key);
        }
    }

    public function import_old(Request $request)
    {
        $data = $this->deviceService->import_old($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    public function check_import_old(Request $request)
    {
        $validate = $this->deviceService->check_import_old($request);
        if (count($validate) > 0) {
            return BaseController::send_response(self::HTTP_OK, $validate[0], $request->key);
        }
    }

    public function all_device(Request $request)
    {
        $data = $this->deviceService->all_device($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

}
