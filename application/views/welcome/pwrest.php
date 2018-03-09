<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



<meta charset="utf-8">



<title> 云热点-忘记密码</title>



<meta name="renderer" content="webkit">



<meta http-equiv="Access-Control-Allow-Origin" content="*">



<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css">








<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>





<style type="text/css">
  
  #js-g-forgot-error{
    color: red;
  }
</style>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->



<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>




<link rel="stylesheet" href="<?php echo base_url();?>Public/static/css/loginsign-less.css">



<link rel="stylesheet" href="http://www.imooc.com/static/css/settings.css">



<link href="<?php echo base_url();?>Public/hotspot/style/bootstrap.min.css" rel="stylesheet">



  <!-- <link href="http://cdn.bootcss.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"> -->



  <link href="<?php echo base_url();?>Public/hotspot/style/font-awesome.min.css" rel="stylesheet">




  <link href="<?php echo base_url();?>Public/hotspot/style/site.min.css?v3" rel="stylesheet">



    





  <link rel="icon" href="/favicon.ico?t=20160511" type="image/x-icon" />
  


   

   



  </head>







  <body class="home-template">









<div id="main">







<div class="wcontainer">



    <div class="wwrap wrap-boxes">



        <div class="wheader-wrap">



            <h1>忘记密码</h1>



        </div>



        <div class="page-forgotpwd">



            <div class="page-forgotpwd-wrap">



                <div class="js-forgotpwd-form-wrap">



                    <h4>通过注册邮箱链接重设密码</h4>



           



                    <form id="js-forgot-form">



                         <div class="form-group">    



                        <div class="input-group input-group">



                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>







                          <input type="text" id="Email_input" class="form-control" placeholder="请输入登录邮箱">



                        </div>



                        </div>



                         <div class="form-group">







                         <div class="input-group input-group text-center">



                         



                          <input type="text" id="verify" class="form-control" style="width:40%;" placeholder="请输入验证码">



                           <img id="verify_code" src="<?php echo site_url('welcome/yzm');?>" style="" alt="验证码" title="验证码">

                            &nbsp;&nbsp;&nbsp;&nbsp;

                           <a href="javascript:void(0);" onclick="changeCode();" class="js-change-verify-code">看不清?</a>



                        </div>



                        



                        </div>



                        <div>



                            <p class="tips" id="js-g-forgot-error">&nbsp;</p>



                            <div>



                                <a href="javascript:void(0);" id="js-forgot-submit" class="btn-mc btn-mc-green link-btn btn-mc-block">提交</a>



                            </div>



                            <p class="login-addon"><br><a href="<?php echo site_url('welcome/index');?>"> 返回立即登录</a></p>



                        </div>



                    </form>



                </div>







                <div class="js-forgot-result forgot-send-result">



                    <i></i>



                    <p>

                    密码重设连接邮件已发送到您的邮箱<em></em><br>



                    请注意查收并重新设置密码



                    </p>



                    <a href="<?php echo site_url('welcome/index');?>" class="btn-mc btn-mc-green link-btn btn-mc-block">返回登录</a>



                </div>



            </div>



        </div>



    </div>



</div>







</div>







<div id="footer">



      <footer class="footer ">



      <div class="container">




        <div class="row footer-bottom">



          <!-- <ul class="list-inline text-center"> -->



          <ul class="list text-center">



            <li><a href="http://www.zjyouth.cn/" target="_blank">宁波优思网络技术有限公司--</a><a href="http://www.miibeian.gov.cn/" target="_blank">浙ICP备11008151号</a></li>



            <li>Copyright © 2010 - 2014 <a href="http://www.zjyouth.cn" target="_blank">Youth Network Technology Co.,Ltd </a> All Rights Reserved.</li>



           



          </ul>



           



        </div>



      </div>



</footer>



    



</div>





<script type="text/javascript">

  

  $("#js-forgot-submit").bind('click',function(event) {
    
    var mail = document.getElementById("Email_input").value;

    //对电子邮件的验证

    var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

    if(!myreg.test(mail)){

        alert('提示\n\n请输入有效的E_mail！');

        document.getElementById("Email_input").focus();

        return false;

    }

    var verify = document.getElementById("verify").value;

    if(verify.length<5){

      alert('验证码不能小于5位');

      document.getElementById("verify").focus();

      return false;

    }

    $(this).text('正在提交……');
    var $this = $(this);

    $.ajax({

      url: "<?php echo site_url('user/email/forget/get');?>",

      type: 'POST',

      dataType: 'json',

      data: {'email': mail,'verify':verify},

    })

    .done(function(ret) {

      if(ret.status=="success"){
        $(".js-forgotpwd-form-wrap").hide();
        var $result = $(".js-forgot-result");
        if(ret.flag=='ok'){
          $result .find('p').append('<br/>'+ret.html);
        }
        $result.find('p em').text(ret.email);
        $result.show();

      }else if(ret.status=="false"){
        $("#js-g-forgot-error").text(ret.message);
        $this.text('提交');
        changeCode();
      }

    });
  });



  function changeCode(){

     document.getElementById("verify_code").src="<?php echo site_url('welcome/yzm');?>?r=" + Math.random();  

  }  

  function rtips(){
    $("#js-g-forgot-error").html("&nbsp;");
  }

  $("#Email_input").bind('focus', function(event) {
    rtips();
  });

  $("#verify").bind('focus', function(event) {
    rtips();
  });


</script>





</body>

</html>