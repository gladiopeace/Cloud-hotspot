{% extends "/layout/layer_boot.html" %}
{% block head %}
  <meta charset="UTF-8">
    <link href="//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet">
   
    {{ parent() }}
    <style type="text/css">
    body{overflow: hidden;}
    </style>
{% endblock %}


{% block content %}

  <div class="container-fluid">
      <div class="row text-center" style="padding-top:66px;">

        <div class="col-xs-4">
          <div class="thumbnail">
            <br/>
            <i class="fa fa-paper-plane-o fa-5x" aria-hidden="true"></i>

            <div class="caption">
              
              <h3>
                500(条)
              </h3>
              <p>
                价格:<i style="color:red;">50.00</i>元
              </p>
              <p>            
                有效期:长期有效              
              </p>
              <a class="btn btn-success" href="/hotspot/buymessage/post?message=500" target="_blank">支付此计划</a>
            </div>
          </div>
        </div>



        <div class="col-xs-4">
          <div class="thumbnail">
            <br/>
            <i class="fa fa-paper-plane-o fa-5x" aria-hidden="true"></i>

            <div class="caption">
              
              <h3>
                1100(条)
              </h3>
              <p>
                价格:<i style="color:red;">100.00</i>元
              </p>
              <p>
                有效期:长期有效              
              </p>
              <a class="btn btn-success" href="/hotspot/buymessage/post?message=1100" target="_blank">支付此计划</a>
              
            </div>
          </div>
        </div>




        <div class="col-xs-4">
          <div class="thumbnail">
            <br/>
            <i class="fa fa-paper-plane-o fa-5x" aria-hidden="true"></i>

            <div class="caption">
              
              <h3>
               5600(条)
              </h3>
              <p>
                价格:<i style="color:red;">500</i>元
              </p>
              <p>
                有效期:长期有效
              
              </p>
              <a class="btn btn-success" href="/hotspot/buymessage/post?message=5600" target="_blank">支付此计划</a>
              
            </div>
          </div>
        </div>




    


</div>
  </div>




{% endblock %}

{% block script %}


{% endblock %}