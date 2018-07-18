<?php


header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('PRC');
error_reporting(E_ALL & ~E_NOTICE);

require_once 'common.php';
$dictionary = getLanguage();

if (file_exists('./install.lock')) {
    echo '
		<html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        </head>
        <body>
        你已经安装过该系统，如果想重新安装，请先删除站点install目录下的 install.lock 文件，然后再安装。
        </body>
        </html>';
    exit;
}





@set_time_limit(1000);
if (phpversion() <= '5.3.0')
    set_magic_quotes_runtime(0);
if ('5.2.0' > phpversion())
    exit('您的php版本过低，不能安装本软件，请升级到5.2.0或更高版本再安装，谢谢！');



define('SITEDIR', _dir_path(substr(dirname(__FILE__), 0, -8)));
define("SIMPLEWIND_CMF_VERSION", '20180720');
//数据库
$sqlFile = 'software.sql';
$configFile = 'config.php';

if (!file_exists(SITEDIR . 'install/' . $sqlFile) || !file_exists(SITEDIR . 'install/' . $configFile)) {
    echo '缺少必要的安装文件!';
    exit;
}
$Title = "Cloud-Portal";
$Powered = "-优思软件";
$steps = array(
    '1' => '安装许可协议',
    '2' => '运行环境检测',
    '3' => '安装参数设置',
    '4' => '安装详细过程',
    '5' => '安装完成',
);
$step = isset($_GET['step']) ? $_GET['step'] : 1;

//地址
$scriptName = !empty($_SERVER["REQUEST_URI"]) ? $scriptName = $_SERVER["REQUEST_URI"] : $scriptName = $_SERVER["PHP_SELF"];

$rootpath = @preg_replace("/\/(I|i)nstall\/index\.php(.*)$/", "", $scriptName);
$domain = empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['HTTP_HOST'];

if ((int) $_SERVER['SERVER_PORT'] != 80) {
    $domain .= ":" . $_SERVER['SERVER_PORT'];
}
$domain = $domain . $rootpath;

