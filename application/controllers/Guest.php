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

    	$site = $this->uri->segment(3);
		$this->load->library('twig');
    	$this->twig->display('guest.php');			

    }

    public function auth(){


    	
    }
}
        