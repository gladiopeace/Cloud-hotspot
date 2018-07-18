<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Manage extends CI_Controller {
		
		private $_organization = array();

	    public function __construct() {
	        parent::__construct();
	        $this->load->library('session');
			$organization = [
				'salt'				=> $this->session->userdata('salt'),
				'username'			=> $this->session->userdata('username'),
				'id'				=> $this->session->userdata('id'),
				'alipay_payment'	=> $this->session->userdata('alipay_payment'),
			];

			if(empty($organization['id']) || empty($organization['salt']) || empty($organization['username']))
				redirect('/','refresh');

			$this->_organization = $organization;
	    }
	
	    public function index() {
	    	
	        $uid = $this->_organization['id'];
			$this->load->model('Member_model');	


			$from = $this->input->get('from');
			$salt = $this->input->get('salt');			

			 
            if(!empty($from) && $from=='auth' && !empty($salt)){
            	$_paydata['alipay_payment'] = $this->session->userdata($salt);            	           	
            	$this->Member_model->update($_paydata,'user',array('id'=>$this->_organization['id']));
            	redirect('/manage/index','refresh');
            }


			$lang = $this->input->get('lang', TRUE);
       		$this->load->library('Lang', array('lang'=>$lang), 'Switch');
       		$data = $this->Switch->init('manage');

          	$data['from'] = $from;
			$data['salt'] = $salt;

			$stores = $this->Member_model->get('hotspot_branch',['salt','branch','id'],['uid'=>$uid]);
			$bech = $this->Member_model->first('user',["*"],['id'=>$uid]);
			$data = array_merge($data,['result'=>$stores,'bech'=>$bech,'now'=>time()]);
			
			$this->load->library('user_agent');
			if ($this->agent->is_mobile()){
				$this->load->library('twig');
				$this->twig->display('manage/indexM.php',$data);
			}else{
                $this->load->library('twig');
				$this->twig->display('manage/index.php',$data);

			}

	    }

	    public function create(){


			$ops = array('setup','add','modify','del','access','message','setup');


			
			$op = $this->uri->segment(3);
		

			if($op=='setup'){			

	 			if($this->input->post()){

					$data = $this->input->post('data');
					$user = $this->input->post('user');
					$ap = $this->input->post('ap');
				
					$aps = explode('@', $ap);

				
					$_uid = $this->_organization['id'];
					$this->load->model('Member_model');
					$branch['branch'] = $data['branch'];
					$branch['brand'] = $data['brand'];
					$branch['site_name'] = $data['branch'];
					$branch['uid'] = $_uid;
					/*$branch['organization_id'] = $_uid;*/
					$access_info = array(
						'url'=>$data['url'],
						'ip'=>$data['ip'],
						'username'=>$user['username'],
						'password'=>$user['password'],
						);
					$branch['access_info'] = json_encode($access_info);
					$branch['salt'] = sha1(time().mt_rand(1,999));
					$branch['addtime'] = time();

					//加载计费模块
					$nexttime = strtotime(date('Y-m-d H:i:s',time())."+ 7 day");
					$branch['overdue'] = $nexttime;

					$bid = $this->Member_model->insert('hotspot_branch',$branch);

					foreach ($aps as $k => $mac) {
						$tmp = array('user_id'=>$_uid,'site_id'=>$bid,'mac'=>$mac);
						$this->Member_model->insert('hotspot_ap',$tmp);
					}
				
					$_data = array('branch'=>$branch['branch'],'salt'=>$branch['salt'],'overdue'=>date("Y-m-d",$nexttime));
					echo json_encode(array('status'=>"success",'id'=>$bid,'data'=>$_data));
					exit();
				}

				$lang = $this->input->get('lang', TRUE);
	       		$this->load->library('Lang', array('lang'=>$lang), 'Switch');
	       		$data = $this->Switch->init('createsite');
				$this->load->library('twig');			
				$this->twig->display('manage/create.php',$data);
								
			}


		}
		

		public function setting(){

            $op = $this->input->get('do');
            if($op=='change'){
                $uid = $this->_organization['id'];

                $this->load->model('Member_model');

                if($this->input->post()){
                    $data = $this->input->post('data');
                    $do = $this->input->post('do');

                    if($do=='init'){
                        $data['uid'] = $uid;
                        //$model->insert('init_user',$data);
                        //echo $model->last_query();
                        unset($data['uid']);
                    }
                    $this->Member_model->update($data,'user',array('id'=>$uid));
                    //echo $model->last_query();

                    echo json_encode(['status'=>'success']);

                    exit();
                }

                $do = $this->input->get('do');

                $user = $this->Member_model->first('user',array("*"),array('id'=>$uid));

                $lang = $this->input->get('lang', TRUE);
	       		$this->load->library('Lang', array('lang'=>$lang), 'Switch');
	       		$data = $this->Switch->init('profile');
	       		$data['bech'] = $user;
	       		$data['do'] = $do;
                $this->load->library('twig');
                $this->twig->display('manage/setting.php',$data);
            }

            if($op=='system'){

                $this->load->model('Member_model');
                if($this->input->post()){
                    $data = $this->input->post();
                    if(!isset($data['do'])) return false;
                    if($data['do']=='Qcloud'){

                        $res = $this->Member_model->Qcloud_Sms_Save($data['data']);

                        echo json_encode(['status'=>'success','message'=>'success']);

                    }

                    if($data['do']=='Aliyun'){

                        $res = $this->Member_model->Aliyun_Sms_Save($data['data']);
                        echo json_encode(['status'=>'success','message'=>'success']);

                    }

                    if($data['do']=='Email'){

                        $res = $this->Member_model->Email_Account_Save($data['data']);

                        echo json_encode(['status'=>'success','message'=>'success']);

                    }

                    if($data['do']=='Bech'){

                        $res = $this->Member_model->Email_Account_Save($data['data']);

                        echo json_encode(['status'=>'success','message'=>'success']);

                    }
                    exit();

                }

                $qcloud = $this->Member_model->Qcloud_Sms_Get();
                $aliyun = $this->Member_model->Aliyun_Sms_Get();
                $email = $this->Member_model->Email_Account_Get();
                $bech = $this->Member_model->Bech_Get();
                //var_dump($aliyun);


              /*  $lang = $this->input->get('lang', TRUE);
	       		$this->load->library('Lang', array('lang'=>$lang), 'Switch');
	       		$data = $this->Switch->init('profile');
	       		$data['bech'] = $user;
	       		$data['do'] = $do;*/
	       		
                $this->load->library('twig');
                $this->twig->display('manage/system.php',['qcloud'=>$qcloud,'aliyun'=>$aliyun,'email'=>$email,'bech'=>$bech]);
            }

		}
		public function logout(){
	    	
	    	$this->session->sess_destroy();
	    	redirect('/','refresh');
		}
}
	        


?>