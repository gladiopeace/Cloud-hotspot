
//PORTAL PAGE
//progress bar animation
App.pagesScripts.login = function() {
    setTimeout(function(){
        $(".popover").fadeIn( 1000 );
        setTimeout(function(){
            $(".popover").fadeOut( 1000 );
        },App.vars.countryCodeDisplayTimeStartup);
    },1000);
}

App.pagesScripts["login-b"] = function() {

}

/**************/
/*
/* GENERAL : ERROR HANDLER
/*
*/

function displayError(msg){
    console.log("displayError");
    $('.error-displayer').text(msg);
    $('.error-handler').css('display', 'inline-flex');
    clearTimeout(App.vars.errorSetTimeout);
    App.vars.errorSetTimeout = setTimeout(function(){
            hideError();
     },App.vars.errorDisplayTime);
}
function hideError(){
    clearTimeout(App.vars.errorSetTimeout);
    $('.error-displayer').text('');
    $('.error-handler').css('display', 'none');
}

/**************/
/*
/* GENERAL : POPUP HANDLER
/*
*/

$(document).on("click","span.close", function() {
    $(".overlay").css("display", "none");
});
$(document).on("click",".overlay-btn.wifi", function() {
    $("div.content").html(App.content[App.vars.language].popup.wifi);
    $('.popup').removeClass('map-wrapper hotline-wrapper').addClass('wifi-wrapper');
    $(".overlay").show();
});
$(document).on("click",".overlay-btn.hotline", function() {
    $("div.content").html(App.content[App.vars.language].popup.hotline);
    $('.popup').removeClass('wifi-wrapper map-wrapper').addClass('hotline-wrapper');
    $(".overlay").show();
});
$(document).on("click",".overlay-btn.map", function() {
    $("div.content").html(App.content[App.vars.language].popup.map);
    $('.popup').removeClass('wifi-wrapper hotline-wrapper').addClass('map-wrapper');
    $(".overlay").show();
});



/**************/

var PageLogin = function(){
    /**
     * 国家区号
     * @type {string}
     */
    this.countryNum = "+ 86";
    /**
     * 用户手机号
     * @type {string}
     */
    this.userPhone = "";
    /**
     * 用户验证码
     * @type {string}
     */
    this.userCode = "";
    /**
     * 接口路径
     * @type {{}}
     */
    this.URL = {};
    /**
     * 获取验证码接口
     * @type {string}
     */
    this.URL.getCode = "/portal/auth/fetch-code-cellphone";
    /**
     * 登录接口
     * @type {string}
     */
    this.URL.signin = "/portal/auth/verify-code-cellphone";
    /**
     * 账号登录接口
     * @type {string}
     */
    this.URL.account = "/portal/auth/fetch-member-account";
};

$PL = new PageLogin();


/*
/* GENERAL : FORM VALIDATION AND LOGIC
/*
*/

//LOGIN PAGE WHEN button clicked
$(document).on("click","#step-1 button:not(.loading)",function(){
    //hideError();
    // we check if a number has been entered
    //if($("#login .phone").val().length != 0 ){
    //    console.log("trigger button 1");
    //    //if yes trigger the loading state for button 1
    //    App.functions.button.loadingState($("#step-1 button"),60);
    //    App.functions.button.normalState($("#step-2 button"));
    //}else{
    //    //else alert
    //    msg = App.content[App.vars.language].login.error.phone;
    //    $('.border-bottom').addClass('error');
    //    displayError(msg);
    //}
    //if yes trigger the loading state for button 1
    // App.functions.button.loadingState($("#step-1 button"),60);
    // App.functions.button.normalState($("#step-2 button"));
    hideError();
    var phoneADom = $("#login .phone");
    var phoneBDom = $("#login-b .phone");

    var salt = $("#branchSalt");   //节点salt
    var mac = $("#deviceMac");   //mac地址

    $PL.countryNum = $("#areacode").val();
    if(phoneADom.val().length != 0){
        $PL.userPhone = phoneADom.val();
    }
    if( phoneBDom.val().length != 0){
       $PL.userPhone = phoneBDom.val();
    }

    if( !phoneADom.val() && !phoneBDom.val() ){
        $PL.userPhone = "";
    }

    if( !$PL.userPhone ){
        var msg = App.content[App.vars.language].login.error.phone;
        var borderBottomDom = $('.border-bottom');
        borderBottomDom.addClass('error');
        displayError(msg);
        return;
    }
    // console.log($PL.countryNum);
    if( !$PL.countryNum ) {
        var msg = App.content[App.vars.language].login.error.areacode;
        var borderBottomDom = $('.border-bottom');
        borderBottomDom.addClass('error');
        displayError(msg);
        return;
    }
    var $button = $("#step-1 button");
    var timmer = 60;
    //App.functions.button.loadingStateForCode($button, timmer);
    var data = {
        areacode: $PL.countryNum.replace(" ","").replace("+","").replace(/^86/, ''),
        cellphone: $PL.userPhone,
        accesskey:salt.val(),
        mac:mac.val(),
        type: "sms"
    };

    console.log(data);
    var callInfo = new CallInfo($PL.URL.getCode,data);
    callInfo.setData(function(json){
        console.log(JSON.stringify(json));

        if( json.code==1 && json.status=='success') {
            App.functions.button.loadingStateForCode($button, timmer);
            console.log("trigger button 1");
            //if yes trigger the loading state for button 1
            // App.functions.button.loadingState($("#step-1 button"),60);
            // App.functions.button.normalState($("#step-2 button"));
        }

        if(json.code==-8) {
            var msg = App.content[App.vars.language].login.error.smsIsp;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');
            displayError(msg);
        }
        if(json.code==-5){
            var msg = App.content[App.vars.language].login.error.phone;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');
            displayError(msg);
        }
    });
});


