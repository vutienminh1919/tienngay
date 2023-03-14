<?php


namespace Modules\AssetLocation\Http\Service;

use Carbon\Carbon;
use Modules\AssetLocation\Http\Repository\AccountVsetRepository;
use Modules\AssetLocation\Http\Repository\ContractRepository;
use Modules\AssetLocation\Http\Repository\DeviceRepository;
use Modules\AssetLocation\Http\Repository\LogDeviceContractRepository;
use Modules\AssetLocation\Http\Repository\LogStockPriceRepository;
use Modules\AssetLocation\Http\Repository\LogWarehouseAssetRepository;
use Modules\AssetLocation\Http\Repository\PartnerRepository;
use Modules\AssetLocation\Http\Repository\WarehouseRepository;
use Modules\AssetLocation\Model\Account_vset;
use Modules\AssetLocation\Model\Contract;
use Modules\AssetLocation\Model\Device;
use Modules\AssetLocation\Model\LogDevice;
use Modules\AssetLocation\Model\LogDeviceContract;
use Modules\AssetLocation\Model\LogWarehouseAsset;

class DeviceService extends BaseService
{
    protected $deviceRepository;
    protected $warehouseRepository;
    protected $partnerRepository;
    protected $logDeviceService;
    protected $vset;
    protected $contractRepository;
    protected $logDeviceContractRepository;
    protected $accountVsetRepository;
    protected $logWarehouseAssetService;
    protected $logWarehouseAssetRepository;
    protected $logStockPriceRepository;

    public function __construct(DeviceRepository $deviceRepository,
                                WarehouseRepository $warehouseRepository,
                                PartnerRepository $partnerRepository,
                                LogDeviceService $logDeviceService,
                                Vsetcomgps $vsetcomgps,
                                ContractRepository $contractRepository,
                                LogDeviceContractRepository $logDeviceContractRepository,
                                AccountVsetRepository $accountVsetRepository,
                                LogWarehouseAssetService $logWarehouseAssetService,
                                LogWarehouseAssetRepository $logWarehouseAssetRepository,
                                LogStockPriceRepository $logStockPriceRepository)
    {
        $this->deviceRepository = $deviceRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->partnerRepository = $partnerRepository;
        $this->logDeviceService = $logDeviceService;
        $this->vset = $vsetcomgps;
        $this->contractRepository = $contractRepository;
        $this->logDeviceContractRepository = $logDeviceContractRepository;
        $this->accountVsetRepository = $accountVsetRepository;
        $this->logWarehouseAssetService = $logWarehouseAssetService;
        $this->logWarehouseAssetRepository = $logWarehouseAssetRepository;
        $this->logStockPriceRepository = $logStockPriceRepository;
    }

    public function validate_import_device($request)
    {
        $message = [];

        if (empty($request->partner)) {
            $message[] = "Nhà cung cấp không để trống";
        }

        if (empty($request->type)) {
            $message[] = "Loại giao dịch không để trống";
        } else {
            if ($request->type == 2) {
                if (empty($request->warehouse_export)) {
                    $message[] = "Kho xuất không để trống";
                    return $message;
                }
            }
        }

        if (empty($request->warehouse_import)) {
            $message[] = "Kho nhập không để trống";
        }

        if (empty($request->date_import)) {
            $message[] = "Ngày nhập không để trống";
        } else {
            $arr = explode('-', $request->date_import);
            if (!empty($arr[0]) && !empty($arr[1]) && !empty($arr[2])) {
                if (!checkdate($arr[1], $arr[2], $arr[0])) {
                    $message[] = "Ngày nhập không đúng đinh dạng, example: YYYY-mm-dd";
                    return $message;
                }
            } else {
                $message[] = "Ngày nhập không đúng đinh dạng, example: YYYY-mm-dd";
                return $message;
            }
        }

        if (empty($request->seri)) {
            $message[] = "Mã thiết bị không để trống";
        } else {
            $device = $this->deviceRepository->findOne(['code' => $request->seri]);
            if ($device) {
                $message[] = "Mã thiết bị đã tồn tại";
                return $message;
            }
        }

        if (empty($request->price)) {
            $message[] = "Giá thiết bị không để trống";
        }

        return $message;
    }

