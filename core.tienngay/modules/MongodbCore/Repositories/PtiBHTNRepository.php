<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\Store as StoreModel;
use Modules\MongodbCore\Entities\PtiBHTN as PtiBHTNModel;
use Modules\MongodbCore\Repositories\Interfaces\PtiBHTNRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Str;

class PtiBHTNRepository implements PtiBHTNRepositoryInterface
{

    /**      
     * @var Model
     */     
     protected $ptiBhtnModel;

    /**
     * PtiBHTNRepository constructor.
     *
     * @param PtiBHTNModel $ptiBhtn
     */
    public function __construct(PtiBHTNModel $ptiBhtn, StoreModel $store) {
        $this->ptiBhtnModel = $ptiBhtn;
        $this->storeModel = $store;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get list by month
     * @return collection
     */
    public function getListByMonth($time, $type = false) {
        // First day of the month.
        $startDate =  date('Y-m-01 00:00:00', strtotime($time));
        // Last day of the month.
        $endDate = date('Y-m-t 23:59:59', strtotime($time));
        $orders = $this->ptiBhtnModel::where(function ($query) use ($startDate, $endDate) {
            $query->where(PtiBHTNModel::CREATED_AT, '>=', strtotime($startDate));
            $query->where(PtiBHTNModel::CREATED_AT, '<=', strtotime($endDate));
        })
        ->where(PtiBHTNModel::STATUS, PtiBHTNModel::STATUS_SUCCESS);
        if ($type == PtiBHTNModel::TYPE_BN) {
            $orders = $orders->where(PtiBHTNModel::TYPE, PtiBHTNModel::TYPE_BN);
        } else if ($type == PtiBHTNModel::TYPE_HD) {
            $orders = $orders->where('pti_info.type', '=', PtiBHTNModel::TYPE_HD);
        } else {
            // get all
        }
        $orders = $orders->get();
        return $orders;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get list by month
     * @return collection
     */
    public function getList($type = false) {
        // First day of the month.
        $startDate =  date('Y-m-d 00:00:00', strtotime("NOW -30 day"));
        // Last day of the month.
        $endDate = date('Y-m-d H:i:s', strtotime("NOW"));
        $orders = $this->ptiBhtnModel::where(function ($query) use ($startDate, $endDate) {
            $query->where(PtiBHTNModel::CREATED_AT, '>=', strtotime($startDate));
            $query->where(PtiBHTNModel::CREATED_AT, '<=', strtotime($endDate));
        })
        ->where(PtiBHTNModel::STATUS, PtiBHTNModel::STATUS_SUCCESS);
        if ($type == PtiBHTNModel::TYPE_BN) {
            $orders = $orders->where(PtiBHTNModel::TYPE, PtiBHTNModel::TYPE_BN);
        } else if ($type == PtiBHTNModel::TYPE_HD) {
            $orders = $orders->where('pti_info.type', '=', PtiBHTNModel::TYPE_HD);
        } else {
            // get all
        }
        $orders = $orders->get();
        return $orders;
    }



    /**
     * Find the specified esource in storage.
     *
     * @param  Array  $condition
     * @return Collection
     */
    public function search($conditions) {
        $searchArr = [];
        if(!empty($conditions['name'])) {
            $searchArr[] = [PtiBHTNModel::TEN_KH, "=", trim($conditions['name'])];
        }
        if(!empty($conditions['indentity'])) {
            $searchArr[] = [PtiBHTNModel::IDENTITY, '=', trim($conditions['indentity'])];
        }
        if(!empty($conditions['so_id_pti'])) {
            $searchArr[] = [PtiBHTNModel::SO_ID_PTI, '=', (int)trim($conditions['so_id_pti'])];
        }
        if(!empty($conditions['contract_code'])) {
            $searchArr[] = [PtiBHTNModel::CODE_CONTRACT, '=', trim($conditions['contract_code'])];
        }
        if(!empty($conditions['contract_disbursement'])) {
            $searchArr[] = [PtiBHTNModel::CODE_CONTRACT_DISBURSEMENT, '=', trim($conditions['contract_disbursement'])];
        }
        if(!empty($conditions['isBanNgoai'])) {
            $searchArr[] = [PtiBHTNModel::TYPE, '=', PtiBHTNModel::TYPE_BN];
        } elseif (!empty($conditions['isHopDong'])) {
            $searchArr[] = [PtiBHTNModel::TYPE, '=', PtiBHTNModel::TYPE_HD];
        }
        $searchArr[] = [PtiBHTNModel::STATUS, '=', PtiBHTNModel::STATUS_SUCCESS];
        $orders = $this->ptiBhtnModel::where($searchArr);
        if(!empty($conditions['start_date'])) {
            $startDate =  date('Y-m-d 00:00:00', strtotime($conditions['start_date']));
            $orders = $orders->where(PtiBHTNModel::CREATED_AT, '>=', strtotime($startDate));
        }
        if(!empty($conditions['end_date'])) {
            $endDate = date('Y-m-d 23:59:59', strtotime($conditions['end_date']));
            $orders = $orders->where(PtiBHTNModel::CREATED_AT, '<=', strtotime($endDate));
        }
        $orders->options([
            'collation' => [
            'locale' => 'en',
            'strength' => 1
        ]]);
        return $orders->get();
        
    }

    public function countGoi($goi) {
        $count = $this->ptiBhtnModel::where('pti_request.goi', '=', trim($goi))
            ->where('type', '=', 'BN')->count();
        return $count;
    }

    public function createBN($data = []){
        $ptiRequest = [];
        if(!empty($data['ten'])) {
            $ptiRequest['ten'] = trim($data['ten']);
        }
        if(!empty($data['dchi'])) {
            $ptiRequest['dchi'] = $data['dchi'];
        }
        if(!empty($data['so_cmt'])) {
            $ptiRequest['so_cmt'] = $data['so_cmt'];
        }
        if(!empty($data['phone'])) {
            $ptiRequest['phone'] = $data['phone'];
        }
        if(!empty($data['ngay_sinh'])) {
            $ptiRequest['ngay_sinh'] = $data['ngay_sinh'];
        }
        if(!empty($data['tien_bh'])) {
            $ptiRequest['tien_bh'] = $data['tien_bh'];
        }
        if(!empty($data['phi'])) {
            $ptiRequest['phi'] = $data['phi'];
        }
        if(!empty($data['email'])) {
            $ptiRequest['email'] = trim($data['email']);
        }
        if(!empty($data['ttoan'])) {
            $ptiRequest['ttoan'] = $data['ttoan'];
        }
        $ptiRequest['goi'] = trim($data['goi']);
        $countGoi = $this->countGoi($ptiRequest['goi']);
        $bankRemark = 'BHTN'.$ptiRequest['goi'] . '0' . ((int)$countGoi + 1);

        if(!empty($data['created_by'])) {
            $createdBy = $data['created_by'];
        } else {
            $createdBy = "system";
        }
        $store = [];
        if(!empty($data['pgdId']) && !empty($data['pgdName'])) {
            $store = [
                "id" => $data['pgdId'],
                "name" => $data['pgdName']
            ];
        }

        $data = [
            PtiBHTNModel::PTI_REQUEST => $ptiRequest,
            PtiBHTNModel::CREATED_BY  => $createdBy,
            PtiBHTNModel::CREATED_AT  => time(),
            PtiBHTNModel::UPDATED_AT  => time(),
            PtiBHTNModel::BANK_REMARK => $bankRemark,
            PtiBHTNModel::TYPE        => 'BN',
            PtiBHTNModel::STATUS      => 'waitPayment',
            PtiBHTNModel::DIEUKHOAN1  => trim($data['dieuKhoan1']),
            PtiBHTNModel::DIEUKHOAN2  => trim($data['dieuKhoan2']),
            PtiBHTNModel::STORE       => $store,
        ];

        $created = $this->ptiBhtnModel->create($data);
        return $created;
    }

    public function getInfo($id) {
        $info = $this->ptiBhtnModel->where('_id', '=' ,$id)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }

    public function saveBN($id, $ptiResponse, $ptiRequest) {
        $info = $this->ptiBhtnModel->where('_id', '=' ,$id)->update([
            PtiBHTNModel::PTI_INFO => $ptiResponse,
            PtiBHTNModel::PTI_REQUEST => $ptiRequest,
        ]);
        return $info;
    }

    public function updateSuccess($id) {
        $info = $this->ptiBhtnModel->where('_id', '=' ,$id)->update([PtiBHTNModel::STATUS => PtiBHTNModel::STATUS_SUCCESS]);
        return $info;
    }

    public function getOrderWaitPayment() {
        $targetTime = strtotime("-3 day");
        $info = $this->ptiBhtnModel->where(PtiBHTNModel::STATUS, '=' ,PtiBHTNModel::STATUS_WAITPAYMENT)
            ->where(PtiBHTNModel::CREATED_AT, '>', $targetTime)
            ->where(PtiBHTNModel::TYPE, '=', PtiBHTNModel::TYPE_BN)->get();
        return $info;
    }

    public function updatePaymentSuccess($id, $transId, $bankName) {
        $info = $this->ptiBhtnModel->where('_id', '=' ,$id)->update([
            PtiBHTNModel::STATUS => PtiBHTNModel::STATUS_PAYMENTSUCCESS,
            PtiBHTNModel::BANK_TRANSID => $transId,
            PtiBHTNModel::BANK_NAME => $bankName
        ]);
        return $info;
    }

    public function checkPayment($id) {
        $info = $this->ptiBhtnModel->where('_id', '=' ,$id)->first();
        if ($info && (
            $info[PtiBHTNModel::STATUS] == PtiBHTNModel::STATUS_PAYMENTSUCCESS || 
            $info[PtiBHTNModel::STATUS] == PtiBHTNModel::STATUS_SUCCESS ||
            $info[PtiBHTNModel::STATUS] == PtiBHTNModel::STATUS_CALLORDER
        )) {
            return true;
        }
        return false;
    }

    /**
    * Nếu KH đã tồn tại bảo hiểm thì lấy giá trị NGAY_KT xa nhất
    * @param String $cccd
    * @return String $ngayKT
    * 
    */
    public function findNgayKTByCCCD($cccd)
    {
        $orders = $this->ptiBhtnModel->where(PtiBHTNModel::IDENTITY, '=' ,$cccd)
            ->where(PtiBHTNModel::STATUS, '=', PtiBHTNModel::STATUS_SUCCESS)->get(['pti_request.ngay_kt']);
        if (count($orders) > 0) {
            $ngayKT = $orders[0]["pti_request"]["ngay_kt"];
            foreach ($orders as $key => $value) {
                if (strtotime($ngayKT) < strtotime($value["pti_request"]["ngay_kt"])) {
                    $ngayKT = $value["pti_request"]["ngay_kt"];
                }
            }
            return $ngayKT;
        }
        return null;
    }

    public function updateHD($id, $ptiResponse, $ptiRequest) {
        $info = $this->ptiBhtnModel->where('_id', '=' ,$id)->update([
            PtiBHTNModel::PTI_INFO => $ptiResponse,
            PtiBHTNModel::PTI_REQUEST => $ptiRequest,
        ]);
        return $info;
    }

    public function updateErrors($id) {
        $info = $this->ptiBhtnModel->where('_id', '=' ,$id)->update([PtiBHTNModel::STATUS => PtiBHTNModel::STATUS_ERRORS]);
        return $info;
    }
}
