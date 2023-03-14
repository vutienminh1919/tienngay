<?php


namespace App\Service;


use App\Models\LogNL;
use App\Repository\LogNlRepositoryInterface;

class LogNlService extends BaseService
{
    protected $logNlRepository;

    public function __construct(LogNlRepositoryInterface $logNLRepository)
    {
        $this->logNlRepository = $logNLRepository;
    }

    public function create_payin($request, $response, $type, $order_code)
    {
        $data = [
            LogNL::COLUMN_REQUEST => json_encode($request),
            LogNL::COLUMN_RESPONSE => json_encode($response),
            LogNL::COLUMN_FLOW => LogNL::PAYIN,
            LogNL::COLUMN_TYPE => $type,
            LogNL::COLUMN_ORDER_CODE => $order_code,
        ];
        $this->logNlRepository->create($data);
    }

    public function create_payout($request, $response, $type, $order_code)
    {
        $data = [
            LogNL::COLUMN_REQUEST => json_encode($request),
            LogNL::COLUMN_RESPONSE => json_encode($response),
            LogNL::COLUMN_FLOW => LogNL::PAYOUT,
            LogNL::COLUMN_TYPE => $type,
            LogNL::COLUMN_ORDER_CODE => $order_code,
        ];
        $this->logNlRepository->create($data);
    }

    public function create_log($error, $type)
    {
        $data = [
            LogNL::COLUMN_RESPONSE => json_encode($error),
            LogNL::COLUMN_FLOW => LogNL::PAYIN,
            LogNL::COLUMN_TYPE => $type,
        ];
        $this->logNlRepository->create($data);
    }

    public function cron_log($request, $response, $type, $order_code)
    {
        $data = [
            LogNL::COLUMN_REQUEST => json_encode($request),
            LogNL::COLUMN_RESPONSE => json_encode($response),
            LogNL::COLUMN_FLOW => 'cron_payin',
            LogNL::COLUMN_TYPE => $type,
            LogNL::COLUMN_ORDER_CODE => $order_code,
        ];
        $this->logNlRepository->create($data);
    }
}