    public function import_device($request)
    {
        if ($request->type == 1) {
            $device = $this->import_create($request);
            return $device;
        } elseif ($request->type == 2) {
            $device = $this->transfer($request);
            return $device;
        } elseif ($request->type == 3) {

        }

    }

    public function import_create($request)
    {
        $warehouse = $this->warehouseRepository->find($request->warehouse_import);
        $partner = $this->partnerRepository->find($request->partner);
        $data = [
            Device::NAME => $partner['name'],
            Device::CODE => $request->seri,
            Device::STATUS => Device::NEW,
            Device::IMPORT_PRICE => (int)$request->price,
            Device::SIM_CARD_FEES => (int)$request->fees,
            Device::NUMBER_SIM_CARD => (int)$request->number_sim,
            Device::STORAGE_DATE => strtotime($request->date_import),
            Device::WAREHOUSE_ASSET_LOCATION => [
                'id' => $warehouse['_id'],
                'name' => $warehouse['name'],
                'store_id' => $warehouse['store_id'] ?? ""
            ],
            Device::PARTNER_ASSET_LOCATION => [
                'id' => $partner['_id'],
                'name' => $partner['name']
            ],
            Device::CREATED_AT => Carbon::now()->unix(),
            Device::CREATED_BY => $request->user->email ?? "",
            Device::STOCK_PRICE => (int)$request->stock_price
        ];
        $device = $this->deviceRepository->create($data);
        $this->logDeviceService->create([], $device, LogDevice::NEW_IMPORT, $request);
        if ($request->key == $request->last) {
            $device_warehouse_import = $this->deviceRepository->findMany([Device::STATUS => Device::NEW]);
            foreach ($device_warehouse_import as $value) {
                if ($value['stock_price'] != $request->stock_price && $value['status'] == Device::NEW) {
                    $device_old = $this->deviceRepository->find($value['_id']);
                    $device_new = $this->deviceRepository->update($value['_id'], [Device::STOCK_PRICE => (int)$request->stock_price, Device::UPDATED_AT => Carbon::now()->unix()]);
                    $this->logDeviceService->create($device_old, $device_new, LogDevice::UPDATE_STOCK, $request);
                }
            }

            $this->logWarehouseAssetRepository->create([
                'warehouse' => $warehouse,
                'date' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now()->unix(),
                'type' => LogWarehouseAsset::NHAP_KHO_MOI,
                'partner' => $partner,
                'so_luong_nhap' => (int)$request->last - 1,
                'don_gia_nhap' => (int)$request->price,
                'so_luong_ton' => (int)$request->total_new_stock ?? 0,
                'don_gia_ton' => (int)$request->stock_price_old ?? 0,
                'don_gia_ton_moi' => (int)$request->stock_price,
                'so_luong_ton_moi' => (int)$request->last - 1 + (int)$request->total_new_stock,
                'created_by' => $request->user->email ?? ""
            ]);

            $this->logStockPriceRepository->create([
                'so_luong_nhap' => (int)$request->last - 1,
                'don_gia_nhap' => (int)$request->price,
                'so_luong_ton_cu' => (int)$request->total_all_new_stock ?? 0,
                'don_gia_ton_cu' => (int)$request->stock_price_old ?? 0,
                'don_gia_ton_moi' => (int)$request->stock_price,
                'so_luong_ton_moi' => (int)$request->last - 1 + ((int)$request->total_all_new_stock ?? 0),
                'date' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now()->unix(),
                'created_by' => $request->user->email ?? ""
            ]);

        }
        return $device;
    }

