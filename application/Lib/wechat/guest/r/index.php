<?php
    session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="telephone=no" name="format-detection" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png"/>
	<title>登记页面</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
		
	<link href="css/reset.css" rel="stylesheet" type="text/css" />
	<link href="css/head.css" rel="stylesheet" type="text/css" />
	<link href="css/foot.css" rel="stylesheet" type="text/css" />
	<link rel='stylesheet' type='text/css' href='css/signup.css' />	
	<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.autocomplete.js" type="text/javascript"></script>
	<script src="js/jquery.touchScroll.js" type="text/javascript"></script>		
		

</head>
<body> 
	<div class="header" id="header">
		<a class="back" href="javascript:history.back();"></a>
		<span class="headline">用户登记</span>
		
	</div>
	<section class="signup">
<!--<div class='bread_new'>用户名注册</div> -->
	<div class="form">
		<form method="post" action="" onsubmit="return false;">
		<ul>
			<li>
			<input class='tipInput' id="user" tiptext='用户名/手机号' type="text" placeholder="" value="" name="user_name">	
			</li>
		<!--	<li>
			<input class='password' tar='password' type="text" value="密码">
			<input id='password' type="password" value="" name="password" style='display: none'>
			</li>
			<li>
			<input class='password' tar='password2' type="text" value="再次输入密码">
			<input id='password2' type="password" value="" name="password2" style='display: none'>
			</li>-->
			<li><input id='applybtn' type="submit" class="btn" onclick="apply()" value="登记" /></li>
			<li ><div id="apple_load"  style="display:none;" align="center"><img src="images/loading.gif"></div></li>
		</ul>
		</form>	
	</div>
	

<script type='text/javascript'>
	
	
	$(function(){
		
		//$("#user").onlyNumAlpha();		
			
	});

	
	function is_mobile() {
        var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
        var u = navigator.userAgent;
        if (null == u) {
            return true;
        }
        var result = regex_match.exec(u);
        if (null == result) {
            return false
        } else {
            return true
        }
     }
	
	function apply(){
        $("#applybtn").text("登记......");
		$("#applybtn").hide();
		$("#apple_load").show();
		//e.preventDefault();
		var user_name=$("input[name=user_name]").val();
		// var pw1=$("input[name=password]").val();
		// var pw2=$("input[name=password2]").val();
		if(user_name == $("input[name=user_name]").attr('tiptext') || user_name==''){
			alert("用户名/手机号不能为空");
			return false;
		}
		// if(pw1 == $("input[name=password]").attr('tiptext') || pw1==''){
			// alert("密码不能为空");
			// return false;
		// }
		// if(pw2 == $("input[name=password2]").attr('tiptext') || pw2==''){
			// alert("再次输入密码");
			// return false;
		// }
		// if(pw1!=pw2){
			// alert("两次密码输入不一致");
			// return false;
		// }
				
        $.post('get.php?u='+$("#user").val(), {}, function(data){
            if(data.success){
                $("#applybtn").attr('disabled', 'disabled');
				$("#applybtn").text("请稍后(正在生成二维码)...");
				
				//手机可能会有两条登录日志
				$.post('/guest/getMinute.php?macid='+ "<?php echo $_SESSION['macid'] ?>", {}, function(data){
					if(data.success){

						$("#applybtn").attr('disabled', 'disabled');
						//判断是PC还是手机 然后
						 if (is_mobile()) {
							 window.location.href = "/guest/s/default/index.php?id=<?php echo $_SESSION['macid'] ?>";
							 //$("#applybtn").text("正在启动微信...").attr('disabled', 'disabled');
							 //setTimeout("callWechatBrowser()", 2000);
						 }
						 else{
							window.location.href = "/guest/s/default/qr.php";
						  }
						
					}else{
							
					 }
				}, 'json');
				
								
				//document.location.href = "http://www.baidu.com";	
				
				
				//=================================
				//echo json_encode(array('success' => true));
				// 加入扫描三维验证模块
               // setInterval("fresh()", 1000);
            }else{
				$("#applybtn").attr('disabled', 'disabled');
				$("#applybtn").text("NO");		
			  }

        }, 'json');
    }

$.fn.onlyNumAlpha = function () {
    $(this).keypress(function (event) {
        var eventObj = event || e;
        var keyCode = eventObj.keyCode || eventObj.which;
        if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122))
            return true;
        else
            return false;
    }).focus(function () {
        this.style.imeMode = 'disabled';
    }).bind("paste", function () {
        var clipboard = window.clipboardData.getData("Text");
        if (/^(\d|[a-zA-Z])+$/.test(clipboard))
            return true;
        else
            return false;
    });
};	


</script>
</section>
<!--页面底部-->


<script type="text/javascript">
_ozuid="";//请客户配合为参数赋值
</script>
<script src="js/m_code.js" type="text/javascript"></script>
<SCRIPT type="text/javascript">
$("#btn-top").click(function(){

	document.getElementsByTagName('body')[0].scrollTop = 0;
});
function set_view(id){
	var url = "signup";
	window.location.href="t/"+id+"/?url="+url;
}
	</SCRIPT>


	<script type="text/javascript">
		var global_loading=document.getElementById("global_loading");
		if(global_loading != null){
			global_loading.parentNode.removeChild(global_loading);
		}
</script>
</body>
</html>

