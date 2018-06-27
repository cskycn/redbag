<?php
namespace Common\Common;

/*
 * 现金红包类
 * 红包最小1元
 */
class CupWeixin
{
    public static function  baseInfo()
    {
        $v_configure = M('weixin_configure');
        $res         = $v_configure->order('created_at desc')->find();
        return $res;
    }

    public function getRedBackageInfo($order_no){
        $baseInfo = self::baseInfo();
        $data['mch_id'] = $baseInfo['pay_mchid'];
        $data['mch_billno'] = $order_no;
        $data['nonce_str'] = self::createNoncestr();
        $data['bill_type'] = 'MCHT';
        $data['appid'] = $baseInfo['appid'];
        $xml = self::arrayToXml($data);
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';
        $re = self::wxHttpsRequestPem($xml,$url);
        $rearr = self::xmlToArray($re);
        return  $rearr;
    }

    //发送裂变红包
    public function sendhongbaoto2($openid){
        $baseInfo = self::baseInfo();
        $data['mch_id'] = $baseInfo['pay_mchid'];
        $data['mch_billno'] = $data['mch_id'].date("Ymd",time()).date("His",time()).rand(1111,9999); //随机字符串
        $data['nonce_str'] = self::createNoncestr();
        $data['re_openid'] = $openid;
        $data['wxappid'] = $baseInfo['appid'];
        $data['nick_name'] = '必应智联';//昵称
        $data['send_name'] = '必应智联';//真实姓名
        $data['total_amount'] = 1*100;//红包金额
        $data['min_value'] = 1*100;//在这里要说明一下，微信红包至少1元
        $data['max_value'] = 1*100;
        $data['amt_type'] = 'ALL_RAND';
        $data['total_num'] = 5;//红包数量
        $data['client_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['act_name'] = '测试红包活动';
        $data['remark'] = '快来抢！！！';
        $data['wishing'] = '测试红包功能';
        if(!$data['re_openid']) {
            $rearr['return_msg']='缺少用户openid';
            return $rearr;
        }
        $data['sign'] = self::getSign($data);
        $xml = self::arrayToXml($data);
        $url ="https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack";
        $re = self::wxHttpsRequestPem($xml,$url);
        $rearr = self::xmlToArray($re);
        return  $rearr;
    }

    /**
     * hbname 红包名称
     *  fee 红包金额 /元
     *  body 内容
     *  openid 微信用户id
     * @return
     */
    public function sendhongbaoto($openid,$price){
        $baseInfo = self::baseInfo();
        $data['mch_id'] = $baseInfo['pay_mchid'];//微信商户id</span>
        $data['mch_billno'] = $data['mch_id'].date("Ymd",time()).date("His",time()).rand(1111,9999); //随机字符串
		$data['nonce_str'] = self::createNoncestr();
		$data['re_openid'] = $openid;
		$data['wxappid'] = $baseInfo['appid'];
		$data['nick_name'] = '必应智联';//昵称
		$data['send_name'] = '必应智联';//真实姓名
		$data['total_amount'] = $price*100;//红包金额
		$data['total_num'] = 1;
		$data['client_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['act_name'] = '爱护心肝宝贝';
		$data['remark'] = '爱护心肝宝贝，答题赢666红包，快来领取吧';
		$data['wishing'] = '爱护心肝宝贝，答题赢666红包，快来领取吧';
        $data['scene_id'] = 'PRODUCT_2';
		if(!$data['re_openid']) {
            $rearr['return_msg']='缺少用户openid';
            return $rearr;
        }
		$data['sign'] = self::getSign($data);
		$xml = self::arrayToXml($data);
		$url ="https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";//微信红包发放接口
		$re = self::wxHttpsRequestPem($xml,$url);
		$rearr = self::xmlToArray($re);
		return  $rearr;
	}

    function trimString($value)
    {
        $ret = null;
        if (null != $value)
        {
            $ret = $value;
            if (strlen($ret) == 0)
            {
                $ret = null;
            }
        }
        return $ret;
    }

    public static function rand_price(){
        $price = rand(1,5)/10+1;
        if($price>1.5) $price = 1.5;
        if($price <1) $price = 1;
        return $price;
    }

    /**
     * 	作用：产生随机字符串，不长于32位
     */
    public function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    /**
     * 	作用：格式化参数，签名过程需要使用
     */
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar="";
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }

    /**
     * 	作用：生成签名
     */
    public function getSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String."&key="."Chenlei123QAZXSWedcrfvtgbyhnChen";
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    /**
     * 	作用：array转xml
     */
    public	function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val))
            {
                $xml.="<".$key.">".$val."</".$key.">";

            }
            else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }
    /**
     * 	作用：将xml转为array
     */
    public function xmlToArray($xml)
    {
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }
    /**
     * 微信请求
     * @param  $vars 要发送的数据
     * @param  $url 要请求的url地址
     * @param  $second 超时时间
     * @return 成功、失败
     */
    public function wxHttpsRequestPem( $vars,$url, $second=30,$aHeader=array()){
        $ch = curl_init();//curl初始化
        /* 设置curl参数*/
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$_SERVER['DOCUMENT_ROOT'].'/Public/wxzs_rem/apiclient_cert.pem');
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$_SERVER['DOCUMENT_ROOT'].'/Public/wxzs_rem/apiclient_key.pem');
        curl_setopt($ch,CURLOPT_CAINFO,'PEM');
        curl_setopt($ch,CURLOPT_CAINFO,$_SERVER['DOCUMENT_ROOT'].'/Public/wxzs_rem/rootca.pem');
        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);//执行url请求，发送相应的数据 返回结果
        if($data){
            curl_close($ch);//关闭连接
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }
}
?>