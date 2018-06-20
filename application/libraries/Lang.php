<?php 

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Lang{
 
 	private $CI;

 	private $languages = array();
 	private $currentL = 'zh';


	public function __construct($config=array('lang'=>'')){

		$lang = $config['lang'];
		

        $this->CI =& get_instance();

        $ops = array('en','zh','tw');

        
        $this->languages = array(
		        'en' => array(
	                'name'                  => 'English',
	                'ident'                => 'english',	                
		        ),		        
		        'zh' => array(
	                'name'                  => '简体中文',
	                'ident'                => 'chinese',		            
		            
		        ),
		      
		);
      	$slang = $this->CI->session->userdata('lang');
      
     
      	
      	 	
      	if(true == $lang && true==$slang && $slang==$lang){      		
  			
  			$this->currentL = $slang;  

      		
      	}elseif(false == $lang && true==$slang){      		
  
  			$this->currentL = $slang;  

      		
      	}elseif(in_array($lang, $ops) &&  $slang!=$lang){
			$newdata = array(
                'lang'  => $lang                  
            );
  			$this->CI->session->set_userdata($newdata);

  			$this->currentL = $lang;
      	}elseif(false==$lang && false==$slang){
       		$this->CI->load->library('user_agent');
       		$lang = $this->CI->agent->languages();       		
       		$this->currentL = $lang[1];
       		$newdata = array(
                'lang'  => $lang[1]                  
            );
  			$this->CI->session->set_userdata($newdata);
      	}




       
	}





	function sign_up(){
	

		$ident = $this->languages[$this->currentL];
		$currentL = $this->currentL;	
		
		$this->CI->lang->load('signup',$ident['ident']);
		
		$data = $this->CI->lang->language;
		$data['clang'] = $currentL;		
		return $data;
	}


	function sign_in(){	

		$ident = $this->languages[$this->currentL];
		$currentL = $this->currentL;			
		$this->CI->lang->load('signin',$ident['ident']);		
		$data = $this->CI->lang->language;
		$data['clang'] = $currentL;		
		return $data;
	}
 
 }
 
 /* End of file Lang.php */
 /* Location: ./application/Libraries/Lang.php */