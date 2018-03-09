<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
 <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
  
  <!-- head 中 -->
  <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.0.1/style/weui.min.css">
  <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
  <link href="//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet">
  
  <style type="text/css">    
    header{  
      right: 0;
      left: 0;
      z-index: 10;
      height: 3.2rem;
      padding-right: 0.5rem;
      padding-left: 0.5rem;
      background-color: #f7f7f8;
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      
    }
    .title{
      position: absolute;
    display: block;
    width: 100%;
    padding: 0;
    margin: 0 -0.5rem;
    font-size: 1rem;
    font-weight: 500;
    line-height: 3.2rem;
    color: #3d4145;
    text-align: center;
    white-space: nowrap;
    }
  </style>
  
</head>

<body>
      
      <div style="margin: 48px 0px auto;text-align: center;">
      <i class="fa fa-dropbox fa-5x"></i>  
      </div> 
     

        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">店铺名称:</label></div>
                <div class="weui-cell__hd weui_cell__primary">
                    <input class="weui-input" type="text" id="branch" placeholder="请输入店铺名称"/>
                </div>
            </div>
           
            <div class="weui-cell">
                <div class="weui-cell__hd">
                  <label class="weui-label">店铺地址:</label>
                </div>
                <div class="weui-cell__bd weui-cell__primary">
                    <input class="weui-input" type="text" id="address" placeholder="请输入店铺地址"/>
                </div>
            </div>


             <div class="weui-cell">
                <div class="weui-cell__hd">
                  <label class="weui-label">联系电话:</label>
                </div>
                <div class="weui-cell__bd weui-cell_primary">
                    <input class="weui-input" type="text" id="cellphone" placeholder="请输入联系电话"/>
                </div>
            </div>

        </div>
      
        <br/>                     
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:void(0);" id="btn">立即创建</a>
        </div>
        

  <script src="//cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        
  <link href="//cdn.bootcss.com/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <script src="//cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  <link href="https://cdn.bootcss.com/sweetalert/1.1.2/sweetalert.min.css" rel="stylesheet">
  <script src="https://cdn.bootcss.com/sweetalert/1.1.2/sweetalert.min.js"></script> 
  <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }      
      
      $(function(){

        $("#btn").click(function(event) {
          
          var address = $("#address").val();
          var branch = $("#branch").val();
          var cellphone = $("#cellphone").val();
          
          if(branch==''){
            toastr.warning("请输入店铺名称!");  
            return false;
          }

          if(cellphone==''){
            toastr.warning("请输入联系电话!");  
            return false;
          }

          if(address==''){
            toastr.warning("请输入店铺地址!");  
            return false;
          }

          $.ajax({
            url: '?',
            type: 'POST',
            dataType: 'json',
            data: {'data[cellphone]':cellphone,'data[branch]':branch,'data[address]':address},
          })
          .done(function() {
            console.log("success");
            swal({   
              title: "创建完成",
              text: "恭喜您,门店创建完成!",
              type: "success",           
              confirmButtonText: "确认",   
              closeOnConfirm: false 
            }, 
            function(){
               window.location.href='/manage';
              //swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
             });
            //toastr.success("验证码发送完成,请查收!");      
          })
          .fail(function() {
            toastr.warning("请求超时,请重试!");  
           
          });
          
        
        });

      }); 

      
       

        function ajaxCreate(username,password){

          api.showProgress({
                  style: 'default',
                  animationType: 'fade',
                  title: '请稍等...',
                  text: '正在登录中',
                  modal: false
              });
             var url = $api.getStorage('base_url')+"/v2/account/login";
          
             api.ajax({
                 url: url,
                 method: 'post',
                 data: {
                     values: { 
                        'email': username,
                        'password': password    
                     }
                 }
             },function(ret, err){
                 api.hideProgress();
                 if (ret) {
                   
                   
                     if(ret.status==2000 && ret.message=='success'){
                
                       api.execScript({
                            name : 'root',                     
                            script : 'title("工作台")'
                      });

                      //window.location.href = "./main.html";                     
                      window.location.href = "./manage.html";                     
                      $api.setStorage('username', ret.data.username);
                      $api.setStorage('id', ret.data.id);
                      $api.setStorage('salt', ret.data.salt);
                      $api.setStorage('company', ret.data.company);

                     }else{
                      api.toast({
                          msg: ret.message,
                          duration: 2000,
                          location: 'bottom'
                      });
                      //alert( JSON.stringify( ret.message) );
                     }
                  
                 } else {
                  alert( JSON.stringify( err ) );
                 }
             });
        }

        function bechTokenk(){      
          var id = $api.getStorage('id');
          var salt = $api.getStorage('salt');
          var username = $api.getStorage('username');
          var token = '{"id":"'+id+'","salt":"'+salt+'","username":"'+username+'"}';            
          token = $api.strToJson(token);
          return token;

        }

        function bechToken(){
          var id = $api.getStorage('id');
          var salt = $api.getStorage('salt');
          var username = $api.getStorage('username');
          var channel = $api.getStorage('channel');
          var token = '{"id":"'+id+'","salt":"'+salt+'","username":"'+username+'","channel":"'+channel+'"}';
          token = $api.strToJson(token);
          return token;
        }

        function ajaxPost(data){
            $.ajax({
              url: "?",
              type: 'POST',
              dataType: 'json',
              data: data,
            })
            .done(function(ret) {
              if(ret.status=='success'){
                explode(ret.data);    
                alert('创建完成!');
                downloads();
              }else if(ret.status=='false'){
                alert(ret.message);
              }
            });
            
        }

        function test(data){
          alert( JSON.stringify( data ) );
        }

      </script> 
</body>
</html>