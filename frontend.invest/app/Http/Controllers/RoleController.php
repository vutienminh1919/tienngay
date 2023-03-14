<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\Api;

class RoleController extends Controller
{

    public function list(Request $request)
    {
        // Filter
        $filter = [];
        if ($request->has('name') && $request->get('name') != '') {
            $filter['name'] = $request->get('name');
        }
        // Page
        $page = 1;
        if ($request->has('page') && $request->get('page') != '') {
            $page = $request->get('page');
        }
        // List
        $response = Api::post('role/list?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('role.list', compact('data', 'paginate'));
    }

    public function create(Request $request)
    {
        // User
        $user = [];
        $response = Api::post('user/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $user = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('role.create', compact('user'));
    }

    public function create_post(Request $request)
    {
        // User
        $user = [];
        $response = Api::post('user/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $user = isset($response['data']) ? collect($response['data']) : [];
        }
        // Role Create
        $response = Api::post('role/create', [
            'name' => $request->get('name')
        ]);
        $error = [];
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                $rold_id = data_get($response, 'data.id', null);
                if ($rold_id) {
                    // Add Rold
                    $response = Api::post('role/add-user', [
                        'user_list' => implode(',', $request->get('user', [])),
                        'id' => $rold_id
                    ]);
                    return redirect()->route('role_list')->with('success', 'Tạo nhóm quyền thành công');
                }
            } else {
                $error = $response['message'];
            }
        }
        return view('role.create', compact('user', 'error'));
    }

    public function toggle_active(Request $request)
    {
        $id = $request->get('id');
        $response = Api::post('role/toggle-active', [
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
        // Detail
        $response = Api::post('role/detail', ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];
            // User
            $user = [];
            $response = Api::post('user/all');
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $user = isset($response['data']) ? collect($response['data']) : [];
            }
            // Return
            return view('role.update', compact('user', 'data', 'id'));
        }
        return abort(404);
    }

    public function update_post($id, Request $request)
    {
        // Role Update
        $response = Api::post('role/update', [
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'id' => $id
        ]);
        $error = [];
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                $rold_id = data_get($response, 'data.id', null);
                if ($rold_id) {
                    // Add Rold
                    $res = Api::post('role/add-user', [
                        'user_list' => $request->get('user_list'),
                        'id' => $rold_id
                    ]);
                    if (isset($res['status']) && $res['status'] == 200) {
                        return redirect()->route('role_update', ['id' => $id])->with('success', 'Cập nhật nhóm quyền ' . $request->get('name') . ' thành công');
                    } else {
                        return redirect()->route('role_update', ['id' => $id])->with('error', isset($res['message']) ? $res['message'] : 'Cập nhật thất bại');
                    }
                }
            } else {
                return redirect()->route('role_update', ['id' => $id])->with('error', isset($response['message']) ? $response['message'] : 'Cập nhật thất bại');
            }
        }
        // Render View
        $response = Api::post('role/detail', ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];
            // User
            $user = [];
            $response = Api::post('user/all');
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $user = isset($response['data']) ? collect($response['data']) : [];
            }
            return view('role.update', compact('user', 'error', 'data', 'id'));
        }
        return abort(404);
    }

}