//if we change the conditions checkbox state
$(document).on("change",".conditions",function(){
    if($(this).is(':checked')){
        $('.border-bottom').removeClass('error');
        hideError();
    }else{
        msg = App.content[App.vars.language].login.error.conditions;
        $('.border-bottom').addClass('error');
        displayError(msg);
    }
});


$(document).on("click","#step-2 button:not(.loading)",function(){
    var phoneADom = $("#login .phone");
    var phoneBDom = $("#login-b .phone");
    var codeADom = $("#login .code");
    var codeBDom = $("#login-b .code");
    var conditionsADom = $("#login #step-2 .conditions");   //协议
    var conditionsBDom = $("#login-b .conditions");         //协议
    var salt = $("#branchSalt");   //节点salt
    var mac = $("#deviceMac");   //mac地址

    var conditionsDom = null;

    if(phoneADom.val().length != 0){
        $PL.userPhone = phoneADom.val();
        $PL.userCode = codeADom.val();
        conditionsDom = conditionsADom;
    }
    if( phoneBDom.val().length != 0){
       $PL.userPhone = phoneBDom.val();
       $PL.userCode = codeBDom.val();
       conditionsDom = conditionsBDom;
    }

    if( !phoneADom.val() && !phoneBDom.val() ){
        $PL.userPhone = "";
    }

    // console.log($PL.userPhone+"  "+$PL.userCode);
    $PL.countryNum = $("#areacode").val();
    if( !$PL.countryNum ) {
        var msg = App.content[App.vars.language].login.error.areacode;
        var borderBottomDom = $('.border-bottom');
        borderBottomDom.addClass('error');
        displayError(msg);
        return;
    } else {
        $PL.countryNum = $PL.countryNum.replace(" ","").replace("+","").replace(/^86/, '')
    }

    if( $PL.userPhone.length > 0 && $PL.userCode.length > 0 && conditionsDom.is(':checked') ){
        App.functions.button.disabledState($("#step-1 button"));
        App.functions.button.loadingState($("#step-2 button"));
        setTimeout(function(){
            $("body").css("backgroundImage"," url('images/portal-bg.jpg')");
            setTimeout(function(){
                App.functions.button.normalState($("#step-2 button"));
            },1000);
        },App.vars.loadingTimeButton);
        var data = {
            cellphone : $PL.countryNum+""+$PL.userPhone,
            password : $PL.userCode,
            accesskey:salt.val(),
            mac:mac.val()
        };
        //console.log(data);
        var callInfo = new CallInfo($PL.URL.signin,data);
        callInfo.setData(function(json){

            console.log(json);
            if(json.status=='success' && json.code==1){
                var verifyData = {
                    cellphone :$PL.userPhone,
                    code : $PL.userCode,
                    accesskey:salt.val(),
                    mac:mac.val(),
                    auth_code:json.access_code
                };

                console.log(verifyData);
                var callVerify = new CallInfo('/portal/verify/cellphone-code',verifyData);
                callVerify.setData(function(ret){
                    if(ret.code=='-1'){
                        var msg = App.content[App.vars.language].login.error.back;
                        var borderBottomDom = $('.border-bottom');
                        borderBottomDom.addClass('error');
                        displayError(msg);
                    }
                    if(ret.code=='1'){
                       
                        var form = $('<form class="hide" action="'+ret.ip+'" method="get">\
                        <input type="hidden" name="auth_code" value="'+json.access_code+'"/>\
                        <input type="hidden" name="accesskey" value="'+ verifyData.accesskey +'" />\
                        </form>');
                        console.log(form);
                        form.appendTo("body").submit();
                    }
                });

            }else if(json.status=='notice'){

                if(json.code=='-1'){
                    var msg = App.content[App.vars.language].login.error.back;
                    var borderBottomDom = $('.border-bottom');
                    borderBottomDom.addClass('error');
                    displayError(msg);
                }
                if(json.code=='-4'){
                    var msg = App.content[App.vars.language].login.error.phone;
                    var borderBottomDom = $('.border-bottom');
                    borderBottomDom.addClass('error');displayError(msg);
                }

                if(json.code=='-5'){
                    var msg = App.content[App.vars.language].login.error.phone;
                    var borderBottomDom = $('.border-bottom');
                    borderBottomDom.addClass('error');displayError(msg);
                }

            }
            /*if( !(json < 0) ) {
                var username = data.user;
                var password = json;
                window.location.href="/portal/component/wechat_init.html"+params;//
               *//*var form = $('<form class="hide" action="http://securelogin.arubanetworks.com/auth/loginnw.html" method="post">\
                         <input type="hidden" name="password" value="'+ password +'" />\
                         <input type="hidden" name="username" value="'+ username +'" />\
                         <input type="hidden" name="buttonClicked" value="0"/>\
                         <input type="hidden" name="redirect_url"/>\
                         <input type="hidden" name="err_flag" value="0"/>\
                         </form>');
                form.appendTo("body").submit();

                *//*
            }*/
           /* if( json == -1 ){//Account Or Password is wrong!;
                var msg = App.content[App.vars.language].login.error.back;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');
                displayError(msg);
            }
            if( json == -4 ){//Please Check The Account

            }
            if( json == -5 ){ // Please Check The Verify-code
                var msg = App.content[App.vars.language].login.error.pass;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }*/
        });
    }else{
        // msg = App.content[App.vars.language].login.error.full;
        // $('.border-bottom').addClass('error');
        // displayError(msg);
        if( !($PL.userPhone.length > 0) ){
            var msg = App.content[App.vars.language].login.error.phone;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');displayError(msg);
            return;
        }
        if( !($PL.userCode.length > 0) ){
            var msg = App.content[App.vars.language].login.error.pass;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');displayError(msg);
            return;
        }
    }
});

