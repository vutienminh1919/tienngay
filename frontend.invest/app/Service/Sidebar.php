<?php

namespace App\Service;

class Sidebar {

    public function loadMenu()
    {
        $response = Api::post(ApiUrl::MENU_SIDEBAR);
        if ( isset($response['status']) && $response['status'] == Api::HTTP_OK ) {
            return $response['data'];
        }
        return null;
    }

    public function urlMenu($url)
    {
        if ( str_starts_with($url, '/') ) {
            return request()->root(). $url;
        }
        return request()->root(). '/' . $url;
    }

    public function activeMenu($url)
    {
        if ( !str_starts_with($url, '/') ) {
            $url = '/'.$url;
        }
        if (request()->getRequestUri() == $url) {
            return 'active';
        }
        return '';
    }

    public function activeMenuParent($parentId, $menu)
    {
        foreach ($menu as $item) {
            if ($item['parent'] == $parentId) {
                if ( !str_starts_with($item['url'], '/') ) {
                    $url = '/'.$item['url'];
                }
                if (request()->getRequestUri() == $url) {
                    return 'show';
                }
            }
        }
        return '';
    }

}
