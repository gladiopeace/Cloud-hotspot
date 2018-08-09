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
		'mysql'			=>'Mysql Version',
		'upload_file'	=>"Upload filesize",
		'database'		=>'DB Connection',
		'mysql_server'	=>'Mysql Server',
		'mysql_port'	=>'Port',
		'database_name'	=>'Database',
		'db_prefix'		=>'DB Prefix',
		'db_user'		=>'DB User',
		'db_pass'		=>'DB Password',
		'user_info'		=>'User Setting',
		'administrator'	=>'Administrator',
		'ad_password'	=>'Password',
		'ad_confirm'	=>'Confirm passwd',
		'ad_email'		=>'Email address',
		'os_type'		=>'Unix-like',
		'no_write'		=>'can\'t wtrite',
		'no_read'		=>'can\'t Read',
		'fix_list'		=>'please fix the list of the promble below',
		'enable'		=>'Enable',
		'installed'		=>'Installed',
		'user_tips'		=>'Administrator Account can not be empty',
		'pass_tips'		=>'Password can not be empty',
		'confirm_tips'	=>'Confirm password can not be empty',
		'wrong_pass_t'	=>'The specified passwords do not match',
		'email_tips'	=>'The email address can not be empty.',
		'wrong_email_t'	=>'Please enter a valid Email address.',
		'manager'		=>'Administrator have all the permissions of this site',
		'installing'	=>'installing software',
		'db_no_connect'	=>'can not connect to the database',
		'db_ver_low'	=>'Mysql Version is lower',
		'db_succ'		=>'the database was Successfully created ',
		'software_succ'	=>'The software was Successfully installed!',
		'software_tips'	=>'for security reasons,please remove the "Install" directory after the software installation!',





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
		'mysql'			=>'Mysql版本',
		'upload_file'	=>"附件上传",
		'database'		=>'数据库连接',
		'mysql_server'	=>'服务器地址',
		'mysql_port'	=>'端口',
		'database_name'	=>'数据库名',
		'db_prefix'		=>'表前缀',
		'db_user'		=>'用户名',
		'db_pass'		=>'密码',
		'user_info'		=>'用户设置',
		'administrator'	=>'管理员账号',
		'ad_password'	=>'密码',	
		'ad_confirm'	=>'确认密码',
		'ad_email'		=>'邮箱地址',
		'os_type'		=>'类Unix',
		'no_write'		=>'不可写',	
		'no_read'		=>'不可读',	
		'fix_list'		=>'请解决以下问题',
		'enable'		=>'开启',
		'installed'		=>'已安装',
		'user_tips'		=>'管理员帐号不能为空',
		'pass_tips'		=>'密码不能为空',
		'confirm_tips'	=>'确认密码不能为空',
		'wrong_pass_t'	=>'两次输入的密码不一致。请重新输入',
		'email_tips'	=>'邮箱地址不能为空',
		'wrong_email_t'	=>'请输入正确的电子邮箱地址',
		'manager'		=> '创始人帐号，拥有站点后台所有管理权限',
		'installing'	=>'正在安装软件',
		'db_no_connect'	=>'连接数据库失败',
		'db_ver_low'	=>'数据库版本太低!',
		'db_succ'		=>'成功创建数据库',
		'software_succ'	=>'安装完成，立即进行设置体验吧!',
		'software_tips'	=>'为了您站点的安全，安装完成后即可将网站根目录下的“Install”文件夹删除。',
		





	];
	return $dictionary;


}