/**************/
/*
/* GENERAL : OTHER
/*
*/

//language switcher
$(document).on("click",".language-switcher",function(e){
    e.stopPropagation();
    if(App.vars.language == "zh") {
        App.functions.content.load("en");
    }else{
        App.functions.content.load("zh");
    }
});


$(document).on("keyup",'.login-input-wrapper input',function(){
    if($(this).val().length > 0) {
        $(this).addClass("filled");
        $('.border-bottom').removeClass('error');
    }else{
        $(this).removeClass("filled");
    }
});

$(document).on("focus",".phone",function(){
    App.functions.log("inputs","focus!");
});
$(document).on("blur",".phone",function(){
    App.functions.log("inputs","blur!");
});

$(document).on("focus","#login-b .phone",function(){
    $(".popover").css('display', 'block').fadeIn( 1000 );
});

$(document).on("blur","#login-b .phone",function(){
    $(".popover").css('display', 'none').fadeOut( 1000 );
});

/**************/
/*
/* VERSION A
/*
*/

$(document).on("click",".form-switcher",function(){
    $(".switchable-form").each(function(){
        console.log("1")
        if($(this).hasClass("hidden")){
            $(this).removeClass("hidden");
        }else {
            $(this).addClass("hidden");
        }
    })
});

$(document).on("click","#step-3 button:not(.loading)",function(){
    var phoneADom = $("#step-3 .name");     //取号机账号
    var codeADom = $("#step-3 .code");      //取号机密码step-other
    var conditionsADom = $("#step-3 .conditions");   //协议
    var salt = $("#branchSalt");   //节点salt
    var mac = $("#deviceMac");   //mac地址
    //$PL.deviceMac = $("#deviceMac").val();
    if( phoneADom.val().length > 0 && codeADom.val().length > 0 && conditionsADom.is(':checked') ) {
        var data = {
            username : phoneADom.val(),
            password : codeADom.val(),
            accesskey : salt.val(),
            mac : mac.val()
        };
        console.log(data);
        var callInfo = new CallInfo($PL.URL.account,data);
        callInfo.setData(function(json){
             console.log(JSON.stringify(json));
            if( !(json.code < 0) && json.status=='success' && json.code==1) {

                var verifyData = {
                    username : phoneADom.val(),
                    password : codeADom.val(),
                    accesskey : salt.val(),
                    mac : mac.val(),
                    auth_code:json.access_code
                };

                console.log(verifyData);
                var callVerify = new CallInfo('/portal/verify/member-auth',verifyData);
                callVerify.setData(function(ret){
                    if(ret.code=='-1'){
                        var msg = App.content[App.vars.language].login.error.back;
                        var borderBottomDom = $('.border-bottom');
                        borderBottomDom.addClass('error');
                        displayError(msg);
                    }
                    if(ret.code=='1'){
                        var form = $('<form class="hide" action="'+ret.ip+'" method="get">\
                        <input type="hidden" name="auth_code" value="'+json.access_code+'"/>\
                        <input type="hidden" name="accesskey" value="'+ verifyData.accesskey +'" />\
                        </form>');
                                           
                        form.appendTo("body").submit();
                    }
                });


            }
            if( json.code == -1 ){
                var msg = App.content[App.vars.language].login.error.back;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }
            if( json.code == -4 ){
                var msg = App.content[App.vars.language].login.error.phone;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }
            if( json.code == -5 ){
                var msg = App.content[App.vars.language].login.error.pass;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }
            if( json.code == -6 ){
                var msg = App.content[App.vars.language].login.error.expire;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }
        });
    }else{
        // msg = App.content[App.vars.language].login.error.full;
        // $('.border-bottom').addClass('error');
        // displayError(msg);
        if( !(phoneADom.val().length > 0) ){
            var msg = App.content[App.vars.language].login.error.phone;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');displayError(msg);
            return;
        }
        if( !(codeADom.val().length > 0) ){
            var msg = App.content[App.vars.language].login.error.pass;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');displayError(msg);
            return;
        }
    }
});

