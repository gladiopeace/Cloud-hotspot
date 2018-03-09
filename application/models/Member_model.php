<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



	class Member_model extends CI_Model{




		public function login(){

			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			//$this->load->database();
			$this->db->select('id,username,password,salt');
			$query = $this->db->get_where('user', array('username' => $username,'password' => $password,'level >=' => '4','vip' => '1'), 1);
			//$data = $query->result_array();
			$data = $query->result_array();
			//var_dump($data);exit('stop here in user model!');


			if(!empty($data) && $data['0']['username']==$username && $data['0']['password']==$password){

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

				//$this->sessionb->set($newdata);
				$this->session->set_userdata($newdata);

				return 1;
			}

		}



		public function query($sql){


			$this->db->query($sql);

			return $this->db->affected_rows();

		}


		/*
		*	public insert_data 插入数据
		*	Paramter $table 表名
		*	paramter $data 数据
		*	return Int结果真与假受影响行数
		*/

		public function insert_data($table,$data,$type='rows'){

			$this->db->insert($table, $data);


			switch ($type) {
				case 'rows':
					return $this->db->affected_rows();
					break;

				case 'id':
					return $this->db->insert_id();
					break;

				default:
					return $this->db->affected_rows();
					break;
			}

		}

		public function insert($table,$data,$type='id'){

			$this->db->insert($table, $data);

			switch ($type) {
				case 'rows':
					return $this->db->affected_rows();
					break;

				case 'id':
					return $this->db->insert_id();
					break;

				default:
					return $this->db->affected_rows();
					break;
			}

		}




		public function get($db,$select=array(),$where=array(),$keyfield=null,$order=array(),$limit=''){
			//exit('sele here!');
			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}

			//$this->db->where($key,$value);
			foreach ($select as $value) {
				$this->db->select("{$value}");
			}
			if(isset($order) && !empty($order)){

				foreach ($order as $key => $value) {
					$this->db->order_by($key,$value);

				}

			}

			if(!empty($limit)){
				$this->db->limit($limit);
			}
			$query=$this->db->get($db);

			$data = $query->result_array();

			if(empty($keyfield)){
				return $data;
			}else{

				$rs = array();
				foreach ($data as $v) {
				//	var_dump($v);echo '<br/>';
					if(isset($v[$keyfield])){
						$rs[$v[$keyfield]] = $v;
					}else{
						$res[] = $v;
					}
				}

				return $rs;
			}

		}




		public function getall($num,$offset,$tb,$arr=array(),$time=array()){
			header("Content-type: text/html;charset=utf-8");
			//$this->db->order_by('addtime','desc');

			if(isset($time) && !empty($time)){

				foreach ($time as $key => $value) {
					$this->db->order_by($key,$value);

				}

			}



			if(isset($arr) && !empty($arr)){

				foreach ($arr as $key => $value) {
					$this->db->where($key,$value);
				}

			}
			 //$this->db->select('id, username, truename, money, credit, cellphone, address, job, addtime');
			// $this->db->where('username',$username);
			 $query=$this->db->get($tb,$num,$offset);

			// echo $this->db->last_query();
  			 return $query;
		}



		public function getTree($arr,$id='0',$level='0'){
			$tree = array();

			foreach ($arr as $v) {
				if($v['parentid'] == $id){
					$v['level'] = $level;
					$tree[] = $v;

					$tree = array_merge($tree,$this->getTree($arr,$v['id'],$level+1));
				}
			}

			return $tree;

		}




		public function getone($select=array(),$db,$where=array()){
			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}

			//$this->db->where($key,$value);
			foreach ($select as $value) {
				$this->db->select("{$value}");
			}

			$this->db->limit('1');
			$query=$this->db->get($db);
			$data = $query->result_array();
            if(empty($data)) return false;

			return $data[0];

		}

		public function first($db,$select=array(),$where=array()){

			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}

			//$this->db->where($key,$value);
			foreach ($select as $value) {
				$this->db->select("{$value}");
			}

			$this->db->limit('1');
			$query=$this->db->get($db);
			$data = $query->row_array();

			return $data;
		}



		public function update($data=array(),$db,$where=array()){

			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}

			$this->db->update($db, $data);

			return $this->db->affected_rows();

		}



		public function delete($where=array(),$db){


			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}
			$this->db->delete($db);

			return $this->db->affected_rows();

		}


		public function set($data=array(),$db,$where=array(),$type=false){


			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}
			foreach ($data as $key => $value) {
				$this->db->set($key,$value,$type);
			}


			$this->db->update($db);
			return $this->db->affected_rows();
		}



		public function add_money($username,$money){

			if(preg_match("/\|/", $username)){
				$users = explode('|', $username);
				$number = count($users);
				for ($i=0; $i < $number; $i++) {

					$this->add_money($user[$i],$money);
				}

			}else{

				$sql = "UPDATE msh_user SET money = money + $money where username='$username'";

				$this->db->query($sql);

				return $this->db->affected_rows();
			}

		}


		public function money_record($username,$amount,$bank,$reason,$note,$editor){



			if(preg_match("/\|/", $username)){
				$users = explode('|', $username);
				$number = count($users);
				for ($i=0; $i < $number; $i++) {

					$this->money_record($user[$i],$amount);
				}

			}else{
				//资金记录的增加功能首先你要知道 增加记录后的余额是多少，所以我们要获取用户的相关信息
				$result = $this->getone(array('*'),'user',array('username'=>$username));
				//file_put_contents(date('H:i:s',time()).'money_record.txt','hello world!\\r\\n'.$username);
				$balance = $result['0']['money'];//用户余额
				date_default_timezone_set('PRC');
				//构建插入的数据
				$data = array(
					'username' => $username,
					'bank' => $bank,
					'amount' => $amount,
					'balance' => $balance,
					'addtime' => time(),
					'reason' => $reason,
					'note' => $note,
					'editor' => $editor
					);

				//插入到数据库中
				$this->insert_data('record_money', $data);

				//return $this->db->affected_rows();

			}


		}


        public function Bech_Save($data){


            if(isset($data['ssl']) && $data['ssl']=='on')  $data['ssl'] = 1;

            if(!isset($data['ssl'])) $data['ssl'] = 0;


            $config = $this->first('config',['*'],['config_name'=>'bech']);

            if($config){
                $res =  $this->update(['config_content'=>json_encode($data)],'config',['config_name'=>'bech']);
            }else{
                $res =  $this->insert_data('config',['config_content'=>json_encode($data),'config_name'=>'bech']);
            }
            return $res;
        }


        public function Bech_Get(){

            $config = $this->first('config',['*'],['config_name'=>'bech']);
            if($config && isset($config['config_content'])){
                $config = json_decode($config['config_content'],true);
            }else{
                $config = array();
            }
            return $config;
        }



        public function Email_Account_Save($data){


            if(isset($data['ssl']) && $data['ssl']=='on')  $data['ssl'] = 1;

            if(!isset($data['ssl'])) $data['ssl'] = 0;


            $config = $this->first('config',['*'],['config_name'=>'email-account']);

            if($config){
                $res =  $this->update(['config_content'=>json_encode($data)],'config',['config_name'=>'email-account']);
            }else{
                $res =  $this->insert_data('config',['config_content'=>json_encode($data),'config_name'=>'email-account']);
            }
            return $res;
        }


        public function Email_Account_Get(){

            $config = $this->first('config',['*'],['config_name'=>'email-account']);
            if($config && isset($config['config_content'])){
                $config = json_decode($config['config_content'],true);
            }else{
                $config = array();
            }
            return $config;
        }


        public function Aliyun_Sms_Save($data){


            if(isset($data['enable']) && $data['enable']=='on')  $data['enable'] = 1;

            if(!isset($data['enable'])) $data['enable'] = 0;


            $config = $this->first('config',['*'],['config_name'=>'aliyun-sms']);

            if($config){
                $res =  $this->update(['config_content'=>json_encode($data)],'config',['config_name'=>'aliyun-sms']);
            }else{
                $res =  $this->insert_data('config',['config_content'=>json_encode($data),'config_name'=>'aliyun-sms']);
            }
            return $res;
        }


        public function Aliyun_Sms_Get(){

            $config = $this->first('config',['*'],['config_name'=>'aliyun-sms']);
            if($config && isset($config['config_content'])){
                $config = json_decode($config['config_content'],true);
            }else{
                $config = array();
            }
            return $config;
        }

        public function Qcloud_Sms_Save($data){



            if(isset($data['enable']) && $data['enable']=='on')  $data['enable'] = 1;

            if(!isset($data['enable']))  $data['enable'] = 0;

            $config = $this->first('config',['*'],['config_name'=>'qcloud-sms']);

            if($config){
               $res =  $this->update(['config_content'=>json_encode($data)],'config',['config_name'=>'qcloud-sms']);
            }else{
                $res =  $this->insert_data('config',['config_content'=>json_encode($data),'config_name'=>'qcloud-sms']);
            }


            return $res;
        }

        public function Qcloud_Sms_Get(){

            $config = $this->first('config',['*'],['config_name'=>'qcloud-sms']);

            if($config && isset($config['config_content'])){

                $config = json_decode($config['config_content'],true);

            }else{
                $config = array();
            }
            return $config;
        }

        public function feiyeconfig($init= array(),$where=array()){

            $total = $this->gettotal($where,$init['table']);
            $this->load->library('pagination');


            $config['base_url'] = $init['url']; //导入分页类URL
            $config['total_rows'] =$total; //$this->db->count_all('shopping_category');  //计算总记录数
            $config['per_page'] = $init['per_page'];         //每页显示的记录数
            $config['uri_segment']=$init['uri_segment'];

            if($this->input->get()){
                $config['suffix']	= '?'.$_SERVER['QUERY_STRING'];
            }

            //define pagging style
            /*$config['full_tag_open'] = '<div class="inline pull-center page">';
            $config['full_tag_close'] = '</div>';
            $config['first_link'] = '首页';
            $config['last_link'] = '尾页';
            $config['prev_link'] = '上一页';
            $config['next_link'] = '下一页';*/



            $config['full_tag_open'] = '<ul class="pagination pagination-right pull-right">';
            $config['full_tag_close'] = '</ul>';
            $config['anchor_class'] = "";
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['first_link'] = '首页';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = '尾页';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $this->pagination->initialize($config);

            return $this->pagination->create_links();
        }

        private function gettotal($where,$table){

            $this->db->where($where);//条件语句
            $this->db->from($table);//查询的表
            $total = $this->db->count_all_results();//总条数

            return $total;
        }
    }

?>
