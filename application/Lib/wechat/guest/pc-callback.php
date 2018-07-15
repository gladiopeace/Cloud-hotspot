<?php

require_once('unifi/controller.php');
require_once('config/unifi.php');

$sid = isset($_GET['sid']) ? $_GET['sid'] : '';

if(!$sid){
    die('error');
}


session_id($sid);
session_start();

$macid = isset($_SESSION['macid']) ? $_SESSION['macid'] : '';

if(!$macid){
    die('error');
}


$controller = new Controller();
$controller->sendAuthorization($macid, $unifiMinutes);
?>

<!DOCTYPE html>
<html>
    <head lang="zh-CN">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="renderer" content="webkit">
        <meta charset="UTF-8">
        <title>微信连接Wi-Fi</title>
        <link rel="stylesheet" href="http://wximg.gtimg.com/tmt//wifi-landing-pc/dist/css/style-index.css"/>
    </head>
    <body>
        <div class="container">     
            <div class="main" style="background-image: url(/guest/s/default/statics/images/background1.jpg);">      
                <div class="main__content main__success">
                    <div class="main__laptop-img"></div>
                    <h2 class="main__content-title">Wi-Fi已成功连接</h2>
                    <div class="main__content-info">
                        欢迎光临UBNT
                    </div>
                </div>      
            </div>      
            <div class="footer">
                 <div class="footer_copyright"><a href="http://www.ubnt.com.cn">优倍快网络咨询（上海）有限公司</a> Copyright © 2016 . All Rights Reserved.</div>
            </div>
        </div>
    </body>
</html>