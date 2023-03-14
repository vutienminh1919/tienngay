<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\Interfaces\HcnsRepositoryInterface as HcnsRepository;
use Exception;
use CURLFile;
use Illuminate\Support\Facades\Validator;
use Modules\Hcns\Service\ApiCall;
use Modules\Hcns\Service\Import;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HcnsController extends BaseController
{
    function __construct(HcnsRepository $hcnsRepository, Import $import) {
        $this->hcnsRepo = $hcnsRepository;
        $this->import = $import;
    }

    /**
    * upload image
    * @param Request $request
    * @return json
    */
    public function uploadImage(Request $request){
        $data = $request->all();
        if($_FILES['file']['size'] > 10000000) {
            $response = array(
                'code' => BaseController::FAIL,
                "msg" => 'Kích thước file không vượt quá 10MB',
            );
            echo json_encode($response);
            return ;
        }
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        $cfile = new \CURLFile($_FILES['file']["tmp_name"],$_FILES['file']["type"],$_FILES['file']["name"]);
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

    /**
    * index page
    * @param Request $request
    * @return Renderable
    */
    public function listAllRecord(Request $request)
    {
        $user = session('user');
        $email = $user['email'];
        $dataSearch = $request->all();
        $records = $this->hcnsRepo->getAllRecord($dataSearch);
        $data = [];
        $data['records'] = $records;
        $data['searchUrl'] = route('viewcpanel::hcns.listRecord');
        $data['urlImport'] = route('viewcpanel::hcns.importExcel');
        $data['dataSearch'] = $dataSearch;
        $data['exportUrl'] = route('viewcpanel::hcns.exportExcel');
        $data['downloadFile'] = route('viewcpanel::hcns.download');
        $data['cpanelURL'] = env('CPANEL_TN_PATH') . '/ToolHcns/index?target_url=';
        return view('viewcpanel::hcns.listRecord', $data);
    }

    /**
    * create page
    * @return Renderable
    */
    public function createRecord()
    {

        return view('viewcpanel::hcns.createRecord', [
            'urlUpload' => route('viewcpanel::hcns.uploadImage'),
            'saveRecord' => route('viewcpanel::hcns.saveRecord'),
        ]);
    }

    /**
    * Create a new blacklist's record
    * @param Request $request
    * @return json
    */
    public function saveRecord(Request $request)
    {
        $user = session('user');
        $dataPost = $request->all();
        $validator = $this->validate($dataPost);
        $validator->after(function() use ($validator, $dataPost) {
            $identify = $dataPost['user_identify'];
            $bool = $this->hcnsRepo->checkExistIdentify(null, $identify);
            if ($bool) {
                $validator->errors()->add('user_identify', 'Số CMND/CCCD đã tồn tại');
            }
            $passport = $dataPost['user_passport'];
            $pass = $this->hcnsRepo->checkExistPassport(null, $passport);
            if ($pass) {
                $validator->errors()->add('user_passport','Số hộ chiếu đã tồn tại');
            }
        });
        // dd($validator->fails());
        if($validator->fails()) {
            Log::info('create Record validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }

        $dataPost['created_by'] = $user['email'];

        $url = config('routes.hcns.black_list.saveRecord');

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Tạo mới bản ghi thành công',
                "data" => [
                    'redirectURL' => route('viewcpanel::hcns.detailRecord', ['id' => $result->json()['data']['_id']]),
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
    * update page
    * @param blacklist_hcns collection's id
    * @return Renderable
    */
    public function editRecord($id) {
        // $dataPost = $request->all();

        $detail = $this->hcnsRepo->findRecord($id);
        if ($detail) {
            $data['detail'] = $detail;
        }
        return view('viewcpanel::hcns.updateRecord', [
            'urlUpload' => route('viewcpanel::hcns.uploadImage'),
            'urlUpdate' => route('viewcpanel::hcns.updateRecord', $id),
            'detail' => $detail,
        ]);
    }

    /**
    * update a blacklist's record
    * @param Request $request
    * @param blacklist_hcns collection's id
    * @return json
    */
    public function updateRecord(Request $request, $id) {
        $user = session('user');
        $dataPost = $request->all();
        $validator = $this->validate($dataPost);
        $validator->after(function() use ($validator, $dataPost, $id) {
            $identify = $dataPost['user_identify'];
            $bool = $this->hcnsRepo->checkExistIdentify($id, $identify);
            if ($bool) {
                $validator->errors()->add('user_identify', 'Số CMND/CCCD đã tồn tại');
            }
            $passport = $dataPost['user_passport'];
            $pass = $this->hcnsRepo->checkExistPassport($id, $passport);
            if ($pass) {
                $validator->errors()->add('user_passport','Số hộ chiếu đã tồn tại');
            }
        });
        if($validator->fails()) {
            Log::info('update Record validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }

        $dataPost['updated_by'] = $user['email'];

        $url = config('routes.hcns.black_list.updateRecord')."/$id";

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        //
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Cập nhật bản ghi thành công',
                "data" => [
                    'redirectURL' => route('viewcpanel::hcns.detailRecord', ['id' => $id]),
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
    * detail page
    * @param blacklist_hcns collection's id
    * @return Renderable
    */
    public function detailRecord($id) {
        $user =session('user');
        $email = $user['email'];

        $detail = $this->hcnsRepo->findRecord($id);
        return view('viewcpanel::hcns.detailRecord', [
            'detail' => $detail,
        ]);
    }

    public function importExcelHcns(Request $request)
    {
        $user = session('user');
        if (!$request->hasFile('upload_file')) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => "Không tìm thấy file import"
            ];
                return response()->json($response);
            } else {
                $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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
                    $arrFail = [];
                    $arrData = [];
                    foreach ($sheetData as $key => $value) {
                        if($this->isEmptyRow($value)) {
                            continue;
                        }

                        Log::info("data import".  print_r($value, true));
                        if ($key >= 1) {
                            $data = array(
                                "user_name" => !empty($value["0"]) ? (trim($value["0"])) : "",
                                "room" => isset($value["1"]) ? (trim($value["1"])) : "",
                                "position" => isset($value["2"]) ? (trim($value["2"])) : "",
                                "work_place" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
                                "day_on" => !empty(trim($value["4"])) ? date('Y-m-d', strtotime(trim($value["4"]))) : "",
                                "day_off" => !empty(trim($value["5"])) ? date('Y-m-d', strtotime(trim($value["5"]))) : "",
                                "reason_for_leave" => !empty(trim($value["6"])) ? (trim($value["6"])) : "",
                                "user_phone" => !empty(trim($value["7"])) ? (trim($value["7"])) : "",
                                "user_email" => !empty(trim($value["8"])) ? (trim($value["8"])) : "",
                                "user_identify" => !empty(trim($value["9"])) ? (trim($value["9"])) : "",
                                "user_passport" => !empty(trim($value["10"])) ? (trim($value["10"])) : "",
                                "date_range" => !empty(trim($value["11"])) ? date('Y-m-d', strtotime(trim($value["11"]))) : "",
                                "issued_by" => !empty(trim($value["12"])) ? (trim($value["12"])) : "",
                                "temporary_address" => !empty(trim($value["13"])) ? (trim($value["13"])) : "",
                                "permanent_address" => !empty(trim($value["14"])) ? (trim($value["14"])) : "",
                                "created_by" => $user['email'],
                            );
                            $arrData[] = $data;
                            $validator = $this->validate($data);
                            $validator->after(function() use ($validator, $data) {
                                $identify = $data['user_identify'];
                                $bool = $this->hcnsRepo->checkExistIdentify(null, $identify);
                                if ($bool) {
                                    $validator->errors()->add('user_identify', 'Số CMND/CCCD đã tồn tại');

                                }
                                if (!empty($data['user_passport'])) {
                                    $passport = $data['user_passport'];
                                    $pass = $this->hcnsRepo->checkExistPassport(null, $passport);
                                    if ($pass) {
                                        $validator->errors()->add('user_passport','Số hộ chiếu đã tồn tại');
                                    }
                                }
                            });
                            // Log::channel('hcns')->info("validator ". $validator->fails());
                            if($validator->fails()) {
                                array_push($arrFail, $validator->errors()->first());
                                break;
                            }
                        }
                    }
                    if (empty($arrData)) {
                        $response = [
                            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                            BaseController::MESSAGE =>  "File không có dữ liệu để Import"
                        ];
                        return response()->json($response);
                    }
                    $arrIdentify = []; $arrPassport = [];
                    foreach ($arrData as $k => $i) {
                        array_push($arrIdentify, $i['user_identify']);
                        if (!empty($i['user_passport'])) {
                            array_push($arrPassport, $i['user_passport']);
                        }
                        if (count($arrIdentify) != count(array_unique($arrIdentify))) {
                            $response = [
                                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                                BaseController::MESSAGE =>  "Số cmnd/cccd đã bị trùng ở các bản ghi khác nhau",
                            ];
                            return response()->json($response);
                        }
                        if (count($arrPassport) != count(array_unique($arrPassport))) {
                            $response = [
                                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                                BaseController::MESSAGE =>  "Số hộ chiếu đã bị trùng ở các bản ghi khác nhau",
                            ];
                            return response()->json($response);
                        }
                    }
                    if(count($arrFail) == 0) {
                        foreach ($arrData as $k => $item) {
                            $url = config('routes.hcns.black_list.saveRecord');
                            Log::info('Call Api: ' . $url . ' ' . print_r($item, true));
                            //call api
                            $result = Http::asForm()->post($url, $item);
                            if ($result->json()['status'] == 200) {
                                $response = [
                                    BaseController::STATUS => BaseController::HTTP_OK,
                                    BaseController::MESSAGE => BaseController::SUCCESS,
                                ];
                            }
                        }
                        return response()->json($response);
                    } else {
                        $response = [
                            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                            BaseController::MESSAGE =>  $arrFail[0].' tại dòng ' . ($key + 1) ,
                        ];
                        return response()->json($response);
                    }
                }
            }
    }


    /**
    * validate data
    * @param Array $dataPost
    * @return Validator object
    */
    public function validate($dataPost) {
        $validator = Validator::make($dataPost, [
            'user_name'         => 'required|max:50',
            'user_identify'     => 'required',
            'user_email'        => 'email:rfc,dns|nullable',
            'user_passport'        => 'nullable',
        ],
        [
            'user_name.required' => 'Tên nhân sự nghỉ việc không để trống',
            'user_identify.required'    => 'Số CMND/CCCD không được để trống',
            'user_identify.digits_between'    => 'Số CMND/CCCD không đúng định dạng',
            'user_email.email'    => 'Email không đúng định dạng',
        ]);
        $validator->after(function() use ($validator, $dataPost) {
            $identify = $dataPost['user_identify'];

            if (preg_match('/^\d{9}$/', $identify) || preg_match('/^\d{12}$/', $identify)) {
                //pass
            } else {
                $validator->errors()->add('user_identify', 'Số CMND/CCCD phải là 9 hoặc 12 chữ số');
            }
            if(isset($dataPost['user_phone']) && $dataPost['user_phone'] != "") {
                $user_phone = $dataPost['user_phone'];
                if (preg_match('/^0[1-9][0-9]{8}$/', $user_phone)) {
                    //do nothing
                } else {
                    $validator->errors()->add('user_phone', 'Số điện thoại phải bắt đầu bằng số 0 và đủ 10 số');
                }
            }
            if(isset($dataPost['user_passport']) && $dataPost['user_passport'] != "") {
                $user_passport = $dataPost['user_passport'];
                if (!preg_match('/^[A-Z][0-9]{7}$/', $user_passport)) {
                    $validator->errors()->add('user_passport', 'Số hộ chiếu bắt đầu bằng chữ in hoa và 7 số');
                }
            }
            if(!empty($dataPost['day_off']) && !empty($dataPost['day_on'])) {
                $day_off = strtotime($dataPost['day_off']);
                $day_on = strtotime($dataPost['day_on']);
                if ($day_on > $day_off) {
                    $validator->errors()->add('day_on', "Ngày bắt đầu không được lớn hơn ngày kết thúc");
                }
            }
        });

        return $validator;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportExcel(Request $request)
    {
        $dataGet = $request->all();
        $records = $this->hcnsRepo->getAllRecord($dataGet, true);
        if (count($records) == 0) {
            $records = [];
        } else {
            $records = $records->toArray();
        }
        return view('viewcpanel::hcns.exportExcel', [
            'records' => $records
        ]);
    }

    /**
     * download excel import template
     */
    public function downloadFile($filename = '')
    {
        // Check if file exists in app/storage/file folder
        $file_path = storage_path() . "/app/public/" . 'bieu_mau_blacklist_hcns.xlsx';
        $headers = array(
            'Content-Type' => 'application/csv',
            'Content-Disposition' => 'attachment; filename=' . 'bieu_mau_blacklist_hcns.xlsx',
        );
        if ( file_exists( $file_path ) ) {
            // Send Download
            return \Response::download( $file_path, 'bieu_mau_blacklist_hcns.xlsx', $headers );
        } else {
            // Error
            exit('File không tồn tại');
        }
    }

    public function isEmptyRow($row) {
        if (!array_filter($row)) {
            return true;
        }
        return false;
    }
}
