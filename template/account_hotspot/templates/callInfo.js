/**
 * Created by Administrator on 2016/3/28.
 */
/**
 * 后台接口
 * @param url
 * @param data
 * @constructor
 */
var CallInfo = function(url,data){
    this.url = url;
    this.data = data;
};


CallInfo.prototype.setData = function(callback){
    var url = this.url;
    var data = this.data;
    $.ajax({
        type: "post",
        dataType: "json",
        url: url,
        async: true,
        data: data,
        success: callback,
        error: function(json) {
            //self.eventSpace.trigger("error." + id);
            console.log("error"+JSON.stringify(json));
        }
    })
};