<?php 





function getLanguage(){

	$lang = false;

	if(isset($_GET['lang']) && !empty($_GET['lang'])) $lang = $_GET['lang'];
	
	if (false == $lang  && isset($_COOKIE["language"])) $lang = $_COOKIE["language"];

	if(!$lang){

		$langs = array();
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			// break up string into pieces (languages and q factors)
			preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)s*(;s*qs*=s*(1|0.[0-9]+))?/i',
					$_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
			if (count($lang_parse[1])) {
				// create a list like "en" => 0.8
				$langs = array_combine($lang_parse[1], $lang_parse[4]);
				// set default to 1 for any without q factor
				foreach ($langs as $lang => $val) {
					if ($val === '') $langs[$lang] = 1;
				}
				// sort list based on value
				arsort($langs, SORT_NUMERIC);
			}
		}
		//extract most important (first)
		foreach ($langs as $lang => $val) { break; }
		//if complex language simplify it
		if (stristr($lang,"-")) {$tmp = explode("-",$lang); $lang = $tmp[0]; }
	}

	$dictionary = [];

	switch ($lang) {
		case 'zh':			
			$dictionary = getChinese();
			break;
		
		case 'en':
			$dictionary = getEnglish();
			break;
		default:
			$dictionary = getEnglish();
			break;
	}

	switch ($lang) {
		case 'en':
			setcookie('language',$lang,time()+3600);
			break;
		
		case 'zh':
			setcookie('language',$lang,time()+3600);		
			break;
	}

	$dictionary['currentL'] = $lang;
	return $dictionary;




}


function getEnglish(){

	$dictionary = [
		'accept' 		=>'Accept',
		'previous' 		=>'Previous',
		'next' 			=>'Next',
		'recheck' 		=>'Recheck',
		'environment'	=>'Environment',
		'server'		=>'Server Information',
		'installation'	=>'Installation',
		'submit'	=>'Submit',



	];

	return $dictionary;
}


function getChinese(){
	
	$dictionary = [
		'accept' 		=>'接受',
		'previous' 		=>'上一步',
		'next' 			=>'下一步',
		'recheck' 		=>'重新检测',
		'environment'	=>'检测环境',
		'server'		=>'服务器',
		'installation'	=>'安装程序',
		'submit'	=>'立即安装',


	];
	return $dictionary;


}

