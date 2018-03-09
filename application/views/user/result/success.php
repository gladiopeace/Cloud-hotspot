<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>云热点--密码重置成功</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">



<link rel="stylesheet" href="{{base_url}}/Public/static/css/base.css">
<link rel="stylesheet" href="{{base_url}}/static/css/common/common-less.css">

<link rel="stylesheet" href="{{base_url}}/Public/static/component/logic/login/login-regist.css">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/settings.css">
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>

<div id="main">


<div class="wcontainer">
    <div class="wwrap wrap-boxes">
        <div class="wheader-wrap">
            <h1>重设密码</h1>
        </div>
        <div class="pwd-reset-result">
            <i class="pwd-rstsuc-icon"></i>
            <div class="pwd-rstsuc-inner">
                <p class="pwd-rstsuc-txt">密码设置成功</p>
                <p><span id="pwd-rstsuc-timer" class="pwd-rstsuctm-wrap">6</span>秒后自动跳转到云热点首页</p>
            </div>
            <a href="{{base_url}}/" class="rlf-btn-green btn-block">返回首页</a>
        </div>
    </div>
</div>

</div>

<div id="footer">
    <div class="waper">
        <div class="footerwaper clearfix">
            <div class="followus r">
                <a class="followus-weixin" href="javascript:;" target="_blank" title="微信">
                    <div class="flw-weixin-box"></div>
                </a>
                <a class="followus-weibo" href="http://weibo.com/u/1786681670" target="_blank" title="新浪微博"></a>
                <a class="followus-qzone" href="http://jq.qq.com/?_wv=1027&k=XFXgp0" target="_blank" title="QQ交流群"></a>
            </div>
            <div class="footer_intro l">
               <!--  <div class="footer_link">
                   <ul>
                       <li><a href="{{base_url}}/Public/" target="_blank">网站首页</a></li>
                       <li><a href="{{base_url}}/Public/about/job" target="_blank">人才招聘</a></li>
                       <li> <a href="{{base_url}}/Public/about/contact" target="_blank">联系我们</a></li>
                       <li><a href="http://daxue.imooc.com/" target="_blank">高校联盟</a></li>
                       <li><a href="{{base_url}}/Public/about/us" target="_blank">关于我们</a></li>
                       <li> <a href="{{base_url}}/Public/about/recruit" target="_blank">讲师招募</a></li>
                       <li> <a href="{{base_url}}/Public/user/feedback" target="_blank">意见反馈</a></li>
                       <li> <a href="{{base_url}}/Public/about/friendly" target="_blank">友情链接</a></li>
                   </ul>
               </div> -->
                <p>Copyright © 2010 - 2015 Youth Network Technology Co.,Ltd All Rights Reserved.-浙ICP备11008151号</p>
            </div>
        </div>
    </div>
</div>
<div id="J_GotoTop" class="elevator">
    <a class="elevator-weixin" href="javascript:;">
        <div class="elevator-weixin-box">
        </div>
    </a>
   <!--  <a class="elevator-msg" href="{{base_url}}/Public/user/feedback" target="_blank" id="feedBack"></a>
   <a class="elevator-app" href="{{base_url}}/Public/mobile/app">
       <div class="elevator-app-box">
       </div>
   </a> -->
    <a class="elevator-top" href="javascript:;" style="display: block;" id="backTop"></a>
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



</body>
</html>
