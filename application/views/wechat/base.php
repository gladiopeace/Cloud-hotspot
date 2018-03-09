{% extends "/layout/hotspot_boot.html" %}
{% set active_now='wechat' %}

{% block head %}
	<meta charset="UTF-8">
    {{ parent() }}
    <style type="text/css">
    
   .pic{width:80px;border:1px solid #ccc;height:80px;}
  .pic img{width: 80px;height:80px;}
  </style>

{% endblock %}


{% block content %}
  
  <div class="row">
      <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>微信公众号信息</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                            
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form id="dataform" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">公众号名称</label>

                                    <div class="col-sm-5">
                                    <input type="text" name="data[title]" class="form-control" value="{{result['title']}}" placeholder="请输入微信名称">
                                    </div>

                                    <div class="col-sm-5">
                                   
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                              
                               
                                <div class="form-group"><label class="col-sm-2 control-label">应用ID:</label>

                                    <div class="col-sm-5">
                                    <input type="text"  name="data[appid]" class="form-control" value="{{result['appid']}}" placeholder="请输入微信APPID">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">应用密钥:</label>

                                    <div class="col-sm-5">
                                    <input type="text" placeholder="请输入微信AppSecret"class="form-control" name="data[secret]" id='secret'value="{{result['secret']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <span></span>
                                    </div>
                                </div>
                                  
                                  <div class="hr-line-dashed"></div>

                                  <div class="form-group"><label class="col-sm-2 control-label">帐号类型:</label>

                                    <div class="col-sm-5">
                                      <label class="checkbox-inline"><input class="type" type="radio" name="data[type]" {% if result['type']==1 or ressult['type']=='' %} checked='checked' {% endif %} class="type"  value="1">订阅号</label>
                                            <label class="checkbox-inline"><input class="type" type="radio" name="data[type]" {% if result['type']==2 %} checked='checked' {% endif %} value="2">服务号</label>
                                            <label class="checkbox-inline"><input class="type" type="radio" name="data[type]" {% if result['type']==3 %} checked='checked' {% endif %} value="3">认证订阅号</label>
                                            <label class="checkbox-inline"><input class="type" type="radio" name="data[type]" {% if result['type']==4 %} checked='checked' {% endif %} value="4">认证服务号</label>
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                            
                                <input name="id" type="hidden" value="{{result['id']}}"/>
                                <input name="accesskey" type="hidden" value="{{accesskey}}"/>
                                <div class="hr-line-dashed"></div>
                                <input id="fechurl" type="hidden" name="data[qrcode]" value="{{result['qrcode']}}">
                                  <div class="form-group">
                                  <label class="col-sm-2 control-label">
                                  二维码
                                  </label>

                                    <div class="col-sm-10">
                                    <div class="pic" id="plib">

                                        {% if result['qrcode']!='' %}

                                          <img src="{{result['qrcode']}}">


                                        {% endif %}


                                      </div>

                                    </div>
                                 
                                </div>
                                
                                
                                
                                <div class="hr-line-dashed"></div>
                              
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">   
                                        <button class="btn btn-primary" id="saving" type="button">保  存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
  </div>
  </div>
  
{% endblock %}


{% block script %}

<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>

<link href="//cdn.bootcss.com/toastr.js/2.1.2/toastr.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/toastr.js/2.1.2/toastr.min.js"></script>
<script type="text/javascript">

    $(function(){

        toastr.options = {

          positionClass: "toast-top-center",//弹出窗的位置
          closeButton: true,
       /*   progressBar: true,*/
          showMethod: 'slideDown',
          timeOut: 4000
      };

      $("#fech").click(function(event) {
        libs('plib','fechurl');
      });

     $("#plib").click(function(event) {
       libs('plib','fechurl');
     });

     $("#fechurl").focus(function(event) {
       libs('plib','fechurl');
     });

      $("#saving").click(function(event) {
        /* Act on the event */
           //toastr.success('温馨提示:已经为您保存完成!');

        $.ajax({
          url: '?',
          type: 'POST',
          dataType: 'json',
          data: $("#dataform").serialize(),
        })
        .done(function(ret) {
            if(ret.status=='success'){
              toastr.success('温馨提示:已经为您保存完成!');

            }else{
              toastr.warning('温馨提示:没有修改任何数据!');

            }
        });
        
      });

    })

    function libs(field,field_value){
      var ok = Math.random();

      var url = '/manage/youtu/test?field='+field+'&field_value='+field_value+'&hash='+ok+'"';
      layer.open({
        type: 2,
        title: '图片资料库',
        area: ['664px', '560px'],
        fix: false, //不固定
        maxmin: true,
        content: url
      });

    

   }
                  
               

</script>

{% endblock %}
