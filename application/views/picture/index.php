{% extends "/layout/hotspot_boot.html" %}
{% set active_now='picture' %}
{% block head %}
  <meta charset="UTF-8">
    {{ parent() }}
    <link rel="stylesheet" type="text/css" href="http://apps.bdimg.com/libs/lightbox/2.6/css/lightbox.css">
    <style media="screen">
        .lightBoxGallery {
            text-align: center;
        }

        table img {
           width: 60px;
           height: 60px;
           
         
        }



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

   

            <div class="ibox-title">
                 <h5>{{dic['library']}}</h5>                  
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
                    <td>{{dic['id']}}</td>
                    <td>{{dic['picture']}}</td>                    
                    <td>URL</td>
                    
                    <td>{{dic['upload_date']}}</td>
                    <td>{{dic['manage']}}</td>
                </tr>
            </thead>
            <tbody>
            
            {% for v in result %}
            <tr class="gradeA odd" id="del{{v['id']}}">
                <td>{{v['id']}}</td>
                <td>
                    
                    <a href="{{v['url']}}" data-lightbox="roadtrip"><img src="{{v['url']}}"></a>
                </td>
                <td>
                    {{v['url']}}
                </td>
       
         
        
                <td>{{v['addtime']|date('Y-m-d H:i:s')}}
                </td>
            

            <td>
            
            <a href="javascript:void(0);" onclick="del('{{v['id']}}');" class="btn btn-success">{{dic['del']}}</button>

            </td>            
            </tr>

            {% endfor %}
            
            </tbody>
          
            </table>
            <nav>
                <ul class="pagination">
                {{ page|raw }}
                </ul>
            </nav>
            </div>


            
            </div>
       


      
    </div>
  </div>
  
{% endblock %}


{% block script %}

<script src="http://apps.bdimg.com/libs/lightbox/2.6/js/lightbox.min.js"></script>
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

      });

    function del(id){
        $.ajax({
          url: '/picture/picdel',
          type: 'POST',
          dataType: 'json',
          data:{'id':id},
        })
        .done(function(ret) {
            if(ret.status=='success'){
              toastr.success('温馨提示:已经为您保存完成!');
              $("#del"+id).remove();

            }
        });
    }
               

</script>


{% endblock %}