/**************/
/*
/* VERSION B
/*
*/

$(document).on("click","#step-other button:not(.loading)",function(){
    hideError();
    // if($("#login-b .name").val().length > 0 && $("#login-b .code-other").val().length > 0){
    //     App.functions.button.disabledState($("#step-1 button"));
    //     App.functions.button.disabledState($("#step-2 button"));
    //     App.functions.button.loadingState($("#step-other button"));
    //     setTimeout(function(){
    //         /*
    //         rippleEffect($("#step-2 button"));
    //         setTimeout(function(){
    //             window.location.hash = "home";
    //         },1000);
    //         */
    //         //$("body").css("backgroundImage"," url('images/portal-bg.jpg')");
    //         window.location.hash = "postroll";
    //         setTimeout(function(){
    //             App.functions.button.normalState($("#step-2 button"));
    //             $("#step-2 button").addClass("green");
    //         },1000);
    //     },App.vars.loadingTimeButton);
    // }else{
    //     console.log($(".name").parent());
    //     if (!$(".name").val() &&  $(".name").val().length <= 0)
    //         $(".name").parent().addClass('error')
    //     if (!$(".code-other").val() &&  $(".code-other").val().length <= 0)
    //         $(".code-other").parent().addClass('error')
    //     msg = "please fill a name and a code";
    //     displayError(msg);
    //     // alert(msg);
    // }
    var phoneBDom = $("#step-other .name");     //取号机账号
    var codeBDom = $("#step-other .code");      //取号机密码
    var conditionsBDom = $("#step-other .conditions");         //协议
    var salt = $("#branchSalt");   //协议
    var mac = $("#deviceMac");   //协议
    if( phoneBDom.val().length > 0 && codeBDom.val().length > 0 && conditionsBDom.is(':checked') ) {
        App.functions.button.loadingState($("#step-other button"));
        var data = {
            username : phoneBDom.val(),
            password : codeBDom.val(),
            accesskey:salt.val(),
            mac:mac.val()
        };
        console.log(data);
        var callInfo = new CallInfo($PL.URL.signin,data);
        callInfo.setData(function(json){
            console.log(JSON.stringify(json));
            if( !(json.code < 0) ) {
                // App.functions.button.loadingState($("#step-3 button"));
                // setTimeout(function(){
                //     window.location.href = App.vars.leavingPageUrl;
                // },App.vars.loadingTimeButton);
              /*  var username = data.user;
                var password = json;
                var form = $('<form class="hide" action="http://securelogin.arubanetworks.com/auth/loginnw.html" method="post">\
                         <input type="hidden" name="password" value="'+ password +'" />\
                         <input type="hidden" name="username" value="'+ username +'" />\
                         <input type="hidden" name="buttonClicked" value="0"/>\
                         <input type="hidden" name="redirect_url"/>\
                         <input type="hidden" name="err_flag" value="0"/>\
                         </form>');
                form.appendTo("body").submit();*/
                //window.location.href="/portal/component/wechat_init.html"+params;//

            }
            if( json.code == -1 ){
                var msg = App.content[App.vars.language].login.error.back;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }
            if( json.code == -4 ){
                var msg = App.content[App.vars.language].login.error.phone;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }
            if( json == -5 ){
                var msg = App.content[App.vars.language].login.error.pass;
                var borderBottomDom = $('.border-bottom');
                borderBottomDom.addClass('error');displayError(msg);
            }
        });
    }else{
        // msg = App.content[App.vars.language].login.error.full;
        // $('.border-bottom').addClass('error');
        // displayError(msg);
        if( !(phoneBDom.val().length > 0) ){
            var msg = App.content[App.vars.language].login.error.phone;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');displayError(msg);
            return;
        }
        if( !(codeBDom.val().length > 0) ){
            var msg = App.content[App.vars.language].login.error.pass;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');displayError(msg);
            return;
        }
    }
});


