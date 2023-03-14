<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm3RepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Validator;

class ReportViewController extends BaseController
{

    /**
    * Modules\MongodbCore\Repositories\ReportForm3Repository
    */
    private $reportForm3Repo;

    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepo;

    public function __construct(
        ReportForm3RepositoryInterface $reportForm3Repository,
        StoreRepository $storeRepository
    ) {
       $this->reportForm3Repo = $reportForm3Repository;
       $this->storeRepo = $storeRepository;
       $this->middleware('tokenIsValid');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function reportForm3()
    {   $currentTime = new DateTime('1 month ago');
        //$results = $this->reportForm3Repo->getListByMonth($currentTime->format("Y-m-d"));
        $results = [
            'total' => 0,
            'data' => []
        ];
        $stores = $this->storeRepo->getAll();
        return view('viewcpanel::reportForm3.index', [
            'results' => $results,
            'currentTime' => $currentTime->format("Y-m"),
            'stores' => $stores,
            'filterUrl' => route('ViewCpanel::ReportForm3.search'),
            'urlImport' => route('viewcpanel::ReportForm3.importExcel'),
            'downloadFile' => route('viewcpanel::ReportForm3.downloadBieuMau')
        ]);
    }

    public function search(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.reportForm3.search');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $results = Http::asForm()->post($url, $dataPost);
        return response()->json($results->json());
    }

    public function importExcel(Request $request) {
        $user = session('user');
        if (!$request->hasFile('upload_file')) {
            return response()->json([
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Report::messages.file_not_found')
            ]);
        } else {
            $file_mimes = array(
                'text/x-comma-separated-values', 
                'text/comma-separated-values', 
                'application/octet-stream', 
                'application/vnd.ms-excel', 
                'application/x-csv', 
                'text/x-csv', 
                'text/csv', 
                'application/csv', 
                'application/excel', 
                'application/vnd.msexcel', 
                'text/plain', 
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );
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
                Log::info("data import".  print_r($sheetData, true));
                foreach ($sheetData as $key => $value) {
                    if($this->isEmptyRow($value)) { 
                        continue; 
                    }
                    if ($key >= 1) {
                        $data = array(
                            "ma_phieu_ghi" => !empty($value["1"]) ? (str_replace(' ', '', $value["1"])) : "",
                            "flag_dung_tinh_lai" => isset($value["2"]) ? (trim($value["2"])) : "",
                            "ngay_dung_tinh_lai" => isset($value["3"]) ? (trim($value["3"])) : "",
                            "created_by"         => !empty($user['email']) ? $user['email'] : ""
                        );
                        $arrData[] = $data;
                        $validator = $this->validate($data);
                        if($validator->fails()) {
                            return response()->json([
                                'data' => [],
                                'status' => Response::HTTP_BAD_REQUEST,
                                'message' => $validator->errors()->first().' tại dòng ' . ($key + 1)
                            ]);
                        }
                    }
                }
                if (empty($arrData)) {
                    return response()->json([
                        'data' => [],
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => __('Report::messages.data_import_empty')
                    ]);
                }
                $url = config('routes.reportForm3.importDungTinhLai');
                Log::info('Call Api: ' . $url . ' ' . print_r($arrData, true));
                //call api
                $results = Http::asForm()->post($url, $arrData);
                return response()->json($results->json());
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
            'ma_phieu_ghi'         => 'required',
            'ngay_dung_tinh_lai' => 'nullable|date'
        ],
        [
            'ma_phieu_ghi.required' => 'Mã phiếu ghi không được để trống',
            'ngay_dung_tinh_lai.date_format' => 'Ngày dừng tính lãi không đúng định dạng'
        ]);
        $validator->after(function() use ($validator, $dataPost) {
            if ($dataPost['flag_dung_tinh_lai'] == '×' || empty($dataPost['flag_dung_tinh_lai'])) {
                //pass
            } else {
                $validator->errors()->add('flag_dung_tinh_lai', 'Đánh dấu dừng tính lãi không đúng định dạng');
            }
        });
        return $validator;
    }

    public function isEmptyRow($row) {
        if (!array_filter($row)) {
            return true;
        }
        return false;
    }

    /**
     * download excel import template
     */
    public function downloadBieuMau($filename = '')
    {
        // Check if file exists in app/storage/file folder
        $file_path = storage_path() . "/app/public/" . 'form3_import_dung_tinh_lai.xlsx';
        $headers = array(
            'Content-Type' => 'application/csv',
            'Content-Disposition' => 'attachment; filename=' . 'form3_import_dung_tinh_lai.xlsx',
        );
        if ( file_exists( $file_path ) ) {
            // Send Download
            return \Response::download( $file_path, 'form3_import_dung_tinh_lai.xlsx', $headers );
        } else {
            // Error
            exit('File không tồn tại');
        }
    }

}
