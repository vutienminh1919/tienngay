<?php


namespace Modules\ViewCpanel\Http\Controllers;

use App\Http\Controllers\Controller;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\TradeItem;
use Modules\MongodbCore\Repositories\LogPublicationRepository;
use Modules\MongodbCore\Repositories\QlpublicationsRepository;
use Modules\MongodbCore\Repositories\TradeItemRepository;
use Modules\MongodbCore\Repositories\TradeOrderRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class QlpublicationsController extends BaseController
{
    private $qlpublicationsRepository;
    private $tradeItemRepository;
    private $logPublicationRepository;
    private $tradeOrderRepository;

    public function __construct(TradeItemRepository $tradeItemRepository,
                                QlpublicationsRepository $qlpublicationsRepository,
                                 LogPublicationRepository $logPublicationRepository,
                                 TradeOrderRepository $tradeOrderRepository)
    {
        $this->tradeItemRepository = $tradeItemRepository;
        $this->qlpublicationsRepository = $qlpublicationsRepository;
        $this->logPublicationRepository = $logPublicationRepository;
    }

// view create a publcation

    public function create_publications(Request $request)
    {
        $user = session('user');
        $data = $request->all();
        $result_trade = $this->qlpublicationsRepository->allTradePublication();
        $result['result_trade'] = $result_trade;
        $result['listPb'] = route('viewcpanel::trade.publication.list');
        return view('viewcpanel::trade.publications.create_publication',$result);
    }

// find a item_id

    public function find_one_trade(Request $request)
    {
        $data = $request->all();
        $url= config('routes.trade.publications.find_one_trade');
        $result = Http::post($url,$data);
        return response()->json($result->json());
    }

// create a publication with status is new
    public function create(Request $request)
    {
        $user = session('user');
        $data = $request->all();
        $data['created_by'] = $user['email'];
        log::channel('cpanel')->info('Call Api: '. print_r($data, true));
        $validate = Validator::make($data, [
            'supplier' => 'required',
            'other_costs' => 'required',
            'date_acceptance' => 'required|after_or_equal:date_order',
            'date_order' => 'required',
            'lead_publications.*.item_id' => 'required',
            'lead_publications.*.total' => 'required|numeric',
            'lead_publications.*.image_detail' => 'required',
            'lead_publications.*.name_publications' => 'required',
            'lead_publications.*.money_publications' => 'required',
        ],
            [
                'supplier.required' => "Nhà cung cấp không được để trống",
                'other_costs.required' => "Chi phí khác không được để trống",
                'date_acceptance.required' => "Ngày nghiệm thu dự kiến không được để trống",
                'date_acceptance.after_or_equal' => "Ngày nghiệm thu dự kiến không được nhỏ hơn ngày đặt hàng",
                'date_order.required' => "Ngày đặt hàng không được để trống",
//                'date_order.after_or_equal' => "Ngày đặt hàng không được nhỏ hơn ngày hiện tại",
                'lead_publications.*.item_id.required' => "Hãy chọn mã ấn phẩm",
                'lead_publications.*.total.required' => "Số lượng ấn phẩm không được để trống",
                'lead_publications.*.total.numeric' => "Số lượng chỉ được nhập số",
                'lead_publications.*.image_detail.required' => "Ảnh mô tả ấn phẩm không được để trống",
                'lead_publications.*.name_publications.required' => "Tên ấn phẩm không được để trống",
                'lead_publications.*.money_publications.required' => "Đơn giá thực tế không được để trống",
            ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        $url = config('routes.trade.publications.create_publication_status1');
        log::channel('cpanel')->info('Call Api: '. $url . ' ' . print_r($data, true));
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        log::channel('cpanel')->info('Result publications: ' . $url . ' ' . print_r($result, true));
        if (!empty($result['data']['result'])) {
            $result['_id'] = $result['data']['_id'];
            return BaseController::sendResponse(
                BaseController::HTTP_OK,
                'Thêm mới thành công',
                $result);
        } else {
            return BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'create error');
        }
    }

//show add data publications

    public function show_list(Request $request)
    {

          $user = session('user');
          $userEmail = !empty($user['email']) ? $user['email'] : "";
            if (empty($userEmail)) {
                echo __('ViewCpanel::message.you_are_not_logged_in');
                exit;
            }
            if (!$user['roles']['tradeMKT']['publication']['show_list']) {
                echo __('ViewCpanel::message.permission_denied');
                exit;
            }
          $buttonCreatePublic = false;
          $buttonUpdatePublic = false;
          $buttonDeletePublic = false;
          $buttonSaveOrder = false;
          if ($user['roles']['tradeMKT']['publication']['buttonCreatePublic']){
            $buttonCreatePublic = true;
          }
          if ($user['roles']['tradeMKT']['publication']['buttonUpdatePublic']){
            $buttonUpdatePublic = true;
          }
          if ($user['roles']['tradeMKT']['publication']['buttonDeletePublic']) {
            $buttonDeletePublic = true;
          }
          if ($user['roles']['tradeMKT']['publication']['buttonSaveOrder']){
            $buttonSaveOrder = true;
          }
          $result['buttonCreatePublic'] = $buttonCreatePublic;
          $result['buttonUpdatePublic'] = $buttonUpdatePublic;
          $result['buttonDeletePublic'] = $buttonDeletePublic;
          $result['buttonSaveOrder'] = $buttonSaveOrder;
          $data = $request->all();
          $result['status'] = !empty($_GET['status']) ? $_GET['status'] : "";
          $result['supplier_search'] = !empty($data['supplier']) ? $data['supplier'] : "";
          $result['date_order_search_start'] = !empty($data['date_order_start']) ? $data['date_order_start'] : "";
          $result['date_order_search_end'] = !empty($data['date_order_end']) ? $data['date_order_end'] : "";
          $result['date_acceptance_complete_search_start'] = !empty($data['date_acceptance_complete_start']) ? $data['date_acceptance_complete_start'] : "";
          $result['date_acceptance_complete_search_end'] = !empty($data['date_acceptance_complete_end']) ? $data['date_acceptance_complete_end'] : "";
          $result['date_acceptance_search_start'] = !empty($data['date_acceptance_start']) ? $data['date_acceptance_start'] : "";
          $result['date_acceptance_search_end'] = !empty($data['date_acceptance_end']) ? $data['date_acceptance_end'] : "";
          $result_publications = $this->qlpublicationsRepository->getAllPublications($data);
          $export = true;
          $result['export']  = $this->qlpublicationsRepository->getAllPublications($data,$export);
          $result['count_data_publications'] = count($result['export']);
          $result['list_publications'] = $result_publications;
          $result['searchData'] = route('viewcpanel::trade.publication.list');
          $result['dataSearch'] = $data;
          $result['indexUrl'] =  route('viewcpanel::trade.tradeOrder.index');
          $result['tradeBEIndexUrl'] =  route('viewcpanel::trade.budgetEstimates.index');
          $result['listPB'] =  route('viewcpanel::trade.publication.list');
          $result['cpanelPath'] = env('CPANEL_TN_PATH');
          return view('viewcpanel::trade.publications.list_publication',$result);
    }


    public function detailPublication(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.publications.find_publics');
        $result = Http::post($url, $data);
        return response()->json($result->json());
    }

// write log for one publication

    public function notePublics(Request $request)
    {
        $user = session('user');
        $data = $request->all();
        $data['created_by'] = $user['email'];
        $validate = Validator::make($data, [
            'description_publications' => 'required',
            //'title_note_publications' => 'required',
        ],
            [
                'description_publications.required' => "Nội dung của ghi chú không được để trống",
                //'title_note_publications.required' => "Tiêu đề của ghi chú không được để trống",
            ]);
         if ($validate->fails()) {
             return response()->json([
                 'status' => Response::HTTP_BAD_REQUEST,
                 "message" => $validate->errors()->first(),
                 "errors" => $validate->errors(),
             ]);
         }
        $url = config('routes.trade.publications.note_one_publication');
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        if (!empty($result['status'] == 200)) {
            return
                BaseController::sendResponse(
                BaseController::HTTP_OK,
                'Thêm mới ghi chú thành công',
                $result);
        } else {
            return
                BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'Thêm mới ghi chú thất bại');
        }
    }

//detail one publication

    public function detailPuclication($id)
    {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['publication']['detailPuclication']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $buttonAcception = false;
        $buttonSaveOrder = false;
        $buttonUpdatePublic = false;
        $buttonDetailPuclic = false;
        $buttonDeletePublic = false;

        if ($user['roles']['tradeMKT']['publication']['buttonAcception']){
            $buttonAcception = true;
        }

        if ($user['roles']['tradeMKT']['publication']['buttonSaveOrder']){
            $buttonSaveOrder = true;
        }

        if ($user['roles']['tradeMKT']['publication']['buttonUpdatePublic']){
            $buttonUpdatePublic = true;
        }

        if ($user['roles']['tradeMKT']['publication']['buttonDetailPuclic']){
            $buttonDetailPuclic = true;
        }

        if ($user['roles']['tradeMKT']['publication']['buttonDeletePublic']){
            $buttonDeletePublic = true;
        }

        $result['buttonAcception'] = $buttonAcception;
        $result['buttonSaveOrder'] = $buttonSaveOrder;
        $result['buttonUpdatePublic'] = $buttonUpdatePublic;
        $result['buttonDetailPuclic'] = $buttonDetailPuclic;
        $result['buttonDeletePublic'] = $buttonDeletePublic;


        $resultPublic = $this->qlpublicationsRepository->detailPublication($id);
        $result['detail'] = $resultPublic;
        $resultFindOne = $this->qlpublicationsRepository->findPublication($id);
        $result['resultFindOne'] = $resultFindOne;
        $result['id'] = $id;
        foreach ($result['resultFindOne'] as $key => $value){
            foreach ($value as $k => $v){
                $result['key'] = $k;
            }
        }
        $resultLog = $this->qlpublicationsRepository->allLogAcceptance($id);
        $result['logAcception'] = $resultLog;
        $result['log'] = [];

        return view('viewcpanel::trade.publications.detail_publication',$result);
    }

//find a publication

    public function findPubl(Request $request)
    {
        $data = $request->all();
        $url=  config('routes.trade.publications.find_publication1');
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        return
                BaseController::sendResponse(
                BaseController::HTTP_OK,
                'thành công',$result);
    }

//write note in a publication

    public function notePuclication(Request $request)
    {
        $user = session('user');
        $data = $request->all();
        //dd($data);
        $data['created_by'] = $user['email'];
        $validate = Validator::make($data, [
            'description' => 'required',
            //'note' => 'required',
        ],
            [
                'description.required' => "Nội dung của ghi chú không được để trống",
                //'note.required' => "Tiêu đề của ghi chú không được để trống",
            ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        $url = config('routes.trade.publications.note_publications');
        $result = Http::post($url,$data);
        $result = $result->json();
        if (!empty($result) && $result['status'] == 200) {
            return
                BaseController::sendResponse(
                    BaseController::HTTP_OK,
                    'Thêm mới ghi chú thành công',
                    $result);
        } else {
            return
                BaseController::sendResponse(
                    BaseController::HTTP_BAD_REQUEST,
                    'Thêm mới ghi chú thất bại');
        }
    }

//detail of  one acception  in publication

    public function dtailLogAcception(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.publications.findLog');
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        if (!empty($result) && $result['status'] == 200) {
            return
                BaseController::sendResponse(
                    BaseController::HTTP_OK,
                    'Tìm log ấn phẩm thành công',
                    $result);
        } else {
            return
                BaseController::sendResponse(
                    BaseController::HTTP_BAD_REQUEST,
                    'Tìm log ấn phẩm thất bại');
        }
    }

    public function dtailLogAcception1(Request $request)
    {
        $data = $request->all();
        $url = config('routes.trade.publications.findLog1');
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        if (!empty($result) && $result['status'] == 200) {
            return
                BaseController::sendResponse(
                    BaseController::HTTP_OK,
                    'Tìm log ấn phẩm thành công',
                    $result);
        } else {
            return
                BaseController::sendResponse(
                    BaseController::HTTP_BAD_REQUEST,
                    'Tìm log ấn phẩm thất bại');
        }
    }

// acception one publication and wirte log acception publication

    public function acceptionPublic(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $bool = false;
        foreach ($data['data'] as $key =>$value){
            //dd($value['total_acceptance']);
            if (!empty($value['total_acceptance'])){
                $bool = true;
            }
        }
        if ($bool == false) {
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "Số lượng nghiệm thu không được để trống,nhập tối thiểu là một ấn phẩm");
        }
//total_acceptance
        $user = session('user');
        $data['created_by'] = $user['email'];
        $validate = Validator::make($data, [
            'image_acception' => 'required',
            //'data.*.total' => 'numeric',
            'data.*.total_acceptance' => 'alpha_num|integer|nullable',

        ],
        [
           'image_acception.required' => "Chứng từ nghiệm thu không được để trống",
           'data.*.total_acceptance.integer' => "Chỉ được nhập số",
           'data.*.total_acceptance.alpha_num' => "Chỉ được nhập số nguyên",
           //'data.*.total_acceptance.lte' => "Số lượng nghiệm thu không được lớn hơn số lượng cần nhận",
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validate->errors()
            ]);
        }
        log::channel('cpanel')->info('Call Api: '. print_r($data, true));
        $url = config('routes.trade.publications.acceptance_publication');
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        log::channel('cpanel')->info('Call: '. print_r($result, true));
        if (!empty($result) && $result['status'] == 200) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => $result['message'],
                'data' => $result
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $result['message']
            ];
        }
        return response()->json($response);
    }

