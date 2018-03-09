
//if there is an existing hash, remove it
window.location.hash = "";

$(document).ready(function(){
    //responsive preloader
    App.functions.responsivePreload(App.functions.detectDeviceScreen());
});

$(window).load(function(){

    //Detect the airport version content
    if(typeof App.vars.airportVersion == "undefined"){
        console.log("Loading airport content from URL param: "+App.vars.urlParams.a);
        if(App.vars.urlParams.a == "hongqiao"){
            App.airportsContent.current = App.airportsContent.airports.hongqiao;
            $("body").addClass("hongqiao");
        }else{
            App.airportsContent.current = App.airportsContent.airports.pudong;
            $("body").addClass("pudong");
        }
    }else{
        console.log("Loading airport content from config file: "+App.vars.airportVersion);
        if(App.vars.airportVersion == "pudong") App.airportsContent.current = App.airportsContent.airports.pudong;
        if(App.vars.airportVersion == "hongqiao") App.airportsContent.current = App.airportsContent.airports.hongqiao;
        $("body").addClass(App.vars.airportVersion);
    }

    App.functions.adaptAirportContent();

    //initiate fastclick
    new FastClick(document.body);

    //some useful output
    screensize = $( window ).width() + " - " + $( window ).height();
    App.functions.log("screen",screensize);
    $( window ).resize(function() {
        screensize = $( window ).width() + " - " + $( window ).height();
        App.functions.log("screen",screensize);
    });

    //lets go to the first page 
    window.location.hash = App.vars.firstPage;

    App.functions.detectDevice();
    App.vars.compatibilityMode = App.functions.assessCompatibilityMode();

    if(App.vars.debugMode == 1) $("#debug").show();

    //which language should we display
    if(App.vars.urlParams.l == "zh") App.functions.content.load("zh");
    if(App.vars.urlParams.l == "en") App.functions.content.load("en");
    //fallback if no language detected in the Url
    if(typeof App.vars.urlParams.l == "undefined") App.functions.content.load(App.vars.defaultLanguage);

    //which version should we display
    if(App.vars.urlParams.v == "v0"){

        App.vars.loginVersion = "login";
        App.vars.siteVersion = "v0";
    }
    if(App.vars.urlParams.v == "v1a"){
        App.vars.loginVersion = "login";
        App.vars.siteVersion = "v1";
    }
    if(App.vars.urlParams.v == "v1b"){
        App.vars.loginVersion = "login-b";
        App.vars.siteVersion = "v1";
    }
    //fallback on the v1a version by default
    if(typeof(App.vars.siteVersion) == undefined){
        App.vars.loginVersion = "login";
        App.vars.siteVersion = "v1";
    }
     console.log("Login displayed: "+ App.vars.loginVersion);
     console.log("Version displayed: "+ App.vars.siteVersion);

    //PAGE SWITCHING SYSTEM
    $(window).on('hashchange', function() {
        var pageToSwitch = window.location.hash.substr(1);
        App.functions.pageSwitcher(pageToSwitch);
    });

    //BUTTON BEHAVIOR
    $("button.anim.example:not(.disabled)").click(function(){
        if($(this).hasClass("loading")){
            App.functions.button.normalState($(this));
        }else{
            App.functions.button.loadingState($(this));
        }
    });

    //output our namespacer
    console.log(App);
});
