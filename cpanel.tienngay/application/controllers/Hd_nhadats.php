<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hd_nhadats extends MY_Controller
{
	public function thuematbang()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/hdnd/thuematbang';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function ds_hopdong()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/hdnd/ds_hopdong';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function ct_hd()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/hdnd/ct_hd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function email()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/hdnd/email';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
}

?>
