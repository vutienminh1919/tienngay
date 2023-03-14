<?php


namespace Modules\MongodbCore\Repositories;


use Carbon\Carbon;
use http\Env\Request;
use Modules\Marketing\Http\Controllers\BaseController;
use Modules\MongodbCore\Entities\LogAllotment;
use Modules\MongodbCore\Entities\LogPublication;
use Modules\MongodbCore\Entities\Qlpublications;
use Modules\MongodbCore\Entities\TradeItem;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Entities\TradeOrder;
use Modules\MongodbCore\Entities\TradeStorage;
use Modules\Marketing\Service\MarketingApi;

class QlpublicationsRepository extends BaseController
{
    protected $qlpublications;
    protected $tradeItem;
    protected $logPublication;
    protected $tradeOrder;
    protected $tradeStorage;
    protected $logAllotment;
    protected $roleRepository;
    protected $groupRoleRepository;

    public function __construct(Qlpublications $qlpublications ,
                                 TradeItem $tradeItem,
                                 LogPublication $logPublication,
                                 TradeOrder $tradeOrder,
                                 TradeStorage $tradeStorage,LogAllotment $logAllotment,
                                 RoleRepository $roleRepository,GroupRoleRepository $groupRoleRepository)
    {
        $this->qlpublications = $qlpublications;
        $this->tradeItem = $tradeItem;
        $this->logPublication = $logPublication;
        $this->tradeOrder = $tradeOrder;
        $this->tradeStorage =$tradeStorage;
        $this->logAllotment = $logAllotment;
        $this->roleRepository = $roleRepository;
        $this->groupRoleRepository = $groupRoleRepository;
    }


//khởi tạo từng ấn phẩm

    public function createOnePublication($request)
    {
        $data = [
            Qlpublications::COLUMN_ITEM_ID => $request->item_id ?? null,
            Qlpublications::COLUMN_TOTAL => $request->total ?? null,
            Qlpublications::COLUMN_IMAGE_DETAIL => $request->image_detail ?? null,
            Qlpublications::COLUMN_NAME_PUBLICATIONS => $request->name_publications ?? null,
            Qlpublications::COLUMN_TECH => $request->tech ?? null,
            Qlpublications::COLUMN_MATERIAL => $request->material ?? null,
            Qlpublications::COLUMN_SIZE => $request->size ?? null,
            Qlpublications::COLUMN_TYPE => $request->type ?? null,
            Qlpublications::COLUMN_MONEY_PUBLICATIONS => $request->money_publications ?? null,
        ];
        $result_publications = $this->qlpublications->create($data);
        //$result_publications = $this->qlpublications->push(Qlpublications::COLUMN_LEAD_PUBLICATIONS,$data);
        return $result_publications;
    }

//khởi tạo thông tin chung của ấn phẩm và từng ấn phẩm ,trạng thái mới

