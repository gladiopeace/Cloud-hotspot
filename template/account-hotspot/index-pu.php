<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{copyright['title']}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link rel="stylesheet" href="{{template}}style/swiper.min.css">
    <link href="{{template}}style/bootstrap.min.css" rel="stylesheet">
    <link href="{{template}}style/jquery.toast.css" rel="stylesheet">



    <style>

    *{padding: 0;margin: 0;}
      body {
        padding: 0;
        margin: 0;
      }

    #init_content{width: 100%;height: 100%;z-index: 200;position: fixed;top: 0px;}
    .tips{
        width: 100%;
        margin: 0px auto;
        position: fixed;
        bottom: -20px;
        text-align: center;
        height: 50px;
        z-index: 100;
        position: fixed;top: 88px;right: -60px; 

    }

  #timeplace{width: 40px;height: 40px;border:1px solid white;border-radius:20px;display: block;    position: absolute;
    top: 0px;
    right: 98px;
    line-height: 40px;
    text-align: center;
  }
    .content{
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        margin: 0 auto;
        padding: 0;
        width: 100%;
    }

    .swiper-container {
        width: 100%;
        height: 200px;
        margin: 0px auto;
    }
    .swiper{
      width: 100%;
      height: 100%;
      margin: 0px auto;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-slide img{width: 100%;/* height: auto; max-height: 300px; */ }
    .login{
       padding: 0px;
        /*width: 100%;*/
        height: 60%;
       /* border: 1px solid #ccc;*/
    }

    .form-control{padding-left: 68px;}
    .field-tips{
      display: inline;
      position: relative;
      top: 28px;
      left: 8px;
    }
    .field-tips input{padding-left: 12px;}
    @media screen and (min-width: 767px){ 
       /* //<=768的设备 */
       .content {
        width: 500px;
        height: 700px;
        }
    }
    #notice{font-size: 6px;position: relative;top: -10px;color: red;}
    #footer{
        position: relative;
        left: 0;
        bottom: 0;
        width: 100%;
        text-align: center;
        font-size: 12px;
        margin-top: 28px;
    }
    #footer p{    color: #999;}
    
    </style>
