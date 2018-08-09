<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="//cdn.bootcss.com/jquery/2.0.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>
</head>
<body>
  <div class="container" style="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">



            <div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{dic['qcloud']}}</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{dic['aliyun']}}</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">{{dic['email']}}</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">{{dic['lisence']}}</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">


                        <form class="form-horizontal" id="Qcloud-post">
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <div class="form-group">
                            <label class="col-sm-4 col-xs-4 text-center">APPID</label>

                            <div class="col-sm-7 col-xs-7">
                                <input type="text" id="company" name="data[appid]" class="form-control" value="{{qcloud['appid']}}">
                            </div>


                        </div>


                        <div class="form-group">
                            <label class="col-sm-4 col-xs-4 text-center">APPKEY</label>

                            <div class="col-sm-7 col-xs-7">
                                <input type="text" name="data[appkey]" class="form-control" value="{{qcloud['appkey']}}">
                            </div>


                        </div>


                        <div class="form-group">
                            <label class="col-sm-4 col-xs-4 text-center">TEMPLID</label>

                            <div class="col-sm-7 col-xs-7">
                                <input type="text" name="data[templid]" class="form-control" value="{{qcloud['templid']}}">
                            </div>


                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 col-xs-4 text-center" data-enable="{{qcloud[enable]}}">{{dic['switch']}}</label>

                            <div class="col-sm-7 col-xs-7">

                                <div class="switch" id="QcloudSms">
                                    <input type="checkbox" name="data[enable]" checked data-on-text="{{dic['enable']}}" data-off-text="{{dic['enable']}}"/>
                                </div>
                            </div>


                        </div>
                        <div class="hr-line-dashed"></div>

                            <br/>
                        <br/>



                        <div class="form-group">
                            <div class="col-sm-12 col-sm-offset-12 text-center">
                                <button class="btn btn-success saving" data-form="Qcloud-post" type="button">{{dic['save']}}</button>
                            </div>

                        </div>

                        <input type="hidden" name="do" value="Qcloud">

            </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">

                        <form class="form-horizontal" id="Aliyun-post">
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">AccessKeyId</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" id="company" name="data[accesskey]" class="form-control" value="{{aliyun['accesskey']}}">
                                </div>


                            </div>


                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">accessKeySecret</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[secret]" class="form-control" value="{{aliyun['secret']}}">
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">签名</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[sign_name]" class="form-control" value="{{aliyun['sign_name']}}">
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">模板CODE</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[template_code]" class="form-control" value="{{aliyun['template_code']}}">
                                </div>


                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center" data-enable="{{aliyun[enable]}}">{{dic['switch']}}</label>

                                <div class="col-sm-7 col-xs-7">

                                    <div class="switch" id="AliyunSms">
                                        <input type="checkbox" name="data[enable]" checked data-on-text="{{dic['enable']}}" data-off-text="{{dic['disable']}}"/>
                                    </div>
                                </div>


                            </div>
                            <div class="hr-line-dashed"></div>

                            <br/>
                            <br/>




                            <div class="form-group">
                                <div class="col-sm-12 col-sm-offset-12 text-center">
                                    <button class="btn btn-success saving" data-form="Aliyun-post" type="button">{{dic['save']}}</button>
                                </div>

                            </div>

                            <input type="hidden" name="do" value="Aliyun">

                        </form>



                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">



                        <form class="form-horizontal" id="Email-post">
                            <br/>
                            <br/>
                            <br/>

                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">{{dic['smtp_server']}}</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" id="company" name="data[smtp_server]" class="form-control" value="{{email['smtp_server']}}">
                                </div>


                            </div>


                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">{{dic['smtp_port']}}</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[smtp_port]" class="form-control" value="{{email['smtp_port']}}">
                                </div>


                            </div>


                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">{{dic['username']}}</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[username]" class="form-control" value="{{email['username']}}">
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">{{dic['password']}}</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[password]" class="form-control" value="{{email['password']}}">
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center" data-enable="{{aliyun[enable]}}">{{dic['ssl']}}</label>

                                <div class="col-sm-7 col-xs-7">

                                    <div class="switch" id="Email">
                                        <input type="checkbox" name="data[ssl]" checked data-on-text="{{dic['enable']}}" data-off-text="{{dic['disable']}}"/>
                                    </div>
                                </div>


                            </div>
                            <div class="hr-line-dashed"></div>

                            <br/>
                            <br/>



                            <div class="form-group">
                                <div class="col-sm-12 col-sm-offset-12 text-center">
                                    <button class="btn btn-success saving" data-form="Email-post" type="button">{{dic['save']}}</button>
                                </div>

                            </div>

                            <input type="hidden" name="do" value="Email">

                        </form>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="settings">


                        <form class="form-horizontal" id="bech-post">
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">AccessId</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" id="company" name="data[access_id]" class="form-control" value="{{bech['access_id']}}">
                                </div>


                            </div>


                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">AccessKey</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[access_key]" class="form-control" value="{{bech['access_key']}}">
                                </div>


                            </div>


                            <div class="form-group">
                                <label class="col-sm-4 col-xs-4 text-center">product-code</label>

                                <div class="col-sm-7 col-xs-7">
                                    <input type="text" name="data[product_code]" class="form-control" value="{{bech['product_code']}}">
                                </div>


                            </div>

                            <br/>
                            <br/>

                            <div class="form-group">
                                <div class="col-sm-12 col-sm-offset-12 text-center">
                                    <button class="btn btn-success saving" data-form="bech-post" type="button">{{dic['save']}}</button>
                                </div>
                            </div>
                            <input type="hidden" name="do" value="Bech">


                        </form>




                    </div>
                </div>

            </div>
        </div>
       

    </div>
    
  </div>


  <script src="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
  <link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
  <script type="text/javascript">
    

    $(function(){
        $('#QcloudSms input').bootstrapSwitch('state',{{qcloud['enable']|default(0)}});
        $('#AliyunSms input').bootstrapSwitch('state',{{aliyun['enable']|default(0)}});
        $('#Email input').bootstrapSwitch('state',{{email['ssl']|default(0)}});

        $(".saving").click(function(event) {
            /* Act on the event */
            var form = $(this).data('form');
             $.ajax({
             url: '?do=system',
             type: 'POST',
             dataType: 'json',
             data: $("#"+form).serialize()
             })
             .done(function(ret) {
             if(ret.status=='success'){
             parent.$('#company_place').text($("#company").val());
             swal({
             title: "完成!",
             text: "已经为您保存完成!",
             type: "success"
             });

             }
             //console.log("success");
             });

        });


    })




  </script>
</body>
</html>