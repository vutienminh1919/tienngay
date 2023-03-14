<?php


namespace Modules\AssetLocation\Http\Service;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Modules\AssetLocation\Http\Repository\ContractRepository;
use Modules\AssetLocation\Http\Repository\DeviceRepository;
use Modules\AssetLocation\Http\Repository\LogWarehouseAssetRepository;
use Modules\AssetLocation\Http\Repository\ReportRepository;
use Modules\AssetLocation\Http\Repository\StoreRepository;
use Modules\AssetLocation\Http\Repository\WarehouseRepository;
use Modules\AssetLocation\Model\Contract;
use Modules\AssetLocation\Model\Device;
use Modules\AssetLocation\Model\LogWarehouseAsset;
use Modules\AssetLocation\Model\Warehouse;

class WarehouseService extends BaseService
{
    protected $warehouseRepository;
    protected $storeRepository;
    protected $deviceRepository;
    protected $reportRepository;
    protected $contractRepository;
    protected $logWarehouseAssetRepository;

    public function __construct(WarehouseRepository $warehouseRepository,
                                StoreRepository $storeRepository,
                                DeviceRepository $deviceRepository,
                                ReportRepository $reportRepository,
                                ContractRepository $contractRepository,
                                LogWarehouseAssetRepository $logWarehouseAssetRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
        $this->storeRepository = $storeRepository;
        $this->deviceRepository = $deviceRepository;
        $this->reportRepository = $reportRepository;
        $this->contractRepository = $contractRepository;
        $this->logWarehouseAssetRepository = $logWarehouseAssetRepository;
    }

    public function create_warehouse_pgd($request)
    {
        $store = $this->storeRepository->find($request->store_id);
        $data = [
            Warehouse::STATUS => Warehouse::ACTIVE,
            Warehouse::NAME => $store['name'],
            Warehouse::SLUG => slugify($store['name']),
            Warehouse::STORE_ID => $store['_id'],
            Warehouse::CREATED_AT => Carbon::now()->unix(),
            Warehouse::CREATED_BY => $request->user->email,
            Warehouse::LEVEL => 3,
        ];
        return $this->warehouseRepository->create($data);

    }

    public function validate_create($request)
    {
        $message = [];
        if (empty($request->store_id)) {
            $message[] = 'Phòng giao dịch không để trống';
        }

        $store = $this->storeRepository->find($request->store_id);
        if (!$store) {
            $message[] = 'Phòng giao dịch không tồn tại';
        }

        $warehouse = $this->warehouseRepository->findOne(['store_id' => $request->store_id]);
        if ($warehouse) {
            $message[] = 'Kho đã tồn tại';
        }

        return $message;
    }

    public function validate_create_general($request)
    {
        $message = [];
        if (empty($request->level)) {
            $message[] = 'Cấp kho không để trống';
        }

        if (empty($request->name)) {
            $message[] = 'Tên kho không để trống';
        }

        $warehouse = $this->warehouseRepository->findOne(['slug' => slugify($request->name)]);
        if ($warehouse) {
            $message[] = 'Kho đã tồn tại';
        }

        return $message;
    }

    public function create_warehouse_general($request)
    {
        $data = [
            Warehouse::STATUS => Warehouse::ACTIVE,
            Warehouse::NAME => $request->name,
            Warehouse::SLUG => slugify($request->name),
            Warehouse::CREATED_AT => Carbon::now()->unix(),
            Warehouse::CREATED_BY => $request->user->email,
            Warehouse::LEVEL => (int)$request->level,
        ];
        return $this->warehouseRepository->create($data);
    }

    public function list()
    {
        return $this->warehouseRepository->getAll();
    }

