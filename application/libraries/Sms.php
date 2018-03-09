<?php

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    require_once "sms/SmsSender.php";
    require_once "sms/SignatureHelper.php";
    use Qcloud\Sms\SmsSingleSender;
    use Qcloud\Sms\SmsMultiSender;
    use Aliyun\DySDKLite\SignatureHelper;

    class Sms{
        private $config = array();

        public function __construct($config = array()){

            if(!empty($config)){

                $this->config = $config;
            }else{
                $this->config = array(
                    'appid'     =>"1400027872",
                    'appkey'    =>"7d200759f5ad36aa413a332c2a8da453",
                    'templId'   =>15032,
                );

            }




        }
        
        public function QcloudSms($phone,$code){

            $appid = $this->config['appid'];
            $appkey = $this->config['appkey'];
            $templId = $this->config['templid'];
            $singleSender = new SmsSingleSender($appid, $appkey);

            //假设模板内容为：测试短信，{1}，{2}，{3}，上学。
            $params = array($code, "10");
            $result = $singleSender->sendWithParam("86", $phone, $templId, $params, "", "", "");
            $rsp = json_decode($result);

            return $rsp;
        

        }

        public function AliyunSms($phone,$code) {

            $params = array ();

            // *** 需用户填写部分 ***

            // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
            $accessKeyId = $this->config['accesskey'];
            $accessKeySecret = $this->config['secret'];

            // fixme 必填: 短信接收号码
            $params["PhoneNumbers"] = $phone;

            // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
            $params["SignName"] = $this->config['sign_name'];

            // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
            $params["TemplateCode"] = $this->config['template_code'];

            // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
            $params['TemplateParam'] = Array (
                "code" => $code,
                "product" => "云热点"
            );

            // fixme 可选: 设置发送短信流水号
           // $params['OutId'] = "12345";

            // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
            //$params['SmsUpExtendCode'] = "1234567";


            // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
            if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                $params["TemplateParam"] = json_encode($params["TemplateParam"]);
            }

            // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
            $helper = new SignatureHelper();

            // 此处可能会抛出异常，注意catch
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($params, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ))
            );

            return $content;
        }

    }


            


?>