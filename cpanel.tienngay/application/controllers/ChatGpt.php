<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
require_once APPPATH . 'libraries/ChatGptService.php';


class ChatGpt extends MY_Controller
{

	public function __construct(){
        parent::__construct();
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }


    /**
    * ChatGpt
    */
    public function index() {
    	$this->data['url'] = 'ChatGpt/chat';
		$this->data['template'] = 'page/chatgpt/index';
		$this->load->view('template', $this->data);
		return;
	}

    /**
    * ChatGpt
    */
    public function chat() {
    	$data = json_decode($this->input->raw_input_stream, true);
    	if (empty($data['msg'])) {
    		return $this->pushJson(400, json_encode(array(
				'code' => 400,
				'msg' => "error"
			)));
    	}
    	$service = new ChatGptService();
    	$msg = $service->chat($data['msg'], $this->userInfo);
    	if ($msg) {
    		return $this->pushJson(200, json_encode(array(
				'code' => 200,
				'msg' => $msg
			)));
    	}

    	return $this->pushJson(400, json_encode(array(
			'code' => 400,
			'msg' => "error"
		)));
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}
}
