<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <title>店铺管理</title>

    <link href="//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.css"/>
    <style>
         body{
        background: #f2f2f2;
        min-width: inherit !important;
        font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
   /* background-color: #2f4050;*/
    font-size: 13px;
   /* color: #676a6c;*/
    overflow-x: hidden;

  }
  .header{
    border-bottom: 1px solid #ccc;width: 80%;margin: 20px auto; height: 168px;

  }
  .header .nav{position: relative; bottom: -40px;text-align: center;}
  .container-fluid{padding: 0 8%;}

  .organization{width: 99%;height: 120px;background-color:white;margin: 0 auto;text-align: center; }
  .organication .panel-bady{text-align: center;height: }
  .panel-heading{text-align: center;}
  .add .panel-body{text-align: center;}
  .branch .panel-body{text-align: center;}
  .tools{
    width: 88%;height: 20px;position:absolute;top: 10px;background-color: #eee;
  }
  .container-fluid .col-md-4,.col-sm-3,.col-xs-6{margin-bottom:8px;}
  .container-fluid .panel .panel-body i:hover{color:#5bc0de;cursor:pointer; }
  .choise_css{
    /* padding: 15px 15px 0; */
    border: 1px solid #949494;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
   /*  min-height: 178px; */
    background: #fff;
    padding:0px;
  /*   margin: 10px 10px 10px 0px; */
  }
  .expired-cover {
      position: absolute;
      z-index: 10;
      background: #000;
      opacity: 0.6;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
   /*   padding-right: 15px;
      padding-left: 15px;*/
  }
  .panel{margin-bottom: 0px;}
  .choise_css .panel-body{border: none;padding: 15px 0px;}
  .choise_css .panel-body span{font-size: 14px;}
  .expired-notice {
    position: absolute;
    z-index: 120;
    width: 100%;
    color: #fff;
    height: 100%;
    top: 60px;
    left: 0;
    background-color: 
}
.btn.btn-primary {
    background-color: #2196f3;
    border-color: #0d8aee;
}
    </style>
</head>
<body>

<div class="header">
    <div class="organization">
        

        <div class="panel">
    
        <div class="panel-body">
      
              <i class="fa fa-windows fa-5x"></i>
              <br/>
              <h5>
                <span id="company_place">
                  {% if bech['cellphone']!=''%}
                    {{bech['cellphone']}}
                  {% else %}
                    {{bech['email']}}
                  {% endif %}
                </span>
              </h5>
            
                                     
          <!--  <button onclick="openW();" class="btn btn-xs btn-info" id="setting" type="button" data-do="change">
            <i class="fa fa-pencil-square-o"></i>&nbsp;在线签约</button>
            &nbsp;&nbsp;-->
            <button class="btn btn-xs btn-primary" onclick="logout();" type="button">
              <i class="fa fa-sign-out"></i>&nbsp;退出系统</button>
        </div>

      </div>
      
    </div>

</div>

<div class="container-fluid">

    <div class="col-md-3 col-sm-4 col-xs-6 add">
      <div class="col-xs-12 choise_css">
          <div class="panel text-center">    
              <div class="panel-body" onclick="creatStore();">                    
                <i class="fa fa-plus-square fa-3x" aria-hidden="true"></i>
                <br/>
                <span>创建</span>
              </div>
            </div>
      </div>    
    </div>

    <div id="public">

      {% for v in result %}

        <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="col-xs-12 choise_css">
            <div class="panel text-center">
              <div class="panel-body">
                <i class="fa fa-dropbox fa-3x" onclick="store('{{v['salt']}}')"></i>
                <br/>
                <span id="store-ak'+v['id']+'">{{v['branch']}}</span>
              </div>
            </div>
          </div>
        </div>

      {% endfor %}


        
    </div>



</div>


    
</body>
<!-- body 最后 -->
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
    apiready = function(){
        bechStore();

        api.addEventListener({
            name: 'touchMe'
        }, function(ret, err){
            var v = ret['value'];
             var ui = '<div class=\"col-md-3 col-sm-4 col-xs-6\"><div class=\"col-xs-12 choise_css\"><div class=\"panel text-center\"><div class=\"panel-body\"><i class=\"fa fa-dropbox fa-3x\" onclick=\"store('+v['id']+')\"></i><br/><span id="store-ak'+v['id']+'">'+v['branch']+'</span></div></div></div></div>';

            //$(".container-fluid").find('div.add').prepend(ui);
            $("#public").prepend(ui);
            /*alert(ret['value']['branch']);
            alert(ret.value.id);*/
        });
    };

    function bechStore(){
        var url = $api.getStorage('base_url')+"/v2/manage/stores";
        var token = bechToken();
        api.ajax({
            url: url,
            method: 'post',
            data: {
                values: { 
                    'token': token,
                }
            }
        },function(ret, err){
            if (ret) {
              if(ret.status=='success'){
                $.each(ret.result, function(index, val) {
                  putLayout(val);
                });
              }else if (ret.status=='relogin') {
                logout();
              }

            } else {
                alert( JSON.stringify( err ) );
            }
        });


    }   

    function store(salt){

      
      window.location.href="/hotspot/index?accesskey="+salt;

    }

    function creatStore(){
         
      var ok = Math.random();
      var url = '/manage/create/setup?&hash='+ok+'"';
      window.location.href=url;           
       /* api.openWin({
            name: 'createStore',
            url: './manageWin.html',
            pageParam: {
              'title': '创建店铺',
              'portal': 'createStore',              
            }           
        });*/      

    }

    function touchMe(fdsaf){
        alert('hello world!');
        alert('ewfdskadsaf');
        //location.reload(true);
    }
  
    function putLayout(v){
        var ui = '<div class=\"col-md-3 col-sm-4 col-xs-6\"><div class=\"col-xs-12 choise_css\"><div class=\"panel text-center\"><div class=\"panel-body\"><i class=\"fa fa-dropbox fa-3x\" onclick=\"store('+v['id']+')\"></i><br/><span id="store-ak'+v['id']+'">'+v['branch']+'</span></div></div></div></div>';

        $("#public").append(ui);
    }

    function logout(){
      window.location.href='/manage/logout';
    }

    function bechToken(){
      var id = $api.getStorage('id');
      var salt = $api.getStorage('salt');
      var username = $api.getStorage('username');
      var channel = $api.getStorage('channel');
      var token = '{"id":"'+id+'","salt":"'+salt+'","username":"'+username+'","channel":"'+channel+'"}';
      token = $api.strToJson(token);
      return token;
    }
</script>
</html>