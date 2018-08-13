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

                {% if v['id']==active %}
           
                    <a class="btn btn-defualt btn-primary saving">{{dic['activated']}}</a> 
                {% else %}
                    <a class="btn btn-defualt btn-white saving" data-id="{{v['id']}}">{{dic['activate']}}</a>
                  
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

          positionClass: "toast-top-center",
          closeButton: true,
       /*   progressBar: true,*/
          showMethod: 'slideDown',
          timeOut: 4000
      };


    
      $(".saving").click(function(event) {
        var $this = $(this);
        var id = $this.data('id');
      
            
        $.ajax({
          url: '/hotspot/themes_update',
          type: 'POST',
          dataType: 'json',
          data: {'id':id,'accesskey':"{{accesskey}}",'type':"{{type}}"},
        })
        .done(function(ret) {
            if(ret.status=='success'){
                $(".saving").text("{{dic['activate']}}").removeClass('btn-primary').addClass('btn-white');
                $this.text("{{dic['activated']}}").addClass('btn-primary').removeClass('btn-white');
                toastr.success("{{dic['success']}}");

            }else{
              toastr.warning("{{dic['false']}}");

            }
        });

      });

    })





</script>

{% endblock %}
