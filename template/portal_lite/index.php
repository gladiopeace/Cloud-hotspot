<!DOCTYPE html>
<html class=" supports csstransforms csstransforms3d csstransitions preserve3d">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{copyright['title']}}</title>
    <script src="{{template}}templates/jquery-1.12.3.min.js"></script>
    <script src="{{template}}templates/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{template}}templates/modernizr.min.js"></script>
    <script src="{{template}}templates/jquery.easing.min.js"></script>
    <script src="{{template}}templates/fastclick.js"></script>
    <script src="{{template}}templates/polyfills.js"></script>
    <script src="{{template}}templates/_bootstrap.js"></script>
    <script src="{{template}}templates/_functions.js"></script>
    <script src="{{template}}templates/_config.js"></script>
    <script src="{{template}}templates/_content.js"></script>
    <script src="{{template}}templates/callInfo.js"></script>
    <script src="{{template}}templates/page-login.js"></script>
    <script src="{{template}}templates/script.js"></script>
    <script src="{{template}}templates/areaCode.js"></script>
    <script src="{{template}}templates/ideal_portal.js"></script>
    <link rel="stylesheet" href="{{template}}templates/jquery.mCustomScrollbar.min.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="{{template}}templates/style.css" type="text/css" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <style>
        #bg{
            background-image: url({{template}}images/fallback_login_desktop.jpg);
        }
        /*area code start*/
        #areacode {
            color: white;
            background: transparent;
            border: none;
            font-weight: 400;
            padding: 0 5px 0 12px;
            margin: 5px 0;
            font-size: 12px;
            height: 24px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: url({{template}}images/arrow.png) 1px 10px no-repeat;
            background-color: transparent;
            background-size: 10px;
        }
        #popup.hide{
            display:none;
        }
        #popup {
            font-size: 12px;
            color: #999;
            border: 1px #999;
            width: 126px;
            position: absolute;
            top: 39px;
            margin-left: 0;
            z-index: 10;
        }
        #popup ul{ margin:0; padding:0; width:55px; border:1px solid #c8c8c8; background:#FFF; overflow-y:scroll;
            overflow-x: hidden; max-height:65px;}
        #popup ul li{ line-height:30px; width:50px; text-indent:5px;}
        #popup ul li:hover{ background:#0168b7; color:#FFF}
        .captcha_pic{width:60px;height:20px;}
        /*area code end*/
    </style>

</head>

<body onload="bodyLoad()" class="pudong full-mode" id="zh">

