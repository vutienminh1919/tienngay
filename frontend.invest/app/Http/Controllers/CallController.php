<?php

namespace App\Http\Controllers;

use App\Service\Api;
use App\Service\ApiUrl;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function index()
    {
        $telesales = Api::post('role/get_user_role_telesales', ['slug' => 'telesales']);
        $user_tls = $telesales['data'];
        return view('config.index', compact('user_tls'));
    }

    public function config_call(Request $request)
    {
        if (!isset($request->telesales)) {
            return redirect()->route('config.call')->with('error', 'Ds nhân viên không để trống');
        }

        $telesales = implode(',', $request->telesales);
        $data = [
            'telesales' => $telesales,
            'start_time' => date('Y-m-d H:i:s'),
            'end_time' => date('Y-m-d') . ' 17:00:00',
        ];
        $response = Api::post('call/config_call', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return redirect()->route('config.call')->with('success', 'Cập nhật thành công');
        } else {
            return redirect()->route('config.call')->with('error', 'Cập nhật không để trống');
        }
    }
}
