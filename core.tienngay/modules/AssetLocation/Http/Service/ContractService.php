<?php


namespace Modules\AssetLocation\Http\Service;


use Carbon\Carbon;
use Modules\AssetLocation\Http\Repository\CityRepository;
use Modules\AssetLocation\Http\Repository\ContractRepository;
use Modules\AssetLocation\Http\Repository\DeviceRepository;
use Modules\AssetLocation\Http\Repository\DistrictRepository;
use Modules\AssetLocation\Http\Repository\LogAddressContractRepository;
use Modules\AssetLocation\Http\Repository\LogAlarmContractRepository;
use Modules\AssetLocation\Http\Repository\LogDeviceContractRepository;
use Modules\AssetLocation\Http\Repository\LogDeviceRepository;
use Modules\AssetLocation\Http\Repository\LogLocationAssetRepository;
use Modules\AssetLocation\Http\Repository\LogNoteRepository;
use Modules\AssetLocation\Http\Repository\LogWarehouseAssetRepository;
use Modules\AssetLocation\Http\Repository\SendEmailAlarmRepository;
use Modules\AssetLocation\Http\Repository\StoreRepository;
use Modules\AssetLocation\Http\Repository\WardRepository;
use Modules\AssetLocation\Http\Repository\WarehouseRepository;
use Modules\AssetLocation\Model\Contract;
use Modules\AssetLocation\Model\Device;
use Modules\AssetLocation\Model\LogDevice;
use Modules\AssetLocation\Model\LogWarehouseAsset;
use Modules\AssetLocation\Model\Warehouse;

class ContractService extends BaseService
{
    protected $contractRepository;
    protected $groupRoleService;
    protected $roleService;
    protected $deviceRepository;
    protected $logDeviceContractRepository;
    protected $logDeviceRepository;
    protected $logDeviceService;
    protected $warehouseRepository;
    protected $storeRepository;
    protected $logAlarmContractRepository;
    protected $storeService;
    protected $sendEmailAlarmRepository;
    protected $locationMap;
    protected $logLocationAssetRepository;
    protected $logAddressContractRepository;
    protected $cityRepository;
    protected $districtRepository;
    protected $wardRepository;
    protected $logNoteRepository;
    protected $logWarehouseAssetRepository;

    public function __construct(ContractRepository $contractRepository,
                                GroupRoleService $groupRoleService,
                                RoleService $roleService,
                                DeviceRepository $deviceRepository,
                                LogDeviceContractRepository $logDeviceContractRepository,
                                LogDeviceRepository $logDeviceRepository,
                                LogDeviceService $logDeviceService,
                                WarehouseRepository $warehouseRepository,
                                StoreRepository $storeRepository,
                                LogAlarmContractRepository $logAlarmContractRepository,
                                StoreService $storeService,
                                SendEmailAlarmRepository $sendEmailAlarmRepository,
                                LocationMap $locationMap,
                                LogLocationAssetRepository $logLocationAssetRepository,
                                LogAddressContractRepository $logAddressContractRepository,
                                CityRepository $cityRepository,
                                DistrictRepository $districtRepository,
                                WardRepository $wardRepository,
                                LogNoteRepository $logNoteRepository,
                                LogWarehouseAssetRepository $logWarehouseAssetRepository)
    {
        $this->contractRepository = $contractRepository;
        $this->groupRoleService = $groupRoleService;
        $this->roleService = $roleService;
        $this->deviceRepository = $deviceRepository;
        $this->logDeviceContractRepository = $logDeviceContractRepository;
        $this->logDeviceRepository = $logDeviceRepository;
        $this->logDeviceService = $logDeviceService;
        $this->warehouseRepository = $warehouseRepository;
        $this->storeRepository = $storeRepository;
        $this->logAlarmContractRepository = $logAlarmContractRepository;
        $this->storeService = $storeService;
        $this->sendEmailAlarmRepository = $sendEmailAlarmRepository;
        $this->locationMap = $locationMap;
        $this->logLocationAssetRepository = $logLocationAssetRepository;
        $this->logAddressContractRepository = $logAddressContractRepository;
        $this->cityRepository = $cityRepository;
        $this->districtRepository = $districtRepository;
        $this->wardRepository = $wardRepository;
        $this->logNoteRepository = $logNoteRepository;
        $this->logWarehouseAssetRepository = $logWarehouseAssetRepository;
    }

