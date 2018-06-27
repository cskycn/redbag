<?php
namespace Mobile\Controller;

use Common\Common\CupWeixin;
use Common\Controller\CApiResponse;
use Common\Controller\Error;
use Common\Weixin\WeiSdk;
use Think\Exception;

class IndexController extends BaseController{
    public function index(){
        $ymemberid = I('ac');
        $memberInfo = $this->getUserInfo();
        if($ymemberid){
//            //进入邀请加分环节
            if(empty($memberInfo['pid']) && $ymemberid != $memberInfo['member_id']){
                //标注被邀请用户
                M("members")->where(['member_id'=>$memberInfo['member_id']])->save(['pid'=>$ymemberid]);
                F('jjf_bz',M()->getLastSql());
                //加积分
                $update = [];
                $update['score'] = array('exp',"score + 3");
                M("members")->where(['member_id'=>$ymemberid])->save($update);
                F('jjf',M()->getLastSql());
            }
        }

        $httphost = 'http://'.$_SERVER['HTTP_HOST'];
        $http_url = $httphost.'/Mobile/Index/index/ac/'.$memberInfo['member_id'];
        $http_img_url = $httphost.'/Public/images/logo3.png';
//        $remark = '爱护心肝宝贝，答题赢666红包，快来领取吧';
//        $title = '爱护心肝宝贝';
        $configureInfo = CupWeixin::baseInfo();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $jssdk         = new WeiSdk($configureInfo['appid'], $configureInfo['appscret'], $url);
        $signPackage   = $jssdk->GetSignPackage();
        $isover = $this->isOver();
        $this->assign('isover',$isover);
        $this->assign('jsonData',json_encode($signPackage));
        $this->assign('http_url',$http_url);

        $this->assign('http_img_url',$http_img_url);
//        $this->assign('remark',$remark);
//        $this->assign('title',$title);
//        $this->display();
        $this->display('redrule');
    }

    public function isOver($type=0){
        //判断活动是否结束
        $isover = 0;
        $nowtime = time();
        $start_time = strtotime('2018-03-16');
        $stop_time = strtotime('2018-03-19');
        if($nowtime>$start_time && $nowtime<$stop_time){
            $isover = 0;
        }
        if($type == 0){
            return $isover;
        }else{
            if($isover == 0){
                header("Location:http://".$_SERVER['HTTP_HOST'].'/Mobile');
                exit();
            }
        }
    }

    public function subjectList(){
        $page = I('page');
        $limit = 1;
        $page = $page == 0 ? 1 : $page;
        $this->isOver(1);
        $memberInfo = $this->getUserInfo();
        $recordInfo = M("subject_answer")->where("member_id=" . $memberInfo['member_id'])->find();

        if ($recordInfo) {
            $page = $recordInfo['wcnum'] + 1;
        }

        $page_first_row = ($page - 1) * $limit;
        $page_list_row = $limit;
        $countNum = M("subject")->where("is_deleted=0")->count();
        if(($page-1) == $countNum){
            header("Location:http://".$_SERVER['HTTP_HOST'].'/Mobile/Index/result_share');
            exit();
        }
        $countPage = ceil($countNum / $limit);
        $page = $page+1;
        $list = M("subject")->where("is_deleted=0")->order("order asc")->limit($page_first_row . ',' . $page_list_row)->select();
        foreach($list as $key=>&$value){
            $optionlist = M("subject_option")->where(['subject_id'=>$value['subject_id'],'is_deleted'=>0])->select();
            $value['optionList'] = $optionlist;
        }
        $isover = 0;
        if(($page-1) == $countPage){
            $isover = 1;
        }
        $memberInfo = $this->getUserInfo();

        $httphost = 'http://'.$_SERVER['HTTP_HOST'];
        $http_url = $httphost.'/Mobile/Index/index/ac/'.$memberInfo['member_id'];
        $http_img_url = $httphost.'/Public/images/logo3.png';
  //      $remark = '爱护心肝宝贝，答题赢666红包，快来领取吧';
  //      $title = '爱护心肝宝贝';
        $configureInfo = CupWeixin::baseInfo();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $jssdk         = new WeiSdk($configureInfo['appid'], $configureInfo['appscret'], $url);
        $signPackage   = $jssdk->GetSignPackage();
        
        $this->assign('jsonData',json_encode($signPackage));
        $this->assign('http_url',$http_url);
        $this->assign('http_img_url',$http_img_url);
 //       $this->assign('remark',$remark);
 //       $this->assign('title',$title);

        $this->assign('isover',$isover);
        $this->assign('currentPage',$page);
        $this->assign('countPage',$countPage);
        $this->assign('list',$list);
        $this->assign('memberInfo',$memberInfo);
        $this->display('subject');
    }

