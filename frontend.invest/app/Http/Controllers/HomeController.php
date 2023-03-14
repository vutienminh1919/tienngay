<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

	public function login()
	{
		return view('home.login');
	}

	public function info()
	{
		return view('home.info');
	}

}
