<?php
namespace Common\Controller;

use Common\Aes\WxCrypt;
use Common\Controller\BaseController;
use Common\Controller\CApiResponse;
use Common\Controller\Error;
use Common\Controller\AesSecurity;
use Common\Service\HttpService;

/**
 * Home基类控制器
 */
class ApiBaseController extends BaseController
{
    public $userId = '';
    public $sexArr = array('男', '女');
    public $appid = 'wx879ab6c47794a3cd';
    public $secret = 'e158a279bd678b17e8848a885e647eed';

    /**
     * 初始化方法
     */
    public function _initialize()
    {
        parent::_initialize();
    }

    //解析用户信息
    public function AnalysisUserData($sessionKey,$iv,$encryptedData){
        $data = array();
//        $sessionKey = session('appletInfo');
//        F('sss',json_encode($sessionKey));
        $pc = new WxCrypt($this->appid,$sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
      
        return $data;
    }

    //获取OpenId
    public function GetAppletOpenId($code){
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$this->appid.'&secret='.$this->secret.'&js_code='.$code.'&grant_type=authorization_code';
        $data = HttpService::httpGet($url);
        return $data;
    }
}

