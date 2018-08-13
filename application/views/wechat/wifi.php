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
                            <h5>{{dic['title']}}</h5>
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
                                <div class="form-group"><label class="col-sm-2 control-label">{{dic['shop_name']}}</label>

                                    <div class="col-sm-5">
                                    <input type="text" name="data[name]" class="form-control" value="{{result['name']}}"  placeholder="{{dic['shop_name_fill']}}">
                                    </div>

                                    <div class="col-sm-5">
                                   
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                              
                               
                                <div class="form-group"><label class="col-sm-2 control-label">{{dic['ssid']}}:</label>

                                    <div class="col-sm-5">
                                    <input type="text"  name="data[ssid]" class="form-control" value="{{result['ssid']}}" placeholder="{{dic['ssid_fill']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>

                             <!--    <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">MAC地址:</label>

                                    <div class="col-sm-5">
                                    <input type="text" placeholder="请输入MAC地址(hotspot网卡mac)" class="form-control" name="data[bssid]" value="{{result['bssid']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <span></span>
                                    </div>
                                </div> -->
                                  
                                  <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{dic['appid']}}:</label>

                                    <div class="col-sm-5">
                                    <input type="text" placeholder="{{dic['appid_fill']}}" class="form-control" name="data[appid]" value="{{result['appid']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <span></span>
                                    </div>
                                </div>
                                  
                                  <div class="hr-line-dashed"></div>

                                  <div class="form-group">

                                   <label class="col-sm-2 control-label">{{dic['shopid']}}:</label>
                                   <div class="col-sm-5">
                                            <input type="text" name="data[shopid]" class="form-control" placeholder="{{dic['shopid_fill']}}" value="{{result['shopid']}}">
                                    </div> 
                                    <div class="col-sm-5">
                                        
                                    </div>
                               
                                   
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                  <label class="col-sm-2 control-label">{{dic['secretkey']}}:</label>
                                    <div class="col-sm-5">
                                         <input type="text" name="data[secretkey]" class="form-control" placeholder="{{dic['secretkey_fill']}}" value="{{result['secretkey']}}">
                                    </div>
                                                                      
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                            
                                <input name="id" type="hidden" value="{{result['id']}}"/>
                                <input name="accesskey" type="hidden" value="{{accesskey}}"/>
                            
                                  
                                
                                
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

        $.ajax({
          url: '?',
          type: 'POST',
          dataType: 'json',
          data: $("#dataform").serialize(),
        })
        .done(function(ret) {
            if(ret.status=='success'){
              toastr.success("{{dic['success']}}");

            }else{
              toastr.warning("{{dic['false']}}");

            }
        });
        
      });

    })
  
               

</script>

{% endblock %}
