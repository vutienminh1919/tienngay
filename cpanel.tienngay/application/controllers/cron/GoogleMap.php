<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GoogleMap extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("time_model");
		$this->load->model("store_model");
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$this->api = new Api();
	}

	private $api, $createdAt;

	public function updateLocationStore() {
		$stores = $this->store_model->find_where(array('status' => 'active'));
		$api_key = 'AIzaSyCZ9685cEtnIxy6MNQja__Mp-Nm_TfUrqY';
		foreach ($stores as $store) {
			$id = $store->_id;
			$address = preg_replace('/\s+/', '+', $store->address);
			$service = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$api_key;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$service);
//			curl_setopt($ch, CURLOPT_POST,1);
//			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//			curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			// var_dump($result);
			curl_close ($ch);
			$result1 = json_decode($result);
			$set = [
				'location' => $result1->results[0]->geometry->location
			];
			$this->store_model->update(array('_id' => $id), $set);
		}
		$response = [
			'status' => 200,
			'message' => 'Update location store success'
		];
		echo json_encode($response);
		return;
	}

}
