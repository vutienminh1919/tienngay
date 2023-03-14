<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\HeyuHandover as HModel;
use Modules\MongodbCore\Repositories\Interfaces\HeyuHandoverRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HeyuHandoverRepository implements HeyuHandoverRepositoryInterface
{

    /**
     * @var Model
     */
     protected $heyuHandover;

    /**
     * HeyuHandoverRepository constructor.
     *
     * @param HeyuHandover $heyuHandover
     */
    public function __construct(HModel $heyuHandover) {
        $this->heyuHandover = $heyuHandover;
    }

    /**
     * Store new handover data into collection
     * @param $attr array
     * @return collection
     * */
    public function store($attr) {
        $data = [
            HModel::STORE_ID      => $attr[HModel::STORE_ID],
            HModel::STORE_NAME    => $attr[HModel::STORE_NAME],
            HModel::DRIVER_CODE   => $attr[HModel::DRIVER_CODE],
            HModel::DRIVER_NAME   => $attr[HModel::DRIVER_NAME],
            HModel::CREATED_BY    => $attr[HModel::CREATED_BY],
            HModel::UPDATED_BY    => $attr[HModel::CREATED_BY],
            HModel::COAT              => [
                HModel::SIZE_S        => !empty($attr[HModel::COAT][HModel::SIZE_S]) ? (int)$attr[HModel::COAT][HModel::SIZE_S] : 0,
                HModel::SIZE_M        => !empty($attr[HModel::COAT][HModel::SIZE_M]) ? (int)$attr[HModel::COAT][HModel::SIZE_M] : 0,
                HModel::SIZE_L        => !empty($attr[HModel::COAT][HModel::SIZE_L]) ? (int)$attr[HModel::COAT][HModel::SIZE_L] : 0,
                HModel::SIZE_XL       => !empty($attr[HModel::COAT][HModel::SIZE_XL]) ? (int)$attr[HModel::COAT][HModel::SIZE_XL] : 0,
                HModel::SIZE_XXL      => !empty($attr[HModel::COAT][HModel::SIZE_XXL]) ? (int)$attr[HModel::COAT][HModel::SIZE_XXL] : 0,
                HModel::SIZE_XXXL     => !empty($attr[HModel::COAT][HModel::SIZE_XXXL]) ? (int)$attr[HModel::COAT][HModel::SIZE_XXXL] : 0
            ],
            HModel::SHIRT             => [
                HModel::SIZE_S        => !empty($attr[HModel::SHIRT][HModel::SIZE_S]) ? (int)$attr[HModel::SHIRT][HModel::SIZE_S] : 0,
                HModel::SIZE_M        => !empty($attr[HModel::SHIRT][HModel::SIZE_M]) ? (int)$attr[HModel::SHIRT][HModel::SIZE_M] : 0,
                HModel::SIZE_L        => !empty($attr[HModel::SHIRT][HModel::SIZE_L]) ? (int)$attr[HModel::SHIRT][HModel::SIZE_L] : 0,
                HModel::SIZE_XL       => !empty($attr[HModel::SHIRT][HModel::SIZE_XL]) ? (int)$attr[HModel::SHIRT][HModel::SIZE_XL] : 0,
                HModel::SIZE_XXL      => !empty($attr[HModel::SHIRT][HModel::SIZE_XXL]) ? (int)$attr[HModel::SHIRT][HModel::SIZE_XXL] : 0,
                HModel::SIZE_XXXL     => !empty($attr[HModel::SHIRT][HModel::SIZE_XXXL]) ? (int)$attr[HModel::SHIRT][HModel::SIZE_XXXL] : 0
            ],
            HModel::EVIDENCE        => $attr[HModel::EVIDENCE],
        ];

        $create = $this->heyuHandover->create($data);
        return $create;
    }

    /**
     * Update handover bill's status to approved
     * @param $id string, $approvedBy string
     * @return boolean
     * */
    public function approve($id, $approvedBy) {
        $update = $this->heyuHandover->find($id);
        if ($update) {
            $update[HModel::STATUS] = HModel::STATUS_APPROVED;
            $update[HModel::APPROVE_AT] = time();
            $update[HModel::APPROVE_BY] = $approvedBy;
            if ($update->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Update handover bill's status to cancel
     * @param $id string, $approvedBy string
     * @return boolean
     * */
    public function cancle($id, $approvedBy, $cancelNote) {
        $update = $this->heyuHandover->find($id);
        if ($update) {
            $update[HModel::STATUS] = HModel::STATUS_CANCLED;
            $update[HModel::APPROVE_AT] = time();
            $update[HModel::APPROVE_BY] = $approvedBy;
            $update[HModel::CANCLE_NOTE] = $cancelNote;
            if ($update->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Handover bill's detail
     * @param $id string
     * @return collection
     * */
    public function detail($id) {
        $handoverBill = $this->heyuHandover->find($id);
        return $handoverBill;
    }

    public function getAll($dataSearch, $export = false)
    {
        $listRecord = $this->heyuHandover;

        if (!empty($dataSearch['driver_code'])) {
            $listRecord = $listRecord->where(HModel::DRIVER_CODE, '$regex', '/' . trim($dataSearch['driver_code']) . '/i');
        }
        if (!empty($dataSearch['driver_name'])) {
            $listRecord = $listRecord->where(HModel::DRIVER_NAME, '$regex', '/' . trim($dataSearch['driver_name']) . '/i');
        }
        if (!empty($dataSearch['store'])) {
            $listRecord = $listRecord->whereIn(HModel::STORE_ID, $dataSearch['store']);
        }else{
            return [];
        }
        if (!empty($dataSearch['status'])) {
            $listRecord = $listRecord->where('status', '=', (int)$dataSearch['status']);
        }
        if (!empty($dataSearch['start_date'])) {
            $startDate =  date('Y-m-d 00:00:00', strtotime($dataSearch['start_date']));
            $listRecord = $listRecord->where(HModel::DELIVERY_DATE, '>=', strtotime($startDate));
        }
        if (!empty($dataSearch['end_date'])) {
            $endDate =  date('Y-m-d 23:59:59', strtotime($dataSearch['end_date']));
            $listRecord = $listRecord->where(HModel::DELIVERY_DATE, '<=', strtotime($endDate));
        }
        if ($export) {
            return $listRecord
                ->orderBy(HModel::CREATED_AT, 'DESC')
                ->get();
        }
        return $listRecord
            ->orderBy(HModel::CREATED_AT, 'DESC')
            ->paginate(20);


    }

    public function getHandoverByIdStore($storeId)
    {
        return $heyuHandover = $this->heyuHandover
            ->whereIn(HModel::STORE_ID, $storeId)
            ->where(HModel::STATUS, HModel::STATUS_APPROVED)
            ->select('coat', 'shirt')
            ->get();

    }
}
