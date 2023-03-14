<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Edit_email extends MY_Controller
{
	
	public function email()
	{
		// $this->data["pageName"] = $this->lang->line('create_store');
		// $this->data['template'] = 'page/editEmail/email';
		// $this->load->view('template', isset($this->data) ? $this->data : NULL);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('page/editEmail/email', isset($this->data) ? $this->data : NULL);
	}
	public function phieuthuong()
	{
		// $this->data["pageName"] = $this->lang->line('create_store');
		// $this->data['template'] = 'page/editEmail/email';
		// $this->load->view('template', isset($this->data) ? $this->data : NULL);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('page/editEmail/phieuthuong', isset($this->data) ? $this->data : NULL);
	}
}

?>
