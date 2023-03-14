<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Device;

class DeviceRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Device::class;
    }

    public function get_total_new_stock($id)
    {
        $model = $this->model;
        return $model->where(Device::WAREHOUSE_ASSET_LOCATION_ID, $id)
            ->where(Device::STATUS, Device::NEW)
            ->count();
    }

    public function get_total_price_new_stock($id)
    {
        $model = $this->model;
        return $model->where(Device::WAREHOUSE_ASSET_LOCATION_ID, $id)
            ->where(Device::STATUS, Device::NEW)
            ->sum(Device::STOCK_PRICE);
    }

    public function ton($warehouse_id, $flag, $in)
    {
        $model = $this->model;
        $model = $model->where(Device::WAREHOUSE_ASSET_LOCATION_ID, $warehouse_id)
            ->whereIn(Device::STATUS, $in);
        if ($flag == 'count') {
            return $model->count();
        } else {
            return $model->sum(Device::STOCK_PRICE);
        }

    }

    public function nhap($warehouse_id, $start_date, $end_date, $flag, $in)
    {
        $model = $this->model;
        $model = $model->where(Device::WAREHOUSE_ASSET_LOCATION_ID, $warehouse_id)
            ->whereIn(Device::STATUS, $in)
            ->whereNull(Device::SECONDHAND)
            ->whereBetween(Device::CREATED_AT, [$start_date, $end_date]);
        if ($flag == 'count') {
            return $model->count();
        } else {
            return $model->sum(Device::IMPORT_PRICE);
        }
    }

    public function xuat($warehouse_id, $start_date, $end_date, $flag)
    {
        $model = $this->model;
        $model = $model->where(Device::WAREHOUSE_ASSET_LOCATION_ID, $warehouse_id)
            ->whereBetween(Device::EXPORT_DATE_STATUS_NEW, [$start_date, $end_date]);
        if ($flag == 'count') {
            return $model->count();
        } else {
            return $model->sum(Device::PRICE_EXPORT_DATE_STATUS_NEW);
        }
    }

    public function get_total_all_new_stock()
    {
        $model = $this->model;
        return $model
            ->where(Device::STATUS, Device::NEW)
            ->count();
    }

    public function get_total_all_price_new_stock()
    {
        $model = $this->model;
        return $model
            ->where(Device::STATUS, Device::NEW)
            ->sum(Device::STOCK_PRICE);
    }

    public function get_device_by_warehouse($request)
    {
        $model = $this->model;
//        $offset = $request->offset ?? 0;
//        $limit = $request->limit ?? 30;
        $model = $model
            ->where(Device::WAREHOUSE_ASSET_LOCATION_ID, $request->id)
//            ->offset((int)$offset)
//            ->limit((int)$limit)
            ->orderBy(Device::CREATED_AT)
            ->get();
        return $model;
    }
}
