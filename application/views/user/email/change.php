<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>云热点--修改邮箱</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
        <meta name="renderer" content="webkit">

        <meta http-equiv="Access-Control-Allow-Origin" content="*">
        <link rel="stylesheet" href="{{base_url}}/Public/static/css/base.css">
        <link rel="stylesheet" href="{{base_url}}/Public/static/css/common/common-less.css">

        <link rel="stylesheet" href="{{base_url}}/Public/static/component/logic/login/login-regist.css">
        <link rel="stylesheet" href="{{base_url}}/Public/static/css/settings.css">
        <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<style type="text/css">
    .input-email{
        margin: 10px auto 30px;
  padding:  10px;
  width: 300px;
  height: 20px;
  line-height: 20px;
  border: 1px solid #c7ced1;
  border-radius: 2px;
  font-size: 12px;
  color: #969b9e;
  display: block;
    }
</style>

<body>



<div id="main">


<div class="wcontainer">
    <div class="wwrap wrap-boxes">
        <div class="wheader-wrap">
            <h1>新邮箱</h1>
        </div>

        <div class="result-container sent-success">
                    <p>
                    </p><h3>输入新邮箱</h3>
                    <input type="mail" id="email" placeholder="新邮箱地址" class="input-email js-email"><p class="notice" style='color:red;'></p>

                    <button id="js-submit" class="js-submit rlf-btn-green">修改邮箱</button>

        </div>
    </div>
</div>

</div>

<script type="text/javascript">

    $("#js-submit").click(function(event) {
        /* Act on the event */
        var email = $("#email").val();
        if(!email){
             $("#email").siblings('p.notice').text('请输入邮箱地址!');
            return false;

        }
        var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if(!reg.test(email)){
            $("#email").siblings('p.notice').text('邮箱地址错误!');
            return false;
        }

        $.ajax({
            url: "{{base_url}}/user/email/change",
            type: 'POST',
            dataType: 'json',
            data: {'email': email},
        })
        .done(function(ret) {

          if(ret.status=="success"){
            window.location.href=ret.url;
          }


          if(ret.status=="false"){
            $("#email").siblings('p.notice').text(ret.message);

          }



        });

    });




    $("#email").focus(function(event) {
        $(this).siblings('p.notice').text('');
    });
</script>
</body>
</html>
