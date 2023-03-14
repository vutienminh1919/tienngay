<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Repository\KpiRepositoryInterface;
use App\Repository\LogKpiRepositoryInterface;
use App\Service\KpiService;
use App\Service\LogKpiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KpiController extends Controller
{
    public function __construct(
        KpiRepositoryInterface $kpi,
        KpiService $kpiService,
        LogKpiService $logKpiService,
        LogKpiRepositoryInterface $logKpiRepository
    )
    {
        $this->kpi_model = $kpi;
        $this->kpiService = $kpiService;
        $this->logKpiService = $logKpiService;
        $this->log_kpi_model = $logKpiRepository;

    }

    public function createKpi(Request $request)
    {
        $current_month = date('m');
        $current_year = date('Y');
        $message = '';
        $validate = Validator::make($request->all(), [
            'invest_target' => 'required'
        ], [
            'invest_target.required' => 'Bạn chưa nhập số tiền đầu tư kpi tháng'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        $dataInsert = [
            'invest_target' => $request->get('invest_target'),
            'month' => $current_month,
            'year' => $current_year,
            'created_by' => current_user()->email ?? ''
        ];
        $condition = [
            'month' => $current_month,
            'year' => $current_year
        ];

        $kpi_db = $this->kpi_model->findExistsKpi($condition);
        //Check: if not exists kpis in current month, year => insert new kpis otherwise update old data kpis
        if (empty($kpi_db)) {
            $kpi_data = $this->kpi_model->create($dataInsert);
            $dataId['id'] = $kpi_data->id;
            $dataInsert['action'] = 'create';
            $dataInsert['type'] = 'kpi';
            $this->logKpiService->insert_log_kpi($dataInsert, $dataId);
            $message = 'Thêm mới KPIs tháng ' . $current_month .  ' thành công!';
        } else {
            $dataUpdate = [
                'invest_target' => $request->get('invest_target'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => current_user()->email ?? ''
            ];
            $this->kpi_model->update($kpi_db['id'], $dataUpdate);
            $dataUpdate['action'] = "update";
            $dataUpdate['type'] = "kpi";
            $dataUpdate['created_by'] = current_user()->email ?? '';
            $this->logKpiService->insert_log_kpi($dataUpdate, $kpi_db);
            $message = 'Cập nhật KPIS tháng ' . $current_month . ' thành công!';
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => $message
        ]);
    }

    public function get_all_log_kpi(Request $request)
    {
        $filter = $request->only('from_date, to_date');
        if (!empty($request->get('from_date')) && $request->get('to_date')) {
            $from_date = strtotime($request->get('from_date'));
            $to_date = strtotime($request->get('to_date'));
            if ($from_date > $to_date) {
                $response = [
                    'status' => Controller::HTTP_BAD_REQUEST,
                    'message' => 'Thời gian tìm kiếm không hợp lệ!',
                ];
                return response()->json($response);
            }
        }
        $log_kpi_data = $this->log_kpi_model->get_all_log_kpi_sv($filter);
        $response = [
            'status' => Controller::HTTP_OK,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $log_kpi_data
        ];
        return response()->json($response);
    }
}
