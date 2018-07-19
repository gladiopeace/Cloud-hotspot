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
		'submit'		=>'Submit',
		'check'			=>'Check',
		'recommended'	=>'Recommended',
		'current'		=>'Current',
		'at_least'		=>'At Least',
		'directory'		=>'Permission Of Directories',
		'read'			=>'Read',
		'write'			=>'Write',
		'os'			=>'OS',
		'php'			=>'PHP Version',
		'mysql'			=>'Mysql Version(Client)',
		'upload_file'	=>"Upload max file's size",


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
		'check'			=>'环境检测',
		'recommended'	=>'推荐配置',
		'current'		=>'当前状态',
		'at_least'		=>'最低要求',
		'directory'		=>'目录权限检查',
		'read'			=>'读取',
		'write'			=>'写入',
		'os'			=>'操作系统',
		'php'			=>'PHP版本',
		'mysql'			=>'Mysql版本(Client)',
		'upload_file'	=>"附件上传",



	];
	return $dictionary;


}

