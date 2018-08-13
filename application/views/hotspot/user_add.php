{% extends "/layout/hotspot_boot.html" %}

{% set active_now='branch' %}

{% block head %}
	<meta charset="UTF-8">
    {{ parent() }}
 <link href="//cdn.bootcss.com/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css" rel="stylesheet">

 {% endblock %}


{% block content %}
  
  <div class="row">
      <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{dic['member']}}</h5>
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
                               <div class="form-group"><label class="col-sm-2 control-label">{{dic['username']}}</label>

                                    <div class="col-sm-5">
                                    <input type="text" value="{{user['username']}}" class="form-control" name="data[username]">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{dic['pass']}}</label>

                                  <div class="col-sm-5">
                                  <input type="text" placeholder="" class="form-control" name="data[password]" value="">
                                  </div>
                                    <div class="col-sm-5">
                                        <!-- <span>如要修改密码请填写,不需要为空!</span> -->
                                    </div>
                                </div>
                                                             
                               
                                
                                
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group"><label class="col-sm-2 control-label">
                                    {{dic['start_date']}}
                                  </label>

                                    <div class="col-sm-5">
                                      <input type="text" class="form_datetime form-control" name="data[start_time]" value="{{user['start_time']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                <input name="id" type="hidden" value="{{user['id']}}"/>
                                <input name="data[accesskey]" type="hidden" value="{{accesskey}}"/>
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group">
                                  <label class="col-sm-2 control-label">{{dic['end_date']}}
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="text" class="form_datetime form-control" name="data[end_time]"  value="{{user['end_time']}}"></div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                
                             
                                
                                <div class="hr-line-dashed"></div>
                              
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">   
                                        <button class="btn btn-primary" id="saving" type="button">{{dic['save']}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
              
  </div>
  </div>
  
{% endblock %}


{% block script %}
<script src="//cdn.bootcss.com/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
<script src="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
<script type="text/javascript">


  
    $(function(){      
    

      $("#saving").click(function(event) {
     

        $.ajax({
          url: '?',
          type: 'POST',
          dataType: 'json',
          data: $("#dataform").serialize(),
        })
        .done(function(ret) {
            if(ret.status=='success'){
              swal({
                  title: "{{dic['success_t']}}",
                  text: "{{dic['success']}}",
                  type: "success"
              },function(){
                window.location.reload();
              });

            }else{
               swal({
                  title: "{{dic['false_t']}}",
                  text: "{{dic['false']}}",
                  type: "warning"
              });

            }
        });
        
      });

    })

    $(document).ready(function(){
        $(".form_datetime").datepicker({format: 'yyyy-mm-dd'});
    });


  
                  
               

</script>

{% endblock %}
