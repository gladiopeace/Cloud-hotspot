<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>注册 - 云热点</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="favicon.ico?t=20160511" type="image/x-icon" />
    <link href="/Public/global.min.css" rel="stylesheet">
     <script src="/Public/hotspot/js/jquery.min.js"></script>
  
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

    </style>
  </head>
<body>


<div class="main signin">
  <div class="center-content special-content">



    <div class="block special-block">
      
      <form method="POST" id="singup" class="login-form" action="?" onsubmit="return check(this)">
        
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
        <input type="password" name="confirm" id="InputConfirm" placeholder="确认密码">
        <i class="conf"></i> 

        
        <div class="align-center line">
          <button class="btn login" id="loginBtn" type="submit">立即注册</button>
         
        </div>
      </form>


    </div>
   
  </div>
</div>
<div class="footer">
    <div class="center-content">
        <div class="main-footer">
            <ul class="inline links">
                <li>Copyright © 2010 - 2016 Youth Network Technology Co.,Ltd All Rights Reserved.</li>

            </ul>
        </div>
    

    </div>
</div>

<div id="box-bg" class="box-bg"></div>
<script type="text/javascript">
   function check (form) {
      if(!form['email'].value){
       // alert('请输入用户名!');
        $("#InputEmail").siblings('i.email').html("<i style='color:red'>输入邮箱</i>");
        return false;
      }

      if(!form['password'].value){

        $("#InputPassword").siblings('i.pwd').html("<i style='color:red'>输入密码</i>");

        return false;
      }else if(form['password'].length<6){
        $("#InputPassword").siblings('i.pwd').html("<i style='color:red'>少于6位!</i>");
        return false;
      }

      if(!form['confirm'].value){
        $("#InputConfirm").siblings('i.conf').html("<i style='color:red'>输入确认密码!</i>");
        return false; 
      }

      if(form['confirm'].value!=form['password'].value){
        $("#InputConfirm").siblings('i.conf').html("<i style='color:red'>密码不一致</i>");
       
        return false;
      }
    

      //$(".geetest").show('slow/400/fast');    

      $.ajax({
        url: "<?php echo site_url('component/singup/post');?>",
        type: 'POST',
        dataType: 'json',
        data: $('#singup').serialize(),
      })
      .done(function(ret) {
        

        if(ret.status=='success'){         

          window.parent.location.href=ret.url;          

        }else{

        }
      });
      
      return false;

      //return true;
    }



    $("#InputEmail").blur(function(event) {
      var email = $(this).val();
      if(email==''){
        return false;
      }

      if(testEmail(email)==false){
          $(event.target).siblings('i.email').html("<i style='color:red'>邮箱错误</i>");
        return false;
      }
      $.ajax({
        url: "<?php echo site_url('component/ajax/singup');?>",
        type: 'POST',
        dataType: 'json',
        data: {'type': 'email','email':email},
      })
      .done(function(message) {
        if(message.status=='ok'){
          $(event.target).siblings('i.email').html("<i style='color:green'>可以注册</i>");
          /*$(event.target).siblings('p').append("<span style='color:green;'>可以使用</span>");*/
        }else if(message.status=='message'){          
          $(event.target).siblings('i.email').html("<i style='color:red'>已经注册</i>");          
        }else if(message.status=='error'){
          
          $(event.target).siblings('i.email').html("<i style='color:red'>已经注册</i>");          
        }
      });
    });

    $("#InputEmail").focus(function(event) {
      $(this).siblings('i.email').html('');
      $(this).siblings('i.email').html('');
    });


    $("#InputPassword").blur(function(event) {
      /* Act on the event */
      var password = $(this).val();
      if(password==''){
        return false;
      }

      if(password.length<6){
        $(event.target).siblings('i.pwd').html("<i style='color:red'>小于6位</i>");     
        return false;
      }else{
        $(event.target).siblings('i.pwd').html("<i class='fa fa-check' style='color:green'>√</i>");      

      }
    });

    $("#InputPassword").focus(function(event) {
      $(this).siblings('i.pwd').html('');
      $(this).siblings('i.pwd').html('');
    });

    $("#InputConfirm").blur(function(event) {
      /* Act on the event */
      var password = $(this).val();
      if(password==''){
        return false;
      }


      var confirm = $("#InputPassword").val();
    
      if(password!=confirm){
        $(event.target).siblings('i.conf').html("<i style='color:red'>密码不一致!</i>"); 
              
        return false;
      }else{
        $(event.target).siblings('i.conf').html("<i class='fa fa-check' style='color:green'>√</i>");       

      }
    });

    $("#InputConfirm").focus(function(event) {
      $(this).siblings('i.conf').html('');
      $(this).siblings('i.conf').html('');
    });

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