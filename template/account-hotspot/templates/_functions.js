console.log("_functions loaded");
/**************/
/* 
/* Get query from URL in JS
/* 
*/

App.functions.getQueryString = function () {
  // This function is anonymous, is executed immediately and 
  // the return value is assigned to QueryString!
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
        // If first entry with this name
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = decodeURIComponent(pair[1]);
        // If second entry with this name
    } else if (typeof query_string[pair[0]] === "string") {
      var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
      query_string[pair[0]] = arr;
        // If third or later entry with this name
    } else {
      query_string[pair[0]].push(decodeURIComponent(pair[1]));
    }
  } 
    return query_string;
};

/**************/
/* 
/* PAGE SWITCHER SYSTEM IN JS
/* 
*/

App.functions.pageSwitcher = function (pageToSwitch) {
  //console.log("App.functions.pageSwitcher: "+pageToSwitch);
  if(App.vars.currentPage != pageToSwitch){
    App.vars.currentPage = pageToSwitch;

    $(".page").each(function(){
        if($(this).attr('id') == pageToSwitch){
            mthis = $(this);
            if(App.vars.pagesTransition == "css") {

                 if(pageToSwitch == "login"){
                    $(".page.active").addClass("fade out").css({
                        "zIndex":'3',
                        "position":'relative'
                    });
                    mthis.show().css({
                        "zIndex":'1',
                        "position":'absolute',
                        'width': '100%',
                        'top': '0px'
                    });
                    setTimeout(function(){
                            $(".page.active").removeClass("active fade out").css({"zIndex":''});
                            setTimeout(function(){
                                mthis.addClass("active").css({"opacity":'',"display":'',"zIndex":'',"top":'',"width":'',"position":''});
                            },0);
                    },300);
                }else{
                    $(".page.active").addClass("fade out");
                        mthis.css("opacity",0).show();
                        // setTimeout(function(){
                            $(".page.active").removeClass("active fade out");
                            mthis.addClass("fade in");
                            // setTimeout(function(){
                                mthis.addClass("active").removeClass("fade in").css({"opacity":'',"display":''});
                        // },300);
                    // },600);
                }
                
            }else{
                $(".page.active").fadeOut(300);
                    setTimeout(function(){
                        $(".page.active").removeClass("active");
                    mthis.fadeIn(300).addClass("active");
                },600);
            }

            //execute script
            if(App.pagesScripts[pageToSwitch]){
                App.pagesScripts[pageToSwitch]();
            }
        }
    });
}
}

/**************/
/* CONTENT AND TRANSLATION SYSTEM, LITE, TRANSPARENT MUSTACHE-LIKE SYSTEM
/* Detect in HTML {{object.param}} and replace it by corresponding js object. Support live, hot content switch for instant content switch (translation)
/* 
*/

//get a js object properties from a string "object.param1.param2" => object.param1.param2
//http://stackoverflow.com/questions/6491463/accessing-nested-javascript-objects-with-string-key
App.functions.objectByString = function(o, s) {
    s = s.replace(/\[(\w+)\]/g, '.$1'); // convert indexes to properties
    s = s.replace(/^\./, '');           // strip a leading dot
    var a = s.split('.');
    for (var i = 0, n = a.length; i < n; ++i) {
        var k = a[i];
        if (k in o) {
            o = o[k];
        } else {
            return;
        }
    }
    return o;
}

App.functions.content = {};

//initialize our DOM by replacing {{ }} in <span class='m-wrapper' data-source='$1'></span>
App.functions.content.init = function (html,callback){
    newContent = html.html().replace(/\{{2}(.*?)\}{2}/g, "<span class='m-wrapper' data-source='$1'></span>");
    html.html(newContent);
    callback();
}

//fill our spans accorfing to data-source
App.functions.content.fill = function (content){
    $(".m-wrapper").each(function(){
        fieldDataSource = $(this).data("source").trim();       
        data = App.functions.objectByString(content,fieldDataSource);
        $(this).html(data);
    });
}

