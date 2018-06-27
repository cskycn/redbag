<?php
/**
 * Copyright (c) 2013-2015, All rights reserved.
 * Author: 未知
 * Create: 2015/10/20 15:12
 */
namespace Common\Weixin;

use Common\Common\CupWeixin;

class WeiSdk
{
    private $appId;
    private $appSecret;
    static  $nonceStr;
    static  $timestamp;
    private $url;

    public function __construct($appId, $appSecret, $url='')
    {
        $this->appId     = $appId;
        $this->appSecret = $appSecret;
        $this->url       = $url;
    }

    public function getSignPackage()
    {
        $jsapiTicket = $this->getJsApiTicket();
        // 注意 URL 一定要动态获取，不能 hardcode.
//        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
//        $Yurl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//        $Zurl = substr(strrchr($Yurl,'&url='),5);
//        Logs::Logs('xy','传递URL：'.$this->url.'  获取URL：'.$Yurl.' 截取到的11URL：'.$Zurl);
        $url       = $this->url;
        $timestamp = time();
        $nonceStr  = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
//        $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Uploads/wx_json/jsapi_ticket.json"));
        $Baseinfo = CupWeixin::baseInfo();
        if ($Baseinfo['jsapi_ticket_time'] < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url    = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res    = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
//                $data->expire_time  = time() + 7000;
//                $data->jsapi_ticket = $ticket;
//                $fp                 = fopen($_SERVER['DOCUMENT_ROOT'] . "/Uploads/wx_json/jsapi_ticket.json", "w");
//                fwrite($fp, json_encode($data));
//                fclose($fp);
                M("weixin_configure")->where(['weixin_configure_id'=>$Baseinfo['weixin_configure_id']])->save(['jsapi_ticket'=>$ticket,'jsapi_ticket_time'=>time()+700]);
            }
        } else {
            $ticket = $Baseinfo['jsapi_ticket'];
        }

        return $ticket;
    }

    public function getAccessToken()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
//        $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Uploads/wx_json/access_token.json"));
        $Baseinfo = CupWeixin::baseInfo();
        if ($Baseinfo['access_token_time'] < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url          = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res          = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                M("weixin_configure")->where(['weixin_configure_id'=>$Baseinfo['weixin_configure_id']])->save(['access_token'=>$access_token,'access_token_time'=>time()+700]);
            }
        } else {
            $access_token = $Baseinfo['access_token'];
        }
        return $access_token;
    }

    /**
     *
     *  下载媒体文件
     */
//    public function downloadWeixinFile($media_id)
//    {
//        $access_token = $this->getAccessToken();
//        $url          = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $access_token . '&media_id=' . $media_id;
//        $ch           = curl_init($url);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_NOBODY, 0);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $package  = curl_exec($ch);
//        $httpinfo = curl_getinfo($ch);
////        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
//        curl_close($ch);
//        $imageAll = array_merge(array('header' => $httpinfo, 'body' => $package));
//
//        $sizeDown = $httpinfo['size_download'];
//        if($sizeDown<120){
//            //获取
//            $errorCode = json_decode($package,true)['errcode'];
//            if($errorCode == 40001){
//                //删除
//                unlink($_SERVER['DOCUMENT_ROOT'].'/Uploads/wx_json/access_token.json');
//                unlink($_SERVER['DOCUMENT_ROOT'].'/Uploads/wx_json/jsapi_ticket.json');
//                if($this->count >= 1){
//                    return $imageAll;
//                }
//                $this->count = $this->count+1;
//                $this->downloadWeixinFile($media_id);
//            }
//        }
//
//        return $imageAll;
//    }

    /**
     * 保存媒体文件
     */
//    public function saveWeixinFile($filecontent)
//    {
//        $filename   = time() . '.jpg';
//        $local_file = fopen($_SERVER['DOCUMENT_ROOT'] . '/Uploads/shotImages/' . $filename, 'w');
//        if (false !== $local_file && false !== fwrite($local_file, $filecontent)) {
//            fclose($local_file);
//            return '/Uploads/shotImages/' . $filename;
//        } else {
//            return '';
//        }
//    }


    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
}