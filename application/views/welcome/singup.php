<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title>商家登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  <link class="bootstrap library" rel="stylesheet" type="text/css" href="http://sandbox.runjs.cn/js/sandbox/bootstrap-2.2.0/css/bootstrap.min.css">
  <script class="bootstrap library" src="http://sandbox.runjs.cn/js/sandbox/jquery/jquery-1.7.2.min.js" type="text/javascript"></script>
  <script class="bootstrap library" src="http://sandbox.runjs.cn/js/sandbox/bootstrap-2.2.0/js/bootstrap.min.js" type="text/javascript"></script>
     <style>*{margin:0;padding: 0;}
      body{background: #444 url(http://sandbox.runjs.cn/uploads/rs/418/nkls38xx/carbon_fibre_big.png)}
      .loginBox{
          background-color: white;margin: 0  auto;margin-top:4%;width: 60%;
      }
      .help-inline{position: relative;top: -6px;}

    </style>
  </head>
  <body>
    
        <section class="loginBox row-fluid">
         <div class="container-fluid">
          <div class="row-fluid">
            <div class="span12">
              <form action="?" method="post" onsubmit="return check(this)">
                <fieldset>
                  <legend>用户注册</legend>
                 
                  <div class="control-group">
                    <label class="control-label" for="inputUsername">用户名:</label>
                    <div class="controls">
                      <input type="text" name="username" id="inputUsername" placeholder="请输入用户名">
                      <span class="help-inline"><i></i></span>
                    </div>

                  </div>


                  <div class="control-group">
                    <label class="control-label" for="inputPassword">设定密码:</label>
                    <div class="controls">
                      <input type="password" name="password" id="inputPassword" placeholder="登录密码">
                      <span class="help-inline"><i></i></span>
                    </div>
                  </div>


                  <div class="control-group">
                    <label class="control-label" for="inputConfirm">确认密码:</label>
                    <div class="controls">
                      <input type="password" name="confirm" id="inputConfirm" placeholder="请再次输入登录密码">
                      <span class="help-inline"><i></i></span>
                    </div>
                  </div>


                  

                   <div class="control-group">
                    <label class="control-label" for="inputEmail">邮箱地址:</label>
                    <div class="controls">
                      <input type="email" id="inputEmail" name="email" placeholder="请输入邮箱地址">
                      <span class="help-inline"><i></i></span>
                    </div>
                  </div>


                    <button type="submit" class="btn btn-primary" style="width:100px;">注册</button>
                    <span class="help-block" style="position: relative;top:-26px;right:-110px;">
                      <a href="<?php echo site_url('welcome/login');?>">已有账号,立刻登录</a>
                    </span>

                </fieldset>
              </form>
            </div>
          </div>
        </div>
        </section><!-- /loginBox -->

  </body>
  <script>
    function check (form) {
      if(!form['username'].value){
       // alert('请输入用户名!');
       $("#inputUsername").siblings('span').css('color', 'red').text('请输入用户名').prepend("<i class='icon-remove'></i>")
        //form['username'].focus();
        return false;
      }

      if(!form['password'].value){
       $("#inputPassword").siblings('span').css('color', 'red').text('请输入密码').prepend("<i class='icon-remove'></i>")
        
        //alert('请输入密码!');
        //form['password'].focus();
        return false;
      }else if(form['password'].length<6){
        //alert('密码不能少于6位!');
        form['password'].focus();
        return false;
      }

      if(!form['confirm'].value){
        $("#inputConfirm").siblings('span').css('color', 'red').text('请输入确认密码').prepend("<i class='icon-remove'></i>")
        return false; 
      }


      if(form['confirm'].value!=form['password'].value){
        $("#inputConfirm").siblings('span').css('color', 'red').text('密码不一致').prepend("<i class='icon-remove'></i>")
        
        //alert('密码不一致!');
       // form['confirm'].focus();
        return false;
      }

      if(!form['email'].value){
        $("#inputEmail").siblings('span').css('color', 'red').text('请输入邮箱!').prepend("<i class='icon-remove'></i>")

         //form['email'].focus();
        //alert('请输入邮箱!');
        return false;
      }else{
         var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;  
          if (!pattern.test(form['email'].value)) {  
              //alert('请输入正确邮箱地址');
              $("#inputEmail").siblings('span').css('color', 'red').text('请输入正确的邮箱!').prepend("<i class='icon-remove'></i>")
              //form['email'].focus();             
              return false;  
          } 
      }

      return true;
    }

    $("#inputUsername").blur(function(event) {
      /* Act on the event */
      var username = $(this).val();
      if(username==''){
        return false;
      }
      $.ajax({
        url: "<?php echo site_url('welcome/ajax/singup');?>",
        type: 'POST',
        dataType: 'json',
        data: {'type': 'username','username':username},
      })
      .done(function(message) {
        if(message.status=='ok'){
          $(event.target).siblings('span').append("<i class='icon-ok'></i>");
        }else if(message.status=='error'){
          $(event.target).siblings('span').css('color', 'red').text('已经注册').prepend("<i class='icon-remove'></i>");
        }
      });
      
      
    });
    
    $("#inputUsername").focus(function(event) {
     $(this).siblings('span').html('');
    });

     $("#inputEmail").blur(function(event) {
      /* Act on the event */
      var email = $(this).val();
      if(email==''){
        return false;
      }

      var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;  
      if (!pattern.test(email)) {  
          $(this).siblings('span').css('color', 'red').text('请输入正确邮箱地址').prepend("<i class='icon-remove'></i>");
          ("#inputEmail").focus();
          return false;  
      } 


      $.ajax({
        url: "<?php echo site_url('welcome/ajax/singup');?>",
        type: 'POST',
        dataType: 'json',
        data: {'type': 'email','email':email},
      })
      .done(function(message) {
        if(message.status=='ok'){
          $(event.target).siblings('span').append("<i class='icon-ok'></i>");
        }else if(message.status=='error'){
          $(event.target).siblings('span').css('color', 'red').text('已经注册').prepend("<i class='icon-remove'></i>");
        }
      });
      
      
    });
    $("#inputEmail").focus(function(event) {
     $(this).siblings('span').html('');
    });


    $("#inputPassword").blur(function(event) {
      /* Act on the event */
      var password = $(this).val();
      if(password==''){
        return false;
      }

      if(password.length<6){
        $(this).siblings('span').css('color', 'red').text('密码不得小于6位').prepend("<i class='icon-remove'></i>");        
        return false;
      }else{
        $(this).siblings('span').css('color', 'red').append("<i class='icon-ok'></i>");        

      }
    });

    $("#inputPassword").focus(function(event) {
     $(this).siblings('span').html('');
    });

    $("#inputConfirm").blur(function(event) {
      /* Act on the event */
      var password = $(this).val();
      if(password==''){
        return false;
      }


      var confirm = $("#inputPassword").val();
    
      if(password!=confirm){
        $(this).siblings('span').css('color', 'red').text('密码不一致!').prepend("<i class='icon-remove'></i>");        
        return false;
      }else{
        $(this).siblings('span').css('color', 'red').append("<i class='icon-ok'></i>");        

      }
    });

    $("#inputConfirm").focus(function(event) {
     $(this).siblings('span').html('');
    });

  </script>
</html>

