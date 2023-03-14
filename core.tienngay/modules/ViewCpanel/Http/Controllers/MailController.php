<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Service\ApiCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\ViewCpanel\Service\Import;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\EmailTemplateRepositoryInterface as emailTemplateRepository;

class MailController extends BaseController
{
    private $roleRepository;
    private $emailTemplateRepo;

    public function __construct(
            RoleRepository $roleRepository,
            EmailTemplateRepository $emailTemplateRepo
        ) {
            $this->roleRepository = $roleRepository;
            $this->emailTemplateRepo = $emailTemplateRepo;
        }


    public function sendMail() {
        $user = session('user');
        $email = $user['email'];
        $import = route('viewcpanel::toolSendEmail.import');
        $getCodeEmail = route('viewcpanel::toolSendEmail.getCodeEmail');
        $downloadFile = route('viewcpanel::toolSendEmail.downloadFile');
        $stores = $this->roleRepository->getAllRoomHO();
        $getSubject = route('viewcpanel::toolSendEmail.getSubject');
        $createTemplate = route('viewcpanel::toolSendEmail.createTemplate');
        $listTempalte = route('viewcpanel::toolSendEmail.indexTempale');
        $name_email = config('viewcpanel.name_email');
        $getSlug = route('viewcpanel::toolSendEmail.getSlug');
        return view('viewcpanel::toolSendEmail.sendEmail', [
            'user' => $email,
            'import'    => $import,
            'getCodeEmail'  => $getCodeEmail,
            'downloadFile'  => $downloadFile,
            'stores'    => $stores,
            'getSubject' => $getSubject,
            'createTemplate' => $createTemplate,
            'listTempalte' => $listTempalte,
            'name_email' => $name_email,
            'getSlug' => $getSlug,
        ]);
    }

    public function createTemplate() {
        $user = session('user');
        $email = $user['email'];
        $stores = $this->roleRepository->getAllRoomHO();
        $saveTemplate = route('viewcpanel::toolSendEmail.saveTemplate');
        $listTempalte = route('viewcpanel::toolSendEmail.indexTempale');
        return view('viewcpanel::toolSendEmail.createTemplate', [
            'stores'    => $stores,
            'saveTemplate' => $saveTemplate,
            'listTempalte' => $listTempalte
        ]);
    }
    