    public function createPublicationStatus1($request)
    {
        $data = [
            Qlpublications::COLUMN_SUPPLIER => $request->supplier ?? null,
            Qlpublications::COLUMN_OTHER_COTS => !empty($request->other_costs) ? (trim(str_replace(array(',', '.',), '', $request->other_costs))) : null,
            Qlpublications::COLUMN_DATE_ACCEPTANCE => $request->date_acceptance ? strtotime($request->date_acceptance) : null,
            Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_NEW,
            Qlpublications::COLUMN_DATE_ORDER => !empty($request->date_order) ? strtotime($request->date_order) : null,
            Qlpublications::COLUMN_SUM_ITEM_ID => $request->sum_item_id ?? null,
            Qlpublications::COLUMN_SUM_MONEY_PUBLICATIONS => !empty($request->sum_money_publications) ? (trim(str_replace(array(',', '.',), '', $request->sum_money_publications))) : null,
            Qlpublications::COLUMN_SUM_TOTAL => $request->sum_total ?? null,
            Qlpublications::CREATED_BY => $request->created_by ?? null
        ];
        foreach ($request['lead_publications'] as $key => $value){
            $id = time() . $key;
            $lead_publications = [
                Qlpublications::COLUMN_KEY_ID => $id,
                Qlpublications::COLUMN_ITEM_ID => $value['item_id'] ?? null,
                Qlpublications::COLUMN_TOTAL => (int)$value['total'] ?? null,
                Qlpublications::COLUMN_IMAGE_DETAIL => $value['image_detail'] ?? null,
                Qlpublications::COLUMN_NAME_PUBLICATIONS => $value['name_publications'] ?? null,
                Qlpublications::COLUMN_SPECIFICATION => $value['specification'] ?? null,
                Qlpublications::COLUMN_MONEY_PUBLICATIONS => !empty($value['money_publications']) ?(trim(str_replace(array(',', '.',), '', $value['money_publications']))): null,
                Qlpublications::COLUMN_MONEY_TOTAL => (trim(str_replace(array(',', '.',), '', $value['money_publications']))) * $value['total'],
                Qlpublications::COLUMN_TYPE =>  $value['type'],
                Qlpublications::COLUMN_PRICE => $value['price'],
                Qlpublications::COLUMN_TOTAL_CLONE => $value['total'],
                Qlpublications::COLUMN_TOTAL_ALLOTMENT => !empty($value['total_allotment']) ? $value['total_allotment'] : 0,
                Qlpublications::COLUMN_TOTAL_QUANTITY_TESTED => !empty($value['total_quantity_tested']) ? $value['total_quantity_tested'] : 0,
                Qlpublications::COLUMN_TOTAL_ACCEPTANCE => !empty($value['total_acceptance']) ? $value['total_acceptance'] : 0,
            ];
            $data['lead_publications'][$id] = $lead_publications;
        }
        $result['result'] = $this->qlpublications->create($data);
        $result['_id'] = $result['result']['_id'];
        return $result;
    }


//khởi tạo thông tin chung của ấn phẩm và từng ấn phẩm ,trạng thái đã đặt hàng
    public function createPublicationStatus2($request)
    {
        $data = [
            Qlpublications::COLUMN_SUPPLIER => $request->supplier ?? null,
            Qlpublications::COLUMN_OTHER_COTS => !empty($request->other_costs) ? (trim(str_replace(array(',', '.',), '', $request->other_costs))) : null,
            Qlpublications::COLUMN_DATE_ACCEPTANCE => $request->date_acceptance ? strtotime($request->date_acceptance) : null,
            Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_ORDERED,
            Qlpublications::COLUMN_DATE_ORDER => !empty($request->date_order) ? strtotime($request->date_order) : null,
            Qlpublications::COLUMN_SUM_ITEM_ID => $request->sum_item_id ?? null,
            Qlpublications::COLUMN_SUM_MONEY_PUBLICATIONS => !empty($request->sum_money_publications) ? (trim(str_replace(array(',', '.',), '', $request->sum_money_publications))) : null,
            Qlpublications::COLUMN_SUM_TOTAL => $request->sum_total ?? null,
            Qlpublications::CREATED_BY => $request->created_by ?? null
        ];
        foreach ($request['lead_publications'] as $key => $value){
            $id = time() . $key;
            $lead_publications = [
                Qlpublications::COLUMN_KEY_ID => $id,
                Qlpublications::COLUMN_ITEM_ID => $value['item_id'] ?? null,
                Qlpublications::COLUMN_TOTAL => (int)($value['total']) ?? null,
                Qlpublications::COLUMN_IMAGE_DETAIL => $value['image_detail'] ?? null,
                Qlpublications::COLUMN_NAME_PUBLICATIONS => $value['name_publications'] ?? null,
                Qlpublications::COLUMN_SPECIFICATION => $value['specification'] ?? null,
                Qlpublications::COLUMN_MONEY_PUBLICATIONS => !empty($value['money_publications']) ?(trim(str_replace(array(',', '.',), '', $value['money_publications']))): null,
                Qlpublications::COLUMN_MONEY_TOTAL => (trim(str_replace(array(',', '.',), '', $value['money_publications']))) * $value['total'],
                Qlpublications::COLUMN_TYPE => $value['type'],
                Qlpublications::COLUMN_PRICE => $value['price'],
                Qlpublications::COLUMN_TOTAL_CLONE => $value['total'],
                Qlpublications::COLUMN_TOTAL_ALLOTMENT => !empty($value['total_allotment']) ? $value['total_allotment'] : 0,
                Qlpublications::COLUMN_TOTAL_QUANTITY_TESTED => !empty($value['total_quantity_tested']) ? $value['total_quantity_tested'] : 0,
                Qlpublications::COLUMN_TOTAL_ACCEPTANCE => !empty($value['total_acceptance']) ? $value['total_acceptance'] : 0,
            ];
            $data['lead_publications'][$id] = $lead_publications;
        }
        $result['result'] = $this->qlpublications->create($data);
        $result['_id'] = $result['result']['_id'];
        return $result;
    }

//chi tiết danh mục ấn phẩm
        public function detailPublication($id)
    {
        $result = $this->qlpublications
        ->where([Qlpublications::ID => $id])
        ->first();
        return $result;
    }
//nghiệm thu ấn phẩm
//    public function acceptancePublication($data, $id)
//    {
//        $bool = false;
//        $result = $this->qlpublications->where([Qlpublications::ID => $id])->first()->toArray();
//        if ($result) {
//            foreach ($result['lead_publications'] as $key => $value) {
//                $id_key = $key;
//                $value["total_acceptance"] = (int)($data['lead_publications'][$key]['total_acceptance']);
//                $update = [
//                    "lead_publications.$key" => $value
//                ];
//                $this->qlpublications->where([Qlpublications::ID => $id])->update($update);
//            }
//        }
//        $resultFindOne = $this->qlpublications->find($id)->toArray();
//        if ($resultFindOne){
//            foreach ($resultFindOne['lead_publications'] as $k => $v){
//                $total = $v['total'];
//                $total_acceptance = $v['total_acceptance'];
//                $key_id = $k;
//                $total1 = $total - $total_acceptance;
//                $v['total'] =  $total1;
//                $update1 = [
//                    "lead_publications.$k" => $v
//                ];
//                if ($total >= $total_acceptance){
//                    $a = $this->qlpublications->where([Qlpublications::ID => $id])
//                    ->update($update1);
//                    $this->qlpublications->where([Qlpublications::ID => $id])
//                    ->update([Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_ACCEPTANCE_END]);
//                     $bool = true;
//                }else{
//                    $bool = false;
//                }
//            }
//        }
//        return $bool;
//    }

//lấy từng ấn phẩm trong phiếu đặt hàng ấn phẩm
    public function findPublication($id)
    {
        $lead = [];
        $result = $this->qlpublications->select([Qlpublications::COLUMN_LEAD_PUBLICATIONS])
        ->where([Qlpublications::ID => $id])->first()->toArray();
        if ($result){
            foreach ($result['lead_publications'] as $key => $value){
                 $lead[] = [$key => $value];
            }
        }
        return $lead;
    }

