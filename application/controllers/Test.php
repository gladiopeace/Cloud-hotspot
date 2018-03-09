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
				'alipay_payment'	=> $this->session->userdata('alipay_payment'),
				
			];
			$this->_config = $this->session->userdata();
/*
			if(empty($organization['id']) || empty($organization['salt']) || empty($organization['username'])){

				redirect('/','refresh');
			}*/


			$this->_organization = $organization;
	    }
	
	    function index() {
	        
	       
	    	//echo json_encode(['data'=>'hello world!!']);
	    	$img = $_FILES['file'];

	    	$path = './data/upload/';
		  	if(!is_dir($path)){
		  		mkdir($path,0777,true);
		  	}
			  
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'gif|jpg|png|mp3|';
			$config['file_name'] = uniqid();
			$config['image_width'] = '400';
			$config['image_height'] = '400';
			
			$this->load->library('upload',$config);

			if (!$this->upload->do_upload('file')){
			   $error = array('error' => $this->upload->display_errors());
			   /*$this->load->view('upload_form', $error);*/
			   echo json_encode(['status'=>"false",'message'=>$error['error']]);
			   //var_dump($error['error']);
			   exit();
			}
			/*else{*/
			$data = $this->upload->data();
			$src_img = "/data/upload/".$data['file_name'];

			echo json_encode(["status"=>"success",'src'=>$src_img]);
			//var_dump($data);

			exit();

	    	$alipay_payment = json_decode($this->_config['alipay_payment'],true);
	    	
	    	$app_auth_token = $alipay_payment['app_auth_token'];
	    	/*var_dump($app_auth_token);
	    	exit();*/
	    	$this->load->library('AlipaySdk');
	    	$result = $this->alipaysdk->uploadPic(array('img'=>$data['full_path'],'app_auth_token'=>$app_auth_token));
	    }

	    public function fetch(){
	    	
	    	$this->load->library('baidu');
			$auth = $this->baidu->fetchAuth();
	    	
	    	$expire = $auth['expires_in']-20; 
	    	
	    	$redis = new Redis();
		    $redis->connect('127.0.0.1',6379);
		
		    $data = json_encode($auth);
		    $redis->set('x', $data);
			//$redis->setTimeout('x', 5);	// x will disappear in 3 seconds.
			$redis->expire('x',5);
		
	    }

	    public function getfetch(){
			
			$redis = new Redis();
		    $redis->connect('127.0.0.1',6379);
			$x = json_decode($redis->get('x'),true);
			var_dump($x);
	    }

	    public function trunkpay_test(){

	    	//$price = $this->input->get('price');
	    	$price = mt_rand(1,99);
	    	$redis = new Redis();
		    $redis->connect('127.0.0.1',6379);
			$redis->rPush('2', $price);
			$redis->expire('2',10);
	    }


	    public function success(){	    	
	    	$data = array();
	    	$this->load->view('trunkpay/result', $data, FALSE);
	    }


	    public function success_alipay(){	    	
	    	$data = array();
	    	$this->load->view('trunkpay/result_alipay', $data, FALSE);
	    }

        public function js_decypt(){
                $data1 = array('val'=>'Hello world','pass'=>'mikrotik');




                //exit();

            	$this->load->library('Enypt');
            	$data = $this->enypt->cryptoJsAesEncrypt($data1["pass"], $data1["val"]);
                $data = array('data'=>json_decode($data,true));
                $data = array_merge($data,$data1);
                var_dump($data);

              /*  var_dump(json_decode($data,true));*/
                //$data = array('val'=>$data,'pass'=>$data["pass"]);
                 /*
                 *
                 * var_dump($data)
                 *
                 */



            $this->load->view('jsencry', $data, FALSE);


        }

        public function test_js(){

            $data = $this->input->get();

            $this->load->view('jsencryb', $data, FALSE);


        }


	}
	        
?>