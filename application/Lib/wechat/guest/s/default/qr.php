<?php
    session_start();

    $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
    $ssid = isset($_SESSION['ssid']) ? $_SESSION['ssid'] : '';
    $bssid = isset($_SESSION['ap']) ? $_SESSION['ap'] : '';

    if(($id && $ssid && $bssid) == false){
    }

    require_once('../../config/wechat.php');
    $sid = session_id();
    $_SESSION['macid'] = $id;
?>
<!DOCTYPE HTML>
<html>
<head lang="zh-CN">
    <meta charset="UTF-8">
    <title>微信连Wi-Fi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <script type="text/javascript" src="../default/statics/js/pcauth.js" ></script>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../default/statics/css/style-pcdemo.css">
    <link href="http://static.ubnt.com.cn/us-ubnt-icon/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container">
        <div class="header">
            <a class="navbar-brand col-xs-8 ubnt-icon--logo-lockup" class="header__logo"  style="font-size: 8rem;color: #139fdf;"href="#"></a>
            <!--建议图片大小为570x140 或 287x70-->
        </div>
    
        <div class="main" style="background-image: url(../default/statics/images/background1.jpg);">
            <!--建议图片大小为 1920x1200 或 1920x1080-->
            <div class="main__content">
                <h2 class="main__content-title">欢迎使用<em style="color: #139fdf;">免费Wi-Fi</em></h2>
                <div class="main__content-qrcode" id='qrcode_zone' style="text-align:center;margin:20px auto;width:250px;"></div>
                <div class="main__content-info">使用微信扫描二维码（如果不扫描你只能使用2分钟WIFI网络）</div>
				
            </div>

        </div>
    
        <div class="footer">
            <div class="footer_copyright"><a href="http://www.ubnt.com.cn">优倍快网络咨询（上海）有限公司</a> Copyright © 2016 . All Rights Reserved.</div>
        </div>
    </div>
</body>
<script type="text/javascript">
    function reload(){
        window.location.hash = "pc-reload";
        window.location.reload();
    }

    JSAPI.auth({
        target : document.getElementById('qrcode_zone'),
        appId : '<?php echo $appId ?>',
        shopId : '<?php echo $shop_id ?>',
        extend : 'wechatpc',
        authUrl : '<?php echo $portalServer ?>/guest/pc-callback.php?httpCode=200&sid=<?php echo $sid ?>&macid=<?php echo $id ?>'
    });

</script>
</html>