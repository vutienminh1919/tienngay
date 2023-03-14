<?php

namespace Modules\CtvTienNgay\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\Collaborator;
use Modules\MongodbCore\Entities\Handbook;
use Modules\MongodbCore\Entities\JavaReport;
use Illuminate\Http\Response;

class NewController extends Controller
{
    function __construct()
    {
        $this->api = "http://127.0.0.1:8080/";
    }

    public function get_all_camnangCTV(){

//        $result = Http::post("http://localhost/tienngay/api.tienngay/handbook/get_all_camnangctv");
//
//        $result = json_decode($result->body());

        $result = Handbook::where('type_new', '=' ,"10")
            ->where('status', '=' ,"active")
            ->orderBy('updated_at','DESC')
            ->get();


        if (!empty($result)){

            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }



    }

    public function detail(Request $request){

        $result = Handbook::where('_id', "$request->id")->first();

        if (!empty($result)){

            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }

    }

    public function views(Request $request){

        $result = Handbook::where('_id', "$request->id")->first();

        if (!empty($result)){

            $views = !empty($result->views) ? $result->views + 1 : 1;

            Handbook::where('_id', "$request->id")->update(["views" => "$views"]);

            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }


    }




}
