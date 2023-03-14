<?php


namespace App\Service;


use App\Models\ConfigCall;
use App\Models\LogConfigCall;
use App\Repository\ConfigCallRepositoryInterface;
use App\Repository\LogConfigCallRepository;
use Illuminate\Support\Facades\Validator;

class ConfigCallService extends BaseService
{
    protected $configCallRepository;
    protected $logConfigCallRepository;

    public function __construct(ConfigCallRepositoryInterface $configCallRepository,
                                LogConfigCallRepository $logConfigCallRepository)
    {
        $this->configCallRepository = $configCallRepository;
        $this->logConfigCallRepository = $logConfigCallRepository;
    }

    public function config_call($request)
    {
        $config = $this->configCallRepository->findOne([ConfigCall::COLUMN_DATE => date('Y-m-d')]);
        if (empty($config)) {
            $data = [
                ConfigCall::COLUMN_TELESALES => $request->telesales,
                ConfigCall::COLUMN_START_TIME => $request->start_time,
                ConfigCall::COLUMN_END_TIME => $request->end_time,
                ConfigCall::COLUMN_DATE => date('Y-m-d'),
                ConfigCall::COLUMN_CREATED_BY => current_user()->email,
            ];
            $config_new = $this->configCallRepository->create($data);
            $typeLog = 'create';
        } else {
            $data = [
                ConfigCall::COLUMN_TELESALES => $request->telesales,
                ConfigCall::COLUMN_START_TIME => $request->start_time,
                ConfigCall::COLUMN_END_TIME => $request->end_time,
                ConfigCall::COLUMN_UPDATED_BY => current_user()->email,
            ];
            $config_new = $this->configCallRepository->update($config->id, $data);
            $typeLog = 'update';
        }
        $this->logConfigCallRepository->create(
            [
                LogConfigCall::COLUMN_TYPE => $typeLog,
                LogConfigCall::COLUMN_REQUEST => json_encode($data),
                LogConfigCall::COLUMN_RESPONSE => json_encode($config_new),
                LogConfigCall::COLUMN_CONFIG_CALL_ID => $config_new->id,
                LogConfigCall::COLUMN_CREATED_BY => current_user()->email
            ]
        );

    }

    public function validate_config_call($request)
    {
        $validate = Validator::make($request->all(), [
            'telesales' => 'required',
        ], [
            'telesales.required' => 'CSKH không để trống',
        ]);
        return $validate;
    }
}
