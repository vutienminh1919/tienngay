<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model{
    public function __Construct(){
        parent::__construct();
        $this->collection = 'role';
    }
    private $collection;

    public function where_or($where=array()){
        return $this->mongo_db->or_where($where)->get($this->collection);
    }
    public function where_in($field = "", $in = array())
    {
        return $this->mongo_db
            ->where_in($field, $in)->get($this->collection);
    }
      // active user
    public function activate($token_active) {
        $query = $this->mongo_db->where('token_active', $token_active)->get('user');
        if (!empty($query)) {
            $data = array(
                'status_login' => true,
                'token_active' => ""
            );
            $this->update(array('token_active' =>  $token_active),$data);
            return  true;
        } else {
            return  false;
        }
    }
    public function insertReturnId($data) {
        return $this->mongo_db->insertReturnId($this->collection, $data);
    }
    public function insert($data){
        return $this->mongo_db->insert($this->collection, $data);
    }
    public function find_where($condition){
        return $this->mongo_db
            ->get_where($this->collection, $condition);
    }
    public function find_where_select($condition, $value){
        return $this->mongo_db
            ->select($value)
            ->get_where($this->collection, $condition);
    }
    public function findOneAndUpdate($where="", $inforUupdate="") {
        $update = array(
            '$set' => $inforUupdate
        );
        return $this->mongo_db->find_one_and_update($this->collection, $where, $update);
    }
    
    public function find_where_not_in($condition, $field="", $in=""){
        if(empty($in)) {
            return $this->mongo_db
            ->order_by(array('created_at' => 'DESC'))
            ->get_where($this->collection, $condition);
        } else {
            return $this->mongo_db
            ->order_by(array('created_at' => 'DESC'))
            ->where_not_in($field, $in)
            ->get_where($this->collection, $condition);
        }
    }
    
    public function findTop($limit=1, $condition, $offset=1){
        $arr = $this->mongo_db
            ->order_by(array('created_at' => 'desc'))
            ->limit($limit)
            ->offset($offset)
            ->get_where($this->collection, $condition);
        return $arr;
    }
    public function find(){
        return $this->mongo_db
            ->get($this->collection);
    }
    private $app_count_user, $app_user_info;
    public function getAppCountUser(){
        return $this->app_count_user;
    }
    public function getAppUserInfo(){
        return $this->app_user_info;
    }
    public function signin($email, $password){
        $condition = array('email' => $email);
        $this->app_count_user = $this->count($condition);
        $this->app_user_info = $this->find_where($condition);
        if ($this->app_count_user == 1 && password_verify($password, $this->app_user_info[0]->password)){
            return true;
        }else{
            return false;
        }
    }
    public function signin_fb_gg($email){
        $condition = array('email' => $email);
        $this->app_count_user = $this->count($condition);
        $this->app_user_info = $this->find_where($condition);
        if ($this->app_count_user == 1){
            return true;
        }else{
            return false;
        }
    }

    public function load_info($email){
        $condition = array('email' => $email);
        $this->app_count_user = $this->count($condition);
        $this->app_user_info = $this->find_where($condition);
        if ($this->app_count_user == 1)return true;
        else return false;
    }
    public function setting_info($email){
        $condition = array('email' => $email);
        $this->app_count_user = $this->count($condition);
        $value = array('my_referal',
            'referal',
            'email',
            'created_at',
            'lang',
            'trust',
            'fee_id',
            'level_id',
            'whitelist',
            'nick_name',
            'enable_google_2fa',
            'enable_email_2fa',
            'enable_sms_2fa',
            'birthday',
            'city',
            'country',
            'address',
            'street_address_1',
            'street_address_2',
            'firt_name',
            'last_name',
            'avatar',
            'egt_fee',
            'chat',
            'passport_country',
            'passport'
        );
        $this->app_user_info = $this->find_where_select($condition, $value);
        if ($this->app_count_user == 1)return true;
        else return false;
    }
    public function signup($email) {
        $condition = array('email' => $email);
        if ($this->count($condition) === 0){
            return true;
        }else{
            return false;
        }
    }
    public function findOne($condition){
        return $this->mongo_db->where($condition)->find_one($this->collection);
    }
    public function update($condition, $set){
        return $this->mongo_db->where($condition)->set($set)->update($this->collection);
    }

    public function delete($condition){
        return $this->mongo_db->where($condition)->delete($this->collection);
    }
    public function getUserDetail($uid){

    }
    public function count($where){
        return $this->mongo_db->where($where)->count($this->collection);
    }
    public function getObjectId($email = '')
    {
        $email_active = $this->findOne(array('email' => $email));
        $getId = $email_active['_id'];
        $idd = json_encode($getId);
        $json = json_decode($idd, true);
        $oId = $json['$oid'];
        return $oId;
    }


    public function send_Email($data) {
        $url_email = $this->config->item('URL_API_EMAIL');
        $postdata = http_build_query(
           $data
        );
        $opts = array('http' =>
                    array(
                        'method' => 'POST',
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'content' => $postdata,
                        //'ignore_errors' => '1'
                    )
                );
        $context = stream_context_create($opts);
        $result = file_get_contents($url_email, false, $context);
        $decodeResponse = json_decode($result);
        // var_dump($decodeResponse);
        try{
            return true;
            // \Log::info($result);
        }catch(\Exception $e){
            return false;
        }
    }
    

//     public function sendEmail($code, $email, $url, $device, $ipAddress, $passwordNew) {
//         $data = array(
//             'infor' => array (
//                 'code' => $code,
//                 'email' => $email,
//                 'url' => $url,
//                 'device' => $device,
//                 'ip_address' => $ipAddress,
//                 'password' => $passwordNew
//             )
//         );
//         $ch = curl_init();
//         // curl_setopt($ch, CURLOPT_URL, $this->config->item('url_service').'email/sendEmail');
//         curl_setopt($ch, CURLOPT_URL, $this->config->item('URL_API_EMAIL'));
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//         $result = curl_exec($ch);
//         var_dump($result);die;
//         try{
// //            \Log::info($result);
//         }catch(\Exception $e){
//             return null;
//         }
//     }
    
    public function sendEmailConfirm($code, $email, $emailVerifyCode) {
        $data = array(
            'infor' => array (
                'code' => $code,
                'email' => $email,
                'email_verify_code' => $emailVerifyCode
            )
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->item('url_service').'email/sendEmail');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $result = curl_exec($ch);
        try{
//            \Log::info($result);
        }catch(\Exception $e){
            return null;
        }
    }

    public function checkEmailStatus($email = '', $password  = '') {
        $mail_active = $this->findOne(array('email' => $email));
        if(empty($mail_active) || !password_verify($password, $mail_active['password'])) return false;
        return true;
    }

    public function checkStatusLogin($email) {
        $mail_active = $this->findOne(array('email' => $email));
        if(!empty($mail_active) && $mail_active['status_login']) return true;
        return false;
    }
    
    public function getRoleByUserId($userId) {
        $roles = $this->find_where(array("status" => "active"));
        $response = array();
        if(count($roles) > 0) {
            $roleStores = array();
            $roleMenus = array();
            $role_name= array();
            $roleAccessRights = array();$i = 0;
            foreach($roles as $role) {
                if(!empty($role['users']) && count($role['users']) > 0){
                    $arrUsers = array();
                    foreach($role['users'] as $item) {
                        array_push($arrUsers, key($item));
                    }
                    //Check userId in list key of $users
                    if(in_array($userId, $arrUsers) == TRUE) {
                        if(!empty($role['stores'])) {
                            //Push store
                            foreach($role['stores'] as $item) {
                                $store_id =  key($item);
                                $store =  $item;
                                foreach($store as $key => $value) {
                                    $store_name = $value['name'];
                                    $store_address = $value['address'];
									$code_area = isset($value['code_area']) ? $value['code_area'] : '';

                                }
                                // array_push($roleStores, key($item));
                                array_push($roleStores, array('store_id' =>  $store_id,'store_name' => $store_name ,'store_address' => $store_address,'code_area' => $code_area));

                            }
                        }
                        if(!empty($role['menus'])) {
                            //Push store
                            foreach($role['menus'] as $item) {
                                array_push($roleMenus, key($item));
                            }
                        }
                          if(!empty($role['name'])) {
                            
                             array_push($role_name, $role['name']);
                            
                        }
                        if(!empty($role['access_rights'])) {
                            //Push store
                            foreach($role['access_rights'] as $item) {
                                array_push($roleAccessRights, key($item));
                                //array_push($roleAccessRights, $item[key($item)]->slug);
                            }
                        }
                    }
                }
            }
            $response['role_stores'] = $roleStores;
            $response['role_menus'] = $roleMenus;
            $response['role_name'] = $role_name;
            $response['role_access_rights'] = $roleAccessRights;
        }
        return $response;
    }
    
    public function getStoresByUserId($userId) {
        $roles = $this->find_where(array("status" => "active"));
        $response = array();
        if(count($roles) > 0) {
            $roleStores = array();
            $roleMenus = array();
            $roleAccessRights = array();$i = 0;
            foreach($roles as $role) {
                if(!empty($role['users']) && count($role['users']) > 0){
                    $arrUsers = array();
                    foreach($role['users'] as $item) {
                        array_push($arrUsers, key($item));
                    }
                    //Check userId in list key of $users
                    if(in_array($userId, $arrUsers) == TRUE) {
                        if(!empty($role['stores'])) {
                            //Push store
                            foreach($role['stores'] as $item) {
                                $store_id =  key($item);
                                $store =  $item;
                                foreach($store as $key => $value) {
                                    $store_name = $value['name'];
                                    $store_address = $value['address'];
                                }
                                // array_push($roleStores, key($item));
                                array_push($roleStores, array('store_id' =>  $store_id,'store_name' => $store_name ,'store_address' => $store_address));

                            }
                        }
                        
                    }
                }
            }
            $response['role_stores'] = $roleStores;
        }
        return $response;
    }

	public function get_store_user($userId)
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		$i = 0;
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && !empty($role['stores'])) {
				$data[$i]['users'] = $role['users'];
				$data[$i]['stores'] = $role['stores'];
				$i++;
			}
		}
		$store = [];
		$slug = [];
		$j = 0;
		$k = 0;
		foreach ($data as $da) {
			foreach ($da['users'] as $d) {
				$dataId = [];
				foreach ($d as $key => $v) {
					array_push($dataId, $key);
				}
				if (in_array($userId, $dataId) == true) {
					if (count($da['stores']) > 1) {
						continue;
					}
					foreach ($da['stores'] as $d) {
						foreach ($d as $key => $v) {
							$store[$j]['name'] = $v['name'];
							$store[$j]['id'] = $key;
							$j++;
						}
					}
				}
			}
		}
		return $store;
	}

	public function findAsm()
	{
		$where = array();
		$mongo = $this->mongo_db;
		$where['status'] = 'active';
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		$mongo = $mongo->like("slug", 'asm');
		return $mongo
			->get($this->collection);

	}
	public function get_thn_user($userId)
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "phong-thu-hoi-no")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						$data = [];
						if ($userId == $key2) {
							array_push($data, $key2 );
						}
					}
				}
			}
		}
		return $data;
	}

	/** Get DS id trưởng phòng QLKV miền Bắc
	 * @return array
	 */
	public function get_id_tp_qlkv_mb()
	{
		$role_tp_qlkv_mb = $this->findOne(['slug' => 'tbp-thn-mien-bac']);
		$id_tp_qlkv_mb_list = [];
		if (!empty($role_tp_qlkv_mb)) {
			foreach ($role_tp_qlkv_mb['users'] as $roles) {
				foreach ($roles as $id_user => $role) {
					if (!empty($id_user)) {
						array_push($id_tp_qlkv_mb_list, $id_user);
					}
				}
			}
		}
		return $id_tp_qlkv_mb_list;
	}

	/** Get DS id trưởng phòng QLKV miền Nam
	 * @return array
	 */
	public function get_id_tp_qlkv_mn()
	{
		$role_tp_qlkv_mn = $this->findOne(['slug' => 'tbp-thn-mien-nam']);
		$id_tp_qlkv_mn_list = [];
		if (!empty($role_tp_qlkv_mn)) {
			foreach ($role_tp_qlkv_mn['users'] as $roles) {
				foreach ($roles as $id_user => $role) {
					if (!empty($id_user)) {
						array_push($id_tp_qlkv_mn_list, $id_user);
					}
				}
			}
		}
		return $id_tp_qlkv_mn_list;
	}

	/** Get list id lead Quản lý khoản vay MB
	 *
	 */
	public function get_id_lead_qlkv_mb()
	{
		$data_role = $this->findOne(['slug' => 'lead-thn-mien-bac']);
		$array_user_id_lead_qlkv_mb = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $roles) {
				foreach ($roles as $key => $role) {
					array_push($array_user_id_lead_qlkv_mb, $key);
				}
			}
		}
		return $array_user_id_lead_qlkv_mb;
	}

	/** Get list id lead Quản lý khoản vay MN
	 *
	 */
	public function get_id_lead_qlkv_mn()
	{
		$data_role = $this->findOne(['slug' => 'lead-thn-mien-nam']);
		$array_user_id_lead_qlkv_mn = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $roles) {
				foreach ($roles as $key => $role) {
					array_push($array_user_id_lead_qlkv_mn, $key);
				}
			}
		}
		return $array_user_id_lead_qlkv_mn;
	}

	/** Get list nhân viên quản lý khoản vay miền Bắc
	 * @return null
	 */
	public function get_id_nv_qlkv_mb()
	{
		$data_role = $this->findOne(['slug' => 'nhan-vien-qlkv-mien-bac']);
		$array_id_nv_qlkv_mb = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $roles) {
				foreach ($roles as $key => $role) {
					array_push($array_id_nv_qlkv_mb, $key);
				}
			}
		}
		return $array_id_nv_qlkv_mb;
	}

	/** Get list nhân viên quản lý khoản vay miền Nam
	 * @return null
	 */
	public function get_id_nv_qlkv_mn()
	{
		$data_role = $this->findOne(['slug' => 'nhan-vien-qlkv-mien-nam']);
		$array_id_nv_qlkv_mn = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $roles) {
				foreach ($roles as $key => $role) {
					array_push($array_id_nv_qlkv_mn, $key);
				}
			}
		}
		return $array_id_nv_qlkv_mn;
	}

	/** Lấy mảng id toàn bộ nhân viên phòng quản lý khoản vay miền Bắc
	 * @return array
	 */
	public function get_list_all_id_nv_qlkv_mb()
	{
		$list_qlkv_mb = array();
		$list_id_tp_qlkv_mb = $this->get_id_tp_qlkv_mb();
		$list_id_lead_qlkv_mb = $this->get_id_lead_qlkv_mb();
		$list_id_nv_qlkv_mb = $this->get_id_nv_qlkv_mb();
		$list_qlkv_mb = array_merge($list_id_tp_qlkv_mb, $list_id_lead_qlkv_mb, $list_id_nv_qlkv_mb);
		return $list_qlkv_mb;
	}

	/** Lấy mảng id toàn bộ nhân viên phòng quản lý khoản vay miền Nam
	 * @return array
	 */
	public function get_list_all_id_nv_qlkv_mn()
	{
		$list_qlkv_mn = array();
		$list_id_tp_qlkv_mn = $this->get_id_tp_qlkv_mn();
		$list_id_lead_qlkv_mn = $this->get_id_lead_qlkv_mn();
		$list_id_nv_qlkv_mn = $this->get_id_nv_qlkv_mn();
		$list_qlkv_mn = array_merge($list_id_tp_qlkv_mn, $list_id_lead_qlkv_mn, $list_id_nv_qlkv_mn);
		return $list_qlkv_mn;
	}

}

