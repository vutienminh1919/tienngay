<?php


namespace App\Service;


use App\Models\LogPay;
use App\Repository\LogPayRepository;
use App\Repository\LogPayRepositoryInterface;

class LogPayService extends BaseService
{
    protected $logPayRepository;

    public function __construct(LogPayRepositoryInterface $logPayRepository)
    {
        $this->logPayRepository = $logPayRepository;
    }

    public function create($request, $param, $result, $type)
    {
        $data = [
            LogPay::COLUMN_TYPE => $type,
            LogPay::COLUMN_REQUEST => json_encode($param),
            LogPay::COLUMN_RESPONSE => json_encode($result),
            LogPay::COLUMN_PAY_ID => $request->id,
            LogPay::COLUMN_CREATED_BY => current_user()->email,
        ];
        $this->logPayRepository->create($data);
    }

    public function create_log_auto($param, $result, $id, $type)
    {
        $data = [
            LogPay::COLUMN_TYPE => $type,
            LogPay::COLUMN_REQUEST => json_encode($param),
            LogPay::COLUMN_RESPONSE => json_encode($result),
            LogPay::COLUMN_PAY_ID => $id,
            LogPay::COLUMN_CREATED_BY => 'automatic system',
        ];
        $this->logPayRepository->create($data);
    }
}
