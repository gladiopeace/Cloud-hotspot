<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>云热点--邮箱验证链接过期</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Access-Control-Allow-Origin" content="*">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/base.css">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/common/common-less.css">

<link rel="stylesheet" href="{{base_url}}/Public/static/component/logic/login/login-regist.css">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/settings.css">
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>




<div id="main">


<div class="wcontainer">
    <div class="wwrap wrap-boxes">
        <div class="wheader-wrap">
            <h1>邮箱验证</h1>
        </div>
        <div class="pwd-reset-result">
            <i class="pwd-rsterror-icon"></i>
            <div class="pwd-rstsuc-inner">
                <p class="pwd-rstsuc-txt">邮箱验证链接过期</p>
                <p>
                    你的邮箱 <?php echo $user['email'];?> 验证失败 <br>
                    <span id="pwd-rstsuc-timer" class="pwd-rstsuctm-wrap">6</span>秒后自动跳转到云热点首页
                </p>
            </div>
            <a href="{{base_url}}/" class="rlf-btn-green btn-block">返回首页</a>
        </div>
    </div>
</div>

</div>

<script type="text/javascript">


    var EndTime=6;
    var intvalue=0;
    var timer2=null;

    function startShow(){
        intvalue ++;
        document.getElementById("pwd-rstsuc-timer").innerHTML="&nbsp;" + ((EndTime-intvalue)%60).toString();
       //  console.log(intvalue);
       // console.log(EndTime);
        if(intvalue==EndTime){
            //document.getElementById("pwd-rstsuc-timer").innerHTML="重发!";

            endShow();

        }
    }

    function endShow(){
        window.clearTimeout(timer2);

        intvalue=0;
        timer2=null;
        window.location.href="{{base_url}}/";
    }




    timer2=window.setInterval("startShow()",1000);



var showRegDialog = function(){
  $.centerDialog({
    width:400,
    height:400,
    content:'<iframe src="/component/singup" width="360" height="360" frameborder="no" noborder="yes" style="text-align:center;padding:0 auto;" class="text-center"></iframe>'
  });
}

var showLoginDialog = function(){
  $.centerDialog({
    id:'loginDialog',
    width:400,
    height:400,
    content:'<iframe src="/component/login" width="360" height="360" frameborder="no" noborder="yes" style="text-align:center;" class="text-center"></iframe>'
  });
}


$(document).ready(function(){

  $("#js-signin-btn").click(function(){
    showRegDialog();
  })
    $("#js-signup-btn").click(function(){
    showLoginDialog();
  })

});

</script>
</body></html>
