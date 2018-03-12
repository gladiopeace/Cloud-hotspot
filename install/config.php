<?php

/**
 * 配置文件
 */
$conf = array();
$conf['default'] = array(
    'hostname' => '#DB_HOST#',
    'username' => '#DB_USER#',
	'password' => '#DB_PWD#',
	'database' => '#DB_NAME#',
	'dbprefix' => '#DB_PREFIX#',
	// 'swap_pre' => '#DB_PREFIX#',
 	'port'	   => '#DB_PORT#',  
);
$conf['base_url'] = '#SERVER_URL#';
return $conf;
?>