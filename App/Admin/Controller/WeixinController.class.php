<?php

namespace Admin\Controller;

use Common\Common\CupWeixin;
use Common\Weixin\WeiSdk;
use Think\Controller;

class WeixinController extends Controller
{
    private $token = '';
    private $count = 0;

    /**
     * 接口数据入口
     */
    public function index()
    {
        $Baseinfo = CupWeixin::baseInfo();
        if (!$Baseinfo) {
            exit();
        }
        $this->token = trim($Baseinfo['token']);
        $objRes      = $this->getRequest();
        if ($objRes == null) {
            $this->valid();
        } else {
            $this->analysis($objRes, $Baseinfo);
            exit;
        }
    }

    public function valid()
    {
        $echoStr = I("echostr");
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = I("signature");
        $timestamp = I("timestamp");
        $nonce     = I("nonce");

        $token  = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function getRequest()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            return $postObj;
        } else {
            return null;
        }
    }

     /**
     *
     * 网页授权方法
     * 1、获取Code
     * 2、Code换取AccessToken 和对应openId
     * 3、返回当前页面
     */
    public function getAuthor()
    {
        $yUrl = I('y_url');
        $code = I('code');

//        session('lx_openid','oEcX2wfxQ7qlk3gCfcRqUGLENG1c');
//        header('Location:'.$yUrl);
//        die;
        $info = CupWeixin::baseInfo();
        if (!$code) {
            $uri      = urldecode('http://' . $_SERVER['HTTP_HOST'] . '/Admin/Weixin/getAuthor?y_url=' . $yUrl);
            $scope    = 'snsapi_userinfo';  //snsapi_base 不弹出  snsapi_userinfo 弹出
            redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $info['appid'] . '&redirect_uri=' . $uri . '&response_type=code&scope=' . $scope . '&state=123#wechat_redirect');
        } else {
            $http_two = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $info['appid'] . '&secret=' . $info['appscret'] . '&code=' . $code . '&grant_type=authorization_code';
            $res      = $this->http_request_json($http_two);
            $res      = @json_decode($res, true);
            session('yrb_openid', $res['openid']);
            $this->add_fans($res['openid'],$info,$res['access_token']);
            redirect($yUrl);
        }
        exit;
    }

    //授权添加用户数据
    public function  add_fans($openid,$Baseinfo,$sq_token='')
    {
        //判断粉丝是否存在
        $v_fans = M('members');
        $date   = date('Y-m-d H:i:s');
        $weiSdk         = new WeiSdk($Baseinfo['appid'], $Baseinfo['appscret']);
        $res_fans = $v_fans->where("openid='" . $openid . "'")->find();
        if (!$res_fans) {
            $token = $weiSdk->getAccessToken();
            $data   = $this->fansinfo($token, $openid,$sq_token);
            F('aa1',"插入用户信息".$token.'==='.$openid.'==='.json_encode($data));
            $insert = array(
                "created_at"   => $date,
                "openid"       => $openid . "",
                "nick_name"     => $data['nickname'] . "",
                "gender"          => $data['sex'],
                "province"     => $data['province'] . "",
                "avatar_url"   => $data['header_url'] . ""
            );
            $v_fans->add($insert);
        } else {
            if (!$res_fans['nick_name'] || !$res_fans['avatar_url']) {
                $token                = $weiSdk->getAccessToken();
                $data                 = $this->fansinfo($token, $openid,$sq_token);
                F('bb',"更新用户信息".json_encode($data));
                $update['nick_name']   = $data['nickname'];
                $update['gender']        = $data['sex'];
                $update['province']   = $data['province'];
                $update['avatar_url'] = $data['header_url'];
                $v_fans->where('member_id=' . $res_fans['member_id'])->save($update);
            }
        }
    }

    /**
     * 发送文本信息
     */
    public function responseText($toUsername, $fromUsername, $content, $msgType = 'text', $funcFlag = 0)
    {
        $time = time();
        $textTpl
              = "<xml>
					<ToUserName><![CDATA[" . $toUsername . "]]></ToUserName>
					<FromUserName><![CDATA[" . $fromUsername . "]]></FromUserName>
					<CreateTime>" . $time . "</CreateTime>
					<MsgType><![CDATA[" . $msgType . "]]></MsgType>
					<Content><![CDATA[" . $content . "]]></Content>
					<FuncFlag>" . $funcFlag . "</FuncFlag>
					</xml>";

        echo $textTpl;
    }

    /**
     * 发送图文信息
     *  单图文或多图文
     */
    public function responseImage($toUsername, $fromUsername, $arrArticle, $createTime = 0, $msgType = 'news', $funcFlag = 1)
    {
        $textTpl
            = "<xml>
					<ToUserName><![CDATA[" . $toUsername . "]]></ToUserName>
					<FromUserName><![CDATA[" . $fromUsername . "]]></FromUserName>
					<CreateTime>" . time() . "</CreateTime>
					<MsgType><![CDATA[" . $msgType . "]]></MsgType>
					<ArticleCount>" . count($arrArticle) . "</ArticleCount>
						 <Articles>";
        foreach ($arrArticle as $v) {
            $textTpl
                .= "	 <item>
                                         <Title><![CDATA[" . $v['title'] . "]]></Title>
                                         <Description><![CDATA[" . $v['description'] . "]]></Description>
                                         <PicUrl><![CDATA[" . $v['picurl'] . "]]></PicUrl>
                                         <Url><![CDATA[" . $v['url'] . "]]></Url>
                                         </item>";
        }
        $textTpl
            .= "  </Articles>
					<FuncFlag>" . $funcFlag . "</FuncFlag>
					</xml>";
        echo $textTpl;
    }

    /**
     *
     * 发送客服消息
     */
    public function send_kf($toUsername,$content){
        $textTpl = '{
			"touser":"'.$toUsername.'",
			"msgtype":"text",
			"text":{
				"content":"'.$content.'"
			}
		}';

        $configureInfo = $this->BaseInfo();
        $weiSdk         = new WeiSdk($configureInfo['appid'], $configureInfo['appscret']);
        $access_token = $weiSdk->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
        $r=$this->httpPost($url,$textTpl);
        return $r;
    }

    public function httpPost($api_url,$data){
        $context = array('http' => array('method' => "POST", 'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) \r\n Accept: */*", 'content' => $data));
        $stream_context = stream_context_create($context);
        $ret = @file_get_contents($api_url, FALSE, $stream_context);
        return json_decode($ret, true);
    }

    /**
     * 发送客服信息
     */
    public function responseKF($toUsername, $fromUsername, $content)
    {
        $time = time();
        $textTpl
              = "<xml>
					<ToUserName><![CDATA[" . $toUsername . "]]></ToUserName>
					<FromUserName><![CDATA[" . $fromUsername . "]]></FromUserName>
					<CreateTime>" . $time . "</CreateTime>
					<MsgType><![CDATA[transfer_customer_service]]></MsgType>
					</xml>";
        echo $textTpl;
    }

    /**
     * 发送指定客服
     */
    public function responseDKF($toUsername, $fromUsername, $KfAccount)
    {
        $time = time();
        $textTpl
              = "<xml>
                      <ToUserName><![CDATA[" . $toUsername . "]]></ToUserName>
                      <FromUserName><![CDATA[" . $fromUsername . "]]></FromUserName>
                      <CreateTime>" . $time . "</CreateTime>
                      <MsgType><![CDATA[transfer_customer_service]]></MsgType>
						<TransInfo>
							<KfAccount>" . $KfAccount . "</KfAccount>
						</TransInfo>
                  </xml>";
        echo $textTpl;
    }


    /**
     * 解析接口
     */
    public function analysis($objRes, $Baseinfo)
    {
        //解析事件
        switch ($objRes->MsgType) {
            case  'text':
                $this->message($objRes->FromUserName, $objRes->ToUserName, $objRes->Content, 'text', $Baseinfo);
                $this->responseText($objRes->FromUserName, $objRes->ToUserName, '功能尚未开放');
                break;
            case  'image':
                $this->message($objRes->FromUserName, $objRes->ToUserName, $objRes->PicUrl, 'image', $Baseinfo);
                $this->responseText($objRes->FromUserName, $objRes->ToUserName, '功能尚未开放');
                break;
            case  'location':
                $msgJ = array(
                    'Location_X' => $objRes->Location_X . "",
                    'Location_Y' => $objRes->Location_Y . "",
                    'Scale'      => $objRes->Scale . "",
                    'Label'      => $objRes->Label . "",
                );
                $this->message($objRes->FromUserName, $objRes->ToUserName, json_encode($msgJ), 'location', $Baseinfo);
                $this->responseText($objRes->FromUserName, $objRes->ToUserName, '功能尚未开放');
                break;
            case  'event':
                $this->message($objRes->FromUserName, $objRes->ToUserName, $objRes->Event, 'event', $Baseinfo, trim($objRes->EventKey));
                $this->_event($objRes, $Baseinfo);
                break;
        }
    }

    /**
     * event事件
     */
    public function   _event($objRes, $Baseinfo)
    {
        switch ($objRes->Event) {
            case 'VIEW':
                break;
            case 'LOCATION':
                break;
            case 'CLICK':
                break;
            case 'SCAN':
                $this->responseText($objRes->FromUserName, $objRes->ToUserName, '欢迎关注公众号');
                break;
            //关注欢迎信息接口
            case 'subscribe':
                $this->_fans_log($objRes->FromUserName, $objRes->Event, $Baseinfo, trim($objRes->EventKey));
                break;
            case 'unsubscribe':
                $this->cancelWx($objRes->FromUserName);
                break;
        }
    }

    /**
     * 记录用户的行为
     */
    public function message($fromUserName, $toUserName, $messageContent, $msgType, $Baseinfo, $eventKey = '')
    {
        $date      = date('Y-m-d H:i:s');
        $v_message = M('weixin_message');
        $insert    = array(
            'content'      => $messageContent . "",
            'type'         => $msgType,
            'fromUserName' => $fromUserName . "",
            'toUserName'   => $toUserName . "",
            'created_at'   => $date
        );
        $v_message->add($insert);
        $this->_fans_log($fromUserName, $messageContent, $Baseinfo, $eventKey);
    }

    /**
     * 粉丝记录
     */
    public function  _fans_log($fromUserName, $messageContent, $Baseinfo, $eventKey)
    {
        //判断粉丝是否存在
        $v_fans = M('members');
        $date   = date('Y-m-d H:i:s');
        $weiSdk         = new WeiSdk($Baseinfo['appid'], $Baseinfo['appscret']);
        $res_fans = $v_fans->where("openid='" . $fromUserName . "'")->find();
        if (!$res_fans) {
            $token = $weiSdk->getAccessToken();
            $data   = $this->fansinfo($token, $fromUserName);
            $insert = array(
                "created_at"   => $date,
                "openid"       => $fromUserName . "",
                "nick_name"     => $data['nickname'] . "",
                "gender"          => $data['sex'],
                "province"     => $data['province'] . "",
                "avatar_url"   => $data['header_url'] . "",
                "is_attention" => 1 //1、关注 0、取消关注
            );
            $v_fans->add($insert);
        } else {
            if (!$res_fans['nick_name'] || !$res_fans['avatar_url']) {
                $token                = $weiSdk->getAccessToken();
                $data                 = $this->fansinfo($token, $fromUserName);
                $update['nick_name']   = $data['nickname'];
                $update['gender']        = $data['sex'];
                $update['province']   = $data['province'];
                $update['avatar_url'] = $data['header_url'];
            }
            //默认关注
            $update['is_attention'] = 1;
            //解绑
//            if ($messageContent == "unsubscribe") {
//                $update['is_attention'] = 0;
//            }
            $v_fans->where('member_id=' . $res_fans['member_id'])->save($update);
        }
    }

    //取消关注公众号
    public function cancelWx($fromUserName){
        $v_fans = M('members');
        $date   = date('Y-m-d H:i:s');
        $res_fans = $v_fans->where("openid='" . $fromUserName . "'")->find();
        if ($res_fans) {
            if (!$res_fans['nick_name'] || !$res_fans['avatar_url']) {
                $configureInfo = $this->BaseInfo();
                $weiSdk         = new WeiSdk($configureInfo['appid'], $configureInfo['appscret']);
                $token = $weiSdk->getAccessToken();
                $data = $this->fansinfo($token, $fromUserName);
                $update['nick_name'] = $data['nickname'];
                $update['gender'] = $data['sex'];
                $update['province'] = $data['province'];
                $update['avatar_url'] = $data['header_url'];
            }
            $update['is_attention'] = 0;
            $v_fans->where('member_id=' . $res_fans['member_id'])->save($update);
        }
    }

    /**
     * 获取粉丝基本信息
     */
    public function fansinfo($token, $fromUserName,$sq_token='')
    {
        if (!$token) {
            $nickname   = '';
            $sex        = 'no';
            $province   = 'no';
            $header_url = '';
        } else {
            if($sq_token){
                $access_token = $sq_token;
            }else{
                $access_token = $token;
            }
//            $access_token = $token;
            $openid       = $fromUserName;
//            $url          = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
            $url          = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $output       = $this->http_request_json($url);
            $jsoninfo     = @json_decode($output, true);
            F('info',json_encode($jsoninfo).'==='.$url);
            if (is_array($jsoninfo)) {
                $nickname   = $jsoninfo['nickname']?$jsoninfo['nickname']:'';
                $sex        = $jsoninfo['sex']?$jsoninfo['sex']:'no';
                $province   = $jsoninfo['province']?$jsoninfo['province']:'no';
                $header_url = $jsoninfo['headimgurl'];
            } else {
                $nickname   = '';
                $sex        = 'no';
                $province   = 'no';
                $header_url = '';
            }
        }
        $nickname = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $nickname);
        $data['nickname']   = $nickname;
        $data['sex']        = $sex;
        $data['province']   = $province;
        $data['header_url'] = $header_url;
        return $data;
    }

    /**
     *
     * 有的服务器无法使用file_get_contents方法
     */
    public function http_request_json($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
