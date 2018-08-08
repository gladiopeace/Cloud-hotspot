<?php


	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Test extends CI_Controller {
	
	    private $_organization = array();
	    private $_config = array();

	    public function __construct() {
	        parent::__construct();

	        $this->load->library('session');
			
			$organization = [
				'salt'				=> $this->session->userdata('salt'),
				'username'			=> $this->session->userdata('username'),
				'id'				=> $this->session->userdata('id'),				
				
			];
			$this->_config = $this->session->userdata();
			$this->_organization = $organization;
	    }
	
	   


	}
	        
?>