/**
 * Created by Administrator on 2016/5/24.
 */


$(function(){

    var html = "";
    html += "<span id=\"stopin\">";
    html += "   <input name=\"areacode\" id=\"areacode\" autocomplete=\"off\" type=\"text\" data=\"國際區號\"";
    html += "       value=\"+ 86\" style=\"width:36px;\" maxlength=\"6\" class=\"\" onclick=\"findCode(this.value)\" onkeyup=\"findCode(this.value);\" />";
    html += "</span>";
    html += "<div id=\"popup\" class=\"hide\">";
    html += "   <ul id=\"colors_ul\">";
    html += "   </ul>";
    html += "</div>";
    console.log(window.login.search);
    if( App.vars.firstPage == "login" ){
        $("#login").find(".code_tag").after(html);
    } else {
        $("#login-b").find(".code_tag").after(html);
        $("#areacode").css("color","#000");
        $("#popup").css("top","77px");
    }
})


var aCode = new Array();
var acodes= new Array("93","355","213","684","376","244","1264","674","1268","54","374","297","290","43","994","973",
    "880","1246","375","32","501","229","1441","975","591","387","267","55","1284","673","359","226","95","257","855",
    "237","1","238","1345","236","235","56","86","61","57","269","243","242","682","506","225","385","53","357","420",
    "45","253","1767","1809","593","20","503","240","291","372","251","500","298","679","358","33","594","689","241",
    "995","49","233","350","30","299","1473","590","1671","502","1481","224","245","592","509","379","504","852","36",
    "354","91","62","98","964","353","972","39","1876","81","962","73","254","686","850","82","965","996","856","371",
    "961","266","231","218","423","370","352","853","389","261","265","60","960","223","356","692","596","222","230",
    "52","691","373","377","976","1664","212","258","264","977","31","599","687","64","505","227","234","683","6723",
    "47","968","92","680","507","675","595","51","63","48"	,"351","974","262","40","7","250","1869","1758","508","1784",
    "685","378","239","966","221","381","248","232","65","421","386","677","252","27","34","94","249","597","268","46",
    "41","963","886","992","255","66","1242","220","228","690","676","1868","216","90","993","1649","688","256","380",
    "971","44","598","998","678","58","84","1340","681","967","260","263","672","246");
acodes.sort();
aCode[93]="Afghanistan";
aCode[355]="Albania";
aCode[213]="Algeria";
aCode[684]="American Samoa";
aCode[376]="Andorra";
aCode[672]="Antartica";

aCode[244]="Angola";
aCode[1264]="Anguilla";
aCode[674]="Antarctica / Nauru";
aCode[1268]="Antigua and Barbuda";
aCode[54]="Argentina";


aCode[374]="Armenia";
aCode[297]="Aruba";
aCode[290]="Ascension Island / Saint Helena";
aCode[61]="Australia/Christmas Island/Cocos (Keeling) Islands";
aCode[43]="Austria";

aCode[994]="Azerbaijan";
aCode[973]="Bahrain";
aCode[880]="Bangladesh";
aCode[1246]="Barbados";
aCode[375]="Belarus";

aCode[32]="Belgium";
aCode[501]="Belize";
aCode[229]="Benin";
aCode[1441]="Bermuda";
aCode[975]="Bhutan";

aCode[591]="Bolivia";
aCode[387]="Bosnia and Herzegovina";
aCode[267]="Botswana";
aCode[55]="Brazil";

aCode[1284]="British Virgin Islands";
aCode[673]="Brunei Darussalam";
aCode[359]="Bulgaria";
aCode[226]="Burkina Faso";


aCode[95]="Burma";
aCode[257]="Burundi";
aCode[855]="Cambodia";
aCode[237]="Cameroon";
aCode[1]="Canada / Northern Mariana Islands / United States";


aCode[238]="Cape Verde Islands";
aCode[1345]="Cayman Islands";
aCode[236]="Central African Republic";
aCode[235]="Chad";
aCode[56]="Chile";

aCode[86]="China";

aCode[57]="Colombia";
aCode[269]="Comoros / Mayotte Island";

aCode[243]="Congo, Democratic Republic of the";
aCode[242]="Congo, Republic of the";
aCode[682]="Cook Islands";
aCode[506]="Costa Rica";
aCode[225]="Cote d'Ivoire";

aCode[385]="Croatia";
aCode[53]="Cuba";
aCode[357]="Cyprus";
aCode[420]="Czech Republic";
aCode[45]="Denmark";
aCode[246]="Diego Garcia";
aCode[253]="Djibouti";
aCode[1767]="Dominica";
aCode[1809]="Dominican Republic / Puerto Rico";
aCode[593]="Ecuador";
aCode[20]="Egypt";

