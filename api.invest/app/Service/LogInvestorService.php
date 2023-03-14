<?php


namespace App\Service;


use App\Models\LogInvestor;
use App\Repository\LogInvestorRepositoryInterface;

class LogInvestorService extends BaseService
{
    protected $logInvestorRepository;

    public function __construct(LogInvestorRepositoryInterface $logInvestorRepository)
    {
        $this->logInvestorRepository = $logInvestorRepository;
    }


    public function create_log($request, $data)
    {
        $this->logInvestorRepository->create([
            LogInvestor::COLUMN_REQUEST => json_encode($request),
            LogInvestor::COLUMN_RESPONSE => json_encode($data),
            LogInvestor::COLUMN_CREATED_BY => current_user()->email,
            LogInvestor::COLUMN_TYPE => 'update'
        ]);
    }

    public function app_create_log($request, $data)
    {
        $this->logInvestorRepository->create([
            LogInvestor::COLUMN_REQUEST => json_encode($request),
            LogInvestor::COLUMN_RESPONSE => json_encode($data),
            LogInvestor::COLUMN_CREATED_BY => $data->phone_number,
            LogInvestor::COLUMN_TYPE => 'update'
        ]);
    }

}
