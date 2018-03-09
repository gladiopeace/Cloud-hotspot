<html>
<head>
	<title>注册商户</title>
	<link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
	<link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>
</head>
<body>
	<div style="text-align:center;margin-top:30px;">
		<img src="/Public/logo-mi.png">
	</div>

<div class="weui-cells weui-cells_form" style="margin-top:30px;">  


	<div class="weui-cell">
	    <div class="weui-cell__hd"><label for="" class="weui-label">帐&nbsp;号</label></div>
	    <div class="weui-cell__bd">
	       <input class="weui-input" type="text" id="account" placeholder="邮箱/手机号">
	    </div>
	</div>

  <div class="weui-cell weui-cell_vcode">
    <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="number" id="code" placeholder="请输入验证码">
    </div>
   	<div class="weui-cell__ft">
      <button class="weui-vcode-btn" style="width:120px;" id='vcode'>获取验证码</button>
    </div>
  </div>

   <div class="weui-cell">
    <div class="weui-cell__hd"><label for="" class="weui-label">密&nbsp;码</label></div>
    <div class="weui-cell__bd">
       <input class="weui-input" type="password" id="password" placeholder="请输入密码">
    </div>
  </div>

<!--  <div class="weui-cell">
    <div class="weui-cell__hd"><label for="" class="weui-label">确&nbsp;认</label></div>
    <div class="weui-cell__bd">
       <input class="weui-input" type="password" id="confirm" placeholder="输入确认密码">
    </div>
  </div>-->

</div>
    <br/>
	<div class='weui-btn-area'>
        <!--<a href="javascript:;" class="weui-btn weui-btn_primary">直接登录</a>-->
		<a href="javascript:void(0);" id='submit' class="weui-btn weui-btn_primary">立即登录</a>
	</div>
	<div style="text-align:center;margin-top:20px;">
		<span>宁波优思网络技术有限公司</span>
	</div>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>


<link href="//cdn.bootcss.com/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>


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
var Taken = false;
$(function(){

	$("#submit").click(function(event) {		
		var account = $("#account").val();
		var verify = $("#code").val();
		var password = $("#password").val();
		var confirm = password;//$("#confirm").val();
 		var flag = false;
		var p =Object.create(check);
		flag = p.mail(account);		
		if(!flag) flag = p.phone(account);	
		if(!flag){
			$("#account").focus();
			toastr.warning("手机号码或邮箱地址错误!");  
			return false;
		}

		if(verify==''){
			$("#code").focus();			
			toastr.warning("请输入验证码!"); 
			return false;
		}

		if(password==''){
			$("#password").focus();			
			toastr.warning("请输入密码!"); 
			return false;
		}

		$.ajax({
            url: '/component/unitedsign',
			type: 'POST',
			dataType: 'json',
			data: {'account':account,'verify':verify,'password':password,'confirm':confirm},
		})
		.done(function(ret) {
			if(ret.status=='success'){
			  	<?php if(!empty($from) && $from=='auth' && !empty($salt)){
	          	?>window.location.href="/manage/index?from=auth&salt=<?php echo $salt;?>";
	          	<?php }else{ ?>
	              	window.location.href="/manage/index";
	          	<?php } ?>
			}else if(ret.status=='false'){
				toastr.warning(ret.message); 
			}
		});
		
	});

	$("#vcode").click(function(){
		var account = $("#account").val();
		var p =Object.create(check);
		var flag = false;
		flag = p.mail(account);
		if(!flag) flag = p.phone(account);

		if(!flag){
			toastr.warning("格式错误!");  
			$("#account").focus();
			return false;
		}
		if(!Taken){
			sms(account);
		}
	});

	
});

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


var TC = {
	EndTime:60,
	intvalue:0,
	controll:'vcode',
	cont:null,
	startShow:function(){		
		this.intvalue ++;
		document.getElementById(this.controll).innerHTML="&nbsp;" + ((this.EndTime-this.intvalue)%60).toString()+"秒";
		 if(this.intvalue>=this.EndTime){
          document.getElementById(this.controll).innerHTML="获取验证码";
          this.endShow();
        }
	},
	endShow:function(){
		window.clearTimeout(this.cont);
        this.intvalue=0;
        this.cont=null;
        Taken = false;
	},
	

}

var c =Object.create(TC);
function sms(account){

	if(c.cont==null){
		
		Taken = true;
		$.ajax({
			url: '/component/verifyCode/united',
			type: 'POST',
			dataType: 'json',
			data: {'account': account},
		})
		.done(function(ret) {
			if(ret.status=='success'){
				c.cont = window.setInterval("c.startShow()",1000);
				toastr.success("验证码发送完成,请查收!");      
			}else{
				toastr.warning(ret.message);  
			}
		});

	} 
}
</script>
</html>