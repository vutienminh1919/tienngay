<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Repository\WarehouseRepository;
use Modules\AssetTienNgay\Model\WarehouseAsset;

class WarehouseService extends BaseService
{
    protected $warehouseRepository;

    public function __construct(WarehouseRepository $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function create($request)
    {
        $warehouse = $this->warehouseRepository->findOne([WarehouseAsset::SLUG => slugify($request->name)]);

        if ($warehouse) {
            $this->warehouseRepository->update($warehouse->_id, [
                WarehouseAsset::STATUS => WarehouseAsset::ACTIVE,
                WarehouseAsset::UPDATED_AT => time(),
                WarehouseAsset::UPDATED_BY => $request->user_info->email,
            ]);
        } else {
            $this->warehouseRepository->create([
                WarehouseAsset::NAME => $request->name,
                WarehouseAsset::SLUG => slugify($request->name),
                WarehouseAsset::STATUS => WarehouseAsset::ACTIVE,
                WarehouseAsset::LEVEL => $request->level,
                WarehouseAsset::CREATED_AT => time(),
                WarehouseAsset::CREATED_BY => $request->user_info->email
            ]);
        }
    }

    public function getAll()
    {
        return $this->warehouseRepository->getAll();
    }
}