<!-- / -->
<!-- / PAGE LOGIN A -->
<!-- / -->
<input type="hidden" id="branchSalt" value="{{branch['salt']}}">
<input type="hidden" id="deviceMac" value="{{config['mac']}}">
<div id="login" class="page active" style="background-color: transparent;">
    <div id="bg"></div>
    <div id="form-wrapper">
        <div class="error-handler">
            <span class="smiley"></span>
            <span class="error-displayer"></span>
        </div>
        <!-- / LOGIN A FORM 1 -->
        <div id="step-1" class="switchable-form">
            <div class="border-bottom float">
                <div class="popover code_tag" style="display: none;">
                    <div class="arrow"></div>
                    <div class="popover-content"><span class="m-wrapper" data-source="login.form_a.1.popover">国际及地区代码</span></div>
                </div>
                <!-- <span id="stopin">
                    <input name="areacode" id="areacode" autocomplete="off" type="text" data="國際區號" value="+ 86" style="width:36px;" maxlength="6" class="" onclick="findCode(this.value)" onkeyup="findCode(this.value);" data-cip-id="areacode">
                </span> -->
                <div id="popup" class="hide">
                    <ul id="colors_ul">   </ul>
                </div>
                <!--
                <select class="country-indicator">
                  <option>+ 86</option>
                  <option>+ 1</option>
                  <option>+ 33</option>
                  <option>+ 23</option>
                  <option>+ 20</option>
                </select>
                -->
                <!-- area code start -->
                <!-- <span id="stopin">
                    <input name="areacode" id="areacode"  autocomplete="off" type="text" data="國際區號"
                           value="+ 86" style="width:36px;" maxlength="6" class="" onclick="findCode(this.value)" onkeyup="findCode(this.value);" />
                </span>
                <div id="popup" class="hide">
                  <ul id="colors_ul">
                  </ul>
                </div> -->
                <!-- area code end -->
                <div class="vertical-separator"></div>
                <div class="login-input-wrapper">
                    <input class="phone" type="text" name="phone" data-cip-id="cIPJQ342845639">
                    <label class="placeholder"><span class="m-wrapper" data-source=" login.form_a.1.phone_placeholder ">请输入手机号码</span></label>
                </div>
            </div>
            <div class="button-wrapper float">
                <button class="anim white">
                    <span class="text"><span class="m-wrapper" data-source="login.form_a.1.button_1">获取验证码</span></span>
                    <span class="counter"><span class="m-wrapper" data-source="login.form_a.1.counter_1">60</span></span>
                    <div class="loader">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
                        </svg>
                    </div>
                </button>
            </div>
            <div class="clear"></div>
        </div>
        <div id="step-2" class="switchable-form">
            <div id="input-wrapper" class="login-input-wrapper float">
                <input class="code" type="text" name="code">
                <label class="placeholder"><span class="m-wrapper" data-source="login.form_a.1.code_placeholder">请输入验证码</span></label>
            </div>
            <div class="button-wrapper float">
                <button class="anim white disabled">
                    <span class="text"><span class="m-wrapper" data-source="login.form_a.1.button_2">登录</span></span>
                    <div class="loader">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
                        </svg>
                    </div>
                </button>
            </div>
            <div class="clear"></div>
            <div class="conditions-wrapper">
                <input class="conditions" type="checkbox" name="conditions" checked="">
                <label class="overlay-btn wifi"><span class="m-wrapper" data-source="login.form_a.1.conditions">我已阅读并接受上网协议</span></label>
                <span class="form-switcher"><span class="m-wrapper" data-source="login.form_a.1.form_switcher">其它登录方式</span></span>
            </div>
        </div>
        <!-- /LOGIN A FORM 2 -->
        <div id="step-3" class="switchable-form hidden">
            <h3 class="overlay-btn map">
                <span class="m-wrapper" data-source="login.form_a.2.title">登录帐户</span>

            </h3>
            <div id="input-wrapper" class="login-input-wrapper float">
                <input class="name" type="text" name="name">
                <label class="placeholder"><span class="m-wrapper" data-source="login.form_a.2.name_placeholder">帐号</span></label>
            </div>
            <div id="input-wrapper" class="login-input-wrapper float">
                <input class="code" type="text" name="code">
                <label class="placeholder"><span class="m-wrapper" data-source="login.form_a.2.code_placeholder">密码</span></label>
            </div>
            <div class="button-wrapper float">
                <button class="anim white">
                    <span class="text"><span class="m-wrapper" data-source="login.form_a.2.button_1">登录</span></span>
                    <div class="loader">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
                        </svg>
                    </div>
                </button>
            </div>
            <div class="clear"></div>
            <div class="conditions-wrapper">
                <label>
                    <input class="conditions" type="checkbox" name="conditions" checked="">
                </label>
                <label class="overlay-btn wifi"><span class="m-wrapper" data-source="login.form_a.2.conditions">我已阅读并接受上网协议</span></label>
                <span class="form-switcher"><span class="m-wrapper" data-source="login.form_a.2.switcher">手机号登录</span></span>
            </div>
        </div>
    </div>
    <div id="footer-links">
        <div class="footer-link link-1 float language-switcher"><span class="m-wrapper" data-source="login.form_a.2.lang_switcher">EN</span></div>
    </div>
    <div class="overlay">
        <div class="popup">
            <span class="close"></span>
            <div class="content"></div>
        </div>
    </div>
</div>

