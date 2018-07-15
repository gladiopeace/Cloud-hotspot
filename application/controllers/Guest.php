<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Guest extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $json = json_encode(['status'=>0,'message'=>'Access Deny!']);
        return $json;
    }

    public function s(){

    	$data = $this->input->get_post();
    	var_dump($data);
    	/*$site = $this->uri->segment(3);


    	$key = $this->input->get_post('salt');
        if(!$key)
            $key = $this->input->get_post('accesskey');
        $mac = $this->input->get('mac');
        $ip = $this->input->get('ip');
        $this->load->model('Portal_model');
        $data = $this->Portal_model->init($key);

        $data['config'] = array(
            'ip'			=>	$ip,
            'salt'			=>	$key,
            'mac'			=>	$mac,
        );
      
        $this->load->library('twig');
        $this->twig->setPath();
        $this->twig->display($data['themes'], $data);
		*/	



		$this->load->library('twig');
    	$this->twig->display('guest.php');			

    }

    public function auth(){


    	
    }
}
        