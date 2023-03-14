<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\Api;

class MenuController extends Controller
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
        $response = Api::post('menu/list?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('menu.list', compact('data', 'paginate'));
    }

    public function create(Request $request)
    {
        // Role
        $response = Api::post('role/all');
        $role = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $role = isset($response['data']) ? collect($response['data']) : [];
        }
        // Menu Parent
        $response = Api::post('menu/parent/all');
        $parent = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $parent = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('menu.create', compact('role', 'parent'));
    }

    public function create_post(Request $request)
    {
        // Role
        $response = Api::post('role/all');
        $role = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $role = isset($response['data']) ? collect($response['data']) : [];
        }
        // Menu Create
        $response = Api::post('menu/create', [
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'parent' => $request->get('parent'),
        ]);
        $error = [];
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                $menu_id = data_get($response, 'data.id', null);
                if ($menu_id) {
                    // Add Role
                    $response = Api::post('menu/add-role', [
                        'role_list' => implode(',', $request->get('role', [])),
                        'id' => $menu_id
                    ]);
                    return redirect()->route('menu_list')->with('success', 'Tạo menu thành công');
                }
            } else {
                $error = $response['message'];
            }
        }
    }

    public function toggle_active(Request $request)
    {
        $id = $request->get('id');
        $response = Api::post('menu/toggle-active', [
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
        $response = Api::post('menu/detail', ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];

            // Role
            $response = Api::post('role/all');
            $role = [];
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $role = isset($response['data']) ? collect($response['data']) : [];
            }
            // Menu Parent
            $response = Api::post('menu/parent/all');
            $parent = [];
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $parent = isset($response['data']) ? collect($response['data']) : [];
            }

            return view('menu.update', compact('data', 'id', 'role', 'parent'));
        }
        return abort(404);
    }

    public function update_post($id, Request $request)
    {
        // User Update
        $response = Api::post('menu/update', [
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'parent' => $request->get('parent'),
            'id' => $id
        ]);
        $error = [];
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                $menu_id = data_get($response, 'data.id', null);
                if ($menu_id) {
                    // Add Rold
                    Api::post('menu/add-role', [
                        'role_list' => implode(',', $request->get('role', [])),
                        'id' => $menu_id
                    ]);
                    return redirect()->route('menu_list')->with('success', 'Cập nhật Menu ' . $request->get('name') . ' thành công');
                }
            } else {
                $error = $response['message'];
            }
        }
        // Error
        $response = Api::post('menu/detail', ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];
        }
        // Role
        $response = Api::post('role/all');
        $role = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $role = isset($response['data']) ? collect($response['data']) : [];
        }
        // Menu Parent
        $response = Api::post('menu/parent/all');
        $parent = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $parent = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('menu.update', compact('data', 'id', 'role', 'parent', 'error'));
    }

}
