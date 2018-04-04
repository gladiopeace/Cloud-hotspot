<!DOCTYPE HTML> 
<html>
<head lang="zh-CN">
    <meta charset="UTF-8">
    <title>{{copyright['title']}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

 <style>
    body{
       /* background:#eee;*/
    }
    *{padding: 0;margin: 0;}
    
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
    font-size: 22px;
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
        height: 38%;
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
        border: 1px solid #ccc;
    }
   /* .tip{position: relative;bottom: -38px;
        left: -42px;
        }*/
    
    .form-control{padding-left: 56px;}
    /*input{padding: 12px 56px;}*/


    @media screen and (min-width: 767px){ 
       /* //<=768的设备 */
       .content {
        width: 500px;
        height: 700px;
        }
    }

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
    <link rel="stylesheet" href="{{template}}style/weixin.css"/>
</head>
<body class="mod-simple-follow">
<div class="mod-simple-follow-page">
    <div class="mod-simple-follow-page__banner">
     
        <div class="swiper-container">
            <div class="swiper-wrapper" id="banner" style="width: 368px;height: 260px;">

                {% for item in banner %}
                    <div class="swiper-slide">
                        <img src="{{item['thumb']}}" style="height:100%;width:100%;">
                    </div>
                {% else %}
                    <div class="swiper-slide">
                        <img class="mod-simple-follow-page__banner-bg" src="{{template}}css//background.jpg" alt="">
                    </div>
                    <div class="mod-simple-follow-page__img-shadow"></div>
                    <div class="mod-simple-follow-page__logo">
                        <img class="mod-simple-follow-page__logo-img" src="{{template}}css/t.weixin.logo.png" alt="">
                        <p class="mod-simple-follow-page__logo-name"></p>
                        <p class="mod-simple-follow-page__logo-welcome">欢迎您</p>
                    </div>
                {% endfor %}
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <!-- end Swiper -->
     
       
    </div>
     <div class="mod-simple-follow-page__attention">
        <p class="mod-simple-follow-page__attention-txt">欢迎使用Wi-Fi</p>
        <a href="javascript:void(0);" onclick="fech();" class="mod-simple-follow-page__attention-btn">一键连接上网</a>
         <p class='text-center'>
                <a href="javascript:void(0);" id="company">{{company}}</a>
         </p>
     


    </div>
</div>

<div id="footer">
    <p class='text-center'>{{copyright['company']}}</p>
    <p class="text-center">Copyright © 2014-2018 Power by Cloud Hotspot</p>
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

<div style="display: none">
    <form action="" name="start" method="get">
        <input type="hidden" name="auth_code">
        <input type="hidden" name="salt" value="{{config['salt']}}">
        <input type="submit">
    </form>

</div>

</body>
<script src="{{template}}js/jquery.min.js"></script>
<script src="{{template}}js/amazeui.min.js"></script>
<link rel="stylesheet" href="{{template}}style/amazeui.min.css"/>
<link rel="stylesheet" href="{{template}}style/swiper.min.css">
<script src="{{template}}js/swiper.min.js"></script>
<script src="{{template}}js/vue.min.js"></script>

<script type="text/javascript">


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
            autoplay: 3000
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
    
    function fech(){

      $.ajax({
        url: '/portal/auth/fetch-wechat-code',
        type: 'POST',
        dataType: 'json',
        data: {'accesskey':"{{config['salt']}}",'mac':"{{config['mac']}}"}
      })
      .done(function(ret) {
            if(ret.status=='success'){
                document.start.auth_code.value = ret.access_code;
                /*      document.start.salt.value*/
                verify(ret);

            }
      });

    }
    function verify(ret){

        $.ajax({
            url: '/portal/verify/wechat-auth',
            type: 'POST',
            dataType: 'json',
            data: {'accesskey':"{{config['salt']}}",'mac':"{{config['salt']}}",'auth_code':ret.access_code}
        })
        .done(function(ret) {
            console.log(ret);
                if(ret.status=='success'){
                   document.start.action= ret.ip;//'http://'+ret.ip+'/login';
                   document.start.submit();//=ret.ip;
                }
        });

    }
</script>

</html>