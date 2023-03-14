<?php


namespace Modules\Marketing\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Marketing\Service\MarketingApi;
use Response;
use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\LogPublicationRepository;
use Modules\MongodbCore\Repositories\QlpublicationsRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MysqlCore\Repositories\Interfaces\MailRepositoryInterface as MailRepository;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\StoreRepository;

class QlpublicationsController extends BaseController
{
    private $qlpublicationsRepository;
    private $tradeItemRepository;
    private $logPublicationRepository;
    private $mailRepository;
    private $roleRepository;
    private $groupRoleRepository;
    private $storeRepository;

    public function __construct(TradeItemRepository $tradeItemRepository,
                                QlpublicationsRepository $qlpublicationsRepository
                                ,LogPublicationRepository $logPublicationRepository,MailRepository $mailRepository,
                                RoleRepository $roleRepository,
                                GroupRoleRepository $groupRoleRepository,
                                StoreRepository $storeRepository)
    {
        $this->tradeItemRepository = $tradeItemRepository;
        $this->qlpublicationsRepository = $qlpublicationsRepository;
        $this->logPublicationRepository = $logPublicationRepository;
        $this->roleRepository = $roleRepository;
        $this->groupRoleRepository = $groupRoleRepository;
        $this->storeRepository = $storeRepository;
    }

//khởi tạo từng ấn phẩm
    public function create_one_publication(Request $request)
    {
        $result = $this->qlpublicationsRepository->createOnePublication($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert success", $result);
    }

//khởi tạo thông tin chung của ấn phẩm và từng ấn phẩm trạng thái mới
    public function create_publication_status1(Request $request)
    {
        //return response()->json($request->all());
        $result = $this->qlpublicationsRepository->createPublicationStatus1($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert success", $result);
    }
//khởi tạo thông tin chung của ấn phẩm và từng ấn phẩm trạng thái đã đặt hàng
    public function create_publication_status2(Request $request)
    {
        $result = $this->qlpublicationsRepository->createPublicationStatus2($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert success", $result);
    }

//nghiệm thu ấn phẩm và logs lịch sử nghiệm thu
    public function acceptance_publication(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $validate = Validator::make($data, [
            //'image_acception' => 'required',
            //'data.*.total_acceptance' => 'numeric',
            'data.*.total_acceptance' => 'alpha_num|integer',
        ],
            [
                //'image_acception.required' => "Chứng từ nghiệm thu không được để trống",
                //'data.*.total_acceptance.numeric' => "Chỉ được nhập số",
                'data.*.total_acceptance.alpha_num' => "Chỉ được nhập số nguyên",
                'data.*.total_acceptance.integer' => "Chỉ được nhập số",
            ]);
        if ($validate->fails()) {
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $validate->errors()->first());
        }
        $action = "Nghiệm thu ấn phẩm thành công";
        $action1 = "Nghiệm thu ấn phẩm thất bại(số lượng ấn phẩm thực tế lớn hơn số ấn phẩm đặt mua)";
        $action2 = "Nghiệm thu ấn phẩm thất bại(trạng thái nghiệm thu không đúng)";
        $resultFindOne = $this->qlpublicationsRepository->detailPublication($data['_id']);
        if (!empty($resultFindOne) && ($resultFindOne['status'] == 3 || $resultFindOne['status'] == 4 || $resultFindOne['status'] == 2)) {
            $result = $this->qlpublicationsRepository->acceptancePublication($data);
            if (!empty($result) && ($result == 1)) {
                $this->qlpublicationsRepository->log($data['_id'], $action, 'recording system');
                $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/publication/detail_publics/" . $data['_id'];
                $detail = $this->qlpublicationsRepository->detailPublication($data['_id']);
                $hcns = config("marketing.HCNS");
                $tpMkt = $this->roleRepository->getTPMKT();
                $user = array_merge($hcns, $tpMkt);
                $dataSendEmail = [
                    "publication" => $detail['lead_publications'],
                    "user" => array_unique($user),
                    'url'  => $url,
                    "flag" => '4',
                ];
                $sendEmail = MarketingApi::sendEmailPublication($dataSendEmail);
                return BaseController::sendResponse(BaseController::HTTP_OK, "Nghiệm thu thành công",$result);
            } else {
                $this->qlpublicationsRepository->log($data['_id'], $action1, 'recording system');
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "Nghiệm thu thất bại(kiểm tra lại số lượng nghiệm thu của từng ấn phẩm)");
            }
        } else {
            $this->qlpublicationsRepository->log($data['_id'], $action2, 'recording system');
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "Trạng thái nghiệm thu không đúng");
        }
    }

//lấy từng ấn phẩm trong phiếu đặt hàng ấn phẩm
    public function find_publication($id)
    {
        $result = $this->qlpublicationsRepository->findPublication($id);
        return BaseController::sendResponse(BaseController::HTTP_OK, "acceptance success", $result);
    }
    public function find_publication1(Request $request)
    {
        $data =$request->all();
        $result = $this->qlpublicationsRepository->findPublication1($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "acceptance success", $result);
    }

//chi tiết từng phiếu đặt hàng ấn phẩm
    public function detail_publication($id)
    {
        $result = $this->qlpublicationsRepository->detailPublication($id);
        return BaseController::sendResponse(BaseController::HTTP_OK, "find success", $result);
    }

//lấy tất cả ấn phẩm thay đổi theo từng lần nghiệm thu của đơn đặt hàng
    public function findLog(Request $request)
    {
        $data = $request->all();
        $result = $this->qlpublicationsRepository->findLog($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "find note success", $result);
    }

//ghi chú từng ấn phẩm
    public function note_publications(Request $request)
    {
        $data = $request->all();
        log::channel('cpanel')->info('data: '. ' ' . print_r($data, true));
        $action = "Ghi chú ấn phẩm thành công";
        $result = $this->qlpublicationsRepository->notePublications($data);
        if (!empty($result) && $result['result_note'] == 1){
            $this->qlpublicationsRepository->log($data['_id'], $action,'recording system');
            return BaseController::sendResponse(BaseController::HTTP_OK, "write note success", $result);
        }else{
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "write note error");
        }
    }

