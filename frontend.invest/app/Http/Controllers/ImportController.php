<?php


namespace App\Http\Controllers;

use App\Service\Api;
use App\Service\Import;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function __construct(Import $import)
    {
        $this->import = $import;
        set_time_limit(360);
    }

    public function index()
    {
        return view('import.index');
    }

    public function import_user_ndt_uy_quyen(Request $request)
    {
        if (!$request->hasFile('upload_file')) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Không tìm thấy file"
            ];
            return response()->json($response);
        } else {
            $file = $request->upload_file;
            $sheetData = $this->import->get_data_import($file);
            $res = $this->validate_import_user($sheetData);
            if (!empty($res)) {
                return response()->json($res);
            }
            $listFail = [];
            foreach ($sheetData as $key => $value) {
                if (empty($value[0]) && empty($value[1]) && empty($value[2]) && empty($value[3])) continue;
                if ($key >= 1) {
                    $data = array(
                        "key" => ++$key,
                        "email" => !empty($value[0]) ? (trim($value[0])) : "",
                        "phone" => !empty($value[1]) ? (trim($value[1])) : "",
                        "full_name" => !empty($value[2]) ? (trim($value[2])) : "",
                        "cmt" => !empty($value[3]) ? (trim($value[3])) : "",
                    );
                    $return = Api::post('user/import_user_ndt_uy_quyen', $data);
                    if (isset($return) && !empty($return['data'])) {
                        array_push($listFail, $return);
                    }
                }
            }
            $response = [
                'status' => Api::HTTP_OK,
                'message' => 'success',
                'data' => $listFail
            ];
            return response()->json($response);
        }
    }

    public function validate_import_user($sheetData)
    {
        if (stripos("Email", trim($sheetData[0][0])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô A định dạng bắt buộc là Email"
            ];
            return $response;
        }
        if (stripos("Phone", trim($sheetData[0][1])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô B định dạng bắt buộc là Phone"
            ];
            return $response;
        }
        if (stripos("Tên đầy đủ", trim($sheetData[0][2])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô C định dạng bắt buộc là Tên đầy đủ"
            ];
            return $response;
        }
        if (stripos("CMT", trim($sheetData[0][3])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô D định dạng bắt buộc là CMT"
            ];
            return $response;
        }

    }

    public function validate_import_contract($sheetData)
    {
        if (stripos("Số điện thoại", trim($sheetData[0][0])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô A định dạng bắt buộc là Số điện thoại"
            ];
            return $response;
        }
        if (stripos("Mã phụ lục", trim($sheetData[0][1])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô B định dạng bắt buộc là Mã phụ lục"
            ];
            return $response;
        }
        if (stripos("Số tiền", trim($sheetData[0][2])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô C định dạng bắt buộc là Số tiền"
            ];
            return $response;
        }
        if (stripos("Thời gian đầu tư", trim($sheetData[0][3])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô D định dạng bắt buộc là Thời gian đầu tư"
            ];
            return $response;
        }

        if (stripos("Lãi suất/năm", trim($sheetData[0][4])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô E định dạng bắt buộc là Lãi suất/năm"
            ];
            return $response;
        }

        if (stripos("Hình thức trả lãi", trim($sheetData[0][5])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô F định dạng bắt buộc là Hình thức trả lãi"
            ];
            return $response;
        }

        if (stripos("Ngày đầu tư", trim($sheetData[0][6])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô F định dạng bắt buộc là Ngày đầu tư"
            ];
            return $response;
        }

        if (stripos("Chu kỳ tính lãi", trim($sheetData[0][7])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô F định dạng bắt buộc là Chu kỳ tính lãi"
            ];
            return $response;
        }

        if (stripos("Ngày trả lãi", trim($sheetData[0][8])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô F định dạng bắt buộc là Ngày trả lãi"
            ];
            return $response;
        }
    }

    public function import_contract_ndt_uy_quyen(Request $request)
    {
        if (!$request->hasFile('upload_file')) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Không tìm thấy file"
            ];
            return response()->json($response);
        } else {
            $file = $request->upload_file;
            $sheetData = $this->import->get_data_import($file);
//            $res = $this->validate_import_contract($sheetData);
//            if (!empty($res)) {
//                return response()->json($res);
//            }
            $listFail = [];
            foreach ($sheetData as $key => $value) {
                if (empty($value[0]) && empty($value[1]) && empty($value[2]) && empty($value[3]) && empty($value[4]) && empty($value[5]) && empty($value[6])) continue;
                if ($key >= 1) {
                    $data = array(
                        "key" => ++$key,
                        "code" => !empty($value[0]) ? (trim($value[0])) : "",
                        "code_contract" => !empty($value[1]) ? (trim($value[1])) : "",
                        "amount_money" => !empty($value[2]) ? (trim(str_replace(array(',', '.',), '', $value[2]))) : "",
                        "number_day_loan" => !empty($value[3]) ? (trim($value[3])) : "",
                        "interest" => !empty($value[4]) ? (trim($value[4])) : "",
                        "type_interest" => !empty($value[5]) ? (trim($value[5])) : "",
                        "created_at" => !empty($value[6]) ? (trim($value[6])) : "",
                        "date_interest" => !empty($value[7]) ? (trim($value[7])) : "",
                        "date_pay" => !empty($value[8]) ? (trim($value[8])) : "",
                        "investment_cycle" => !empty($value[9]) ? (trim($value[9])) : "",
                    );
                    $return = Api::post('contract/import_contract_ndt_uy_quyen', $data);
                    if (isset($return) && !empty($return['data'])) {
                        array_push($listFail, $return);
                    }
                }
            }
            $response = [
                'status' => Api::HTTP_OK,
                'message' => 'success',
                'data' => $listFail
            ];
            return response()->json($response);
        }
    }

    public function validate_import_transaction($sheetData)
    {
        if (stripos("Mã hợp đồng", trim($sheetData[0][0])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô A định dạng bắt buộc là Mã hợp đồng"
            ];
            return $response;
        }
        if (stripos("Tiền gốc", trim($sheetData[0][1])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô B định dạng bắt buộc là Tiền gốc"
            ];
            return $response;
        }
        if (stripos("Tiền lãi", trim($sheetData[0][2])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô C định dạng bắt buộc là Tiền lãi"
            ];
            return $response;
        }
        if (stripos("Ngày thanh toán", trim($sheetData[0][3])) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô D định dạng bắt buộc là Ngày thanh toán"
            ];
            return $response;
        }
    }

    public function import_transaction_ndt_uy_quyen(Request $request)
    {
        if (!$request->hasFile('upload_file')) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Không tìm thấy file"
            ];
            return response()->json($response);
        } else {
            $file = $request->upload_file;
            $sheetData = $this->import->get_data_import($file);
            $res = $this->validate_import_transaction($sheetData);
            if (!empty($res)) {
                return response()->json($res);
            }
            $listFail = [];
            foreach ($sheetData as $key => $value) {
                if (empty($value[0]) && empty($value[1]) && empty($value[2]) && empty($value[3])) continue;
                if ($key >= 1) {
                    $data = array(
                        "key" => ++$key,
                        "code_contract" => !empty($value[0]) ? (trim($value[0])) : "",
                        "tien_goc" => !empty($value[1]) ? (trim(str_replace(array(',', '.',), '', $value[1]))) : 0,
                        "tien_lai" => !empty($value[2]) ? (trim(str_replace(array(',', '.',), '', $value[2]))) : 0,
                        "created_at" => !empty($value[3]) ? (trim($value[3])) : "",
                    );
                    $return = Api::post('transaction/import_transaction_pay_ndt_uy_quyen', $data);
                    if (isset($return) && !empty($return['data'])) {
                        array_push($listFail, $return);
                    }
                }
            }
            $response = [
                'status' => Api::HTTP_OK,
                'message' => 'success',
                'data' => $listFail
            ];
            return response()->json($response);

        }
    }

    public function import_lead_investor(Request $request)
    {
        if (!$request->hasFile('upload_file')) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Không tìm thấy file"
            ];
            return response()->json($response);
        } else {
            $file = $request->upload_file;
            $sheetData = $this->import->get_data_import($file);
            $res = $this->validate_import_lead_investor($sheetData);
            if (!empty($res)) {
                return response()->json($res);
            }
            $listFail = [];
            foreach ($sheetData as $key => $value) {
                if (empty($value[0]) && empty($value[1]) && empty($value[2]) && empty($value[3]) && empty($value[4])) continue;
                if ($key >= 1) {
                    $data = array(
                        "key" => ++$key,
                        "name" => !empty($value[0]) ? (trim($value[0])) : "",
                        "phone" => !empty($value[1]) ? (trim($value[1])) : '',
                        "phone_link" => !empty($value[2]) ? (trim($value[2])) : '',
                        "status" => !empty($value[3]) ? (trim($value[3])) : "",
                        "source" => !empty($value[4]) ? (trim($value[4])) : "",
                    );
                    $return = Api::post('lead/importLeadInvestor', $data);
                    if (isset($return) && !empty($return['key'])) {
                        array_push($listFail, $return);
                    }
                }
            }
            $response = [
                'status' => Api::HTTP_OK,
                'message' => 'success',
                'data' => $listFail
            ];
            return response()->json($response);

        }
    }

    public function validate_import_lead_investor($sheetData)
    {
        if (stripos("nha-dau-tu", slugify(trim($sheetData[0][0]))) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô A định dạng bắt buộc là Nhà đầu tư"
            ];
            return $response;
        }
        if (stripos("so-dien-thoai", slugify(trim($sheetData[0][1]))) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô B định dạng bắt buộc là Số điện thoại"
            ];
            return $response;
        }
        if (stripos("tai-khoan-lien-ket", slugify(trim($sheetData[0][2]))) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô C định dạng bắt buộc là Tài khoản liên kết"
            ];
            return $response;
        }
        if (stripos("tinh-trang", slugify(trim($sheetData[0][3]))) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô D định dạng bắt buộc là Tình trạng"
            ];
            return $response;
        }
        if (stripos("nguon", slugify(trim($sheetData[0][4]))) === false) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Tên ô E định dạng bắt buộc là Nguồn"
            ];
            return $response;
        }
    }

    public function import_block_user_call(Request $request)
    {
        if (!$request->hasFile('upload_file')) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Không tìm thấy file"
            ];
            return response()->json($response);
        } else {
            $file = $request->upload_file;
            $sheetData = $this->import->get_data_import($file);
            $listFail = [];
            foreach ($sheetData as $key => $value) {
                if (empty($value[0])) continue;
                if ($key >= 1) {
                    $data = array(
                        "key" => ++$key,
                        "phone" => !empty($value[0]) ? (trim($value[0])) : "",
                    );
                    $return = Api::post('investor/block_user_assign_call', $data);
                    if (isset($return) && !empty($return['key'])) {
                        array_push($listFail, $return);
                    }
                }
            }
            $response = [
                'status' => Api::HTTP_OK,
                'message' => 'success',
                'data' => $listFail
            ];
            return response()->json($response);
        }
    }


    public function import_refferral_code(Request $request)
    {
        if (!$request->hasFile('upload_file')) {
            $response = [
                'status' => Api::HTTP_ERROR,
                'message' => "Không tìm thấy file"
            ];
            return response()->json($response);
        } else {
            $file = $request->upload_file;
            $sheetData = $this->import->get_data_import($file);
            $listFail = [];
            foreach ($sheetData as $key => $value) {
                if (empty($value[0]) && empty($value[1]) && empty($value[2])) continue;
                if ($key >= 1) {
                    $data = array(
                        "key" => ++$key,
                        "investor_code" => !empty($value[0]) ? (trim($value[0])) : "",
                        "refferral_code" => !empty($value[1]) ? (trim($value[1])) : "",
                        "date" => !empty($value[2]) ? (trim($value[2])) : "",
                    );
                    $return = Api::post('commission/import_commission', $data);
                    if (isset($return) && !empty($return['key'])) {
                        array_push($listFail, $return);
                    }
                }
            }
            $response = [
                'status' => Api::HTTP_OK,
                'message' => 'success',
                'data' => $listFail
            ];
            return response()->json($response);
        }
    }
}
