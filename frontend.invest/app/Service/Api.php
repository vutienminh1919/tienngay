<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class Api
{
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_OK = 200;
    const HTTP_ERROR = 400;

    public static function post($url, $data = [])
    {
        $user = session()->get('user');
        if ($user && isset($user['token_web'])) {
            $response = Http::withHeaders([
                'Authorization' => $user['token_web']
            ])->post(env('API_URL') . $url, $data);
        } else {
            $response = Http::post(env('API_URL') . $url, $data);
        }
        if ($response->ok()) {
            $data = json_decode($response->body(), true);
            if (isset($data['status'])) {
                if ($data['status'] == self::HTTP_UNAUTHORIZED) {
                    session()->forget('user');
                    header('Location: ' . route('auth_login'));
                    exit();
                } elseif ($data['status'] == 403) {
                    session()->forget('user');
                    header('Location: ' . route('auth_login'));
                    exit();
                } else {
                    return $data;
                }
            }
        }
        return null;
    }

    public static function get($url, $data = [])
    {
        $user = session()->get('user');
        if ($user && isset($user['token_web'])) {
            $response = Http::withHeaders([
                'Authorization' => $user['token_web']
            ])->get(env('API_URL') . $url, $data);
        } else {
            $response = Http::get(env('API_URL') . $url, $data);
        }
        if ($response->ok()) {
            $data = json_decode($response->body(), true);
            if (isset($data['status'])) {
                if ($data['status'] == self::HTTP_UNAUTHORIZED) {
                    session()->forget('user');
                    header('Location: ' . route('auth_login'));
                    exit();
                } elseif ($data['status'] == 403) {
                    session()->forget('user');
                    header('Location: ' . route('auth_login'));
                    exit();
                } else {
                    return $data;
                }
            }
        }
        return null;
    }

    public static function post1($url, $data = [])
    {
        $user = session()->get('user');
        if ($user && isset($user['token_web'])) {
            $response = Http::withHeaders([
                'Authorization' => $user['token_web']
            ])->post(env('API_URL') . $url, $data);
        } else {
            $response = Http::post(env('API_URL') . $url, $data);
        }
        if ($response->ok()) {
            dd($response->body());
            $data = json_decode($response->body(), true);
            if (isset($data['status'])) {
                if ($data['status'] == self::HTTP_UNAUTHORIZED) {
                    session()->forget('user');
                    header('Location: ' . route('auth_login'));
                    exit();
                } elseif ($data['status'] == 403) {
                    session()->forget('user');
                    header('Location: ' . route('auth_login'));
                    exit();
                } else {
                    return $data;
                }
            }
        }
        return null;
    }

}
