{% extends "/layout/head.html" %}

{% block title %}Index{% endblock %}
{% block head %}
    {{ parent() }}

{% endblock %}
{% block content %}

  <!-- content start -->
<div class="admin-content" style="padding-bottom:30px;">

<div class="am-panel am-panel-primary" style="padding-bottom:30px;">
  <div class="am-panel-hd">图片管理</div>
  <div class="am-panel-bd">

      <table  data-am-widget="gallery" class="am-table am-table-bordered am-table-hover" data-am-gallery="{pureview: 1}">
        <tr>
          <td><input type="checkbox" class="all">全选</td>
          <td>图片(点击放大)</td>
          <td>图片地址</td>
          <td>增加时间</td>

        </tr>
        {% for v in results %}

        <tr>
          <td class="pitem" data-status="false" id="{{v['id']}}">
            <input type="checkbox" class="ckone">
          </td>

          <td>

            <img src="{{v['url']}}" data-rel="{{v['url']}}" alt="图片地址:{{v['url']}}&nbsp;&nbsp;&nbsp;上传时间:{{v['addtime']|date("Y-m-d H:i:s")}}" style="width:60px;height:60px;">




          </td>
          <td>{{v['url']}}</td>


          <td>{{v['addtime']|date("Y-m-d H:i:s")}}</td>



        </tr>
      {% endfor %}
    </table>
  <a href="javascript:void(0);" class="am-btn am-btn-success" onclick="del()">删除所选</a>

  <ul class='am-pagination am-pagination-right am-align-right'>
     {{ page|raw }}
  </ul>


  </div>
</div>


</div>

  <!-- content end -->


<script type="text/javascript">

window.onload=function(){

  $(".all").click(function(event) {
  /* Act on the event */
    var status = $(this).is(':checked');//全选

    selected(status);
  });


  $(".ckone").click(function(event) {
  /* Act on the event */
    var status = $(this).is(':checked');//全选
    if(status){
      $(this).parent('td').attr('data-status', 'success');
    }else{
      $(this).parent('td').attr('data-status', 'false');

    }

  });
}


function selected(flag){


  $(".pitem").each(function(index, el) {
    var status = $(this).attr('data-status');
    if(!flag){
      if(status=='success'){
        $(this).attr('data-status', 'false').find("[type='checkbox']").click();
      }
    }else{

      if(status=='false'){
        $(this).attr('data-status', 'success').find("[type='checkbox']").click();
      }
    }
  });
}

function del(){

  if(confirm('您确定要删除吗?')){


     $(".pitem").each(function(index, el) {
      var status = $(this).attr('data-status');
      var id = $(this).attr('id');

      if(status=='success'){

          $.ajax({
            url: "{{base_url}}/member/youtu/del",
            type: 'POST',
            dataType: 'json',
            data: {'id': id},
          })
          .done(function(ret) {
            removepic(id);
          });

      }

    });
  }



}

function removepic(id){
  $("#"+id).parent('tr').remove();
}







</script>
{% endblock %}