//sửa từng phiếu đặt ấn phẩm
    public function update_publications(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // $data = $request->all();
        log::channel('cpanel')->info('update_publications: '. ' ' . print_r($data, true));
        $action = 'Chỉnh sửa phiếu đặt hàng thành công';
        $action1 = 'Chỉnh sửa phiếu đặt hàng thất bại';
        $resultFindOne = $this->qlpublicationsRepository->detailPublication($data['_id']);
        log::channel('cpanel')->info('resultFindOne: '. ' ' . print_r($resultFindOne, true));
        $result = $this->qlpublicationsRepository->updatePublications($data);
        log::channel('cpanel')->info('result2: '. ' ' . print_r($result, true));
        if ($result) {
            $detail = $this->qlpublicationsRepository->detailPublication($data["_id"]);
            if ($detail['status'] == "2" || $detail['status'] == "3") {
                $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/publication/detail_publics/" . $data['_id'];
                $tpMkt = $this->roleRepository->getTPMKT();
                $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
                $user = array_merge($tpMkt, $tradeMkt);
                $dataSendEmail = [
                    "publication" => $detail['lead_publications'],
                    "user" => array_unique($user),
                    'url'  => $url,
                    "flag" => '3',
                ];
                $sendEmail = MarketingApi::sendEmailPublication($dataSendEmail);
            }
            return BaseController::sendResponse(BaseController::HTTP_OK, "update success", $result->toArray());
        }
        return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update fail");
    }

//lấy hết tất cả các phiếu đặt ấn phẩm
    public function get_all_publications(Request $request)
    {
        $data = $request->all();
        $result = $this->qlpublicationsRepository->getAllPublications($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "findAll success", $result);
    }

//xóa mềm (update trạng thái block)
    public function update_status_block(Request $request)
    {
        $data = $request->all();
        $action = 'Thay đổi trạng thái thành công';
        $action1 = 'Thay đổi trạng thái thất bại';
        $resultFindOne = $this->qlpublicationsRepository->detailPublication($data['_id']);
        if ($resultFindOne['status'] == 1){
            $result = $this->qlpublicationsRepository->updateStatusBlock($data);
            $this->qlpublicationsRepository->log($data['_id'],$action,'recording system');
            return BaseController::sendResponse(BaseController::HTTP_OK, "update status block success", $result);
        }else{
            $this->qlpublicationsRepository->log($data['_id'],$action1,'recording system');
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update status block error");
        }
    }
//ghi chú từng phiếu đặt hàng ấn phẩm(màn danh sách tất cả  phiếu đặt hàng)
    public function note_one_publication(Request $request)
    {
        $data = $request->all();
        $result = $this->qlpublicationsRepository->noteOnepublication($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "findAll success", $result);
    }

