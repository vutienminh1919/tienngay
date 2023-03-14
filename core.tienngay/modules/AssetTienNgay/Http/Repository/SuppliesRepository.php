<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\SuppliesAsset;

class SuppliesRepository extends BaseRepository
{
    public function getModel()
    {
        return SuppliesAsset::class;
    }

    public function get_all_paginate($request)
    {
        $model = $this->model;

        if (!empty($request->status)) {
            $model = $model->where(SuppliesAsset::STATUS, (int)$request->status);
        }
        if (!empty($request->user_id)) {
            $model = $model->where(SuppliesAsset::USER_ID, $request->user_id);
        }
        if (!empty($request->equipment_child_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_CHILD_ID, $request->equipment_child_id);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        if (!empty($request->department_id)) {
            $model = $model->where(SuppliesAsset::DEPARTMENT_ID, $request->department_id);
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
            return $model
                ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
                ->paginate(20);
        }
        if (!empty($request->equipment_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_ID, $request->equipment_id);
            if (count($request->data_department) > 0) {
                $model = $model->whereIn(SuppliesAsset::DEPARTMENT_ID, $request->data_department);
            }
            return $model
                ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
                ->paginate(20);
        }

        if (!empty($request->warehouse_id)) {
            $model = $model->where(SuppliesAsset::WAREHOUSE_ID, $request->warehouse_id);
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
            return $model
                ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
                ->paginate(20);
        }
    }

    public function get_count_all($request)
    {
        $model = $this->model;
        if (!empty($request->status)) {
            $model = $model->where(SuppliesAsset::STATUS, (int)$request->status);
        }
        if (!empty($request->user_id)) {
            $model = $model->where(SuppliesAsset::USER_ID, $request->user_id);
        }
        if (!empty($request->equipment_child_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_CHILD_ID, $request->equipment_child_id);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        if (!empty($request->department_id)) {
            $model = $model->where(SuppliesAsset::DEPARTMENT_ID, $request->department_id);
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
            return $model->count();
        }

        if (!empty($request->equipment_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_ID, $request->equipment_id);
            if (count($request->data_department) > 0) {
                $model = $model->whereIn(SuppliesAsset::DEPARTMENT_ID, $request->data_department);
            }
            return $model->count();
        }

        if (!empty($request->warehouse_id)) {
            $model = $model->where(SuppliesAsset::WAREHOUSE_ID, $request->warehouse_id);
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
            return $model->count();
        }


    }

    public function get_list_app($request)
    {
        $model = $this->model;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        if (!empty($request->status)) {
            $model = $model->where(SuppliesAsset::STATUS, (int)$request->status);
        }
        if (!empty($request->deparment_id)) {
            $model = $model->where(SuppliesAsset::DEPARTMENT_ID, $request->department_id);
        }
        if (!empty($request->user_id)) {
            $model = $model->where(SuppliesAsset::USER_ID, $request->user_id);
        }
        if (!empty($request->equipment_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_ID, $request->equipment_id);
        }
        if (!empty($request->equipment_child_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_CHILD_ID, $request->equipment_child_id);
        }
        if (!empty($request->warehouse_id)) {
            $model = $model->where(SuppliesAsset::WAREHOUSE_ID, $request->warehouse_id);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        return $model
            ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
            ->skip((int)$offset)
            ->take((int)$limit)
            ->get();
    }

    public function get_all($request)
    {
        $model = $this->model;
        if (!empty($request->status)) {
            $model = $model->where(SuppliesAsset::STATUS, (int)$request->status);
        }
        if (!empty($request->user_id)) {
            $model = $model->where(SuppliesAsset::USER_ID, $request->user_id);
        }
        if (!empty($request->equipment_child_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_CHILD_ID, $request->equipment_child_id);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        if (!empty($request->department_id)) {
            $model = $model->where(SuppliesAsset::DEPARTMENT_ID, $request->department_id);
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
            return $model
                ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
                ->get();
        }

        if (!empty($request->equipment_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_ID, $request->equipment_id);
            if (count($request->data_department) > 0) {
                $model = $model->whereIn(SuppliesAsset::DEPARTMENT_ID, $request->data_department);
            }
            return $model
                ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
                ->get();
        }

        if (!empty($request->warehouse_id)) {
            $model = $model->where(SuppliesAsset::WAREHOUSE_ID, $request->warehouse_id);
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
            return $model
                ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
                ->get();
        }

    }

    public function get_all_paginate_dashboard($request)
    {
        $model = $this->model;
        $status = !empty($request->status) ? (int)$request->status : 1;
        $model = $model->where(SuppliesAsset::STATUS, $status);
        if ($status == SuppliesAsset::THIET_BI_CHO_XU_LY || $status == SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
            if (count($request->data_department) > 0) {
                $model = $model->whereIn(SuppliesAsset::DEPARTMENT_ID, $request->data_department);
            }
        }
        if ($status == SuppliesAsset::THIET_BI_MOI || $status == SuppliesAsset::THIET_BI_HONG || $status == SuppliesAsset::THIET_BI_LUU_KHO) {
            if (count($request->data_warehouse) > 0) {
                $model = $model->whereIn(SuppliesAsset::WAREHOUSE_ID, $request->data_warehouse);
            }
        }
        if (count($request->data_equipment) > 0) {
            $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        if (!empty($request->user_id)) {
            $model = $model->where(SuppliesAsset::USER_ID, $request->user_id);
        }

        if (!empty($request->status_receive)) {
            if ($request->status_receive == 1) {
                $model = $model->where(SuppliesAsset::STATUS_RECEIVE, true);
            } else {
                $model = $model->whereNotIn(SuppliesAsset::STATUS_RECEIVE, [true]);
            }
        }
        return $model
            ->orderBy(SuppliesAsset::UPDATED_AT, self::DESC)
            ->paginate(30);
    }

    public function get_all_dashboard($request)
    {
        $model = $this->model;
        $status = !empty($request->status) ? (int)$request->status : 1;
        $model = $model->where(SuppliesAsset::STATUS, $status);
        if ($status == SuppliesAsset::THIET_BI_CHO_XU_LY || $status == SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
            if (count($request->data_department) > 0) {
                $model = $model->whereIn(SuppliesAsset::DEPARTMENT_ID, $request->data_department);
            }
        }
        if ($status == SuppliesAsset::THIET_BI_MOI || $status == SuppliesAsset::THIET_BI_HONG || $status == SuppliesAsset::THIET_BI_LUU_KHO) {
            if (count($request->data_warehouse) > 0) {
                $model = $model->whereIn(SuppliesAsset::WAREHOUSE_ID, $request->data_warehouse);
            }
        }
        if (count($request->data_equipment) > 0) {
            $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(function ($query) use ($name) {
                $query->where(SuppliesAsset::NAME, 'LIKE', "%$name%")
                    ->orWhere(SuppliesAsset::ID, $name);
            });
        }
        if (!empty($request->user_id)) {
            $model = $model->where(SuppliesAsset::USER_ID, $request->user_id);
        }
        if (!empty($request->status_receive)) {
            $model = $model->where(SuppliesAsset::STATUS_RECEIVE, $request->status_receive);
        }
        return $model
            ->orderBy(SuppliesAsset::UPDATED_AT, self::DESC)
            ->get();
    }

    public function get_count_all_dashboard($request)
    {
        $model = $this->model;
        $status = (int)$request->status;
        $model = $model->where(SuppliesAsset::STATUS, $status);
        if ($status == SuppliesAsset::THIET_BI_CHO_XU_LY || $status == SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
            if (count($request->data_department) > 0) {
                $model = $model->whereIn(SuppliesAsset::DEPARTMENT_ID, $request->data_department);
            }
        }
        if ($status == SuppliesAsset::THIET_BI_MOI || $status == SuppliesAsset::THIET_BI_HONG || $status == SuppliesAsset::THIET_BI_LUU_KHO) {
            if (count($request->data_warehouse) > 0) {
                $model = $model->whereIn(SuppliesAsset::WAREHOUSE_ID, $request->data_warehouse);
            }
        }
        if (count($request->data_equipment) > 0) {
            $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
        }
        if (!empty($request->user_id)) {
            $model = $model->where(SuppliesAsset::USER_ID, $request->user_id);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        return $model->count();
    }

    public function report($request)
    {
        $model = $this->model;
        return $model->whereIn(SuppliesAsset::ID, $request->supplies)
            ->get();
    }

    public function get_warehouse_paginate($request)
    {
        $model = $this->model;
        $model = $model->where(SuppliesAsset::WAREHOUSE_ID, $request->warehouse_id);
        if (!empty($request->status)) {
            $model = $model->where(SuppliesAsset::STATUS, (int)$request->status);
        }
        if (!empty($request->equipment_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_ID, $request->equipment_id);
        } else {
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
        }
        if (!empty($request->equipment_child_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_CHILD_ID, $request->equipment_child_id);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        return $model
            ->orderBy(SuppliesAsset::CREATED_AT, self::DESC)
            ->paginate(20);
    }

    public function get_count_warehouse($request)
    {
        $model = $this->model;
        $model = $model->where(SuppliesAsset::WAREHOUSE_ID, $request->warehouse_id);
        if (!empty($request->status)) {
            $model = $model->where(SuppliesAsset::STATUS, (int)$request->status);
        }
        if (!empty($request->equipment_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_ID, $request->equipment_id);
        } else {
            if (count($request->data_equipment) > 0) {
                $model = $model->whereIn(SuppliesAsset::EQUIPMENT_ID, $request->data_equipment);
            }
        }
        if (!empty($request->equipment_child_id)) {
            $model = $model->where(SuppliesAsset::EQUIPMENT_CHILD_ID, $request->equipment_child_id);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $model = $model->where(SuppliesAsset::NAME, 'LIKE', "%$name%");
        }
        return $model->count();
    }

    public function find_supplies_assgin_code()
    {
        $model = $this->model;
        return $model->whereIn(SuppliesAsset::STATUS, [SuppliesAsset::THIET_BI_CHO_XU_LY, SuppliesAsset::THIET_BI_DANG_SU_DUNG])
            ->orderBy(SuppliesAsset::CREATED_AT, self::ASC)
            ->get();
    }

    public function get_all_data($request)
    {
        $model = $this->model;
        if (!empty($request->status)) {
            $model = $model->where(SuppliesAsset::STATUS, (int)$request->status);
        }

        if (!empty($request->warehouse_id)) {
            $model = $model->where(SuppliesAsset::WAREHOUSE_ID, $request->warehouse_id);
        }
        return $model
            ->orderBy(SuppliesAsset::CREATED_AT, self::ASC)
            ->get();
    }
}