    public function findPublication1($data)
    {
        $lead = [];
        $result = $this->qlpublications->select([Qlpublications::COLUMN_LEAD_PUBLICATIONS.'.'.$data[Qlpublications::COLUMN_ID_PUBLICATION]])
        ->where([Qlpublications::ID => $data[Qlpublications::ID]])->first()->toArray();
        if ($result){
            foreach ($result['lead_publications'] as $key => $value){
                 $lead[] = [$key => $value];
            }
        }
        return $lead;
    }

//log hệ thống thông báo
    public function log($id, $action,$createdBy)
    {
        $log = [
            'action' => $action,
            'created_by' => $createdBy,
            'created_at' => time()
        ];
        $updateLog = $this->qlpublications::where(Qlpublications::ID, $id)
            ->push(Qlpublications::COLUMN_LOG, $log);
    }



//logs lịch sử nghiệm thu
public function acceptancePublication($data1)
    {
        if (!empty($data1)) {
            // 1: find old data
            $resultOld = $this->qlpublications->where([Qlpublications::ID => $data1['_id']])->first();
            $leadPublicationsOld = $resultOld['lead_publications'];
            // 2: create new data
            $leadPublicationsNew = $resultOld['lead_publications'];
        }else{
            return  false;
        }

        foreach ($data1['data'] as $key => $value) {
            $valueTotalAcceptane = !empty($value['total_acceptance']) ? $value['total_acceptance'] :  0 ;
            $leadPublicationsNew[$value['key']]['total_acceptance'] = $valueTotalAcceptane;
            $leadPublicationsNew[$value['key']]['total_quantity_tested'] = $valueTotalAcceptane;
        }

        //4: update QLPublication
        $dataSave = $resultOld['lead_publications'];
        $bool = true;
        foreach ($leadPublicationsNew as $key => $value) {
            $dataTotal = $value['total'];
            //$dataTotalAcceptance = $value['total_acceptance'];
            $dataTotalAcceptance = $value['total_acceptance'];
            if ($dataTotal >= $dataTotalAcceptance) {
                $dataSave[$key]['total'] = $dataTotal - $dataTotalAcceptance;
                $oldTotalAccept = !empty($leadPublicationsOld[$key]['total_acceptance']) ? $leadPublicationsOld[$key]['total_acceptance'] : 0;
                $total_quantity_tested = !empty($leadPublicationsOld[$key]['total_quantity_tested']) ? $leadPublicationsOld[$key]['total_quantity_tested'] : 0;
                //$dataSave[$key]['total_acceptance'] = $value['total_acceptance'] + $oldTotalAccept;
                $dataSave[$key]['total_acceptance'] = $dataTotalAcceptance + $oldTotalAccept;
                //$dataSave[$key]['total_quantity_tested'] = $value['total_acceptance'] + $total_quantity_tested;
                $dataSave[$key]['total_quantity_tested'] = $dataTotalAcceptance + $total_quantity_tested;
            } else {
                $bool = false;
            }
        }
        if (!$bool) {
            // nghiem thu that bai
            return false;
        }

        // 3: save log
        $dataLog = [
            LogPublication::COLUMN_CONTRACT_ID => $resultOld['_id'],
            LogPublication::STATUS_OLD => $leadPublicationsOld,
            LogPublication::CREATED_BY => !empty($data1['created_by']) ? $data1['created_by'] : 'ItTest@tienngay.vn',
            LogPublication::STATUS_NEW => $leadPublicationsNew,
            LogPublication::COLUMN_IMAGE_ACCEPTION => $data1['image_acception'] ?? null
        ];
        $this->logPublication->create($dataLog);

        $resultOld->lead_publications = $dataSave;
        $resultOld->save();
        $result_publications = $this->qlpublications->where([Qlpublications::ID => $data1['_id']])->first();
        if ($result_publications) {
            $leadDataTotal = [];
            foreach ($result_publications['lead_publications'] as $k => $v) {
                $totalDataAll = $v['total'];
                $leadDataTotal[] = $totalDataAll;
            }
        }
        $sumDataTotal = array_sum($leadDataTotal);
        if ($sumDataTotal == '0'){
            $dataUpdate = [
              Qlpublications::COLUMN_DATE_ACCEPTANCE_COMPLETE => Carbon::now()->timestamp,
              Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_COMPLETE
            ];
            $this->qlpublications->where([Qlpublications::ID => $data1['_id']])->update($dataUpdate);

        }else{
            $this->qlpublications->where([Qlpublications::ID => $data1['_id']])->update([Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_ACCEPTANCE_END]);
        }
        return $bool;
    }

//lấy chi tiết ấn phẩm thay đổi theo từng lần nghiệm thu của đơn đặt hàng
    public function findLog($data)
    {
        $lead = [];
        $result = $this->logPublication->where(LogPublication::ID,$data[LogPublication::ID])
        ->first()->toArray();
         if ($result){
            foreach ($result['status_new'] as $key => $value){
                $lead[] = $value;
            }
         }
         return $lead;
    }

//lấy tất cả log nghiệm thu

