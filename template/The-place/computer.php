<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{copyright['title']}}</title>      
    <link href="{{template}}style/style.css" rel="stylesheet" />
    <link href="{{template}}style/bootstrap.min.css" rel="stylesheet" />
    <script src="{{template}}js/jquery.min.js"></script>  
    <script src="{{template}}js/bootstrap.min.js"></script>  
</head>
<body>
    <div class="container-fluid  bg" style="margin-top: 60px;">
 
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5">
                    <div class="login">

                        <div class="col-xs-6 col-md-6 on" ><a href="javascript:void(0)" onclick="fech();" >微信连Wi-Fi</a>
                        </div>
                  
                        <div class="col-xs-6 col-md-6 on01" style="float:right">登录</div>
                        <div class="clearfix"></div>
                        
                        <div class="content">
                            <input type="text" placeholder="请输入手机号..." name="cellphone" style="background-color:#fff" id='cellphone'/>
                            <input type="text" placeholder="请输入验证码号..." name="verify" id="verify"/>
                            <span class="code">
                                <button type="button" class="btn btn-warning btn-sm img-responsive" id="img">验证码</button>
                             
                            </span>
                           <a class="btn btn-warning" onclick="Login();">登录</a>
                        </div>

                      
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-7 advert">
                    <!-- 多图滚动 -->
                
                    <div id="scrollBox" class="scrollBox" style="width:100%;height:100%;">
                        <div class="hd" >
                            <div style="float:left">
                                <span class="prev"></span>
                                <span class="next dir01"></span>
                            </div>
                            <ul></ul>

                        </div>
                        <div class="bd" id="banner" style="width:300px;height:300px;">
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

  <div style="display: none">
    <form action="" name="start" method="get">
        <input type="hidden" name="auth_code">
        <input type="hidden" name="salt" value="{{config['salt']}}">
        <input type="submit">
    </form>
  </div>


  <script src="{{template}}js/TouchSlide.1.1.js"></script>
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


        var commonInit = [];
        var config = [];
        var skip_control;
    
        TouchSlide({
          slideCell:"#scrollBox",
          titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
          effect:"leftLoop",
          autoPage:true, //自动分页
          switchLoad:"_src" //切换加载，真实图片路径为"_src"
        });

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

       



    var EndTime=60;
    var intvalue=0;
    var timer2=null;


     $("#img").click(function(event) {
            /* Act on the event */
        var cellphone = $("[name='cellphone']").val();
        if(cellphone=='' || cellphone==null){
            alert('请输入手机号码!');
            $("[name='cellphone']").focus();
            return false;
        }

        var re= /^1\d{10}$/;
        if(!re.test(cellphone)){
          alert('请输入正确的手机号码。');
          $("[name='cellphone']").focus();
          return false;
        }

        if(timer2==null){
           Message(cellphone);
        }
    });



    function Message(cellphone){
        //var form = $("#mikrotik").serialize();

        var data = {        
          cellphone: cellphone,
          accesskey:"{{config['salt']}}",
          mac:"{{config['mac']}}",
          type: "sms"
        };

        $.ajax({
            url:  "/portal/auth/fetch-code-cellphone",
            type: 'POST',
            dataType: 'json',
            data:data,
        })
        .done(function(info) {
            console.log(info);
            if(info.status=='success'){

              timer2=window.setInterval("startShow()",1000);

            }else{
              alert(info.message);
            }
        });      

    }


  
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

                verify(ret);

            }
        });

    }

    function Login(){

        var cellphone = $("#cellphone").val();
        var code = $("#verify").val();
       
        var verifyData = {
          cellphone :cellphone,
          password:code,
          accesskey:"{{config['salt']}}",
          mac:"{{config['mac']}}",         
        };

        $.ajax({
            url:  "/portal/auth/verify-code-cellphone",
            type: 'POST',
            dataType: 'json',
            data:verifyData,
        })
        .done(function(info) {
            console.log(info);
            if(info.status=='success'){
              console.log(info);
              if(info.status=='success'){
                  document.start.auth_code.value = info.access_code;

                  verify(info);
              }

            }else{
              alert('手机号码或验证码错误!');
            }
        });   

    }

    function verify(ret){

        $.ajax({
            url: '/portal/verify/wechat-auth',
            type: 'POST',
            dataType: 'json',
            data: {'accesskey':"{{config['salt']}}",'mac':"{{config['mac']}}",'auth_code':ret.access_code}
        })
        .done(function(ret) {
            console.log(ret);
            if(ret.status=='success'){
                document.start.action=ret.ip; //'http://'+ret.ip+'/login';
                document.start.submit();//=ret.ip;
            }
        });

    }


    function startShow(){
        intvalue ++;
        document.getElementById("img").innerHTML="&nbsp;" + ((EndTime-intvalue)%60).toString()+"秒后重发";
        if(intvalue>=EndTime){
            document.getElementById("img").innerHTML="重发!";
            endShow();
        }
    }

    function endShow(){
        window.clearTimeout(timer2);
        intvalue=0;
        timer2=null;
    }


</script>
                   
                </div>
            </div>
        </div>

    </div>
</body>
</html>
