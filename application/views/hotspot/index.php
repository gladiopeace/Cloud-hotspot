{% extends "/layout/hotspot_boot.html" %}


{% block head %}
	<meta charset="UTF-8">
    {{ parent() }}



{% endblock %}


{% block content %}
        <div class="row">
         
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">

                        <div class="col-xs-4">
                            <i class="fa fa-envelope-o fa-5x"></i>

                        </div>
                        <div class="col-xs-8 text-right">
                            <span>已发短信数</span>

                            <h2 class="font-bold"><span id="message_total"></span> </h2>
                         
                        </div>
                        

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-wechat fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> 微信连Wi-Fi </span>
                            <h2 class="font-bold" id="wechat_count"></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-rss fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> 短信认证</span>
                            <h2 class="font-bold" id="message_count"></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-paper-plane fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> 账号认证 </span>
                            <h2 class="font-bold" id="account_count"></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                       
                        <div class="ibox-content">

                        
                            <div class="flot-chart main" style="height: 400px;" id="main">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{% endblock %}

{% block script %}

<script src="//cdn.bootcss.com/layer/2.4/layer.min.js"></script>
<script src="//cdn.bootcss.com/echarts/2.2.6/echarts-all.js"></script>
<script type="text/javascript">
 // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));



        // 使用刚指定的配置项和数据显示图表。
        //myChart.setOption(option);
  // 路径配置
        $.ajax({
            url: '/hotspot/init',
            type: 'POST',
            dataType: 'json',
            data: {'days': 'test'},
        })
        .done(function(rest) {

           
            if(rest.status=='success'){
                //alert(rest.status);              
                test(rest.data);
                           
                $("#wechat_count").text(rest.summary.wechat);
           

                $("#message_count").text(rest.summary.cellphone);
        

                     
                $("#message_total").text(rest.summary.total_message);
            
       
                $("#account_count").text(rest.summary.account);
                

            }
            
        });

        function test(data){
            

            var rest=[];
            var rest_total=[];
            var rest_wechat=[];
            var rest_account=[];
            var rest_cellphone=[];
            var i =0;
           
            $.each(data,function(key,val){               
               

                rest[i]= key;
                rest_total[i]= val['total'];
                rest_wechat[i]= val['wechat'];
                rest_cellphone[i]= val['cellphone'];
                rest_account[i]= val['account'];
                i++
            });

      
           
            option = {
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['总访问','微信连Wi-Fi','手机认证','账号认证']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data :rest
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'总访问',
                        type:'line',
                        stack: '总量',
                        data:rest_total
                    },
                    {
                        name:'微信连Wi-Fi',
                        type:'line',
                        stack: '总量',
                        data:rest_wechat
                    }
                    ,
                    {
                        name:'手机认证',
                        type:'line',
                        stack: '总量',
                        data:rest_cellphone
                    },
                    {
                        name:'账号认证',
                        type:'line',
                        stack: '总量',
                        data:rest_account
                    }
                ]
            };



        // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option)


        } 


        function buyMsg(){

            var access = '{{accesskey}}';
            var ok = Math.random();
            var url ="/hotspot/buymessage/init?access="+access+"&hash="+ok;
            layer.open({
                type: 2,
                title: '短信充值',
                area: ['640px', '460px'],
                fix: true, //不固定
                maxmin: true,
                content: url
            });
        }



    </script>
{% endblock %}