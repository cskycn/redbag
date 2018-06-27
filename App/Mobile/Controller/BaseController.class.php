<?php
namespace Mobile\Controller;

use Think\Controller;

class BaseController extends Controller{
    public $openid;

    function __construct()
    {
        parent::__construct();
        $this->openid = session('yrb_openid');
        F('aaa',$this->openid);
        if(empty($this->openid)){
            $y_url = 'http://' . $_SERVER['HTTP_HOST'] . '/Mobile';
            if(ACTION_NAME == 'result'){
                $y_url = 'http://' . $_SERVER['HTTP_HOST'] . '/Mobile/Index/result';
            }
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/Admin/Weixin/getAuthor?y_url='.$y_url;
            header('Location:'.$url);
            die;
        }
    }

    public function getUserInfo(){
        $info = M("members")->where(['openid'=>$this->openid])->find();
        if(empty($info['avatar_url'])){
            $info['avatar_url'] =  'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
        }
        return $info;
    }
}