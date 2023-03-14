<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\Api;

class UserController extends Controller
{

    public function list(Request $request)
    {
        // Filter
        $filter = [];
        if ($request->has('email') && $request->get('email') != '') {
            $filter['email'] = $request->get('email');
        }
        if ($request->has('phone') && $request->get('phone') != '') {
            $filter['phone'] = $request->get('phone');
        }
        if ($request->has('role') && is_array($request->get('role'))) {
            $filter['role'] = implode(',', $request->get('role', []));
        }
        if ($request->has('per_page') && is_array($request->get('per_page'))) {
            $filter['per_page'] = implode(',', $request->get('per_page', []));
        }
        // Page
        $page = 1;
        if ($request->has('page') && $request->get('page') != '') {
            $page = $request->get('page');
        }
        // List
        $response = Api::post('user/list?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        // Get Role
        $response = Api::post('role/all');
        $role = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $role = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('user.list', compact('data', 'paginate', 'role'));
    }

    public function create()
    {
        $response = Api::post('role/all');
        // Menu
        $menu = [];
        $response = Api::post('menu/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $menu = isset($response['data']) ? collect($response['data']) : [];
        }
        // Action
        $action = [];
        $response = Api::post('action/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $action = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('user.create', compact('menu', 'action'));
    }

    public function create_post(Request $request)
    {
        // Get Role
        $response = Api::post('role/all');
        $role = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $role = isset($response['data']) ? collect($response['data']) : [];
        }
        // User Create
        $response = Api::post('user/create', [
            'email' => $request->get('email'),
            'full_name' => $request->get('full_name'),
            'phone' => $request->get('phone'),
            'password' => $request->get('password'),
        ]);
        $error = [];
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                $user_id = data_get($response, 'data.id', null);
                if ($user_id) {
                    // Add Menu
                    Api::post('user/add-menu', [
                        'menu_list' => $request->get('menu_list'),
                        'id' => $user_id
                    ]);
                }
                return redirect()->route('user_list')->with('success', 'Tạo tài khoản thành công');
            } else {
                $error = $response['message'];
            }
        }
        // Menu
        $menu = [];
        $response = Api::post('menu/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $menu = isset($response['data']) ? collect($response['data']) : [];
        }
        // Action
        $action = [];
        $response = Api::post('action/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $action = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('user.create', compact('menu', 'action', 'error'));
    }

    public function toggle_active(Request $request)
    {
        $id = $request->get('id');
        $response = Api::post('user/toggle-active', [
            'id' => $id
        ]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Success'
            ]);
        }
        return response()->json([
            'status' => Api::HTTP_ERROR,
            'message' => 'Error'
        ], Api::HTTP_ERROR);
    }

    public function update($id)
    {
        $response = Api::post('user/detail', [
            'id' => $id
        ]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];
            // Get Role
            $response = Api::post('role/all');
            $role = [];
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $role = isset($response['data']) ? collect($response['data']) : [];
            }
            // Menu
            $menu = [];
            $response = Api::post('menu/all');
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $menu = isset($response['data']) ? collect($response['data']) : [];
            }
            // Action
            $action = [];
            $response = Api::post('action/all');
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $action = isset($response['data']) ? collect($response['data']) : [];
            }
//            dd($data);
            return view('user.update', compact('role', 'data', 'id', 'menu', 'action'));
        }
        return abort(404);
    }

    public function update_post($id, Request $request)
    {
        // User Update
        $response = Api::post('user/update', [
            'status' => $request->get('status'),
            'id' => $id
        ]);
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                $user_id = data_get($response, 'data.id', null);
                if ($user_id) {
                    Api::post('user/add-menu', [
                        'menu_list' => $request->get('menu_list'),
                        'id' => $id
                    ]);
                    return redirect()->route('user_list')->with('success', 'Cập nhật người dùng ' . $request->get('name') . ' thành công');
                }
            } else {
                $error = $response['message'];
            }
        }
        return redirect()->route('user_list');
    }

    public function tao_moi_ndt_uy_quyen(Request $request)
    {
        $data = [
            'email' => $request->email,
            'phone' => $request->phone,
            'full_name' => $request->full_name,
            'cmt' => $request->cmt,
        ];
        $response = Api::post('user/tao_moi_ndt_uy_quyen', $data);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thêm mới thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thêm mới không thành công'
            ]);
        }
    }
}
