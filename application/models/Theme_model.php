<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function scanTheme(){

	  	$path = FCPATH.'template'.DIRECTORY_SEPARATOR;
        $dirs = scandir($path);
        $dirs = array_diff($dirs,['..','.','component']);
        $softThemes = $this->getInstalled();
        
        $installed = array();
        $thems = array();
        foreach ($softThemes as $k => $v){
        	
        	$themes[]=array(
        		'theme'=>$v['theme'],
        		'name'=>$v['theme_data']['name'],
        		'picture'=>$v['theme_data']['picture'],
        		'install'=>1,
        		'system'=>1,
        		'data'=>array()
        	);
        }

        foreach ($dirs as $k => $theme){
           
            $dir = $path.$theme;
            if(is_dir($dir)){
                if(is_file($dir.DIRECTORY_SEPARATOR.'config.xml')){
                   $xml = simplexml_load_file($dir.DIRECTORY_SEPARATOR.'config.xml');
                   $data = json_decode(json_encode($xml),TRUE);
                   
                   if(isset($data['@attributes']) 
                   		&& isset($data['@attributes']['engine']) 
                   		&& $data['@attributes']['engine']='http://www.zjyouth.cn' 
                   		&& $data['@attributes']['base'] = $theme
                   	){
                   		$flag = 0;
                   		$system = 0;
                   		if(in_array($theme, $installed)){
                   			$themes = array_diff($themes, [$theme]);
                   			$flag=1;
                   		
                   		} 
                   		$picture = $data['logo'];

                   		if(preg_match('/\@/', $picture)){
                   			$logo = explode('@', $picture);
                   			$picture = '/template/'.$theme.'/'.$logo[1];
                   		}

                   		$themes[]=array(
                   			'theme'=>$theme,
                   			'name'=>$data['name'],
                   			'picture'=>$picture,
                   			'install'=>$flag,
                   			'system'=>$system,
                   			'data'=>$data
                   		);
                   }
                   

                }   
               
           
            }
            
        }

        return array_values($themes);
	}


	public function getInstalled(){

		$installed = $this->get('themes',["*"],[]);
		$themes = array();
		foreach ($installed as $k => $v) {
			$themes[]= array(
				'theme' => $v['style'],
				'theme_data' => $v,
			); 
		}
		return $themes;
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

}

	/* End of file Theme_model.php */
	/* Location: ./application/models/Theme_model.php */