switch ($step) {

    case '1':
        include_once ("./templates/s1.php");
        exit();

    case '2':

        if (phpversion() < 5) {
            die('本系统需要PHP5+MYSQL >=5.6环境，当前PHP版本为：' . phpversion());
        }

        $phpv = @ phpversion();
        $os = PHP_OS;
        $os = php_uname();
        $tmp = function_exists('gd_info') ? gd_info() : array();
        $server = $_SERVER["SERVER_SOFTWARE"];
        $host = (empty($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_HOST"] : $_SERVER["SERVER_ADDR"]);
        $name = $_SERVER["SERVER_NAME"];
        $max_execution_time = ini_get('max_execution_time');
        $allow_reference = (ini_get('allow_call_time_pass_reference') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
        $allow_url_fopen = (ini_get('allow_url_fopen') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
        $safe_mode = (ini_get('safe_mode') ? '<font color=red>[×]On</font>' : '<font color=green>[√]Off</font>');
        $Errors = [];
        $err = 0;
        if (empty($tmp['GD Version'])) {
            $gd = '<font color=red>[×]Off</font>';
            $err++;
            $Errors[]='请确认服务器PHP安装GD库!';
        } else {
            $gd = '<font color=green>[√]On</font> ' . $tmp['GD Version'];
        }
        if (function_exists('mysqli_connect')) {
            $mysql = '<span class="correct_span">&radic;</span> 已安装';
        } else {
            $mysql = '<span class="correct_span error_span">&radic;</span> 出现错误';
            $Errors[]='请确认MySQL服务器支持Mysqli扩展!';

            $err++;
        }
        if (ini_get('file_uploads')) {
            $uploadSize = '<span class="correct_span">&radic;</span> ' . ini_get('upload_max_filesize');
        } else {
            $Errors[]='请确认php服务器支持文件上传!';
            $uploadSize = '<span class="correct_span error_span">&radic;</span>禁止上传';
        }
        if (function_exists('session_start')) {
            $session = '<span class="correct_span">&radic;</span> 支持';
        } else {
            $Errors[]='请确认php服务器支持Session!';
            $session = '<span class="correct_span error_span">&radic;</span> 不支持';
            $err++;
        }


        $folder = array(
            'install',
            'data',
        );
        include_once ("./templates/s2.php");
        exit();

    case '3':

        if ($_GET['testdbpwd']) {

           
            $conn = @mysqli_connect($_POST['dbHost'],$_POST['dbUser'], $_POST['dbPwd'],'',$_POST['dbPort']);

            if ($conn) {
                die("1");
            } else {
                die("");
            }
        }
        
        include_once ("./templates/s3.php");
        exit();


    case '4':
        if (intval($_GET['install'])) {
            $n = intval($_GET['n']);
            $arr = array();

            $dbHost = trim($_POST['dbhost']);
            $dbPort = trim($_POST['dbport']);
            $dbName = trim($_POST['dbname']);
            /*$dbHost = empty($dbPort) || $dbPort == 3306 ? $dbHost : $dbHost . ':' . $dbPort;*/
            $dbUser = trim($_POST['dbuser']);
            $dbPwd = trim($_POST['dbpw']);
            $dbPrefix = empty($_POST['dbprefix']) ? 'sn_' : trim($_POST['dbprefix']);

            $username = trim($_POST['manager']);
            $password = trim($_POST['manager_pwd']);
            $email	  = trim($_POST['manager_email']);
            $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
            $server_url = $http_type . $_SERVER['HTTP_HOST'];      
            $conn = @mysqli_connect($dbHost,$dbUser, $dbPwd,'',$dbPort);
            if (!$conn) {
                $arr['msg'] = "连接数据库失败!";
                echo json_encode($arr);
                exit;
            }
            $conn->query("SET NAMES 'utf8'"); //,character_set_client=binary,sql_mode='';
            $version =$conn->server_version;
            if ($version < 4.1) {
                $arr['msg'] = '数据库版本太低!';
                echo json_encode($arr);
                exit;
            }
            if (!$conn->select_db($dbNam)) {
                //if (!mysql_select_db($dbName, $conn)) {
                //创建数据时同时设置编码
                if (!$conn->query("CREATE DATABASE IF NOT EXISTS `" . $dbName . "` DEFAULT CHARACTER SET utf8;")) {
                    $arr['msg'] = '数据库 ' . $dbName . ' 不存在，也没权限创建新的数据库！';
                    echo json_encode($arr);
                    exit;
                }
                if (empty($n)) {
                    $arr['status'] = 'notice';
                    $arr['msg'] = "成功创建数据库:{$dbName}<br>";
                    echo json_encode($arr);
                    exit;
                }
                $conn->select_db($dbName);
            }
            //读取数据文件
            $sqldata = file_get_contents(SITEDIR . 'install/' . $sqlFile);
            $sqlFormat = sql_split($sqldata, $dbPrefix);
            /**
            执行SQL语句
             */
            $counts = count($sqlFormat);
            for ($i = $n; $i < $counts; $i++) {
                $sql = trim($sqlFormat[$i]);
                //创建数据表
                if (strstr($sql, 'CREATE TABLE')) {
                    preg_match('/CREATE TABLE `([^ ]*)`/', $sql, $matches);
                    //mysql_query("DROP TABLE IF EXISTS `$matches[1]");
                    $conn->query("DROP TABLE IF EXISTS ,$matches[1]");
                    //$ret = mysql_query($sql);
                    $ret = $conn->query($sql);
                    if ($ret) {
                        $message = '<li><span class="correct_span">&radic;</span>创建数据表' . $matches[1] . '，完成</li> ';
                    } else {
                        $message = '<li><span class="correct_span error_span">&radic;</span>创建数据表' . $matches[1] . '，失败</li>';
                    }
                    $i++;
                    $arr = array('status' => 'notice', 'msg' => $message,'data'=>$matches,'sql'=>$sql);

                    echo json_encode($arr);
                    exit;
                } else {
                    //插入数据表
                    if($sql) $ret = $conn->query($sql);
                    $message = '<li><span class="correct_span">&radic;</span>'.$sql.'</li>';
                    $message = "";
                    $arr = array('status' =>'notice', 'msg' => $message,'sql'=>$sql,'okokook'=>$ret);
                    echo json_encode($arr);
                    exit;
                }
            }
         /*   if ($i == 999999){
                exit;
            }*/
            //更新配置信息
            /*   $site_options=<<<helllo
            {
                     "name":"name",
                     "url":"url"
                     "title":"$name",
                     "key":"$key",
                     "des":"$des"
         }
         helllo;*/
            //$query ="UPDATE `{$dbPrefix}config` SET  `value` = '{$url}' WHERE rname='url' ";
            //config system setup init
            /*
            mysql_query("UPDATE `{$dbPrefix}config` SET  `value` = '{$url}' WHERE name='url' ");
            mysql_query("UPDATE `{$dbPrefix}config` SET  `value` = '{$name}' WHERE name='name' ");
            mysql_query("UPDATE `{$dbPrefix}config` SET  `value` = '{$name}' WHERE name='title'");
            mysql_query("UPDATE `{$dbPrefix}config` SET  `value` = '{$key}' WHERE name='key'");
            mysql_query("UPDATE `{$dbPrefix}config` SET  `value` = '{$des}' WHERE name='des'");
             */
            //读取配置文件，并替换真实配置数据
            $strConfig = file_get_contents(SITEDIR . 'install/' . $configFile);
            $strConfig = str_replace('#DB_HOST#', $dbHost, $strConfig);
            $strConfig = str_replace('#DB_NAME#', $dbName, $strConfig);
            $strConfig = str_replace('#DB_USER#', $dbUser, $strConfig);
            $strConfig = str_replace('#DB_PWD#', $dbPwd, $strConfig);
            $strConfig = str_replace('#DB_PORT#', $dbPort, $strConfig);
            $strConfig = str_replace('#DB_PREFIX#', $dbPrefix, $strConfig);
            $strConfig = str_replace('#AUTHCODE#', sp_random_string(18), $strConfig);
            $strConfig = str_replace('#COOKIE_PREFIX#', sp_random_string(6) . "_", $strConfig);
            $strConfig = str_replace('#SERVER_URL#',$server_url , $strConfig);
            @chmod(SITEDIR . '/config.php',0777);
            @file_put_contents(SITEDIR . '/data/config.php', $strConfig);
            //插入管理员
            //生成随机认证码
            $verify = sp_random_string(6);
            $time = time();
            $create_date=date("Y-m-d h:i:s");
            $ip = get_client_ip();
            $ip =empty($ip)?"0.0.0.0":$ip;
            $password = md5($password);
            $salt = sha1($username.$password.time());
           // $query ="INSERT INTO `{$dbPrefix}user`(username,password,email,salt,level,ip,created,addtime)VALUES('{$username}', '{$password}', '{$email}', '{$salt}', '8','{$ip}','{$create_date}','{$time}');";
            $query ="INSERT INTO `{$dbPrefix}user`(username,password,email,salt,level,addtime)VALUES('{$username}', '{$password}', '{$email}', '{$salt}', '8','{$time}');";
            $conn->query($query);
            /*$message = '成功添加管理员<br />成功写入配置文件<br>安装完成．';*/
            /*$arr = array('status' => 'notice', 'msg' => $message);
            echo json_encode($arr);*/
            $arr = array('status' => 'success', 'msg' =>'恭喜您数据库初始化完成!');
            //$arr = array('status' => 'success', 'msg' =>$query);
            //$arr = array('n' => 999999, 'msg' => $message);
            echo json_encode($arr);
            exit;
        }
include_once ("./templates/s4.php");
exit();
case '5':
    	$ip = get_client_ip();
    	$host=$_SERVER['HTTP_HOST'];
        include_once ("./templates/s5.php");
        @touch('./install.lock');
        exit();
}

function testwrite($d) {
    $tfile = "_test.txt";
    $fp = @fopen($d . "/" . $tfile, "w");
    if (!$fp) {
        return false;
    }
    fclose($fp);
    $rs = @unlink($d . "/" . $tfile);
    if ($rs) {
        return true;
    }
    return false;
}

function sql_execute($sql, $tablepre) {
    $sqls = sql_split($sql, $tablepre);
    if (is_array($sqls)) {
        foreach ($sqls as $sql) {
            if (trim($sql) != '') {
                mysql_query($sql);
            }
        }
    } else {
        mysql_query($sqls);
    }
    return true;
}

function sql_split($sql, $tablepre) {
    $s_tablepre = "ros_";
    if ($tablepre != "ros_")
        $sql = str_replace("ros_", $tablepre, $sql);
    $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);

    if ($tablepre != $s_tablepre)
        $sql = str_replace($s_tablepre, $tablepre, $sql);
    $sql = str_replace("\r", "\n", $sql);
    $ret = array();
    $num = 0;
    $queriesarray = explode(";\n", trim($sql));
    unset($sql);
    foreach ($queriesarray as $query) {
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        $queries = array_filter($queries);
        foreach ($queries as $query) {
            $str1 = substr($query, 0, 1);
            if ($str1 != '#' && $str1 != '-')
                $ret[$num] .= $query;
        }
        $num++;
    }
    return $ret;
}

function _dir_path($path) {
    $path = str_replace('\\', '/', $path);
    if (substr($path, -1) != '/')
        $path = $path . '/';
    return $path;
}

// 获取客户端IP地址
function get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL)
        return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos)
            unset($arr[$pos]);
        $ip = trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

function dir_create($path, $mode = 0777) {
    if (is_dir($path))
        return TRUE;
    $ftp_enable = 0;
    $path = dir_path($path);
    $temp = explode('/', $path);
    $cur_dir = '';
    $max = count($temp) - 1;
    for ($i = 0; $i < $max; $i++) {
        $cur_dir .= $temp[$i] . '/';
        if (@is_dir($cur_dir))
            continue;
        @mkdir($cur_dir, 0777, true);
        @chmod($cur_dir, 0777);
    }
    return is_dir($path);
}

function dir_path($path) {
    $path = str_replace('\\', '/', $path);
    if (substr($path, -1) != '/')
        $path = $path . '/';
    return $path;
}

function sp_password($pw, $pre){
	$decor=md5($pre);
	$mi=md5($pw);
	return substr($decor,0,12).$mi.substr($decor,-4,4);
}

function sp_random_string($len = 6) {
	$chars = array(
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
			"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
			"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
			"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
			"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
			"3", "4", "5", "6", "7", "8", "9"
	);
	$charsLen = count($chars) - 1;
	shuffle($chars);    // 将数组打乱
	$output = "";
	for ($i = 0; $i < $len; $i++) {
		$output .= $chars[mt_rand(0, $charsLen)];
	}
	return $output;
}

?>