//load the content, here we have different content because of multilingual
App.functions.content.load = function(lang_code) {
    //inform our namespacer to the currently used language content
    console.log(lang_code);
   App.vars.language = lang_code;
   $("body").attr("id",lang_code);
   //init and fill, the init will only replace {{ }} the first time called
   App.functions.content.init($("body"),function(){
        App.functions.content.fill(App.content[App.vars.language]);
    });
   //bind an event "content.onChange" on that moment for extra DOM and JS manipulations
   $(document).trigger(App.customEvents.content.onChange);
}


//function that replace the content according to the selected airport version
App.functions.adaptAirportContent = function (){
    var newcontent = App.airportsContent.current;

    App.content.zh.splashscreen.tagline = newcontent.zh.welcome;
    App.content.zh.popup.map = newcontent.zh.map;
    App.content.zh.popup.hotline = newcontent.zh.hotline;
    
    App.content.en.splashscreen.tagline = newcontent.en.welcome;
    App.content.en.popup.map = newcontent.en.map;
    App.content.en.popup.hotline = newcontent.en.hotline;
};

/**************/
/* 
/* BUTTON SYSTEM
/* 
*/

App.functions.button = {};
App.functions.button.loadingStateForCode = function(b,seconds){
    if(!seconds) seconds = 0;
    b.find(".text").hide(0);
    b.find(".counter").text(seconds);
    b.addClass("loading").removeClass("disabled");
    //if counter
    if(b.find(".counter").length > 0){
        b.find(".counter").delay(100).show(0);
        App.functions.createCounterNew(b,seconds, function(){
            App.functions.button.normalStateForCode(b);
        });
    }
};

App.functions.button.normalState = function(b){
  b.find(".text").delay(100).show(0);
  b.removeClass("loading disabled");
  if(b.find(".counter").length > 0){
      b.find(".counter").hide(0);
  }   
}
App.functions.button.normalStateForCode = function(b){
  var getCodeText = App.content[App.vars.language].login.form_a[1].button_1;
  b.html('<span class="text"><span class="m-wrapper" data-source="login.form_a.1.button_1">' + getCodeText + '</span></span><span class="counter"><span class="m-wrapper" data-source="login.form_a.1.counter_1">60</span></span><div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle></svg></div>')
  b.removeClass("loading disabled");
}

App.functions.button.loadingState = function(b,seconds){
    if(!seconds) seconds = 0;
    console.log(seconds);
    b.find(".text").hide(0);
    b.find(".counter").text(seconds);
    b.addClass("loading").removeClass("disabled");
    //if counter
    if(b.find(".counter").length > 0){
        b.find(".counter").delay(100).show(0);
        App.functions.createCounter(b.find(".counter"),seconds);
    }  
}

App.functions.button.disabledState = function (b){
    b.find(".text").delay(100).show(0);
    b.addClass("disabled").removeClass("loading");
    if(b.find(".counter").length > 0){
        b.find(".counter").hide(0);
    }  
}


/**************/
/* 
/* OTHER HELPERS
/* 
*/

App.functions.log = function(name,value){
    if(!$("#debug").find("."+name).length ){
        $("#debug").append("<div class='"+name+"'></div>");
    }
    $("#debug ."+name).html(name+" : "+value);
}

App.functions.detectDeviceScreen = function(){
    var windowsize = $(window).width();
    //mobile
    if(windowsize < 768) return "mobile";
    //tablet
    if(windowsize >= 768 && windowsize < 1024) return "tablet";
    //desktop
    if(windowsize >= 1024) return "desktop";
}

