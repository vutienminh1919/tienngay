<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Template extends Controller
{
   
    public function bien_ban()
    {
        return view('page.bien_ban');
    }
 
}