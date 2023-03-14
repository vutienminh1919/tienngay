<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $chart_invest = [];
        $month = [];
        $response = Api::post('transaction/chart_invest');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $chart_invest = !empty($response['data']['invest']) ? $response['data']['invest'] : [];
            $month = !empty($response['data']['month']) ? $response['data']['month'] : [];
        }

        $chart_invest_by_day = [];
        $date = [];
        $response1 = Api::post('transaction/chart_invest_by_day_on_month');
        if (isset($response1['status']) && $response1['status'] == Api::HTTP_OK) {
            $chart_invest_by_day = !empty($response1['data']['invest']) ? $response1['data']['invest'] : [];
            $date = !empty($response1['data']['date']) ? $response1['data']['date'] : [];
        }

        $chart_payment_by_day_goc = [];
        $chart_payment_by_day_lai = [];
        $chart_payment_by_day_tong = [];
        $date1 = [];
        $response2 = Api::post('transaction/chart_payment_by_day_on_month');
        if (isset($response2['status']) && $response2['status'] == Api::HTTP_OK) {
            $chart_payment_by_day_tong = !empty($response2['data']['tong_goc_lai']) ? $response2['data']['tong_goc_lai'] : [];
            $chart_payment_by_day_goc = !empty($response2['data']['tien_goc']) ? $response2['data']['tien_goc'] : [];
            $chart_payment_by_day_lai = !empty($response2['data']['tien_lai']) ? $response2['data']['tien_lai'] : [];
            $date1 = !empty($response2['data']['date']) ? $response2['data']['date'] : [];
        }

        $chart_payment_tong = [];
        $chart_payment_goc = [];
        $chart_payment_lai = [];
        $month1 = [];
        $response3 = Api::post('transaction/chart_payment');
        if (isset($response3['status']) && $response3['status'] == Api::HTTP_OK) {
            $chart_payment_tong = !empty($response3['data']['tong_goc_lai']) ? $response3['data']['tong_goc_lai'] : [];
            $chart_payment_goc = !empty($response3['data']['tien_goc']) ? $response3['data']['tien_goc'] : [];
            $chart_payment_lai = !empty($response3['data']['tien_lai']) ? $response3['data']['tien_lai'] : [];
            $month1 = !empty($response3['data']['month']) ? $response3['data']['month'] : [];
        }
        $name = (Session::get('user')['full_name']);
        $message = "Welcome, " . $name;
        toastSuccess($message);
        return view('dashboard.dashboard', compact('chart_invest', 'month', 'chart_invest_by_day', 'date', 'date1', 'chart_payment_by_day_tong', 'chart_payment_by_day_goc', 'chart_payment_by_day_lai', 'month1', 'chart_payment_goc', 'chart_payment_tong', 'chart_payment_lai'));
    }

    public function dashboard_telesales(Request $request)
    {
        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');
        $dataSendApi = array();
        if (!empty($from_date) && !empty($to_date)) {
            $dataSendApi = [
                'from_date' => $from_date,
                'to_date' => $to_date
            ];
        }
        $response_dash = Api::post('transaction/dashboard_ndt', $dataSendApi);
        if (!empty($response_dash['status']) && $response_dash['status'] == Api::HTTP_OK) {
            $dashboard_data = !empty($response_dash['data']) ? $response_dash['data'] : [];
        } else {
            $dashboard_data = [];
            $message_dash = $response_dash['message'] ?? '';
            if (!empty($message_dash)) {
                toastError($message_dash, 'LỖI TÌM KIẾM', [
                    'positionClass' => 'toast-top-right'
                ]);
            }
        }
        return view('dashboard.dashboard_ndt', compact('dashboard_data'));
    }

    public function add_kpi(Request $request)
    {
        $data = [
            'invest_target' => str_replace(array('.', ','), '', $request->invest_target)
        ];
        $response = Api::post('kpi', $data);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => $response['message']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']['invest_target'][0]) ? $response['message']['invest_target'][0] : 'Cập nhật thất bại',
                'data' => $response['data'] ?? 0
            ]);
        }
    }

    public function get_list_log_kpi(Request $request)
    {
        $filter = array();
        if (!empty($request->has('from_date')) && !empty($request->get('from_date'))) {
            $filter['from_date'] = $request->get('from_date');
        }
        if (!empty($request->has('to_date')) && !empty($request->get('to_date'))) {
            $filter['to_date'] = $request->get('to_date');
        }
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // Call api get data
        $response = Api::post('log_kpi' . '?page=' . $page, $filter);
        $log_kpi_data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == 200) {
            $res_data = $response['data'];
            $log_kpi_data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($log_kpi_data, $log_kpi_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        } else {
            toastError($response['message'] ?? '', "LỖI TÌM KIẾM!");
        }
        return view('log_kpi.list_log_kpi', compact('log_kpi_data', 'paginate'));

    }
}
