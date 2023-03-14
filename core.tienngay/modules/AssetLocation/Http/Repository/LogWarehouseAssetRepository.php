<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\LogWarehouseAsset;

class LogWarehouseAssetRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogWarehouseAsset::class;
    }

    public function history($request, $query)
    {
        $model = $this->model;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 20;

        if ($query == 'get') {
            return $model->offset((int)$offset)
                ->limit((int)$limit)
                ->orderBy('created_at', self::DESC)
                ->get();
        } elseif ($query == 'excel') {
            return $model
                ->orderBy('created_at', self::DESC)
                ->get();
        } else {
            return $model->count();
        }

    }
}
