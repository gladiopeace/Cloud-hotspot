{% extends "/layout/hotspot_boot.html" %}
{% set active_now='themes' %}

{% block head %}
	<meta charset="UTF-8">
    {{ parent() }}

{% endblock %}


{% block content %}

  <div class="row">
    {% for v in result %}
      <div class="col-md-3" style="margin-bottom: 20px;">
		  <div class="ibox-content text-center">
	        <h1>{{v['name']}}</h1>
	        <div class="m-b-sm">
	                <img alt="image" src="{{v['picture']}}" style="width: 100px;height: 100px;">
	        </div>
	       <p class="font-bold">{{v['note']}}</p>

	        <div class="text-center">

                {% if v['install']==1 %}   
                  <br/>        
                 已经安装
                 <br/>
                {% elseif v['install']==0 %}
                    <a class="btn btn-defualt btn-white install" data-theme="{{v['data']['@attributes']['base']}}" data-name="{{v['name']}}" data-type="{{v['data']['type']}}" data-picture="{{v['picture']}}" data-note="{{v['data']['description']}}">安装</a>
                  
                {% endif %}
              
	            
	     
	        </div>
	    	</div>
	   </div>
       {% endfor %}
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

    
      $(".install").click(function(event) {

        var $this = $(this);
        var name = $this.data('name');
        var style = $this.data('theme');
        var type = $this.data('type');
        var note = $this.data('note');
        var picture = $this.data('picture');
        var data = {'name':name,'note':note,'type':type,'picture':picture,'style':style};
        
        $.ajax({
          url: '/hotspot/install_theme',
          type: 'POST',
          dataType: 'json',
          data: {'data':data},
        })
        .done(function(ret) {
            if(ret.status=='success'){
                $(".saving").text('启用').removeClass('btn-primary').addClass('btn-white');
                $this.text('已启用').addClass('btn-primary').removeClass('btn-white').removeClass('install');
                toastr.success('温馨提示:已经为您完成安装!');

            }else{
              toastr.warning('错误提示:未完成安装或主题早已安装，请重试!');

            }
        });

      });

    })





</script>

{% endblock %}