/**************/
/*
/* VERSION C
/*
*/

$(document).on("click","#button-wrapper",function(){
    $(".switchable-form").each(function(){
        console.log("1")
        if($(this).hasClass("hidden")){
            $(this).removeClass("hidden");
        }else {
            $(this).addClass("hidden");
        }
    })
});

$(document).on("click","#button-wrapper button:not(.loading)",function(){
    App.functions.button.loadingState($("#button-wrapper button"));
    // setTimeout(function(){
    //     // window.location.href = App.vars.leavingPageUrl;
    //     window.location.hash = "postroll";
    // },App.vars.loadingTimeButton);
    var data = {};
    var callInfo = new CallInfo("/portal/ajaxgetuserinfo",data);
    callInfo.setData(function(json){
        // console.log(JSON.stringify(json));
        var obj = jQuery.parseJSON(json);
        var rt = obj.rt;
        console.log(obj);
        return false;
        if( rt > 0 ) {
            console.log(obj);
            var userinfo = obj.userinfo;
            var username = userinfo.username;
            var password = userinfo.password;
            return false;
            // var form = $('<form class="hide" action="http://securelogin.arubanetworks.com/auth/loginnw.html" method="post">\
            //          <input type="hidden" name="password" value="'+ password +'" />\
            //          <input type="hidden" name="username" value="'+ username +'" />\
            //          <input type="hidden" name="buttonClicked" value="0"/>\
            //          <input type="hidden" name="redirect_url"/>\
            //          <input type="hidden" name="err_flag" value="0"/>\
            //          </form>');
            // form.appendTo("body").submit();
        } else {
       /*     var msg = App.content[App.vars.language].login.error.back;
            var borderBottomDom = $('.border-bottom');
            borderBottomDom.addClass('error');displayError(msg);*/
        }
    });
});

/*$(document).on("click",".link-update",function(){
    // window.location.href = "index.html";
    window.location.href = "/portal?flgid=1";
});*/

$(document).on("click","#mobile-selector",function(){
    if ($(this).attr('class').indexOf("selected") == -1) {
        $('#other-selector').removeClass("selected");
        $(this).addClass("selected");
        $("#mobile-connect").css('display', 'block');
        $("#other-connect").css('display', 'none');
    }
});
$(document).on("click","#other-selector",function(){
    if ($(this).attr('class').indexOf("selected") == -1) {
        $('#mobile-selector').removeClass("selected");
        $(this).addClass("selected");
        $("#mobile-connect").css('display', 'none');
        $("#other-connect").css('display', 'block');
    }
});