    public function allLogAcceptance($id)
    {
        $result = $this->logPublication->where(LogPublication::COLUMN_CONTRACT_ID,$id)->get()->toArray();
        if (!empty($result)){
            foreach ($result as $key => $value){
                if (!empty($value['status_new'])) {
                    //$result[$key]['sumTotal'] = 0;
                    $result[$key]['arrTotal'] = [];
                    $result[$key]['arrTotalSum'] = [];
                    $result[$key]['sumTotal'] = 0;
                    $result[$key]['sumTotalAcception'] = 0;
                    foreach ($value['status_new'] as $ke => $va) {
                        if (!empty($va['total']) && $va['total'] > '0') {
                            $result[$key]['arrTotal'][] = ($va['total']);
                            $result[$key]['sumTotalAcception'] +=  (int)$va['total_acceptance'];
                            $result[$key]['sumTotal'] = count($result[$key]['arrTotal']);
                            if(!empty($va['total_acceptance']) && (int)$va['total_acceptance'] > 0){
                                $result[$key]['arrTotalSum'][] = ((int)($va['total_acceptance']));
                                $result[$key]['arrTotalSumPb'] = count($result[$key]['arrTotalSum']);
                            }

                        }
                    }
                }
            }
        }
        return $result;
    }


//ghi chú từng ấn phẩm(màn chi tiết)
    public function notePublications($data)
    {
        $result = $this->qlpublications->where([Qlpublications::ID => $data[Qlpublications::ID]])->first()->toArray();
        if (!empty($result)) {
            $dataNote = Qlpublications::COLUMN_NOTE_PUBLICATIONS;
            $dataNote = [
                Qlpublications::COLUMN_NOTE => !empty($data['note']) ? $data['note'] : null,
                Qlpublications::COLUMN_DESCRIPTION => !empty($data['description']) ? $data['description'] : null,
                //Qlpublications::CREATED_BY => 'ducta@tienngay.vn',
                Qlpublications::CREATED_BY => !empty($data['created_by']) ? $data['created_by'] : 'ITtest@tienngay.vn',
                Qlpublications::CREATED_AT => time(),
            ];
            $keyId = $data['id_publication'];
            foreach ($result['lead_publications'] as $key => $value) {
                if ($key == $keyId) {
                    $resultNote = $this->qlpublications
                        ->where([Qlpublications::ID => $data[Qlpublications::ID]])
                        ->push("lead_publications.$keyId.note_description", $dataNote);
                    $result_note['result_note'] = $resultNote;
                    $resultIdNote = $this->qlpublications->where([Qlpublications::ID => $data[Qlpublications::ID]])->first();
                    $resultIdNotePb = $resultIdNote->lead_publications[$key];
                    $result_note['resultIdNote'] = $resultIdNotePb;
                }
            }
        }
        return $result_note;
    }

//sửa từng ấn phẩm
//    public function updatePublications($data,$id)
//    {
//        $result = [];
//        $result1 = $this->qlpublications->find($id);
//        if (isset($data['supplier'])) {
//            $result[Qlpublications::COLUMN_SUPPLIER] = $data['supplier'];
//        }
//
//        if (isset($data['other_costs'])) {
//            $result[Qlpublications::COLUMN_OTHER_COTS] = $data['other_costs'];
//        }
//
//        if (isset($data['date_acceptance'])) {
//            $result[Qlpublications::COLUMN_DATE_ACCEPTANCE] = strtotime($data['date_acceptance']);
//        }
//
//        if (isset($data['sum_item_id'])) {
//            $result[Qlpublications::COLUMN_SUM_ITEM_ID] = strtotime($data['sum_item_id']);
//        }
//
//        if (isset($data['sum_money_publications'])) {
//            $result[Qlpublications::COLUMN_SUM_MONEY_PUBLICATIONS] = strtotime($data['sum_money_publications']);
//        }
//
//        if (isset($data['sum_total'])) {
//            $result[Qlpublications::COLUMN_SUM_TOTAL] = strtotime($data['sum_total']);
//        }
//
//
//        $leadPublications = $result1['lead_publications'];
//        if (!empty($result1)) {
//            foreach ($result1['lead_publications'] as $key => $value) {
//                if (isset($data['lead_publications'][$key]['item_id'])) {
//                    $leadPublications[$key]['item_id'] = $data['lead_publications'][$key]['item_id'];
//                }
//                if (isset($data['lead_publications'][$key]['total'])) {
//                    $leadPublications[$key]['total'] = $data['lead_publications'][$key]['total'];
//                }
//                if (isset($data['lead_publications'][$key]['money_publications'])) {
//                    $leadPublications[$key]['money_publications'] = $data['lead_publications'][$key]['money_publications'];
//                }
//
//                if (isset($data['lead_publications'][$key]['money_total'])) {
//                    $leadPublications[$key]['money_total'] = $data['lead_publications'][$key]['money_total'];
//                }
//
//                if (isset($data['lead_publications'][$key]['type'])) {
//                    $leadPublications[$key]['type'] = $data['lead_publications'][$key]['type'];
//                }
//
//
//                if (isset($data['lead_publications'][$key]['price'])) {
//                    $leadPublications[$key]['price'] = $data['lead_publications'][$key]['price'];
//                }
//
//                if (isset($data['lead_publications'][$key]['specification'])) {
//                    $leadPublications[$key]['specification'] = $data['lead_publications'][$key]['specification'];
//                }
//
//            }
//        }
//        $result1->lead_publications = $leadPublications;
//        $result1->save();
//        if (empty($result)) {
//            return false;
//        }
//        $update_ublications = $this->qlpublications
//            ->where([Qlpublications::ID => $id])
//            ->update($result);
//        return  $update_ublications;
//    }

//lấy hết tất cả các phiếu đặt ấn phẩm

