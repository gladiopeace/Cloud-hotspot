{% extends "/layout/basic_boot.html" %}
{% block head %}
	<meta charset="UTF-8">
    <link href="//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet">
    <title>节点管理</title>
    {{ parent() }}
  
    <style type="text/css">
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
    border-bottom: 1px solid #ccc;width: 80%;margin: 2% auto; height: 210px;

  }

  @media screen and (max-width:960px){
    .header{
      border-bottom: 1px solid #ccc;width: 100%;height: 210px;

    }
  }
  .header .nav{position: relative; bottom: -40px;text-align: center;}
  .container-fluid{padding: 0 8%;}

  .organization{width: 400px;height: 120px;background-color:white;margin: 0 auto;text-align: center; }
  .organication .panel-bady{text-align: center;height: }
  .panel-heading{text-align: center;}
  .add .panel-body{text-align: center;}
  .branch .panel-body{text-align: center;}
  .tools{
    width: 88%;height: 20px;position:absolute;top: 10px;background-color: #eee;
  }
  .container-fluid .panel .panel-body i:hover{color:#5bc0de;cursor:pointer; }
  .choise_css{
    padding:0;
    border: 1px solid #949494;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
    min-height: 178px;
    background: #fff;
    margin: 10px 10px 10px 0px;
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
  .choise_css .panel-body{border: none;padding: 26px 0px;}
 .panel{margin-bottom: 0px;}

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

{% endblock %}


{% block content %}
<div class="header">
    <div class="organization">
        

        <div class="panel">
    
        <div class="panel-body">
      
              <i class="fa fa-windows fa-5x"></i>
              <br/>
              <h5>机构名称:
                <span id="company_place">
                {% if bech['company']!='' %}
                  {{bech['company']}}
                {% else %}
                  宁波优思网络技术有限公司
                {% endif %}
                </span>
              </h5>
            
              <br/>
            <!--  <button class="btn btn-xs btn-success" id="payment" type="button" data-do="change">
              <i class="fa fa-rmb"></i>&nbsp;授权管理</button>
              &nbsp;&nbsp;              -->
              <button class="btn btn-xs btn-info" id="setting" type="button" data-do="change">
              <i class="fa fa-pencil-square-o"></i>&nbsp;{{profile}}</button>
              &nbsp;&nbsp;
              {% if bech['level']=='8' or bech['level']=='6' %}
              <button class="btn btn-xs btn-info" id="system" type="button" data-do="system">
                <i class="fa fa-cog fa-fw fa-spin"></i>&nbsp;{{system}}</button>
              &nbsp;&nbsp;
              {% endif %}
              <button class="btn btn-xs btn-primary" onclick="window.location.href='/manage/logout'" type="button">
              <i class="fa fa-sign-out"></i>&nbsp;{{logout}}</button>
        </div>

      </div>
      
    </div>
<!-- 
    <div class="nav" style="display: none;">
        <button class="btn btn-primary " type="button"><i class="fa fa-check"></i>&nbsp;Submit</button>
        <button class="btn btn-success " type="button"><i class="fa fa-upload"></i>&nbsp;&nbsp;<span class="bold">Upload</span></button>
        <button class="btn btn-info " type="button"><i class="fa fa-paste"></i> Edit</button>
        <button class="btn btn-warning " type="button"><i class="fa fa-warning"></i> <span class="bold">Warning</span></button>
      
     
       
    </div> -->
</div>

<div class="container-fluid">

    <div class="col-md-3 col-sm-4 col-xs-6 add">
      <div class="col-xs-12 choise_css">
          <div class="panel text-center">
              <div class="panel-body">
                  <br/>
                  <i class="fa fa-plus-square fa-5x" aria-hidden="true"></i>
                  <br/>
                  <h4>{{create_branch}}</h4>
              </div>
            </div>
      </div>
    
    </div>




    {% for v in result %}
    <div class="col-md-3 col-sm-4 col-xs-6">
      
      <div class="col-xs-12 choise_css">
        <div class="panel text-center">    
          <div class="panel-body">
              <i class="fa fa-dropbox fa-5x" onclick="opens('/hotspot/index?accesskey={{v['salt']}}');"></i>
              <!-- <i class="fa fa-dropbox fa-5x" onclick="window.open('/store/index/portal?accesskey={{v['salt']}}','_blank')"></i> -->
              <h4>{{v['branch']}}</h4>
              <span>{{ v['overdue']|date("Y-m-d")}}</span>
          </div>        
        </div>
    
        <!-- {% if v['overdue'] < now %}
          <div class="expired-cover">
           
          </div>
          <div class="expired-notice text-center">
            <p lang="">您的计划已到期，请续费后继续使用。</p>

            <br>
            <a type="button" data-access="{{v['id']}}" class="btn btn-primary expired_btn" href="javascript:void(0);">立即续费</a> 
          </div>
        {% endif %} -->
        
     

      </div>


      
     
    </div>
    {% endfor %}
         
</div>

{% endblock %}

{% block script %}

<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>
<script type="text/javascript">
    
    $(".add").click(function(event) {
        /* Act on the event */
        var ok = Math.random();
        var url = '/manage/create/setup?&hash='+ok+'"';
        layer.open({
          type: 2,
          title: '{{create_branch}}',
          area: ['680px', '588px'],
          fix: true, //不固定
          maxmin: true,
          content: url
        });

      
      //popWin.showWin("590","550","",url);
    });

    $(".pay").append('<div class="test">付费</div>');

    function set(){
        //iframe层-父子操作
     
    }

    $("#setting").click(function(event) {
      /* Act on the event */
      var type = $(this).data('do');
      layer.open({
        type: 2,
        title: '{{profile}}',
        area: ['500px', '400px'],
        fix: true, //不固定
        maxmin: true,
        content: '/manage/setting?do='+type,
      });
    });

    $("#system").click(function(event) {
        /* Act on the event */
        var type = $(this).data('do');
        layer.open({
            type: 2,
            title: '{{system}}',
            area: ['600px', '600px'],
            fix: true, //不固定
            maxmin: true,
            content: '/manage/setting?do='+type,
        });
    });

    $("#payment").click(function(event) {
      /* Act on the event */
      
      layer.open({
        type: 2,
        title: '授权管理',
        area: ['500px', '400px'],
        fix: true, //不固定
        maxmin: true,
        content: '/manage/payment/alipay',
      });
    });

    $(".expired_btn").click(function(event) {
      /* Act on the event */
      var access = $(this).data('access');
      var ok = Math.random();
      var url ="manage/plan/init?access="+access+"&hash="+ok;
      layer.open({
        type: 2,
        title: '套餐续费',
        area: ['640px', '460px'],
        fix: true, //不固定
        maxmin: true,
        content: url
      });
    });

    $("#message").click(function(event) {
      /* Act on the event */
       /* Act on the event */
      var access = $(this).data('access');
      var ok = Math.random();
      var url ="manage/message/init?access="+access+"&hash="+ok;
      layer.open({
        type: 2,
        title: '短信充值',
        area: ['640px', '460px'],
        fix: true, //不固定
        maxmin: true,
        content: url
      });
    });

    function opens(url){     
      window.location.href=url;
    } 

  </script>
{% endblock %}