    public function doSubject()
    {
        $answer = I('answer');
        $subid = I('subid');
        $resp = CApiResponse::instance();
        if (empty($answer) || empty($subid)) {
            $resp->setCode(Error::ERR_MISS_PARAMETERS);
            $resp->pack();
        }
        $model = M();
        $model->startTrans();
        try {
            $options = array();
            $options['subid'] = $subid;
            $options['option'] = $answer;
            $time = date("Y-m-d H:i:s");
            $optionInfo = M("subject_option")->where("is_deleted=0 and subject_id=" . $subid . " and is_true=1")->find();
            if ($optionInfo && $optionInfo['subject_option_id'] == $answer) {
                $options['is_true'] = 1;
                $options['score'] = 5;
            } else if ($optionInfo && $optionInfo['option'] != $answer) {
                $options['is_true'] = 0;
                $options['score'] = 0;
            } else {
                $resp->setCode(Error::ERR_GENERAL);
                $resp->pack();
            }
            $memberInfo = $this->getUserInfo();
            $recordInfo = M("subject_answer")->where(['member_id'=>$memberInfo['member_id']])->find();
            if ($recordInfo) {
                //更新答题
                $update = array();
                $yoption = json_decode($recordInfo['options'], true);
                $iex = false;
                foreach($yoption as $k=>$v){
                    if($v['subid'] == $options['subid']){
                        $iex = true;
                        break;
                    }
                }
                if($iex){
                    $resp->pack();
                }
                $yoption[count($yoption)] = $options;
                $update['options'] = json_encode($yoption);
                $update['wcnum'] = $recordInfo['wcnum'] + 1;
                $update['score'] = $recordInfo['score'] + $options['score'];
                $answer = $model->table("red_subject_answer")->where('answer_id=' . $recordInfo['answer_id'])->save($update);
            } else {
                //首次答题入库
                $insert = array();
                $insert['created_at'] = $time;
                $insert['member_id'] = $memberInfo['member_id'];
                $insert['options'] = json_encode(array($options));
                $insert['score'] = $options['score'];
                $insert['subject_id'] = $subid;
                $insert['wcnum'] = 1;
                $answer = $model->table("red_subject_answer")->add($insert);
            }

            if (!$answer) {
                $model->rollback();
                $resp->setCode(Error::ERR_FATAL);
                $resp->pack();
            }
            if($options['is_true'] ==1){
                //加积分
                $up = [];
                $up['score'] = array('exp',"score + 5");
                M("members")->where(['member_id'=>$memberInfo['member_id']])->save($up);
            }
            $model->commit();
            $resp->pack();
        } catch (Exception $e) {
            $model->rollback();
            $resp->setCode(Error::ERR_FATAL);
            $resp->pack();
        }
    }