    public function report_warehouse()
    {
        $warehouses = $this->warehouseRepository->getAll();
        foreach ($warehouses as $warehouse) {
            $report = $this->reportRepository->findOne(['month' => date('Y-m'), 'warehouse_asset_location_id' => $warehouse['_id']]);
            $start_date = Carbon::now()->firstOfMonth()->format('Y-m-d 00:00:00');
            $end_date = Carbon::now()->lastOfMonth()->format('Y-m-d 23:59:59');
            $ton = $this->deviceRepository->ton($warehouse['_id'], 'count', [Device::NEW]);
            $total_ton = $this->deviceRepository->ton($warehouse['_id'], 'sum', [Device::NEW]);
            $nhap = $this->deviceRepository->nhap($warehouse['_id'], strtotime($start_date), strtotime($end_date), 'count', [Device::NEW, Device::OLD, Device::ACTIVE]);
            $total_nhap = $this->deviceRepository->nhap($warehouse['_id'], strtotime($start_date), strtotime($end_date), 'sum', [Device::NEW, Device::OLD, Device::ACTIVE]);
            $xuat = $this->deviceRepository->xuat($warehouse['_id'], strtotime($start_date), strtotime($end_date), 'count');
            $total_xuat = $this->deviceRepository->xuat($warehouse['_id'], strtotime($start_date), strtotime($end_date), 'sum');
            if ($report) {
                $this->reportRepository->update($report['_id'], [
                    'so_luong_nhap' => $nhap,
                    'tong_tien_nhap' => $total_nhap,
                    'so_luong_xuat' => $xuat,
                    'tong_tien_xuat' => $total_xuat,
                    'so_luong_ton_cuoi_thang' => $ton,
                    'tong_tien_ton_cuoi_thang' => $total_ton,
                    'updated_at' => Carbon::now()->unix()
                ]);
            } else {
                $this->reportRepository->create([
                    'warehouse_asset_location_id' => $warehouse['_id'],
                    'month' => date('Y-m'),
                    'so_luong_ton_dau_thang' => $ton,
                    'tong_tien_ton_dau_thang' => $total_ton,
                    'so_luong_nhap' => 0,
                    'tong_tien_nhap' => 0,
                    'so_luong_xuat' => 0,
                    'tong_tien_xuat' => 0,
                    'so_luong_ton_cuoi_thang' => $ton,
                    'tong_tien_ton_cuoi_thang' => $total_ton,
                    'created_at' => Carbon::now()->unix()
                ]);
            }
        }
        return;
    }

    public function contract_disbursement($request)
    {
        try {
            $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
            $device = $this->deviceRepository->findOne([Device::CODE => $contract['loan_infor']['device_asset_location']['code']]);
            $total_device_new = $this->deviceRepository->count([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $device['warehouse_asset_location']['id']]);
            $device_new = $this->deviceRepository->findOne([Device::STATUS => Device::NEW]);
            if ($device && $device['status'] == Device::NEW) {
                $this->logWarehouseAssetRepository->create([
                    'warehouse' => $device['warehouse_asset_location'],
                    'date' => Carbon::now()->format('Y-m-d'),
                    'created_at' => Carbon::now()->unix(),
                    'type' => LogWarehouseAsset::XUAT_BAN_GIAO_MOI,
                    'partner' => $device['partner_asset_location'],
                    'so_luong_xuat' => 1,
                    'don_gia_xuat' => $device['stock_price'] ?? 0,
                    'so_luong_ton' => $total_device_new > 0 ? (int)$total_device_new : 0,
                    'don_gia_ton' => $total_device_new > 0 ? $device_new['stock_price'] : 0,
                    'don_gia_ton_moi' => $total_device_new > 0 ? $device_new['stock_price'] : 0,
                    'so_luong_ton_moi' => $total_device_new > 0 ? (int)$total_device_new - 1 : 0,
                    'code_contract'=> $contract['code_contract'],
                    'code_contract_disbursement'=> $contract['code_contract_disbursement'],
                    'imei'=> $device['code'],
                ]);
            } elseif ($device && $device['status'] == Device::OLD) {
                $this->logWarehouseAssetRepository->create([
                    'warehouse' => $device['warehouse_asset_location'],
                    'date' => Carbon::now()->format('Y-m-d'),
                    'created_at' => Carbon::now()->unix(),
                    'type' => LogWarehouseAsset::XUAT_BAN_GIAO_CU,
                    'partner' => $device['partner_asset_location'],
                    'so_luong_xuat' => 1,
                    'don_gia_xuat' => $device['stock_price'] ?? 0,
                    'so_luong_ton' => $total_device_new > 0 ? (int)$total_device_new : 0,
                    'don_gia_ton' => $total_device_new > 0 ? $device_new['stock_price'] : 0,
                    'so_luong_ton_moi' => $total_device_new > 0 ? (int)$total_device_new : 0,
                    'don_gia_ton_moi' => $total_device_new > 0 ? $device_new['stock_price'] : 0,
                    'code_contract'=> $contract['code_contract'],
                    'code_contract_disbursement'=> $contract['code_contract_disbursement'],
                    'imei'=> $device['code'],
                ]);
            }
        } catch (\Exception $exception) {
            $error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            $message = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Cron: ' . '"<b>' . 'WarehouseService/contract_disbursement' . '</b>"' . "\n" .
                'Phát sinh lỗi: ' . '"<b>' . json_encode($error) . '</b>"' . "\n" .
                'IP: ' . '"<b>' . $request->ip() . '</b>"';
            Telegram::send($message);
        }
        return;
    }

