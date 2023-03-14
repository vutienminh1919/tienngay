<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm3RepositoryInterface;

class ReportForm3Controller extends BaseController
{
    /**
    * Modules\MongodbCore\Repositories\ReportForm3Repository
    */
    private $reportForm3Repo;

   /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Report"
     * )
     */
    public function __construct(
        ReportForm3RepositoryInterface $reportForm3Repository
    ) {
       $this->reportForm3Repo = $reportForm3Repository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function search(Request $request)
    {
        $data = $request->all();
        Log::channel('report')->info('Report search requested: ' . print_r($data, true));
        if (empty($data)) {
            return response()->json([
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Report::messages.not_found')
            ]);
        }
        $validator = Validator::make($data, [
            'contract_code'   => 'string|max:50',
            'contract_disbursement'   => 'string|max:50',
            'store_id'   => 'string|max:50',
            'range_time' => 'date_format:Y-m'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            Log::channel('report')->info('Report search response: ' . print_r($response, true));
            return response()->json($response);
        }
        $results = $this->reportForm3Repo->search($data);
        if (empty($results)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Report::messages.not_found'),
                'data' => $results
            ];
            Log::channel('report')->info('Report search response: ' . print_r($response, true));
            return response()->json($response);
        }
        
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('Report::messages.success'),
            'data' => $results
        ];
        //Log::channel('report')->info('Report search response: ' . print_r($response, true));
        return response()->json($response);
        
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function importDungTinhLai(Request $request)
    {
        $data = $request->all();
        Log::channel('report')->info('Report importDungTinhLai requested: ' . print_r($data, true));
        if (empty($data)) {
            return response()->json([
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Report::messages.data_import_empty')
            ]);
        }
        foreach ($data as $key => $value) {
            $validator = $this->validate($value);
            if($validator->fails()) {
                return response()->json([
                    'data' => [],
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => $validator->errors()->first()
                ]);
            }
            $results = $this->reportForm3Repo->importNgayDungTinhLai($value);
        }
        
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('Report::messages.success'),
            'data' => []
        ];
        Log::channel('report')->info('Report importDungTinhLai response: ' . print_r($response, true));
        return response()->json($response);
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
}
