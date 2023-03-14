<?php

namespace Modules\CtvTienNgay\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\MongodbCore\Entities\JavaReport;

class HomeController extends Controller
{

    public function index()
    {
        return response()->json();
    }
}
