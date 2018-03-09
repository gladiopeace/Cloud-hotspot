{% extends "/layout/hotspot_boot.html" %}
{% set active_now='branch' %}
{% block head %}
  <meta charset="UTF-8">
    {{ parent() }}
   <style media="screen">
        .main{width: 800px;min-height: 400px;border: 1px solid #ccc;padding-bottom: 60px;}
        .menu {background: #eee;padding: 20px;}
        .menu input{width: 80%;display: inline;margin-right: 16px;}
        .menu a{margin: 5px;}
        .menu .sub{
            margin-top:20px;padding-left:80px;background:url('{{base_url}}/Public/static/images/bg_repno.gif') no-repeat -245px -545px;
        }
        .menu .sub input{width: 76%;}

        .radio.inline{
        display: inline-block;

        }


        #footer{width: 800px;height: 60px;border: 1px solid #ccc;position: relative;top: -60px;line-height: 60px;text-align: center;}
        #footer a {margin: 10px;}
    </style>
{% endblock %}


{% block content %}
  <style type="text/css">
    .nav > li.active {
     border:none; 
    }

  </style>
  <div class="row">
    <div class="col-md-12">

        <div class="col-lg-12">
            <div class="ibox float-e-margins">
            <div class="ibox-title">
                 <h5>访问记录</h5>                  
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
          
            <div id="editable_wrapper" class="dataTables_wrapper form-inline">


             <table class="table table-striped table-bordered table-hover  dataTable" id="editable" role="grid" aria-describedby="editable_info">
                <thead>
                <tr>
                    <td>序号</td>

                    <td>授权码</td>
                    <td>MAC地址</td>
                    <td>授权类型</td>
                    <td>授权时间</td>
                    <td>生成时间</td>

                </tr>
            </thead>
            <tbody>
            
            {% for v in result %}
            <tr class="gradeA odd" id="del{{v['id']}}">
           <td>{{v['id']}}</td>
           <td>{{v['access_code']}}</td>
          <td>{{v['device_mac']}}</td>
          <td>
          {% if v['auth_type']=='fetch-wechat-code' %}
                微信连Wi-Fi
          {% elseif v['auth_type']=='fetch-member-account' %}
                账号登录授权
          {% elseif v['auth_type']=='verify-code-cellphone' %}
                手机验证授权
          {% endif %}
          </td>

        <td>
            {% if v['auth_type'] %}
                {{v['auth_time']|date('Y-m-d H:i:s')}}
            {% else %}
                未完成授权
            {% endif %}
        </td>


         <td>
          {{v['addtime']|date('Y-m-d H:i:s')}}

          </td>
            

                 
            </tr>

            {% endfor %}
            
            </tbody>
          
            </table>
            <div class="row">
            <!-- <div class="col-sm-6">

                <a href="/hotspot/users_add?accesskey={{accesskey}}" class="btn btn-primary ">增加用户</a>
            </div> -->
            <div class="col-sm-6">
            <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate"><ul class="pagination">
              
              {{page|raw}}
            </ul></div></div></div>

            </div>


            
            </div>
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
          timeOut: 6000
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
              toastr.warning('温馨提示:没有修改任何数据!');

            }
        });
        
      });

    })

                  
               
function del(id){

  $.ajax({
    url: '/hotspot/users_del',
    type: 'post',
    dataType: 'json',
    data: {'id': id},
  })
  .done(function(ret) {
    if(ret.status=='success'){
      $("#del"+id).remove();
       toastr.success('温馨提示:已经为您删除完成!');
    }
  });
  
}
</script>


{% endblock %}
