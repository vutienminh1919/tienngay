
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Area extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('area_model');
        $this->load->model('store_model');
        $this->load->model('log_model');
         $this->load->model('kpi_pgd_model');
         $this->load->model('role_model');
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
      public function getAreaByDomain_post(){
        // $flag = notify_token($this->flag_login);
        // if ($flag == false) return;
        $data = $this->input->post();
        $code_domain = !empty($data['code_domain']) ? $data['code_domain'] : "";
        //var_dump($code_domain);
        $area = $this->area_model->find_where(array("domain.code" => $code_domain));
        if (!empty($area)) {
            foreach ($area as $sto) {
                $sto['name'] = (string)$sto['title'];
            }
        }
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $area
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
        return;
    }
     public function getStoreByArea_post(){
        // $flag = notify_token($this->flag_login);
        // if ($flag == false) return;
        $data = $this->input->post();
        $code_area = !empty($data['code_area']) ? $data['code_area'] : "";
        $store = $this->store_model->find_where(array("code_province_store" => $code_area));
           
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $store
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
        return;
    }
    public function get_store_by_area_post(){
        // $flag = notify_token($this->flag_login);
        // if ($flag == false) return;
        $data = $this->input->post();
        $code_area = !empty($data['code_area']) ? $data['code_area'] : "";
        $store = $this->store_model->find_where(array("code_area" => $code_area));
           
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $store
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
        return;
    }
     public function get_char_kpi_post(){
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
         $data = $this->input->post();
         $start_date = !empty($data['start_date']) ? $data['start_date'] : "";
        $end_date = !empty($data['end_date']) ? $data['end_date'] : "";
        $domain_vung = !empty($data['domain_vung']) ? $data['domain_vung'] : "";
        $area_vung = !empty($data['area_vung']) ? $data['area_vung'] : "";
        $store_vung = !empty($data['store_vung']) ? $data['store_vung'] : "";
        $data_condition=array(
        'date'=>array(    '$gte' => strtotime(trim($start_date).' 00:00:00'),
            '$lte' => strtotime(trim($end_date).' 23:59:59') ),
        'domain'=>$domain_vung,
        'area'=>$area_vung,
        'store'=>$store_vung
        );
        $kpiData = $this->kpi_pgd_model->find_where($data_condition);
        if (!empty($kpiData)) {
            foreach ($kpiData as $s) {
                $s['id'] = (string)$s['_id'];
            }
        }
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $kpiData
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function find_where_not_in_post() {
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
        $data = $this->input->post();
        unset($data['type']);
        $areas = $this->area_model->find_where_not_in($data['where'], $data['fields'], convertToMongoObject($data['not_in']));
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $areas
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    
    public function find_where_post() {
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
        $data = $this->input->post();
        unset($data['type']);
        $areas = $this->area_model->find_where_select($data, array("_id", "name", "province", "district", "address"));
        if (!empty($areas)) {
            foreach ($areas as $sto) {
                $sto['area_id'] = (string)$sto['_id'];
            }
        }
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $areas
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    

    private $createdAt, $flag_login, $id, $uemail, $ulang, $app_login;

    public function get_all_post(){
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
        $area = $this->area_model->find_where_in('status', ['active','deactive']);
        if (!empty($area)) {
            foreach ($area as $s) {
                $s['id'] = (string)$s['_id'];
            }
        }
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $area
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function get_all_home_post(){

    	$check_user_area = $this->checkRoleArea($this->uemail);

    	if($check_user_area == true){
			$area = $this->area_model->find_where(['status' => 'active', 'code' => ['$nin' => ['KV_HN1','KV_HN2','KV_QN','Priority','KV_BTB']]]);
		} else {
			$area = $this->area_model->find_where_in('status', ['active']);
		}
        if (!empty($area)) {
            foreach ($area as $s) {
                $s['id'] = (string)$s['_id'];
            }
        }
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $area
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function get_area_post(){
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
        $data = $this->input->post();
        $id = !empty($data['id']) ? $data['id'] : "";
        if(empty($id)){
            $response = array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => "Id area already exists"
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
            return;
        }
        $area = $this->area_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $area
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function get_area_by_code_post(){
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
        $data = $this->input->post();
        $code = !empty($data['code']) ? $data['code'] : "";
       
        $area = $this->area_model->findOne(array("code" => $code));
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $area
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
     public function get_description_area_post(){
      
        $data = $this->input->post();
        $link = !empty($data['link']) ? $data['link'] : "";
        if(empty($link)){
            $response = array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => "Id area already exists"
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
            return;
        }
        $area = $this->area_model->findOne(array("link" => $link));
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'data' => $area
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    public function create_area_post(){
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
        $data = $this->input->post();
      $data['created_at']=$this->createdAt;
       
        $this->area_model->insert($data);
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'message' => "Create area success",
            'data'=>$data
        );

        $this->set_response($response, REST_Controller::HTTP_OK);
        return;
    }

    public function update_area_post(){
        $flag = notify_token($this->flag_login);
        if ($flag == false) return;
        $data = $this->input->post();
        $id = !empty($data['id']) ? $data['id'] : "";
        $count = $this->area_model->count(array("_id" => new \MongoDB\BSON\ObjectId($id)));
        if($count != 1) {
            $response = array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => "Không tồn tại vùng nào cần cập nhật"
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
            return;
        }
        $data['updated_at']=$this->createdAt;
        $this->log_area($data);
        unset($data['id']);
     
        $this->area_model->update(
            array("_id" => new MongoDB\BSON\ObjectId($id)),
            $data
        );
        $response = array(
            'status' => REST_Controller::HTTP_OK,
            'message' => "Update area success",
            'data' => $data
        );
        $this->set_response($response, REST_Controller::HTTP_OK);
        return;
    }

    public function log_area($data){
        $id = !empty($data['id']) ? $data['id'] : "";
        $area = $this->area_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));
        $area['id'] = (string)$area['_id'];
        unset($area['_id']);
        $dataInser = array(
            "new_data" => $data,
            "old_data" => $area,
            "type" => 'area'
        );
        $this->log_model->insert($dataInser);
    }

	public function checkRoleArea($email){

		$user_call = $this->call_thn_mn();
		$user_field = $this->field_thn_mn();
		$user_field_b4 = $this->field_thn_mn_b4();
		$lead_call = $this->lead_call_mien_nam();
		$lead_field = $this->lead_field_mien_nam();
		$tp_thn = $this->tbp_thn_mien_nam();

		$arr = array_merge($user_call, $user_field, $user_field_b4, $lead_call, $lead_field, $tp_thn);

		if (in_array($email, $arr)){
			return true;
		} else {
			return false;
		}

	}

	public function call_thn_mn()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "call-thu-hoi-no-mien-nam")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}

	public function lead_field_mien_nam()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "lead_field_mien_nam")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}

	public function lead_call_mien_nam()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "lead-call-mien-nam")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}

	public function tbp_thn_mien_nam()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "tbp-thn-mien-nam")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}

	public function field_thn_mn_b4()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "field-thu-hoi-no-mien-nam-b4")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}

	public function field_thn_mn()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "field-thu-hoi-no-mien-nam")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}

	public function lead_thn_mn()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "lead-thn-mien-nam")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}

	public function get_all_area_active_post(){
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$area = $this->area_model->find_where_in('status', ['active']);
		if (!empty($area)) {
			foreach ($area as $s) {
				$s['id'] = (string)$s['_id'];
			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $area
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

}
?>
