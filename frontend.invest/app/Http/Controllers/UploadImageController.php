<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    public function upload_img(Request $request)
    {
        $serviceUpload = env('URL_SERVICE_UPLOAD');
        $files = $request->image;
        $tmp_name = $files->getPathName();
        $type = $files->getClientOriginalExtension();
        $name = $files->getClientOriginalName();
        $cfile = new \CURLFile($tmp_name, $type, $name);
        $post = ['avatar' => $cfile];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $serviceUpload);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        $result1 = json_decode($result);
        return response()->json([
            'status' => Api::HTTP_OK,
            'message' => 'Cập nhật thành công',
            'data' => $result1
        ]);
    }
}