//đặt hàng (update trạng thái đã đặt hàng)
    public function update_status_order(Request $request)
    {
        $data = $request->all();
        $action = 'Thay đổi trạng thái thành công';
        $action1 = 'Thay đổi trạng thái thất bại';
        $resultFindOne = $this->qlpublicationsRepository->detailPublication($data['_id']);
        if ($resultFindOne['status'] == 1) {
            $result = $this->qlpublicationsRepository->updateStatusOrder($data);
            $this->qlpublicationsRepository->log($data['_id'], $action, 'recording system');
            //send Email
            $detail = $this->qlpublicationsRepository->detailPublication($data["_id"]);
            $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/publication/detail_publics/" . $data['_id'];
            $tpMkt = $this->roleRepository->getTPMKT();
            $tradeMkt = $this->groupRoleRepository->getEmailTradeMKT();
            $user = array_merge($tpMkt, $tradeMkt);
            $dataSendEmail = [
                "publication" => $detail['lead_publications'],
                "user" => array_unique($user),
                'url'  => $url,
                "flag" => '1',
            ];
            $sendEmail = MarketingApi::sendEmailPublication($dataSendEmail);
            return BaseController::sendResponse(BaseController::HTTP_OK, "update status acceptance success", $result);
        } else {
            $this->qlpublicationsRepository->log($data['_id'], $action1, 'recording system');
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update status acceptance error");
        }
    }

//lấy tất cả các mẫu ấn phẩm

    public function all_trade_publication()
    {
        $result = $this->qlpublicationsRepository->allTradePublication();
        return BaseController::sendResponse(BaseController::HTTP_OK, "findAllTrade success", $result);
    }
//lấy tất cả các mẫu  ấn phảm  theo (item_id)
    public function find_one_trade(Request $request)
    {
        //return response()->json('here');
        $data = $request->all();
        $result = $this->qlpublicationsRepository->findOneTrade($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "findAllTrade success", $result);
    }

//lấy một phiếu mua ấn phẩm

    public function find_publics(Request $request)
    {
        $data = $request->all();
        $result = $this->qlpublicationsRepository->findPublications($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "find one publication success", $result);
    }
//lấy tất cả log nghiệm thu
    public function allLogAcception($id)
    {
        $result = $this->qlpublicationsRepository->allLogAcceptance($id);
        return BaseController::sendResponse(BaseController::HTTP_OK, "find all success", $result);
    }
//chi tiết của một ấn phẩm
    public function findKeyId($id,$key_id)
    {
        $result = $this->qlpublicationsRepository->findOneKeyId($id,$key_id);
        return BaseController::sendResponse(BaseController::HTTP_OK, "findAllTrade success", $result);
    }

//thay đổi trạng thái từ đã đặt hàng sang chờ nghiệm thu
    public function changeStatusAcception()
    {
        $result = $this->qlpublicationsRepository->changeStatusAcception();
        return BaseController::sendResponse(BaseController::HTTP_OK, "findAllTrade success", $result);
    }

//lây hết các phiếu order trạng thái =3 và tiến trình =7
    public function getAllTradeOder($id,$key_id)
    {
        $result = $this->qlpublicationsRepository->getAllTradeOder($id,$key_id);
        return BaseController::sendResponse(BaseController::HTTP_OK, "findAllTrade success", $result);
    }

//phân bổ các ấn phẩm
    public function allotment_publication(Request $request)
    {
        $data = $request->all();
        $result = $this->qlpublicationsRepository->allotmentPublication($data,$data['_id'],$data['key_id']);
        if (!empty($result) && $result == 1){
            // $detail = $this->qlpublicationsRepository->detailPublication($data["_id"]);
            $url = env("CPANEL_TN_PATH") . "/trade/requestIndex/" . "?target=" . "cpanel/trade/publication/detail_publics/" . $data['_id'];
            $publication = [];
            $arrTPGD = [];
            $tpMkt = $this->roleRepository->getTPMKT();
            $detailItem = $this->tradeItemRepository->detailByCodeItem($data['code_item']);
            foreach ($data['data'] as $item) {
                $tpgd = $this->roleRepository->getChtByStoreId($item['store_id']);
                $arrTPGD+= $tpgd;
                $namePGD = $this->storeRepository->getStoreName($item['store_id']);
                $publication[] = [
                    'code_item' => $data['code_item'],
                    'name_item' => $detailItem['detail']['name'],
                    'store_name' => $namePGD,
                    'total_allotment' => $item['total_allotment'],
                    'specification' => $detailItem['detail']['specification'],
                ];
            }
            $user = array_merge($tpMkt, $arrTPGD);

            $dataSendEmail = [
                "publication" => $publication,
                "user" => array_unique($user),
                'url'  => $url,
                "flag" => '5',
            ];
            $sendEmail = MarketingApi::sendEmailPublication($dataSendEmail);
             return BaseController::sendResponse(BaseController::HTTP_OK, "allotment success", $result);
        }else{
             return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "allotment error");
        }
    }

    public function findLog1(Request $request)
    {
        $data = $request->all();
        $result = $this->qlpublicationsRepository->findLog1($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "find all success", $result);
    }

   //test
    public function test(Request $request)
    {
        $data = $request->all();
        $result = $this->qlpublicationsRepository->findOneTrade($data);
        return BaseController::sendResponse(BaseController::HTTP_OK, "find all success", $result);
    }
}