<!-- / -->
<!-- / PAGE LOGIN B -->
<!-- / -->
<div id="login-b" class="page">
    <div id="bg_b"></div>
    <div id="form-wrapper">
        <div class="error-handler">
            <span class="smiley"></span>
            <span class="error-displayer"></span>
        </div>
        <div id="connect-selector">
            <div id="mobile-selector" class="connect-selector selected">
                <span><span class="m-wrapper" data-source="login.form_b.1.tab_1">手机认证</span></span>
            </div>
            <div id="other-selector" class="connect-selector">
                <span><span class="m-wrapper" data-source="login.form_b.1.tab_2">取号机认证</span></span>
            </div>
        </div>
        <!-- / LOGIN B FORM 1 -->
        <div id="mobile-connect">
            <div id="step-1">
                <div class="border-bottom float">
                    <div class="popover code_tag" style="display: none;">
                        <div class="arrow"></div>
                        <div class="popover-content"><span class="m-wrapper" data-source="login.form_b.1.popover">国际及地区代码</span></div>
                    </div>
                    <!--
                    <select class="country-indicator">
                      <option>+ 86</option>
                      <option>+ 1</option>
                      <option>+ 33</option>
                      <option>+ 23</option>
                      <option>+ 20</option>
                    </select>
                    -->
                    <!-- area code start -->
                    <!-- <span id="stopin">
                        <input name="areacode" id="areacode"  autocomplete="off" type="text" data="國際區號"
                               value="+ 86" style="width:36px;" maxlength="6" class="" onclick="findCode(this.value)" onkeyup="findCode(this.value);" />
                    </span>
                    <div id="popup" class="hide">
                      <ul id="colors_ul">
                      </ul>
                    </div> -->
                    <!-- area code end -->
                    <div class="vertical-separator"></div>
                    <div class="login-input-wrapper">
                        <input class="phone" type="text" name="phone">
                        <!-- /%div.placeholder-content.hidden <span class='m-wrapper' data-source='login.form_b.1.phone_placeholder'></span> -->
                        <label class="placeholder"><span class="m-wrapper" data-source="login.form_b.1.phone_placeholder">请输入手机号码</span></label>
                    </div>
                </div>
                <div class="button-wrapper float">
                    <button class="anim green">
                        <span class="text"><span class="m-wrapper" data-source="login.form_b.1.button_1">获取验证码</span></span>
                        <span class="counter">60</span>
                        <div class="loader">
                            <svg class="circular" viewBox="25 25 50 50">
                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
            <div class="clear"></div>
            <div id="step-2">
                <div id="input-wrapper" class="login-input-wrapper float">
                    <input class="code" type="text" name="code">
                    <!-- /%div.placeholder-content.hidden <span class='m-wrapper' data-source='login.form_b.1.code_placeholder'></span> -->
                    <label class="placeholder"><span class="m-wrapper" data-source="login.form_b.1.code_placeholder">请输入验证码</span></label>
                </div>
                <div class="button-wrapper float">
                    <button class="anim white disabled">
                        <span class="text"><span class="m-wrapper" data-source="login.form_b.1.button_2">登录</span></span>
                        <div class="loader">
                            <svg class="circular" viewBox="25 25 50 50">
                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
                            </svg>
                        </div>
                    </button>
                </div>
                <div class="clear"></div>
                <div class="conditions-wrapper">
                    <label>
                        <input class="conditions" type="checkbox" name="conditions" checked="">
                    </label>
                    <a class="overlay-btn wifi"><span class="m-wrapper" data-source="login.form_b.1.conditions">我已阅读并接受上网协议</span></a>
                    <a class="language-switcher"><span class="m-wrapper" data-source="login.form_b.1.lang_switcher">EN</span></a>
                </div>
            </div>
        </div>
        <!-- / LOGIN B FORM 2 -->
        <div id="other-connect">
            <div id="step-1">
                <a class="overlay-btn map">
                    <span class="m-wrapper" data-source="login.form_b.2.title">登录帐户</span>
                </a>
            </div>
            <div class="clear"></div>
            <div id="step-other">
                <div id="input-wrapper" class="login-input-wrapper float align-3-element">
                    <input class="name" type="text" name="name">
                    <label class="placeholder"><span class="m-wrapper" data-source="login.form_b.2.name_placeholder">帐号</span></label>
                </div>
                <div id="input-wrapper" class="login-input-wrapper float">
                    <input class="code code-other" type="text" name="code">
                    <label class="placeholder"><span class="m-wrapper" data-source="login.form_b.2.code_placeholder">密码</span></label>
                </div>
                <div class="button-wrapper float">
                    <button class="anim green disabled">
                        <span class="text"><span class="m-wrapper" data-source="login.form_b.2.button_1">提交</span></span>
                        <div class="loader">
                            <svg class="circular" viewBox="25 25 50 50">
                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
                            </svg>
                        </div>
                    </button>
                </div>
                <div class="clear"></div>
                <div class="conditions-wrapper">
                    <label>
                        <input class="conditions" type="checkbox" name="conditions" checked="">
                    </label>
                    <a class="overlay-btn wifi"><span class="m-wrapper" data-source="login.form_b.2.conditions">我已阅读并接受上网协议</span></a>
                    <a class="language-switcher" href=""><span class="m-wrapper" data-source="login.form_b.2.lang_switcher">EN</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay">
        <div class="popup">
            <span class="close"></span>
            <div class="content"></div>
        </div>
    </div>
</div>
<style>
    #bg_b{
        background-size: cover;
        position: absolute;
        top: 0px;
        width: 100%;
        height: 100%;
        background-position: top;
    }
</style>
</body>
</html>