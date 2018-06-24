<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Cloud Hotspot</title>
  <link href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="//cdn.bootcss.com/jquery/2.0.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style type="text/css">

  .select{
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;

  }

  </style>
</head>
<body>
  <div class="container" style="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form class="form-horizontal" id="post">
                <br/>
                  <div class="form-group">
                  <label class="col-sm-3 col-xs-3 text-center">{{account}}</label>

                    <div class="col-sm-8 col-xs-8">
                    <input type="text" name="data[account]" class="form-control" id="email_add" value="" placeholder="{{account_fill}}">
                  </div>

                   
                </div>
                <div class="form-group">
                   <label class="col-sm-3 col-xs-3 text-center">{{verify}}</label>
                    <div class="col-sm-8 col-xs-8">
                      <div class="input-group">
                        
                        <input class="form-control" name="data[code]" type="text" placeholder="{{verify_fill}}">
                        <div class="input-group-addon" data-lock='wait' style="width: 88px;text-align: center;color: white;cursor: pointer;background-color: #47B347;" id="getEmail">{{verify_code}}</div>
                      </div>
                    </div>
               
                </div>

                  <div class="form-group">
                  <label class="col-sm-3 col-xs-3 text-center">{{password}}</label>

                    <div class="col-sm-8 col-xs-8">
                    <input type="password" name="data[password]" placeholder="{{password_fill}}" class="form-control" value="">
                  </div>

                   
                </div>

               
                <div class="hr-line-dashed"></div>
               
                <div class="form-group">
                    <div class="col-sm-12 col-sm-offset-12 text-center">   
                      <button class="btn btn-success" id="saving" type="button">{{submit}}</button>
                  </div>                                  

              </div>
             
            </form>
        </div>
       

    </div>
    
  </div>
<link href="//cdn.bootcss.com/toastr.js/2.0.3/css/toastr.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/toastr.js/2.0.3/js/toastr.min.js"></script>

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
    $("#saving").click(function(event) {
      
      var account = $('#email_add').val();
     
      var p=check;//Object.create(check);
      flag = p.mail(account);   
      if(!flag) flag = p.phone(account);  
      if(!flag){
        $("#account").focus();
        toastr.warning("手机号码或邮箱地址错误!");  
        return false;
      }
      //return false;
      $.ajax({
        url: '?',
        type: 'POST',
        dataType: 'json',
        data: $("#post").serialize(),
      })
      .done(function(ret) {
        if(ret.status=='success'){ 
            toastr.success("新密码重置完成,请登录!");             
             //parent.$('#company_place').text($("#company").val());
             /* swal({
                  title: "注册完成!",
                  //text: "请等待我们的审核!",
                  text: "商户号已发送至邮箱,请查收!",
                  type: "success"
              });*/

        }else{
          
            /* swal({
                  title: "注册失败!",
                    text: ret.message,
                  type: "info"
              });*/
            //swal("邮箱地址格式错误!");
            toastr.warning(ret.message);             

          
        }
        //console.log("success");
      });
      
    });



    $("#getEmail").click(function(event) {
      /* Act on the event */
      
      let lock = $(this).data('lock');

      if(lock!='wait') return false;

      $(this).data('lock', 'locked');

      let account = $('#email_add').val();

      timer2=window.setInterval("startShow()",1000);
     
      let p=check;//Object.create(check);

      flag = p.mail(account);   
      if(!flag) flag = p.phone(account);  
      if(!flag){
        $("#account").focus();
        toastr.warning("手机号码或邮箱地址错误!");  
        return false;
      }

      toastr.info("正在为您请求中,请等待……");    

      $.ajax({
        url: '/component/restByCode/get',
        type: 'POST',
        dataType: 'json',
        data: {'account':account},
      })
      .done(function(ret) {
        if(ret.status=='success'){
          toastr.success("已成功发送验证码!");          
        }
        if(ret.status=='false'){
            /*swal({
                title: "注册失败!",
                text: ret.message,
                type: "info"
            });*/
          toastr.warning(ret.message);    

        }

       
      });
      
     


    });

    var EndTime=60;
    var intvalue=0;
    var timer2=null;

    function startShow(){
        intvalue ++;
        document.getElementById("getEmail").innerHTML="&nbsp;" + ((EndTime-intvalue)%60).toString()+"秒后重新获取";
        if(intvalue>=EndTime){
          $(this).data('lock', 'locked');
          document.getElementById("getEmail").innerHTML="{{verify_code}}";          
          endShow();
        }
    }

    function endShow(){
        window.clearTimeout(timer2);
        intvalue=0;
        timer2=null;
    }

     function testEmail(str){
      var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
      if(reg.test(str)){
        return true;
      }else{
        return false;
      }
    }


    var check = {
      mail:function(mail){
        var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            if(!reg.test(mail)) return false;
            return true;
      },
      phone:function(phone){
        var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/; 
        if(!myreg.test(phone)) return false;
        return true;
      },
    }

    


  </script>
</body>
</html>