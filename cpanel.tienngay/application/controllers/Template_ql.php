<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template_ql extends MY_Controller
{
	public function createStore()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/asm/asm';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}

	public function cvkd()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/cvkd/cvkd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	
	public function tpgd()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/tpgd/tpgd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function asm()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/asm/asm';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function gdkd()
	{        
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/gdkd/gdkd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function tpthn()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/tpthn/tpthn';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function tnthn()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/tnthn/tnthn';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function cvthn()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/cvthn/cvthn';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function pheduyet()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/pheduyet/pheduyet';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function ctpheduyet()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/ctpheduyet/ctpheduyet';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function cptb()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/cptb/cptb';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function cttb()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/cttb/cttb';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function xnt_local()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/xnt_local/xnt_local';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function xnt_pgd()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/xnt_pgd/xnt_pgd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function xnt_tax()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/xnt_tax/xnt_tax';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function xnt_khotax()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/xnt_khotax/xnt_khotax';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}
	public function warning()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/ql_xuat_nhap_ton/warning/warning';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		
	}

}

?>
