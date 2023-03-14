<?php

namespace App\Http\Controllers;

use App\Service\Excel;
use Illuminate\Http\Request;
use App\Service\Api;
use App\Service\ApiUrl;
use Illuminate\Support\Facades\Session;

class InvestorController extends Controller
{

    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';
    const STATUS_DEACTIVE = 'deactive';

    const REVIEWS_MEMBER = 'member';
    const REVIEWS_BRONZE = 'bronze';
    const REVIEWS_SILVER = 'silver';
    const REVIEWS_GOLD = 'gold';
    const REVIEWS_DIAMON = 'diamon';

    const TYPE_NHAN_VIEN = 1;
    const TYPE_NHA_DAU_TU_APP = 2;
    const TYPE_NHA_DAU_TU_UY_QUYEN = 3;

    public function __construct(Excel $excel)
    {
        $this->sheet = $excel;
    }

    public function listNew(Request $request)
    {
        // Filter
        $filter = [];
        if ($request->has('start_date') && $request->get('start_date') != '') {
            $filter['start_date'] = $request->get('start_date');
        }
        if ($request->has('end_date') && $request->get('end_date') != '') {
            $filter['end_date'] = $request->get('end_date');
        }
        if ($request->has('name') && $request->get('name') != '') {
            $filter['name'] = $request->get('name');
        }
        if ($request->has('email') && $request->get('email') != '') {
            $filter['email'] = $request->get('email');
        }
        if ($request->has('phone') && $request->get('phone') != '') {
            $filter['phone'] = $request->get('phone');
        }
        if ($request->has('status') && $request->get('status') != '') {
            $filter['status'] = $request->get('status');
        }
        if ($request->has('status_call') && $request->get('status_call') != '') {
            $filter['status_call'] = $request->get('status_call');
        }
        if ($request->has('note_delete') && $request->get('note_delete') != '') {
            $filter['note_delete'] = $request->get('note_delete');
        }
        if ($request->has('find_call_assign') && $request->get('find_call_assign') != '') {
            $filter['find_call_assign'] = $request->get('find_call_assign');
        }


        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post(ApiUrl::INVESTOR_NEW_LIST . '?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        $count = 0;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? ($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
            $count = $res_data['total'] ?? 0;
        }
        $telesales = Api::post('role/get_user_role_telesales', ['slug' => 'telesales']);
        $user_tls = $telesales['data'];

        return view('investor.list-new', compact('data', 'paginate', 'user_tls', 'count'));
    }

