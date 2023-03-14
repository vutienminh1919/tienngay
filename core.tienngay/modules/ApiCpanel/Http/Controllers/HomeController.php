<?php

namespace Modules\ApiCpanel\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API V2 Tienngay"
     * )
     */
    public function index()
    {
        return response()->json(config()->all());
    }
}
