<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{copyright['title']}}</title>
    <script src="{{template}}js/jquery.min.js"></script>
    <script src="{{template}}js/bootstrap.min.js"></script>

    <link href="{{template}}style/style.css" rel="stylesheet" />
    <style type="text/css">
    .weixin{width: 92.5%;padding: 0px 30px 0px 30px;    
      /* background-image: url({{template}}images/wechat.jpg); */
    text-align: center;
    
    background-image: none!important;
    background-position: center center;
    background-repeat: repeat;
    margin-top: 0px;
    position: absolute;
    z-index: 3;}

    .content {
      background-image:none!important; 
      text-align: center;

    }
    #init_content{width: 100%;height: 100%;z-index: 200;position: fixed;top: 0px;}
    .swiper-container {width: 100%;height: 39%;margin: 0px auto;}
    .tips{
      /*width: 100%;*/
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

 .btn-primary {
    background-color: #1ab394;
    border-color: #1ab394;
    color: #FFFFFF;
}
.btn-success {
    background-color: #1c84c6;
    border-color: #1c84c6;
    color: #FFFFFF;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
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
    
    </style>
    
</head>
<body>
    <div class="container-fluid  bg">
 
        <div class="container">
            <div class="row">

              
                <div class="col-xs-12 col-sm-12 col-md-5">
                    <div class="login">

                        <input id="mikrotik" data-status='false' type="hidden">

                        <div class="weixin hidden-md open">
                                              
                          <img src="{{template}}images/wechatlogo.jpg" style="height:100px;width:100px;border-radius:60px; -webkit-border-radius:60px;" onclick="fetch();"><br/>          
                          <a class="btn btn-success text-center" href="javascript:void(0);" onclick="fech();" role="button">一键连接Wi-Fi</a>

                       
                                                       
                          <br/>                            

                        </div>
                        <div class="content">
                          <br/><br/><br/><br/>   
                         
                        </div>

                        
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-7 advert">
                    <!-- 多图滚动 -->
                
                    <div id="scrollBox" class="scrollBox">
                        <div class="hd" >
                            <div style="float:left">
                                <span class="prev"></span>
                                <span class="next dir01"></span>
                            </div>
                            <ul></ul>

                        </div>                   
 
                        <div class="bd" id="banner">                           
                          {% for item in banner %} 
                            <ul>
                              <li>                                  
                                <a class="pic" href="{{item['thumb']}}">
                                  <img src="{{item['thumb']}}"/>
                                </a>
                              </li>                                  
                            </ul>
                         {% endfor %} 

                        </div>
                    </div>
                   
                   
                </div>
            </div>
        </div>

    </div>

    <!-- screen -->
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

    <script src="{{template}}js/TouchSlide.1.1.js"></script>


     <script src="{{template}}js/swiper.min.js"></script>
    <link rel="stylesheet" href="{{template}}style/swiper.min.css">               
                    <!-- scrollBox E -->
    <script type="text/javascript">


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

      var skip_control;
      function remove_skip(){

        clearInterval(skip_control);
        $("#init").hide('fast/400');
      } 



      TouchSlide({
        slideCell:"#scrollBox",
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        effect:"leftLoop",
        autoPage:true, //自动分页
        switchLoad:"_src" //切换加载，真实图片路径为"_src"
      });





        function skip_time(){
         // alert(config['skip_time']);
          var time = parseInt(config['skip_time']);
          if(time==0){
            //clearIntervel(skip_control);
            clearInterval(skip_control);
            remove_skip();
            return;
          }
          //alert(time);
          //document.getElementById('skip_time').innerHtml='2';
          $("#skip_time").text(time);
          config['skip_time']--;

        }
      function remove_skip(){

        clearInterval(skip_control);
        $("#init").hide('fast/400');
      } 



      function onekey(){
        var url = "/portal/verify?accesskey="+$_GET['accesskey']+'&mac='+$_GET['mac']+'&ip='+$_GET['ip']+'&chaplogin='+$_GET['chaplogin'];
        window.location.href=url;
      }


      $(" .scrollBox .next").click(function () {
          if( $(this).hasClass("dir01")){
          
          }else{
              $(this).addClass("dir01")
              $(this).siblings("span").removeClass("dir")
          }
             
      })

      $(" .scrollBox .prev").click(function () {
          if ($(this).hasClass("dir")) {

          } else {
            $(this).addClass("dir")
            $(this).siblings("span").removeClass("dir01")
          }

      })


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
</body>
</html>