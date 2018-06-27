<?php
/**
 * Copyright (c) 2013-2015, All rights reserved.
 * Author: Bob Chen <ct_job123@163.com>
 * Create: 2015/10/20 15:12
 */
namespace Common\Weixin;

use Common\Common\Logs;

class WxPayHelper
{
    var    $parameters; //cft 参数
    var    $custom_id;//构造函数传入customid
    public $appid      = '';
    public $appsecret  = '';
    public $partnerid  = '';
    public $paysignkey = '';
    public $partnerkey = '';

    function __construct()
    {

    }

    function setParameter($parameter, $parameterValue)
    {
        $this->parameters[CommonUtil::trimString($parameter)] = CommonUtil::trimString($parameterValue);
    }

    function getParameter($parameter)
    {
        return $this->parameters[$parameter];
    }

    //获取商户号
    function getPartnerId()
    {
        return $this->partnerid;
    }

    public function create_noncestr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            //$str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $str;
    }

    function check_cft_parameters()
    {
        Logs::Logs('parameters',json_encode($this->parameters));
        if ($this->parameters["appid"] == null || $this->parameters["body"] == null || $this->parameters["mch_id"] == null || $this->parameters["nonce_str"] == null ||
            $this->parameters["out_trade_no"] == null || $this->parameters["total_fee"] == null || $this->parameters["openid"] == null ||
            $this->parameters["notify_url"] == null || $this->parameters["spbill_create_ip"] == null || $this->parameters["trade_type"] == null
        ) {
            return false;
        }
        return true;

    }

    function check_cft_parameters1()//退款
    {
        if ($this->parameters["appid"] == null || $this->parameters["mch_id"] == null || $this->parameters["nonce_str"] == null || $this->parameters["out_trade_no"] == null || $this->parameters["total_fee"] == null || $this->parameters["refund_fee"] == null || $this->parameters["op_user_id"] == null || $this->parameters["out_refund_no"] == null) {
            Logs::Logs('payout',$this->parameters["appid"].'##'.$this->parameters["mch_id"].'##'.$this->parameters["nonce_str"].'##'. $this->parameters["out_trade_no"].'##'.$this->parameters["total_fee"].'##'.$this->parameters["refund_fee"].'##'. $this->parameters["op_user_id"].'##'.$this->parameters["out_refund_no"]);
            return false;
        }
        return true;
    }

    protected function get_cft_package()
    {
        //获得PARTNERKEY
        $partnerkey = $this->partnerkey;
        try {

            if (null == $partnerkey || "" == $partnerkey) {
                throw new SDKRuntimeException("密钥不能为空！" . "<br>");
            }
            $commonUtil = new CommonUtil();
            ksort($this->parameters);
            $unSignParaString = $commonUtil->formatQueryParaMap($this->parameters, false);
            $paraString       = $commonUtil->formatQueryParaMap($this->parameters, true);

            $md5SignUtil = new MD5SignUtil();
            return $paraString . "&sign=" . $md5SignUtil->sign($unSignParaString, $commonUtil->trimString($partnerkey));
        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }

    }

    protected function get_biz_sign($bizObj)
    {
        //获取APPkEY
        $appkey = $this->paysignkey;

        foreach ($bizObj as $k => $v) {
            $bizParameters[strtolower($k)] = $v;
        }
        try {
            if ($appkey == "") {
                throw new SDKRuntimeException("APPKEY为空！" . "<br>");
            }
            $bizParameters["appkey"] = $appkey;
            ksort($bizParameters);
            //var_dump($bizParameters);
            $commonUtil = new CommonUtil();
            $bizString  = $commonUtil->formatBizQueryParaMap($bizParameters, false);
            // var_dump($bizString);
            return sha1($bizString);
        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }
    //生成app支付请求json
    /*
    {
    "appid":"wwwwb4f85f3a797777",
    "traceid":"crestxu",
    "noncestr":"111112222233333",
    "package":"bank_type=WX&body=XXX&fee_type=1&input_charset=GBK&notify_url=http%3a%2f%2f
        www.qq.com&out_trade_no=16642817866003386000&partner=1900000109&spbill_create_ip=127.0.0.1&total_fee=1&sign=BEEF37AD19575D92E191C1E4B1474CA9",
    "timestamp":1381405298,
    "app_signature":"53cca9d47b883bd4a5c85a9300df3da0cb48565c",
    "sign_method":"sha1"
    }
    */
    function create_app_package($traceid = "")
    {
        try {
            //var_dump($this->parameters);
            if ($this->check_cft_parameters() == false) {
                throw new SDKRuntimeException("生成package参数缺失！" . "<br>");
            }
            $nativeObj["appid"]         = $this->appid;
            $nativeObj["package"]       = $this->get_cft_package();
            $nativeObj["timestamp"]     = time();
            $nativeObj["traceid"]       = $traceid;
            $nativeObj["noncestr"]      = $this->create_noncestr();
            $nativeObj["app_signature"] = $this->get_biz_sign($nativeObj);
            $nativeObj["sign_method"]   = 'sha1';
            return json_encode($nativeObj);


        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }
    //生成jsapi支付请求json
    /*
    "appId" : "wxf8b4f85f3a794e77", //公众号名称，由商户传入
    "timeStamp" : "189026618", //时间戳这里随意使用了一个值
    "nonceStr" : "adssdasssd13d", //随机串
    "package" : "bank_type=WX&body=XXX&fee_type=1&input_charset=GBK&notify_url=http%3a%2f
    %2fwww.qq.com&out_trade_no=16642817866003386000&partner=1900000109&spbill_create_i
    p=127.0.0.1&total_fee=1&sign=BEEF37AD19575D92E191C1E4B1474CA9",
    //扩展字段，由商户传入
    "'sha1'" : "SHA1", //微信签名方式:sha1
    "paySign" : "7717231c335a05165b1874658306fa431fe9a0de" //微信签名
    */
    function create_biz_package()
    {
        //加载微信支付配置文件
        try {
            if ($this->check_cft_parameters() == false) {
                throw new SDKRuntimeException("生成package参数缺失！" . "<br>");
            }
            $nativeObj["appId"]     = $this->appid;
            $nativeObj["package"]   = $this->get_cft_package();
            $nativeObj["timeStamp"] = strval(time());
            $nativeObj["nonceStr"]  = $this->create_noncestr();
            $nativeObj["paySign"]   = $this->get_biz_sign($nativeObj);
            $nativeObj["'sha1'"]    = 'sha1';

            return $nativeObj;

        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }

    /**
     *  乐学支付
     */
    function getPackage()
    {
        //加载微信支付配置文件
        try {
            if ($this->check_cft_parameters() == false) {
                throw new SDKRuntimeException("生成package参数缺失！" . "<br>");
            }
            //生成签名算法
            $this->setParameter('sign', $this->getSign($this->parameters,false));
            $xml
                     = '<xml>
                           <appid>'.$this->getParameter('appid').'</appid>
                           <body>'.$this->getParameter('body').'</body>
                           <mch_id>'.$this->getParameter('mch_id').'</mch_id>
                           <nonce_str>'.$this->getParameter('nonce_str').'</nonce_str>
                           <notify_url>'.$this->getParameter('notify_url').'</notify_url>
                           <openid>'.$this->getParameter('openid').'</openid>
                           <out_trade_no>'.$this->getParameter('out_trade_no').'</out_trade_no>
                           <spbill_create_ip>'.$this->getParameter('spbill_create_ip').'</spbill_create_ip>
                           <total_fee>'.$this->getParameter('total_fee').'</total_fee>
                           <trade_type>'.$this->getParameter('trade_type').'</trade_type>
                           <sign>'.$this->getParameter('sign').'</sign>
                        </xml>';


            $api_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
            $postObj = $this->post($api_url, $xml);
            $msg = ''.$postObj->return_msg;
            if($msg == 'OK'){
                $result['appId'] = $this->getParameter('appid');
                $result['timeStamp'] = strval(time());
                $result['nonceStr'] = ''.$postObj->nonce_str;
                $result['package'] = 'prepay_id='.$postObj->prepay_id;
                $result['signType'] = 'MD5';
                $result['paySign'] = $this->getSign($result,false);
            }else{
                throw new SDKRuntimeException("prepay_id获取失败".implode('==',$postObj));
            }
            return $result;
        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }

    /**
     *  微信退款
     */
    function refundPackage()
    {
        if ($this->check_cft_parameters1() == false) {
            throw new SDKRuntimeException("生成package参数缺失！" . "<br>");
        }
        //生成签名算法
        $this->setParameter('sign', $this->getSign($this->parameters,false));
        $xml
            = '<xml>
               <appid>'.$this->getParameter('appid').'</appid>
               <mch_id>'.$this->getParameter('mch_id').'</mch_id>
               <nonce_str>'.$this->getParameter('nonce_str').'</nonce_str>
               <op_user_id>'.$this->getParameter('op_user_id').'</op_user_id>
               <out_refund_no>'.$this->getParameter('out_refund_no').'</out_refund_no>
               <out_trade_no>'.$this->getParameter('out_trade_no').'</out_trade_no>
               <refund_fee>'.$this->getParameter('refund_fee').'</refund_fee>
               <total_fee>'.$this->getParameter('total_fee').'</total_fee>
               <sign>'.$this->getParameter('sign').'</sign>
        </xml>';
        Logs::Logs('payout','服务器提交XML：'.$xml);
        $api_url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $postXml = $this->curl_post_ssl($api_url, $xml);
//        $postXml = substr($postXml,strpos($postXml,'<xml>'));
        $postObj = simplexml_load_string($postXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $array = json_decode(json_encode($postObj), true);
        $msg = $array['return_msg'];
        if($msg == 'OK'){
            $result_code = $array['result_code'];
            if($result_code == 'SUCCESS'){
                Logs::Logs('payout','---------------------------微信退款成功---------------------------');
                $res = array(
                    'code'=>0,
                    'message'=>'退款成功',
                    'appid'=>$array['appid'],
                    'mch_id'=>$array['mch_id'],
                    'nonce_str'=>$array['nonce_str'],
                    'sign'=>$array['sign'],
                    'transaction_id'=>$array['transaction_id'],
                    'out_trade_no'=>$array['out_trade_no'],
                    'out_refund_no'=>$array['out_refund_no'],
                    'refund_id'=>$array['refund_id'],
                    'refund_fee'=>$array['refund_fee'],
                    'total_fee'=>$array['total_fee'],
                    'cash_fee'=>$array['cash_fee']
                );
            }else{
                Logs::Logs('payout','微信退款失败：'.$array['err_code_des']);
                $res = array(
                    'code'=>402,
                    'message'=>'微信退款失败'.$array['err_code_des']
                );
            }
        }else{
            Logs::Logs('payout','微信退款失败：服务器提交给微信端数据失败');
            $res = array(
                'code'=>403,
                'message'=>'微信退款失败：服务器提交给微信端数据失败'
            );
        }
        return $res;
    }

    public function curl_post_ssl($url, $xml, $second=30,$aHeader=array())
    {
        $file = $_SERVER['DOCUMENT_ROOT'].'/apps/Common/Weixin/lexnj15today51lqtodayedu.pem';
        if(is_file($file)){
            Logs::Logs('payout',222);
        }else{
            Logs::Logs('payout',333);
        }
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);//证书检查
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
//        curl_setopt($ch,CURLOPT_SSLCERT,'/www/lexue_v2.3.1/Public/xuelecert15today/lxjxj_cert_20lqjxj.pem');
        curl_setopt($ch,CURLOPT_SSLCERT,$_SERVER['DOCUMENT_ROOT'].'/apps/Common/Weixin/lxjxj_cert_20lqjxj.pem');
//        curl_setopt($ch,CURLOPT_SSLCERT,'/opt/lexuecert/apiclientl_xcert.pem');
//        curl_setopt($ch,CURLOPT_SSLCERT,'/tmp/apiclientl_xcert.pem');
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
//        curl_setopt($ch,CURLOPT_SSLKEY,'/www/lexue_v2.3.1/Public/xuelecert15today/lexue51_key_jstoday.pem');
        curl_setopt($ch,CURLOPT_SSLKEY,$_SERVER['DOCUMENT_ROOT'].'/apps/Common/Weixin/lexue51_key_jstoday.pem');
//        curl_setopt($ch,CURLOPT_SSLKEY,'/opt/lexuecert/apiclientl_xkey.pem');
//        curl_setopt($ch,CURLOPT_SSLKEY,'/tmp/apiclientl_xkey.pem');
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
//        curl_setopt($ch,CURLOPT_CAINFO,'/www/lexue_v2.3.1/Public/xuelecert15today/lexnj15today51lqtodayedu.pem');
        curl_setopt($ch,CURLOPT_CAINFO,$_SERVER['DOCUMENT_ROOT'].'/apps/Common/Weixin/lexnj15today51lqtodayedu.pem');
//        curl_setopt($ch,CURLOPT_CAINFO,'/opt/lexuecert/rootl_xca.pem');
//        curl_setopt($ch,CURLOPT_CAINFO,'/tmp/rootl_xca.pem');
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
        Logs::Logs('payout',$ch);
        $data=curl_exec($ch);
        if($data){ //返回来的是xml格式需要转换成数组再提取值，用来做更新
            Logs::Logs('payout','微信返回XML：'.$data);
            curl_close($ch);

            return $data;
        }else{
            $error=curl_errno($ch);
            echo "curl出错，错误代码：$error"."<br/>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurs.html'>;错误原因查询</a><br/>";
            curl_close($ch);
            echo false;
        }
    }

    /**
     *
     * 获取支付签名
     */
    public function  getSign($paraMap,$urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v){
            if (null != $v && "null" != $v && "sign" != $k) {
                if($urlencode){
                    $v = urlencode($v);
                }
                $buff .= $k . "=" . $v . "&";
            }
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = $buff."key=".$this->partnerkey;
        }
        return strtoupper(md5($reqPar));
    }

    //生成原生支付url
    /*
    weixin://wxpay/bizpayurl?sign=XXXXX&appid=XXXXXX&productid=XXXXXX&timestamp=XXXXXX&noncestr=XXXXXX
    */
    function create_native_url($productid)
    {

        $commonUtil             = new CommonUtil();
        $nativeObj["appid"]     = $this->appid;
        $nativeObj["productid"] = urlencode($productid);
        $nativeObj["timestamp"] = time();
        $nativeObj["noncestr"]  = $this->create_noncestr();
        $nativeObj["sign"]      = $this->get_biz_sign($nativeObj);
        $bizString              = $commonUtil->formatBizQueryParaMap($nativeObj, false);
        return "weixin://wxpay/bizpayurl?" . $bizString;

    }
    //生成原生支付请求xml
    /*
    <xml>
    <AppId><![CDATA[wwwwb4f85f3a797777]]></AppId>
    <Package><![CDATA[a=1&url=http%3A%2F%2Fwww.qq.com]]></Package>
    <TimeStamp> 1369745073</TimeStamp>
    <NonceStr><![CDATA[iuytxA0cH6PyTAVISB28]]></NonceStr>
    <RetCode>0</RetCode>
    <RetErrMsg><![CDATA[ok]]></ RetErrMsg>
    <AppSignature><![CDATA[53cca9d47b883bd4a5c85a9300df3da0cb48565c]]>
    </AppSignature>
    <SignMethod><![CDATA[sha1]]></ SignMethod >
    </xml>
    */
    function create_native_package($retcode = 0, $reterrmsg = "ok")
    {
        try {
            if ($this->check_cft_parameters() == false && $retcode == 0) {   //如果是正常的返回， 检查财付通的参数
                throw new SDKRuntimeException("生成package参数缺失！" . "<br>");
            }
            $nativeObj["AppId"]        = $this->appid;
            $nativeObj["Package"]      = $this->get_cft_package();
            $nativeObj["TimeStamp"]    = time();
            $nativeObj["NonceStr"]     = $this->create_noncestr();
            $nativeObj["RetCode"]      = $retcode;
            $nativeObj["RetErrMsg"]    = $reterrmsg;
            $nativeObj["AppSignature"] = $this->get_biz_sign($nativeObj);
            $nativeObj["SignMethod"]   = 'sha1';
            $commonUtil                = new CommonUtil();

            return $commonUtil->arrayToXml($nativeObj);

        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }

    }

    function open($api_url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $ret   = curl_exec($ch);
        $error = curl_error($ch);

        if ($error) {
            return false;
        }

        $json = json_decode($ret, TRUE);

        return $json;
    }


    function post($api_url, $data)
    {
        $context = array('http' => array('method' => "POST", 'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) \r\n Accept: */*", 'content' => $data));
        $stream_context = stream_context_create($context);
        $ret = @file_get_contents($api_url, FALSE, $stream_context);
        $ret = simplexml_load_string($ret, 'SimpleXMLElement', LIBXML_NOCDATA);

        return $ret;
    }

    /**
     * 获取access token
     * @return array
     */
//    function access_token($cache = true)
//    {
//        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecret";
//        // echo $url;
//        $access_token = '';
//        $cachefile    = dirname(STATICPATH) . "/application/logs/token.txt";
//
//        if (file_exists($cachefile) && $cache) {
//            $access_token = file_get_contents($cachefile);
//            return $access_token;
//        }
//        try {
//
//            $ret = $this->open($url);
//            @unlink($cachefile);
//            file_put_contents($cachefile, $ret['access_token'], FILE_APPEND);
//            return $ret['access_token'];
//        } catch (Exception $e) {
//            return '';
//        }
//
//    }

    /**
     * 发货通知
     *
     * openid                    购买用户的 OpenId，这个已经放在最终支付结果通知的 PostData 里了
     * transid                    交易单号
     * out_trade_no                第三方订单号
     * appsignature             最终支付结果通知的 PostData 里了的依据签名方式生成
     * deliver_timestamp        发货时间戳
     * deliver_status            发货状态    1:成功 0:失败
     * deliver_msg                发货状态信息
     *
     */

    function delivernotify($openid, $transid, $out_trade_no, $deliver_status = 1, $deliver_msg = 'ok')
    {

        $post                      = array();
        $post['appid']             = $this->appid;
        $post['appkey']            = $this->paysignkey;
        $post['openid']            = $openid;
        $post['transid']           = $transid;
        $post['out_trade_no']      = $out_trade_no;
        $post['deliver_timestamp'] = time();
        $post['deliver_status']    = $deliver_status;
        $post['deliver_msg']       = $deliver_msg;
        $post['app_signature']     = $this->get_sign($post);
        $post['sign_method']       = "SHA1";

        $data = json_encode($post);
        $weiSdk = new WeiSdk();
        $access_token = $weiSdk->getAccessToken();

        $url = 'https://api.weixin.qq.com/pay/delivernotify?access_token=' . $access_token;
        $ret = $this->post($url, $data);
        if (in_array($ret['errcode'], array(40001, 40002, 42001))) {
            @unlink($_SERVER['DOCUMENT_ROOT'].'/Uploads/wx_json/access_token.json');
            @unlink($_SERVER['DOCUMENT_ROOT'].'/Uploads/wx_json/jsapi_ticket.json');
            return $this->delivernotify($openid, $transid, $out_trade_no, $deliver_status, $deliver_msg);
        }
        return $ret;
    }

    //生成签名 Sha1 obj为数组
    function get_sign($obj)
    {

        try {

            if (null == $this->partnerkey || "" == $this->partnerkey) {
                throw new SDKRuntimeException("密钥不能为空！" . "<br>");
            }

            $commonUtil = new CommonUtil();
            ksort($obj);
            $unSignParaString = $commonUtil->formatQueryParaMap($obj, false);
            $paraString       = $commonUtil->formatQueryParaMap($obj, true);

            return sha1($paraString);

        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }

    }
    //客服功能 向购买支付成功的用户发送信息
    /*  function kefu_response($userOpenID,$content){
          $txt = '{
              "touser":"'.$userOpenID.'",
              "msgtype":"text",
              "text":
              {
                   "content":"'.$content.'"
              }
          }';

          $access_token = $this->access_token();
          $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
          $obj = $this->https_post($url,$txt);
          $obj = json_decode($obj);
          return $obj->errmsg;
      }
      //* 向远程网址发送POST信息*

      function https_post($url,$data)
      {
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          $result = curl_exec($curl);
          if (curl_errno($curl)) {
             return 'Errno'.curl_error($curl);
          }
          curl_close($curl);
          return $result;
      }*/

}

?>