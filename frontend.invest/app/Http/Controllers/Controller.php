<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Minify_CSS;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }

    private function generateCss()
    {
        $css_file = File::files('./css');
        $css_content = '';
        foreach ($css_file as $css_item) {
            $css_content .= $css_item->getContents();
        }
        $css_content = Minify_CSS::minify($css_content);
        View::share('minify_css', $css_content);
        // dd($css_content);
    }

    public function userCan($action, $option = null)
    {
        $user = Session::get('user');
        $result = Gate::forUser($user)->allows($action, $option);
        return $result;
    }

}
