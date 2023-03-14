<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class NotificationController extends Controller
{
    public function list(Request $request)
    {
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;

        // List
        $response = Api::post('notification/get_paginate_notification_user?page=' . $page, ['id' => Session::get('user')['id']]);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('notification.list', compact('data', 'paginate'));
    }

    public function update_read(Request $request)
    {
        $response = Api::post('notification/update_read', ['id' => $request->id]);
        return response()->json([
            'status' => 200,
            'message' => 'Thanh cong']);
    }

    public function read_all(Request $request)
    {
        $response = Api::post('notification/read_all', ['id' => Session::get('user')['id']]);
        return response()->json([
            'status' => 200,
            'message' => 'Thanh cong']);
    }
}