//detail publication use update one publication

    public function detailPuclication1($id)
    {
        //lấy phiếu mua ấn phẩm theo id phiếu mua
        $resultPublic = $this->qlpublicationsRepository->detailPublication($id);
        $result['detail'] = $resultPublic;
        //lấy từng ấn phẩm đã khởi tạo trong phiếu mua ấn phẩm
        $resultFindOne = $this->qlpublicationsRepository->findPublication($id);
        $result['resultFindOne'] = $resultFindOne;
        $result['id'] = $id;
        foreach ($result['resultFindOne'] as $key => $value){
            foreach ($value as $k => $v){
                $result['key'] = $k;
            }
        }
        $result['id'] = $id;
        $result_trade = $this->qlpublicationsRepository->allTradePublication();
        $result['result_trade'] = $result_trade;
        return view('viewcpanel::trade.publications.update_publication',$result);
    }

// update publications

    public function update_publics(Request $request)
    {
        $user = session('user');
        $data = json_decode($request->getContent(), true);
        $validate = Validator::make($data, [
            'supplier' => 'required',
            'other_costs' => 'required',
            'date_acceptance' => 'required',
            'date_order' => 'required',
            'lead_publications.*.item_id' => 'required',
            'lead_publications.*.total' => 'required|numeric',
            'lead_publications.*.name_publications' => 'required',
            'lead_publications.*.specification' => 'required',
            'lead_publications.*.money_publications' => 'required',
        ],
            [
                'supplier.required' => "Nhà cung cấp không được để trống",
                'other_costs.required' => "Chi phí khác không được để trống",
                'date_acceptance.required' => "Ngày nghiệm thu dự kiến không được để trống",
                'date_order.required' => "Ngày đặt hàng không được để trống",
                'lead_publications.*.item_id.required' => "Hãy chọn mã ấn phẩm",
                'lead_publications.*.total.required' => "Số lượng ấn phẩm không được để trống",
                 'lead_publications.*.total.numeric' => "Số lượng chỉ được nhập số",
                'lead_publications.*.name_publications.required' => "Tên ấn phẩm không được để trống",
                'lead_publications.*.specification.required' => "Quy cách ấn phẩm không được trống",
                'lead_publications.*.money_publications.required' => "Đơn giá thực tế không được để trống",
            ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        $data['created_by'] = $user['email'];
        $url = config('routes.trade.publications.update_publications');
        log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($data, true));
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        log::channel('cpanel')->info('Result publications: ' . $url . ' ' . print_r($result, true));
        if (!empty($result) && $result['status'] == 200) {
            return BaseController::sendResponse(
                BaseController::HTTP_OK,
                'Chỉnh sửa đơn đặt hàng thành công',
                $result);
        } else {
            return BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'Chỉnh sửa đơn đặt hàng thất bại');
        }
    }

