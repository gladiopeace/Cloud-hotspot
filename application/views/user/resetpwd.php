<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>云热点重置密码</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">

<meta http-equiv="Access-Control-Allow-Origin" content="*">

<link rel="stylesheet" href="{{base_url}}/Public/static/css/base.css">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/common/common-less.css">

<link rel="stylesheet" href="{{base_url}}/Public/static/component/logic/login/login-regist.css">
<link rel="stylesheet" href="{{base_url}}/Public/static/css/settings.css">

<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="{{base_url}}/Public/js/center-dialog.js?t=20140403"></script>


</head>
<body>



<div id="main">

<div class="wcontainer">
    <div class="wwrap wrap-boxes">
        <div class="wheader-wrap">
            <h1>重设密码</h1>
        </div>
        <div class="pwd-reset-wrap">
            <form action="{{base_url}}/user/resetpwd" method="post" id="pagePwReset">
                <div class="wlfg-wrap">
                    <label class="label-name" for="">邮箱</label>
                    <div class="rlf-group">
                        <input type="text" name="email" disabled="disabled" readonly="readonly" class="rlf-input rlf-input-email" value="{{user['email']}}">
                        <p class="rlf-tip-wrap"></p>
                    </div>
                </div>
                <div class="wlfg-wrap">
                    <label class="label-name" for="newpass">新密码</label>
                    <div class="rlf-group">
                        <input type="password" data-validate="password" name="newpass" id="newpass" class="rlf-input rlf-input-pwd" placeholder="请输入密码">
                        <p class="rlf-tip-wrap">请输入6-16位密码，区分大小写，不能使用空格！</p>
                    </div>
                </div>
                <div class="wlfg-wrap">
                    <label class="label-name" for="confirm">确认密码</label>
                    <div class="rlf-group">
                        <input type="password" name="confirm" id="confirm" class="rlf-input rlf-input-pwd" placeholder="请输入密码">
                        <p class="rlf-tip-wrap">请输入确认密码！</p>
                    </div>
                </div>
                <div class="wlfg-wrap">
                    <label class="label-name" for=""></label>
                    <div class="rlf-group">
                        <span id="reset-submit" hidefocus="true" data-dismiss="modal" aria-role="button" class="rlf-btn-green btn-block">完成</span>
                    </div>
                </div>
                <input class="hideVal" type="hidden" name="accesskey"  value="{{user['accesskey']}}">
                <input class="hideVal" type="hidden" name="linkid"     value="{{user['id']}}">
                <input class="hideVal" type="hidden" name="secretkey"  value="{{user['secretkey']}}">
            </form>
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
    <a class="elevator-top" href="javascript:void(0);" style="display: block;" id="backTop"></a>
</div>
<script type="text/javascript">

    $("#newpass").blur(function(event) {
        /* Act on the event */
       var password = $(this).val();
       if(password.length<6){

        $(this).addClass('rlf-field-error').parent('div').find('.rlf-tip-wrap').text('请输入6-16位密码，区分大小写，不能使用空格！').addClass('rlf-tip-error');

       }else{
        $(this).parent('div').find('.rlf-tip-wrap').text('');
       }
    });

    $("#newpass").focus(function(event) {
        $(this).removeClass('rlf-field-error').parent('div').find('.rlf-tip-wrap').removeClass('rlf-tip-error');
    });

    $("#confirm").keyup(function(event) {
        /* Act on the event */
       var password = $("#newpass").val();
       var confirm = $(this).val();
       if(password!=confirm){

        $(this).addClass('rlf-field-error').parent('div').find('.rlf-tip-wrap').text('两次密码输入不一致！').addClass('rlf-tip-error');

       }else{
        $(this).removeClass('rlf-field-error').parent('div').find('.rlf-tip-wrap').text('').removeClass('rlf-tip-error');
       }
    });


    $("#reset-submit").click(function(event) {
        /* Act on the event */
        var password = $("#newpass").val();
        var confirm = $("#confirm").val();

        if(password.length<6){
            $("#newpass").addClass('rlf-field-error').focus().parent('div').find('.rlf-tip-wrap').text('请输入6-16位密码，区分大小写，不能使用空格！').addClass('rlf-tip-error');
            return false;
        }

        if(password!=confirm){
            $("#confirm").addClass('rlf-field-error').focus().parent('div').find('.rlf-tip-wrap').text('两次密码输入不一致！').addClass('rlf-tip-error');
            return false;
       }

      /* $("#pagePwReset").submit();*/

      $.ajax({
          url: "{{base_user}}/user/resetpwd/access",
          type: 'POST',
          dataType: 'json',
          data: $("#pagePwReset").serialize(),
      })
      .done(function(ret) {
         if(ret.status=='success'){
            window.location.href="{{base_url}}/user/resetpwd/result/success?accesskey={{user['accesskey']}}";
         }else if(ret.status=='gone'){
            window.location.href="{{base_url}}/user/resetpwd/result/error?accesskey={{user['accesskey']}}";
         }else if(ret.status=='none'){
            window.location.href="{{base_url}}/";
         }else{
           alert(ret.message);
         }

      });

    });


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