aCode[503]="El Salvador";
aCode[240]="Equatorial Guinea";
aCode[291]="Eritrea";
aCode[372]="Estonia";
aCode[251]="Ethiopia";

aCode[500]="Falkland Islands (Islas Malvinas)";
aCode[298]="Faroe Islands";
aCode[679]="Fiji Islands";
aCode[358]="Finland";
aCode[33]="France";

aCode[500]="Falkland Islands (Islas Malvinas)";
aCode[298]="Faroe Islands";
aCode[679]="Fiji Islands";
aCode[358]="Finland";
aCode[33]="France";

aCode[594]="French Guiana";
aCode[689]="French Polynesia";
aCode[241]="Gabon";
aCode[995]="Georgia";

aCode[49]="Germany";
aCode[233]="Ghana";
aCode[350]="Gibraltar";
aCode[30]="Greece";
aCode[299]="Greenland";

aCode[1473]="Grenada";
aCode[590]="Guadeloupe";
aCode[1671]="Guam";
aCode[502]="Guatemala";
aCode[1481]="Guernsey";

aCode[224]="Guinea";
aCode[245]="Guinea-Bissau";
aCode[592]="Guyana";
aCode[509]="Haiti";
aCode[379]="Holy See (Vatican City)";

aCode[504]="Honduras";
aCode[852]="Hong Kong (SAR)";
aCode[36]="Hungary";
aCode[354]="Iceland";
aCode[91]="India";

aCode[62]="Indonesia";
aCode[98]="Iran";
aCode[964]="Iraq";
aCode[353]="Ireland";
aCode[972]="Israel";

aCode[39]="Italy";
aCode[1876]="Jamaica";
aCode[81]="Japan";
aCode[962]="Jordan";

aCode[73]="Kazakhstan";
aCode[254]="Kenya";
aCode[686]="Kiribati";
aCode[850]="Korea, North";
aCode[82]="Korea, South";

aCode[965]="Kuwait";
aCode[996]="Kyrgyzstan";
aCode[856]="Laos";
aCode[371]="Latvia";
aCode[961]="Lebanon";

aCode[266]="Lesotho";
aCode[231]="Liberia";
aCode[218]="Libya";
aCode[423]="Liechtenstein";
aCode[370]="Lithuania";

aCode[352]="Luxembourg";
aCode[853]="Macao";
aCode[389]="Macedonia, The Former Yugoslav Republic of";
aCode[261]="Madagascar";
aCode[265]="Malawi";

aCode[352]="Luxembourg";
aCode[853]="Macao";
aCode[389]="Macedonia, The Former Yugoslav Republic of";
aCode[261]="Madagascar";
aCode[265]="Malawi";

aCode[60]="Malaysia";
aCode[960]="Maldives";
aCode[223]="Mali";
aCode[356]="Malta";
aCode[692]="Marshall Islands";

aCode[596]="Martinique";
aCode[222]="Mauritania";
aCode[230]="Mauritius";
aCode[52]="Mexico";

aCode[691]="Micronesia, Federated States of	";
aCode[373]="Moldova";
aCode[377]="Monaco";
aCode[976]="Mongolia";
aCode[1664]="Montserrat";

aCode[212]="Morocco";
aCode[258]="Mozambique";
aCode[264]="Namibia";
aCode[977]="Nepal";

aCode[31]="Netherlands";
aCode[599]="Netherlands Antilles";
aCode[687]="New Caledonia";
aCode[64]="New Zealand";
aCode[505]="Nicaragua";

aCode[227]="Niger";
aCode[234]="Nigeria";
aCode[683]="Niue";
aCode[6723]="Norfolk Island";

aCode[47]="Norway / Svalbard";
aCode[968]="Oman";
aCode[92]="Pakistan";
aCode[680]="Palau";
aCode[507]="Panama";

aCode[675]="Papua New Guinea";
aCode[595]="Paraguay";
aCode[51]="Peru";
aCode[63]="Philippines";
aCode[48]="Poland";

aCode[351]="Portugal";
aCode[974]="Qatar";
aCode[262]="Reunion";
aCode[40]="Romania";

aCode[7]="Russia";
aCode[250]="Rwanda";
aCode[1869]="Saint Kitts and Nevis";
aCode[1758]="Saint Lucia";

aCode[508]="Saint Pierre and Miquelon";
aCode[1784]="Saint Vincent and the Grenadines";
aCode[685]="Samoa";
aCode[378]="San Marino";
aCode[239]="Sao Tome and Principe";

