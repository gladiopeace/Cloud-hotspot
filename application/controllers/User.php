<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class User extends CI_Controller{



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

        public function index(){
            redirect('user/signin');
        }

		public function resetpwd(){

			$ops = array('access','result');

			$op = $this->uri->segment(3);

			if(in_array($op, $ops)){

				if($op=="access"){

					if($this->input->post()){

						$accesskey = $this->input->post('accesskey');
						$secretkey = $this->input->post('secretkey');
						$linkid = $this->input->post('linkid');

					
						if(!$accesskey || !$secretkey){
							echo json_encode(array('status'=>"false","message"=>"none"));
							exit();
						}

						//$sql = "SELECT p1.id,p1.uid,p1.type,p1.addtime,p2.email,p2.password FROM ros_mail p1 LEFT JOIN ros_user p2 ON p1.uid = p2.id WHERE p1.accesskey='".$accesskey."' AND p1.secretkey='".$secretkey."' AND p2.id = p1.uid";
						$sql = "SELECT p1.id,p1.uid,p1.accesskey,p1.secretkey,p1.type,p1.addtime,p1.email,p2.id,p2.username,p2.password FROM ros_mail p1 LEFT JOIN ros_user p2 ON p1.uid = p2.id WHERE p1.accesskey='".$accesskey."' AND p1.secretkey='".$secretkey."' AND p1.id='".$linkid."' AND p2.id = p1.uid";

						
				
					
						$query = $this->db->query($sql);
						//DDDecho $this->db->last_query();
						$result = $query->result_array();
						//$salt = $user[0]['id'].$user[0]['password'].$user[0]['email'];
						

						$now = time();

						$before = intval($result[0]['addtime'])-180;

						$sec = $now - $before;
									
						$mins = intval($sec/60);
						header('content-type:text/html;charset=utf-8');
						/*if($mins<=60){*/					
						if($mins<=1440){					
							
							$password = $this->input->post('newpass');
							$confirm = $this->input->post('confirm');
							if($password!=$confirm){
								$this->load->helper('js');
								_alert_back('两次输入密码不一致!');
							}

							
							$newpass = md5($password);
							$salt = sha1($result[0]['username'].$newpass);

							$this->db->query("UPDATE ros_user SET password='".$newpass."',salt='".$salt."' WHERE id='".$result[0]['uid']."' AND email='".$result[0]['email']."'");
							$this->db->query("UPDATE ros_mail SET status='1' WHERE id='".$linkid."' AND accesskey='".$accesskey."' AND secretkey='".$secretkey."'");
							
							/*$res = $this->db->affected_rows();
							if($res){
							*/
							echo json_encode(array('status'=>"success"));
							/*}else{
								$this->load->helper('js');
								_alert_back('密码修改失败!');
							}*/
						}else{
							echo json_encode(array('status'=>"false",'message'=>"gone"));
							//$this->load->view('user/resetpwd_b');
						}
						exit();
					}



					$accesskey = $this->input->get('accesskey');
					$secretkey = $this->input->get('secretkey');
					
					if(!$accesskey || !$secretkey){
						exit('stop is not post');
						redirect('');
					}

					$sql = "SELECT p1.id,p1.uid,p1.type,p1.accesskey,p1.secretkey,p1.status,p1.addtime,p2.email,p2.password FROM ros_mail p1 LEFT JOIN ros_user p2 ON p1.uid = p2.id WHERE p1.accesskey='".$accesskey."' AND p1.secretkey='".$secretkey."' AND p2.id = p1.uid";

				
					
					$query = $this->db->query($sql);

					$result = $query->result_array();

					

					if(empty($result)){

						redirect('');
					}

				

					$now = time();

					$before = $result[0]['addtime'];

					$sec = $now - $before;
								
					$mins = intval($sec/60);
					$data['user'] = $result[0];
					/*if($mins<=60 && $result[0]['status']==0){*/
					if($mins<=1440 && $result[0]['status']==0){
						
						
						
						$this->load->view('user/resetpwd', $data, FALSE);

					}else{
						$h = intval($mins/60);
						//$this->load->view('user/result/error/resetpwd_b', $data, FALSE);
						redirect(site_url('user/resetpwd/result/error?accesskey='.$result[0]['accesskey']));
					}
				}

				if($op=='result'){

					$type = $this->uri->segment(4);

					if($type=="success"){
						$accesskey = $this->input->get('accesskey');
						$query = $this->db->query("SELECT accesskey FROM ros_mail WHERE accesskey='{$accesskey}'");
						$result = $query->result_array();
						
						if(!empty($result)){
							$this->load->view('user/result/success');
						}else{
							redirect(base_url(),'refresh');
						}

						
					}

					if($type=="error"){
						$accesskey = $this->input->get('accesskey');
						$query = $this->db->query("SELECT accesskey FROM ros_mail WHERE accesskey='{$accesskey}'");
						$result = $query->result_array();
						if(!empty($result)){
							$this->load->view('user/result/error');
						}else{
							redirect(base_url(),'refresh');
						}
						
					}


				}
				


			}else{
				redirect('','refresh');

			}
		
			


			

		}


		public function signin(){
			
	       	if(!empty($this->_saler['username']) 
	       		&& !empty($this->_saler['salt']) 
	       		&& !empty($this->_saler['id'])
	       	){
	       		redirect('manage');
			}else{		
				$lang = $this->input->get('lang', TRUE);
	       		$this->load->library('Lang', array('lang'=>$lang), 'Switch');
	       		$data = $this->Switch->sign_in();	   			
  				$this->load->library('twig');
				$this->twig->display('index/signin.php',$data);					
			}
		}
	
	
		public function signup(){
			
			if(!empty($this->_saler['username']) && empty($this->_saler['salt']) && empty($this->_saler['id']))	redirect('manage');


            if($this->input->post()){

                $email = $this->input->post('email');
                $password = md5($this->input->post('password'));
                $this->db->select('id,username,password,email,salt');
                $flag = false;
                $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
                if (preg_match($pattern,$email)){
                    //$query = $this->db->get_where('user', array('password' => $password,"email" =>$email,'level >=' => '4','vip' => '1'), 1);
                    $query = $this->db->get_where('user', array('password' => $password,"email" =>$email), 1);
                    $flag = true;
                }else{
                    $query = $this->db->get_where('user', array('password' => $password,"username" =>$email), 1);

                }

                $data = $query->result_array();
                var_dump($data);
                if(!empty($data) && $data['0']['password']==$password){
                    if($flag==true && $data['0']['email']!==$email && $data['0']['username']!==$email){
                        echo json_encode(array("status"=>"false","message"=>"用户名或密码错误!"));
                        exit();
                    }elseif($flag==false && $data['0']['username']!==$email){
                        echo json_encode(array("status"=>"false","message"=>"用户名或密码错误!"));
                        exit();
                    }


                    $salt = sha1($data['0']['username'] . $data['0']['password']);//生成加密的票据

                    if($salt!=$data['0']['salt']){

                        $this->db->where('id',$data['0']['id']);
                        $this->db->update('user', array('salt'=>$salt));
                    }


                    $this->load->library('session');

                    $newdata = array(
                        'username'  => $data['0']['username'],
                        'salt'     =>  $salt,
                        'id' => $data['0']['id']
                    );

                    $this->session->set_userdata($newdata);

                    echo json_encode(array("status"=>"ok","message"=>"success!"));
                }else{
                    echo json_encode(array("status"=>"false","message"=>"用户名或密码错误!"));
                }
                exit();
            }
			$from = $this->input->get('from');
			$salt = $this->input->get('salt');

       		$lang = $this->input->get('lang', TRUE);
       		$this->load->library('Lang', array('lang'=>$lang), 'Switch');
       		$data = $this->Switch->sign_up();	   			
			$this->load->library('twig');
			$data['salt'] = $salt;
			$data['from'] = $from;

			$this->twig->display('index/signup.php',$data);

			
		}

		public function changemail(){


			$type = $this->uri->segment(3);
				
			if($type=="access"){


				$accesskey = $this->input->get('accesskey');
				$secretkey = $this->input->get('secretkey');
				
				if(!$accesskey || !$secretkey){
					redirect('');
				}

				$sql = "SELECT p1.id,p1.uid,p1.type,p1.accesskey,p1.secretkey,p1.status,p1.addtime,p1.email,p2.password FROM ros_mail p1 LEFT JOIN ros_user p2 ON p1.uid = p2.id WHERE p1.accesskey='".$accesskey."' AND p1.secretkey='".$secretkey."' AND p2.id = p1.uid";

			
				
				$query = $this->db->query($sql);

				$result = $query->result_array();

				
			
				if(empty($result) || $result[0]['type']!='change'){

					redirect('');
				}

			
	
				$now = time();

				$before = $result[0]['addtime'];

				$sec = $now - $before;
				
				$mins = intval($sec/60);
				$data['user'] = $result[0];
				/*if($mins<=60 && $result[0]['status']==0){*/
				if($mins<=1440 && $result[0]['status']==0){
						
					$salt = sha1($result[0]['email'].$result[0]['password']);
					$sql = "UPDATE ros_user SET salt='".$salt."',email='".$result[0]['email']."',username='".$result[0]['email']."' WHERE id='".$result[0]['uid']."'";
					$this->db->query($sql);
					
				
					$sql = "UPDATE ros_mail SET status='1' WHERE id='".$result[0]['id']."'";
					
					$this->db->query($sql);
				
					$this->load->view('user/email/active', $data, FALSE);
					
				}else{
				
					//$this->load->view('user/result/error/resetpwd_b', $data, FALSE);
					redirect(site_url('user/changemail/error?accesskey='.$result[0]['accesskey']));
				}
			}
			
			if($type=="error"){

				$this->load->view('user/email/error');
			}


		}

		public function email(){

			$ops = array('forget','active','change','verifysent');
			$op = $this->uri->segment(3);
			

			if(in_array($op, $ops)){

				if($op=="forget"){
					$email = $this->input->post('email');
					$verify = strtoupper($this->input->post('verify'));
					session_start();

					if(isset($_SESSION['yzm']) && !empty($_SESSION['yzm'])){
						$_verify = $_SESSION['yzm'];
					}else{
						$_verify = '';
					}
					
					if($_verify==$verify){
						
						$query = $this->db->query("SELECT id,password,email FROM ros_user WHERE email='{$email}' LIMIT 1");
						$user = $query->result_array();					

						if(!empty($user) && $email==$user['0']['email']){
							
							$now = time();
							$accesskey = sha1($user[0]['id'].$user[0]['email'].$now);
							$secretkey = sha1($user[0]['id'].$user[0]['password'].$user[0]['email']);
							$data = array(
								'uid'		=>	$user[0]['id'],
								'accesskey'	=>	$accesskey,
								'secretkey'	=>	$secretkey,
								'email'		=>	$user[0]['email'],
								'type'		=>	"resetpwd",
								'addtime'	=>	$now,
								);

							$this->db->insert('ros_mail', $data);



							//$this->mail->send_mail('yb19901208.vlp@163.com','我','[云热点]找回您的帐户密码',$body);
							$_mail= explode("@", $email);
							$mail_type = $_mail[1];
							switch ($mail_type) {
								case 'qq.com':
									$url = 'http://mail.qq.com';
									break;

								case '163.com':
									$url = 'http://mail.163.com/';
									break;

								case 'sina.com':
									$url = 'http://mail.sina.com/';
									break;

								case 'sina.cn':
									$url = 'http://mail.sina.com/';
									break;

								case 'sohu.com':
									$url = 'http://mail.sohu.com/';
									break;

								case 'gmail.com':
									$url = 'http://mail.gmail.com/';
									break;
								
								default:
									# code...
									break;
							}

							if(!empty($url)){
								$html ="<a href='".$url."' target='_blank'>查看邮件>></a>";
								$flag ='ok'; 
							}else{
								$html =null;
								$flag ='false'; 
							}

							
							echo json_encode(array('status'=>"success",'html'=>$html,'email'=>$email,'flag'=>$flag));
							$url = site_url('user/resetpwd/access').'?accesskey='.$accesskey.'&secretkey='.$secretkey;
							$this->load->library('Mail');
							$this->mail->Mail_init('云热点');
							$data = array('url'=>$url);
							$body = $this->mail->getbody('forget',$data);
							$this->mail->send_mail($email,'我','[云热点]找回您的帐户密码',$body);

						}else{
							echo json_encode(array('status'=>"false",'message'=>"请填写云热点的注册邮箱!"));
						}

					}else{

						echo json_encode(array('status'=>"false",'message'=>"验证码错误!"));
					}				

				}

				if($op=="verifysent"){
					$accesskey = $this->input->get('accesskey');
					$secretkey = $this->input->get('secretkey');
					
					if(!$accesskey || !$secretkey){
						redirect('');
					}

					$sql = "SELECT p1.id,p1.uid,p1.type,p1.accesskey,p1.secretkey,p1.status,p1.addtime,p1.email,p2.password FROM ros_mail p1 LEFT JOIN ros_user p2 ON p1.uid = p2.id WHERE p1.accesskey='".$accesskey."' AND p1.secretkey='".$secretkey."' AND p2.id = p1.uid";

				
					
					$query = $this->db->query($sql);

					$result = $query->result_array();

					

					if(empty($result)){

						redirect('');
					}

				

					$now = time();

					$before = $result[0]['addtime'];

					$sec = $now - $before;
					
					$_mail= explode("@", $result[0]['email']);
					$mail_type = $_mail[1];
					switch ($mail_type) {
						case 'qq.com':
							$url = 'http://mail.qq.com';
							break;

						case '163.com':
							$url = 'http://mail.163.com/';
							break;

						case 'sina.com':
							$url = 'http://mail.sina.com/';
							break;

						case 'sina.cn':
							$url = 'http://mail.sina.com/';
							break;

						case 'sohu.com':
							$url = 'http://mail.sohu.com/';
							break;

						case 'gmail.com':
								$url = 'http://mail.gmail.com/';
								break;
						
						default:
							$url = "javascript:alert('未知的邮件服务商,请自行前往查收!');";
							break;
					}
					


					$data['url'] = $url;
					$mins = intval($sec/60);
					$data['user'] = $result[0];
					/*	if($mins<=60 && $result[0]['status']==0){*/
					if($mins<=1440 && $result[0]['status']==0){

						$this->load->view('user/email/verifysent', $data, FALSE);
						
					}else{
					
						//$this->load->view('user/result/error/resetpwd_b', $data, FALSE);
						redirect(site_url('user/email/active/error?accesskey='.$result[0]['accesskey']));
					}
					

				}

				if($op=="change"){

					if($this->input->post()){

						$email = $this->input->post('email');

						$query = $this->db->query("SELECT email FROM ros_user WHERE email='{$email}'");
						$_ret = $query->result_array();
						if(!empty($_ret) && $_ret[0]['email']==$email){
							echo json_encode(array('status'=>"false",'message'=>"邮箱地址已经被使用!"));
							exit();
						}
						$id = $this->_saler['id'];

						$sql = "SELECT id,password,truename FROM ros_user WHERE id='{$id}'";

						$query = $this->db->query($sql);

						$user = $query->result_array();
						
						$now = time();
						$accesskey = sha1($user[0]['id'].$email.$now);
						$secretkey = sha1($user[0]['id'].$user[0]['password'].$email);
						/*$salt = sha1($accesskey.$secretkey);*/
						$data = array(
							'uid'		=>	$user[0]['id'],
							'accesskey'	=>	$accesskey,
							'secretkey'	=>	$secretkey,				
							'email'		=>	$email,				
							'type'		=>	"change",
							'addtime'	=>	$now,
							);  

						$this->db->insert('ros_mail', $data);

						//echo $this->db->last_query();

						//$this->mail->send_mail('yb19901208.vlp@163.com','我','[云热点]找回您的帐户密码',$body);
						$_mail= explode("@", $email);
						/*var_dump($_mail);exit();*/
						$mail_type = $_mail[1];
						switch ($mail_type) {
							case 'qq.com':
								$url = 'http://mail.qq.com';
								break;

							case '163.com':
								$url = 'http://mail.163.com/';
								break;

							case 'sina.com':
								$url = 'http://mail.sina.com/';
								break;

							case 'sina.cn':
								$url = 'http://mail.sina.com/';
								break;

							case 'sohu.com':
								$url = 'http://mail.sohu.com/';
								break;

							case 'gmail.com':
								$url = 'http://mail.gmail.com/';
								break;
							
							default:
								# code...
								break;
						}

						
						$url = site_url('user/changemail/access').'?accesskey='.$accesskey.'&secretkey='.$secretkey;						
						$this->load->library('Mail');
						$this->mail->Mail_init('云热点');
						$data = array('url'=>$url,'truename'=>$user[0]['truename']);
						$body = $this->mail->getbody('change',$data);
						$this->mail->send_mail($email,'我','[云热点]激活邮箱帐户',$body);
						$to = site_url('user/email/verifysent').'?accesskey='.$accesskey.'&secretkey='.$secretkey;
						echo json_encode(array('status' =>'success' ,'url'=>$to));
						exit();
					}

					$this->load->view('user/email/change');
							
					
					
				}

				if($op=="active"){
					
					$type = $this->uri->segment(4);
				
					if($type=="access"){


						$accesskey = $this->input->get('accesskey');
						$secretkey = $this->input->get('secretkey');
						
						if(!$accesskey || !$secretkey){
							redirect('');
						}

						$sql = "SELECT p1.id,p1.uid,p1.type,p1.accesskey,p1.secretkey,p1.status,p1.addtime,p2.email,p2.password FROM ros_mail p1 LEFT JOIN ros_user p2 ON p1.uid = p2.id WHERE p1.accesskey='".$accesskey."' AND p1.secretkey='".$secretkey."' AND p2.id = p1.uid";

					
						
						$query = $this->db->query($sql);

						$result = $query->result_array();

						

						if(empty($result)){

							redirect('');
						}

					

						$now = time();

						$before = $result[0]['addtime'];

						$sec = $now - $before;
						
						$mins = intval($sec/60);
						$data['user'] = $result[0];
						
						//if($mins<=60 && $result[0]['status']==0){
						if($mins<=1440 && $result[0]['status']==0){
								
							$salt = sha1($result[0]['email'].$result[0]['password']);
							$sql = "UPDATE ros_user SET salt='".$salt."' WHERE id='".$result[0]['uid']."' AND email='".$result[0]['email']."'";
							$this->db->query($sql);
							
							$sql = "UPDATE ros_mail SET status='1' WHERE id='".$result[0]['id']."'";
							
							$this->db->query($sql);
						
							$this->load->view('user/email/active', $data, FALSE);
							
						}else{
							$this->load->view('user/email/error',$data);
							//$this->load->view('user/result/error/resetpwd_b', $data, FALSE);
							//redirect(site_url('user/email/active/error?accesskey='.$result[0]['accesskey']));
						}
					}
					



					

				}

			}

		}

		public function forget(){


			if($this->input->post()){
		      	$data = $this->input->post('data');

		      	$newpass = trim($data['password']);
		      	if(empty($data['password'])){
		      		echo json_encode(["status"=>"false","message"=>"请输入密码!"]);
					exit();
		      	}

		      	if(empty($data['account'])){
		      		echo json_encode(["status"=>"false","message"=>"请输入商户号!"]);
					exit();
		      	}

		      	if(empty($data['code'])){
		      		echo json_encode(["status"=>"false","message"=>"请输入验证码!"]);
					exit();
		      	}

		      	$account = trim($data['account']);
				$code = trim($data['code']);

				$salt = sha1($account.$code);
				$auth_code = $this->session->userdata('auth_code');
				$auth_user = $this->session->userdata('auth_user');
				$auth_salt = $this->session->userdata('auth_salt');

				$mail = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		        $phone ='/^(1(([123456789][0-9])|(47)|[8][0126789]))\d{8}$/';
		        $flag = false;		        
		        if(preg_match($mail,$account)){
		        	$type = 'email';
		        	$flag = true;			
		        }else if(preg_match($phone,$account)){
		        	$type = 'phone';
					$flag = true;
				} 

				if(!$flag){
					echo json_encode(["status"=>"false","message"=>"手机号码或邮箱地址错误!"]);
					exit();
				}

				$this->load->model('member_model');					
				if($type=='email'){
					$_user = $this->member_model->getone(array('email,username'),'user',array("email="=>$account));
				}elseif ($type=='phone') {
					$_user = $this->member_model->getone(array('email,username,cellphone'),'user',array("cellphone="=>$account));					
				}				

				if(empty($_user)){
		        	echo json_encode(array("status"=>"false","message"=>"用户不存在!"));												
					exit();
				}

				if($account==$auth_user && $code==$auth_code && $salt==$auth_salt){
						
			      	if($type=='email'){						
						$_user = $this->member_model->update(array('password'=>md5($newpass)),'user',array("email="=>$account));
					}elseif ($type=='phone') {
						$_user = $this->member_model->update(array('password'=>md5($newpass)),'user',array("cellphone="=>$account));					
					}	
					echo json_encode(['status'=>"success",'message'=>'重置完成!']);
				}else{
					echo json_encode(['status'=>"false"]);
				}
		     	
		      	exit();
		    }


		    $lang = $this->input->get('lang', TRUE);
       		$this->load->library('Lang', array('lang'=>$lang), 'Switch');
       		$data = $this->Switch->init('forget');	   			
			$this->load->library('twig');
			$this->twig->display('index/forget',$data);
		}

		public function emailVerify(){

		    $email = $this->input->post('email');
		   
		  
	        if($this->check($email)){
	          echo json_encode(['status'=>"false",'message'=>"邮箱地址已经注册,请直接登录!"]);
	          exit();
	        }


		   
		    $code ='';
		    for ($i=0; $i <6 ; $i++) { 
		        $code.=mt_rand(1,9);
		    }  


		    $session=Yaf_Session::getInstance();
		    $session->emailcode = $code;

			//获取用户信息
			$this->session->userdata('username');
			$this->_saler['salt'] = $this->session->userdata('salt');
			$this->_saler['id'] = $this->session->userdata('id');	
			$this->_saler['channel'] = $this->session->userdata('channel');

	    	$this->load->library('Mail');
			$this->mail->Mail_init('云热点');
			$data = array('url'=>$url);
			$body = $this->mail->getbody('forget',$data);
			$this->mail->send_mail($email,'我','[云热点]找回您的帐户密码',$body);


		    $body = $mail->getbody('verify',$code);
		    $mail->send_mail($email,'我','[云热点]商户帐户',$body);
		    echo json_encode(['status'=>"success"]);

		}


		private function check($email){

			$sql = "SELECT * FROM ros_user WHERE email='".$email."'";
					
			$query = $this->db->query($sql);

			$check = $query->result_array();

			
		    if($check && $check==$email){
		        return true;
		        exit();
		    }

		    return false;
		}

	}


?>