App.functions.assessCompatibilityMode = function(){
    if( navigator.userAgent.match(/533/g) || 
        navigator.userAgent.match(/534/g) || 
        navigator.userAgent.match(/Android 4.4/g) || 
        navigator.userAgent.match(/Android 4.3/g) || 
        navigator.userAgent.match(/Android 4.2/g) || 
        navigator.userAgent.match(/534/g) || 
        navigator.userAgent.match(/MSIE/g) || 
        navigator.userAgent.match(/OS 7_0/g) || 
        navigator.userAgent.match(/Trident/g) 
        ){
        console.log("/!\\ APP RUNNING IN COMPATIBILITY MODE");
        //alert("Compat mode");
        $("body").addClass("compatibility-mode");
        return 1;
    }else{
        if(App.vars.forceCompatibilityMode == 1){
            $("body").addClass("compatibility-mode");
            return 1;
        }else{
            $("body").addClass("full-mode");
            return 0;
        }
    }
}

App.functions.detectDevice = function(){
    if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream) {
        $("body").addClass("ios");
    }
    if(navigator.userAgent.match(/MicroMessenger/g)) {
        $("body").addClass("wechat");
    }
}

App.functions.detectDeviceByWidth = function(){
    width = $(window).width();
    if(width < 600) return "mobile";
    if(width >= 600 && width < 1024) return "tablet";
    if(width >= 1024 ) return "desktop";
}   

App.functions.responsivePreload = function(deviceType){
    console.log("App.functions.responsivePreload: "+deviceType);
    if(deviceType == "mobile"){
        $(".topreload2").append("\
            <img src='images/login-ad.jpeg'>\
            <img src='images/postroll-ad.jpeg'>\
            <img src='images/preroll-ad.jpeg'>\
            <img src='images/splashscreen-bg.jpeg'>\
        ");
    }
    if(deviceType == "tablet"){
        $(".topreload2").append("\
            <img src='images/postroll_background_tablet.jpg'>\
            <img src='images/preroll_background_tablet.jpg'>\
            <img src='images/login_background_tablet.jpg'>\
            <img src='images/splashscreen-bg-tablet.jpeg'>\
        ");
    }
    if(deviceType == "desktop"){
        $(".topreload2").append("\
            <img src='images/postroll_background_desktop.jpg'>\
            <img src='images/preroll_background_desktop.jpg'>\
            <img src='images/login_background_desktop.jpeg'>\
            <img src='images/splashscreen-bg-desktop.jpeg'>\
        ");
    }
}

App.functions.createCounterNew = function (element,seconds, callback){
    var elementChild = element.find(".counter");
    once = 0;
    counterInterval = setInterval(function(){
        if(seconds!=0){
            seconds--;
            elementChild.text(seconds);
        }else{
            if(once == 0){
                callback();
                once = 1;
                window.clearInterval(counterInterval);
            }
        }
    },1000);
}

App.functions.createCounter = function (element,seconds){
    once = 0;
    counterInterval = setInterval(function(){
        if(seconds!=0){
            seconds--;
            element.text(seconds);
        }else{
            if(once == 0){
                App.functions.button.disabledState(element);
                once = 1;
                window.clearInterval(counterInterval);
            }
        }
    },1000);
}


App.functions.centerDiv = function(t){
    var offset = t.offset();
    var width = t.width();
    var height = t.height();
    var center = {};
     center.x = offset.left + width / 2;
     center.y = offset.top + height / 2;
    return center
}

App.functions.rippleEffect = function(t,e){ 
    var btnOffset = t.offset();
    if(!e){
        var center = centerDiv(t);
        xPos = center.x - btnOffset.left;
        yPos = center.y - btnOffset.top;
        console.log(center);
    }else{
        xPos = e.pageX - btnOffset.left;
        yPos = event.pageY - btnOffset.top;
    }
    var $div = $('<div/>');

    $div.addClass('ripple-effect');
    var $ripple = $(".ripple-effect");

    $ripple.css("height", t.height());
    $ripple.css("width", t.height());
    $div
    .css({
      top: yPos - ($ripple.height()/2),
      left: xPos - ($ripple.width()/2),
      background: t.data("ripple-color")
    }) 
    .appendTo(t);

    window.setTimeout(function(){
     //$div.remove();
    }, 2000);
}