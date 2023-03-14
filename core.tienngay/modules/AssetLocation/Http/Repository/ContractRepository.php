<?php


namespace Modules\AssetLocation\Http\Repository;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\AssetLocation\Model\Contract;
use Modules\AssetLocation\Model\Device;

class ContractRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Contract::class;
    }

    public function asset_by_user_business($request, $query)
    {
        $model = $this->model;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 20;
        if (!empty($request->stores)) {
            $model = $model->whereIn(Contract::STORE_ID, $request->stores);
        }

        if (!empty($request->store)) {
            $model = $model->where(Contract::STORE_ID, $request->store);
        }

        if (!empty($request->email)) {
            $model = $model->where(Contract::CREATED_BY, $request->email);
        }

        if (!empty($request->code_contract_disbursement)) {
            $model = $model->where(Contract::CODE_CONTRACT_DISBURSEMENT, 'LIKE', "%$request->code_contract_disbursement%");
        }

        if (!empty($request->customer_name)) {
            $model = $model->where(Contract::CUSTOMER_INFOR_NAME, 'LIKE', "%$request->customer_name%");
        }

        if (!empty($request->seri)) {
            $model = $model->where(Contract::LOAN_INFOR_DEVICE_LOCATION_CODE, 'LIKE', "%$request->seri%");
        }

        if (!empty($request->license)) {
            $model = $model->where(Contract::PROPERTY_INFOR_LICENSE, 'LIKE', "%$request->license%");
        }

        if (!empty($request->start) && !empty($request->end)) {
            $model = $model->whereBetween(Contract::DISBURSEMENT_DATE, [strtotime($request->start), strtotime($request->end)]);
        }

        if (!empty($request->location)) {
            $model = $model->where(Contract::DEVICE_ASSET_LOCATION_STATUS, (int)$request->location);
        }

        if (!empty($request->alarm)) {
            $model = $model->where(Contract::DEVICE_ASSET_LOCATION_ALARM, (int)$request->alarm);
        }

        $model = $model
//            ->whereIn(Contract::LOAN_INFOR_PRODUCT_CODE, [Contract::VAY_GAN_DINH_VI, Contract::VAY_CAVET_OTO])
            ->whereIn(Contract::STATUS, Contract::SAU_GIAI_NGAN)
            ->where('loan_infor.device_asset_location', 'exists', true)
            ->where('loan_infor.device_asset_location.device_asset_location_id' , '!=', '')
            ->whereNull(Contract::DEVICE_ASSET_LOCATION_STATUS_RECALL);

        if ($query == 'get') {
            return $model
                ->select('_id', 'customer_infor', 'code_contract_disbursement', 'status', 'property_infor', 'disbursement_date', 'created_by', 'store', 'loan_infor', 'code_contract', 'expire_date', 'current_address')
                ->offset((int)$offset)
                ->limit((int)$limit)
                ->orderBy('disbursement_date', self::DESC)
                ->get();
        } elseif ($query == 'excel') {
            return $model
                ->select('_id', 'customer_infor', 'code_contract_disbursement', 'status', 'property_infor', 'disbursement_date', 'created_by', 'store', 'loan_infor', 'code_contract', 'expire_date', 'current_address', 'debt')
                ->orderBy('disbursement_date', self::DESC)
                ->get();
        } elseif ($query == 'location') {
            if (!empty($request->status_location)) {
                $model = $model->where(Contract::DEVICE_ASSET_LOCATION_STATUS, (int)$request->status_location);
            }
            return $model->count();
        } elseif ($query == 'alarm') {
            if (!empty($request->status_alarm)) {
                $model = $model->where(Contract::DEVICE_ASSET_LOCATION_ALARM, (int)$request->status_alarm);
            }
            return $model->count();
        } else {
            if (!empty($request->debt) && $request->debt == 'active') {
                $model = $model->where(Contract::EXPIRE_DATE, '>', Carbon::now()->unix())
                    ->whereNotIn(Contract::STATUS, [Contract::DA_TAT_TOAN]);
            } elseif (!empty($request->debt) && $request->debt == 'deactive') {
                $model = $model->where(function ($query) {
                    return $query->where(Contract::EXPIRE_DATE, '<=', Carbon::now()->unix())
                        ->orWhere(function ($subQuery) {
                            return $subQuery->where(Contract::STATUS, Contract::DA_TAT_TOAN);
                        });
                });
            }
            return $model->count();
        }
    }

    public function find_contract_active($device_id)
    {
        $model = $this->model;
        return $model
            ->select('_id', 'customer_infor', 'code_contract_disbursement', 'status', 'property_infor', 'disbursement_date', 'created_by', 'store', 'loan_infor', 'code_contract', 'expire_date', 'current_address', 'debt')
            ->where(Contract::LOAN_INFOR_DEVICE_LOCATION_ID, $device_id)
//            ->whereIn(Contract::LOAN_INFOR_PRODUCT_CODE, [Contract::VAY_GAN_DINH_VI, Contract::VAY_CAVET_OTO])
            ->where('loan_infor.device_asset_location', 'exists', true)
            ->where('loan_infor.device_asset_location.device_asset_location_id' , '!=', '')
            ->whereIn(Contract::STATUS, Contract::DANG_VAY)
            ->first();

    }

    public function total_asset_contract($store_id, $type)
    {
        $model = $this->model;
        $model = $model->where(Contract::STORE_ID, $store_id)
//            ->whereIn(Contract::LOAN_INFOR_PRODUCT_CODE, [Contract::VAY_GAN_DINH_VI, Contract::VAY_CAVET_OTO])
            ->where('loan_infor.device_asset_location', 'exists', true)
            ->where('loan_infor.device_asset_location.device_asset_location_id' , '!=', '')
            ->whereIn(Contract::STATUS, Contract::SAU_GIAI_NGAN)
            ->whereNull(Contract::DEVICE_ASSET_LOCATION_STATUS_RECALL);

        if ($type == 'active') {
            $model = $model->where(Contract::EXPIRE_DATE, '>', Carbon::now()->unix())
                ->whereNotIn(Contract::STATUS, [Contract::DA_TAT_TOAN]);
        } elseif ($type == 'deactive') {
            $model = $model->where(function ($query) {
                return $query->where(Contract::EXPIRE_DATE, '<=', Carbon::now()->unix())
                    ->orWhere(function ($subQuery) {
                        return $subQuery->where(Contract::STATUS, Contract::DA_TAT_TOAN);
                    });
            });
        }

        return $model
            ->count();
    }

    public function total_alarm_asset_contract($store, $alarm)
    {
        $model = $this->model;
        $model = $model->whereIn(Contract::STORE_ID, $store)
//            ->whereIn(Contract::LOAN_INFOR_PRODUCT_CODE, [Contract::VAY_GAN_DINH_VI, Contract::VAY_CAVET_OTO])
            ->where('loan_infor.device_asset_location', 'exists', true)
            ->where('loan_infor.device_asset_location.device_asset_location_id' , '!=', '')
            ->whereIn(Contract::STATUS, Contract::SAU_GIAI_NGAN)
            ->whereNull(Contract::DEVICE_ASSET_LOCATION_STATUS_RECALL)
            ->where(Contract::DEVICE_ASSET_LOCATION_ALARM, (int)$alarm);
        return $model->count();
    }

    public function get_contract_by_product_asset_location()
    {
        $model = $this->model;
        $model = $model
//            ->whereIn(Contract::LOAN_INFOR_PRODUCT_CODE, [Contract::VAY_GAN_DINH_VI, Contract::VAY_CAVET_OTO])
            ->where('loan_infor.device_asset_location', 'exists', true)
            ->where('loan_infor.device_asset_location.device_asset_location_id' , '!=', '')
            ->where(Contract::STATUS, Contract::DA_GIAI_NGAN)
            ->get();
        return $model;
    }

    public function contract_by_collection($request, $query)
    {
        $model = $this->model;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 20;
        if (!empty($request->stores)) {
            $model = $model->whereIn(Contract::STORE_ID, $request->stores);
        }

        if (!empty($request->store)) {
            $model = $model->where(Contract::STORE_ID, $request->store);
        }

        if (!empty($request->code_contract_disbursement)) {
            $model = $model->where(Contract::CODE_CONTRACT_DISBURSEMENT, 'LIKE', "%$request->code_contract_disbursement%");
        }

        if (!empty($request->customer_name)) {
            $model = $model->where(Contract::CUSTOMER_INFOR_NAME, 'LIKE', "%$request->customer_name%");
        }

        if (!empty($request->seri)) {
            $model = $model->where(Contract::LOAN_INFOR_DEVICE_LOCATION_CODE, 'LIKE', "%$request->seri%");
        }

        if (!empty($request->license)) {
            $model = $model->where(Contract::PROPERTY_INFOR_LICENSE, 'LIKE', "%$request->license%");
        }

        if (!empty($request->start) && !empty($request->end)) {
            $model = $model->whereBetween(Contract::DISBURSEMENT_DATE, [strtotime($request->start), strtotime($request->end)]);
        }

        if (!empty($request->location)) {
            $model = $model->where(Contract::DEVICE_ASSET_LOCATION_STATUS, (int)$request->location);
        }

        if (!empty($request->alarm)) {
            $model = $model->where(Contract::DEVICE_ASSET_LOCATION_ALARM, (int)$request->alarm);
        }

        if (!empty($request->status)) {
            $model = $model->where(Contract::STATUS, (int)$request->status);
        }

        $model = $model
//            ->whereIn(Contract::LOAN_INFOR_PRODUCT_CODE, [Contract::VAY_GAN_DINH_VI, Contract::VAY_CAVET_OTO])
            ->where('loan_infor.device_asset_location', 'exists', true)
            ->where('loan_infor.device_asset_location.device_asset_location_id' , '!=', '')
            ->whereIn(Contract::STATUS, Contract::SAU_GIAI_NGAN);

        if ($query == 'get') {
            return $model
                ->select('_id', 'customer_infor', 'code_contract_disbursement', 'status', 'property_infor', 'disbursement_date', 'created_by', 'store', 'loan_infor', 'code_contract', 'expire_date', 'current_address', 'debt')
                ->offset((int)$offset)
                ->limit((int)$limit)
                ->orderBy('disbursement_date', self::DESC)
                ->get();
        } elseif ($query == 'excel') {
            return $model
                ->select('_id', 'customer_infor', 'code_contract_disbursement', 'status', 'property_infor', 'disbursement_date', 'created_by', 'store', 'loan_infor', 'code_contract', 'expire_date', 'current_address', 'debt')
                ->orderBy('disbursement_date', self::DESC)
                ->get();
        } elseif ($query == 'location') {
            if (!empty($request->status_location)) {
                $model = $model->where(Contract::DEVICE_ASSET_LOCATION_STATUS, (int)$request->status_location);
            }
            return $model->count();
        } elseif ($query == 'alarm') {
            if (!empty($request->status_alarm)) {
                $model = $model->where(Contract::DEVICE_ASSET_LOCATION_ALARM, (int)$request->status_alarm);
            }
            return $model->count();
        } else {
            if (!empty($request->debt) && $request->debt == 'active') {
                $model = $model->where(Contract::EXPIRE_DATE, '>', Carbon::now()->unix())
                    ->whereNotIn(Contract::STATUS, [Contract::DA_TAT_TOAN]);
            } elseif (!empty($request->debt) && $request->debt == 'deactive') {
                $model = $model->where(function ($query) {
                    return $query->where(Contract::EXPIRE_DATE, '<=', Carbon::now()->unix())
                        ->orWhere(function ($subQuery) {
                            return $subQuery->where(Contract::STATUS, Contract::DA_TAT_TOAN);
                        });
                });
            }
            return $model->count();
        }
    }
}
