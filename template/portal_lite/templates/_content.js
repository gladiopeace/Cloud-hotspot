console.log("_content loaded");
App.airportsContent = {
    airports : {
        pudong : {
            en : {
                welcome : "Welcome to Pudong Airport",
                hotline : "<div class='hotline'>\
                <img class='hotline-img' src='./images/wifi-1.png'><br><br>\
                <span class='title'>24hrs Service Line</span><br>\
                <span class='popup-number'>400 6070 122</span>\
                </div>",
                map : "<div class='map'>\
                <h3>Wi-Fi ticket machines can be found at</h3>\
                T1 domestic boarding gate 8/9<br>\
                T1 international boarding gate 19/20<br>\
                T1 international info counter<br>\
                T2 domestic boarding gate<br>\
                C58 T2 international boarding gate<br>\
                D75 T2 international info counter<br>\
                T2 VIP Lounge 78<br>\
                </div>",
            },
            zh : {
                welcome : "浦东机场欢迎您",
                hotline : "<div class='hotline'>\
                <img class='hotline-img' src='./images/wifi-1.png'><br><br>\
                <span class='title'>24小时客服热线</span><br>\
                <span class='popup-number'>400 6070 122</span>\
                </div>",
                map : "<div class='map'>\
                <h3>取号机位于</h3>\
                T1国内8/9号登机口<br>\
                T1国际19/20号登机口<br>\
                T1国际问询台<br>\
                T2国内C58登机口<br>\
                T2国际D75登机口<br>\
                T2国际问询台<br>\
                T2国际78号贵宾室<br>\
                </div>"
            },
        },
        hongqiao : {
            en : {
                welcome : "Welcome to Hongqiao Airport",
                hotline : "<div class='hotline'>\
                <img class='hotline-img' src='./images/wifi-1.png'><br><br>\
                <span class='title'>24hrs Service Line</span><br>\
                <span class='popup-number'>400 9217 105</span>\
                </div>",
                map : "<div class='map'>\
                Wi-Fi ticket machines can be found at T1 boarding gate B9-B10.<br>\
                </div>"
            },
            zh : {
                welcome : "虹桥机场欢迎您",
                hotline : "<div class='hotline'>\
                <img class='hotline-img' src='./images/wifi-1.png'><br><br>\
                <span class='title'>24小时客服热线</span><br>\
                <span class='popup-number'>400 9217 105</span>\
                </div>",
                map : "<div class='map'>\
                取号机位于T1航站楼B9-B10登机口<br>\
                </div>"
            },
        },
    },
    current : {}
}