    public function warehouse_local($request)
    {
        $warehouses = $this->warehouseRepository->findManySortColumn([Warehouse::STATUS => Warehouse::ACTIVE], Warehouse::LEVEL, self::ASC);
        foreach ($warehouses as $warehouse) {
            $warehouse['total'] = $this->deviceRepository->count([Device::WAREHOUSE_ASSET_LOCATION_ID => $warehouse['_id']]);
            $warehouse['total_active'] = $this->deviceRepository->count([Device::WAREHOUSE_ASSET_LOCATION_ID => $warehouse['_id'], Device::STATUS => Device::ACTIVE]);
            $warehouse['total_new'] = $this->deviceRepository->count([Device::WAREHOUSE_ASSET_LOCATION_ID => $warehouse['_id'], Device::STATUS => Device::NEW]);
            $warehouse['total_old'] = $this->deviceRepository->count([Device::WAREHOUSE_ASSET_LOCATION_ID => $warehouse['_id'], Device::STATUS => Device::OLD]);
            $warehouse['total_broken'] = $this->deviceRepository->count([Device::WAREHOUSE_ASSET_LOCATION_ID => $warehouse['_id'], Device::STATUS => Device::BROKEN]);
        }
        return $warehouses;
    }

    public function detail($request)
    {
        $data = [];
        $data['warehouse'] = [];
        $data['devices'] = [];
        $warehouse = $this->warehouseRepository->find($request->id);
        if ($warehouse) {
            $data['warehouse'] = $warehouse;
            $devices = $this->deviceRepository->get_device_by_warehouse($request);
            foreach ($devices as $device) {
                if ($device['status'] == Device::ACTIVE) {
                    $contract = $this->contractRepository->find_contract_active($device['_id']);
                    if ($contract) {
                        $device['contract'] = $contract;
                    }
                }
            }
            $data['devices'] = $devices;
        }
        return $data;

    }

    public function history($request)
    {
        $data = [];
        $data['history'] = $this->logWarehouseAssetRepository->history($request, $request->type_query);
        $data['total'] = $this->logWarehouseAssetRepository->history($request, 'total');
        return $data;
    }

    public function backup($request)
    {
        $logs = $this->logWarehouseAssetRepository->findMany(['type' => LogWarehouseAsset::XUAT_BAN_GIAO_MOI]);
        foreach ($logs as $log) {
            $so_luong_ton_moi = $log['so_luong_ton_moi'];
            $so_luong_ton = $log['so_luong_ton'];
            $this->logWarehouseAssetRepository->update($log['_id'], [
                'so_luong_ton' => $so_luong_ton + 1,
                'so_luong_ton_moi' => $so_luong_ton_moi + 1,
            ]);
        }
        return;
    }

    public function view_all($request)
    {
        $data = [];
        $data['all'] = $this->deviceRepository->count();
        $data['active'] = $this->deviceRepository->count([Device::STATUS => Device::ACTIVE]);
        $data['new'] = $this->deviceRepository->count([Device::STATUS => Device::NEW]);
        $data['old'] = $this->deviceRepository->count([Device::STATUS => Device::OLD]);
        return $data;
    }

}