// create publications with  status is order
    public function create_status_order(Request $request)
    {
        $user = session('user');
        $data = $request->all();
        $validate = Validator::make($data, [
            'supplier' => 'required',
            'other_costs' => 'required',
            'date_acceptance' => 'required|after_or_equal:date_order',
            'date_order' => 'required',
            'lead_publications.*.item_id' => 'required',
            'lead_publications.*.total' => 'required|numeric',
            'lead_publications.*.image_detail' => 'required',
            'lead_publications.*.name_publications' => 'required',
            'lead_publications.*.money_publications' => 'required',
        ],
            [
                'supplier.required' => "Nhà cung cấp không được để trống",
                'other_costs.required' => "Chi phí khác không được để trống",
                'date_acceptance.required' => "Ngày nghiệm thu dự kiến không được để trống",
                'date_acceptance.after_or_equal' => "Ngày nghiệm thu dự kiến không được nhỏ hơn ngày đặt hàng",
                'date_order.required' => "Ngày đặt hàng không được để trống",
//                'date_order.after_or_equal' => "Ngày đặt hàng không được nhỏ hơn ngày hiện tại",
                'lead_publications.*.item_id.required' => "Hãy chọn mã ấn phẩm",
                'lead_publications.*.total.required' => "Số lượng ấn phẩm không được để trống",
                'lead_publications.*.total.numeric' => "Số lượng chỉ được nhập số",
                'lead_publications.*.image_detail.required' => "Ảnh mô tả ấn phẩm không được để trống",
                'lead_publications.*.name_publications.required' => "Tên ấn phẩm không được để trống",
                'lead_publications.*.money_publications.required' => "Đơn giá thực tế không được để trống",
            ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        $data['created_by'] = $user['email'];
        $url = config('routes.trade.publications.create_publication_status2');
        log::channel('cpanel')->info('Call Api: '. $url . ' ' . print_r($data, true));
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        log::channel('cpanel')->info('Result publications: ' . $url . ' ' . print_r($result, true));
        if (!empty($result['data']['result'])) {
            $result['_id'] = $result['data']['_id'];
            return BaseController::sendResponse(
                BaseController::HTTP_OK,
                'Thêm mới thành công',
                $result);
        } else {
            return BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'Thêm mới thất bại');
        }
    }

    // update status block

    public function update_status_block(Request $request)
    {
        $user = session('user');
        $data = $request->all();
        $data['created_by'] = $user['email'];
        $url = config('routes.trade.publications.update_status_block');
        $result = Http::post($url, $data);
        $result = $result->json();
        log::channel('cpanel')->info('Result data: ' . $url . ' ' . print_r($result, true));
        if (!empty($result) && $result['status'] == 200) {
            return BaseController::sendResponse(
                BaseController::HTTP_OK,
                'Cập nhật trạng thái thành công',
                $result);
        } else {
            return BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'Xóa phiếu ấn phẩm thất bại');
        }
    }

    public function update_status_order(Request $request)
    {
        $user = session('user');
        $data = $request->all();
        $data['created_by'] = $user['email'];
        $url = config('routes.trade.publications.update_status_order');
        $result = Http::post($url, $data);
        $result = $result->json();
        log::channel('cpanel')->info('Result data: ' . $url . ' ' . print_r($result, true));
        if (!empty($result) && $result['status'] == 200) {
            return BaseController::sendResponse(
                BaseController::HTTP_OK,
                'Cập nhật trạng thái thành công',
                $result);
        } else {
            return BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'Cập nhật trạng thái thất bại');
        }
    }

    public function findOneKeyId($id,$key_id)
    {
         $result = $this->qlpublicationsRepository->findOneKeyId($id,$key_id);
         $resultSpecification['specification'] = $result['specification'];
         $resultType['type'] =  $result['type'];
         $resultItemId['item_id'] = $result['item_id'];
         $itemId['name_publications'] = $result['name_publications'];
         $totalAllotment['total_allotment'] =  $result['total_allotment'];
         $resultTotal['total_acceptance'] = $result['total_acceptance'];
         $result['resultTotals'] = $result['total_acceptance'];
         $result['result_total_quantity_tested'] = $result['total_quantity_tested'];
         $resultGetData = $this->qlpublicationsRepository->getAllTradeOder($id,$key_id);
         $result['getAllData'] = $resultGetData;
         $result['id'] = $id;
         $result['key_id'] = $key_id;
         return view('viewcpanel::trade.publications.allotment_publication',$result);
    }

    public function allotment_publication(Request $request,$id,$key_id)
    {
        $user = session('user');
        $data = $request->all();
        $data['created_by'] = $user['email'];
        $arr_total_allotment = [];
         $validate = Validator::make($data, [
            'data.*.store_id' => 'required',
            'data.*.total_allotment' => 'required|alpha_num|integer',
        ],
            [
                'data.*.store_id.required' => "Phòng giao dịch không được để trống",
                'data.*.total_allotment.required' => "Số lượng phân bổ không được để trống",
                'data.*.total_allotment.alpha_num' => "Chỉ được nhập số nguyên",
                'data.*.total_allotment.integer' => "Chỉ được nhập số",
            ]);
        if ($validate->fails()) {
                return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
                "errors" => $validate->errors(),
            ]);
        }
        if (!($resultGetData = $this->qlpublicationsRepository->getAllTradeOder($id,$key_id))) {
                return BaseController::sendResponse(
                BaseController::HTTP_NOT_FOUND,
                'Phân bổ thất bại');
        }
        if (!($resultOne = $this->qlpublicationsRepository->findOneKeyId($id,$key_id))){
                return BaseController::sendResponse(
                BaseController::HTTP_NOT_FOUND,
                'Phân bổ thất bại');
        }
        foreach ($data['data'] as $key => $value){
            $arr_total_allotment[] = $value['total_allotment'];
            if ($resultGetData){
                foreach ($resultGetData as $ky => $vl){
                    $sumQuantityReceived = $vl['item_quantity'] - $vl['received_amount'];
                    if ($vl['_id'] == $value['id_request']){
                       if ($value['total_allotment'] > $sumQuantityReceived){
                            return response()->json([
                            'status' => Response::HTTP_BAD_REQUEST,
                            "message" => 'Số lượng phân bổ vượt quá số lượng cần giao',
                            "errors" => 'Số lượng phân bổ vượt quá số lượng cần giao',
                        ]);
                       }
                    }
                }
            }
        }
        $sumAllotment = array_sum($arr_total_allotment);
        if ($sumAllotment > $resultOne['total_quantity_tested']){
                        return response()->json([
                            'status' => Response::HTTP_BAD_REQUEST,
                            "message" => 'Tổng số lượng phân bổ vượt quá số lượng có thể phân bổ',
                            "errors" => 'Tổng số lượng phân bổ vượt quá số lượng có thể phân bổ',
                        ]);
        }
        $data['id'] = $id;
        $data['key_id'] = $key_id;
        $url = config('routes.trade.publications.allotment_publication');
        log::channel('cpanel')->info('Call publications: ' . $url . ' ' . print_r($data, true));
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        $result = $result->json();
        log::channel('cpanel')->info('Result publications: ' . $url . ' ' . print_r($data, true));
        if (!empty($result) && $result['status'] == 200) {
                return BaseController::sendResponse(
                BaseController::HTTP_OK,
                'Phân bổ thành công',
                $result);
        } else {
                return BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'Phân bổ thất bại');
        }
    }


    public function importFile(Request $request)
    {
        $user = session('user');
        $url = config('routes.trade.publications.create_publication_status1');
        $url1 = config('routes.trade.publications.find_one_trade');
        if (empty($_FILES['upload_file']['name'])) {
            return BaseController::sendResponse(
                BaseController::HTTP_BAD_REQUEST,
                'Import file thất bại(chưa nhập file)');
        }else{
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
               $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

                $sheetData[0] = array_filter($sheetData[0]);
                if (count($sheetData[0]) != 4) {
                      return BaseController::sendResponse(
                        BaseController::HTTP_BAD_REQUEST,
                        'Bạn nhập sai mẫu file');
                }
                $arr_error = [];
                $dataArr = [
                    'supplier' => '',
                    'other_costs' => '',
                    'date_acceptance' => '',
                    'date_order' => '',
                    'created_by' => $user['email'],
                    'lead_publications' => []
                ];
                $moneyTotal = 0;
                $count = 0;
                $sum_money_publications = 0;
                foreach ($sheetData as $key => $value) {
                    if ($key == 1) {
                        if ($value["0"] == '') continue;
                        $dataArr ['supplier'] = $value[1];
                        $dataArr ['other_costs'] = $value[3];
                        $dataArr ['date_acceptance'] = $value[2];
                        $dataArr ['date_order'] = $value[0];
                    }
                    if ($key >= 3){
                        //$a = $this->qlpublicationsRepository->findOneTrade(['item_id' => $value[2]]);
                        $a = Http::asForm()->post($url1, ['item_id' => $value[2]]);
                        $a =  $a->json();
//                        if (!empty($a) && $a['data'] == null) {
//                            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST,'import thất bại'. ' tại dòng ' . ( $key + 1) . ' mã ấn phẩm không tồn tại');
//                        } else {
//                            if (!empty($value[0] && $value[1]) && is_int($value[1]) == true && is_int($value[0]) == true) {
//                                $count++;
//                                $id = time() . $key;
//                                $lead_publications = [
//                                    'key_id' => $id,
//                                    'item_id' => $value[2],
//                                    'total' => $value[1],
//                                    'money_publications' => $value[0],
//                                    'name_publications' => $a['data']['detail']['name'],
//                                    'specification' => $a['data']['detail']['specification'],
//                                    'type' => $a['data']['detail']['type'],
//                                    'price' => $a['data']['detail']['price'],
//                                    'total_clone' => $value[1],
//                                    'image_detail' => $a['data']['path'],
//                                    'money_total' => $value[1] * $value[0],
//                                ];
//                                $moneyTotal += $lead_publications['total'];
//                                $sum_money_publications += $lead_publications['money_total'];
//                                $dataArr['lead_publications'][$id] = $lead_publications;
//                                $dataArr['sum_total'] = $moneyTotal;
//                                $dataArr['sum_item_id'] = $count;
//                                $dataArr['sum_money_publications'] = $sum_money_publications;
//                            }else{
//                                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, 'import thất bại' . ' tại dòng ' . ($key + 1) . ' đơn giá và số lượng không được nhập chữ');
//                            }
//                        }
                        if (!empty($a) && $a['data'] != null){
                            if (is_int($value[1]) == true && is_int($value[0]) == true){
                                $count++;
                                $id = time() . $key;
                                $lead_publications = [
                                    'key_id' => $id,
                                    'item_id' => $value[2],
                                    'total' =>$value[1],
                                    'money_publications' => $value[0],
                                    'name_publications' => $a['data']['detail']['name'],
                                    'specification' => $a['data']['detail']['specification'],
                                    'type' => $a['data']['detail']['type'],
                                    'price' => $a['data']['detail']['price'],
                                    'total_clone' => $value[1],
                                    'image_detail' => $a['data']['path'],
                                    'money_total' => $value[1] * $value[0],
                                ];
                                $moneyTotal += $lead_publications['total'];
                                $sum_money_publications += $lead_publications['money_total'];
                                $dataArr['lead_publications'][$id] = $lead_publications;
                                $dataArr['sum_total'] = $moneyTotal;
                                $dataArr['sum_item_id'] = $count;
                                $dataArr['sum_money_publications'] = $sum_money_publications;
                            }else{
                                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, 'Import thất bại' . ' tại dòng ' . ($key + 1) . ' dữ liệu đầu vào không đúng định dạng');
                            }
                        }else{
                            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST,'Import thất bại'. ' tại dòng ' . ( $key + 1) . ' mã ấn phẩm không tồn tại');
                        }
                    }
                }
                $result = Http::asForm()->post($url, $dataArr);
                $result = $result->json();
                if (!empty($result) && $result['status'] == 200) {
                    return BaseController::sendResponse(
                        BaseController::HTTP_OK,
                        'Import file thành công',
                        $result);
                } else {
                    return response()->json($response = [
                        BaseController::HTTP_BAD_REQUEST,
                        BaseController::MESSAGE =>  ' tại dòng ' . $result['message']
                    ]);
                }
            }
        }
    }

    public function uploadFile(Request $request)
    {
         $data = $request->all();
        if ($_FILES['file']['size'] > 10000000) {
            $response = array(
                'code' => 201,
                "msg" => 'Kích thước file không vượt quá 10MB',
            );
            echo json_encode($response);
            return;
        }
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        $cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
        $post = array('avatar' => $cfile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serviceUpload);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($result);
        $random = sha1(substr(md5(rand()), 0, 8));
        $data_con = array();
        if ($result1->path) {
            $data_con['url'] = $result1->path;
            $response = array(
                'code' => 200,
                "msg" => "success",
                'path' => $result1->path,
                'key' => $random,
                'raw_name' => $_FILES['file']['name']
            );
            echo json_encode($response);
            return;
        } else {
            $response = array(
                'code' => 201,
                "msg" => 'Upload không thành công hoặc định dạng không hợp lệ'
            );
            echo json_encode($response);
            return;
        }
    }

}
