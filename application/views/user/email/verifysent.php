<!DOCTYPE html>
<!-- saved from url=(0039)http://www.imooc.com/user/setverifysent -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>云热点</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<meta property="qc:admins" content="77103107776157736375">
<meta property="wb:webmaster" content="c4f857219bfae3cb">
<meta http-equiv="Access-Control-Allow-Origin" content="*">

<meta http-equiv="Access-Control-Allow-Origin" content="*">

<link rel="stylesheet" href="{{base_url}}/Public/static/css/base.css">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/common/common-less.css">

<link rel="stylesheet" href="{{base_url}}/Public/static/component/logic/login/login-regist.css">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/settings.css">
<body>


<div id="main">


<style>
.mail-label{margin-left: 30px;}
.result-container h1{margin: 20px 0 ;color: #333;}
.bottom{width:800px;margin: 30px auto;border-top: 1px solid #d0d6d9;}
.bottom .link-goback{display: inline-block;margin: 30px 0 0 30px;color: #fff;font-size: 14px;background-color: #333;height: 40px;line-height: 40px;width: 120px;cursor: pointer;text-align: center;-webkit-transition: background-color 0.2s;-moz-transition: background-color 0.2s;-o-transition: background-color 0.2s;transition: background-color 0.2s;}
.bottom .link-goback:hover{background-color: #444;}
.bottom .sbtn-green{margin-top: 30px;}
</style>

<div class="wcontainer">
    <div class="wwrap wrap-boxes">
        <div class="wheader-wrap">
            <h1>邮箱验证</h1>
        </div>
        <div class="result-container sent-success">
            <i></i>
            <h1>我们向您{{user['email']}}发送了验证邮件</h1>
            <p>验证邮箱可以更好的保护您的账户安全，请及时验证！<span class="mail-label">没收到？</span><span class="sent-again"><span class="js-resend resend" data-from="reg" data-t="60">再次发送验证邮件</span></span></p>
            <div class="bottom">
                <a href="{{url}}" target="_blank" class="sbtn-green rlf-btn-green">去邮箱验证</a>
                <a class="link-goback" href="{{base_url}}/user/email/change?accesskey={{user['accesskey']}}&secretkey={{user['secretkey']}}">更改邮箱</a>
            </div>

        </div>
    </div>
</div>

</div>


</body>
</html>
