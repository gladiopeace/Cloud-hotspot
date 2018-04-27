function getUaType() {
    var  u  =  window.navigator.userAgent;
    var  num ;
    if (u.indexOf('Trident')  >  -1) {
        return  "333";
    } else  if (u.indexOf('Presto')  >  -1) {
        return  "333";
    } else  if (u.indexOf('Gecko')  >  -1  &&  u.indexOf('KHTML')  ==  -1) {
        return  "333";
    } else  if (u.indexOf('AppleWebKit') > -1  &&  u.indexOf('Safari')  >  -1 && u.indexOf('Mobile') == -1) {
        if (u.indexOf('Chrome')  >  -1) {
            return  "333";
        } else  if (u.indexOf('OPR') > -1) {
            return  "333"
        } else {
            return  "333";
        }
    } else if (u.indexOf("Mac OS") && u.indexOf('AppleWebKit') > -1 && u.indexOf('Mobile') == -1) {
        return  "333";
    } else  if (u.indexOf('Mobile')  >  -1) {
        if (u.indexOf("Mac OS X")) {
            num = u.substr(u.indexOf('OS') + 3, 5)
            if (u.indexOf('iPhone')  >  -1) {
                return  "335";
            } else  if (u.indexOf('iPod')  >  -1) {
                return  "335";
            } else  if (u.indexOf('iPad')  >  -1) {
                if (window.orientation == 90 || window.orientation == -90) {
                    return "333"
                }
                return  "334";
            } else {
                return "335";
            }
        } else  if (u.indexOf('Android')  >  -1  ||  u.indexOf('Linux')  >  -1) {
            num  =  u.substr(u.indexOf('Android')  +  8,  3);
            return  "335";
        } else  if (u.indexOf('BB10')  >  -1 ) {
            return  "335";
        } else  if (u.indexOf('IEMobile') > -1) {
            return  "335"
        } else {
            return "335";
        }
    } else {
        return "335";
    }
}

function getLangType() {
    var language;
    var langType;
    if (navigator.appName == 'Netscape') {
        language = navigator.language;
    } else {
        language = navigator.browserLanguage;
    }
    if (language.indexOf('zh') > -1) {
        langType = '71000';
    } else {
        langType = '72000';
    }

    // alert(langType);
    return langType;
}

function getAdImg(wlType) {
    // $.ajax({　　
    //     url: 'http://122.225.103.118:8889/wlQuery?flag=0&pid=F7tEhO1y/OI=',
    //     　　timeout: 3000,
    //     　　type: 'get',
    //     　　data: { uaType: getUaType(), langType: getLangType(), wlType: wlType },
    //     　　dataType: 'jsonp',
    //     　　success: function(data) {
    //         if (data.result == 1) {
    //             document.getElementById("bg").style.backgroundImage = "url('" + data.wlUrl + "')";
    //             //document.getElementById("bg_b").style.backgroundImage = "url('" + data.wlUrl + "')";
		// $.getJSON("http://122.225.103.118:8889/pvtj?callback=?",{'wlId':data.wlId},function(data){});
    //         } else {
    //             if (getUaType() == '333') {
    //                 if (getLangType() == '71000') {
    //                     document.getElementById("bg").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/pc_wifi_login.jpg')";
    //                     document.getElementById("bg_b").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/pc_wifi_login.jpg')";
    //                 } else {
    //                     document.getElementById("bg").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/pc_wifi_login.jpg')";
    //                     document.getElementById("bg_b").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/pc_wifi_login.jpg')";
    //                 }
    //             } else if (getUaType() == '334') {
    //                 if (getLangType() == '71000') {
    //                     document.getElementById("bg").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/tablet_wifi_login.jpg')";
    //                     document.getElementById("bg_b").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/tablet_wifi_login.jpg')";
    //                 } else {
    //                     document.getElementById("bg").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/tablet_wifi_login.jpg')";
    //                     document.getElementById("bg_b").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/tablet_wifi_login.jpg')";
    //                 }
    //             } else if (getUaType() == '335') {
    //                 if (getLangType() == '71000') {
    //                     document.getElementById("bg").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/phone_wifi_login.jpg')";
    //                     document.getElementById("bg_b").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/phone_wifi_login.jpg')";
    //                 } else {
    //                     document.getElementById("bg").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/phone_wifi_login.jpg')";
    //                     document.getElementById("bg_b").style.backgroundImage = "url('http://172.21.163.19/default/defaultpic/phone_wifi_login.jpg')";
    //                 }
    //             }
    //         }　　
    //     },
    //     　　complete: function(XMLHttpRequest, status) {　　　　
    //         if (status == 'timeout' || status == 'error') {
    //             ajaxTimeoutTest.abort();　　　　
    //         }　　
    //     }
    // });
}

$(document).ready(getAdImg('440000'));
