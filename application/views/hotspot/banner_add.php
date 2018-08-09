{% extends "/layout/hotspot_boot.html" %}
{% set active_now='theme' %}

{% block head %}
	<meta charset="UTF-8">
    {{ parent() }}
    <link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
    <style type="text/css">
    
   .pic{width:160px;border:1px solid #ccc;height:160px;}
  .pic img{width: 160px;height:160px;}
  </style>

{% endblock %}


{% block content %}
  
   <div class="row">
      <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{dic['banner']}}</h5>
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
                             
                               
                              
                  


                                <div class="hr-line-dashed"></div>
                               <input type="hidden" name="data[accesskey]" value="{{accesskey}}">


  

                      <div class="form-group news">
                        <label class="col-sm-2 control-label">{{dic['banner']}}:</label>
                        <div class="col-sm-5">
                        <div class="input-group">
                          <input type="text" class="form-control" name="data[thumb]" value="" id="fechurl">  

                          <!-- <input type="text" class="form-control" id="exampleInputAmount" placeholder="Amount"> -->
                          <div class="input-group-addon pic_s" style="background-color:#5eb95e;color: white;"><i class="fa fa-picture-o"></i>&nbsp;{{dic['choose']}}</div>
                          </div>
                        </div>
                          <!-- <div id="plib" class="pic">

                          </div> -->
                      </div>

             
            <input type="hidden" name="data[accesskey]" value="{{accesskey}}">
            
            <div class="form-group news">
              <label class="col-sm-2 control-label"></label>
              <div class="col-sm-5">      
                <div id="plib" class="pic">

                </div>
              </div>
            </div>

            <div class="form-group news">
            <label class="col-sm-2 control-label">{{dic['title']}}:</label>
            <div class="col-sm-5">
              <input type="text" name="data[title]" class="form-control" placeholder="请输入标题" value="">
            </div>
          </div>


            <div class="form-group news">
            <label class="col-sm-2 control-label">{{dic['sort']}}:</label>
            <div class="col-sm-5">
              <input type="text" name="data[order]" class="form-control" placeholder="请输入排序" value="">
            </div>
          </div>

          <div class="form-group news">
            <label class="col-sm-2 control-label">URL:</label>
            <div class="col-sm-5">
              <input type="text" name="data[url]" class="form-control" placeholder="请输入点击URL" value="">
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

<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>
<script src="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
<script type="text/javascript">

    $(function(){



    $(".type").click(function() {
        initups();
    });


  
    $(".pic_s").click(function(event) {
      libs('plib','fechurl');
    });


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

  });

  

  

  function libs(field,field_value){
   
    var ok = Math.random();

      var url = '/picture/component/init?field='+field+'&field_value='+field_value+'&hash='+ok+'"';
      layer.open({
        type: 2,
        title: "{{dic['library']}}",
        area: ['664px', '560px'],
        fix: false, //不固定
        maxmin: true,
        content: url
      });
 }


 $("#post").submit(function(){
   $.ajax({
     url: '?',
     type: 'POST',
     dataType: 'json',
     data:$(this).serialize(),
   })
   .done(function(ret) {
     if(ret.status=='success'){
       alert('增加完成!');
       window.location.reload();
     }else{
       alert('增加失败,请重试!');
     }
   });
   return false;
 });
           

</script>

{% endblock %}