    public function check_status_device_active()
    {
        $devices = $this->deviceRepository->findMany([Device::STATUS => Device::ACTIVE]);
        $acc = $this->accountVsetRepository->findOne([Account_vset::APP_ID => env('VSET_APPID')]);
        foreach ($devices as $device) {
            if (!empty($device['code'])) {
                $data = $this->vset->miles($acc['access_token'], $device['code']);
                if (!empty($data) && $data->code == 0) {
                    $this->deviceRepository->update($device['_id'], [
                        Device::STATUS_LOCATION => !empty($data->data[0]->status) ? Vsetcomgps::const_status($data->data[0]->status) : 0,
                        Device::DATA_STATUS_LOCATION => !empty($data->data[0]->status) ? $data->data[0] : null,
                        Device::UPDATED_AT => Carbon::now()->unix()
                    ]);
                    $contract = $this->contractRepository->find_contract_active($device['_id']);
                    $this->contractRepository->update($contract['_id'], [
                        'device_asset_location_status' => !empty($data->data[0]->status) ? Vsetcomgps::const_status($data->data[0]->status) : 0
                    ]);
                }
//                else {
//                    $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
//                        'Client: ' . env('APP_ENV') . "\n" .
//                        'Nội dung: ' . '"<b>' . 'Không lấy được thông tin thiết bị định vị VSET, IMEI ' . $device['code'] . '-------' . json_encode($data) . '</b>"';
//                    Telegram::send($message_new);
//                }
            }
        }
        return;
    }

