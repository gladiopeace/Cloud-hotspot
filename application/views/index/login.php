<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>注册 - Cloud Hotspot</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
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
    width: 208px;
    height: 68px;
    position: relative;
    top: -14px;
    }
  .menu__title{float:left;margin-top:-5px}
  .menu__link{display:block}
  .menu__logo{width:232px;height:46px}
  .menu .btn_home,.menu .btn_share{display:block;float:right;margin-left:27px;line-height:40px;font-size:20px;text-decoration:none}
 /* .menu .btn_share{width:120px;height:40px;line-height:40px;background:#31c27c;border-radius:20px;text-align:center}body{background:#fff;color:#000}*/
  .getEmail{
    width: 88px;
    height: 35px;
    line-height: 35px;
    position: absolute;
    text-align: center;
    right: 142px;
    float: right;
    color: white;
    cursor: pointer;
    background-color: #47B347;
  }
  i.email{
  clear: both;
/*   position: relative;
top: -46px;
right: -54px;
float: right; */
  font-size: 12px;
  
  }
  i.pwd{font-size-adjust:12px;}

    </style>
  </head>
  
<body style="overflow: hidden;">


<div class="header">

     <div class="menu">
    <div class="menu__content">
        <img src="/Public/yousihaodian.png">
      
       
        <a href="/user/singin" role="button" class="btn_share" id="login-btn">商家中心</a>
       </a>

    </div>
  </div>

</div>

<div class="main signin">
  <div class="center-content special-content">



    <div class="block special-block">
      
      <form method="POST" id="singup" class="login-form" action="?" onsubmit="return check(this)">
        
         <div id="switch_form">
          <ul class="inline" style="height: 40px;">
            <li><a href="/user/singin"><h3>登录</h3></a></li>
            <li><a href="/user/singup"><h3>注册</a></h3></li>
          </ul>
        </div>
        <input type="hidden" name="goto" value="">
        <div style="position: static;">
          <input type="text" name="account" id="account" placeholder="邮箱/手机号码" value="">
      
          <i class="email"></i> 

        </div>
        <div style="position: static;">
            <input type="text" name="code" id="code" placeholder="验证码">
            <span class="getEmail" id="vcode">获取验证码</span> 
            <i class="emailCode"></i> 
            <input type="hidden" id="auth_salt" name="auth_salt" value="">
        </div>
        <input type="password" name="password" id="password" placeholder="登录密码">
        <i class="pwd"></i>         
        <input type="password" name="confirm" id="confirm" placeholder="确认密码">
        <i class="conf"></i>         
        <div class="align-center line">
          <button class="btn login" id="submit" type="button">立即注册</button>
         
        </div>
      </form>

    </div>
   
  </div>
</div>
<div class="footer">
    <div class="center-content">

        <div class="main-footer">

           <div style="text-align: center;padding:8px;color: blue;">
                <a href="http://www.zjyouth.cn/" target="_blank">宁波优思网络技术有限公司</a>&nbsp;&nbsp;&nbsp;<a href="http://www.miibeian.gov.cn/" target="_blank">浙ICP备11008151号</a> 
            </div>
            <ul class="inline links">

                <li>Copyright © 2010 - 2016 Youth Network Technology Co.,Ltd All Rights Reserved.</li>
              
            </ul>
        </div>


    </div>
</div>

<link href="//cdn.bootcss.com/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