    public function getAllPublications($data,$export = false)
    {
        $result = $this->qlpublications;
        if (!empty($data['status'])) {
            $result = $result->where(Qlpublications::COLUMN_STATUS, (int)$data['status']);
        }

        if (!empty($data['supplier'])) {
            //$result = $result->where(Qlpublications::COLUMN_SUPPLIER, $data['supplier']);
            $result = $result->where(Qlpublications::COLUMN_SUPPLIER, 'like', '%' . $data['supplier'] . '%');
        }
        //ngày nghiệm thu dự kiến

        if (!empty($data['date_acceptance_start']) || !empty($data['date_acceptance_end'])) {
            $startDateAcceptance = !empty($data['date_acceptance_start']) ? strtotime(($data['date_acceptance_start']) . ' 00:00:00') : 1;
            $endDateAcceptance = !empty($data['date_acceptance_end']) ? strtotime($data['date_acceptance_end'] . ' 23:59:59') : time();
            $result = $result->whereBetween(Qlpublications::COLUMN_DATE_ACCEPTANCE, [$startDateAcceptance, $endDateAcceptance]);
        } elseif (!empty($data['date_acceptance_complete_start']) || !empty($data['date_acceptance_complete_end'])) {
            $startDateAcceptanceComplete = !empty($data['date_acceptance_complete_start']) ? strtotime(($data['date_acceptance_complete_start']) . ' 00:00:00') : 1;
            $endDateAcceptanceComplete = !empty($data['date_acceptance_complete_end']) ? strtotime($data['date_acceptance_complete_end'] . ' 23:59:59') : time();
            $result = $result->whereBetween(Qlpublications::COLUMN_DATE_ACCEPTANCE_COMPLETE, [$startDateAcceptanceComplete, $endDateAcceptanceComplete]);
        } elseif (!empty($data['date_order_start']) || !empty($data['date_order_end'])) {
            $startDateOrder = !empty($data['date_order_start']) ? strtotime(($data['date_order_start']) . ' 00:00:00') : 1;
            $endDateOrder = !empty($data['date_order_end']) ? strtotime($data['date_order_end'] . ' 23:59:59') : Carbon::now()->timestamp;
            $result = $result->whereBetween(Qlpublications::COLUMN_DATE_ORDER, [$startDateOrder, $endDateOrder]);
        }



        //ngày nghiệm thu hoàn thành
        //ngày đặt hàng
        if (!$export){
            $result = $result->
            whereIn(Qlpublications::COLUMN_STATUS,
                [Qlpublications::STATUS_NEW,
                    Qlpublications::STATUS_ORDERED,
                    Qlpublications::STATUS_ACCEPTANCE,
                    Qlpublications::STATUS_ACCEPTANCE_END,
                    Qlpublications::STATUS_COMPLETE]);
            return $result
                ->orderBy(Qlpublications::CREATED_AT, self::DESC)
                ->paginate(20);
        }else{
            $result = $result->
            whereIn(Qlpublications::COLUMN_STATUS,
                [Qlpublications::STATUS_NEW,
                    Qlpublications::STATUS_ORDERED,
                    Qlpublications::STATUS_ACCEPTANCE,
                    Qlpublications::STATUS_ACCEPTANCE_END,
                    Qlpublications::STATUS_COMPLETE]);
            return $result
                ->orderBy(Qlpublications::CREATED_AT, self::DESC)
                ->get();
        }
    }

//xóa mềm (update trạng thái block)

