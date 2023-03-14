<?php
namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use CURLFile;
use Modules\MongodbCore\Repositories\Interfaces\KsnbRepositoryInterface as KsnbRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Modules\MongodbCore\Repositories\KsnbCodeErrorsRepositoryInterface as KsnbCodeErrorsRepository;
use Illuminate\Support\Facades\Validator;

use Modules\ViewCpanel\Service\ApiCall;

class KsnbViewController extends BaseController
{
    private $ksnbRepository;
    private $storeRepository;
    private $roleRepository;
    private $groupRepository;

    /**
    * Modules\MongodbCore\Repositories\KsnbCodeErrorsRepository
    */
    private $ksnbCodeErrorsRepository;

   public function __construct(
        KsnbRepository $ksnbRepository,
        StoreRepository $storeRepository,
        RoleRepository $roleRepository,
        KsnbCodeErrorsRepository $ksnbCodeErrorsRepository,
        GroupRoleRepository $groupRoleRepository
    ) {
        $this->ksnbRepo = $ksnbRepository;
        $this->storeRepo = $storeRepository;
        $this->roleRepository = $roleRepository;
        $this->ksnbCodeErrorsRepository = $ksnbCodeErrorsRepository;
        $this->groupRepository = $groupRoleRepository;
    }

    public function listReports()
    {
        $reports = $this->ksnbRepo->getAllReport();
        $data = [];
        $data['reports'] = $reports;
        return view('viewcpanel::reportsKsnb.listReports', $data);
    }

    public function createReport(Request $request)
    {
        $create = $this->ksnbRepo->getAllReport();
        $stores = $this->roleRepository->getAllRoom();
        $listErrors = $this->ksnbCodeErrorsRepository->getAllErrorCodes(['description', 'code_error']);
        $errorCodes = [];
        foreach ($listErrors as $value) {
            $errorCodes[] = [
                'label' => $value['code_error'] . ' - ' . $value['description'],
                'value' => $value['code_error']
            ];
        }

        return view('viewcpanel::reportsKsnb.createReport', [
            'stores' => $stores,
            'urlUpload' => route('ViewCpanel::ReportKsnb.uploadImage'),
            'getCodeByType' => route('ViewCpanel::ReportKsnb.getCodeByType'),
            'getPunishmentByCode' => route('ViewCpanel::ReportKsnb.getPunishmentByCode'),
            'getDisciplineByCode' => route('ViewCpanel::ReportKsnb.getDisciplineByCode'),
            'getDescription' => route('ViewCpanel::ReportKsnb.getDescription'),
            'getEmployeesByStoreId' => route('ViewCpanel::ReportKsnb.getEmployeesByStoreId'),
            'getEmailCHTByStoreId' => route('ViewCpanel::ReportKsnb.getEmailCHTByStoreId'),
            'getNameByEmail' => route('ViewCpanel::ReportKsnb.getNameByEmail'),
            'allMailRoll' => route('ViewCpanel::ReportKsnb.allMailRoll'),
            'errorCodes'     => $errorCodes,
            'getErrorCodeInfoUrl' => route('ViewCpanel::ReportsKsnb.getErrorCodeInfo'),
            'getQuoteDocument' => route('ViewCpanel::ReportKsnb.getQuoteDocument'),

        ]);
    }

    public function detailReport($id)
    {
        $user =session('user');
        $email = $user['email'];
        $detail = $this->ksnbRepo->find($id);
        $data = [];
        $data['detail'] = $detail;
        $data['user'] = $email;
        $userCheckRole = $this->roleRepository->getEmailKsnb();
        $data['ksnb'] = $userCheckRole;
        $qltbp = $this->roleRepository->getQuanLy_TBP();
        $data['qltbp'] = $qltbp;
        $data['CEO'] = config('viewcpanel.CEO');
        $data['download'] = route('ViewCpanel::ReportKsnb.download');
        $userCheckRoleNv = $this->groupRepository->getEmailGroupKsnb();
        $data1['cancelReportNv'] = $userCheckRoleNv;
        $data['cancelrpnv'] = route('ViewCpanel::ReportsKsnb.cancelRpNv', ['id' => $id]);
        $data['companyRules'] = config('reportsksnb.companyRules');
        $data['tbp'] = config('viewcpanel.TBPKSNB');
        if (!$detail) {
            abort(BaseController::HTTP_NOT_FOUND);
        }
        return view('viewcpanel::reportsKsnb.detailReport', $data,$data1);
    }

