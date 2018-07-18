<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal_model extends CI_Model {


	public function first($select=array(),$db,$where=array()){

			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}

			//$this->db->where($key,$value);
			foreach ($select as $value) {
				$this->db->select("{$value}");
			}
			
			$this->db->limit(1);
			
			$query=$this->db->get($db);

			$bech = $query->result_array();
			if(!empty($bech)) return $bech[0];

	}

	public function save($data=array(),$db,$where=array()){		

		foreach ($where as $key => $value) {
			$this->db->where($key,$value);
		}

		$this->db->update($db, $data);

		return $this->db->affected_rows();

	}

	public function create($table,$data,$type='rows'){

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

	public function get($select=array(),$db,$where=array(),$keyfield=null,$order=array(),$limit=''){

		if(is_array($where)){
			foreach ($where as $key => $value) {
				$this->db->where($key,$value);
			}
		}else{
			$this->db->where($where);
		}
			
		foreach ($select as $value) {
			$this->db->select("{$value}");
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
			
				if(isset($v[$keyfield])){
					$rs[$v[$keyfield]] = $v;
				}else{
					$res[] = $v;
				}
			}

			return $rs;
		}

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


	public function init($key,$flag='mikrotik'){
		
		switch ($flag) {
			case 'mikrotik':
				$site = array('salt'=>$key);
				break;
			
			case 'ubnt':
				$site = array('id'=>$key);
				# code...
				break;		
		}


	    $bech = $this->branch($site);//	    
	    $where = array('accesskey'=>$bech['salt']);
		$copyright = $this->first(array('*'),'themes_copyright',$where);

		if (empty($copyright)){
			$copyright= array('company'=>"宁波优思网络技术有限公司",'title'=>'热点Wi-Fi','number'=>"10",'type'=>"accept",'a_num'=>"4",'b_num'=>"4");
		}	

		$slider = $this->get(array('thumb'),'hotspot_slider',$where);		
		$banner = $this->get(array('thumb'),'hotspot_banner',$where);

		switch ($bech['type']) {
			case 'wechat':
			case 'wifi':
				$tid = $bech['wechat_tid'];
				$themeType = 2;
			
				break;

			case 'normal':
				$tid = $bech['normal_tid'];		
				$themeType = 1;

				break;

			case 'account':
				$tid = $bech['account_tid'];		
				$themeType = 3;				

				break;
			
			default:
				$tid = $bech['normal_tid'];	
				$themeType = 1;			

				break;
		}
		
		if($tid){
			$themes = $this->first(array("style"),"themes",array('id'=>$tid,'type'=>$themeType));
		}else{
			$themes = $this->first(array("style"),"themes",array('type'=>$themeType));			
		}

		if(empty($themes)){
			$themes = array('style' =>'cloud-theme');
		}
	   	
	   	$this->load->library('user_agent');

	   	$index = 'index.php';
		if (!$this->agent->is_mobile()){
			$index = 'computer.php';
			//$themes['style'] = 'hotspot';
		} 		
		$action = site_url('portal/verify');
		$_url = base_url();
	   	$result = array(	   		
	   		'branch' 	=>	$bech,
	   		'copyright' =>	$copyright,
	   		'themes' 	=> $themes['style'].'/'.$index,
	   		'template' 	=>$_url.'template/'.$themes['style'].'/',
	   		'action' 	=> $action,	   		
	   		'slider' 	=> $slider,
	   		'banner' 	=> $banner,	
			'static'	=> base_url(),		
	   	);

	   	$result = array_merge($result,$where);
	   	return $result;


	}

	public function branch($where){
		
		$bech = $this->first(array('*'),'hotspot_branch',$where);

	    if(empty($bech)) self::message('节点不存在');

	    if(empty($bech['access_info'])) 
	    	self::message('请上传生节点文件至ros中,IP要与hotspot一致');	
	    $bech['access_info'] = json_decode($bech['access_info'],true);

        //var_dump($bech);exit();
	    return $bech;
	}

	public function wecaht_wifi($where){

		$api = $this->first(array('*'),'wifiapi',$where);
		if (empty($api))
			$api = array(
				'ssid'		=>	'mikrotik',
				'bssid'		=>	'E4:8D:8C:11:FC:92',
				'shopid'	=>	'7342319',
				'appid'		=>	'wx874f915d24c24862',
				'secretkey'	=>	'79b10b7b17856cfef3c1b8a86d61ad2f'

			);
			 		
		return $api;		
	}


    public function config($accesskey){

        $where = ['accesskey'=>$accesskey];

        $copyright= array('company'=>"宁波优思网络技术有限公司",'number'=>"10",'type'=>"deny",'screen'=>'deny');

        $_cpck = $this->first(['company','title','screen','type','number'],"themes_copyright",$where);
        $bech = false;
        if(false!=$_cpck) $copyright = $_cpck;

        $screen = $this->get(array('thumb'),'hotspot_slider',$where,$keyfield=null,['order ASC','addtime DESC','id DESC'],$limit='');
        if(false==$screen){
            if($bech==false)
                $bech = $this->first(['id','uid'],"hotspot_branch",['salt'=>$accesskey]);
            $screen = $this->get(array('thumb'),'hotspot_slider',['bid'=>$bech['id'],'uid'=>$bech['uid']],$keyfield=null,['order ASC','addtime DESC','id DESC'],$limit='');
            if(false!=$screen)
                $this->save(['accesskey'=>$accesskey],"hotspot_slider",['bid'=>$bech['id'],'uid'=>$bech['uid']]);

        }


        if(empty($screen)) $screen = [['thumb'	=>'http://image.cloudshotspot.com/0427e64339c161504d2808433b35e243ab8c76b4_1476978749.jpg']];

        $banner = $this->get(array('thumb'),'hotspot_banner',$where,$keyfield=null,['order ASC','addtime DESC','id DESC'],$limit='');

        if(false==$banner){
            if($bech==false) $bech = $this->first(['id','uid'],"hotspot_branch",['salt'=>$accesskey]);
            $banner = $this->get(array('thumb'),'hotspot_banner',['bid'=>$bech['id'],'uid'=>$bech['uid']],$keyfield=null,['order ASC','addtime DESC','id DESC'],$limit='');
            if(false!=$banner)  $this->save(['accesskey'=>$accesskey],"hotspot_banner",['bid'=>$bech['id'],'uid'=>$bech['uid']]);
        }

        if(empty($banner)) $banner = [['thumb' => 'http://image.cloudshotspot.com/f3719945d9b5ba83c92429f6c9a28bcbb1f484dc_1470661695.jpg']];
        return ['banner'=>$banner,'screen'=>$screen,'copyright'=>$copyright];

    }

    public function QcloudAliyunSms(){

        $aliyun = $this->first(['*'],'config',['config_name'=>'aliyun-sms']);
        if($aliyun && isset($aliyun['config_content'])){
            $aliyun = json_decode($aliyun['config_content'],true);
        }else{
            $aliyun = array();
        }

        $qcloud = $this->first(['*'],'config',['config_name'=>'qcloud-sms']);

        if($qcloud && isset($qcloud['config_content'])){
            $qcloud = json_decode($qcloud['config_content'],true);
        }else{
            $qcloud = array();
        }
        $result = array();
        if(!empty($aliyun) && $aliyun['enable']==1 && !empty($qcloud) && $qcloud['enable']==1 ){
            $qcloud['type']='qcloud-sms';
            $result[1] = $qcloud;
            $aliyun['type'] = 'aliyun-sms';
            $result[2] = $aliyun;

        }elseif(!empty($aliyun) &&  $aliyun['enable']==1){
            $aliyun['type'] = 'aliyun-sms';
            $result[1] = $aliyun;
        }elseif(!empty($qcloud) && $qcloud['enable']==1){
            $qcloud['type']='qcloud-sms';
            $result[1] = $qcloud;
        }

        return $result;
    }

    public function textSaltToken($authCode,$salt,$mac){

        $authResult = $this->first(array(),'access_auth',array('access_code'=>$authCode));

        if(false!=$authResult && !empty($authResult)){

            $this->save(array('device_mac'=>$mac,'auth_time'=>time()),'access_auth',array('access_code'=>$authCode));
            $where = array('salt'=>$salt);
            //$data = $this->Portal_model->branch($where);
            $data = $this->branch($where);
            $this->load->library('Aes');
            $ip = $data["access_info"]['ip'];
            $pass  = md5('mikrotik');

            //For ubnt auth
            if($data['brand']=='ubnt'){

            	$this->sendAuthorization($mac,$data['site_name'],$data["access_info"]);
            	
            } 

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
            );

        }else{
            $data = array('status'=>0,'message'=>'Access Deny');
        }
        return $data;

    }

    public function apToSite($mac){
		$ap = $this->first(array('site_id'),'hotspot_ap',array('mac'=>$mac));		
	    if(empty($ap)) self::message('unauthorized access');
	    $siteData = $this->init($ap['site_id'],'ubnt');
	    return $siteData; 
    }

    public function sendAuthorization($mac,$site='',$unifiKey=array()){
	


      	 //Config
        $server   = 'https://'.$unifiKey['ip'].':8443/';
        $user     = $unifiKey['username'];
        $password = $unifiKey['password'];
        $expire_mins = 240;
	    
       /* $site     = $this->site;*/
        $cookie_file_path = FCPATH. '/data/unifi_cookie';

        // Login
        $data = json_encode(
            array(
                  'username' => $user,
                  'password' => $password,
            )
        );


        // Start Curl for login
        $ch = curl_init();
        // We are posting data
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // Set up cookies
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
        // Allow Self Signed Certs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, '1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Login to the UniFi controller
        curl_setopt($ch, CURLOPT_URL, $server . "/api/login");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        //var_dump($result);


        // Send user to authorize and the time allowed
        $data = json_encode(
                            array(
                                  'cmd' => 'authorize-guest',
                                  'mac' => $mac,
                                  'minutes' => $expire_mins,
                                  )
                            );
        $ch = curl_init();
        // We are posting data
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // Set up cookies
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
        // Allow Self Signed Certs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, '1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Make the API Call
        curl_setopt($ch, CURLOPT_URL, $server . '/api/s/' . $site . '/cmd/stamgr');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'json=' . $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        //var_dump($result);

        //Logout
        $ch = curl_init();
        // We are posting data
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // Set up cookies
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
        // Allow Self Signed Certs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, '1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Make the API Call
        curl_setopt($ch, CURLOPT_URL, $server . '/api/logout');
        curl_exec($ch);
        curl_close($ch);    



    }

	private static function message($info){
		$info = urlencode($info);
		echo urldecode(json_encode(array('status'=>"false",'message'=>$info)));
		die();
	}



	

}

/* End of file Portal_model.php */
/* Location: ./application/models/Portal_model.php */

?>