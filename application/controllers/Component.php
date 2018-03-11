<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Component extends CI_Controller {
	
		public function index(){
			
		}

		public function singup(){

		

			if($this->input->post()){

				$email = $this->input->post('email');
				$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		        if (!preg_match($pattern,$email)){
		        	echo json_encode(array("status"=>"false","type"=>"Email","message"=>"邮件地址格式错误!"));
					exit();
		        }

				$passwd = $this->input->post('password');

				$confirm = $this->input->post('confirm');
				if(strlen($passwd)<6){
					echo json_encode(array("status"=>"false","type"=>"Passwd","message"=>"密码不得小于六位!"));
					exit();
				}

				if($passwd!=$confirm){
		        	echo json_encode(array("status"=>"false","type"=>"Confirm","message"=>"密码不一致!"));
					exit();
				}

				$this->load->model('member_model');

				$_user = $this->member_model->getone(array('email,username'),'user',array("username ='{$email}' OR email="=>$email));

				if(!empty($_user) && $username == $_user['0']['username']){
		        	echo json_encode(array("status"=>"notice","message"=>$email."已经注册,请直接登录."));
					exit();
				}

				$ak = sha1(time().$email);
				$sk = sha1(time().sha1($email.$passwd));

				$data = array(
					'username'	=>	$email,
					'password'	=>	md5($passwd),
					'email'		=>	$email,
					'level'		=>	'4',
					'vip'		=>	'1',
					'message'	=>	'10',
					'accesskey'	=>$ak,
					'secretkey'	=>$sk,
					'addtime'	=>	time(),
					);
				$res = $this->member_model->insert_data('user',$data,'id');
				$this->load->library('session');
				$salt = sha1($data['username'] . $data['password']);//生成加密的票据
				$newdata = array(
                   'username'  	=> $data['username'],
                   'salt'     	=>  $salt,
                   'id' 		=> $res,
               );

				$this->session->set_userdata($newdata);

				if($res){
					$url = site_url('manage/index');					
					echo json_encode(array("status"=>"success","url"=>$url));
					exit();
				}


			}
			
		}		

		public function login(){

			$ops= array('display','post');

			$op = $this->uri->segment(3);
			if(!in_array($op, $ops)) exit();
				
			if($op=='post' && $this->input->post()){

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

			}


			

			
		}



		public function userinfo(){

			$id = $this->uri->segment(3);
			$this->load->helper('js');
		
			$this->load->model('member_model');
			$user =$this->member_model->getone(array("*"),"openqq",array("id"=>$id));
			
			$data['profile'] = $user['0'];
			
			$this->load->view('welcome/component/open', $data, FALSE);	
			
			
		}





		public function open(){

			$type = $this->uri->segment(3);

			if($type=="post"){

				$opentype = $this->input->post('type');

				if($opentype=="new"){
					$this->load->model('member_model');	

					$email = $this->input->post('email');

					$_user = $this->member_model->getone(array('email,username'),'user',array("username ='{$email}' OR email="=>$email));

					if(!empty($_user) && $email == $_user['0']['email']){
			        	echo json_encode(array("status"=>"notice","message"=>$email."已经注册,请直接登录."));							
						exit();
					}
				
					$passwd = $this->input->post('password');
					$_id = $this->input->post('id');

					$user = $this->member_model->getone(array("*"),"openqq",array("id"=>$_id));
					if(empty($user)){
						echo json_encode(array("status"=>"notice","message"=>"非法访问!"));	
						exit();
					}
					$ak = sha1(time().$email);
					$sk = sha1(time().sha1($email.$passwd));
					
					$data = array(
						'username'	=>	$email,
						'password'	=>	md5($passwd),
						'nickname'	=>	$user[0]['nickname'],
						'gender'	=>	$user[0]['gender'],
						'thumb'		=>	$user[0]['thumb'],
						'year'		=>	$user[0]['year'],
						'province'	=>	$user[0]['province'],
						'city'		=>	$user[0]['city'],
						'email'		=>	$email,
						'message'	=>	'10',
						'level'		=>	'4',
						'vip'		=>	'1',
						'accesskey'	=>$ak,
						'secretkey'	=>$sk,
						'addtime'	=>	time(),
						);

					$id = $this->member_model->insert_data('user',$data,'id');

					$res = $this->member_model->update(array('oid'=>$id,'email'=>$email),"openqq",array("id"=>$_id));

					if($res==1){
						$salt = sha1($email . $passwd);//生成加密的票据
						$this->load->library('session');

						$newdata = array(
		                   'username'  => $email,
		                   'salt'     =>  $salt,
		                   'id' => $id,
		               );

						//$this->sessionb->set($newdata);
						$this->session->set_userdata($newdata);
						//$this->push($$data['username']);	
						echo json_encode(array("status"=>"ok"));
					}
											
						
				

				}

				if($opentype=="bind"){

					$email = $this->input->post('email');
					$passwd = md5($this->input->post('password'));
					$this->load->model('member_model');	
					$_user = $this->member_model->getone(array("id",'email',"username"),'user',array("password"=>$passwd,"username"=>$email));
					
					if(empty($_user)){
						$_user = $this->member_model->getone(array('id','username','email'),'user',array("password"=>$passwd,"email"=>$email));

					}

					if(!empty($_user)){
						
						$_id = $this->input->post('id');

						$salt = sha1($email . $passwd);//生成加密的票据
						$this->load->library('session');

						$newdata = array(
		                   'username'  => $email,
		                   'salt'     =>  $salt,
		                   'id' => $_user[0]['id']
		               );

						//$this->sessionb->set($newdata);
						$this->session->set_userdata($newdata);
						//$this->push($_user[0]['username']);
						$this->member_model->update(array("oid"=>$_user[0]['id'],"email"=>$email),'openqq',array("id"=>$_id));
						echo json_encode(array("status"=>"ok","message"=>"success!"));
						
					}else{
				        echo json_encode(array("status"=>"notice","message"=>"用户名或密码错误!"));							
						
					}
					

					
				}


			}
			


		}

		public function ajax(){

			$model = $this->uri->segment(3);

			switch ($model) {
				case 'sigup': //用户注册

				$type = $this->input->post('type');
				$account = trim($this->input->post('account'));
				if($type){
					switch ($type) {
						case 'username':
							$username = strtolower($this->input->post('email'));
							$this->load->model('member_model');


							$phone ='/^(1(([123456789][0-9])|(47)|[8][0126789]))\d{8}$/';
							$type = 'username';
					       	        
					       	if(preg_match($phone,$username)) $type = 'phone';	

							$this->load->model('member_model');					
							if ($type=='phone') {
								$user = $this->member_model->getone(array('email,username,cellphone'),'user',array("cellphone"=>$username));					
							}else{
								$user = $this->member_model->getone(array('username'),'user',array('username'=>$username));
							}		
							/*echo $this->db->last_query();
							var_dump($user);*/

							
	                        $message = array('status'=>'message');
							if(!empty($user))
	                            $message = array('status'=>'ok');
							echo json_encode($message);

							break;

						
						case 'email':
							$email = $this->input->post('email');
							$this->load->model('member_model');
							$_email = $this->member_model->getone(array('email'),'user',array("username ='{$email}' OR email="=>$email));
	                        $message = array('status'=>'message');
							if(!empty($_email) && $_email['email']==$email)
	                            $message = array('status'=>'ok');
							echo json_encode($message);

							break;
						
						default:
							# code...
							break;
					}
				}

			
				if($account){

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
						echo json_encode(["status"=>"false","message"=>"格式错误!"]);
						exit();
					}

					$this->load->model('member_model');					
					if($type=='email'){
						$_user = $this->member_model->getone(array('email,username,cellphone'),'user',array("email"=>$account));
					}elseif ($type=='phone') {
						$_user = $this->member_model->getone(array('email,username,cellphone'),'user',array("cellphone"=>$account));					
					}				

					if(!empty($_user)){
						if($type=='email' && $account == $_user['email']){
			        		echo json_encode(array("status"=>"message","message"=>$account."已经注册,请直接登录."));							
						}elseif($type=='phone' && $account == $_user['cellphone']){
			        		echo json_encode(array("status"=>"message","message"=>$account."已经注册,请直接登录."));													
						}
						exit();
					}else{
						echo json_encode(array("status"=>"ok","message"=>"可以注册!"));
						exit();
					}

				}							
				

				break;
			}



		}
		public function register(){

			if(!$this->input->post()) exit();			
		
			$code = trim($this->input->post('verify'));
			$passwd = $this->input->post('password');
			$confirm = $this->input->post('confirm');
			$account = trim($this->input->post('account'));

			$mail = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	        $phone ='/^(1(([123456789][0-9])|(47)|[8][0126789]))\d{8}$/';
	        $flag = false;		        
	        if(preg_match($mail,$account)){
	        	$type = 'email';
	        	$flag = true;			
	        }else if(preg_match($phone,$account)){
	        	$type = 'cellphone';
				$flag = true;
			} 
			
			if(!$flag){
				echo json_encode(["status"=>"false","message"=>"手机号码或邮箱地址错误!"]);
				exit();
			}	
		
			if(strlen($passwd)<6){
				echo json_encode(array("status"=>"false","message"=>"密码不得小于六位!"));
				exit();
			}
			
			if($passwd!=$confirm){
	        	echo json_encode(array("status"=>"false","message"=>"密码不一致!"));
				exit();
			}


			$this->load->library('session');

	        $salt = sha1($account.$code);
	        $auth_salt = $this->session->userdata('auth_salt');
	        $auth_user = $this->session->userdata('auth_user');
	        $auth_code = $this->session->userdata('auth_code');
	        
	        if($account!=$auth_user || $code!=$auth_code || $salt!=$auth_salt){
	        	echo json_encode(array("status"=>"false","message"=>"验证码不正确!"));
	        	exit();
	        }

	        $this->load->model('member_model');					
			if($type=='email'){
				$_user = $this->member_model->getone(array('email,username'),'user',array("username ='{$account}' OR email="=>$account));
			}elseif ($type=='cellphone') {
				$_user = $this->member_model->getone(array('email,username'),'user',array("username ='{$account}' OR cellphone="=>$account));					
			}				

			if(!empty($_user) && $account == $_user['username']){
	        	echo json_encode(array("status"=>"false","message"=>$account."已经注册,请直接登录."));							
				exit();
			}	

			$ak = sha1(time().$account);
			$sk = sha1(time().sha1($account.$passwd));
			
			$data = array(
				'username'	=>	$account,
				'password'	=>	md5($passwd),
				"{$type}"	=>	$account,
				'level'		=>	'4',
				'vip'		=>	'1',
				'message'	=>	'10',
				'accesskey'	=>$ak,
				'secretkey'	=>$sk,
				'addtime'	=>	time(),
				);
			$res = $this->member_model->insert_data('user',$data,'id');
		
			$salt = sha1($data['username'] . $data['password']);//生成加密的票据
			$newdata = array(
               'username'  	=> $data['username'],
               'salt'     	=>  $salt,
               'id' 		=> $res,
           );
			
			$this->session->set_userdata($newdata);

			if($res){
				$url = site_url('manage/index');
				//echo json_encode(array("status"=>"notice","message"=>"已经注册成功,请直接登录!"));							
				echo json_encode(array("status"=>"success","url"=>$url));							
				exit();
			}

		

			

		}

		public function restByCode(){

			$op = $this->uri->segment(3);
			if(!in_array($op, ['get','auth'])) exit();
			$this->load->library('session');
			if($op=='get'){
				$account = trim($this->input->post('account'));
				
				$mail = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		        $phone ='/^(1(([12345678][0-9])|(47)|[8][0126789]))\d{8}$/';
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

				$this->load->model('Member_model');					
				if($type=='email'){
					$_user = $this->Member_model->getone(array('email,username'),'user',array("email="=>$account));
				}elseif ($type=='phone') {
					$_user = $this->Member_model->getone(array('email,username,cellphone'),'user',array("cellphone="=>$account));					
				}				

				if(empty($_user)){
		        	echo json_encode(array("status"=>"false","message"=>"用户不存在!"));												
					exit();
				}

				$code='';
				for ($i=0; $i <6 ; $i++) { 
					$code.=mt_rand(0,9);# code...
				}

				$newdata = array(
                   'auth_user'  	=> $account,
                   'auth_salt'  	=> sha1($account.$code),
                   'auth_code' 		=> $code,
               	);
					
				$this->session->set_userdata($newdata);
				if($type=='email'){

     				$emailSystem = $this->Member_model->Email_Account_Get();
     				if(empty($emailSystem)){
     					$ret = array('status'=>'false','message'=>'Please Config your Email');
     					echo json_encode($ret);
     					exit();
     				}

					$this->load->library('Mail');
					$this->mail->Mail_init('Cloud-hotspot',$emailSystem);
					$body = $this->mail->getbody('verify',array('code'=>$code));
					$this->mail->send_mail($account, '我','请查收邮箱验证码', $body);
				
				}elseif($type=='phone'){


					$this->load->model('Portal_model');
	                $system = $this->Portal_model->QcloudAliyunSms();

	                if(!$system){
	                    echo json_encode(['status'=>'system_error','message'=>'Please Contact the network administrator.Please fill your SMS Server!','code'=>-8]);
	                    exit();
	                    //'code'=>-4,  //code -1 //account password was wrong. -4 //account was wrong. -5 //verify code was wrong! -6//The Account has expired
	                }

	                $num = count($system);
	                $index = mt_rand(1,$num);
	                $config = $system[$index];

	                $this->Portal_model->create('message_code',array('salt'=>'reset','mac'=>$account,'content'=>'验证码:'.$code,'cellphone'=>$account,'code'=>$code,'status'=>"1",'expired'=>time()+3600,'addtime'=>time()));
	                $this->load->library('Sms', $config);
	                if($config['type']=='qcloud-sms'){
	                    $result =  $this->sms->QcloudSms($account,$code);
	                }elseif($config['type']=='aliyun-sms'){
	                    $result = $this->sms->AliyunSms($account,$code);
	                }

				}
				echo json_encode(['status'=>'success','message'=>"验证码已发送至".$account,'code'=>$code]);
			}

			if($op=='auth'){
				$email = trim($this->input->post('account'));
				$code = trim($this->input->post('verify'));
				$salt = sha1($email.$code);
				$auth_code = $this->session->userdata('auth_code');
				$auth_email = $this->session->userdata('auth_user');
				$auth_salt = $this->session->userdata('auth_salt');

				if($email==$auth_email && $code==$auth_code && $salt==$auth_salt){
					echo json_encode(['status'=>"success",'auth_salt'=>$auth_salt]);
				}else{
					echo json_encode(['status'=>"false"]);
				}
			}

		}

		public function verifyCode(){


			$op = $this->uri->segment(3);
			if(!in_array($op, ['get','auth','united'])) exit();
			$this->load->library('session');
			if($op=='get'){
				$account = trim($this->input->post('account'));
				
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

				$this->load->model('Member_model');					
				if($type=='email'){
					$_user = $this->Member_model->getone(array('email,username'),'user',array("email="=>$account));
				}elseif ($type=='phone') {
					$_user = $this->Member_model->getone(array('email,username,cellphone'),'user',array("cellphone="=>$account));					
				}				

				if(!empty($_user)){
		        	//echo json_encode(array("status"=>"false","message"=>$account."已经注册,请直接登录."));							
					if($type=='email' && $account == $_user['0']['email']){
		        		echo json_encode(array("status"=>"message","message"=>"已经注册,请直接登录."));							
					}elseif($type=='phone' && $account == $_user['0']['cellphone']){
		        		echo json_encode(array("status"=>"message","message"=>"已经注册,请直接登录."));													
					}
					exit();

				}

				$code='';
				for ($i=0; $i <6 ; $i++) { 
					$code.=mt_rand(0,9);# code...
				}

				$newdata = array(
                   'auth_user'  	=> $account,
                   'auth_salt'  	=> sha1($account.$code),
                   'auth_code' 		=> $code,
               	);
					
				$this->session->set_userdata($newdata);
				if($type=='email'){

     				$emailSystem = $this->Member_model->Email_Account_Get();
     				if(empty($emailSystem)){
     					$ret = array('status'=>'false','message'=>'Please Config your Email');
     					echo json_encode($ret);
     					exit();
     				}

					$this->load->library('Mail');
					$this->mail->Mail_init('Cloud-hotspot',$emailSystem);


					$body = $this->mail->getbody('verify',array('code'=>$code));
					$this->mail->send_mail($account, '我','请查收邮箱验证码', $body);
				
				}elseif($type=='phone'){

					$this->load->model('Portal_model');
	                $system = $this->Portal_model->QcloudAliyunSms();

	                if(!$system){
	                    echo json_encode(['status'=>'system_error','message'=>'Please Contact the network administrator.Please fill your SMS Server!','code'=>-8]);
	                    exit();	                    
	                }

	                $num = count($system);
	                $index = mt_rand(1,$num);
	                $config = $system[$index];
	                //var_dump($config);exit();
	                $this->Portal_model->create('message_code',array('salt'=>'sigup','mac'=>$account,'content'=>'验证码:'.$code,'cellphone'=>$account,'code'=>$code,'status'=>"1",'expired'=>time()+3600,'addtime'=>time()));
	                $this->load->library('Sms', $config);
	                if($config['type']=='qcloud-sms'){
	                    $result =  $this->sms->QcloudSms($account,$code);
	                }elseif($config['type']=='aliyun-sms'){
	                    $result = $this->sms->AliyunSms($account,$code);
	                }
					
				}
				echo json_encode(['status'=>'success','message'=>"验证码已发送至".$account,'code'=>$code]);
			}

			if($op=='auth'){
				$email = trim($this->input->post('account'));
				$code = trim($this->input->post('verify'));
				$salt = sha1($email.$code);
				$auth_code = $this->session->userdata('auth_code');
				$auth_email = $this->session->userdata('auth_user');
				$auth_salt = $this->session->userdata('auth_salt');

				if($email==$auth_email && $code==$auth_code && $salt==$auth_salt){
					echo json_encode(['status'=>"success",'auth_salt'=>$auth_salt]);
				}else{
					echo json_encode(['status'=>"false"]);
				}
			}


            if($op=='united'){
                $account = trim($this->input->post('account'));

                $mail = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
                $phone ='/^(1(([357][0-9])|(47)|[8][0126789]))\d{8}$/';
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
              

                $code='';
                for ($i=0; $i <6 ; $i++) {
                    $code.=mt_rand(0,9);# code...
                }

                $newdata = array(
                    'auth_user'  	=> $account,
                    'auth_salt'  	=> sha1($account.$code),
                    'auth_code' 		=> $code,
                );

                $this->session->set_userdata($newdata);
                if($type=='email'){

                    $this->load->library('Mail');
                    $this->mail->Mail_init('优思收银');
                    $body = $this->mail->getbody('verify',array('code'=>$code));
                    $this->mail->send_mail($account, '我','请查收优思收银邮箱验证码', $body);

                }elseif($type=='phone'){
                    $this->load->library('Sms');
                    $this->sms->QcloudSms($account,$code);
                }
                echo json_encode(['status'=>'success','message'=>"验证码已发送至".$account,'code'=>$code]);
            }

		}

		public function verifyEmail(){


			$op = $this->uri->segment(3);
			if(!in_array($op, ['get','auth'])) exit();
			$this->load->library('session');
			if($op=='get'){
				$email = trim($this->input->post('email'));
				

				$this->load->model('member_model');					

				$_user = $this->member_model->getone(array('email,username'),'user',array("username ='{$email}' OR email="=>$email));

				if(!empty($_user) && $email == $_user['email']){
		        	echo json_encode(array("status"=>"false","message"=>$email."已经注册,请直接登录."));							
					exit();
				}


				$this->load->library('Mail');
				$this->mail->Mail_init('Cloud-hotspot');
				$code='';
				for ($i=0; $i <6 ; $i++) { 
					$code.=mt_rand(0,9);# code...
				}
				


				$newdata = array(
                   'auth_email'  	=> $email,
                   'auth_salt'  => sha1($email.$code),
                   'auth_code' 		=> $code,
               	);
					
				$this->session->set_userdata($newdata);

				$body = $this->mail->getbody('verify',array('code'=>$code));
				$this->mail->send_mail($email, '我','请查收邮箱验证码', $body);
				echo json_encode(['status'=>'success','message'=>"验证码已发送至".$email]);
			}

			if($op=='auth'){
				$account = trim($this->input->post('account'));
				$code = trim($this->input->post('code'));
				$salt = sha1($account.$code);
				$auth_code = $this->session->userdata('auth_code');
				$auth_user = $this->session->userdata('auth_user');
				$auth_salt = $this->session->userdata('auth_salt');

				if($account==$auth_user && $code==$auth_code && $salt==$auth_salt){
					echo json_encode(['status'=>"success",'auth_salt'=>$auth_salt]);

				}else{
					echo json_encode(['status'=>"false"]);
				}
			}

		}



	}
	
	/* End of file Component.php */
	/* Location: ./application/controllers/Component.php */

?>
