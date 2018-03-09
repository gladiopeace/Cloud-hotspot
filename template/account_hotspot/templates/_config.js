console.log("_config loaded");

//DEVELOPMENT PARAMETERS
if(window.location.href.startsWith("http://localhost") || window.location.href.startsWith("http://192.168")){
    App.vars = {
        clientUserAgent : navigator.userAgent,
        environment : "development",
        compatibilityMode : "",
        forceCompatibilityMode : 0  ,
        urlParams : App.functions.getQueryString(),
        language : "",
        defaultLanguage : "zh",
        currentPage : "",
        //airportVersion : "pudong",
        pagesTransition : "css",
        firstPage : "login",
        prerollLoadingTime : 3000,
        splashscreenTime : 4000,
        postrollLoadingTime : 8000,
        errorDisplayTime : 2000,
        countryCodeDisplayTimeStartup : 3000,
        loadingTimeButton : 1000,
        leavingPageTime : 3000,
        leavingPageUrl : "http://www.shairport.com/",
        debugMode : 0,
    };
}else{
//PRODUCTION PARAMETERS + COMMENTS
    App.vars = {
        // what environment are we on?
        environment : "production",
        // get the user agent string of the client
        clientUserAgent : navigator.userAgent,
        // get the URL GET parameters with JS
        urlParams : App.functions.getQueryString(),
        // the current language
        language : "",
        // what is the default language
        defaultLanguage : "zh",
        // variable that handle which page is currently displayed
        currentPage : "",
        // what airport content to take, hongqiao or pudong
        //airportVersion : "pudong",
        // type of animation, js or css, app was validated and fully tested on css, not js
        pagesTransition : "css",
        // first page to display after the loading
        firstPage : "login",
        // preroll page : how long does it last
        prerollLoadingTime : 3000,
        // splashscreen page : how long does it last
        splashscreenTime : 4000,
        // postroll page : how long last the advertising
        postrollLoadingTime : 8000,
        // how long does the form error displays
        errorDisplayTime : 2000,
        // version A login only : how long does the popup country code helper shows up
        countryCodeDisplayTimeStartup : 3000,
        //time of the loading state of the button
        loadingTimeButton : 1000,
        leavingPageTime : 2000,
        // page to go after the login
        leavingPageUrl : "http://www.shairport.com/",
        // there are two versions for the animations, the compatibility version is for webkit < 537, IE and iOS7
        compatibilityMode : "",
        // force the compatibility version for debug purposes
        forceCompatibilityMode : 0,
        // provide an overlay to display informations using App.functions.log for easy mobile debug
        debugMode : 0,
    };
}


App.customEvents = {
    content : {
        onChange : "contentOnChange",
    }
}

// declare onLanguageChange on namespacer
// dispatch it on content.load
    //for that we need a elem.
    //lets try body
