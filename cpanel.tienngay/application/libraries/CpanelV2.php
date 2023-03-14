<?php

class CpanelV2 {

    public static function getDomain() {
        $ci =& get_instance();
        $ci->config->load('config');
        $baseURL = $ci->config->item("cpanel_v2_url");
        return $baseURL;
    }
}
