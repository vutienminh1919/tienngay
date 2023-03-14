<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class TemplateHome extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function general(){
        $data['template'] = 'templatehome/general';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function takeloannow(){
        $data['template'] = 'templatehome/takeloannow';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function home(){
        $data['template'] = 'templatehome/home';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function pawnnow(){
        $data['template'] = 'templatehome/pawnnow';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function aboutus(){
        $data['template'] = 'templatehome/aboutus';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function guidepawn(){
        $data['template'] = 'templatehome/guidepawn';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function officelist(){
        $data['template'] = 'templatehome/officelist';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function faqs(){
        $data['template'] = 'templatehome/faqs';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function recuiment(){
        $data['template'] = 'templatehome/recuiment';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function recuimentdetail(){
        $data['template'] = 'templatehome/recuimentdetail';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function newsdetail(){
        $data['template'] = 'templatehome/newsdetail';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function news(){
        $data['template'] = 'templatehome/news';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function preservation(){
        $data['template'] = 'templatehome/preservation';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function orders(){
        $data['template'] = 'templatehome/orders';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function liquidationdetails(){
        $data['template'] = 'templatehome/liquidationdetails';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function liquidation(){
        $data['template'] = 'templatehome/liquidation';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
    public function liquidationlist(){
        $data['template'] = 'templatehome/liquidationlist';
        $this->load->view('templatehome/template', isset($data)?$data:NULL);
    }
}
?>