   public function updateReport(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        $validator = Validator::make(
            $dataPost, [
            'type' => 'required',
            'code_error' => 'required',
            'user_name' => 'required',
            'user_email' => 'required',
            'store_name' => 'required',
            'email_tpgd' => 'required',
            'description'=>'required',
            'url' => 'required',
            'sign_day' => 'required',
            'no' => 'required',
            'quote_document' => 'required',
        ],
        [
            'code_error.required' => 'Mã lỗi không được để trống',
            'type.required' => 'Nhóm vi phạm không được để trống',
            'punishment.required' => 'Chế tài phạt không được để trống',
            'discipline.required' => 'Chế tài phạt không được để trống',
            'user_name.required' => 'Tên nhân viên không để trống',
            'user_email.required' => 'Email nhân viên không để trống',
            'store_name.required' => 'Tên PGD không được để trống',
            'email_tpgd.required' => 'Tên TPGD không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'url.required' => 'Ảnh không để trống',
            "quote_document.required" => "Văn bản/Quyết định không để trống",
            "no.required" => "Số văn bản/quyết định không để trống",
            "sign_day.required" => "Ngày ban hành văn bản/quyết định không để trống",
        ]
        );

        if($validator->fails()) {
            Log::info('createReport validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }

        $dataPost['updated_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.updateReport') . "/$id";
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.update_rp'), $user['email']);
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Cập nhật biên bản thành công',
                "data" => [
                    'redirectURL' => route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]),
                ]
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }
    }

    public function saveReport(Request $request)
    {
        $user = session('user');
        $dataPost = $request->all();
        $validator = Validator::make(
            $dataPost, [
                'code_error' => 'required',
                'type' => 'required',
                'punishment' => 'required',
                'discipline' => 'required',
                'user_name' => 'required',
                'user_email' => 'required',
                'store_name' => 'required',
                'email_tpgd' => 'required',
                'description'=>'required',
                'url' => 'required',
                'sign_day' => 'required',
                'no' => 'required',
                'quote_document' => 'required',
            ],
            [
                'code_error.required' => 'Mã lỗi không được để trống',
                'type.required' => 'Nhóm vi phạm không được để trống',
                'punishment.required' => 'Chế tài phạt không được để trống',
                'discipline.required' => 'Chế tài phạt không được để trống',
                'user_name.required' => 'Tên nhân viên không để trống',
                'user_email.required' => 'Email nhân viên không để trống',
                'store_name.required' => 'Tên PGD không được để trống',
                'email_tpgd.required' => 'Tên TPGD không được để trống',
                'description.required' => 'Mô tả không được để trống',
                'url.required' => 'Ảnh không để trống',
                "quote_document.required" => "Văn bản/Quyết định không để trống",
                "no.required" => "Số văn bản/quyết định không để trống",
                "sign_day.required" => "Ngày ban hành văn bản/quyết định không để trống",
            ]
        );

        if($validator->fails()) {
            Log::info('createReport validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }

        $dataPost['created_by'] = $user['email'];

        $url = config('routes.ksnb.reportksnb.saveReport');

        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportsKsnb.listReports');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            $this->ksnbRepo->wlog($result->json()['data']['_id'], config('viewcpanel.rp_log_action.create_rp'), $user['email']);
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Tạo biên bản thành công',
                "data" => [
                    'redirectURL' => route('ViewCpanel::ReportKsnb.detailReport', ['id' => $result->json()['data']['_id']]),
                ]
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }
    }

    public function editReport($id) {
        $detail = $this->ksnbRepo->find($id);
        $storeId = $detail['store_id'];
        $stores  = $this->roleRepository->getAllRoom();
        $employees = $this->roleRepository->getMailByRole($storeId);
        $listErrors = $this->ksnbCodeErrorsRepository->getAllErrorCodes(['description', 'code_error']);
        $listErorrsByType = $this->ksnbCodeErrorsRepository->getCodeByType($detail->type);
        $errorCodes = [];
        foreach ($listErrors as $value) {
            $errorCodes[] = [
                'label' => $value['code_error'] . ' - ' . $value['description'],
                'value' => $value['code_error']
            ];
        }
        return view('viewcpanel::reportsKsnb.updateReport', [
            'detail' => $detail,
            'stores' => $stores,
            'employees' => $employees,
            'urlUpload' => route('ViewCpanel::ReportKsnb.uploadImage'),
            'getCodeByType' => route('ViewCpanel::ReportKsnb.getCodeByType'),
            'getPunishmentByCode' => route('ViewCpanel::ReportKsnb.getPunishmentByCode'),
            'getDisciplineByCode' => route('ViewCpanel::ReportKsnb.getDisciplineByCode'),
            'getDescription' => route('ViewCpanel::ReportKsnb.getDescription'),
            'getEmployeesByStoreId' => route('ViewCpanel::ReportKsnb.getEmployeesByStoreId'),
            'getEmailCHTByStoreId' => route('ViewCpanel::ReportKsnb.getEmailCHTByStoreId'),
            'getNameByEmail' => route('ViewCpanel::ReportKsnb.getNameByEmail'),
            'errorCodes'     => $errorCodes,
            'getErrorCodeInfoUrl' => route('ViewCpanel::ReportsKsnb.getErrorCodeInfo'),
            'allMailRoll' => route('ViewCpanel::ReportKsnb.allMailRoll'),
            'listErorrsByType' => $listErorrsByType
        ]);
    }

    public function filter(Request $request) {
        $search = $request->all();
        $result = $this->ksnbRepo->filter($search);
        return $result;
    }


    //update email confrim

    public function updateProcess(Request $request, $id) {
        $dataPost = $request->all();
        Log::channel('reportsksnb')->info('dataPost updateProcess:' . print_r($dataPost, true));
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.updateProcess') . "/$id";
        // dd('here');
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportsKsnb.feedbackReport', ['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.confirm_rp'), $user['email']);
            
        }
        return response()->json($result->json());
    }

    public function uploadImage(Request $request){
        $data = $request->all();
        if($_FILES['file']['size'] > 10000000) {
            $response = array(
                'code' => 201,
                "msg" => 'Kích thước file không vượt quá 10MB',
            );
            echo json_encode($response);
            return ;
        }
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        $cfile = new CURLFile($_FILES['file']["tmp_name"],$_FILES['file']["type"],$_FILES['file']["name"]);
        $post = array('avatar'=> $cfile );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$serviceUpload);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec ($ch);
        curl_close ($ch);
        $result1 = json_decode($result);
        $random = sha1(substr(md5(rand()), 0, 8));
        $data_con = array();
        if ($result1->path) {
            $data_con['url'] = $result1->path;
                $response = array(
                'code' => 200,
                "msg"=>"success",
                'path' => $result1->path,
                'key' => $random,
                'raw_name' => $_FILES['file']['name']
            );
            echo json_encode($response);
            return ;
        } else {
            $response = array(
                'code' => 201,
                "msg" => 'Upload không thành công hoặc định dạng không hợp lệ'
            );
            echo json_encode($response);
            return ;
        }
    }