<div id="box-bg" class="box-bg"></div>
<script type="text/javascript">

 toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
  
  $(function(){
    
    $("#account").blur(function(event) {
      var account = $(this).val();
      if(account==''){
        return false;
      }

      var p =Object.create(check);
      var flag = false;
      flag = p.mail(account);
      if(!flag) flag = p.phone(account);

      if(!flag){
        $(event.target).siblings('i.email').html("<i style='color:red'>格式错误</i>");
        return false;
      }
      $.ajax({
        url: "/component/ajax/singup",
        type: 'POST',
        dataType: 'json',
        data: {'account':account},
      })
      .done(function(ret) {
        if(ret.status=='ok'){
          $(event.target).siblings('i.email').html("<i style='color:green'>可以注册</i>");
          /*$(event.target).siblings('p').append("<span style='color:green;'>可以使用</span>");*/
        }else if(ret.status=='message'){          
          $(event.target).siblings('i.email').html("<i style='color:red'>已经注册</i>");          
        }else{
          
          $(event.target).siblings('i.email').html("<i style='color:red'>"+ret.message+"</i>");          
        }
      });
    });

    $("#account").focus(function(event) {
      $(this).siblings('i.email').html('');
      
    });


    $("#code").blur(function(event) {
      var code = $(this).val();
      if(code==''){
        return false;
      }
      var account = $("#account").val();

    
      $.ajax({
        url: "/component/verifyEmail/auth",
        type: 'POST',
        dataType: 'json',
        data: {'code': code,'account':account},
      })
      .done(function(ret) {
          //alert(ret.status);
          if(ret.status=='success'){
            $("#auth_salt").val(ret.auth_salt);
            $('i.emailCode').html("<i class='fa fa-check' style='color:green'>√</i>");
           
          }else{
             $('i.emailCode').html("<i class='fa fa-check' style='color:red;'>X</i>");
            
          }
      });
    });

    $("#code").focus(function(event) {
      $(".emailCode").html('');
    });

    $("#password").blur(function(event) {
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

  
    $("#confirm").blur(function(event) {
      /* Act on the event */
      var password = $(this).val();
      if(password==''){
        return false;
      }


      var confirm = $("#password").val();
    
      if(password!=confirm){
        $(event.target).siblings('i.conf').html("<i style='color:red'>密码不一致!</i>"); 
              
        return false;
      }else{
        $(event.target).siblings('i.conf').html("<i class='fa fa-check' style='color:green'>√</i>");       

      }
    });

    $("#confirm").focus(function(event) {
      $(this).siblings('i.conf').html('');
      $(this).siblings('i.conf').html('');
    });

  


    $("#submit").click(function(event) {    
      var account = $("#account").val();
      var verify = $("#code").val();
      var password = $("#password").val();
      var confirm = $("#confirm").val();
      var flag = false;
      var p =Object.create(check);
      flag = p.mail(account);   
      if(!flag) flag = p.phone(account);  
      if(!flag){
        $("#account").focus();
        toastr.warning("格式错误!");  
        return false;
      }

      if(verify==''){
        $("#code").focus();     
        toastr.warning("请输入验证码!"); 
        return false;
      }

      if(password==''){
        $("#password").focus();     
        toastr.warning("请输入密码!"); 
        return false;
      }

      if(password!=confirm){
        $("#confirm").siblings('i.conf').html("<i style='color:red'>密码不一致!</i>"); 
              
        return false;
      }else{
        $("#confirm").siblings('i.conf').html("<i class='fa fa-check' style='color:green'>√</i>");       

      }


      $.ajax({
        url: '/component/register',
        type: 'POST',
        dataType: 'json',
        data: {'account':account,'verify':verify,'password':password,'confirm':confirm},
      })
      .done(function(ret) {
        if(ret.status=='success'){
          <?php 
            if(!empty($from) && $from=='auth' && !empty($salt)){

          ?>
          window.location.href="/manage/index?from=auth&salt=<?php echo $salt;?>";
          <?php }else{ ?>
              window.location.href="/manage/index";
          <?php } ?>
                 
        }else if(ret.status=='false'){
          toastr.warning(ret.message); 
        }
      });
      
    });

    $("#vcode").click(function(){
      var account = $("#account").val();
      var p =Object.create(check);
      var flag = false;
      flag = p.mail(account);
      if(!flag) flag = p.phone(account);

      if(!flag){
        toastr.warning("手机号码或邮箱地址错误!");  
        $("#account").focus();
        return false;
      }
      sms(account);
    });

  });

  var check = {
    mail:function(mail){
      var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
          if(!reg.test(mail)) return false;
          return true;
    },
    phone:function(phone){
      var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/; 
      if(!myreg.test(phone)) return false;
      return true;
    },
  }


  var TC = {
    EndTime:60,
    intvalue:0,
    controll:'vcode',
    cont:null,
    startShow:function(){   
      this.intvalue ++;
      document.getElementById(this.controll).innerHTML="&nbsp;" + ((this.EndTime-this.intvalue)%60).toString()+"秒";
       if(this.intvalue>=this.EndTime){
            document.getElementById(this.controll).innerHTML="获取验证码";
            this.endShow();
          }
    },
    endShow:function(){
      window.clearTimeout(this.cont);
          this.intvalue=0;
          this.cont=null;
    },
    

  }

  var c =Object.create(TC);
  function sms(account){

    if(c.cont==null){
        
      $.ajax({
        url: '/component/verifyCode/get',
        type: 'POST',
        dataType: 'json',
        data: {'account': account},
      })
      .done(function(ret) {
        if(ret.status=='success'){
          c.cont = window.setInterval("c.startShow()",1000);
          toastr.success("验证码发送完成,请查收!");      
        }else{
          toastr.warning(ret.message);  
        }
      });

    } 
  }

</script>
</body>
</html>