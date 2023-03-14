<?php
defined('BASEPATH') or exit('No direct script access allowed');


class CVS
{
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->load('config');
		$this->CVS_USERNAME = $this->CI->config->item('CVS_USERNAME');
		$this->CVS_PASSWORD = $this->CI->config->item('CVS_PASSWORD');
		$this->CVS_API_URL = $this->CI->config->item('CVS_API_URL');
	}

	/** Generate authentication from username and password with base64
	 * @return string
	 */
	public function generateAuthentication()
	{
		$user_name = $this->CVS_USERNAME;
		$password = $this->CVS_PASSWORD;
		$authenString = $user_name . ':' . $password;
		$authentication = base64_encode($authenString);
		return $authentication;
	}


	public function callApi($image_detect_url)
	{
		$authentication = $this->generateAuthentication();
		$cvs_url = $this->CVS_API_URL . $image_detect_url['type_url'];
		$headers = array(
			'Authorization: Basic ' . $authentication
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $cvs_url. '?img1=' . $image_detect_url['front_img']
									. '&img2=' . $image_detect_url['back_img']
									. '&format_type=url&get_thumb=' . $image_detect_url['get_thumb'], //get_thumb = true: trả về string base_64 của ảnh
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 60,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => $headers,
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}
}
