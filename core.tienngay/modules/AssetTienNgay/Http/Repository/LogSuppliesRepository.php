<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\LogSuppliesAsset;

class LogSuppliesRepository extends BaseRepository
{
    public function getModel()
    {
        return LogSuppliesAsset::class;
    }

    public function findRequest($id)
    {
        $model = $this->model;
        return $model
            ->where(LogSuppliesAsset::SUPPLIES_ID, $id)
            ->whereIn(LogSuppliesAsset::TYPE, [LogSuppliesAsset::ERROR, LogSuppliesAsset::SEND, LogSuppliesAsset::INVENTORY])
            ->orderBy(LogSuppliesAsset::CREATED_AT, self::DESC)
            ->first();
    }
}