    public function saveTemplate(Request $request) {
        $user = session('user');
        $email = $user['email'];
        $dataRequest = $request->all();
        Log::info('data sendEmail save:' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'subject'           => 'required|max:100',
            'message'           => 'required',
            'store'             => 'required',
            'code'              => 'required'
        ], 
        [
            'subject.required'            => "Tiêu đề email không được để trống",
            'subject.max'                 => "Tiêu đề email không vượt quá 100 ký tự",
            'message.required'            => "Nội dung email không được để trống",
            'store.required'              => "Phòng ban không được để trống",
            'code.required'               => "Mã code không để trống",
        ]);
        $validator->after(function() use ($validator, $dataRequest) {
            $code = $dataRequest['code'];
            $bool = $this->emailTemplateRepo->checkExistCode(null, $code);
            if ($bool) {
                $validator->errors()->add('code', 'Mã code đã tồn tại');
            }
        });
        if($validator->fails()) {
            Log::info('data send email validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $dataRequest['created_by'] = $user['email'];
        $url = config('routes.tool.sendEmail.saveTemplate');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::asForm()->post($url, $dataRequest);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Thành công',
                "data" => [
                    'redirectURL' => route('viewcpanel::toolSendEmail.indexTempale'),
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


    /**
    * get code by store
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function importListEmail(Request $request)
    {   
        $user = session('user');
        $dataRequest    = $request->all();
        log::info('data send Email:' . print_r($dataRequest, true));
        $subject        = !empty($dataRequest['subject']) ? $dataRequest['subject'] : "";
        $from           = !empty($dataRequest['from']) ? $dataRequest['from'] : "";
        $content        = !empty($dataRequest['content_email']) ? $dataRequest['content_email'] : "";
        $store          = !empty($dataRequest['store']) ? $dataRequest['store'] : "";
        $created_by     = $user['email'];

        if (!$request->hasFile('upload_file')) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => "Không tìm thấy file import"
            ];
                return response()->json($response);
            } else {
                $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 
                    'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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
                    if (count($sheetData) >= 500) {
                        return response()->json([
                            "status" => BaseController::HTTP_BAD_REQUEST,
                            "message" => 'Thất bại',
                            "data" => [],
                            "error" => 'Dữ liệu import nhỏ hơn 500 khách hàng',
                        ]);
                    }
                    $arrData = [];
                    foreach ($sheetData as $key => $value) {
                        if($this->isEmptyRow($value)) {
                            continue;
                        }
                        Log::info("data import".  print_r($value, true));
                        if ($key>=1) {
                            $data = array(
                                "user_name" => !empty($value["0"]) ? (trim($value["0"])) : "",
                                "email"     => !empty($value["1"]) ? (trim($value["1"])) : "",
                                'subject'   => $subject,
                                'from'      => $from,
                                'content'   => $content,
                                'store'     => $store,
                                'created_by' => $created_by,    
                            );
                            if (empty($data['email'])) {
                                continue;
                            }
                            $arrData[] = $data;
                            $validate = Validator::make($data,[

                                'subject'   => "required",
                                'from'      => "required",
                                'store'     => "required",
                                'content' => "required",
                            ], [
                            
                                'subject.required'      => "Tiêu đề email không được để trống",
                                'from.required'         => "Email được gửi từ đâu không được để trống",
                                'store.required'        => "Phòng ban không được để trống",
                                'content.required'      => "Chương trình truyền thông không được để trống",
                            ]);
                            if ($validate->fails()) {
                                Log::info('data send email validator ' . $validate->errors()->first());
                                return response()->json([
                                    "status" => BaseController::HTTP_BAD_REQUEST,
                                    "message" => $validate->errors()->first(),
                                    "data" => [],
                                    "errors" => $validate->errors()
                                ]);
                            }
                        }
                    }
                    if (empty($arrData)) {
                        $response = [
                            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                            BaseController::MESSAGE =>  "File không có dữ liệu để Import"
                        ];
                        return response()->json($response);
                    } else {
                        foreach ($arrData as $k => $item) {
                            $url = config('routes.tool.sendEmail.email');
                            Log::info('Call Api: ' . $url . ' ' . print_r($item, true));
                            $result = Http::asForm()->post($url, $item);
                            if ($result->json()['status'] == 200) {
                                $response = [
                                    BaseController::STATUS => BaseController::HTTP_OK,
                                    BaseController::MESSAGE => BaseController::SUCCESS,
                                ];
                            } else {
                                $response = [
                                    BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                                    BaseController::MESSAGE => "Có lỗi xảy ra",
                                ];
                            }
                        }
                        return response()->json($response);
                    }
                }
        }
    }

    public function isEmptyRow($row) {
        if (!array_filter($row)) {
            return true;
        }
        return false;
    }

    public function downloadFile($filename = '')
    {
        // Check if file exists in app/storage/file folder
        $file_path = storage_path() . "/app/public/" . 'bieu_mau_tool_email.xlsx';
        $headers = array(
            'Content-Type' => 'application/csv',
            'Content-Disposition' => 'attachment; filename=' . 'bieu_mau_tool_email.xlsx',
        );
        if ( file_exists( $file_path ) ) {
            // Send Download
            return \Response::download( $file_path, 'bieu_mau_tool_email.xlsx', $headers );
        } else {
            // Error
            exit('File không tồn tại');
        }
    }


    /**
    * get code by store
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function getCodeEmail(Request $request) {
        $dataRequest = $request->all();
        $url = config('routes.tool.sendEmail.getCodeEmail');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::asForm()->post($url, $dataRequest);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }


    /**
    * get code by store
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function getSubject(Request $request) {
        $dataRequest = $request->all();
        $url = config('routes.tool.sendEmail.getSubject');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::asForm()->post($url, $dataRequest);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    public function editTemplate($id) {
        $user = session('user');
        $email = $user['email'];
        $detail = $this->emailTemplateRepo->findById($id);
        $stores = $this->roleRepository->getAllRoomHO();
        $updateTemplate = route('viewcpanel::toolSendEmail.updateTemplate', $id);
        $listTempalte = route('viewcpanel::toolSendEmail.indexTempale');
        return view('viewcpanel::toolSendEmail.updateTemplate', [
            'stores'    => $stores,
            'updateTemplate' => $updateTemplate,
            'detail' => $detail,
            'listTempalte' => $listTempalte
        ]);
    }

    public function updateTemplate(Request $request, $id) {
        $user = session('user');
        $email = $user['email'];
        $dataRequest = $request->all();
        log::info('data update:' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'subject'           => 'required|max:100',
            'message'     => 'required',
            'store'             => 'required',
            'code'          => 'required'
        ], 
        [
            'subject.required'            => "Tiêu đề email không được để trống",
            'subject.max'                 => "Tiêu đề email không vượt quá 100 ký tự",
            'message.required'             => "Nội dung email không được để trống",
            'store.required'              => "Phòng ban không được để trống",
            'code.required'                => "Mã code không để trống",
        ]);

        if($validator->fails()) {
            Log::info('data send email validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $dataRequest['created_by'] = $user['email'];
        $dataRequest['updated_by'] = $user['email'];
        $url = config('routes.tool.sendEmail.updateTemplate') . "/$id";
        Log::info('Call Api: ' . $url . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::asForm()->post($url, $dataRequest);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Thành công',
                "data" => [
                    'redirectURL' => route('viewcpanel::toolSendEmail.indexTempale'),
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

    public function indexTempale(Request $request) {
        $dataSearch = $request->all();
        $lists = $this->emailTemplateRepo->getAll($dataSearch);
        $create = route('viewcpanel::toolSendEmail.createTemplate');
        $sendEmail = route('viewcpanel::toolSendEmail.sendEmail');
        $stores = $this->roleRepository->getAllRoomHO();
        $search =  route('viewcpanel::toolSendEmail.indexTempale');
        $cpanelURL = env('CPANEL_TN_PATH') . '/ToolSendEmail/index?target_url=';
        return view('viewcpanel::toolSendEmail.listTemplate', [
            'lists' => $lists,
            'create' => $create,
            'sendEmail' => $sendEmail,
            'stores' => $stores,
            'search ' => $search,
            'dataSearch' => $dataSearch,
            'cpanelURL' => $cpanelURL,
        ]);
    }


    /**
    * get slug
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function getSlug(Request $request) {
        $dataRequest = $request->all();
        $url = config('routes.tool.sendEmail.getSlug');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataRequest, true));
        //call api
        $result = Http::asForm()->post($url, $dataRequest);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

}
