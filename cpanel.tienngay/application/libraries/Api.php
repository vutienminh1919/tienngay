<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Api {
    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->config('config');
    }

    public $CI;

    public function apiGet($token, $url) {
        $urlGet = $this->CI->config->item('api_pawn').$url;
        $opts = array('http' =>
            array(
                'method' => 'GET',
                'header' => "Authorization:" . $token
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($urlGet, false, $context);

        $decodeResponse = json_decode($result);
        return $decodeResponse;
    }
    public function apiPost($token, $url, $data=array()) {
        $urlPost = $this->CI->config->item('api_pawn').$url;
        $request_headers = array(
            "Content-type:" . 'application/x-www-form-urlencoded',
            "Authorization: " . $token
        );
        $data['type'] = 1;
        $postdata = http_build_query($data);
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => $request_headers,
                'content' => $postdata,
                'timeout' => 1200,
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($urlPost, false, $context);
        $decodeResponse = json_decode($result);
        return $decodeResponse;
    }

    public function apiPost1($token, $url, $data=array()) {

        $urlPost = $this->CI->config->item('api_pawn').$url;
        $request_headers = array(
            "Content-type:" . 'application/x-www-form-urlencoded',
            "Authorization: " . $token
        );
        $data['type'] = 1;
        $postdata = http_build_query($data);
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => $request_headers,
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($urlPost, false, $context);
//        $decodeResponse = json_decode($result);
//		var_dump($decodeResponse); die;
//        var_dump($token);die;
//        return $decodeResponse;
		  var_dump($result);die;
        $decodeResponse = json_decode($token);
        var_dump($token);die;
        return $decodeResponse;

    }



    public function apiPostNoHeader($url, $data=array()) {
        $urlPost = $this->CI->config->item('api_pawn').$url;
        $request_headers = array(
            "Content-type:" . 'application/x-www-form-urlencoded'
        );
        $postdata = http_build_query($data);
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => $request_headers,
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($urlPost, false, $context);
        $decodeResponse = json_decode($result);
        return $decodeResponse;
    }

	public function api_core_Post($token, $url, $data=array()) {
		$urlPost = $this->CI->config->item('URL_API_CORE').$url;
		$request_headers = array(
			"Content-type:" . 'application/x-www-form-urlencoded',
			"Authorization: " . $token
		);
		$data['type'] = 1;
		$postdata = http_build_query($data);
		$opts = array('http' =>
			array(
				'method' => 'POST',
				'header' => $request_headers,
				'content' => $postdata,
				'timeout' => 1200,
			)
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($urlPost, false, $context);
		$decodeResponse = json_decode($result);
		return $decodeResponse;
	}
}