    public function detail($request)
    {
        $data = [];
        $data['device'] = $this->deviceRepository->findOne([Device::CODE => $request->seri]);
        $data['log_contract'] = $this->logDeviceContractRepository->findManySortColumn(
            [
                'device_asset_location.code' => $request->seri
            ],
            LogDeviceContract::CREATED_AT,
            self::DESC
        );
        foreach ($data['log_contract'] as $datum) {
            $datum['contract'] = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $datum['code_contract']]);
        }
        return $data;
    }

    public function calculate_stock_price($request)
    {
        $data = [];
        $total_new_stock = $this->deviceRepository->get_total_new_stock($request->warehouse_import);
        $total_all_new_stock = $this->deviceRepository->get_total_all_new_stock();
        $total_price_new_stock = $this->deviceRepository->get_total_price_new_stock($request->warehouse_import);
        $total_all_price_new_stock = $this->deviceRepository->get_total_all_price_new_stock();
        $current_device = $this->deviceRepository->findOne([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $request->warehouse_import]);
        $data['total_new_stock'] = $total_new_stock;
        $data['total_all_new_stock'] = $total_all_new_stock;
        $data['stock_price_old'] = !empty($current_device) ? $current_device['stock_price'] : 0;
        if ($request->total_import_new == 0) {
            $stock_price = 0;
        } else {
            $stock_price = ($request->total_price_import_new + $total_all_price_new_stock) / ($request->total_import_new + $total_all_new_stock);
        }
        $data['stock_price'] = floor($stock_price);
        return $data;

    }

    public function transfer($request)
    {
        $warehouse_import = $this->warehouseRepository->find($request->warehouse_import);
        $warehouse_export = $this->warehouseRepository->find($request->warehouse_export);
        $partner = $this->partnerRepository->find($request->partner);
        $device = $this->deviceRepository->findOne([Device::CODE => $request->seri]);
        if ($device) {
            if ($device['warehouse_asset_location']['id'] != $warehouse_import['_id']) {
                $device_new = $this->deviceRepository->update($device['_id'], [
                    'warehouse_asset_location' => [
                        'id' => $warehouse_import['_id'],
                        'name' => $warehouse_import['name'],
                        'store_id' => $warehouse_import['store_id'] ?? ""
                    ],
                    'transfer' => true,
//                    'storage_date' => strtotime($request->date_import),
                    'updated_at' => Carbon::now()->unix(),
                    'transfer_date' => strtotime($request->date_import),
                ]);
                $this->logDeviceService->create($device->attributesToArray(), $device_new, LogDevice::TRANSFER, $request);
            }


            if ($request->key == $request->last) {
                $so_luong_ton_kho_chuyen = $this->deviceRepository->count([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $request->warehouse_export]);
                $this->logWarehouseAssetRepository->create([
                    'warehouse' => $warehouse_export,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'created_at' => Carbon::now()->unix(),
                    'type' => LogWarehouseAsset::DIEU_CHUYEN_KHO_XUAT,
                    'partner' => $device['partner'],
                    'so_luong_chuyen' => (int)$request->last - 1,
                    'don_gia_chuyen' => !empty($device) ? $device['stock_price'] : 0,
                    'so_luong_ton' => $so_luong_ton_kho_chuyen + (int)$request->last - 1,
                    'don_gia_ton' => !empty($device) ? $device['stock_price'] : 0,
                    'don_gia_ton_moi' => !empty($device) ? $device['stock_price'] : 0,
                    'so_luong_ton_moi' => $so_luong_ton_kho_chuyen,
                    'created_by' => $request->user->email ?? ""
                ]);

                $so_luong_ton_kho_nhan = $this->deviceRepository->count([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $request->warehouse_import]);
                $so_luong_ton_kho_nhan_truoc_chuyen = $so_luong_ton_kho_nhan - ((int)$request->last - 1);
                $this->logWarehouseAssetRepository->create([
                    'warehouse' => $warehouse_import,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'created_at' => Carbon::now()->unix(),
                    'type' => LogWarehouseAsset::DIEU_CHUYEN_KHO_NHAP,
                    'partner' => $device['partner'],
                    'so_luong_chuyen' => (int)$request->last - 1,
                    'don_gia_chuyen' => !empty($device) ? $device['stock_price'] : 0,
                    'so_luong_ton' => $so_luong_ton_kho_nhan_truoc_chuyen > 0 ? $so_luong_ton_kho_nhan_truoc_chuyen : 0,
                    'don_gia_ton' => !empty($device) ? $device['stock_price'] : 0,
                    'don_gia_ton_moi' => !empty($device) ? $device['stock_price'] : 0,
                    'so_luong_ton_moi' => $so_luong_ton_kho_nhan,
                    'created_by' => $request->user->email ?? ""
                ]);
            }
        }
        return $device;

    }

    public function check_transfer($request)
    {
        $message = [];

        if (empty($request->warehouse_export)) {
            $message[] = "Kho chuyển không để trống";
            return $message;
        }

        if (empty($request->warehouse_import)) {
            $message[] = "Kho nhận không để trống";
            return $message;
        }

        if (empty($request->seri)) {
            $message[] = "Imei thiết bị không để trống";
            return $message;
        }

        $device = $this->deviceRepository->findOne([Device::CODE => $request->seri]);
        if (!$device) {
            $message[] = "Thiết bị không tồn tại";
            return $message;
        } else {
            if ($device['status'] == Device::ACTIVE) {
                $message[] = "Trạng thái thiết bị không hợp lệ";
                return $message;
            }
        }
        $warehouse_export = $this->warehouseRepository->find($request->warehouse_export);
        $warehouse_import = $this->warehouseRepository->find($request->warehouse_import);

        if ($device['warehouse_asset_location']['id'] != $warehouse_export['_id']) {
            $message[] = "Thiết bị không tồn tại trong kho chuyển";
        }

        if ($device['warehouse_asset_location']['id'] == $warehouse_import['_id']) {
            $message[] = "Thiết bị đã tồn tại trong kho nhận";
        }

        if (empty($request->date_import)) {
            $message[] = "Ngày nhập không để trống";
        } else {
            $arr = explode('-', $request->date_import);
            if (!empty($arr[0]) && !empty($arr[1]) && !empty($arr[2])) {
                if (!checkdate($arr[1], $arr[2], $arr[0])) {
                    $message[] = "Ngày nhập không đúng đinh dạng, example: YYYY-mm-dd";
                    return $message;
                }
            } else {
                $message[] = "Ngày nhập không đúng đinh dạng, example: YYYY-mm-dd";
                return $message;
            }
        }
        return $message;
    }

    public function import_old($request)
    {
        $warehouse = $this->warehouseRepository->find($request->warehouse_import);
        $partner = $this->partnerRepository->find($request->partner);
        $data = [
            Device::NAME => $partner['name'],
            Device::CODE => $request->seri,
            Device::STATUS => Device::OLD,
            Device::IMPORT_PRICE => (int)$request->price,
            Device::SIM_CARD_FEES => (int)$request->fees,
            Device::STORAGE_DATE => strtotime($request->date_import),
            Device::WAREHOUSE_ASSET_LOCATION => [
                'id' => $warehouse['_id'],
                'name' => $warehouse['name'],
                'store_id' => $warehouse['store_id'] ?? ""
            ],
            Device::PARTNER_ASSET_LOCATION => [
                'id' => $partner['_id'],
                'name' => $partner['name']
            ],
            Device::CREATED_AT => Carbon::now()->unix(),
            Device::CREATED_BY => $request->user->email ?? "",
            Device::STOCK_PRICE => 0,
            Device::SECONDHAND => true

        ];
        $device = $this->deviceRepository->create($data);
        $this->logDeviceService->create([], $device, LogDevice::OLD_IMPORT, $request);

        if ($request->key == $request->last) {
            $so_luong_ton_kho_nhan = $this->deviceRepository->count([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $request->warehouse_import]);
            $device_status_new = $this->deviceRepository->findOne([Device::STATUS => Device::NEW]);
            $this->logWarehouseAssetRepository->create([
                'warehouse' => $warehouse,
                'date' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now()->unix(),
                'type' => LogWarehouseAsset::NHAP_KHO_CU,
                'partner' => $partner,
                'so_luong_nhan' => (int)$request->last - 1,
                'don_gia_nhan' => 0,
                'so_luong_ton' => $so_luong_ton_kho_nhan,
                'don_gia_ton' => !empty($device_status_new) ? $device_status_new['stock_price'] : 0,
                'don_gia_ton_moi' => !empty($device_status_new) ? $device_status_new['stock_price'] : 0,
                'so_luong_ton_moi' => $so_luong_ton_kho_nhan,
                'created_by' => $request->user->email ?? ""
            ]);
        }
        return $device;
    }

    public function check_import_old($request)
    {
        $message = [];

        if (empty($request->partner)) {
            $message[] = "Nhà cung cấp không để trống";
        }

        if (empty($request->type)) {
            $message[] = "Loại giao dịch không để trống";
        } else {
            if ($request->type == 2) {
                if (empty($request->warehouse_export)) {
                    $message[] = "Kho xuất không để trống";
                    return $message;
                }
            }
        }

        if (empty($request->warehouse_import)) {
            $message[] = "Kho nhập không để trống";
        }

        if (empty($request->date_import)) {
            $message[] = "Ngày nhập không để trống";
        } else {
            $arr = explode('-', $request->date_import);
            if (!empty($arr[0]) && !empty($arr[1]) && !empty($arr[2])) {
                if (!checkdate($arr[1], $arr[2], $arr[0])) {
                    $message[] = "Ngày nhập không đúng đinh dạng, example: YYYY-mm-dd";
                    return $message;
                }
            } else {
                $message[] = "Ngày nhập không đúng đinh dạng, example: YYYY-mm-dd";
                return $message;
            }
        }

        if (empty($request->seri)) {
            $message[] = "Mã thiết bị không để trống";
        } else {
            $device = $this->deviceRepository->findOne(['code' => $request->seri]);
            if ($device) {
                $message[] = "Mã thiết bị đã tồn tại";
                return $message;
            }
        }

        if (empty($request->price)) {
            $message[] = "Giá thiết bị không để trống";
        }

        return $message;
    }

    public function all_device($request)
    {
        $devices = $this->deviceRepository->getAll();
        foreach ($devices as $device) {
            if ($device['status'] == Device::ACTIVE) {
                $contract = $this->contractRepository->find_contract_active($device['_id']);
                if ($contract) {
                    $device['contract'] = $contract;
                }
            }
        }
        return $devices;
    }
}
