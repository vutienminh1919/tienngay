<?php

namespace Modules\CtvTienNgay\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\MongodbCore\Repositories\BannerRepository;

class BannerController extends Controller
{
    private $banner_model;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->banner_model = $bannerRepository;
    }

    public function get_all(Request $request)
    {
        $banner = $this->banner_model->get_banner_ctv_tienngay();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $banner
        ]);
    }

    public function get_banner_admin(Request $request)
    {
        $banner = $this->banner_model->get_banner_admin_ctv_tienngay();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $banner
        ]);
    }
}
