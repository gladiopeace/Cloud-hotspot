<?php 

	
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Index extends CI_Controller {
	
	    private $_saler = array();
		

		public function __construct(){
			parent::__construct();

			$this->load->library('session');
			//获取用户信息
			$this->_saler['username'] = $this->session->userdata('username');
			$this->_saler['salt'] = $this->session->userdata('salt');
			$this->_saler['id'] = $this->session->userdata('id');
			$this->_saler['channel'] = $this->session->userdata('channel');

			
		}

	
	    function index() {
	       	
	       	if(empty($this->_saler['username']) || empty($this->_saler['salt']) || empty($this->_saler['id'])){
				$this->load->view('welcome_message');
				//$this->load->library('twig');	
				//$this->twig->display('index/index.php',[' $data']);
			}else{				
				
				if($this->_saler['channel']=="manage"){
					redirect('manage');
				}

				if($this->_saler['channel']=="store_user"){
					$store = $this->session->userdata('store');
					
					if(isset($store['salt']) && !empty($store['salt'])){
						$accesskey = $store['salt'];
					}else{

						$accesskey = $store['accesskey'];
					}
					redirect(site_url('store/index/portal?accesskey='.$accesskey),'refresh');
				}	
			}
			
	    }
	}
	        
 ?>