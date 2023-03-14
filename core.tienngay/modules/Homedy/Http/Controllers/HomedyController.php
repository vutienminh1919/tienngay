<?php

namespace Modules\Homedy\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\Lead;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Entities\CskhInsert;

class HomedyController extends Controller
{

    public function list_province()
    {
        $response = Http::get('https://provinces.open-api.vn/api/p/');
        if ($response->ok()) {
            $data = json_decode($response->body(), true);
            return response()->json($data);
        }
        return response()->json([], Response::HTTP_BAD_REQUEST);
    }

    public function list_district()
    {
        $response = Http::get('https://provinces.open-api.vn/api/d/');
        if ($response->ok()) {
            $data = json_decode($response->body(), true);
            return response()->json($data);
        }
        return response()->json([], Response::HTTP_BAD_REQUEST);
    }

    public function send_lead_post(Request $request)
    {
        Log::channel('homedy')->info('(send_lead_post):'. print_r($request->all(), true));
        $validate = Validator::make($request->all(), [
            "name" => "required",
            "phone" => "required|regex:/([0-9]{10})\b/",
            "address_district" => "numeric|nullable",
            "address_province" => "numeric|nullable",
            "property_district" => "numeric|nullable",
            "property_province" => "numeric|nullable",
            "loan_money" => "numeric|nullable",
            "loan_amount" => "numeric|nullable",
            "loan_time" => "numeric|nullable",
            "homedy_id" => "required|numeric"
        ], [
            "name.required" => "Tên khách hàng không được để trống!",
            "phone.required" => "Số điện thoại không được để trống!",
            "phone.regex" => "Số điện thoại không đúng định dạng!",
            "address_district.number" => "Thông tin phải là dạng số",
            "address_province.number" => "Thông tin phải là dạng số",
            "property_district.number" => "Thông tin phải là dạng số",
            "property_province.number" => "Thông tin phải là dạng số",
            "loan_money.number" => "Thông tin phải là dạng số",
            "loan_amount.number" => "Thông tin phải là dạng số",
            "loan_time.number" => "Thông tin phải là dạng số",
            "homedy_id.required" => "Id không được để trống",
        ]);
        $start_day = Carbon::now()->startOfDay();
        $end_day = $start_day->clone()->endOfDay();
        if ($validate->fails()) {
            return response([
                'status' => (int) Response::HTTP_BAD_REQUEST,
                'error' => $validate->errors()
            ]);
        }

        // Check trùng trong ngày
        $check_lead = Lead::where(Lead::COLUMN_SOURCE, "Homedy")
            ->where(Lead::CREATED_AT, '>=', $start_day->getTimestamp())
            ->where(Lead::CREATED_AT, '<', $end_day->getTimestamp())
            ->where(Lead::COLUMN_PHONE_NUMBER, $request->phone)
            ->first();
        if ($check_lead) {
            return response([
                'status' => (int) Response::HTTP_BAD_REQUEST,
                'error' => "Lead đã tồn tại. Xin thử lại vào ngày mai."
            ]);
        }

        // Check trùng số đã có
        $check_lead_data = Lead::where(Lead::COLUMN_SOURCE, "Homedy")
            ->where(Lead::COLUMN_PHONE_NUMBER, $request->phone)
            ->first();
        if ($check_lead_data) {
            $update = Lead::where(Lead::COLUMN_ID, $check_lead_data->_id)->first();
            $update->update([
                'homedy_disable' => '1'
            ]);
        }

        // Lấy user tiếp theo
        $last_homedy = Lead::where(Lead::COLUMN_SOURCE, "Homedy")
            ->orderBy('_id', 'desc')
            ->limit(2)
            ->get();
        $list_insert_old = $last_homedy->map(function($item) {
            return $item->cskh;
        });
        $list_insert_old = $list_insert_old->unique();
        //dd($list_insert_old);
        $list_cskh = [];
        $cskh_insert = CskhInsert::orderBy('_id', 'desc')->first();
        if ($cskh_insert) {
            $cskh_insert = $cskh_insert->list_homedy ?? '';
            $list_cskh = explode(',', $cskh_insert);
        }
        $cskh = array_diff($list_cskh, $list_insert_old->toArray());
        $cskh = collect($cskh)->first();

        $data = collect([]);
        $data->put(Lead::COLUMN_FULL_NAME, $request->name);
        $data->put(Lead::COLUMN_PHONE_NUMBER, $request->phone);
        $data->put(Lead::COLUMN_SOURCE, "Homedy");
        $data->put(Lead::CREATED_AT, time());
        $data->put(Lead::COLUMN_STATUS, Lead::STATUS_NEW);
        $data->put(Lead::COLUMN_STATUS_SALE, Lead::STATUS_SALE_NEW);
        $data->put(Lead::COLUMN_UTM_SOURCE, 'Homedy');
        $data->put(Lead::COLUMN_UTM_CAMPAIGN, 'Homedy');
        $data->put(Lead::COLUMN_TYPE_FINANCE, '9');
        $data->put(Lead::COLUMN_HOMEDY_STATUS, '1');
        $data->put(Lead::COLUMN_HOMEDY_ID, $request->homedy_id);
        $data->put(Lead::COLUMN_CSKH, $cskh);
        if ( $check_lead_data ) {
            $data->put(Lead::COLUMN_HOMEDY_LOG, $check_lead_data->homedy_log);
            $data->put(Lead::COLUMN_HOMEDY_AMOUNT, $check_lead_data->homedy_amount);
        }
        if ( $request->address_province ) {
            $data->put(Lead::COLUMN_HK_PROVINCE, $request->address_province);
        }
        if ( $request->address_district ) {
            $data->put(Lead::COLUMN_HK_DISTRICT, $request->address_district);
        }
        if ( $request->property_province ) {
            $data->put(Lead::COLUMN_NS_PROVINCE, $request->property_province);
        }
        if ( $request->property_district ) {
            $data->put(Lead::COLUMN_NS_DISTRICT, $request->property_district);
        }
        if ( $request->loan_money ) {
            $data->put(Lead::COLUMN_LOAN_AMOUNT, $request->loan_money);
            $data->put(Lead::COLUMN_HOMEDY_MONEY, $request->loan_money);
        }
        if ( $request->loan_amount ) {
            $data->put(Lead::COLUMN_LOAN_AMOUNT, $request->loan_amount);
            $data->put(Lead::COLUMN_HOMEDY_MONEY, $request->loan_amount);
        }
        if ( $request->loan_time ) {
            $data->put(Lead::COLUMN_LOAN_TIME, $request->loan_time);
        }
        $model = new Lead();
        $result = $model->fill($data->toArray())->save();
        if ($result) {
            Log::channel('homedy')->info('(send_lead_post): Success');
            return response()->json([
                'status' => (int) Response::HTTP_OK,
                'id' => $model->_id
            ]);
        }
        return response([
            'status' => (int) Response::HTTP_INTERNAL_SERVER_ERROR
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function get_lead(Request $request) {
        $lead = Lead::select([
            Lead::COLUMN_FULL_NAME,
            Lead::COLUMN_PHONE_NUMBER,
            Lead::COLUMN_HK_PROVINCE,
            Lead::COLUMN_HK_DISTRICT,
            Lead::COLUMN_NS_PROVINCE,
            Lead::COLUMN_NS_DISTRICT,
            Lead::COLUMN_LOAN_AMOUNT,
            Lead::COLUMN_LOAN_TIME,
            Lead::COLUMN_HOMEDY_STATUS,
            Lead::COLUMN_HOMEDY_ID,
            Lead::COLUMN_HOMEDY_LOG
        ])->where(Lead::COLUMN_SOURCE, "Homedy")
        ->orderBy(Lead::COLUMN_ID, "DESC")->paginate();
        $lead = $lead->toArray();
        $data = data_get($lead, 'data');
        $data = collect($data)->map(function($item) {
            $result['id'] = $item[Lead::COLUMN_ID] ?? '';
            $result['name'] = $item[Lead::COLUMN_FULL_NAME] ?? '';
            $result['phone'] = $item[Lead::COLUMN_PHONE_NUMBER] ?? '';
            if ( isset($item[Lead::COLUMN_HK_DISTRICT]) ) {
                $result['address_district'] = (int) $item[Lead::COLUMN_HK_DISTRICT] ?? '';
            }
            if ( isset($item[Lead::COLUMN_HK_PROVINCE]) ) {
                $result['address_province'] = (int) $item[Lead::COLUMN_HK_PROVINCE] ?? '';
            }
            if ( isset($item[Lead::COLUMN_NS_DISTRICT]) ) {
                $result['property_district'] = (int) $item[Lead::COLUMN_NS_DISTRICT] ?? '';
            }
            if ( isset($item[Lead::COLUMN_NS_PROVINCE]) ) {
                $result['property_province'] = (int) $item[Lead::COLUMN_NS_PROVINCE] ?? '';
            }
            if ( isset($item[Lead::COLUMN_LOAN_AMOUNT]) ) {
                $result['loan_money'] = isset($item[Lead::COLUMN_HOMEDY_LOG]) ? collect($item[Lead::COLUMN_HOMEDY_LOG])->sum('loan_money') : 0;
            }
            if ( isset($item[Lead::COLUMN_LOAN_TIME]) ) {
                $result['loan_time'] = (int) $item[Lead::COLUMN_LOAN_TIME] ?? '';
            }
            if ( isset($item[Lead::COLUMN_HOMEDY_AMOUNT]) ) {
                $result['loan_amount'] = isset($item[Lead::COLUMN_HOMEDY_LOG]) ? collect($item[Lead::COLUMN_HOMEDY_LOG])->sum('amount_money') : 0;
            }
            $result['homedy_id'] = (int) $item[Lead::COLUMN_HOMEDY_ID] ?? '';
            $result['status'] = (int) $item[Lead::COLUMN_HOMEDY_STATUS] ?? '1';
            $result['homedy_log'] = $item[Lead::COLUMN_HOMEDY_LOG] ?? null;
            return $result;
        });
        $lead['data'] = $data;
        return response()->json($lead);
    }

    public function find_lead(Request $request) {
        $lead = Lead::select([
            Lead::COLUMN_FULL_NAME,
            Lead::COLUMN_PHONE_NUMBER,
            Lead::COLUMN_HK_PROVINCE,
            Lead::COLUMN_HK_DISTRICT,
            Lead::COLUMN_NS_PROVINCE,
            Lead::COLUMN_NS_DISTRICT,
            Lead::COLUMN_LOAN_AMOUNT,
            Lead::COLUMN_LOAN_TIME,
            Lead::COLUMN_HOMEDY_STATUS,
            Lead::COLUMN_HOMEDY_ID,
            Lead::COLUMN_HOMEDY_LOG
        ])->where(Lead::COLUMN_SOURCE, "Homedy")
        ->where(Lead::COLUMN_HOMEDY_ID, $request->homedy_id)->first();
        $item = $lead->toArray();
        $result['id'] = $item[Lead::COLUMN_ID] ?? '';
        $result['name'] = $item[Lead::COLUMN_FULL_NAME] ?? '';
        $result['phone'] = $item[Lead::COLUMN_PHONE_NUMBER] ?? '';
        if ( isset($item[Lead::COLUMN_HK_DISTRICT]) ) {
            $result['address_district'] = (int) $item[Lead::COLUMN_HK_DISTRICT] ?? '';
        }
        if ( isset($item[Lead::COLUMN_HK_PROVINCE]) ) {
            $result['address_province'] = (int) $item[Lead::COLUMN_HK_PROVINCE] ?? '';
        }
        if ( isset($item[Lead::COLUMN_NS_DISTRICT]) ) {
            $result['property_district'] = (int) $item[Lead::COLUMN_NS_DISTRICT] ?? '';
        }
        if ( isset($item[Lead::COLUMN_NS_PROVINCE]) ) {
            $result['property_province'] = (int) $item[Lead::COLUMN_NS_PROVINCE] ?? '';
        }
        if ( isset($item[Lead::COLUMN_LOAN_AMOUNT]) ) {
            $result['loan_money'] = isset($item[Lead::COLUMN_HOMEDY_LOG]) ? collect($item[Lead::COLUMN_HOMEDY_LOG])->sum('loan_money') : 0;
        }
        if ( isset($item[Lead::COLUMN_LOAN_TIME]) ) {
            $result['loan_time'] = (int) $item[Lead::COLUMN_LOAN_TIME] ?? '';
        }
        if ( isset($item[Lead::COLUMN_HOMEDY_AMOUNT]) ) {
            $result['loan_amount'] = isset($item[Lead::COLUMN_HOMEDY_LOG]) ? collect($item[Lead::COLUMN_HOMEDY_LOG])->sum('amount_money') : 0;
        }
        $result['homedy_id'] = (int) $item[Lead::COLUMN_HOMEDY_ID] ?? '' ;
        $result['status'] = (int) $item[Lead::COLUMN_HOMEDY_STATUS] ?? '1';
        $result['homedy_log'] = $item[Lead::COLUMN_HOMEDY_LOG] ?? null;
        return response()->json($result);
    }
}
