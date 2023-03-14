<?php


namespace Modules\AssetLocation\Http\Service;

use Modules\AssetLocation\Http\Repository\LogWarehouseAssetRepository;

class LogWarehouseAssetService extends BaseService
{
    protected $logWarehouseAssetRepository;

    public function __construct(LogWarehouseAssetRepository $logWarehouseAssetRepository)
    {
        $this->logWarehouseAssetRepository = $logWarehouseAssetRepository;
    }
}
