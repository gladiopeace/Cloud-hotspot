<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Component extends CI_Controller {
	
		public function index(){
			
		}

		public function singup(){

			$ops= array('display','post');

			$op = $this->uri->segment(3) ? $this->uri->segment(3) : "display";
			if(in_array($op, $ops)){
				if($op=='post'){

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
							$url = site_url('member/index');
							//echo json_encode(array("status"=>"notice","message"=>"已经注册成功,请直接登录!"));							
							echo json_encode(array("status"=>"success","url"=>$url));							
							exit();
						}


					}

				}

				if($op=='display'){
					$this->load->view('welcome/component/singup');
				}				

			}

			
		}		

		public function login(){

			$ops= array('display','post');

			$op = $this->uri->segment(3) ? $this->uri->segment(3) : "display";
			if(in_array($op, $ops)){
				
				if($op=='post'){

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

				if($op=='display'){
					$this->load->view('welcome/component/login');
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
				case 'singup': //用户注册

				$type = $this->input->post('type');

				switch ($type) {
					case 'username':
						$username = strtolower($this->input->post('email'));
						$this->load->model('member_model');
						$user = $this->member_model->getone(array('username'),'user',array('username'=>$username));
                        $message = array('status'=>'message');
						if(!empty($user) && $user['username']==$username)
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

				break;
			}



		}

		public function is_moble(){

			$flag=false;
			$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
			if(preg_match("/(iPhone|IOS|iPad|iPod|Android|Windows Phone|HTC)/i", $UA)){
			 	$flag=true;
				return $flag;
			}
		}


	}
	
	/* End of file Component.php */
	/* Location: ./application/controllers/Component.php */

?>
