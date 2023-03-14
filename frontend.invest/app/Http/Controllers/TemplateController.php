<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function invest()
    {
        return view('template.test');
    }
    public function list_id_invest()
    {
        return view('template.list_id_invest');
    }
    public function ndt_app()
    {
        return view('template.ndt_app');
    }
    public function ndt_uyquyen()
    {
        return view('template.ndt_uyquyen');
    }
    public function details_uyquyen()
    {
        return view('template.details_uyquyen');
    }
    public function details_ndt()
    {
        return view('template.details_ndt');
    }
}
