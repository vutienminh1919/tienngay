<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Response;
use Modules\ViewCpanel\Service\ApiCall;
use Modules\MongodbCore\Repositories\BlackListRepository;
use Modules\MongodbCore\Repositories\HcnsRepository;
use Illuminate\Http\Request;


class BlackListController extends BaseController
{
    function __construct(BlackListRepository $blackListRepository, HcnsRepository $hcnsRepository) {
        $this->blackListRepository = $blackListRepository;
        $this->hcnsRepository = $hcnsRepository;

    }
        //get all record in blacklist total
    public function getPropertyBlacklist()
    {
        $records = $this->blackListRepository->getAllBlackList();
        $exemtion = $this->blackListRepository->getAllExemtion();
        return view('viewcpanel::blacklist.list', [
            'results' => $records,
            'exemtion' => $exemtion,
            'filterUrl' => route('viewcpanel::blacklist.search'),
            'export' => true,
            'cpanelURL' => env('CPANEL_TN_PATH') . '/ToolBlackList/index?target_url=',
            'cpanelExemtion' =>  env('CPANEL_TN_PATH')
        ]);
    }

    public function searchBlacklist(Request $request)
    {
        $dataPost = $request->all();
        unset($dataPost['_token']);
        $arrSearch = [];
        foreach ($dataPost as $key => $value) {
            if ($value) {
                $arrSearch[$key] = $value;
            }
        }
        if (empty($arrSearch)) {
            $blacklist_search = $this->blackListRepository->getAllBlackList();
        }
        $blacklist_search = $this->blackListRepository->search($arrSearch);
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('ViewCpanel::message.success'),
            'data' => $blacklist_search
        ];
        return response()->json($response);
    }

    //detail property in blacklist
    public function detailProperty($id)
    {
        $property = ApiCall::getDetailProperty($id);
        $data = [];
        $data['property'] = $property['data'];
        if($data['property']['code'] == config('blacklist.LOAI_TAI_SAN.XE_MAY')){
            $data['type'] = "Xe Máy";
        }else{
            $data['type'] = "Ô TÔ";
        }
        $img_tai_san = $property['data']['image_property'];
        $img_dang_ky = $property['data']['image_registration'];
        $img_dang_kiem = $property['data']['image_certificate'];
        if (!empty($img_tai_san)) {
            $arr_img_tai_san = [];
            foreach ($img_tai_san as $value) {
                array_push($arr_img_tai_san, $value['path']);
            }
        }
        if (!empty($img_dang_ky)) {
            $arr_img_dang_ky = [];
            foreach ($img_dang_ky as $value) {
                array_push($arr_img_dang_ky, $value['path']);
            }
        }
        if (!empty( $img_dang_kiem)) {
            $arr_img_dang_kiem = [];
            foreach ( $img_dang_kiem as $value) {
                array_push($arr_img_dang_kiem, $value['path']);
            }
        }
        $data['img_tai_san']['path'] = !empty($arr_img_tai_san) ? $arr_img_tai_san : "";
        $data['img_dang_ky']['path'] = $arr_img_dang_ky;
        $data['img_dang_kiem']['path'] = !empty($arr_img_dang_kiem) ? $arr_img_dang_kiem : "";
        $data['cpanelURL'] = env('CPANEL_TN_PATH') . '/ToolBlackList/index';
        return view('viewcpanel::blacklist.detailProperty', $data);
    }
        //detail hcns in blacklist
    public function detailHcns($id)
    {
        $hcns = $this->hcnsRepository->findRecord($id);
        $data['detail'] = $hcns;
        return view('viewcpanel::blacklist.detailHcns', $data);
    }
        //detail exemption in blacklist
    public function detailExemtion($id)
    {
        $exemtion = ApiCall::getDetailExemtion($id);
        $img = $exemtion['data']['image_exemption_profile'];
        if (!empty($img)) {
            $arr_img = [];
            foreach ($img as $value) {
                array_push($arr_img, $value['path']);
            }
        }
        $data = [];
        $data['exemtion'] = $exemtion['data'];
        $data['img']['path'] = $arr_img;
        $data['cpanelURL'] = env('CPANEL_TN_PATH');
        return view('viewcpanel::blacklist.detailExemtion', $data);
    }

}
