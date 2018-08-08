<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>云热点节点设置向导</title>
    <style type="text/css">
        #wizard {border:5px solid #789;font-size:12px;height:508px;margin:10px auto;width:580px;overflow:hidden;position:relative;-moz-border-radius:5px;-webkit-border-radius:5px;}
        #wizard .items{width:20000px; clear:both; position:absolute;}
        #wizard .right{float:right;}
        #wizard #status{height:35px;background:#123;padding-left:25px !important;}
        #status {list-style: none;}
        #status li{float:left;color:#fff;padding:10px 30px;}
        #status li.active{background-color:#369;font-weight:normal;}
        .input{width:240px; height:18px; margin:10px auto; line-height:20px; border:1px solid #d3d3d3; padding:2px}
        .page{padding:20px 30px;width:500px;float:left;}
        .page h3{height:42px; font-size:16px; border-bottom:1px dotted #ccc; margin-bottom:20px; padding-bottom:5px}
        .page h3 em{font-size:12px; font-weight:500; font-style:normal}
        .page p{line-height:24px;}
        .page p label{font-size:14px; display:block;}

    </style>

    <script src="//cdn.bootcss.com/jquery/2.0.1/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/scrollable.js"></script>
</head>

<body style="overflow: hidden;">


<div id="main">

    <form action="#" method="post">
        <div id="wizard">
            <ul id="status">
                <li class="active"><strong>1.</strong>{{step1}}</li>
                <li><strong>2.</strong>{{step2}}</li>
                <li><strong>3.</strong>{{step3}}</li>
                <li><strong>4.</strong>{{step4}}</li>
            </ul>

            <div class="items">
                <div class="page">
                    <h3>{{step1_title}}</h3>
                    <p>
                        <label>{{brand}}：</label>
                        <input type="radio" class="brand-type" value="ubnt" checked="checked" name="data[brand]">Ubiquiti
                        <input type="radio" class="brand-type" value="mikrotik" name="data[brand]">Mikrotik
                       
                    </p>
                    <p>
                        <label>{{site}}：</label>
                        <input type="text" class="input" id="branch" name="data[branch]" placeholder=""/>
                    </p>

                    <p>
                        <label id="brand-ip" data-ubnt='{{ip_ubnt}}' data-mikrotik='{{ip_mikrotik}}'>{{ip_ubnt}}：</label>
                        <input type="text" class="input" id="ip" name="data[ip]" placeholder="" value="192.168.88.1"/>
                    </p>
                   

                    <p>
                        <label>{{redirect}}：</label><input type="text" class="input" id="url" name="data[url]" placeholder="http://www.google.com" value="http://www.google.com"/></p>
                    <div class="btn_nav">
                        <input type="button" class="next right" value="{{next}}&raquo;" />
                    </div>
                </div>
                <div class="page">
                    <h3>{{step2_title}}</h3>
                    <p>
                        <label id='user-text'>{{user_ubnt}}:</label>
                        <input type="text" class="input" id="user" name="user[username]" placeholder=""  />
                    </p>
                    <p>
                        <label id='pass-text'>{{pass_ubnt}}:</label>
                        <input type="password" id="pass" class="input" name="user[password]"  placeholder=""/>
                    </p>
                    <p>
                        <label>{{pass_confirm}}：</label>
                        <input type="password" id="pass1" class="input" name="user[confirm]" placeholder=""/>
                    </p>

                    <div class="btn_nav">
                        <input type="button" class="prev" style="float:left" value="&laquo;{{previous}}" />
                        <input type="button" class="next right" value="{{next}}&raquo;" />                 
                    </div>
                </div>
                <div class="page">
                    <h3>{{step3_title}}<br/></h3>
                    <p>                       
                        <textarea rows="18" id="ap" name="ap" cols="68" placeholder="{{ap_fill}}"></textarea>
                    </p>

                    <div class="btn_nav">
                        <input type="button" class="prev" style="float:left" value="&laquo;{{previous}}" />
                        <input type="button" class="right apply" value="{{next}}&raquo;" />
                        <input type="hidden" class="next" id="success"/>
                    </div>
                </div>
                <div class="page">
                    <h3>{{success_title}}<br/><em>{{success_sub_title}}</em></h3>
                    <h4>{{congratulations}}</h4>
                    <div id="mikrotik-down" style="display: none;">
                        <p>{{mikrotik_download}}</p>
                        <p>{{mikrotik_tutorials}}</p>
                        <br/>
                        <br/>
                        <br/>
                        <div class="btn_nav">
                            <input type="hidden" id="download" value="">
                            <input type="button" value="{{download}}" onclick="downloads();"/>
                            <input type="button" class="right" value="{{tutorial_mikrotik}}"/>        
                        </div>
                    </div>

                    <div id="ubnt-down">                        
                        <p>{{ubiquiti_tutorials}}</p>                     
                        <br/>
                        <br/>
                        <br/>
                        <div class="btn_nav">
                            <input type="hidden" id="download" value="">                           
                            <input type="button"  value="{{tutorial_unifi}}"/>        
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </form><br />
    <br />
    <br />

</div>

<script type="text/javascript">
    $(function(){
        $("#wizard").scrollable({
            onSeek: function(event,i){
                $("#status li").removeClass("active").eq(i).addClass("active");
            },
            onBeforeSeek:function(event,i){
                if(i==1){
                    let user = $("#branch").val();
                    if(user==""){
                        alert("节点名不能为空！");
                        $("#branch").focus();
                        return false;
                    }
                    let ip = $("#ip").val();
                    let url = $("#url").val();
                    if(ip==""){
                        alert("ip地址不能为空！");
                        return false;
                    }
                    if(url==''){
                        alert("URL不能为空！");
                        return false;
                    }
                }

                if(i==2){
                    let user = $("#user").val();
                    if(user==""){
                        alert("请输入用户名！");
                        return false;
                    }
                    let pass = $("#pass").val();
                    let pass1 = $("#pass1").val();
                    if(pass==""){
                        alert("请输入密码！");
                        return false;
                    }
                    if(pass1 != pass){
                        alert("两次密码不一致！");
                        return false;
                    }

                }
            }
        });
        $(".apply").click(function(){

            let ap = $("#ap").val();

            if(ap==''){
                alert("The AP's MAC address can not be empty!");
                return false;
            }

            let data = $("form").serialize();

            $.ajax({
                url: "?",
                type: 'POST',
                dataType: 'json',
                data: data,
            })
            .done(function(ret) {
                if(ret.status=='success'){
                    explode(ret.data);
                    $("#download").val(ret.id);
                    $("#success").click();
                }else if(ret.status=='false'){
                    alert(ret.message);
                }
            });


        });

        $(".brand-type").click(function(event) {
            /* Act on the event */
            let type = $(this).val();//$('input[name="brand"]:checked').val();
            let mikrotik = $("#brand-ip").data('mikrotik');
            let ubnt = $("#brand-ip").data('ubnt');         
            let user_ubnt = "{{user_ubnt}}";
            let user_mikrotik = "{{user_mikrotik}}";
            let pass_ubnt = "{{pass_ubnt}}";
            let pass_mikrotik = "{{pass_mikrotik}}";
            if(type=='mikrotik'){              
               $("#brand-ip").text(mikrotik);   
               $("#user-text").text(user_mikrotik);        
               $("#pass-text").text(pass_mikrotik);
               $("#mikrotik-down").show();  
               $("#ubnt-down").hide();        
            }else if(type=='ubnt'){
               $("#brand-ip").text(ubnt);   
               $("#user-text").text(user_ubnt);        
               $("#pass-text").text(pass_ubnt); 
               $("#mikrotik-down").hide();        
               $("#ubnt-down").show();        
            }
                        
            console.log(type);
        });
    });


    function explode(config){
      var data = "<div class=\"col-md-3 col-sm-4 col-xs-6\"><div class=\"col-xs-12 choise_css\"><div class=\"panel text-center\"><div class=\"panel-body\"><i class=\"fa fa-dropbox fa-5x\" onclick=\"window.open('/hotspot/index?accesskey="+config['salt']+"','_blank')\"></i><h4>"+config['branch']+"</h4><span>"+config['overdue']+"</span></div></div></div></div>";
      parent.$('.container-fluid').append(data)
    } 
    function downloads(){

        var id  = $("#download").val();
        $('body').append("<iframe style='display:none;' src='/hotspot/downtest?id="+id+"'></iframe>" );


    }
</script>


</body>
</html>
