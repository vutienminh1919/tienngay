<?php

namespace App\Http\Controllers;

use App\Service\ApiCpanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Http;
use App\Service\Api;
use Illuminate\Support\Arr;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function login_post(Request $request)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha(env('CAPTCHA_SECRET'));
        $resp = $recaptcha->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
        $error = null;
//		if ($resp->isSuccess()) {
        $response = Http::post(env('API_URL') . 'auth/signin', [
            'email' => $request->get('username'),
            'password' => $request->get('password')
        ]);
        if ($response->ok()) {
            $data = json_decode($response->body(), true);
            if (isset($data['status']) && $data['status'] == 200) {
                $phone_net = ApiCpanel::post('user_phonenet/get_user_phonenet_by_email', ['email_user' => $data['data']['email']]);
                if ($request->get('remember') == 'on') {
                    Session::put('user', $data['data'], 3360);
                } else {
                    Session::put('user', $data['data']);
                }
                if (isset($phone_net->status) && $phone_net->status == 200) {
                    Session::put('phonenet', $phone_net->data);
                }
                return redirect()->route('dashboard.index');
            } else {
                $error = 'Thông tin đăng nhập chưa chính xác';
            }
        } else {
            $error = 'Thông tin đăng nhập chưa chính xác';
        }
//		} else {
//			$error = 'Tích chọn tôi không phải là người máy';
//		}
        return view('auth.login', compact('error'));
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('auth_login');
    }

    public function profile()
    {
        $response = Api::post('profile');
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('auth.profile', compact('data'));
    }

    public function changePass(Request $request)
    {
        $response = Api::post('change-pass', [
            'password_old' => $request->get('password_old'),
            'password_new' => $request->get('password_new'),
            'password_re' => $request->get('password_re'),
        ]);
        if (isset($response['status'])) {
            if ($response['status'] == Api::HTTP_OK) {
                return response()->json([
                    'status' => Api::HTTP_OK,
                    'message' => "Success"
                ]);
            } else {
                return response()->json([
                    'status' => Api::HTTP_ERROR,
                    'message' => Arr::flatten($response['message'])
                ]);
            }
        }
        return response()->json([
            'status' => Api::HTTP_ERROR,
            'message' => 'Error'
        ]);
    }

}
