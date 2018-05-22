<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	private $_saler = array();
		
	public function __construct(){

		parent::__construct();		
		
		$this->load->library('session');		
		$this->_saler['username'] = $this->session->userdata('username');
		$this->_saler['salt'] = $this->session->userdata('salt');
		$this->_saler['id'] = $this->session->userdata('id');
	

	}





	public function index(){

		if(!empty($this->_saler['username']) && !empty($this->_saler['salt']) && !empty($this->_saler['id'])){
			redirect('manage');
		}
		$data['profile'] = $this->_saler;
		$this->load->view('welcome/index', $data, FALSE);
		
	}


	public function login(){
	
		if(empty($this->_saler['username']) || empty($this->_saler['salt']) || empty($this->_saler['id'])){
			$this->load->view('welcome/login');
		}else{				
			redirect('manage');
		}
	}
	
	public function singup(){

		if($this->input->post()){
			header('content-type: text/html;charset=utf-8');
			$passwd = $this->input->post('password');
			$confirm = $this->input->post('confirm');
			$this->load->helper('js');
			if($passwd!=$confirm){
				_alert_back('密码不一致!');
			}
			$this->load->model('member_model');
			$username = strtolower($this->input->post('username'));
			$_user = $this->member_model->getone(array('username'),'user',array('username'=>$username)); 
			if(!empty($_user) && $username == $_user['0']['username']){
				_alert_back('用户名已经注册,不能重复注册!');
			}
			$email = $this->input->post('email');
			$_email = $this->member_model->getone(array('email'),'user',array('email'=>$email));
			if(!empty($_email) && $email==$_email['0']['email']){
				_alert_back('邮箱已经注册,不能重复注册!');
			}
			$ak = sha1(time().$username);
			$sk = sha1(time().sha1($username.$passwd));
			
			$data = array(
				'username'	=>	$username,
				'password'	=>	md5($passwd),
				'email'		=>	$email,
				'message'	=>	"10",
				'level'		=>	'4',
				'vip'		=>	'1',
				'accesskey'	=>$ak,
				'secretkey'	=>$sk,
				'addtime'	=>	time(),
				);
			$res = $this->member_model->insert_data('user',$data);
			if($res==1){
				_location('注册成功,请登录!',site_url('welcome'));
			}
		}

		if(empty($this->_saler['username']) || empty($this->_saler['salt']) || empty($this->_saler['id'])){
			$this->load->view('welcome/singup');
		}else{				
			redirect('member');
		}
	}



	/*
	*  function ajax 
	*   dateil :
	*
	*/
	public function ajax(){ 

		$model = $this->uri->segment(3);

		switch ($model) {
			
			case 'singup': //用户注册

				$type = $this->input->post('type');

				switch ($type) {
					case 'username':
						$username = strtolower($this->input->post('username'));

						$this->load->model('member_model');

						$user = $this->member_model->getone(array('username'),'user',array('username'=>$username));
						$message = null;
						if(!empty($user) && $user['0']['username']==$username){
							$message = array('status'=>'error');
						}else{
							$message = array('status'=>'ok');							
						}

						echo json_encode($message);

						break;

					case 'email':
						$email = $this->input->post('email');
						$this->load->model('member_model');

						$_email = $this->member_model->getone(array('email'),'user',array('email'=>$email));
					
						$message = null;
						if(!empty($_email) && $_email['0']['email']==$email){
							$message = array('status'=>'error');
						}else{
							$message = array('status'=>'ok');							
						}

						echo json_encode($message);

						break;
					
					default:
						# code...
						break;
				}

				# code...
				break;//结束用户注册
			
			default:
				# code...
				break;
		}



	}

	public function pwforgot(){

		$this->load->view('welcome/pwrest');

	}

	public function userinfo(){
		$this->load->helper('js');
		if(!empty($this->_saler['username']) && !empty($this->_saler['id'])){

			if($this->_saler['salt']=="open" || $this->_saler['salt']==null){
				$this->load->model('member_model');
				$user =$this->member_model->getone(array("*"),"user",array("username"=>$this->_saler['username']));
				$data['profile'] = $user['0'];
				$this->load->view('welcome/component/open', $data, FALSE);
			}else{
				_alert_back('非法访问');
			}

		}else{
			_alert_back('非法访问');

		}
		
	}

	function islogin(){			
			
		if(empty($this->_saler['username']) || empty($this->_saler['id'])){
			
			redirect('welcome/login');
		}elseif(empty($this->_saler['salt'])){				
			redirect('welcome/userinfo');
		}

	}

	function yzm(){
	  $conf['name']='yzm'; //作为配置参数
	  $this->load->library('captcha_code',$conf);
	  $code = $this->captcha_code->show();
	  var_dump($code);
	 /* $_code =$this->captcha_code->getCaptcha();
	  var_dump($_code);
	 */ 
	  /*$this->session->set_userdata('captcha',$code);*/

	}

	function test(){
		$data =array();
		$this->load->view('mobile/test', $data, FALSE);
	}

	function is_moble(){
		$flag=false;
		$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
		if(preg_match("/(iPhone|IOS|iPad|iPod|Android|Windows Phone|HTC)/i", $UA)){
			$flag=true;	
		}
		
		return $flag;
		 
	}


	
	




}
