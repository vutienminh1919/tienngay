<?php


namespace Modules\AssetTienNgay\Http\Service;

use Modules\AssetTienNgay\Http\Repository\LogSuppliesRepository;

class LogSuppliesService extends BaseService
{
    protected $logSuppliesRepository;

    public function __construct(LogSuppliesRepository $logSuppliesRepository)
    {
        $this->logSuppliesRepository = $logSuppliesRepository;
    }
}