//lấy list danh sách theo cấp
    public function list_users_ksnb(Request $request)
    {
        $data = [];
        $user = session('user');
        $email = $user['email'];
        $listUser = ApiCall::getUserEmail($email);
        $stores = $this->roleRepository->getAllRoom();
        $dataSearch = $request->all();
        unset($dataSearch['_token']);
        if (!empty($listUser) && $listUser["status"] == Response::HTTP_OK) {
            if(empty($listUser["data"])) {
                $reports = $this->ksnbRepo->getAllReport($dataSearch);
                $data['reports'] = $reports;
            } else {
                $reports = $this->ksnbRepo->get_email_ksnb($listUser["data"], $dataSearch);
                $data['reports'] = $reports;
            }
        } else {
            $reports = $this->ksnbRepo->get_email_ksnb([$email], $dataSearch);
            $data['reports'] = $reports;
        }
        $data['searchUrl'] = route('ViewCpanel::ReportsKsnb.listReports');
        $data['dataSearch'] = $dataSearch;
        return view('viewcpanel::reportsKsnb.index', $data);
    }

    //update process sau khi ko duyệt
    public function updateNotConfrim(Request $request, $id) {
        $dataPost = $request->all();

        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.updateEmailNotConfrim') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.not_confirm_rp'), $user['email']);
            return redirect()->route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id])->with('success', 'Cập nhật tiến trình thành công');
        } else {
            return redirect()->route('ViewCpanel::ReportsKsnb.listReports')->with('errors', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }

    //update process sau khi gửi duyệt lại
    public function updateReConfrim(Request $request, $id) {
        $dataPost = $request->all();

        $user = session('user');
        $dataPost['updateted_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.updateEmailReConfrim') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.sent_reconfirm_rp'), $user['email']);
            
        } 
        return response()->json($result->json());
    }

    //update process khi đưa ra kết luận
    public function updateinfer(Request $request, $id) {
        $dataPost = $request->all();
        $validator = Validator::make(
            $dataPost, [
                'infer' => 'required',
            ],
            [
                'infer.required' => 'Kết luận không được để trống'
            ]
        );

        if($validator->fails()) {
            Log::info('updateinfer validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.updateInfer') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]);

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.infer_rp'), $user['email']);

        } 
        return response()->json($result->json());
    }

    //view cho nv vi phạm phản hồi
    public function feedback($id) {
        $user =session('user');
        $email = $user['email'];
        $detail = $this->ksnbRepo->find($id);
        $data = [];
        $data['detail'] = $detail;
        $userCheckRole = $this->roleRepository->getEmailKsnb();
        $data['user'] = $email;
        $data['ksnb'] = $userCheckRole;
        $data['download'] = route('ViewCpanel::ReportKsnb.download');
        $userCheckRoleNv = $this->groupRepository->getEmailGroupKsnb();
        $data1['cancelReportNv'] = $userCheckRoleNv;
        $data['cancelrpnv'] = route('ViewCpanel::ReportsKsnb.cancelRpNv', ['id' => $id]);
        if (!$detail) {
            abort(BaseController::HTTP_BAD_REQUEST);
        }
        return view('viewcpanel::reportsKsnb.feedback', $data, $data1);
    }

    //update feedback vào db và gửi mail khi ng vp phản hồi
    public function sendfeedback(Request $request, $id) {
        $dataPost = $request->all();
        $validator = Validator::make(
            $dataPost, [
                'comment' => 'required',
            ],
            [
                'comment.required' => 'Phản hồi không được để trống'
            ]
        );

        if($validator->fails()) {
            Log::info('sendfeedback validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.sendfeedback') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport',['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.feedback_rp'), $user['email']);

        } 
        return response()->json($result->json());
    }



    //call ajax 3 hàm bên dưới
    public function getCodeByType (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.ksnb.reportksnb.getCodeByType');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    public function getPunishmentByCode (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.ksnb.reportksnb.getPunishmentByCode');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    public function getDisciplineByCode (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.ksnb.reportksnb.getDisciplineByCode');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    public function getEmailCHT(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.ksnb.reportksnb.getEmailCHT');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }


    public function getEmployeesByStoreId(Request $request)
    {
        $storeId = $request->get("store_id");
        $dataPost = [
            'store_id' => $storeId
        ];
        $url = config('routes.ksnb.reportksnb.getEmployeesByStoreId');
        $result = Http::asForm()->post($url, $dataPost);
        $response = $result->json();
        return response()->json($response);
    }

    public function getEmailCHTByStoreId(Request $request)
    {
        $storeId = $request->get("store_id");
        $dataPost = [
            'store_id' => $storeId
        ];
        $url = config('routes.ksnb.reportksnb.getEmailCHTByStoreId');
        $result = Http::asForm()->post($url, $dataPost);
        $response = $result->json();
        return response()->json($response);
    }



    public function getDescription(Request $request) {
        $dataPost = $request->all();

        $url = config('routes.ksnb.reportksnb.getDescription');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    public function getNameByEmail(Request $request) {
        $dataPost = $request->all();

        $url = config('routes.ksnb.reportksnb.getNameByEmail');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }


    //Gửi duyệt sau khi tạo
    public function updateWaitConfrim(Request $request, $id) {
        $dataPost = $request->all();
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.updateWaitConfrim') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport',['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.wait_confrim_rp'), $user['email']);

        }
        return response()->json($result->json());
    }


    public function allMailRoll(Request $request)
    {
        $dataPost = [
            'id_room' => $request->get('id_room')
        ];
        $url = config('routes.ksnb.reportksnb.allMailRoll');
        $result = Http::asForm()->post($url, $dataPost);
        $response = $result->json();
        return response()->json($response);
    }

    public function getAllRoom(Request $request)
    {
        $dataPost = $request->all();
        $url = config('routes.ksnb.reportksnb.getAllRoom');
        $result = Http::asForm()->post($url, $dataPost);
        $response = $result->json();
        return response()->json($response);
    }

    /**
     * get error's code information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getErrorCodeInfo(Request $request) {
        $dataPost = $request->all();
        $code = isset($dataPost['code_error']) ? $dataPost['code_error'] : NULL;
        $dataPost = ['code' => $code];
        $url = config('routes.ksnb.reportksnb.getErrorCodeInfo');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    public function ksnbFeedback(Request $request, $id){
        $dataPost = $request->all();
        $validator = Validator::make(
            $dataPost, [
                'ksnb_comment' => 'required',
            ],
            [
                'ksnb_comment.required' => 'Phản hồi không được để trống'
            ]
        );

        if($validator->fails()) {
            Log::info('ksnbFeedback validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.ksnbFeedbackReport') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportsKsnb.feedbackReport',['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.feedback_rp'), $user['email']);

        } 
        return response()->json($result->json());
    }

    public function waitInfer($id) {
        $dataPost = [];
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.waitInfer') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.wait_infer'), $user['email']);
            return redirect()->route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id])->with('success', 'Cập nhật tiến trình thành công');
        } else {
            return redirect()->route('ViewCpanel::ReportsKsnb.listReports')->with('errors', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }

    public function cancelRpNv($id)
    {
        $user = session('user');
        $result = $this->ksnbRepo->cancelReportnv($id);
        if (!empty($result)) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.cancel_rp'), $user['email']);
            return redirect()->route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id])->with('success', 'Hủy biên bản thành công');
        } else {
            return redirect()->route('ViewCpanel::ReportsKsnb.listReports')->with('errors', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }


    public function endTimeReport()
    {
        $result = $this->ksnbRepo->endTimeRp();
        return redirect()->route('ViewCpanel::ReportsKsnb.listReports');

    }

    public function download() {
        // Check if file exists in app/storage/file folder
        $file_path = storage_path() . "/app/public/" . 'QĐ2342021QĐ-TGĐ.pdf';
        $headers = array(
            'Content-Type' => 'application/csv',
            'Content-Disposition' => 'attachment; filename=' . 'QĐ2342021QĐ-TGĐ.pdf',
        );
        if ( file_exists( $file_path ) ) {
            // Send Download
            return \Response::download( $file_path, 'QĐ2342021QĐ-TGĐ.pdf', $headers );
        } else {
            // Error
            exit('File không tồn tại');
        }

    }

    public function sendCeo(Request $request, $id) {
        $dataPost = $request->all();
        Log::channel('reportsksnb')->info('dataPost send Ceo:' . print_r($dataPost, true));
        $validator = Validator::make(
            $dataPost, [
                'infer' => 'required',
            ],
            [
                'infer.required' => 'Kết luận không được để trống'
            ]
        );

        if($validator->fails()) {
            Log::info('ksnbFeedback validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.sendCeo') . "/$id";
 
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]);

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.sendCeo'), $user['email']);
            // $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.infer_to_ceo_rp'), $user['email']);
        }
        return response()->json($result->json());
    }

    public function ceoNotConfirm(Request $request, $id) {
        $dataPost = $request->all();
        $validator = Validator::make(
            $dataPost, [
                'ceo_not_confirm' => 'required',
            ],
            [
                'ceo_not_confirm.required' => 'Lý do CEO trả về không được để trống',
            ]
        );

        if($validator->fails()) {
            Log::info('ceo not confirm validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.ceoNotConfirm') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.ceoNotConfirm'), $user['email']);
            return redirect()->route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id])->with('success', 'Cập nhật tiến trình thành công');
        } else {
            return redirect()->route('ViewCpanel::ReportsKsnb.listReports')->with('errors', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }

    public function ceoConfirm(Request $request, $id) {
        $dataPost = $request->all();
        $validator = Validator::make(
            $dataPost, [
                'ceo_confirm' => 'required',
            ],
            [
                'ceo_confirm.required' => 'Ý kiến của CEO không được để trống'
            ]
        );

        if($validator->fails()) {
            Log::info('ceo confirm validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $user = session('user');
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.ceoConfirm') . "/$id";
        $dataPost['urlItem'] = env('LMS_TN_PATH') . '?target_url=' . route('ViewCpanel::ReportKsnb.detailReport', ['id' => $id]);
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepo->wlog($id, config('viewcpanel.rp_log_action.ceoConfirm'), $user['email']);
        }
        return response()->json($result->json());
    }

}
