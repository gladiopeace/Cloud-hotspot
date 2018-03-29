<!DOCTYPE html>
<html><head lang="zh-CN"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
    <title>微信连Wi-Fi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="{{template}}css/style-simple-follow.css">
    <style>

        #footer{
            position: relative;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            margin-top: 28px;
        }
        #footer p{    color: #999;}
    </style>
</head>
<body class="mod-simple-follow">
<div class="mod-simple-follow-page" style="margin: 0 auto;max-width: 800px">
    <div class="mod-simple-follow-page__banner">
        <img class="mod-simple-follow-page__banner-bg" src="{{template}}css//background.jpg" alt="">
        <div class="mod-simple-follow-page__img-shadow"></div>
        <div class="mod-simple-follow-page__logo">
            <img class="mod-simple-follow-page__logo-img" src="{{template}}css/t.weixin.logo.png" alt="">
            <p class="mod-simple-follow-page__logo-name"></p>
            <p class="mod-simple-follow-page__logo-welcome">欢迎您</p>
        </div>
    </div>
    <div class="mod-simple-follow-page__attention">
        <p class="mod-simple-follow-page__attention-txt">欢迎使用微信连Wi-Fi</p>
        <a class="mod-simple-follow-page__attention-btn" onclick="fech()">一键打开微信连Wi-Fi</a>
    </div>

    <div id="footer">
        <p class='text-center'>{{copyright['company']}}</p>
        <p class="text-center">Copyright © 2014-2018 Power by Cloud Hotspot</p>
    </div>
</div>




<div style="display: none">
    <form action="" name="start" method="get">
        <input type="hidden" name="auth_code">
        <input type="hidden" name="salt" value="{{config['salt']}}">
        <input type="submit">
    </form>

</div>
<script src="{{template}}js/jquery.min.js"></script>

<script type="text/javascript">
    var $_GET = (function(){
        var url = window.document.location.href.toString();
        var u = url.split("?");
        if(typeof(u[1]) == "string"){
            u = u[1].split("&");
            var get = {};
            for(var i in u){
                var j = u[i].split("=");
                get[j[0]] = j[1];
            }
            return get;
        } else {
            return {};
        }

    })();

    function fech(){
        $.ajax({
            url: '/portal/auth/fetch-wechat-code',
            type: 'POST',
            dataType: 'json',
            data: {'accesskey':"{{config['salt']}}",'mac':"{{config['mac']}}"}
        })
            .done(function(ret) {
                if(ret.status=='success'){
                    document.start.auth_code.value = ret.access_code;

                    verify(ret);

                }
            });

    }
    function verify(ret){

        $.ajax({
            url: '/portal/verify/wechat-auth',
            type: 'POST',
            dataType: 'json',
            data: {'accesskey':"{{config['salt']}}",'mac':"{{config['mac']}}",'auth_code':ret.access_code}
        })
            .done(function(ret) {
                console.log(ret);
                if(ret.status=='success'){
                    document.start.action=ret.ip; //'http://'+ret.ip+'/login';
                    document.start.submit();//=ret.ip;
                }
            });

    }
</script>
</body>
</html>