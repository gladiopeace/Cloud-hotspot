<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <meta http-equiv="Expires" content="Sun Apr 22 2018 13:31:43 GMT">
  <meta name="viewport" content="width=320,user-scalable=0">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>无线上网服务</title>
  <link rel="stylesheet" href="{{template}}static/base.css">
  <script language="javascript">
    var remp=/^(00[1-9]\d{8,21}|17[0-9]\d{8}|13[0-9]\d{8}|14[0-9]\d{8}|15[0-9]\d{8}|18[0-9]\d{8})$/;
    var rekc=/^[a-z0-9A-Z]{5,10}$/;
    var intvid=0;
    var iv=0,isec=0;
    var color="RoyalBlue";
    function checkMobile(){
      var m=document.getElementById('Mobile');            
      if(m.value.match(remp)==null){
        m.focus();
        alert("请正确填写手机号，正确格式为：\n中国国内手机：例如中国移动手机号码 13900000000。");
        return false;
      }

      isec = 10;
      __S();
      Message(m.value)
      return false;
    }

    function Message(cellphone){
        var data = {        
          cellphone: cellphone,
          accesskey:"{{config['salt']}}",
          mac:"{{config['mac']}}",
          type: "sms"
        };

        $.ajax({
            url:  "/portal/auth/fetch-code-cellphone",
            type: 'POST',
            dataType: 'json',
            data:data,
        })
        .done(function(info) {
            console.log(info);
            if(info.status!='success'){
              alert(info.message);
            }
        });
    }


    function Login(){
        var m=document.getElementById('Mobile'); 
        var k=document.getElementById('K');       
        var verifyData = {
          cellphone :m.value,
          password:k.value,
          accesskey:"{{config['salt']}}",
          mac:"{{config['mac']}}",         
        };

        $.ajax({
            url:  "/portal/auth/verify-code-cellphone",
            type: 'POST',
            dataType: 'json',
            data:verifyData,
        })
        .done(function(info) {
            console.log(info);
            if(info.status=='success'){
              console.log(info);
              if(info.status=='success'){
                  document.start.auth_code.value = info.access_code;
                  verify(info);
              }

            }else{
              alert('手机号码或验证码错误!');
            }
        });   

    }

    function verify(ret){

        $.ajax({
            url: '/portal/verify/wechat-auth',
            type: 'POST',
            dataType: 'json',
            data: {'accesskey':"{{config['salt']}}",'mac':"{{config['mac']}}",'auth_code':ret.access_code}
        })
        .done(function(ret) {
            console.log(ret);
            if(ret.status=='success'){
                document.start.action=ret.ip; //'http://'+ret.ip+'/login';
                document.start.submit();//=ret.ip;
            }
        });

    }


    function checkKcode(){
    
      var k=document.getElementById('K');
      if(k.value.match(rekc)==null){
        k.focus();return false;
      }
      Login();
      return false;
    }

    function __F(){intvid=setInterval("var t=tdt;if(t.style.color=='orange')t.style.color='#666';else t.style.color='ORANGE';iv++;if(iv>5)clearInterval(intvid);",500);}
    function __S(){
      isec--;
      var _b = document.forms['FormA'].SMSBUTTON;
      _b.disabled=1;
      var template = '请等待${Sec}秒后重发';
      var key = '${Sec}';
      _b.value = template.replace(key,isec);
      if(isec > 0){
        setTimeout(__S,1000);
      }
      else{
        _b.disabled=0;
        _b.value='获得短信验证码';
      }
    }
    var SERVER = '';
    function C(_0){var _1=document.getElementById("isok");if(_1.checked){_0.style.color="white";_0.style.backgroundColor="#555";_0.style.backgroundImage="url("+SERVER+"{{template}}static/noselect.svg)";_1.checked=0}else{_0.style.color="#333";_0.style.backgroundColor="#fff";_0.style.backgroundImage="url("+SERVER+"{{template}}static/ok.svg)";_1.checked=1}}function D(_0){if(!window.IS_CONF){J("/p.conf",function(c){eT.innerHTML=c;IS_CONF=1})}var t=EXA_T;if(t.style.display=="none"||t.style.display==""){t.style.display="block";_0.style.color="#555";_0.style.backgroundColor="#fff";_0.style.backgroundImage="url("+SERVER+"{{template}}static/search.svg)"}else{t.style.display="none";_0.style.color="#fff";_0.style.backgroundColor="#555";_0.style.backgroundImage="url("+SERVER+"{{template}}static/searchw.svg)"}event.cancelBubble=true}function T_X(){EXA_T.style.display="none";var b=TNCBUTTON;b.style.backgroundColor="#555";b.style.color="#fff";b.style.backgroundImage="url("+SERVER+"{{template}}static/searchw.svg)"}function T_O(){EXA_T.style.display="none";var c=CHKBOX;c.style.color="#666";c.style.backgroundImage="url("+SERVER+"{{template}}static/ok.svg)";c.style.backgroundColor="#fff";isok.checked=1;var b=TNCBUTTON;b.style.backgroundColor="#555";b.style.color="#fff";b.style.backgroundImage="url("+SERVER+"{{template}}static/searchw.svg)"}function J(src,fn){var script=document.createElement("script");script.type="text/javascript";if(typeof fn=="function"){var name="fn_"+new Date().getTime();window[name]=fn;src=/\?/.test(src)?src+"&jsonp="+name:src+"?jsonp="+name;script.src=src;script.onload=function(){setTimeout(function(){window[name]=null},3000)}}document.head.appendChild(script)};
  </script>