    public function result(){
        $configureInfo = CupWeixin::baseInfo();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $jssdk         = new WeiSdk($configureInfo['appid'], $configureInfo['appscret'], $url);
        $signPackage   = $jssdk->GetSignPackage();
        $memberInfo = $this->getUserInfo();
        $httphost = 'http://'.$_SERVER['HTTP_HOST'];
        $http_url = $httphost.'/Mobile/Index/index/ac/'.$memberInfo['member_id'];
        $http_img_url = $httphost.'/Public/images/logo3.png';
//        $remark = '爱护心肝宝贝，答题赢666红包，快来领取吧';
//        $title = '爱护心肝宝贝';

        $pmList = M("members")->where("score>0")->order("score desc,register_time asc")->limit("0,10")->field("avatar_url,nick_name,score,member_id,register_time")->select();
        foreach($pmList as $key=>&$value){
//            $value['pm'] = $key+1;
            $rank1 = $this->getRank($value['member_id'],$value['score']);
            $value['pm'] = $rank1;
            if(empty($value['avatar_url'])){
                $value['avatar_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
            }
        }

        if(empty($memberInfo['avatar_url'])){
            $memberInfo['avatar_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
        }

        $countNum = M("members")->where("score>0")->count();
        $countPage =  ceil($countNum / 10);
        $rank = $this->getRank($memberInfo['member_id'],$memberInfo['score']);
        $isover = $this->isOver();
        $this->assign('isover',$isover);
        $this->assign('rank',$rank);
        $this->assign('jsonData',json_encode($signPackage));
        $this->assign('http_url',$http_url);
        $this->assign('http_img_url',$http_img_url);
 //       $this->assign('remark',$remark);
 //       $this->assign('title',$title);
        $this->assign('pmList',$pmList);
        $this->assign('memberinfo',$memberInfo);
        $this->assign('count_page',$countPage);
        $this->assign('current_page',2);
        $this->display('paiming');
    }

    public function result2(){
        
        $configureInfo = CupWeixin::baseInfo();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $jssdk         = new WeiSdk($configureInfo['appid'], $configureInfo['appscret'], $url);
        $signPackage   = $jssdk->GetSignPackage();
        $memberInfo = $this->getUserInfo();
        $httphost = 'http://'.$_SERVER['HTTP_HOST'];
        $http_url = $httphost.'/Mobile/Index/index/ac/'.$memberInfo['member_id'];
        $http_img_url = $httphost.'/Public/images/logo3.png';
//        $remark = '爱护心肝宝贝，答题赢666红包，快来领取吧';
 //       $title = '爱护心肝宝贝';
//        $rank1 = $this->getRank(519,45);
//        echo $rank1;die;
        $pmList = M("members")->where("score>0")->order("score desc,register_time asc")->limit("0,10")->field("avatar_url,nick_name,score,member_id,register_time")->select();
        foreach($pmList as $key=>&$value){
//            $value['pm'] = $key+1;
            $rank1 = $this->getRank($value['member_id'],$value['score']);

            //根据积分总额倒推计算分享人数
            $value['share'] = intval(($value['score'] - 5) / 3);
            $value['pm'] = $rank1;
            if(empty($value['avatar_url'])){
                $value['avatar_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
            }
        }

        if(empty($memberInfo['avatar_url'])){
            $memberInfo['avatar_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
        }

        $countNum = M("members")->where("score>0")->count();
        $countPage =  ceil($countNum / 10);
        $rank = $this->getRank($memberInfo['member_id'],$memberInfo['score']);
        $isred = 0;
        
        if($rank<=10000){
            //获取到红包
            $isred = 1;
        }
        $lqlog = M("log")->where(['member_id' => $memberInfo['member_id']])->find();
        if ($lqlog) {
            //红包已领取
            $isred = 2;
        }
        if($memberInfo['score']<=0){
            $isred = 0;
        }

        
        $isover = $this->isOver();
        $this->assign('isover',$isover);
        $this->assign('isred',$isred);
        $this->assign('rank',$rank);
        $this->assign('jsonData',json_encode($signPackage));
        $this->assign('http_url',$http_url);
        $this->assign('http_img_url',$http_img_url);
 //       $this->assign('remark',$remark);
 //       $this->assign('title',$title);
        $this->assign('pmList',$pmList);
        $this->assign('memberinfo',$memberInfo);
        $this->assign('count_page',$countPage);
        $this->assign('current_page',2);
        $this->display('paiming2');
    }
    public function result_share(){
        $configureInfo = CupWeixin::baseInfo();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $jssdk         = new WeiSdk($configureInfo['appid'], $configureInfo['appscret'], $url);
        $signPackage   = $jssdk->GetSignPackage();
        $memberInfo = $this->getUserInfo();
        $httphost = 'http://'.$_SERVER['HTTP_HOST'];
        $http_url = $httphost.'/Mobile/Index/index/ac/'.$memberInfo['member_id'];
        $http_img_url = $httphost.'/Public/images/logo3.png';
//        $remark = '爱护心肝宝贝，答题赢666红包，快来领取吧';
//        $title = '爱护心肝宝贝';

        

//        $pmList = M("members")->order("score desc")->limit("0,10")->field("avatar_url,nick_name,score,member_id")->select();
//        foreach($pmList as $key=>&$value){
//            $value['pm'] = $key+1;
//            if(empty($value['avatar_url'])){
//                $value['avatar_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
//            }
//        }
//        $countNum = M("members")->where("1=1")->count();
//        $countPage =  ceil($countNum / 10);

        $rank = $this->getRank($memberInfo['member_id'],$memberInfo['score']);
        if(empty($memberInfo['avatar_url'])){
            $memberInfo['avatar_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
        }
        
        $isover = $this->isOver();

        $this->assign('isover',$isover);
        $this->assign('jsonData',json_encode($signPackage));
        $this->assign('http_url',$http_url);
        $this->assign('http_img_url',$http_img_url);
//        $this->assign('remark',$remark);
//        $this->assign('title',$title);
        $this->assign('rank',$rank);
//        $this->assign('pmList',$pmList);
        $this->assign('memberinfo',$memberInfo);
//        $this->assign('count_page',$countPage);
//        $this->assign('current_page',2);
        $this->display('result');
    }

    public function getRank($member_id,$score){
        $rank = M("members")->where("score>".$score)->count();
        $rank2 = M("members")->where("score=".$score)->order("register_time asc")->select();

        foreach($rank2 as $key=>$value){
            if($value['member_id'] == $member_id){
                $rank = $rank+$key+1;
                break;
            }
        }
        return $rank;
    }

    public function getList(){
        $resp = CApiResponse::instance();
        $limit = 10;
        $page = I('page');
        $page = $page <2 ? 2 : $page;
        $page_first_row = ($page - 1) * $limit;
        $page_list_row = $limit;
        $result = array();
        $countNum = M("members")->where("score>0")->count();
        $result['countPage'] = ceil($countNum / $limit);
        $result['currentPage'] = $page+1;
        $list = M("members")->where("score>0")->order("score desc,register_time asc")->limit($page_first_row . ',' . $page_list_row)->field("avatar_url,nick_name,score,member_id,register_time")->select();
        if($list){
            foreach($list as $key=>&$value){
//                $value['pm'] = $page_first_row+$key+1;
                $rank1 = $this->getRank($value['member_id'],$value['score']);
                $value['pm'] = $rank1;
                if(empty($value['avatar_url'])){
                    $value['avatar_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/images/logo2.jpg';
                }
            }
            $result['list'] = $list;
            $resp->setData($result);
        }else{
            $resp->setCode(Error::ERR_RECODE_NOT_FOUND_ERROR);
        }
        $resp->pack();
    }

    public function redRule(){
        $this->display('redrule');
    }

    //领取红包
    public function getRedPackage(){
        $resp = CApiResponse::instance();
        $mid = I("mid");
        $tel = I("tel");
        $code = I("code");

        if($this->checkMsgCode($tel,$code)){
            try {
                $memberInfo = $this->getUserInfo();
                if($mid != $memberInfo['member_id']){
                    $resp->setCode(104,'用户异常，无法领取');
                    $resp->pack();
                }
                if($memberInfo['score'] <=0){
                    $resp->setCode(102,'尚未获得红包');
                    $resp->pack();
                }
                $lqlog = M("log")->where(['member_id' => $memberInfo['member_id']])->find();
                if (!$lqlog&&$memberInfo['score']>0) {
                    $cupObj = new CupWeixin();
                    //获取用户排名
                    $rank = $this->getRank($memberInfo['member_id'], $memberInfo['score']);
                    $r_price = $this->rank_price($rank);
                    if ($r_price > 0) {
                        if($r_price >100){
                            //三次发送666
                            $res1 = $cupObj->sendhongbaoto($this->openid, 200);
                            F('lq1_'.$memberInfo['member_id'].'_'.time(), '领取人Openid：'.$this->openid.' 红包金额：200 返回值：'.json_encode($res1, JSON_UNESCAPED_UNICODE));
                            if ($res1 && $res1['result_code'] == 'SUCCESS') {
                                //红包发送成功
                                $price1 = $res1['total_amount'] / 100;
                                M("log")->add(['member_id' => $memberInfo['member_id'], 'price' => $price1]);
                            }
    
                            $res2 = $cupObj->sendhongbaoto($this->openid, 200);
                            F('lq2_'.$memberInfo['member_id'].'_'.time(), '领取人Openid：'.$this->openid.' 红包金额：200 返回值：'.json_encode($res1, JSON_UNESCAPED_UNICODE));
                            if ($res2 && $res2['result_code'] == 'SUCCESS') {
                                //红包发送成功
                                $price2 = $res2['total_amount'] / 100;
                                M("log")->add(['member_id' => $memberInfo['member_id'], 'price' => $price2]);
                            }
                            $res3 = $cupObj->sendhongbaoto($this->openid, 200);
                            F('lq3_'.$memberInfo['member_id'].'_'.time(), '领取人Openid：'.$this->openid.' 红包金额：200 返回值：'.json_encode($res1, JSON_UNESCAPED_UNICODE));
                            if ($res3 && $res3['result_code'] == 'SUCCESS') {
                                //红包发送成功
                                $price3 = $res3['total_amount'] / 100;
                                M("log")->add(['member_id' => $memberInfo['member_id'], 'price' => $price3]);
                            }
                            $res4 = $cupObj->sendhongbaoto($this->openid, 66);
                            F('lq4_'.$memberInfo['member_id'].'_'.time(), '领取人Openid：'.$this->openid.' 红包金额：66 返回值：'.json_encode($res1, JSON_UNESCAPED_UNICODE));
                            if ($res4 && $res4['result_code'] == 'SUCCESS') {
                                //红包发送成功
                                $price4 = $res4['total_amount'] / 100;
                                M("log")->add(['member_id' => $memberInfo['member_id'], 'price' => $price4]);
                            }
    
                            if (($res1 && $res1['result_code'] == 'SUCCESS')||($res2 && $res2['result_code'] == 'SUCCESS')||($res3 && $res3['result_code'] == 'SUCCESS')||($res4 && $res4['result_code'] == 'SUCCESS')) {
    
                            }else{
                                $resp->setCode(102,'红包领取失败');
                            }
    
                        }else{
                            $res = $cupObj->sendhongbaoto($this->openid, $r_price);
                            F('lq' .time(), '领取人Openid：'.$this->openid.' 红包金额：'.$r_price.' 返回值：'.json_encode($res, JSON_UNESCAPED_UNICODE));
                            if ($res && $res['result_code'] == 'SUCCESS') {
                                //红包发送成功
                                $price = $res['total_amount'] / 100;
                                M("log")->add(['member_id' => $memberInfo['member_id'], 'price' => $price]);
                            }else{
                                $resp->setCode(102,'红包领取失败');
                            }
                        }
                    }else{
                        $resp->setCode(102,'尚未获得红包');
                    }
                }else{
                    $resp->setCode(103,'已领取过红包');
                }
            }catch(Exception $e){
                $resp->setCode(101,'领取红包异常');
                F('red_throw_exception',$e->getMessage());
            }
        }else{
            $resp->setCode(105,'短信验证码错误');
        }
        $resp->pack();
    }

    public function rank_price($rank){
        $price = 0;
        if($rank>=1&&$rank<=10){
            $price = 666;
        }else if($rank>10&&$rank<=30){
            $price = 66;
        }else if($rank>30&&$rank<=330){
            $price = 6;
        }else  if($rank>330&&$rank<=10000){
            //1-1.5元随机
            $price = CupWeixin::rand_price();
        }
        return $price;
    }

    //***************************
    //  判断短信验证码对不对
    //***************************
    public function checkMsgCode($tel,$code){
        $check = S('sms_' . $tel);
        if (!$check ){ 
            return false;
        }
        if($check == trim($code)){
            return true;
        }
        return false;
    }


    //***************************
    //  发起短信请求
    //***************************
    public function sendSMStoUser(){
        
        $appid = '1400106639';
        $appkey = '3351ebe86c92366da89563861f145293';
        $country_prefix = '86';
        $templId = '128306';  //短信模板的ID


        $phone = I('request.phone');
      //  $userID = I('request.user_id');
    
        //S('sms_'.$phone,null);
        if(!$phone || !$this->checkSmsCode($phone)) { //短信验证码限定时间内
            $resp->setCode(301,'发送短信太频繁或错误');
            $resp->pack();
            exit();
        }

        $code = $this->createSMSCode();

        try {
            Vendor('Sms/SmsSenderUtil');
            Vendor('Sms/SmsSingleSender');

            $sender = new \Qcloud\Sms\SmsSingleSender($appid, $appkey);
            $params = [$code];
            $result = $sender->sendWithParam($country_prefix, $phone, $templId,$params, "");
            $result = json_decode($result,true);
            
            $data["mobile"] = $phone;
            $data["code"] = $code;
            $data["time"] = time();

            if($result["result"] == 0){
                $this->setSmsCache($data);
                $resp->setCode(200,'短信发送成功');
                $resp->pack();
                exit();
            }else{
                $resp->setCode(302,'短信发送失败');
                $resp->pack();
                exit();
            }
        } 
        catch(\Exception $e) { 
            return false;
        }
    }


    //***************************
    //  生成短信验证码
    //***************************
    public function createSMSCode($length = 4){
        $min = pow(10 , ($length - 1));
        $max = pow(10, $length) - 1;
        return rand($min, $max);
    }

    //***************************
    //  检测手机短信验证码是否发送过
    //***************************
    protected function checkSmsCode($mobile){
        if (!$mobile) {
            return false;
        }

        //没有缓存记录，之前没发过
        if (!S('sms_' . $mobile) ){ 
            return true;
        }

        //缓存记录超过60s
        $tmp = S('sms_' . $mobile);
        $gap = time() - (int)$tmp["time"];
        if($gap >= 60){
            return true;
        }   
        return false;

    }

    //***************************
    //  设置手机短息验证码缓存
    //***************************
    protected function setSmsCache($data_cache){

        $lifetime = 1800;
        //Cache::set
        S('sms_' . $data_cache['mobile'], $data_cache, $lifetime);
    }
}
