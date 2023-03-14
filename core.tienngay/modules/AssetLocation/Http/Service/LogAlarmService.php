<?php


namespace Modules\AssetLocation\Http\Service;


use Carbon\Carbon;
use Modules\AssetLocation\Http\Repository\ContractRepository;
use Modules\AssetLocation\Http\Repository\DeviceRepository;
use Modules\AssetLocation\Http\Repository\LogAlarmContractRepository;
use Modules\AssetLocation\Http\Repository\LogAlarmRepository;
use Modules\AssetLocation\Http\Repository\SendEmailAlarmRepository;
use Modules\AssetLocation\Model\Contract;
use Modules\AssetLocation\Model\Device;

class LogAlarmService extends BaseService
{
    protected $logAlarmRepository;
    protected $deviceRepository;
    protected $contractRepository;
    protected $roleService;
    protected $storeService;
    protected $sendEmailAlarmRepository;
    protected $logAlarmContractRepository;

    public function __construct(LogAlarmRepository $logAlarmRepository,
                                DeviceRepository $deviceRepository,
                                ContractRepository $contractRepository,
                                RoleService $roleService,
                                StoreService $storeService,
                                SendEmailAlarmRepository $sendEmailAlarmRepository,
                                LogAlarmContractRepository $logAlarmContractRepository)
    {
        $this->logAlarmRepository = $logAlarmRepository;
        $this->deviceRepository = $deviceRepository;
        $this->contractRepository = $contractRepository;
        $this->roleService = $roleService;
        $this->storeService = $storeService;
        $this->sendEmailAlarmRepository = $sendEmailAlarmRepository;
        $this->logAlarmContractRepository = $logAlarmContractRepository;
    }

    public function create($request)
    {
        $data = $request->all();
        $this->logAlarmRepository->create([
            'data' => $data,
            'created_at' => Carbon::now()->unix()
        ]);
        foreach ($data as $datum) {
            if (!empty($datum['imei'])) {
                $device = $this->deviceRepository->findOne([Device::CODE => $datum['imei'], Device::STATUS => Device::ACTIVE]);
                if ($device) {
                    if (!empty($datum['alarmCode'])) {
                        $this->deviceRepository->update($device['_id'], [
                            Device::STATUS_ALARM => Vsetcomgps::const_alarm($datum['alarmCode']),
                            Device::DATA_ALARM => $datum
                        ]);
                        $contract = $this->contractRepository->find_contract_active($device['_id']);
                        if ($contract && $contract['status'] != 19) {
                            $this->contractRepository->update($contract['_id'], [
                                Contract::DEVICE_ASSET_LOCATION_ALARM => Vsetcomgps::const_alarm($datum['alarmCode'])
                            ]);

                            $this->logAlarmContractRepository->create([
                                'code_contract' => $contract['code_contract'],
                                'code_contract_disbursement' => $contract['code_contract_disbursement'],
                                'alarmCode' => Vsetcomgps::const_alarm($datum['alarmCode']),
                                'imei' => $datum['imei'],
                                'created_at' => Carbon::now()->unix(),
                                'data' => $datum
                            ]);
                            if (in_array($datum['alarmCode'], ['REMOVE', 'LOWVOT', 'HOME', 'REMOVECONTINUOUSLY'])) {
                                $users = $this->storeService->get_all_user_by_store($contract['store']['id']);
                                foreach ($users as $user) {
                                    $data = [
                                        'status' => 'new',
                                        'created_at' => Carbon::now()->unix(),
                                        'data_send' => [
                                            'receiver' => $user,
                                            'alarm' => Vsetcomgps::alarm($datum['alarmCode']),
                                            'imei' => $datum['imei'],
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
            }
        }
        return;
    }
}