    public function asset_by_user_business($request)
    {
        $data = [];
        $groupRoles = $this->groupRoleService->getGroupRole($request->user->_id);
        if (in_array('quan-ly-khu-vuc', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
            $request->stores = $this->roleService->getStores($request->user->_id);
        } else if (in_array('giao-dich-vien', $groupRoles)) {
            $request->email = $request->user->email;
        }
        $data['contract'] = $this->contractRepository->asset_by_user_business($request, $request->type_query ?? 'get');
        foreach ($data['contract'] as $contract) {
            $log_address = $this->logAddressContractRepository->findOneSortColumn(['contract_id' => $contract['_id']], 'created_at', 'DESC');
            if ($log_address) {
                $contract['address'] = $log_address['current_address_new'];
            } else {
                $contract['address'] = $contract['current_address'];
            }

            $log_note = $this->logNoteRepository->findOneSortColumn(['contract_id' => $contract['_id']], 'created_at', 'DESC');
            if ($log_note) {
                $contract['note'] = $log_note['note'];
            } else {
                $contract['note'] = '';
            }
        }
        $data['total'] = $this->contractRepository->asset_by_user_business($request, 'total');

        $request->debt = 'active';
        $data['active'] = $this->contractRepository->asset_by_user_business($request, 'total');
        $request->debt = 'deactive';
        $data['deactive'] = $this->contractRepository->asset_by_user_business($request, 'total');

        $request->status_alarm = Device::ALARM_REMOVE;
        $data['REMOVE'] = $this->contractRepository->asset_by_user_business($request, 'alarm');
        $request->status_alarm = Device::ALARM_FENCEOUT;
        $data['FENCEOUT'] = $this->contractRepository->asset_by_user_business($request, 'alarm');
        $request->status_alarm = Device::ALARM_CRASH;
        $data['CRASH'] = $this->contractRepository->asset_by_user_business($request, 'alarm');
        $request->status_alarm = Device::ALARM_LOWVOT;
        $data['LOWVOT'] = $this->contractRepository->asset_by_user_business($request, 'alarm');
        $request->status_alarm = Device::ALARM_REMOVECONTINUOUSLY;
        $data['REMOVECONTINUOUSLY'] = $this->contractRepository->asset_by_user_business($request, 'alarm');

        return $data;
    }

    public function validate_recall_device($request)
    {
        $message = [];
        if (empty($request->code_contract)) {
            $message[] = 'Mã hợp đồng đang trống';
            return $message;
        }

        $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
        if (!$contract) {
            $message[] = 'Không tìm thấy hợp đồng';
            return $message;
        }

        return $message;
    }

    public function recall_device($request)
    {
        $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
        $this->contractRepository->update($contract['_id'], ['device_asset_location_status_recall' => true]);
        $logDeviceContract = $this->logDeviceContractRepository->findOne(['code_contract' => $request->code_contract]);
        if ($logDeviceContract) {
            $this->logDeviceContractRepository->update($logDeviceContract['_id'], [
                'recall_date' => Carbon::now()->unix(),
                'updated_at' => Carbon::now()->unix(),
                'updated_by' => $request->user->email
            ]);
        }

        $device = $this->deviceRepository->find($contract['loan_infor']['device_asset_location']['device_asset_location_id']);
        if ($device) {
            $device_new = $this->deviceRepository->update($device['_id'], [
                Device::STATUS => Device::OLD,
                Device::STOCK_PRICE => 0,
                Device::UPDATED_BY => $request->user->email
            ]);

            $so_luong_ton_kho_nhan = $this->deviceRepository->count([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $device['warehouse_asset_location']['id']]);
            $device_status_new = $this->deviceRepository->findOne([Device::STATUS => Device::NEW]);
            $this->logWarehouseAssetRepository->create([
                'warehouse' => $device['warehouse_asset_location'],
                'date' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now()->unix(),
                'type' => LogWarehouseAsset::THU_HOI_VE_KHO,
                'partner' => $device['partner_asset_location'],
                'so_luong_nhan' => 1,
                'don_gia_nhan' => 0,
                'so_luong_ton' => $so_luong_ton_kho_nhan,
                'don_gia_ton' => !empty($device_status_new) ? $device_status_new['stock_price'] : 0,
                'don_gia_ton_moi' => !empty($device_status_new) ? $device_status_new['stock_price'] : 0,
                'so_luong_ton_moi' => $so_luong_ton_kho_nhan,
                'code_contract'=> $contract['code_contract'],
                'code_contract_disbursement'=> $contract['code_contract_disbursement'],
                'imei'=> $device['code'],
            ]);
        }
        $this->logDeviceService->create($device, $device_new, LogDevice::RECALL, $request);
        return;
    }

    public function asset_by_asm_business($request)
    {
        $data = [];
        $stores = $this->roleService->getStores($request->user->_id);
        $i = 0;
        foreach ($stores as $key => $store) {
            $store_info = $this->storeRepository->find($store);
            if ($store_info) {
                $warehouse = $this->warehouseRepository->findOne([Warehouse::STORE_ID => $store]);
                if (!$warehouse) continue;
                $data['store'][$i]['id'] = $store;
                $data['store'][$i]['name'] = $store_info['name'];
                if ($warehouse) {
                    $data['store'][$i]['total_asset'] = $this->contractRepository->total_asset_contract($store, 'all');
                } else {
                    $data['store'][$i]['total_asset'] = 0;
                }
                $data['store'][$i]['active'] = $this->contractRepository->total_asset_contract($store, 'active');
                $data['store'][$i]['deactive'] = $data['store'][$i]['total_asset'] - $data['store'][$i]['active'];

                $data['store'][$i]['new'] = $this->deviceRepository->count([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $warehouse['_id']]);
                $data['store'][$i]['old'] = $this->deviceRepository->count([Device::STATUS => Device::OLD, Device::WAREHOUSE_ASSET_LOCATION_ID => $warehouse['_id']]);
                $i++;
            }
        }
        $data['total'] = [];
        $data['total']['total_asset'] = 0;
        $data['total']['active'] = 0;
        $data['total']['deactive'] = 0;
        $data['total']['new'] = 0;
        $data['total']['old'] = 0;

        if (!empty($data['store'])) {
            foreach ($data['store'] as $value) {
                $data['total']['total_asset'] += $value['total_asset'];
                $data['total']['active'] += $value['active'];
                $data['total']['deactive'] += $value['deactive'];
                $data['total']['new'] += $value['new'];
                $data['total']['old'] += $value['old'];
            }
        }
        $data['total']['REMOVE'] = $this->contractRepository->total_alarm_asset_contract($stores, Device::ALARM_REMOVE);
        $data['total']['FENCEOUT'] = $this->contractRepository->total_alarm_asset_contract($stores, Device::ALARM_FENCEOUT);
        $data['total']['CRASH'] = $this->contractRepository->total_alarm_asset_contract($stores, Device::ALARM_CRASH);
        $data['total']['LOWVOT'] = $this->contractRepository->total_alarm_asset_contract($stores, Device::ALARM_LOWVOT);
        $data['total']['REMOVECONTINUOUSLY'] = $this->contractRepository->total_alarm_asset_contract($stores, Device::ALARM_REMOVECONTINUOUSLY);
        return $data;
    }

    public function send_alarm_contract_by_product_asset_location()
    {
        $contracts = $this->contractRepository->get_contract_by_product_asset_location();
        if ($contracts) {
            foreach ($contracts as $contract) {
                $current_time = Carbon::now()->format('Y-m-d');
                $disbursement_date = date('Y-m-d', $contract['disbursement_date']);
                $date_diff = (strtotime($current_time) - strtotime($disbursement_date)) / (60 * 60 * 24);
                if (in_array($date_diff, [1, 2, 3, 4])) {
                    $date = $date_diff;
                    $alarm = "Cảnh báo hiện tại đã qua " . $date . " ngày sau giải ngân. Khách hàng chưa quay lại địa chỉ liên hệ.";
                    $logAlarm = $this->logAlarmContractRepository->log_alarm_fencein_by_contract($contract['disbursement_date'], Carbon::now()->unix(), $contract['code_contract']);
                } elseif ($date_diff >= 10 && $date_diff % 10 == 1) {
                    $date = $date_diff - 1;
                    $alarm = "Cảnh báo hiện tại trong 10 ngày gần nhất. Khách hàng chưa quay lại địa chỉ liên hệ.";
                    $logAlarm = $this->logAlarmContractRepository->log_alarm_fencein_by_contract(Carbon::now()->subDays(11)->unix(), Carbon::now()->subDay()->unix(), $contract['code_contract']);
                } else {
                    $alarm = '';
                    $logAlarm = true;
                }
                if (!$logAlarm) {
                    $users = $this->storeService->get_all_user_by_store($contract['store']['id']);
                    if ($users) {
                        foreach ($users as $user) {
                            $data = [
                                'status' => 'new',
                                'created_at' => Carbon::now()->unix(),
                                'data_send' => [
                                    'receiver' => $user,
                                    'alarm' => $alarm,
                                    'imei' => $contract['loan_infor']['device_asset_location']['code'] ?? "",
                                    'customer_name' => $contract['customer_infor']['customer_name'] ?? "",
                                    'code_contract' => $contract['code_contract_disbursement'] ?? "",
                                    'store' => $contract['store']['name'] ?? "",
                                    'time' => Carbon::now()->format('d-m-Y H:i:s'),
                                    'link' => env('DOMAIN_LMS') . 'pawn/detail?id=' . $contract['_id'],
                                    'email' => $user,
                                    "code" => "alarm_asset_location",
                                ]
                            ];
                            $this->sendEmailAlarmRepository->create($data);
                        }
                    }
                }
            }
        }
        return;
    }

    public function contract_by_product_asset_location()
    {
        $contracts = $this->contractRepository->get_contract_by_product_asset_location();
        if ($contracts) {
            foreach ($contracts as $contract) {
                $address_contract = $contract['current_address']['current_stay'] . ', '
                    . $contract['current_address']['ward_name'] . ', '
                    . $contract['current_address']['district_name'] . ', '
                    . $contract['current_address']['province_name'];
//                dd($address_contract);
                $location_address_contract = $this->locationMap->get_infor_from_address($address_contract);

                dd($location_address_contract);
            }
        }
        return;
    }

    public function validate_update_address_contract($request)
    {
        $message = [];
        if (empty($request->code_contract)) {
            $message[] = 'Mã hợp đồng đang trống';
            return $message;
        }

        $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
        if (!$contract) {
            $message[] = 'Không tìm thấy hợp đồng';
            return $message;
        }

        if (empty($request->province)) {
            $message[] = 'Tỉnh/TP đang trống';
            return $message;
        }

        if (empty($request->district)) {
            $message[] = 'Quận/Huyện đang trống';
            return $message;
        }

        if (empty($request->ward)) {
            $message[] = 'Xã/Phường đang trống';
            return $message;
        }

        if (empty($request->current_stay)) {
            $message[] = 'Nơi ở đang trống';
            return $message;
        }

        return $message;
    }

    public function update_address_contract($request)
    {
        $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
        $city = $this->cityRepository->findOne(['code' => $request->province]);
        $district = $this->districtRepository->findOne(['code' => $request->district]);
        $ward = $this->wardRepository->findOne(['code' => $request->ward]);
        $this->logAddressContractRepository->create(
            [
                'contract_id' => $contract['_id'],
                'current_address_old' => $contract['current_address'],
                'current_address_new' => [
                    'province' => $city['code'],
                    'province_name' => $city['name'],
                    'district' => $district['code'],
                    'district_name' => $district['name'],
                    'ward' => $ward['code'],
                    'ward_name' => $ward['name'],
                    'current_stay' => $request->current_stay
                ],
                'created_at' => Carbon::now()->unix(),
                'created_by' => $request->user->email
            ]
        );
        return;
    }

    public function validate_update_note_contract($request)
    {
        $message = [];
        if (empty($request->code_contract)) {
            $message[] = 'Mã hợp đồng đang trống';
            return $message;
        }

        $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
        if (!$contract) {
            $message[] = 'Không tìm thấy hợp đồng';
            return $message;
        }

        if (empty($request->note)) {
            $message[] = 'Ghi chú đang trống';
            return $message;
        }

        return $message;
    }

    public function update_note_contract($request)
    {
        $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
        $this->logNoteRepository->create([
            'contract_id' => $contract['_id'],
            'created_at' => Carbon::now()->unix(),
            'created_by' => $request->user->email,
            'note' => $request->note
        ]);
    }

    public function contract_by_collection($request)
    {
        $data = [];
        $area = $this->check_area_user_collection($request->user->email);
        if (!empty($area)) {
            $request->stores = $this->storeService->get_store_by_area($area);
        }
        $data['contracts'] = $this->contractRepository->contract_by_collection($request, $request->type_query);
        $data['total'] = $this->contractRepository->contract_by_collection($request, 'total');
        return $data;

    }

    public function check_area_user_collection($email)
    {
        $user_mb = $this->roleService->get_user_collection_mb();
        $user_mn = $this->roleService->get_user_collection_mn();
        $flag = '';
        if (in_array($email, $user_mb)) {
            $flag = 'mb';
        } elseif (in_array($email, $user_mn)) {
            $flag = 'mn';
        }
        return $flag;
    }

    public function excel_asset_by_user_business($request)
    {
        $data = [];
        $groupRoles = $this->groupRoleService->getGroupRole($request->user->_id);
        if (in_array('quan-ly-khu-vuc', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
            $request->stores = $this->roleService->getStores($request->user->_id);
        } else if (in_array('giao-dich-vien', $groupRoles)) {
            $request->email = $request->user->email;
        }
        $contracts = $this->contractRepository->asset_by_user_business($request, $request->type_query ?? 'excel');
        return $contracts;
    }

    public function recall_device_hand_over($request){

        $contract = $this->contractRepository->findOne([Contract::CODE_CONTRACT => $request->code_contract]);
        $loan_infor_new = $contract['loan_infor'];
        $loan_infor_new['device_asset_location']['handOver']['statusHandOver'] = 2;
        $this->contractRepository->update($contract['_id'], ['device_asset_location_status_recall' => true, 'loan_infor' => $loan_infor_new]);

        $logDeviceContract = $this->logDeviceContractRepository->findOne(['code_contract' => $request->code_contract]);
        if ($logDeviceContract) {
            $this->logDeviceContractRepository->update($logDeviceContract['_id'], [
                'recall_date' => Carbon::now()->unix(),
                'updated_at' => Carbon::now()->unix(),
                'updated_by' => $request->user->email
            ]);
        }

        $device = $this->deviceRepository->find($contract['loan_infor']['device_asset_location']['device_asset_location_id']);
        if ($device) {
            $device_new = $this->deviceRepository->update($device['_id'], [
                Device::STATUS => Device::OLD,
                Device::STOCK_PRICE => 0,
                Device::UPDATED_BY => $request->user->email,
                Device::WAREHOUSE_ASSET_LOCATION => ['id' => $contract['loan_infor']['device_asset_location']['handOver']['wareAssetLocation'] , 'name' => $contract['loan_infor']['device_asset_location']['handOver']['wareAssetLocationName']]
            ]);

            $so_luong_ton_kho_nhan = $this->deviceRepository->count([Device::STATUS => Device::NEW, Device::WAREHOUSE_ASSET_LOCATION_ID => $device['warehouse_asset_location']['id']]);
            $device_status_new = $this->deviceRepository->findOne([Device::STATUS => Device::NEW]);
            $this->logWarehouseAssetRepository->create([
                'warehouse' => ['id' => $contract['loan_infor']['device_asset_location']['handOver']['wareAssetLocation'] , 'name' => $contract['loan_infor']['device_asset_location']['handOver']['wareAssetLocationName']],
                'date' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now()->unix(),
                'type' => LogWarehouseAsset::THU_HOI_VE_KHO,
                'partner' => $device['partner_asset_location'],
                'so_luong_nhan' => 1,
                'don_gia_nhan' => 0,
                'so_luong_ton' => $so_luong_ton_kho_nhan,
                'don_gia_ton' => !empty($device_status_new) ? $device_status_new['stock_price'] : 0,
                'don_gia_ton_moi' => !empty($device_status_new) ? $device_status_new['stock_price'] : 0,
                'so_luong_ton_moi' => $so_luong_ton_kho_nhan,
                'code_contract'=> $contract['code_contract'],
                'code_contract_disbursement'=> $contract['code_contract_disbursement'],
                'imei'=> $device['code'],
            ]);
        }
        $this->logDeviceService->create($device, $device_new, LogDevice::RECALL, $request);
        return;

    }
}