aCode[966]="Saudi Arabia";
aCode[221]="Senegal";
aCode[381]="Serbia and Montenegro";
aCode[248]="Seychelles";
aCode[232]="Sierra Leone";

aCode[65]="Singapore";
aCode[421]="Slovakia";
aCode[386]="Slovenia";
aCode[677]="Solomon Islands";
aCode[252]="Somalia";

aCode[27]="South Africa";
aCode[34]="Spain";
aCode[94]="Sri Lanka";
aCode[249]="Sudan";
aCode[597]="Suriname";

aCode[268]="Swaziland";
aCode[46]="Sweden";
aCode[41]="Switzerland";
aCode[963]="Syria";

aCode[886]="Taiwan";
aCode[992]="Tajikistan";
aCode[255]="Tanzania";
aCode[66]="Thailand";
aCode[1242]="The Bahamas";

aCode[220]="The Gambia";
aCode[228]="Togo";
aCode[690]="Tokelau";
aCode[676]="Tonga";
aCode[1868]="Trinidad and Tobago";

aCode[216]="Tunisia";
aCode[90]="Turkey";
aCode[993]="Turkmenistan";
aCode[1649]="Turks and Caicos Islands";
aCode[688]="Tuvalu";

aCode[256]="Uganda";
aCode[380]="Ukraine";
aCode[971]="United Arab Emirates";
aCode[44]="United Kingdom";
aCode[598]="Uruguay";

aCode[998]="Uzbekistan";
aCode[678]="Vanuatu";
aCode[58]="Venezuela";
aCode[84]="Vietnam";
aCode[1340]="Virgin Islands";

aCode[681]="Wallis and Futuna";
aCode[967]="Yemen";
aCode[260]="Zambia";
aCode[263]="Zimbabwe";


function findCode(value){
    value = value.replace(" ","").replace("+","");
    if(value.length>0){
        var aResult = new Array();
        for(var i=0;i<acodes.length;i++){

            if(acodes[i].indexOf(value) == 0){
                //aResult.push(acodes[i]+" - "+aCode[acodes[i]]);
                aResult.push(acodes[i]);
            }
        }
        if(aResult.length>0){
            setCodes(aResult);
        }else{
            clearCodes();
        }
    }else{
        defaultcode();
    }
}
function liover(id){

    document.getElementById(id).setAttribute("class","mouseOver");
    document.getElementById(id).setAttribute("className","mouseOver");
}
function liout(id){
    document.getElementById(id).setAttribute("class","mouseOut");
    document.getElementById(id).setAttribute("className","mouseOut");
}
function setCodes(rs){
    document.getElementById("popup").setAttribute("class","show");
    document.getElementById("popup").setAttribute("className","show");
    ulnode=document.getElementById("colors_ul");
    var listr="";
    for(var i=0;i<rs.length;i++){
        //var s=rs[i].indexOf(" - ");
        //telcode=rs[i].substr(0,s);
        telcode = rs[i];
        listr = listr+"<li id='li"+i+"' onclick='selectcode("+telcode+")' onmousemove='liover(this.id)' onmouseout='liout(this.id)' class='mouseout'>+ "+rs[i]+"</li>";
    }
    ulnode.innerHTML=listr;
}
function selectcode(ids){
    document.getElementById("areacode").value = "+ " + ids;
    document.getElementById("popup").setAttribute("class","hide");
    document.getElementById("popup").setAttribute("className","hide");
    clearCodes();
}
function defaultcode(){
    var aResult=new Array();
    //aResult.push("86 - China");
    aResult.push("86");
    setCodes(aResult);
}
function clearCodes(){
    ulnode=document.getElementById("colors_ul");
    ulnode.innerHTML="";
    document.getElementById("popup").setAttribute("class","hide");
    document.getElementById("popup").setAttribute("className","hide");
}
function stopPropagation(e) {
    e = e || window.event;
    if(e.stopPropagation) { //W3C阻止冒泡方法
        e.stopPropagation();
    } else {
        e.cancelBubble = true; //IE阻止冒泡方法
    }
}
var setdefault=function(){
    $("#mobile,#captcha2,#areacode").each(function(){
        var df=$(this).attr("data");
        $(this).val(df);
    })
};
$("#areacode").focus(function(){
    //yick add setdefault for area code
    var areanum=$("#areacode").val();
    if(areanum==""||areanum=="國際區號"){
        areanum="86";
    }
    findCode(areanum);

});

var bodyLoad = function(){

   
    document.getElementsByTagName('body').item(0).onclick=function(){document.getElementById('popup').className='hide';};
    document.getElementById('stopin').onclick=function(e){stopPropagation(e);};
};