    public function confirmNew(Request $request)
    {
        $investor_list = $request->get('investor_list', '');
        $response = Api::post(ApiUrl::INVESTOR_NEW_CONFIRM, [
            'investor_list' => $investor_list,
            'created_by' => Session::get('user')['email']
        ]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công'
            ]);
        }
        return response()->json([
            'status' => Api::HTTP_ERROR,
            'message' => 'Error'
        ]);
    }

    public function blockNew(Request $request)
    {
        $investor_list = $request->get('investor_list', '');
        $response = Api::post(ApiUrl::INVESTOR_NEW_BLOCK, [
            'investor_list' => $investor_list
        ]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công'
            ]);
        }
        return response()->json([
            'status' => Api::HTTP_ERROR,
            'message' => 'Error'
        ]);
    }

    public function detailNew($id)
    {
        $response = Api::post(ApiUrl::INVESTOR_NEW_DETAIL, ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            return view('investor.detail-new', compact('data', 'id'));
        }
        return abort(404);
    }

    public function detailNewPost(Request $request, $id)
    {
        $response = Api::post('investor/new/update', [
            'id' => $id,
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return redirect()->route('investor_new_list')->with('success', 'Cập nhật nhà đầu tư ' . $request->get('name') . ' thành công');
        } else {
            $response = Api::post(ApiUrl::INVESTOR_NEW_DETAIL, ['id' => $id]);
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $data = isset($response['data']) ? $response['data'] : [];
                return view('investor.detail-new', compact('data'));
            }
        }
    }

    public function list(Request $request)
    {

        // Filter
        $filter = [];
        if ($request->has('name') && $request->get('name') != '') {
            $filter['name'] = $request->get('name');
        }
        if ($request->has('phone') && $request->get('phone') != '') {
            $filter['phone'] = $request->get('phone');
        }
        if ($request->has('email') && $request->get('email') != '') {
            $filter['email'] = $request->get('email');
        }
        if ($request->has('status_call') && $request->get('status_call') != '') {
            $filter['status_call'] = $request->get('status_call');
        }
        if ($request->has('note_delete') && $request->get('note_delete') != '') {
            $filter['note_delete'] = $request->get('note_delete');
        }
        if ($request->has('investment_status') && $request->get('investment_status') != '') {
            $filter['investment_status'] = $request->get('investment_status');
        }
        if ($request->has('find_call_assign') && $request->get('find_call_assign') != '') {
            $filter['find_call_assign'] = $request->get('find_call_assign');
        }

        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post('investor/list_v2' . '?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        $count = 0;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
            $count = $res_data['total'] ?? 0;
        }
        $telesales = Api::post('role/get_user_role_telesales', ['slug' => 'telesales']);
        $user_tls = $telesales['data'];
        return view('investor.list', compact('data', 'paginate', 'user_tls', 'count'));
    }

    public function detail($id)
    {
        $response = Api::post(ApiUrl::INVESTOR_DETAIL, ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            return view('investor.detail', compact('data'));
        }
        return abort(404);
    }

    public function list_ndt_uy_quyen(Request $request)
    {
        // Filter
        $filter = [];
        if ($request->has('name') && $request->get('name') != '') {
            $filter['name'] = $request->get('name');
        }
        if ($request->has('phone') && $request->get('phone') != '') {
            $filter['phone'] = $request->get('phone');
        }
        if ($request->has('email') && $request->get('email') != '') {
            $filter['email'] = $request->get('email');
        }
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post(ApiUrl::INVESTOR_LIST_UY_QUYEN . '?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('investor.list_uy_quyen', compact('data', 'paginate'));
    }

    public function update_invester_active(Request $request)
    {
        $response = Api::post('investor/update_invester_active', [
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => "Cập nhật thành công"
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => 'Cập nhật không thành công'
            ]);
        }
    }

    public function excel_all_list_active()
    {
        $response = Api::post('investor/excel_list_v2');
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Số điện thoại');
            $this->sheet->setCellValue('C1', 'Trạng thái đầu tư');
            $this->sheet->setCellValue('D1', 'Tình trạng Call');
            $this->sheet->setCellValue('E1', 'Lý do hủy');
            $this->sheet->setCellValue('F1', 'Ghi chú');
            $this->sheet->setCellValue('G1', 'Ngày sinh');
            $this->sheet->setCellValue('H1', 'Khu vực');
            $this->sheet->setCellValue('I1', 'Ngày kích hoạt');
            $this->sheet->setCellValue('J1', 'Số gói đầu tư');
            $this->sheet->setCellValue('K1', 'Nhân viên');
            $this->sheet->setCellValue('L1', 'Số tiền đầu tư');
            $this->sheet->setCellValue('M1', 'Số tiền gốc còn lại');

            $this->sheet->setStyle("A1");
            $this->sheet->setStyle("B1");
            $this->sheet->setStyle("C1");
            $this->sheet->setStyle("D1");
            $this->sheet->setStyle("E1");
            $this->sheet->setStyle("F1");
            $this->sheet->setStyle("G1");
            $this->sheet->setStyle("H1");
            $this->sheet->setStyle("I1");
            $this->sheet->setStyle("J1");
            $this->sheet->setStyle("K1");
            $this->sheet->setStyle("L1");
            $this->sheet->setStyle("M1");
            $i = 2;
            foreach ($data as $item) {
                $this->sheet->setCellValue('A' . $i, !empty($item['name']) ? $item['name'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['phone_number']) ? $item['phone_number'] : '');
                $this->sheet->setCellValue('C' . $i, $item['investment_status'] == 1 ? "Đã đầu tư" : 'Chưa đầu tư');
                $this->sheet->setCellValue('D' . $i, !empty($item['call_status']) ? lead_status($item['call_status']) : "");
                $this->sheet->setCellValue('E' . $i, !empty($item['note_cancel']) ? note_delete($item['note_cancel']) : "");
                $this->sheet->setCellValue('F' . $i, !empty($item['call_note']) ? ($item['call_note']) : "");
                $this->sheet->setCellValue('G' . $i, !empty($item['birthday']) ? date('d/m/Y', strtotime($item['birthday'])) : "");
                $this->sheet->setCellValue('H' . $i, !empty($item['city']) ? get_province_name_by_code($item['city']) : "");
                $this->sheet->setCellValue('I' . $i, !empty($item['active_at']) ? date('d/m/Y', strtotime($item['active_at'])) : '');
                $this->sheet->setCellValue('J' . $i, !empty($item['total_contract']) ? ($item['total_contract']) : 0, true);
                $this->sheet->setCellValue('K' . $i, !empty($item['user_call']) ? $item['user_call'] : "");
                $this->sheet->setCellValue('L' . $i, !empty($item['total_money_contract']) ? $item['total_money_contract'] : 0, true);
                $this->sheet->setCellValue('M' . $i, !empty($item['goc_con_lai']) ? round($item['goc_con_lai']) : 0, true);
                $i++;
            }
            $this->sheet->callLibExcel('data-investor-' . time() . '.xlsx');
        } else {

            redirect()->route('investor_list')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function detail_investor($id)
    {
        $response = Api::post(ApiUrl::INVESTOR_DETAIL, ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => "Thất bại"
            ]);
        }
    }

    public function them_phu_luc_ndt_uy_quyen(Request $request)
    {
        $data = [
            'id' => $request->id_investor,
            'amount_money' => str_replace(array(',', '.',), '', $request->amount_money),
            'code_contract' => $request->code_contract,
            'interest' => $request->interest,
            'created_at' => $request->ngay_dau_tu,
            'payment_method' => $request->hinh_thuc_thanh_toan,
            'investment_cycle' => 365,
            'date_interest' => $request->hinh_thuc_tinh_lai,
            'type_interest' => $request->hinh_thuc_tra_lai,
            'number_day_loan' => $request->thoi_gian_dau_tu,
            'date_pay' => $request->date_pay
        ];
        $response = Api::post('contract/them_phu_luc_ndt_uy_quyen', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }

    public function call_detail(Request $request)
    {
        $response = Api::post('investor/call_detail', ['id' => $request->id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = $response['data'];
            if (!isset($data['call'])) {
                $data['call'] = [
                    'status' => '',
                    'note' => '',
                    'call_note' => ''
                ];
            }
            $data['number_phonenet'] = base64_encode($data['phone_number']);
            $data['hide_phone_number'] = hide_phone($data['phone_number']);
            $data['hide_phone_vimo'] = hide_phone($data['phone_vimo']);
            $data['hide_code'] = hide_phone($data['code']);
            return response()->json([
                'status' => Api::HTTP_OK,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => "Thất bại"
            ]);
        }
    }

    public function call_update_investor(Request $request)
    {
        $data = [
            'id' => $request->id,
            'email' => $request->email,
            'identity' => $request->identity,
            'name' => $request->name,
            'avatar' => $request->avatar,
            'front_facing_card' => $request->front_facing_card,
            'card_back' => $request->card_back,
            'birthday' => $request->birthday,
            'city' => $request->city,
            'status' => $request->status,
            'note' => $request->note,
            'call_note' => $request->call_note,
            'job' => $request->job,
            'address' => $request->address,
        ];
        $response = Api::post('investor/call_update_investor', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Cập nhật thất bại'
            ]);
        }
    }

    public function thong_ke_call(Request $request)
    {
        return view('investor.thong_ke_call');
    }

    public function excel_call(Request $request)
    {
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('thong_ke_call')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        $response = Api::post('investor/excel_call_v2', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $roles = !empty($response['role']) ? $response['role'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Số điện thoại');
            $this->sheet->setCellValue('C1', 'Tài khoản liên kết');
            $this->sheet->setCellValue('D1', 'Tình trang tài khoản');
            $this->sheet->setCellValue('E1', 'Tình trạng Call');
            $this->sheet->setCellValue('F1', 'Lý do hủy');
            $this->sheet->setCellValue('G1', 'Ghi chú');
            $this->sheet->setCellValue('H1', 'Ngày đăng kí');
            $this->sheet->setCellValue('I1', 'Nguồn');
            $this->sheet->setCellValue('J1', 'SDT giới thiệu');
            if (in_array('telesales', $roles)) {
                $this->sheet->setCellValue('K1', 'Nhân viên');
                $this->sheet->setCellValue('L1', 'Tác động lần cuối');
            }


            $this->sheet->setStyle("A1");
            $this->sheet->setStyle("B1");
            $this->sheet->setStyle("C1");
            $this->sheet->setStyle("D1");
            $this->sheet->setStyle("E1");
            $this->sheet->setStyle("F1");
            $this->sheet->setStyle("G1");
            $this->sheet->setStyle("H1");
            $this->sheet->setStyle("I1");
            $this->sheet->setStyle("J1");
            if (in_array('telesales', $roles)) {
                $this->sheet->setStyle("K1");
                $this->sheet->setStyle("L1");
            }
            $i = 2;
            foreach ($data as $item) {
                $this->sheet->setCellValue('A' . $i, !empty($item['name']) ? $item['name'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['phone_number']) ? $item['phone_number'] : '');
                $this->sheet->setCellValue('C' . $i, !empty($item['phone_vimo']) ? $item['phone_vimo'] : "");
                $this->sheet->setCellValue('D' . $i, ($item['status'] == 'active') ? 'Đã kích hoạt' : 'Chưa kích hoạt');
                $this->sheet->setCellValue('E' . $i, !empty($item['call_status']) ? lead_status($item['call_status']) : "");
                $this->sheet->setCellValue('F' . $i, !empty($item['note_cancel']) ? note_delete($item['note_cancel']) : "");
                $this->sheet->setCellValue('G' . $i, !empty($item['call_note']) ? ($item['call_note']) : "");
                $this->sheet->setCellValue('H' . $i, !empty($item['created_at']) ? date('d/m/Y H:i:s', strtotime($item['created_at'])) : '');
                $this->sheet->setCellValue('I' . $i, !empty($item['source']) ? $item['source'] : '');
                $this->sheet->setCellValue('J' . $i, !empty($item['referral_code']) ? $item['referral_code'] : '');
                if (in_array('telesales', $roles)) {
                    $this->sheet->setCellValue('K' . $i, !empty($item['user_call']) ? $item['user_call'] : '');
                    $this->sheet->setCellValue('L' . $i, !empty($item['call_updated_at']) ? date('d/m/Y H:i:s', strtotime($item['call_updated_at'])) : '');
                }
                $i++;
            }
            $this->sheet->callLibExcel('data-investor-' . time() . '.xlsx');
        } else {
            redirect()->route('thong_ke_call')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function get_list_lead_investor(Request $request)
    {
        $filter = [];
        if ($request->has('phone') && $request->get('phone') != '') {
            $filter['phone'] = $request->get('phone');
        }
        if ($request->has('name_investor') && $request->get('name_investor') != '') {
            $filter['name_investor'] = $request->get('name_investor');
        }
        if ($request->has('status_call') && $request->get('status_call') != '') {
            $filter['status_call'] = $request->get('status_call');
        }
        if ($request->has('note_delete') && $request->get('note_delete') != '') {
            $filter['note_delete'] = $request->get('note_delete');
        }
        if ($request->has('source') && $request->get('source') != '') {
            $filter['source'] = $request->get('source');
        }
        if ($request->has('find_call_assign') && $request->get('find_call_assign') != '') {
            $filter['find_call_assign'] = $request->get('find_call_assign');
        }

        if ($request->has('priority') && $request->get('priority') != '') {
            $filter['priority'] = $request->get('priority');
        }

        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post('lead/get_list_lead_investor' . '?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        $telesales = Api::post('role/get_user_role_telesales', ['slug' => 'telesales']);
        $user_tls = $telesales['data'];
        return view('investor.lead_investor', compact('data', 'paginate', 'user_tls'));
    }

    public function call_lead_detail(Request $request)
    {
        $response = Api::post('lead/call_detail', ['id' => $request->id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = $response['data'];
            if (!isset($data['call'])) {
                $data['call'] = [
                    'status' => '',
                    'note' => '',
                    'call_note' => ''
                ];
            }
            $data['number_phonenet'] = base64_encode($data['phone']);
            $data['hide_phone_number'] = hide_phone($data['phone']);
            $data['hide_phone_vimo'] = hide_phone($data['phone_link']);
            return response()->json([
                'status' => Api::HTTP_OK,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => "Thất bại"
            ]);
        }
    }

    public function call_update_lead(Request $request)
    {
        $data = [
            'id' => $request->id,
            'email' => $request->email,
            'identity' => $request->identity,
            'name' => $request->name,
            'birthday' => $request->birthday,
            'city' => $request->city,
            'status' => $request->status,
            'note' => $request->note,
            'call_note' => $request->call_note,
        ];
        $response = Api::post('lead/call_update_investor', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Cập nhật thất bại'
            ]);
        }
    }

    public function history_call_lead(Request $request)
    {
        $response = Api::post('lead/history_call_lead', ['id' => $request->id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $response['data']['lich_su'] = [];
            if (isset($response['data']['log'])) {
                foreach ($response['data']['log'] as $value) {
                    $new = json_decode($value['new']);
                    $new->created_at = date('d/m/Y H:i:s', $value['created_at']);
                    $new->created_by = $value['created_by'];
                    array_push($response['data']['lich_su'], $new);
                }
            }
            foreach ($response['data']['lich_su'] as $v) {
                if (isset($v->status)) {
                    $v->status = lead_status($v->status);
                } else {
                    $v->status = 'Mới';
                }
                if (isset($v->note)) {
                    $v->note = note_delete($v->note);
                } else {
                    $v->note = '';
                }
                if (!isset($v->call_note)) {
                    $v->call_note = '';
                }
            }
            return response()->json([
                'status' => Api::HTTP_OK,
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => 'Thất bại'
            ]);
        }
    }

    public function history_call_investor(Request $request)
    {
        $response = Api::post('investor/history_call', ['id' => $request->id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $response['data']['lich_su'] = [];
            if (isset($response['data']['log'])) {
                foreach ($response['data']['log'] as $value) {
                    $new = json_decode($value['new']);
                    $new->created_at = date('d/m/Y H:i:s', $value['created_at']);
                    $new->created_by = $value['created_by'];
                    array_push($response['data']['lich_su'], $new);
                }
            }
            foreach ($response['data']['lich_su'] as $v) {
                if (isset($v->status)) {
                    $v->status = lead_status($v->status);
                } else {
                    $v->status = 'Mới';
                }
                if (isset($v->note)) {
                    $v->note = note_delete($v->note);
                } else {
                    $v->note = '';
                }
                if (!isset($v->call_note)) {
                    $v->call_note = '';
                }
            }
            return response()->json([
                'status' => Api::HTTP_OK,
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => 'Thất bại'
            ]);
        }
    }

    public function excel_call_lead(Request $request)
    {
        $filter = [];
        if (!empty($request->has('fdate_lead')) && $request->get('fdate_lead') != '') {
            $filter['fdate'] = $request->get('fdate_lead');
        }

        if (!empty($request->has('tdate_lead')) && $request->get('tdate_lead') != '') {
            $filter['tdate'] = $request->get('tdate_lead');
        }
        if (strtotime($request->get('fdate_lead')) > strtotime($request->get('tdate_lead'))) {
            return redirect()->route('thong_ke_call')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        $response = Api::post('lead/excel_call_lead_v2', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $roles = !empty($response['role']) ? $response['role'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Số điện thoại');
            $this->sheet->setCellValue('C1', 'Tài khoản liên kết');
            $this->sheet->setCellValue('D1', 'Tình trạng Call');
            $this->sheet->setCellValue('E1', 'Lý do hủy');
            $this->sheet->setCellValue('F1', 'Ghi chú');
            $this->sheet->setCellValue('G1', 'Ngày tạo');
            if (in_array('telesales', $roles)) {
                $this->sheet->setCellValue('H1', 'Nhân viên');
            }
            $this->sheet->setCellValue("I1", 'Nguồn lead');

            $this->sheet->setStyle("A1");
            $this->sheet->setStyle("B1");
            $this->sheet->setStyle("C1");
            $this->sheet->setStyle("D1");
            $this->sheet->setStyle("E1");
            $this->sheet->setStyle("F1");
            $this->sheet->setStyle("G1");
            if (in_array('telesales', $roles)) {
                $this->sheet->setStyle("H1");
            }
            $this->sheet->setStyle("I1");
            $i = 2;
            foreach ($data as $item) {
                $this->sheet->setCellValue('A' . $i, !empty($item['name']) ? $item['name'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['phone']) ? $item['phone'] : '');
                $this->sheet->setCellValue('C' . $i, !empty($item['phone_link']) ? $item['phone_link'] : "");
                $this->sheet->setCellValue('D' . $i, !empty($item['call_status']) ? lead_status($item['call_status']) : "");
                $this->sheet->setCellValue('E' . $i, !empty($item['note_cancel']) ? note_delete($item['note_cancel']) : "");
                $this->sheet->setCellValue('F' . $i, !empty($item['call_note']) ? ($item['call_note']) : "");
                $this->sheet->setCellValue('G' . $i, !empty($item['created_at']) ? date('d/m/Y H:i:s', strtotime($item['created_at'])) : '');
                if (in_array('telesales', $roles)) {
                    $this->sheet->setCellValue('H' . $i, !empty($item['user_call']) ? $item['user_call'] : '');
                }
                $this->sheet->setCellValue('I' . $i, !empty($item['source']) ? source_lead($item['source']) : "VFC");
                $i++;
            }
            $this->sheet->callLibExcel('data-investor-' . time() . '.xlsx');
        } else {
            redirect()->route('thong_ke_call')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function change_call(Request $request)
    {
        $data = [
            'id_lead' => $request->id_lead,
            'user_call_id' => $request->user_call_id
        ];
        if ($request->type == 'investor') {
            $res = Api::post('investor/change_call', $data);
        } else {
            $res = Api::post('lead/change_call', $data);
        }
        if ($res['status'] && $res['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($res['message']) ? $res['message'] : "Thất bại"
            ]);
        }
    }

    public function report_productivity_investor(Request $request)
    {
        // Filter
        $filter = [];
        if ($request->has('start_date') && $request->get('start_date') != '') {
            $filter['start_date'] = $request->get('start_date');
        }
        if ($request->has('end_date') && $request->get('end_date') != '') {
            $filter['end_date'] = $request->get('end_date');
        }

        if ($request->has('find_call_assign') && $request->get('find_call_assign') != '') {
            $filter['find_call_assign'] = $request->get('find_call_assign');
        }
        // List
        $response = Api::post(ApiUrl::INVESTOR_REPORT_TLS, $filter);

        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            if (!empty($res_data)) {
                foreach ($res_data as $key => $res) {
                    $res_data[$key]['total_lead_divide'] = $res['lead_new_in_day'] + $res['backlog_old_not_yet'];
                    $res_data[$key]['lead_processed_old_realtime'] = !isset($res['lead_backlog_saved']) ? 0 : (($res['lead_backlog_saved'] - $res['backlog_old_not_yet']) < 0) ? 0 : ($res['lead_backlog_saved'] - $res['backlog_old_not_yet']);
                    $res_data[$key]['total_lead_processed'] = $res['lead_processed_in_day'] + $res_data[$key]['lead_processed_old_realtime'];
                    $res_data[$key]['lead_new_activated_realtime'] = $res['lead_new_activated_in_day'];
                    $res_data[$key]['percent_processed'] = ($res_data[$key]['total_lead_divide'] == 0 || $res_data[$key]['total_lead_processed'] == 0) ? 0 : round((($res_data[$key]['total_lead_processed'] / $res_data[$key]['total_lead_divide']) * 100), 2);
                    if (empty($res['email_tls']) || empty($res['id_tls'])) {
                        unset($res_data[$key]);
                    }
                }
            }
            $data = isset($res_data) ? collect($res_data) : [];
        }
        $telesales = Api::post('role/get_user_role_telesales', ['slug' => 'telesales']);
        $user_tls = $telesales['data'];
        return view('investor.report_productivity_investor', compact('data', 'user_tls'));
    }

    public function total_excel_call(Request $request)
    {
        $data = [
            'fdate' => $request->fdate,
            'tdate' => $request->tdate,
        ];
        $response = Api::post('investor/total_excel_call', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công',
                'data' => $response['data'] ?? 0
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Cập nhật thất bại',
                'data' => $response['data'] ?? 0
            ]);
        }
    }

    public function total_excel_call_lead(Request $request)
    {
        $data = [
            'fdate' => $request->fdate,
            'tdate' => $request->tdate,
        ];
        $response = Api::post('lead/total_excel_call_lead', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công',
                'data' => $response['data'] ?? 0
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Cập nhật thất bại',
                'data' => $response['data'] ?? 0
            ]);
        }
    }

    public function re_care(Request $request)
    {
        $filter = [];
        $filter['tab'] = $request->tab ?? 'not-investment';
        $filter['name'] = $request->get('name') ?? '';
        $filter['phone'] = $request->get('phone') ?? "";
        $filter['email'] = $request->get('email') ?? "";
        $filter['status_call'] = $request->get('status_call') ?? "";
        $filter['note_delete'] = $request->get('note_delete') ?? "";
        $filter['investment_status'] = $request->get('investment_status') ?? "";
        $filter['find_call_assign'] = $request->get('find_call_assign') ?? "";
        $filter['time_care'] = $request->get('time_care') ?? "";
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post('investor/list_v2' . '?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        $count = 0;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
            $count = $res_data['total'] ?? 0;
        }
        $telesales = Api::post('role/get_user_role_telesales', ['slug' => 'telesales']);
        $user_tls = $telesales['data'];
        return view('investor.re-care', compact('data', 'paginate', 'user_tls', 'count'));
    }
}