    public function updateStatusBlock($data)
    {
        $bool = false;
        $result_publications = $this->qlpublications->where([Qlpublications::ID => $data[Qlpublications::ID]])->first();
        if ($result_publications['status'] == 1){
             $result = $this->qlpublications->where([Qlpublications::ID => $data[Qlpublications::ID]])->update([Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_BLOCK]);
             $bool = true;
        }else{
            $bool = false;
        }
        return $bool;
    }

//đặt hàng (update trạng thái đã đặt hàng)

    public function updateStatusOrder($data)
    {
        $bool = false;
        $result_publications = $this->qlpublications->where([Qlpublications::ID => $data[Qlpublications::ID]])->first();
        if ($result_publications['status'] == 1) {
            $result = $this->qlpublications->where([Qlpublications::ID => $data[Qlpublications::ID]])->update([Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_ORDERED]);
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }

//ghi chú từng phiếu đặt hàng ấn phẩm(màn danh sách tất cả  phiếu đặt hàng)

    public function noteOnePublication($data)
    {
        $data1 = [];
        if (!empty($data['description_publications'])){
            $data1[Qlpublications::COLUMN_DESCRIPTION_PUBLICATIONS] = $data['description_publications'];
        }
        if (!empty($data['title_note_publications'])) {
            $data1[Qlpublications::COLUMN_TITLE_NOTE_PUBLICATIONS] = $data['title_note_publications'];
        }
        //$data1[Qlpublications::CREATED_BY] = 'ducta@tienngay.vn';
        $data1[Qlpublications::CREATED_BY] = $data['created_by'];
        $data1[Qlpublications::CREATED_AT] = time();
        if ($data1){
            $resultSaveNote = $this->qlpublications->where([Qlpublications::ID => $data[Qlpublications::ID]])->push('lead_note',$data1);
        }
        $result['saveNote'] = $resultSaveNote;
        $resultId = $this->qlpublications->find($data[Qlpublications::ID])->toArray();
        $result['idNote'] = $resultId;
        return $result;
    }

//lấy tất cả các mẫu ấn phẩm

    public function allTradePublication()
    {
        $result = $this->tradeItem->where([TradeItem::STATUS => TradeItem::STATUS_ACTIVE])->get();
        return $result;
    }

//lấy tất cả các mẫu  ấn phảm  theo (item_id)

    public function findOneTrade($data)
    {
        $result = $this->tradeItem->where(TradeItem::ITEM_ID,$data[TradeItem::ITEM_ID])->first();
        return $result;
    }

//lấy một publication

    public function findPublications($data)
    {
        $result = $this->qlpublications->where([Qlpublications::ID => $data['_id']])->first()->toArray();
        return $result;
    }
//COLUMN_DATE_ORDER

    public function updatePublications($data)
    {
        $result1 = $this->qlpublications->find($data['_id']);
        $lead_publications = [];
        if (isset($data['supplier'])) {
            $result1[Qlpublications::COLUMN_SUPPLIER] = $data['supplier'];
        }
        if (isset($data['other_costs'])) {
            $result1[Qlpublications::COLUMN_OTHER_COTS] = (trim(str_replace(array(',', '.',), '', $data['other_costs'])));
        }
        if (isset($data['date_acceptance'])) {
            $result1[Qlpublications::COLUMN_DATE_ACCEPTANCE] = strtotime($data['date_acceptance']);
        }
        if (isset($data['date_order'])) {
            $result1[Qlpublications::COLUMN_DATE_ORDER] = strtotime($data['date_order']);
        }
        if (isset($data['sum_item_id'])) {
            $result1[Qlpublications::COLUMN_SUM_ITEM_ID] = $data['sum_item_id'];
        }
        if (isset($data['sum_money_publications'])) {
            $result1[Qlpublications::COLUMN_SUM_MONEY_PUBLICATIONS] = (trim(str_replace(array(',', '.',), '', $data['sum_money_publications'])));
        }
        if (isset($data['sum_total'])) {
            $result1[Qlpublications::COLUMN_SUM_TOTAL] = $data['sum_total'];
        }
        foreach ($data['lead_publications'] as $key => $value) {
            $a = $this->tradeItem->where([TradeItem::ITEM_ID => $value['item_id']])->first();
            $dataPublic = [
                Qlpublications::COLUMN_KEY_ID => (string)$key,
                Qlpublications::COLUMN_ITEM_ID => $value['item_id'],
                Qlpublications::COLUMN_TOTAL => $value['total'],
                Qlpublications::COLUMN_MONEY_PUBLICATIONS => (trim(str_replace(array(',', '.',), '', $value['money_publications']))),
                Qlpublications::COLUMN_MONEY_TOTAL => (trim(str_replace(array(',', '.',), '', $value['money_total']))),
                Qlpublications::COLUMN_TYPE => $value['type'],
                Qlpublications::COLUMN_PRICE => $value['price'],
                Qlpublications::COLUMN_SPECIFICATION => $value['specification'],
                Qlpublications::COLUMN_NAME_PUBLICATIONS => $value['name_publications'],
                Qlpublications::COLUMN_TOTAL_CLONE => $value['total'],
                Qlpublications::COLUMN_IMAGE_DETAIL => $a['path'],
                Qlpublications::COLUMN_TOTAL_ALLOTMENT => !empty($value['total_allotment']) ? $value['total_allotment'] : 0,
                Qlpublications::COLUMN_TOTAL_QUANTITY_TESTED => !empty($value['total_quantity_tested']) ? $value['total_quantity_tested'] : 0,
                Qlpublications::COLUMN_TOTAL_ACCEPTANCE => !empty($value['total_acceptance']) ? $value['total_acceptance'] : 0,
            ];
            $lead_publications[(string)$key] = $dataPublic;
        }
        $result1->lead_publications = $lead_publications;
        $result1->save();
        return $result1;
    }
//tìm từng ấn phẩm
    public function findOneKeyId($id,$key_id)
    {
        $result = $this->qlpublications->where([Qlpublications::ID => $id])->first();
        if ($result && !empty($result['lead_publications'][$key_id])) {
            return $result['lead_publications'][$key_id];
        }
        return null;
    }

//cập nhật trạng thái từ đã dặt hàng sang chờ mkt nghiệm thu
    public function changeStatusAcception()
    {
        $bool = false;
        $startDate = Carbon::now()->format('Y-m-d 00:00:00');
        $endDate = Carbon::now()->format('Y-m-d 23:59:59');
        $result = $this->qlpublications
            ->whereBetween(Qlpublications::COLUMN_DATE_ACCEPTANCE, [strtotime($startDate), strtotime($endDate)])
            ->where([Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_ORDERED])
            ->get();
        if ($result){
            foreach ($result as $key => $value){
                if ($value['status'] == 2){
                    $resultTime = $this->qlpublications
                    ->where(Qlpublications::ID,$value['_id'])
                    ->update([Qlpublications::COLUMN_STATUS => Qlpublications::STATUS_ACCEPTANCE]);
                    $bool =true;
                }else{
                    $bool =false;
                }
            }
            $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/publication/detail_publics/";
            $tpMkt = $this->roleRepository->getTPMKT();
            $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
            $hcns =  config('mongodbcore.tradeMkt.HCNS');
            $user = array_merge($tpMkt, $tradeMkt);
            $dataSendEmail = [
                "url" => $url,
                "publication" => $result->toArray(),
                "user" => array_unique($user),
                'flag' => "2",
            ];
            $sendEmail = MarketingApi::sendEmailPublication($dataSendEmail);
        }
        return $bool;
    }

//lây hết các phiếu order trạng thái =3 và tiến trình =7
    public function getAllTradeOder($id,$key_id)
    {
        $result = $this->qlpublications->where([Qlpublications::ID => $id])->first();
        if (empty($result['lead_publications'][$key_id])) {
            return false;
        }
        $findPb = $result['lead_publications'][$key_id];
        $condition = [];
        $condition['progress'] = TradeOrder::PROGRESS_HCNS_BUYING;
        $status = TradeOrder::STATUS_WAIT_APPROVE;
        $itemCode = $findPb['item_id'];

        $item = TradeOrder::raw(function ($collection) use ($condition, $itemCode,$status) {
            return $collection->aggregate([
                ['$unwind' => '$items'],
                ['$match' => (object)[
                    'progress' => TradeOrder::PROGRESS_HCNS_BUYING,
                    'items.item_code' => $itemCode,
                    'status' => TradeOrder::STATUS_WAIT_APPROVE
                ]],
                [
                    '$group' => [
                        '_id' => '$_id',
                        'store_id' =>  ['$addToSet' => '$store_id'],
                        'item_quantity' => ['$sum' => '$items.item_quantity'],
                        //'item_quantity' => ['$addToSet' => '$items.item_quantity'],
                        'received_amount' => ['$sum' => '$items.received_amount'],
                        'store_name' => ['$addToSet' => '$store_name'],
                        'plan_name' => ['$addToSet' => '$plan_name'],
                        "total_remaining" => ['$sum' => ['$subtract' => ['$items.item_quantity', '$items.received_amount']]],
                    ]
                ]
            ]);
        });
        $a = $item->toArray();
        return $a;

    }
//actual_price
//AP49ABE2E7
//total_allotment
// phân bổ về các phòng giao dịch
    public function allotmentPublication($data,$id,$key_id)
    {
        $bool = false;
        $arrAllotment = [];
        $resultPub = $this->getAllTradeOder($id,$key_id);
        foreach ($data['data'] as $key => $value){
            $arrAllotment[] = $value['total_allotment'];
            if ($resultPub){
                foreach ($resultPub as $ky => $vl){
                    if ($vl['_id'] == $value['id_request']){
                        $sumQuantityReceived = $vl['item_quantity'] - $vl['received_amount'];
                        if ($value['total_allotment'] < $sumQuantityReceived){
                            $bool = true;
                        }
                    }
                }
            }
        }
        $sumAllotment = array_sum($arrAllotment);
        $lead = [];
        $test = $this->qlpublications->where([Qlpublications::ID => $data['_id']])->first();
        $actual_price = $test['lead_publications'][$key_id]['money_publications'];
        $supplier = $test['supplier'];
        foreach ($test['lead_publications'] as $ke => $va){
            if ($data['code_item'] == $va['item_id'] && ($sumAllotment <= $va['total_acceptance'])) {
                $va['total_allotment'] = $sumAllotment;
                $total_acceptanceLive = $va['total_quantity_tested'] - $sumAllotment;
                $va['total_quantity_tested'] = $total_acceptanceLive;
                $bool = true;
            }
             $lead[$ke] = $va;
        }
        $test->lead_publications = $lead;
        $test->save();
        if ($data) {
            foreach ($data['data'] as $a => $v) {
                $total_allotment = $v['total_allotment'];
                $store_id = $v['store_id'];
                $id_request = $v['id_request'];
                //tìm từng yêu cầu ấn phẩm theo id_request
                $resultOrder = $this->tradeOrder->where([TradeOrder::ID => $v['id_request']])->first();
                //lấy thông tin của ấn phẩm
                $resultTradeItem = $this->tradeItem->where([TradeItem::ITEM_ID => $data['code_item']])->first()->toArray();
                //tìm phòng giao dịch theo store_id
                //$result = $this->tradeStorage->where([TradeStorage::STORE_ID => $v['store_id']])->first();
                if (!empty($resultOrder)) {
                    $storageItems = [];
                    $checkExist = false;
                    foreach ($resultOrder->items as $ke => $value) {
                        if (!empty($data['code_item']) && ($value['item_code'] == $data['code_item'])) {
                            //$value['quantity_stock'] += $total_allotment;
                            $value['last_quantity_import'] = (int)$total_allotment;
                            $checkExist = true;
                            $dataTradeOder = [
                                'key' => time() . $a++,
                                'ncc' => $supplier,
                                'actual_price' => (int)$actual_price,
                                'type' => $value['item_type'],
                                'item_name' => $value['item_name'],
                                'specification' => $value['item_specifications'],
                                'item_id' => $value['item_id'],
                                'item_code' => $value['item_code'],
                                'quantity_import' => (int)$total_allotment,
                                'created_at' => Carbon::now()->timestamp,
                                'created_by' => !empty($data['created_by']) ? $data['created_by'] : 'ItTest@tienngay.vn'

                            ];
                            $this->tradeOrder->where([TradeOrder::ID => $id_request])
                                ->push('logs_allotment', $dataTradeOder);
                        }
                    }
                    $bool = true;
                } else {
                     $bool = false;
                }
            }
        }
        return $bool;
    }


    public function findLog1($data)
    {
        $lead = [];
        $result = $this->logPublication->where(LogPublication::ID,$data[LogPublication::ID])
        ->first()->toArray();
          $lead['id_clone'] = $result['_id'];
          $lead['image_acception'] = $result['image_acception'];
         return $lead;
    }










}
