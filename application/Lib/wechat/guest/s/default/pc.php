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
    <title>å¾®ä¿¡è¿žWi-Fi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../default/statics/images/favicon.ico" rel="icon">
    <link rel="stylesheet" href="/guest/s/default/statics/css/style-pcdemo.css">

    <link rel="stylesheet" href="/guest/s/default/statics/css/site.css">


</head>

<body>
    <div class="container">
        <div class="header">

        </div>
    
        <div class="main" style="background-image: url(../default/statics/images/background1.jpg);">
            <!--å»ºè®®å›¾ç‰‡å¤§å°ä¸?1920x1200 æˆ?1920x1080-->
            <div class="main__content">
                <img class="mod-simple-follow-page__logo-img" src="/guest/s/default/statics/images/nophoto.gif" alt=""/>
                <h2 class="main__content-title">æ¬¢è¿Žä½¿ç”¨<em style="color: #139fdf;">å…è´¹Wi-Fi</em></h2>
                <?php echo $bssid; ?>
                <button style="border:0px" class="mod-simple-follow-page__attention-btn" id="applybtn" onclick="apply()">ä½¿ç”¨å¾®ä¿¡æ‰«æäºŒç»´ç </button>
				<button style="display:none;" style="border:0px" class="mod-simple-follow-page__attention-btn" id="regbtn" onclick="r_apply()">å…ˆç™»è®°ä¿¡æ¯</button>
            </div>
    
        </div>
    
        <div class="footer">
            <div class="footer_copyright"><a href="http://www.ubnt.com.cn">ä¼˜å€å¿«ç½‘ç»œå’¨è¯¢ï¼ˆä¸Šæµ·ï¼‰æœ‰é™å…¬å¸</a> Copyright Â© 2016 . All Rights Reserved.</div>
        </div>
    </div>
</body>
<script src="/guest/s/default/statics/js/jquery.js"></script>
<script type="text/javascript" src="/guest/s/default/statics/js/md5.js"></script>
<script type="text/javascript" src="/guest/s/default/statics/js/pcauth.js" ></script>
<script type="text/javascript">
var appId          = "<?php echo $appId ?>";
    var secretkey      = "<?php echo $secretkey ?>";
    var extend         = "<?php echo $extend ?>";    ã€€ã€€ã€€ //å¼€å‘è€…è‡ªå®šä¹‰å‚æ•°é›†åˆ
    var timestamp      = new Date().getTime();ã€€ã€€ã€€ã€€//æ—¶é—´æˆ?æ¯«ç§’)
    var shop_id        = "<?php echo $shop_id ?>";            ã€€ã€€  //APè®¾å¤‡æ‰€åœ¨é—¨åº—çš„ID
    var authUrl        = "<?php echo $portalServer ?>/guest/callback.php?httpCode=200&sid=<?php echo $sid ?>";        //æœåŠ¡å™¨å›žè°ƒåœ°å€ gwIdå½“å‰è¿žæŽ¥çš„è·¯ç”±çš„è®¾å¤‡ç¼–å·
    var mac            = "<?php echo $id ?>";  ã€€ã€€ã€€//ç”¨æˆ·æ‰‹æœºmacåœ°å€ å®‰å“è®¾å¤‡å¿…éœ€
    var ssid           = "<?php echo $ssid ?>";           //APè®¾å¤‡ä¿¡å·åç§°ï¼Œéžå¿…é¡»
    var bssid          = "<?php echo $bssid ?>";       //APè®¾å¤‡macåœ°å€ï¼Œéžå¿…é¡»

    function Wechat_GotoRedirect(appId, extend, timestamp, sign, shopId, authUrl, mac, ssid, bssid){
        //å°†å›žè°ƒå‡½æ•°åç§°å¸¦åˆ°æœåŠ¡å™¨ç«?
        var url = "https://wifi.weixin.qq.com/operator/callWechatBrowser.xhtml?appId=" + appId
                                                                            + "&extend=" + extend
                                                                            + "Ã—tamp=" + timestamp
                                                                            + "&sign=" + sign;
        //å¦‚æžœsignåŽé¢çš„å‚æ•°æœ‰å€¼ï¼Œåˆ™æ˜¯æ–?.1å‘èµ·çš„æµç¨?
        if(authUrl && shopId){
            url = "https://wifi.weixin.qq.com/operator/callWechat.xhtml?appId=" + appId
                                                                            + "&extend=" + extend
                                                                            + "Ã—tamp=" + timestamp
                                                                            + "&sign=" + sign
                                                                            + "&shopId=" + shopId
                                                                            + "&authUrl=" + encodeURIComponent(authUrl)
                                                                            + "&mac=" + mac
                                                                            + "&ssid=" + ssid
                                                                            + "&bssid=" + bssid;

        }
        //é€šè¿‡domæ“ä½œåˆ›å»ºscriptèŠ‚ç‚¹å®žçŽ°å¼‚æ­¥è¯·æ±‚
        var script = document.createElement('script');
        script.setAttribute('src', url);
        document.getElementsByTagName('head')[0].appendChild(script);
    }

    function callWechatBrowser(){
        var sign = $.md5(appId + extend + timestamp + shop_id + authUrl + mac + ssid + bssid + secretkey);
        try{
            Wechat_GotoRedirect(appId, extend, timestamp, sign, shop_id, authUrl, mac, ssid, bssid);
        } catch(e){
            alert("error!");
        }
    }

    var count = 0;

    function apply(){
        $("#applybtn").text("è¯·ç¨å€™æ­£åœ¨ç”ŸæˆäºŒç»´ç ...");
        $.post('/guest/getMinute.php?macid='+ mac, {}, function(data){
            if(data.success){

                $("#applybtn").attr('disabled', 'disabled');
                window.location.href = "qr.php";
            }else{
				$("#applybtn").attr('disabled', 'disabled');
				$("#applybtn").text("ä½ æ— æƒä½¿ç”¨WIFIç½‘ç»œ");	
				//setInterval("reg()", 1000);
				$("#regbtn").show();	
			 }
        }, 'json');
    }
	
	function r_apply(){
		document.location.href = "/guest/r/index.php";
		// $.post('/guest/r/index.php', function(data){
            // if(data.success){
                // location.hash = "openwechat";               
                // location.reload();
            // }
        // }, 'json');		
	}
	
	
    function reload(){
        window.location.hash = "pc-open";
        window.location.reload();
    }


    window.onload = function(){
        if(location.hash == "#pc-open"){
            window.location.href = "/guest/s/default/qr.php";

        }
    }
</script>
</html>