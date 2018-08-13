{% extends "/layout/hotspot_boot.html" %}
{% set active_now='system' %}

{% block head %}
  <meta charset="UTF-8">
    {{ parent() }}
    <link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
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
                    <h5>系统设备号</h5>
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
                       <div class="form-group">
                          <label class="col-sm-2 control-label">设备号</label>
                            <div class="col-sm-5">
                              <input id="accesskey" onclick="CopyIt('accesskey');" type="text" name="data[title]" class="form-control" value="{{accesscode}}">
                            </div>                                    
                        </div>
                        <div class="hr-line-dashed"></div>
                    </form>

                </div>
            </div>
      </div>
    </div>
  
{% endblock %}


{% block script %}


<script type="text/javascript">

  

  
function CopyIt(id){
  $("#"+id).select();
}     

</script>

{% endblock %}
