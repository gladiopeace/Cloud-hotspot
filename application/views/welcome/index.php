<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>登录 - 云热点</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="icon" href="/favicon.ico?t=20160511" type="image/x-icon" />

    <link href="/Public/global.min.css" rel="stylesheet">

    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
  
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
    .menu{height: 80px;background: #272727;overflow: hidden;position: fixed;top: 0px;z-index: 1000;width: 100%;}
  .menu__content{position:relative;margin:20px auto;width:1000px;height:40px}
  .menu__title{float:left;margin-top:-5px}
  .menu__link{display:block}
  .menu__logo{width:232px;height:46px}
  .menu .btn_home,.menu .btn_share{display:block;float:right;margin-left:27px;line-height:40px;font-size:20px;color:#fff;text-decoration:none}.menu .btn_share{width:120px;height:40px;line-height:40px;background:#31c27c;border-radius:20px;text-align:center}body{background:#fff;color:#000}
  i.email{
  /*  clear: both;
    position: relative; 
    top: -46px;
    right: -54px;
    float: right;*/
    font-size: 6px;
  }
  i.pwd{font-size-adjust: 6px;}
    .center-content {
        padding: 20px 0;
        border-top: 1px solid #fff;
        position: relative;
        text-align: center;
    }
    </style>
  </head>
<body>


<div class="main signin">
  <div class="center-content special-content">



    <div class="block special-block">
      
      <form method="POST" id="login" class="login-form" action="?" onsubmit="return check(this)">
        
        <div id="switch_form">
          <ul class="inline" style="height: 40px;">
            <li><a href="<?php echo site_url('login');?>"><h3>登录</h3></a></li>
            <li><a href="<?php echo site_url('singup');?>"><h3>注册</a></h3></li>
          </ul>
        </div>
        <input type="hidden" name="goto" value="">
        <input type="text" name="email" id="InputEmail" placeholder="注册邮箱" value="">
      
        <i class="email"></i> 

        <input type="password" name="password" id="InputPassword" placeholder="密码">
        
      
        <i class="pwd"></i>                
        <div class="line advanced-line">
          <div class="remember-line">
           
            <a class="abright" href="<?php echo site_url('welcome/pwforgot');?>">忘记密码</a>
          </div>
          <p class="error" id="verify"></p>
          <p class="error flash-error" id="error">
            
          </p>
        </div>



        <div class="align-center line">
          <button class="btn login" id="loginBtn" type="submit">确认登录</button>
         
        </div>
       
      </form>


    </div>
   
  </div>
</div>
<div class="footer">
    <div class="center-content">



            <ul class="inline links">
                <li>Copyright © 2010 - 2016 Youth Network Technology Co.,Ltd All Rights Reserved.</li>
            </ul>

    

    </div>
</div>

<div id="box-bg" class="box-bg"></div>
<script type="text/javascript">
  
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

        url: "<?php echo site_url('component/ajax/singup');?>",

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

   function testEmail(str){

      var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

      if(reg.test(str)){

        return true;

      }else{

        return false;

      }

    }


     function check (form) {

      if(!form['email'].value){

       // alert('请输入用户名!');

        $("#InputEmail").siblings('p').find("span.icon").html("<span style='color:red'><i class='fa fa-times'></i></span>");

        $("#InputEmail").siblings('p').find("span.help").html("<span style='color:red'>请输入邮件地址</span>");

        return false;

      }



      if(!form['password'].value){



        $("#InputPassword").siblings('i.pwd').html("<i style='color:red'>输入密码</i>");



        return false;

      }else if(form['password'].length<6){


        $("#InputPassword").siblings('i.pwd').html("<i style='color:red'>密码不能少于6位!</i>");

        return false;

      }

       //$(".geetest").show('slow/400/fast');

      $.ajax({

        url: "<?php echo site_url('component/login/post');?>",

        type: 'POST',

        dataType: 'json',

        data: $('#login').serialize(),

      })

      .done(function(ret) {

        if(ret.status=='false'){

          $("#error").html("<span style='color:red'>"+ret.message+"</span>");

        }

        if(ret.status=='ok'){         

          window.parent.location.href="<?php echo site_url('manage/index');?>";

        }

      });


      return false;




    }


</script>
</body>
</html>