<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="renderer" content="webkit">   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <title>登录 - Cloud Hotspot</title>
    <link rel="icon" href="/favicon.ico?t=20160511" type="image/x-icon" />
    <link href="/Public/global.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jquery/2.2.2/jquery.min.js"></script>
    <style type="text/css">
    #switch_form{height: 40px;line-height: 40px;}
    #switch_form ul li{height: 40px;margin-right: 140px;text-align: center;
      cursor: pointer;}
    #switch_form ul li h3{
      text-align: center;
    font-size: 18px;
    font-weight: 400;
    color: #0c94de;
    }

    .header .logo{float:left;}
    .header ul {float: right;width: 60%;border: 1px solid white;height:100%;margin: 0px;}
    .header ul li{display: inline-block;width: 80px;height: 100%;line-height: 80px;}
    .menu{height: 80px;border-bottom:1px solid #ccc;overflow: hidden;position: fixed;top: 0px;z-index: 1000;width: 100%;}
  .menu__content{position:relative;margin:20px auto;width:80%;height:40px}
  .menu__content img{
   /* width: 208px;*/
    height: 68px;
    position: relative;
    top: -14px;
  }
  .menu__title{float:left;margin-top:-5px}
  .menu__link{display:block}
  .menu__logo{width:232px;height:46px}
  .menu .btn_home,.menu .btn_share{display:block;float:right;margin-left:27px;line-height:40px;font-size:20px;text-decoration:none}
 /* .menu .btn_share{width:120px;height:40px;line-height:40px;background:#31c27c;border-radius:20px;text-align:center}body{background:#fff;color:#000}*/
  i.email{
  /*  clear: both;
    position: relative;
    top: -46px;
    right: -54px;
    float: right;*/
    font-size: 12px;
  }
  i.pwd{font-size-adjust: 12px;}

    </style>
  </head>
<body style="overflow:hidden;">

<div class="header">

     <div class="menu">
      
      <div class="menu__content">
        <img src="/Public/cloud-hotspot.png">
       
        <a href="/user/sigin" role="button" class="btn_share" id="login-btn">商家中心</a>
      
    </div>
  </div>

</div>

<div class="main signin">
  <div class="center-content special-content">



    <div class="block special-block">
      
      <form method="POST" id="login" class="login-form" action="?" onsubmit="return check(this)">

        <div id="switch_form">
          <ul class="inline" style="height: 40px;">
            <li><a href="/user/sigin"><h3>登录</h3></a></li>
            <li><a href="/user/sigup"><h3>注册</a></h3></li>
          </ul>
        </div>

      
        <div id="manage">
          <input type="text" name="email" id="InputEmail" placeholder="邮箱/手机号" value="" autocomplete="off"/>
          <i class="email"></i>  
        </div>


        
        <input type="password" name="password" id="InputPassword" placeholder="请输入密码" autocomplete="off"/>


        <i class="pwd"></i>
        <div class="line advanced-line">
          <div class="remember-line">
            <a class="abright" id='forget' href="javascript:void(0);">忘记密码?</a>
          </div>
          <p class="error" id="verify"></p>
          <p class="error flash-error" id="error">
          </p>
        </div>

        <div class="align-center line">
          <button class="btn login" id="loginBtn" type="button">确认登录</button>
        </div>
      </form>
     
    </div>
  </div>
</div>

<div class="footer">
    <div class="center-content">

        <div class="main-footer">
           <!-- <div style="text-align: center;padding:8px;color: blue;">
                <a href="http://www.zjyouth.cn/" target="_blank">宁波优思网络技术有限公司</a>
            </div> -->
            <ul class="inline links">
                <li>Copyright © 2014-<?php echo date('Y',time());?> Power by Cloud Hotspot</li>              
            </ul>
        </div>
    </div>
</div>

<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>

<script type="text/javascript">

  $(document).ready(function() {
    
    $("#InputPassword").blur(function(event) {

      /* Act on the event */

      var password = $(this).val();

      if(password==''){

        return false;

      }



      if(password.length<6){


        $(event.target).siblings('i.pwd').html("<i class='fa error' style='color:red'>少于六位</i>");

        return false;

      }else{
        $(event.target).siblings('i.pwd').html("<i class='fa fa-check' style='color:green'>√</i>");
      }



    });

    $("#InputPassword").focus(function(event) {

      $(this).siblings('i.pwd').html('');


    });

      $("#InputEmail").blur(function(event) {
          var email = $(this).val();
          if(email==''){
              return false;
          }
          var type = 'email';
          if(testEmail(email)==false){
              type = 'username';
          }

          $.ajax({

              url: "<?php echo site_url('component/ajax/sigup');?>",

              type: 'POST',
              dataType: 'json',
              data: {'type':type,'email':email},

          })
          .done(function(message) {

              if(message.status=='ok'){

                  $(event.target).siblings('i.email').html("<i style='color:green;'>√</i>");


              }else if(message.status=='message'){
                  $(event.target).siblings('i.email').html("<i style='color:red;'>×</i>");

              }

          });

      });



    $("#InputEmail").focus(function(event) {

      $(this).siblings('i.email').html('');

      $(this).siblings('i.email').html('');

    });


     $("#forget").click(function(event) {
      /* Act on the event */

      var url = '/user/forget';
        layer.open({
          type: 2,
          title: '忘记密码',
          area: ['480px', '280px'],
          fix: true, //不固定
          maxmin: true,
          content: url
        });
    });

  });

   function testAccount(str){
      var flag = false;
      var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
      if(reg.test(str)) flag = true;        
      var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/; 
      if(myreg.test(str)) flag = true;
      return flag;        

  }


    function check (form) {

      

        if(!form['email'].value){
          $("i.email").html("<span style='color:red'>不能为空</span>");
          return false;
        }


      if(!form['password'].value){
        $("#InputPassword").siblings('i.pwd').html("<i style='color:red'>输入密码</i>");
        return false;

      }else if(form['password'].length<6){
        $("#InputPassword").siblings('i.pwd').html("<i style='color:red'>密码不能少于6位!</i>");
        return false;
      }

      $.ajax({
        url: "/component/login/post",
        type: 'POST',
        dataType: 'json',
        data: $('#login').serialize()
      })
      .done(function(ret) {
        if(ret.status=='false'){
          $("#error").html("<span style='color:red'>"+ret.message+"</span>");
        }
        if(ret.status=='ok'){
          window.location.href="<?php echo site_url('manage/index');?>";
        }
      });
      return false;
     
    }


  function testEmail(str){

      var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

      if(reg.test(str)){

          return true;

      }else{

          return false;

      }

  }


</script>

</body>
</html>
