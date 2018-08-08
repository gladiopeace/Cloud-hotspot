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
                                <div class="form-group"><label class="col-sm-2 control-label">{{dic['site']}}</label>

                                    <div class="col-sm-5">
                                    <input type="text" name="data[branch]" class="form-control" value="{{bech['branch']}}">
                                    </div>

                                    <div class="col-sm-5">
                                   
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                              
                               
                                <div class="form-group">
                                  <label class="col-sm-2 control-label" id='user-lable'>
                                    {% if bech['brand'] == 'mikrotik' %} {{dic['user_mikrotik']}} {% elseif bech['brand'] == 'ubnt' %} {{dic['user_ubnt']}} {% endif %}
                                    
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="text" id='user-text' value="{{bech['access_info']['username']}}" class="form-control" name="access_info[username]" placeholder="{% if bech['brand'] == 'mikrotik' %} {{dic['user_mikrotik']}} {% elseif bech['brand'] == 'ubnt' %} {{dic['user_ubnt']}} {% endif %}">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label" id="pass-lable">                                  
                                    {% if bech['brand'] =='mikrotik' %} {{ dic['pass_mikrotik'] }} {% elseif bech['brand'] =='ubnt' %} {{ dic['pass_ubnt'] }} {% endif %}
                                 
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="password" id='pass-text' placeholder="{% if bech['brand'] =='mikrotik' %} {{ dic['pass_mikrotik'] }} {% elseif bech['brand'] =='ubnt' %} {{ dic['pass_ubnt'] }} {% endif %}" class="form-control" name="access_info[password]" value="{{bech['access_info']['password']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <span></span>
                                    </div>
                                </div>
                                                             
                               
                                
                                
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group"><label class="col-sm-2 control-label" id='ip-lable'>
                                    {% if bech['brand'] =='mikrotik' %} {{ dic['ip_mikrotik'] }} {% elseif bech['brand'] =='ubnt' %} {{ dic['ip_ubnt'] }} {% endif %}
                                   
                                  </label>

                                    <div class="col-sm-5">
                                      <input type="text" class="form-control" id="ip-text" placeholder="{% if bech['brand'] =='mikrotik' %} {{ dic['ip_mikrotik'] }} {% elseif bech['brand'] =='ubnt' %} {{ dic['ip_ubnt'] }} {% endif %}" name="access_info[ip]" value="{{bech['access_info']['ip']}}">
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                <input name="id" type="hidden" value="{{bech['id']}}" id="download_id"/>
                                <input name="salt" type="hidden" value="{{bech['salt']}}"/>
                                <div class="hr-line-dashed"></div>

                                  <div class="form-group">
                                  <label class="col-sm-2 control-label">{{dic['redirect']}}
                                  </label>

                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="access_info[url]" value="{{bech['access_info']['url']}}"></div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>



                                <div class="form-group"><label class="col-sm-2 control-label">{{dic['brand']}}</label>

                                    <div class="col-sm-5">

                                      <input class="brand-type" type="radio" name="data[brand]" {% if bech['brand']=='mikrotik' %} checked{% endif %} value="mikrotik">
                                      Mikrotik
                                      <input class="brand-type" type="radio" name="data[brand]"{% if bech['brand']=='ubnt'%} checked{% endif %} value="ubnt">
                                      Ubiquiti
                                     
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>



                                <div class="form-group"><label class="col-sm-2 control-label">{{dic['authen_type']}}</label>

                                    <div class="col-sm-5">

                                      <input type="radio" name="data[type]" {% if bech['type']=='normal' or bech['type']=='' %} checked{% endif %} value="normal">
                                      {{ dic['sms'] }}
                                      <input type="radio" value="account" name="data[type]"{% if bech['type']=='account'%} checked{% endif %}>
                                      {{ dic['member'] }}                                    
                                      <input type="radio" value="wechat" name="data[type]" {% if bech['type']=='wifi' or bech['type']=='wechat' %} checked{% endif %}>
                                      {{ dic['wechat'] }}                                           
                                    </div>
                                    <div class="col-sm-5">
                                        
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>


                             


                                 <div class="form-group"><label class="col-sm-2 control-label"></label>

                                    <div class="col-sm-5">

                                       <button class="btn btn-primary" id="saving" type="button">{{dic['save']}}</button>
                                        &nbsp;&nbsp;&nbsp;
                                       <button class="btn btn-success" onclick="preview();" type="button">{{dic['preview']}}</button>
                                        &nbsp;&nbsp;&nbsp;
                                        {%  if bech['brand']=='mikrotik' %}
                                        <button class="btn btn-success" id='mikrotik-down' onclick="downloads();" type="button">{{dic['download']}}</button>
                                        {% endif %}
                                    </div>
                                    <div class="col-sm-5">
                                        
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
<script src="https://cdn.bootcss.com/layer/3.0.2/layer.min.js"></script>
<link href="https://cdn.bootcss.com/layer/3.0.2/skin/default/layer.css" rel="stylesheet">
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




      $(".brand-type").click(function(event) {
            console.log('eeeeee');
            /* Act on the event */
            let type = $(this).val();//$('input[name="brand"]:checked').val();          
            let user_ubnt = "{{dic['user_ubnt']}}";
            let user_mikrotik = "{{dic['user_mikrotik']}}";
            let pass_ubnt = "{{dic['pass_ubnt']}}";
            let pass_mikrotik = "{{dic['pass_mikrotik']}}";
            let ip_mikrotik = "{{dic['ip_mikrotik']}}";
            let ip_ubnt = "{{dic['ip_ubnt']}}";
            if(type=='mikrotik'){              
               $("#user-lable").text(user_mikrotik);        
               $("#pass-lable").text(pass_mikrotik);
               $("#user-text").text(user_mikrotik);        
               $("#pass-text").text(pass_mikrotik);
               $("#ip-text").text(ip_mikrotik);
               $("#ip-lable").text(ip_mikrotik);               
               $("#mikrotik-down").show();  
               
            }else if(type=='ubnt'){
              $("#user-lable").text(user_ubnt);        
               $("#pass-lable").text(pass_ubnt); 
               $("#user-text").text(user_ubnt);        
               $("#pass-text").text(pass_ubnt); 
               $("#ip-lable").text(ip_ubnt);
               $("#ip-text").text(ip_ubnt);
               $("#mikrotik-down").hide();        
               
            }
                        
            console.log(type);
        });


    })

    
  function downloads(){
    var id  = $("#download_id").val();
    $('body').append("<iframe style='display:none;' src='/hotspot/downtest?id="+id+"'></iframe>" );
  }

  function preview(){
    var url = "/hotspot/preview?salt={{bech['salt']}}"
    layer.open({
      type: 2,
      title: "Wi-Fi Portal -- {{dic['preview']}}",
      shadeClose: true,
      shade: 0.8,
      area: ['368px', '580px'],
      content: url//iframe的url
    }); 
  }
          
               

</script>

{% endblock %}
