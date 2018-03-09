<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class portal extends CI_Controller {

		private $lock = array();

	    function __construct() {
	        parent::__construct();
	        $this->lock = $_COOKIE;		
	    }		
		
		public function init(){

			$data = $_REQUEST;//$this->input->raw_input_stream();
	    	$this->load->library('twig');
            $this->twig->setPath();
			$this->twig->display('init/init.html',array('result'=>$data));
		}

        public function index(){
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
           /*var_dump($data);
            exit();*/
            $this->load->library('twig');
            $this->twig->setPath();
            $this->twig->display($data['themes'], $data);
        }
		public function api(){
			$op = $this->uri->segment(3);
			if(!in_array($op, array('init','login','config'))) die();
			
			$post = $this->input->post();
			if($op=='login'){
		
				$where = array(
					'salt' => $post['salt'],
					'id' => $post['id'],
					'uid' => $post['uid']
					);
				$this->load->model('portal_model');
				$bech = $this->portal_model->branch($where);
				$result = array(
						'username'	=>$bech['access_info']['username'],
						'password'	=>$bech['access_info']['password'],				
					);
				echo json_encode($result);

			}

			if($op=='init'){
					$mac = $post["mac"];
					$salt = $post['accesskey'];

                    $where = array('accesskey'=>$salt);

					$this->load->model('Portal_model');
					$access_info = $this->Portal_model->wecaht_wifi($where);
											
					$ssid=$access_info['ssid'];
					$bssid =$access_info['bssid'];

					$appid =$access_info['appid'];
					$shopid =$access_info['shopid'];
					$secretkey =$access_info['secretkey'];

					$authurl  = site_url('portal/component/init/?mac='.$mac);
				
					$extend = $ssid;
					//生成时间截
					$time = explode ( " ", microtime () );
				    $time = $time [1] . ($time [0] * 1000);
				    $time2 = explode ( ".", $time );
				    $timestamp = $time2 [0];

				    $sign = md5($appid.$extend.$timestamp.$shopid.$authurl.$mac.$ssid.$bssid.$secretkey);
					
				    $ret = array(
				    		'authurl'=>$authurl,
				    		'sign'=>$sign,
				    		'extend'=>$extend,
				    		'timestamp'=>$timestamp,
				    		'appid'=>$appid,
				    		'shopid'=>$shopid,
				    		'secretkey'=>$secretkey,
				    		'mac'=>$mac,
				    		'ssid'=>$ssid,
				    		'bssid'=>$bssid,
				    	);				  

				    echo json_encode($ret);

			}


            if($op=='config'){
                $accesskey = $this->input->post('accesskey');
                $this->load->model('Portal_model');
                $data = $this->Portal_model->config($accesskey);
                echo json_encode($data);
            }
			

		}

        public function TextTokenSalt(){
            header('Access-Control-Allow-Origin:*');
            $salt = $this->input->get_post('accesskey');
            $mac = $this->input->get_post('mac');
            $authCode = $this->input->get_post('auth_code');
            if(false==$authCode || false==$salt || false==$mac){
                echo json_encode(array('status'=>0,'message'=>'Access Deny'));
                exit();
            }
            $this->load->model('Portal_model');
            $data = $this->Portal_model->textSaltToken($authCode,$salt,$mac);
            echo json_encode($data);

            //$where = array('salt'=>$salt);
            //$data = $this->Portal_model->branch($where);
            //$data = $this->Portal_model->textSaltToken($authCode,$salt,$mac);
            //$data = $this->branch($where);
            /*$this->load->library('Aes');
            $ip = $data["access_info"]['ip'];
            $pass  = md5('mikrotik');
            $username = $this->aes->encrypt($data["access_info"]['username'],$pass);
            $password = $this->aes->encrypt($data["access_info"]['password'],$pass);
            $url = $data["access_info"]['url'];
            $type = $data['type'];
            $wechat = array();
            if($type=='wechat'){
                $where = array('accesskey'=>$salt);
                $access_info = $this->Portal_model->wecaht_wifi($where);
                $ssid=$access_info['ssid'];
                $bssid =$access_info['bssid'];
                $appid =$access_info['appid'];
                $shopid =$access_info['shopid'];
                $secretkey =$access_info['secretkey'];
                $authurl  = site_url('portal/component/init/?mac='.$mac);
                $extend = $ssid;
                //生成时间截
                $time = explode ( " ", microtime ());
                $time = $time [1] . ($time [0] * 1000);
                $time2 = explode ( ".", $time );
                $timestamp = $time2 [0];
                $sign = md5($appid.$extend.$timestamp.$shopid.$authurl.$mac.$ssid.$bssid.$secretkey);
                $wechat = array(
                    'authurl'=>$authurl,
                    'sign'=>$sign,
                    'extend'=>$extend,
                    'timestamp'=>$timestamp,
                    'appid'=>$appid,
                    'shopid'=>$shopid,
                    'secretkey'=>$secretkey,
                    'ssid'=>$ssid,
                    'mac'=>$mac,
                    'bssid'=>$bssid,
                );
            }

            $data = array(
                'type'=> $type,
                'wechat'=>$wechat,
                'ip'=>$ip,
                'username'=>$username,
                'password'=>$password,
                'url'=>$url,
                'pass'=>$pass,
            );*/

            //echo json_encode($data);
        }

        public function verify(){
           
            $salt = $this->input->get_post('accesskey');

            $verify_type = $this->uri->segment(3);

            $auth_flag = false;
            $authMessage = 'access deny';
            if($verify_type=='cellphone-code'){

                $cellphone = $this->input->get_post('cellphone');
                $verifyCode = $this->input->get_post('code');
                $authCode = $this->input->get_post('auth_code');
                $mac = $this->input->get_post('mac');
                $this->load->model('Portal_model');


                if(!preg_match("/1[34578]{1}\d{9}$/",$cellphone)){
                    $status = 'notice';
                    $access_code ='-5';
                    echo json_encode(array('status'=>$status,'code'=>$access_code));
                    exit();
                }

                $salt = $this->input->get_post('accesskey');
                $this->load->model('Portal_model');
                $where = [
                    'code'      => $verifyCode,
                    'salt'      => $salt,
                    'cellphone' => $cellphone,
                    'expired >='=>time(),
                ];
                $this->load->model('Portal_model');
                $result = $this->Portal_model->first(["code"],'message_code',$where);
                if(!empty($result) && $result['code']==$verifyCode){

                    $result = $this->Portal_model->first(["access_code"],'access_auth',['accesskey'=>$salt,'access_code'=>$authCode]);

                    if(false==$result && $result['access_code']!=$authCode){
                        $status = 'notice';
                        $code ='-1';
                        echo json_encode(['status'=>$status,'code'=>$code]);
                        exit();

                    }
                    $auth_flag = true;
                }else{
                    $status = 'notice';
                    $code ='-1';
                    echo json_encode(['status'=>$status,'code'=>$code]);
                    exit();
                }




            }elseif($verify_type=='member-auth'){


                $salt = $this->input->get_post('accesskey');
                $username = $this->input->get_post('username');
                $password = $this->input->get_post('password');
                $mac = $this->input->get_post('mac');
                $authCode = $this->input->get_post('auth_code');
                $where = array(
                    'accesskey'     =>$salt,
                    'username'  => trim($username),
                    'password'  => md5(trim($password)),
                );

                $this->load->model('Portal_model');
                $account =  $this->Portal_model->first(["*"],'hotspot_users',$where);

                if(!empty($account) && $account['username']==$where['username'] && $account['password']==$where['password']){

                    if(strtotime("+ 1 day",$account['end_time'])<time()){
                        $echo = array(
                            'status'=>'false',
                            'message'=>"用户已经过期!",
                            'code'=>-6,
                        );
                        echo json_encode($echo);
                        exit();

                    }else{
                        $result = $this->Portal_model->first(["access_code"],'access_auth',['accesskey'=>$salt,'access_code'=>$authCode]);

                        if(false==$result && $result['access_code']!=$authCode){
                            $status = 'notice';
                            $code ='-1';
                            echo json_encode(['status'=>$status,'code'=>$code]);
                            exit();

                        }
                        $auth_flag = true;
                    }

                }else{
                    $echo = array(
                        'status'=>"false",
                        'code'=>-1,  //code -1 //account password was wrong. -4 //account was wrong. -5 //verify code was wrong! -6//The Account has expired
                        'message'=>"用户名或密码错误!"
                    );
                    echo json_encode($echo);
                    exit();

                }



            }elseif ($verify_type=='wechat-auth') {

                $authCode = $this->input->get_post('auth_code');
                $mac = $this->input->get_post('mac');
                $this->load->model('Portal_model');
                $auth =$this->Portal_model->first(['access_code','accesskey'],'access_auth',['access_code'=>$authCode,'accesskey'=>$salt]);
                if(!empty($auth) && $auth['access_code']==$authCode && $salt==$auth['accesskey']) $auth_flag = true;
                //var_dump($auth);
            }

            if(!$auth_flag){
                $ret = array('status'=>'false','message'=>$authMessage);
                echo json_encode($ret);
                exit();
            }          

            $this->load->model('Portal_model');
            $data = $this->Portal_model->branch(array('salt'=>$salt));

            $ip = $data["access_info"]['ip'];
            $url = $data["access_info"]['url'];
            $data = array(
                'type'=> $data['type'],
                'ip'=>$ip,
                'url'=>$url,
                'code'=>1,
                'status'=>'success',

            );
            echo json_encode($data);


   

        }

        public function auth(){
            header('Access-Control-Allow-Origin:*');
            $op = $this->uri->segment(3);
            $ops = array('fetch-code-cellphone','verify-code-cellphone','fetch-member-account','fetch-wechat-code');
            if(!in_array($op, $ops)) die();

            if($op=='fetch-code-cellphone'){

                $cellphone = $this->input->get_post('cellphone');

                if(!preg_match("/1[34578]{1}\d{9}$/",$cellphone)){
                    $status = 'notice';
                    $access_code ='-5';
                    echo json_encode(array('status'=>$status,'code'=>$access_code));
                    exit();
                }

                $salt = $this->input->get_post('accesskey');
                $mac = $this->input->get_post('mac');
                $code='';
                for ($i=0; $i <6 ; $i++) {
                    $code.=mt_rand(0,9);# code...
                }

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

                $this->Portal_model->create('message_code',array('salt'=>$salt,'mac'=>$mac,'content'=>'验证码:'.$code,'cellphone'=>$cellphone,'code'=>$code,'status'=>"1",'expired'=>time()+3600,'addtime'=>time()));
                $this->load->library('Sms', $config);
                if($config['type']=='qcloud-sms'){
                    $result =  $this->sms->QcloudSms($cellphone,$code);
                }elseif($config['type']=='aliyun-sms'){
                    $result = $this->sms->AliyunSms($cellphone,$code);
                }
                echo json_encode(['status'=>'success','message_code'=>$code,'code'=>1]);

            }

            if($op=='verify-code-cellphone'){
                $cellphone = $this->input->get_post('cellphone');
                $mac = $this->input->get_post('mac');
                if(!preg_match("/1[34578]{1}\d{9}$/",$cellphone)){
                    $status = 'notice';
                    $access_code ='-5';
                    echo json_encode(array('status'=>$status,'code'=>$access_code));
                    exit();
                }

                $password = $this->input->get_post('password');

                $salt = $this->input->get_post('accesskey');
                $this->load->model('Portal_model');
                $where = [
                    'code'      => $password,
                    'salt'      => $salt,
                    'cellphone' => $cellphone,
                    'expired >='=>time(),
                ];
                $this->load->model('Portal_model');
                $result = $this->Portal_model->first(["code"],'message_code',$where);
                if(!empty($result) && $result['code']==$password){
                    $status = 'success';
                    $code = 1;
                    $access_code = mt_rand(1,9).uniqid();
                    $insert_data = ['accesskey'=>$salt,'access_code'=>$access_code,'request_data'=>json_encode($result),'auth_type'=>'verify-code-cellphone'];
                    $this->Portal_model->create('access_auth',$insert_data);

                }else{
                    $status = 'notice';
                    $code ='-1';
                }
                //echo -5;//
                echo json_encode(array('status'=>$status,'access_code'=>$access_code,'code'=>$code));
            }

            if($op=='fetch-member-account'){


                $accesskey = $this->input->get_post('accesskey');
                $username = $this->input->get_post('username');
                $password = $this->input->get_post('password');
                $mac = $this->input->get_post('mac');
                $where = array(
                    'accesskey'     =>$accesskey,
                    'username'  => trim($username),
                    'password'  => md5(trim($password)),
                );

                $this->load->model('Portal_model');
                $account =  $this->Portal_model->first(["*"],'hotspot_users',$where);

                if(!empty($account) && $account['username']==$where['username'] && $account['password']==$where['password']){

                    if(strtotime("+ 1 day",$account['end_time'])<time()){
                        $echo = array(
                            'status'=>'false',
                            'message'=>"用户已经过期!",
                            'code'=>-6,
                        );
                        
                    }else{
                        $access_code = mt_rand(1,9).uniqid();
                        $insert_data = ['accesskey'=>$accesskey,'access_code'=>$access_code,'request_data'=>json_encode($account),'auth_type'=>'fetch-member-account'];
                        $this->Portal_model->create('access_auth',$insert_data);
                        $echo = array(
                            'status'=>"success",
                            'message'=>"success",
                            'code'=>1,
                            'access_code'=>$access_code
                        );
                    }

                    
                }else{
                    $echo = array(
                        'status'=>"false",
                        'code'=>-1,  //code -1 //account password was wrong. -4 //account was wrong. -5 //verify code was wrong! -6//The Account has expired
                        'message'=>"用户名或密码错误!"
                    );
                 
                }

                echo json_encode($echo);
            }

            if($op=='fetch-wechat-code'){
                $accesskey = $this->input->get_post('accesskey');
                $mac = $this->input->get_post('mac');
                $this->load->model('Portal_model');
                $access_code = mt_rand(1,9).uniqid();
                $insert_data = ['accesskey'=>$accesskey,'access_code'=>$access_code,'request_data'=>json_encode($mac),'device_mac'=>$mac,'auth_type'=>'fetch-wechat-code'];
                $this->Portal_model->create('access_auth',$insert_data);
                $echo = array(
                    'status'=>"success",
                    'message'=>"success",
                    'access_code'=>$access_code
                );
                echo json_encode($echo);
            }


        }

        public function status(){
            echo 'success';
        }



		public function component(){

			$op = $this->uri->segment(3);

			if(!in_array($op, array('init','verify','account'))) die();


			if($op=='init'){
				$key = $this->input->post('accesskey');
				echo 'success';
	    		//redirect($url,'refresh');

			}

			if($op=='account'){

                $accesskey = $this->input->get_post('accesskey');
                $username = $this->input->get_post('username');
                $password = $this->input->get_post('password');
                $where = array(
                    'accesskey'		=>$accesskey,
                    'username'	=> trim($username),
                    'password'	=> md5(trim($password)),
                );

                $this->load->model('Portal_model');
                $account =  $this->Portal_model->first(["*"],'hotspot_users',$where);

                if($account['username']==$where['username'] && $account['password']==$where['password']){

                    if(strtotime("+ 1 day",$account['end_time'])<time()){
                        echo json_encode(array('status'=>'false','message'=>"用户已经过期!"));
                        exit();
                    }
                    $access_code = mt_rand(1,9).uniqid();
                    $insert_data = ['accesskey'=>$accesskey,'access_code'=>$access_code,'request_data'=>json_encode($account)];
                    $this->Portal_model->create('access_auth',$insert_data);
                    echo json_encode(array('status'=>"success",'message'=>"success",'access_code'=>$access_code));
                }else{
                    echo json_encode(array('status'=>"false",'message'=>"用户名或密码错误!"));
                }

            }
			

		}

		public function ajax(){

            $op = $this->uri->segment(3);

            if($op=='fetch-code-cellphone'){

                $cellphone = $this->input->get_post('cellphone');
                $salt = $this->input->get_post('accesskey');
                $mac = $this->input->get_post('mac');
                $code='';
                for ($i=0; $i <6 ; $i++) {
                    $code.=mt_rand(0,9);# code...
                }

                $this->load->model('Portal_model');
                $system = $this->Portal_model->QcloudAliyunSms();

                if(!$system){
                    echo json_encode(['status'=>'system_error','Please Contact the network administrator.Please fill your SMS Server!']);
                    exit();
                }

                $num = count($system);
                $index = mt_rand(1,$num);
                $config = $system[$index];

                $this->Portal_model->create('message_code',array('salt'=>$salt,'mac'=>$mac,'content'=>'验证码:'.$code,'cellphone'=>$cellphone,'code'=>$code,'status'=>"1",'expired'=>time()+3600,'addtime'=>time()));
                $this->load->library('Sms', $config);
                if($config['type']=='qcloud-sms'){
                    $result =  $this->sms->QcloudSms($cellphone,$code);
                }elseif($config['type']=='aliyun-sms'){
                    $result = $this->sms->AliyunSms($cellphone,$code);
                }


                //echo json_encode(['status'=>'success','code'=>$code]);
                echo json_encode(['status'=>'success']);

            }

            if($op=='verify-code-cellphone'){
                $cellphone = $this->input->get_post('cellphone');

                if(!preg_match("/1[34578]{1}\d{9}$/",$cellphone)){
                    $status = 'notice';
                    $access_code ='-4';
                    echo json_encode(array('status'=>$status,'code'=>$access_code));
                    exit();
                }

                $password = $this->input->get_post('password');

                $salt = $this->input->get_post('accesskey');
                $this->load->model('Portal_model');
                $where = [
                    'code'		=> $password,
                    'salt'		=> $salt,
                    'cellphone'	=> $cellphone,
                    'expired >='=>time(),
                ];
                $this->load->model('Portal_model');
                $result = $this->Portal_model->first(["code"],'message_code',$where);
                if(!empty($result) && $result['code']==$password){
                    $status = 'success';
                    $access_code = mt_rand(1,9).uniqid();
                    $insert_data = ['accesskey'=>$salt,'access_code'=>$access_code,'request_data'=>json_encode($result),'auth_type'=>'verify-code-cellphone'];
                    $this->Portal_model->create('access_auth',$insert_data);
                }else{
                    $status = 'notice';
                    $access_code ='-1';
                }
                //echo -5;//
                echo json_encode(array('status'=>$status,'code'=>$access_code));
            }

            if($op=='fetch-member-account'){


                $accesskey = $this->input->get_post('accesskey');
                $username = $this->input->get_post('username');
                $password = $this->input->get_post('password');
                $where = array(
                    'accesskey'     =>$accesskey,
                    'username'  => trim($username),
                    'password'  => md5(trim($password)),
                );

                $this->load->model('Portal_model');
                $account =  $this->Portal_model->first(["*"],'hotspot_users',$where);

                if(!empty($account) && $account['username']==$where['username'] && $account['password']==$where['password']){

                    if(strtotime("+ 1 day",$account['end_time'])<time()){
                        $echo = array(
                            'status'=>'false',
                            'message'=>"用户已经过期!"
                        );
                        
                    }
                    $access_code = mt_rand(1,9).uniqid();
                    $insert_data = ['accesskey'=>$accesskey,'access_code'=>$access_code,'request_data'=>json_encode($account)];
                    $this->Portal_model->create('access_auth',$insert_data);
                    $echo = array(
                        'status'=>"success",
                        'message'=>"success",
                        'access_code'=>$access_code
                    );
                    
                }else{
                    $echo = array(
                        'status'=>"false",
                        'code'=>-1,
                        'message'=>"用户名或密码错误!"
                    );
                 
                }
                echo json_encode($echo);
            }
        }              

		
	}
	        
 ?>