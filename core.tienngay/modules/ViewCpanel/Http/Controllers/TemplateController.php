<?php

namespace Modules\ViewCpanel\Http\Controllers;


use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TemplateController extends BaseController
{
   
    public function bien_ban()
    {
        return view('viewcpanel::page.bien_ban');
    }
    public function bien_ban1()
    {
        return view('viewcpanel::page.bien_ban1');
    }
   
    public function bien_ban2()
    {
        return view('viewcpanel::page.bien_ban2');
    }
   
 
}