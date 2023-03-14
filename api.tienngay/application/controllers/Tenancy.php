<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Tenancy extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('bank_nganluong_model');
        $this->load->model('district_model');
        $this->load->model('log_model');
        $this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        $headers = $this->input->request_headers();
        $dataPost = $this->input->post();
        $this->flag_login = 1;
        if (!empty($headers['Authorization']) || !empty($headers['authorization'])) {
            $headers_item = !empty($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];
            $token = Authorization::validateToken($headers_item);
            if ($token != false) {
                // Kiểm tra tài khoản và token có khớp nhau và có trong db hay không
                $this->app_login = array(
                    '_id'=>new \MongoDB\BSON\ObjectId($token->id),
                    'email'=>$token->email,
                    "status" => "active",
                    // "is_superadmin" => 1
                );
                //Web
                if($dataPost['type'] == 1) $this->app_login['token_web'] = $headers_item;
                if($dataPost['type'] == 2) $this->app_login['token_app'] = $headers_item;
                $count_account = $this->user_model->count($this->app_login);
                $this->flag_login = 'success';
                if ($count_account != 1) $this->flag_login = 2;
                if ($count_account == 1){
                    $this->info = $this->user_model->findOne($this->app_login);
                    $this->id = $this->info['_id'];
                    // $this->ulang = $this->info['lang'];
                    $this->uemail = $this->info['email'];
                }
            }
        }
    }

	public function getAll_post()
	{
		$result = $this->bank_nganluong_model->find();

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'succes' ,
			'data' => $result,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_all_district_post()
	{
		$result = $this->district_model->find();
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'succes',
			'data' => $result,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

}
?>