App.content = {
    zh : {
        preroll : {
            skip : "跳过",
        },
        splashscreen : {
            tagline : ""
        },
        login : {
            error : {
                phone: "您输入的手机号码有误，请重新输入",
                full: "您输入的手机号码有误，请重新输入",
                conditions: "请先接受上网协议",
                back: "账号/密码错误，请重新输入",
                areacode: "请检查国际码",
                pass: "请检查验证码",
                phone: "请检查账号",
                smsIsp:'短信服务未启用',
                expire: "该账号已过期"
            },
            form_a : {
                1 : {
                    popover : "国际及地区代码",
                    phone_placeholder: "请输入手机号码",
                    button_1: "获取验证码",
                    counter_1: 60,
                    code_placeholder: "请输入验证码",
                    button_2: "登录",
                    conditions: "我已阅读并接受上网协议",
                    form_switcher: "其它登录方式",
                },
                2 : {
                    title : "帐户登录",
                    name_placeholder : "帐号",
                    code_placeholder : "密码",
                    button_1 : "登录",
                    conditions : "我已阅读并接受上网协议",
                    switcher : "手机号登录",
                    lang_switcher : "EN",
                   
                },
            },
            form_b : {
                1: {
                    tab_1 : "手机认证",
                    tab_2 : "取号机认证",
                    popover : "国际及地区代码",
                    code_placeholder : "请输入验证码",
                    button_1 : "获取验证码",
                    button_2 : "登录",
                    phone_placeholder : "请输入手机号码",
                    conditions : "我已阅读并接受上网协议",
                    lang_switcher : "EN",
                  
                },
                2 : {
                    title: "获取登录帐户",
                    name_placeholder: "帐号",
                    button_1: "提交",
                    code_placeholder: "密码",
                    conditions: "我已阅读并接受上网协议",
                    lang_switcher : "EN",
                  
                },
            },
            form_c : {
                1: {
                    tab_1 : "手机认证",
                    tab_2 : "取号机认证",
                    popover : "国际及地区代码",
                    code_placeholder : "请输入验证码",
                    button_1 : "一键登录",
                    button_2 : "登录",
                    phone_placeholder : "请输入手机号码",
                    conditions : "我已阅读并接受上网协议",
                    lang_switcher : "EN",
                  
                },
                2 : {
                    title: "获取登录帐户",
                    name_placeholder: "帐号",
                    button_1: "一键登录",
                    code_placeholder: "密码",
                    conditions: "我已阅读并接受上网协议",
                    lang_switcher : "EN",
                
                },
            },
        },
        popup : {
            map : "",
            hotline : "",
            wifi : "<div class='wifi'><h2>WIFI使用条款：</h2><br>\
            本免费Wi-Fi是由您当前上网环境所在地提供的开放式免费网络。<br>\
            您已经阅读、理解并同意接受经协议和规则。若您不同意相关协议，应当立即停止使用开放免费Wi-Fi服务。<br>\
            第一、用户在同意和使用本网络时，必须遵守以下规则：<br>\
            1)用户必须遵守国家的相关法律和互联网各项规章制度。<br>\
            2)用户对使用期间所有活动和事件负全部责任。<br>\
            3)用户对服务的使用必须遵循：<br>\
            （a）从中国境内向外传输技术性资料时必须符合中国有关法规；<br>\
            （b）使用网络服务不作非法用途，不干扰或混乱网络服务；<br>\
            （c）遵守所有使用网络服务的网络协议、规定、程序和惯例；<br>\
            （d）不散布谣言，扰乱社会秩序，破坏社会稳定；不散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪；不侮辱或者诽谤他人，侵害他人合法权益；<br>\
            （e）不传输任何非法、骚扰性、中伤他人、辱骂性、恐吓性、伤害性、庸俗、淫秽等信息资料；不传输任何教唆他人构成犯罪行为的资料；不传输涉及国家安全的资料；不传输任何不符合当地法规、国家法律和国际法律的资料。<br>\
            4）用户需对自己在网上的行为承担法律责任。用户若在网上散布和传播反动、色情或其他违反国家法律的信息，本系统记录有可能作为用户违反法律的证据。<br>\
            5）用户和上网终端信息如有变更，或发生密码泄漏等情况等，一切造成的后果由用户承担。<br>\
            第二、开放免费Wi-Fi网络技术服务商在提供网络服务时遵循以下原则：<br>\
            1）对于免费Wi-Fi网络用户只提供网络接入服务，不提供其它的服务,不对用户网络行为负责。<br>\
            2）对于使用免费Wi-Fi网络服务器上的用户，我们的服务原则是：<br>\
            （a）不涉及用户的联系方式等信息。<br>\
            （b）尊重用户隐私权，绝不公开、编辑或透露用户信息，除非有法律许可要求及公安管理规定。<br>\
            （c）保留判定用户的行为是否符合“用户协议”的权利，如果免费Wi-Fi网络服务提供商认为用户违背了本协议，将会中断其网络，相关损失由用户自己负责。<br>\
            以上“网络用户协议”的各项条款应与国家有关法律、法规保持一致，如有与法律、法规条款相抵触的内容，以法律、法规条款为准。<br>\
            此无线网络服务有权根据需要不时地制订、修改本协议及/或各类规则，并以公示的方式进行变更公告，无需另行单独通知您。当你再次使用即表示您已经阅读、理解并接受经修订的协议和规则。若您不同意相关变更，应当立即停止使用开放免费Wi-Fi服务。<br></div>",
        },
        home : {

        },
        portal : {

        },
        leavingPage : {
            url : App.vars.leavingPageUrl,
            redirecting : "跳转中",
            title : "感谢访问我们的网站",
        }
    },
    en : {
        preroll : {
            skip : "Skip",
        },
        splashscreen : {
            tagline : "Welcome to Wireless Service",
        },
        login : {
            error : {
                phone: "please fill a number",
                full: "please fill a code and agree to the general conditions",
                conditions: "Must accept the terms and conditions",
                back: "invalid account/password, please try again",
                areacode: "plase check international",
                pass: "plase check verification",
                phone: "plase check account",
                smsIsp:'No Message Sender',
                expire: "The Account has expired"
            },
            form_a : {
                1 : {
                    popover : "Country or region code",
                    phone_placeholder: "Phone number",
                    button_1: "Get Code",
                    counter_1: 60,
                    code_placeholder: "SMS Validation Code",
                    button_2: "Log in",
                    conditions: "I agree to the Terms & Conditions",
                    form_switcher: "Login via WIFI Account",
                },
                2 : {
                    title : "Use a Wi-Fi Account",
                    name_placeholder : "Username",
                    code_placeholder : "Password",
                    button_1 : "Send",
                    conditions: "I agree to the Terms & Conditions",
                    switcher : "Login with mobile phone",
                    lang_switcher : "中文",
                  
                },
            },
            form_b : {
                1: {
                    tab_1 : "Login with mobile phone",
                    tab_2 : "Login via WIFI Ticket",
                    popover : "Country or region code",
                    code_placeholder : "SMS Validation Code",
                    button_1 : "Get Code",
                    button_2 : "Log in",
                    phone_placeholder : "Phone Number",
                    conditions : "I agree to the Terms & Conditions",
                    lang_switcher : "中文",
                    
                },
                2 : {
                    title : "Find a Wi-Fi ticket machine",
                    name_placeholder: "Username",
                    button_1: "Send",
                    code_placeholder: "Password",
                    conditions: "I agree to the Terms & Conditions",
                    lang_switcher : "中文",
                    
                },
            },
            form_c : {
                1: {
                    tab_1 : "Login with mobile phone",
                    tab_2 : "Login via WIFI Ticket",
                    popover : "Country or region code",
                    code_placeholder : "SMS Validation Code",
                    button_1 : "One click access",
                    button_2 : "Log in",
                    phone_placeholder : "Phone Number",
                    conditions : "I agree to the Terms & Conditions",
                    lang_switcher : "中文",
                   
                },
                2 : {
                    title : "Find a Wi-Fi ticket machine",
                    name_placeholder: "Username",
                    button_1: "Send",
                    code_placeholder: "Password",
                    conditions: "I agree to the Terms & Conditions",
                    lang_switcher : "中文",
                   
                },
            },
        },
        popup : {
            map : "",
            hotline : "",
            wifi : "<div class='wifi'>\
            <h2>WIFI terms of use：</h2><br>\
            This is a free Hotspot wireless internet service provided by Pudong Airport Authorities as an open network for use by passengers of Pudong.<br><br>\
            You have read, understand and agree to accept the agreement and rules.If you don't agree to the agreement, shall immediately stop the use of open and free wi-fi.<br>\
            First, the user agrees and the use of the network, must abide by the following rules:<br><br>\
            1) the user must abide by the national related laws and regulations of the Internet.<br><br>\
            2) the user take full responsibility for all activities and events during use.<br><br>\
            3) users on the use of the service must be followed:<br><br>\
            (a) from China to the outside transport technical data must comply with the relevant Chinese laws and regulations;<br><br>\
            (b) using the web service is not for illegal purposes, without interference or chaos network services;<br><br>\
            (c) comply with all using web services network protocol, rules, procedures and practices;<br><br>\
            (d) don't spread rumors, disturbing social order, undermine social stability;Spreading obscenity, pornography, gambling, violence, murder, terrorism or abetting crime;Do not insult or slander others, infringes on the lawful rights and interests;<br><br>\
            (e) does not transmit any illegal, harassment, slander others, abusive, threatening, harmful, vulgar and obscene information;Does not transfer any anyone who instigates another to constitute a crime data;Do not transfer information involving national security;Does not transfer any does not accord with the local laws and regulations, the national law and international law.<br><br>\
            4) the user needs to their online behavior bear legal responsibility.If users on the Internet to spread and spread the reactionary, pornography or other violation of the laws of the state information, the system records may be in violation of the law as a user of the evidence.<br><br>\
            5), Internet access and user terminal information if there are any changes, or password leakage occurs, and so on and so forth and so on, all the consequences shall be borne by the user.<br><br>\
            Second, open and free wi-fi network technology service provider in providing network service follow the following principles:<br><br>\
            1) for free wi-fi network users only provide Internet access service, does not provide other services, are not responsible for the user's network behavior.<br><br>\
            2) for using free wi-fi network users on the server, our service principle is:<br><br>\
            (a) does not involve the user's contact information.<br><br>\
            (b) the respect user privacy, never open, edit, or disclose customer information, unless there are legal licensing requirements and the public security management regulations.<br><br>\
            (c) reserved for determining the user's behavior whether to conform to the \"user agreement\" rights, if free wi-fi network service provider that user violation of this agreement, will interrupt the network related loss shall be the responsibility of the users themselves.<br><br>\
            Terms of the above \"online user agreement\" should be consistent with the relevant state laws and regulations, if there is any conflict with the laws, regulations, provisions of the content, the laws, regulations, provisions shall prevail.<br><br>\
            Wireless shall have the right to formulate, modify this agreement from time to time according to need and/or all kinds of rules, and changes in the form of public announcements, no additional inform you separately.When you use again indicates that you have read, understand and accept the revised agreement and rules.If you don't agree with relevant changes, should immediately stop using open and free wi-fi.<br>",
        },
        home : {

        },
        portal : {

        },
        leavingPage : {
            url : App.vars.leavingPageUrl,
            redirecting : "redirecting you to",
            title : "Thanks for your visit",
        }
    },

}