</head>
<body>
<table align="CENTER" style="WIDTH:100%;height:100%;position:relative;">
  <tbody>
  <tr><td class="SECTION TOP"><img src="{{template}}static/logo100000135.png" class="LOGO"></td></tr>  <tr>
    <td class="SECTION SLIDE">
      <img src="{{template}}static/life_2100000135.jpg" style="width:100%;">      <div id="EXA_M">
        <table style="width:100%"><tbody>
          <tr>
            <td align="center" class="SECTION">
              <div style="color:#555;"><b style="FONT-SIZE:13px">享受您的免费无线上网服务！</b></div>
            </td>
          </tr>
          				<tr>
					<td valign="top" class="SECTION" align="center">
					<table class="EXA_P">
						<tbody><tr>
							<td style="HEIGHT:45PX;COLOR:#666;FONT-SIZE:12px;line-height: 1.5em;" align="center">
								<div>填写手机号码，专属的无线上网密码免费发送到手机，建议填写中国移动、中国电信及中国联通的手机号码</div>
							</td>
						</tr>
						<tr>
						<td valign="TOP" style="HEIGHT:35px;PADDING-BOTTOM:10px;" nowrap="" align="center" c="">
							<form method="POST" action="http://172.16.200.5:38000/ck/" id="FormA" name="FormA" style="margin:0px" autocomplete="ON" onsubmit="return checkMobile();">
								<input type="HIDDEN" name="GXP" value="aiahubm02lcd5on243bcsk15j3">
								<input id="Mobile" class="BOX INPUTBOX" maxlength="21" name="Mobile" style="BACKGROUND-IMAGE:url({{template}}static/phone.svg);width:120px;border-bottom-right-radius:0px;border-top-right-radius:0px;margin-right:0px;" type="tel" value="" placeholder="填写手机号码"><input type="SUBMIT" class="BOX SUBMIT" id="SMSBUTTON" style="margin-left:0px;BACKGROUND-COLOR:#333;MARGIN-TOP:5px;WIDTH:120px;border-bottom-left-radius:0px;border-top-left-radius:0px;" value="获得短信验证码">
							</form>
						</td>
					</tr>
						</tbody></table>
						</td>
				</tr>          <tr>
            <td valign="top" class="SECTION" align="center" style="border-top:0.5px solid #ddd">
              <table class="EXA_P">
                <tbody><tr>
                  <td style="padding-top:5px;padding-bottom:10px;COLOR:#555;;line-height: 1.5em;" id="tdt" align="center">
                    <b>使用者若要使用密码并登录无线网络，</b><br>我们将认为使用者已阅读并接受以下所有条款：                  </td>
                </tr>
                <tr>
                  <td style="HEIGHT:50px" align="center">
                    <form id="FormB" name="FormB" onsubmit="return(document.getElementById(&#39;isok&#39;).checked&amp;&amp;checkKcode());" autocomplete="OFF">
                      <div id="CHKBOX" class="BOX BUTTON" style="display:inline-block;background-image: url({{template}}static/ok.svg);background-color:white;width:268px;margin-bottom:15px;" onclick="C(this)">
                        <input type="checkbox" value="1" id="isok" name="isok" checked="" style="display:none"><span style="vertical-align:top">我已阅读并同意此</span><div class="BOX BUTTON" onclick="D(this)" style="vertical-align:top;margin:0px;float:right;box-shadow:none;display:inline-block;background-image: url({{template}}static/searchw.svg);width: 143px;background-color:#555;color:white;OPACITY:1" id="TNCBUTTON">上网服务条款和条件</div></div>
                      <input type="HIDDEN" name="GXP" value="aiahubm02lcd5on243bcsk15j3">
                      <input type="HIDDEN" name="AN" value="">
                      <input id="K" class="BOX INPUTBOX" maxlength="6" name="K" style="margin-bottom: 10px;background-image:url({{template}}static/message.svg);width:120px;border-bottom-right-radius:0px;border-top-right-radius:0px;margin-right:0px;" type="tel" value="" placeholder="6位短信验证码"><input type="submit" class="BOX SUBMIT" value="点击连接上网" style="margin-left:0px;background-color: #333;margin-bottom:15px;min-width: 120px;border-bottom-left-radius:0px;border-top-left-radius:0px;;">
                    </form>
                  </td>
                </tr>
              </tbody></table>
            </td>
          </tr>
          
          </tbody>
        </table>
      </div>
      <div id="EXA_T">
        <div class="TNC">
          <div class="TNCB TNCB1" onclick="T_X()">点击此处隐藏</div>
          <div class="TNCC" id="eT"><p align="center" style="padding:0 15px;">Loading...</p></div>
          <div class="TNCB TNCB2" onclick="T_O()">我已阅读并同意此上网服务条款和条件</div>
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <td style="height: 100%;vertical-align:bottom;padding:15px;" align="CENTER">
      <svg width="66px" height="23px" style="opacity:0.7">
        <image xlink:href="{{template}}static/pb.svg" src="{{template}}static/pb.png" width="66px" height="23px"></image>
      </svg>
    </td>
  </tr>
  </tbody>
</table>

<div style="display: none">
    <form action="" name="start" method="get">
        <input type="hidden" name="auth_code">
        <input type="hidden" name="salt" value="{{config['salt']}}">
        <input type="submit">
    </form>
</div>
<script type="text/javascript" src="{{template}}static/jquery.min.js"></script>
</body>
</html>