<?php
    session_start();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $ssid = isset($_GET['ssid']) ? $_GET['ssid'] : '';
    $bssid = isset($_GET['ap']) ? $_GET['ap'] : '';

    if(($id && $ssid && $bssid) == false){
    }

    require_once('../../config/wechat.php');
    $sid = session_id();
    $_SESSION['id'] = $id;
    $_SESSION['ssid'] = $id;
    //$_SESSION['ap'] = $id;
	$_SESSION['ap'] = $bssid;
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
    <link rel="stylesheet" href="/guest/s/default/statics/css/style-simple-follow.css"/>
</head>
<script type="text/javascript">
    var appId          = "<?php echo $appId ?>";
    var secretkey      = "<?php echo $secretkey ?>";
    var extend         = "<?php echo $extend ?>";    //开发者自定义参数集合
    var timestamp      = new Date().getTime();       //时间�?毫秒)
    var shop_id        = "<?php echo $shop_id ?>";   //AP设备所在门店的ID
    var authUrl        = "<?php echo $portalServer ?>/guest/callback.php?httpCode=200&sid=<?php echo $sid ?>";        //服务器回调地址 gwId当前连接的路由的设备编号
    var mac            = "<?php echo $id ?>";        //用户手机mac地址 安卓设备必需
    var ssid           = "<?php echo $ssid ?>";      //AP设备信号名称，非必须
    var bssid          = "<?php echo $bssid ?>";     //AP设备mac地址，非必须
    function is_mobile() {
        var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
        var u = navigator.userAgent;
        if (null == u) {
            return true;
        }
        var result = regex_match.exec(u);
        if (null == result) {
            return false
        } else {
            return true
        }
     }
     if (is_mobile()) {
     }
     else{
        document.location.href = "/guest/s/default/pc.php";
      }
 </script>
<body class="mod-simple-follow">
<div class="mod-simple-follow-page">
    <div class="mod-simple-follow-page__banner">
        <img class="mod-simple-follow-page__banner-bg" src="/guest/s/default/statics/images/background1.jpg" alt=""/>
        <div class="mod-simple-follow-page__img-shadow"></div>
        <div class="mod-simple-follow-page__logo">
            <img class="mod-simple-follow-page__logo-img" src="/guest/s/default/statics/images/nophoto.gif" alt=""/>
            <p class="mod-simple-follow-page__logo-name"></p>
            <p class="mod-simple-follow-page__logo-welcome">UBNT欢迎你</p>
        </div>
    </div>
    <div class="mod-simple-follow-page__attention">
		<?php echo $bssid; ?>
        <p class="mod-simple-follow-page__attention-txt">欢迎使用微信连Wi-Fi</p>
        <button style="border:0px" class="mod-simple-follow-page__attention-btn" id="applybtn" onclick="apply()">一键打开微信连Wi-Fi</button>
    </div>
    <div class="mod-simple-follow-page__attention">        
        <button style="display:none;" style="border:0px" class="mod-simple-follow-page__attention-btn" id="regbtn"onclick="r_apply()">先登记信息</button>
    </div>
</div>
</body>
<script src="/guest/s/default/statics/js/jquery.js"></script>
<script type="text/javascript" src="/guest/s/default/statics/js/md5.js"></script>
<script type="text/javascript">

    function Wechat_GotoRedirect(appId, extend, timestamp, sign, shopId, authUrl, mac, ssid, bssid){
        //将回调函数名称带到服务器�?
        var url = "https://wifi.weixin.qq.com/operator/callWechatBrowser.xhtml?appId=" + appId
                                                                            + "&extend=" + extend
                                                                            + "×tamp=" + timestamp
                                                                            + "&sign=" + sign;
        //如果sign后面的参数有值，则是�?.1发起的流�?
        if(authUrl && shopId){
            url = "https://wifi.weixin.qq.com/operator/callWechat.xhtml?appId=" + appId
                                                                            + "&extend=" + extend
                                                                            + "×tamp=" + timestamp
                                                                            + "&sign=" + sign
                                                                            + "&shopId=" + shopId
                                                                            + "&authUrl=" + encodeURIComponent(authUrl)
                                                                            + "&mac=" + mac
                                                                            + "&ssid=" + ssid
                                                                            + "&bssid=" + bssid;

        }
        //通过dom操作创建script节点实现异步请求
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
        $("#applybtn").text("请稍侯正在等待授权 0 秒..");
        $.post('/guest/getMinute.php', {}, function(data){
            if(data.success){
                $("#applybtn").attr('disabled', 'disabled');
                setInterval("fresh()", 1000);
            }else{
				//$("#applybtn").attr('disabled', 'disabled');
				$("#applybtn").text("你无权使用WIFI网络");
				$("#regbtn").show();						
			}

        }, 'json');
    }
	
	
	function r_apply(){
		document.location.href = "/guest/r/index.php";	
	}	
	
	
    function countDown(){
        count++;
        $("#applybtn").text("请稍候正在等待授权 " + count + " 秒..").attr('disabled', 'disabled');
    }

    function fresh(){
        countDown();
        $.get('http://wx.ubnt.com.cn/success.php', function(data){
            if(data.success){
                location.hash = "openwechat";
                // alert(location.hash);
                location.reload();
            }
        }, 'json');
    }

    window.onload = function(){
        if(location.hash == "#openwechat"){
            $("#applybtn").text("正在启动微信...").attr('disabled', 'disabled');
            setTimeout("callWechatBrowser()", 2000);
        }
    }
</script>
<script type="text/javascript" src="/guest/s/default/statics/js/wechatutil.js" ></script>
</html>