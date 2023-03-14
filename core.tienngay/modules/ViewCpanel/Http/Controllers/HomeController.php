<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\MongodbCore\Entities\JavaReport;
use Modules\MysqlCore\Entities\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(JavaReport $javaReport, User $user)
    {
        //dd(config());
//        $data = $user::all();
//        dd($data);
        return view('viewcpanel::index');
    }
}
