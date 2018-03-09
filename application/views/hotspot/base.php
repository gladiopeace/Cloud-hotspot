{% extends "/layout/hotspot_boot.html" %}
{% set active_now='branch' %}

{% block head %}
	<meta charset="UTF-8">
    {{ parent() }}

{% endblock %}


{% block content %}
  
  <div class="row">
      <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>无线热点管理</h5>
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
                                <div class="form-group"><label class="col-sm-2 control-label">节点名称</label>

                                    <div class="col-sm-5">
                                    <input type="text" name="data[branch]" class="form-control" value="{{bech['branch']}}">
                                    </div>

                                    <div class="col-sm-5">
                                   
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                              
                               
                                <div class="form-group"><label class="col-sm-2 control-label">节点用户</label>

                                    <div class="col-sm-5">
                                    <input type="text" value="{{bech['access_info']['username']}}" class="form-control" name="access_info[username]">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">节点密码</label>

                                    <div class="col-sm-5">
                                    <input type="text" placeholder="请输入节点密码" class="form-control" name="access_info[password]" value="{{bech['access_info']['password']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <span></span>
                                    </div>
                                </div>
                                                             
                               
                                
                                
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group"><label class="col-sm-2 control-label">
                                    IP地址
                                  </label>

                                    <div class="col-sm-5">
                                      <input type="text" class="form-control" name="access_info[ip]" value="{{bech['access_info']['ip']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                <input name="id" type="hidden" value="{{bech['id']}}" id="download_id"/>
                                <input name="salt" type="hidden" value="{{bech['salt']}}"/>
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group">
                                  <label class="col-sm-2 control-label">跳转 URL
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="access_info[url]" value="{{bech['access_info']['url']}}"></div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group"><label class="col-sm-2 control-label">认证方式</label>

                                    <div class="col-sm-5">

                                      <input type="radio" name="data[type]" {% if bech['type']=='normal' or bech['type']=='' %} checked{% endif %} value="normal">
                                      通用认证
                                      <input type="radio" value="account" name="data[type]"{% if bech['type']=='account'%} checked{% endif %}>
                                      帐号认证
                                      <input type="radio" value="wechat" name="data[type]" {% if bech['type']=='wifi' or bech['type']=='wechat' %} checked{% endif %}>
                                      微信连Wi-Fi
                                           
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                              
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">   
                                        <button class="btn btn-primary" id="saving" type="button">保  存</button>
                                    </div>


                                    <div class="col-sm-4">   
                                        <button class="btn btn-success" onclick="downloads();" type="button">下载节点</button>
                                    </div>


                                  </div>
                            </form>
                        </div>
                    </div>
  </div>
  </div>
  
{% endblock %}


{% block script %}
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
              toastr.warning('温馨提示:已经为您保存完成!');

            }
        });
        
      });

    })

    
  function downloads(){

  var id  = $("#download_id").val();

  $('body').append("<iframe style='display:none;' src='/hotspot/downtest?id="+id+"'></iframe>" );


}
          
               

</script>

{% endblock %}
