<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Http\Request;

class ActionController extends Controller
{

    public function list()
    {
        // List
        $response = Api::post('action/all');
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = $response['data'];
        }
        // Menu
        $menu = [];
        $response = Api::post('menu/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $menu = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('action.list', compact('data', 'menu'));
    }

    public function create()
    {
        // Menu
        $menu = [];
        $response = Api::post('menu/all');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $menu = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('action.create', compact('menu'));
    }

    public function create_post(Request $request)
    {
        // Menu Create
        $response = Api::post('action/create', [
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'menu_id' => $request->get('menu'),
        ]);
        $error = [];
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                return redirect()->route('action_list')->with('success', 'Tạo action thành công');
            } else {
                $error = $response['message'];
            }
        }
    }

    public function update($id)
    {
        $response = Api::post('action/detail', ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];
            // Menu
            $menu = [];
            $response = Api::post('menu/all');
            if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
                $menu = isset($response['data']) ? collect($response['data']) : [];
            }
            return view('action.update', compact('menu', 'data', 'id'));
        }
        return abort(404);
    }

    public function update_post($id, Request $request)
    {
        $response = Api::post('action/update', [
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'menu_id' => $request->get('menu'),
            'id' => $id
        ]);
        $error = [];
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                return redirect()->route('action_list')->with('success', 'update action thành công');
            } else {
                $error = $response['message'];
            }
        }
    }

}
