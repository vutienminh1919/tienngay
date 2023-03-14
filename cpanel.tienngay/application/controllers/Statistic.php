<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Statistic extends MY_Controller{
    public function __construct(){
        parent::__construct();
          $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
        if (!$this->is_superadmin) {
            $paramController = $this->uri->segment(1);
            $param = strtolower($paramController);
            if (!in_array($param, $this->paramMenus)) {
                $this->session->set_flashdata('error', $this->lang->line('not_have_permission').' '.$paramController .'!');
                redirect(base_url('app'));
                return;
            }
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }
  //   public function insurrance(){
  //       $this->data["pageName"] = "Statistic insurrance";
  //       $this->data['template'] = 'page/statistic/insurrance_dashboard';

  //       try{
		// 	$res = $this->api->apiPost($this->user['token'], "statistic/getData_insurrance");
		// 	$this->data['data'] = $res->data;
			
		// 	$this->load->view('template', isset($this->data)?$this->data:NULL);
		// }catch (\Exception $exception){
		// 	$this->data['data'] = '';
		// 	$this->load->view('template', isset($this->data)?$this->data:NULL);
		// }
  //   }

   

	public function insurrance(){
		  try{
		$this->data["pageName"] = "Statistic insurrance";
		 $this->data['template'] = 'page/statistic/insurrance_dashboard';
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
			$res = $this->api->apiPost($this->user['token'], "statistic/search",$cond);
			$this->data['data'] = $res->data;
		
		$this->load->view('template', isset($this->data)?$this->data:NULL);
		}catch (\Exception $exception){
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}
	}
}
?>
