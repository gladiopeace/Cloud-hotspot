{% extends "/layout/hotspot_boot.html" %}
{% set active_now='theme' %}

{% block head %}
	<meta charset="UTF-8">
    {{ parent() }}

{% endblock %}


{% block content %}
  
  <div class="row">
      <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>主题设置</h5>
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
                             

                                <input name="id" type="hidden" value="{{ret['id']}}"/>                               
                           
                              <div class="form-group">
                                  <label class="col-sm-2 control-label">
                                    标题名称
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="data[title]" value="{{ret['title']}}">
                                    </div>
                                    <div class="col-sm-5">
                                       
                                    </div>
                              </div>
                                
                              <div class="hr-line-dashed"></div>


                              <div class="form-group">
                                  <label class="col-sm-2 control-label">
                                    公司名称
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="data[company]" value="{{ret['company']}}">
                                    </div>
                                    <div class="col-sm-5">
                                       
                                    </div>
                              </div>
                                
                              <div class="hr-line-dashed"></div>
                              


                              <div class="form-group">
                                  <label class="col-sm-2 control-label">
                                  广告时间
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="data[number]" value="{{ret['number']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        只填写数字
                                    </div>
                              </div>
                                
                                <div class="hr-line-dashed"></div>



                                  
                                <div class="form-group"><label class="col-sm-2 control-label">广告功能</label>

                                    <div class="col-sm-5">
                                    <input type="radio" name="data[screen]" {% if ret['screen']=='accept' or ret['screen']=='' %} checked{% endif %} value="accept">
                                      开启
                                      <input type="radio" value="deny" name="data[screen]" {% if ret['screen']=='deny'%} checked{% endif %} >
                                     关闭
                                     
                                    </div>
                                    <div class="col-sm-5">
                                        <span></span>
                                    </div>
                                </div>
                                                             
                               
                                
                                
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group"><label class="col-sm-2 control-label">
                                   跳过广告
                                  </label>

                                    <div class="col-sm-5">
                                     

                                     <input type="radio" name="data[type]" {% if ret['type']=='accept' or ret['type']=='' %} checked{% endif %} value="accept">
                                      允许
                                      <input type="radio" value="deny" name="data[type]" {% if ret['type']=='deny'%} checked{% endif %} >
                                      禁止
                                     
                                    </div>
                                    <div class="col-sm-5">
                                        
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
<script src="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
<script type="text/javascript">

    $(function(){


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
              swal({
                  title: "完成!",
                  text: "已经为您保存完成!",
                  type: "success"
              }, function () {
                  window.location.reload();             
              });


            }else{
             swal({
                  title: "失败!",
                  text: "保存失败,请重试!",
                  type: "warning"
              });

            }
        });
        
      });

    })

    
                  
               

</script>

{% endblock %}
