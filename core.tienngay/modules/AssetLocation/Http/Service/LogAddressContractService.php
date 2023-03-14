<?php


namespace Modules\AssetLocation\Http\Service;


use Modules\AssetLocation\Http\Repository\BaseRepository;
use Modules\AssetLocation\Http\Repository\LogAddressContractRepository;

class LogAddressContractService extends BaseService
{
    protected $logAddressContractRepository;

    public function __construct(LogAddressContractRepository $logAddressContractRepository)
    {
        $this->logAddressContractRepository = $logAddressContractRepository;
    }
}