</head>
<body>
  <div class="content">
   
        <!-- Swiper -->
        <div class="swiper-container">
             <div class="swiper-wrapper" id="banner" style="width: 368px;height: 260px;">

                 {% for item in banner %}
                     <div class="swiper-slide">
                         <img src="{{item['thumb']}}" style="height:100%;width:100%;">
                     </div>
                 {% else %}
                        No users have been found.
                 {% endfor %}

            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
     
        <div class="login">
            
        <div style="padding-left:30px;padding-right:30px;padding-top:20px;">
    
        <fieldset>


          <form id="mikrotik" data-status='false' method="post">
              
          

              <div class="form-group">
                <p class="field-tips">会员帐号:</p>
                <input type="text" name="username" id="username" class="form-control"  placeholder="会员帐号">
              </div>
              <div class="form-group">
                <p class="field-tips">帐号密码:</p>
            
                <input type="password" name="password" id="password" class="form-control" placeholder="验证密码">
              </div>

          
              <span id="notice"></span>
              <br/>
              <div class="form-group text-center">
                 <a href="javascript:void(0);" class="btn btn-success" onclick="post();" style="width:60%;position:relative;">登&nbsp;&nbsp;&nbsp;&nbsp;录</a>
              </div>

          </form>      
                 
        </fieldset>
        </div>
        </div>

          <div id="footer">
              <p class='text-center'>{{copyright['company']}}</p>
              <br/>
              <p class="text-center">Copyright © 2014-2018 Power by Cloud Hotspot</p>
          </div>
          
  </div>


  {% if copyright['screen'] == 'accept' %}
  <div id="init">

    <div id="init_content">
      <div class="swiper">
           <div class="swiper-wrapper">

               {% for item in slider %}
                   <div class="swiper-slide">
                       <img src="{{item['thumb']}}" style="height:100%;width:100%;">
                   </div>
               {% else %}
                    No users have been found.
               {% endfor %}

           </div>

           <div class="tips" style="color:white;font-size:24px;font-fimaly:宋体,雅黑;">

            <div id='timeplace'>

              <span id="skip_time">{{ skip_time }}</span>s
              {% if copyright['type'] == 'accept' %}
              <a href="javascript:void(0);" style="color:white;font-size:10px;font-fimaly:宋体,雅黑;text-decoration:none;position:relative;top:-10px;" onclick="remove_skip();">跳过</a>
              {% endif %}
            </div>


           </div>


      </div>

    </div>

  </div>
  {% endif %}

  <!-- Swiper JS -->
    


  <!-- Link Swiper's CSS -->
  <script src="{{template}}js/jquery.min.js"></script>
  <script src="{{template}}js/bootstrap.min.js"></script>
  <script src="{{template}}js/swiper.min.js"></script>
  <script src="{{template}}js/jquery.toast.js"></script>

    <!-- Initialize Swiper -->
    <script>

        var $_GET = (function(){
          var url = window.document.location.href.toString();
          var u = url.split("?");
          if(typeof(u[1]) == "string"){
            u = u[1].split("&");
            var get = {};
            for(var i in u){
              var j = u[i].split("=");
              get[j[0]] = j[1];
            }
            return get;
          } else {
            return {};
          }

        })();


          //渲染Banner
          var swiper = new Swiper('.swiper-container',{
              pagination: '.swiper-pagination',
              paginationClickable: true,
              //autoplay: 2500,
              autoplay:2000
          });

        {% if copyright['screen'] == 'accept' %}

            var tickTime = 10;
            var skip_control;
            skip_control=setInterval('skip_time()',1000);
            var swiper = new Swiper('.swiper',{
              pagination: false,
              paginationClickable: true,
              autoplay: 3000,
              //autoplay: 2000,
            });

            function skip_time(){
                // alert(config['skip_time']);
                var time = parseInt(tickTime);
                if(time==0){
                    //clearIntervel(skip_control);
                    clearInterval(skip_control);
                    remove_skip();
                    return;
                }
                //alert(time);
                //document.getElementById('skip_time').innerHtml='2';
                $("#skip_time").text(time);
                tickTime--;

            }

            {% if copyright['type'] == 'accept' %}
                function remove_skip(){
                    clearInterval(skip_control);
                    $("#init").hide('fast/400');
                }
            {% endif %}

        {% endif %}


    function post(){
        var username = $("#username").val();
        var password = $("#password").val();
        if(username =='' || password==''){
            $.toast({
                text:  '请输入用户和密码', // Text that is to be shown in the toast
                icon: 'info', // Type of toast icon
                showHideTransition: 'fade', // fade, slide or plain
                allowToastClose: false, // Boolean value true or false
                hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                position: 'mid-center',
                textAlign: 'center',  // Text alignment i.e. left, right or center
            });

            return false;
        }
        $.ajax({
              url: "/portal/auth/fetch-member-account",
              type: 'POST',
              dataType: 'json',
              data:{'username':username,'password':password,'accesskey':"{{config['salt']}}",'mac':"{{config['mac']}}"}
          })
        .done(function(info) {

            if(info['status']=='success'){
                startLogin(info);

            }else{
                console.log(info);

                $.toast({
                    text:  info['message'], // Text that is to be shown in the toast
                    icon: 'info', // Type of toast icon
                    showHideTransition: 'fade', // fade, slide or plain
                    allowToastClose: false, // Boolean value true or false
                    hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                    stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                    position: 'mid-center',
                    textAlign: 'center',  // Text alignment i.e. left, right or center
                });

            }
      });
      return false;

    }


    function startLogin(json){

        var verifyData = {
            username : $("#username").val(),
            password : $("#password").val(),
            accesskey:"{{config['salt']}}",
            mac:"{{config['mac']}}",
            auth_code:json.access_code
        };

        $.ajax({
          url: '/portal/verify/member-auth',
          type: 'POST',
          dataType: 'json',
          data: verifyData
        })
        .done(function(ret) {
          console.log("success");
            if(ret.code=='-1'){
                swal({
                    title: "",
                    text: "访问错误,请重试!",
                    timer: 2000,
                    showConfirmButton: false,
                    showCancelButton: false,
                    type:"info"
                })

                $.toast({
                    text: "访问错误,请重试!", // Text that is to be shown in the toast

                    icon: 'info', // Type of toast icon
                    showHideTransition: 'fade', // fade, slide or plain
                    allowToastClose: false, // Boolean value true or false
                    hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                    stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                    position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

                    textAlign: 'center',  // Text alignment i.e. left, right or center
                    loader: true,  // Whether to show loader or not. True by default
                    loaderBg: '#9EC600',  // Background color of the toast loader
                });
            }
            if(ret.code=='1'){

                var form = $('<form class="hide" action="http://'+ret.ip+'/login" method="get">\
                    <input type="hidden" name="auth_code" value="'+json.access_code+'"/>\
                    <input type="hidden" name="accesskey" value="'+ verifyData.accesskey +'" />\
                    </form>');
                console.log(form);
                form.appendTo("body").submit();
            }
        });

    }

    </script>

</body>
</html>
