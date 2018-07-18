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

        $id = $this->input->get_post('id'); //user's mac address
        $ap = $this->input->get_post('ap'); //AP mac
    	$ssid = $this->input->get_post('ssid'); //ssid the user is on (POST 2.3.2)
        $time =  $this->input->get_post('t');  //time the user attempted a request of the portal
        $refURL = $this->input->get_post('url'); //url the user attempted to reach
        
        $site = $this->uri->segment(3);
        $this->load->model('Portal_model');
        $data = $this->Portal_model->apToSite($ap);

        $data['config'] = array(
            'ip'            => $data['branch']['access_info']['ip'],//
            'salt'          =>  $data['branch']['salt'],
            'mac'           =>  $id,
        );
      
        $this->load->library('twig');
        $this->twig->setPath();
        $this->twig->display($data['themes'], $data);
    }

}
        