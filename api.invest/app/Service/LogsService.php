<?php


namespace App\Service;


use App\Models\LogError;
use App\Repository\LogErrorRepository;
use App\Repository\LogsRepository;

class LogsService
{
    protected $logsRepository;
    protected $errorRepository;

    public function __construct(LogsRepository $logsRepository,
                                LogErrorRepository $logErrorRepository)
    {
        $this->logsRepository = $logsRepository;
        $this->logErrorRepository = $logErrorRepository;
    }

    public function create($request, $exception, $function)
    {
        $response = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ];

        $log = $this->logErrorRepository->create([
            LogError::INPUT => json_encode($request->all()),
            LogError::ERROR => json_encode($response),
            LogError::ACTION => $function
        ]);
        return $log;
    }

}
