<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Common\Controller\CApiResponse;
use Common\Controller\Error;
use Common\Controller\FunMethod;


class CommentController extends AdminBaseController
{
    public function index(){
//        $citys = M("province_city_area")->where("pid=0")->select();
        $data = D('Members')->getPage(M('members'),array('is_deleted'=>0),'register_time desc');
        $this->assign('ulist',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('now_page',$data['nowPage']);
//        $this->assign('citys',$citys);
        $this->display();
    }

    public function getRtj(){
        $resp = CApiResponse::instance();
        $mid = I('mid');
        $data = M('Members')->where("is_deleted=0 and pid=".$mid)->order("register_time desc")->select();
        $resp->setData($data);
        $resp->pack();
    }

    public function dosearch(){
        $citys = M("province_city_area")->where("pid=0")->select();
        $tel = I('tel');
        if(empty($tel)){
            $sdata = array('is_deleted'=>0);
        }else{
            $sdata = array('is_deleted'=>0,'tel'=>array('like','%'.$tel.'%'));
        }
        $data = D('Members')->getPage(M('members'),$sdata);
        $this->assign('ulist',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('now_page',$data['nowPage']);
        $this->assign('stel',$tel);
        $this->assign('citys',$citys);
        $this->display('index');
    }

    public function setUserType(){
        $type = I('type')||0;
        $mid = I('mid');
        $update = M("members")->where("member_id=".$mid)->save(array('type'=>$type));
        if ($update>=0) {
            $this->success('操作成功', U('Admin/Member/index'));
        } else {
            $this->error('操作失败');
        }
    }

    public function add(){
        if(IS_POST){
            $data = I('post.');
            $data['is_deleted'] = 0;
            $birthdaydate = substr($data['birthday'],5);
            $constellationInfo = M("constellation")->where("start_time>='".$birthdaydate."' and stop_time<='".$birthdaydate."'")->field("name")->find();
            if($constellationInfo){
                $data['constellation'] = $constellationInfo['name'];
            }
            $password = $data['password'];
            $data['password'] = md5($password);
            $time = date('Y-m-d H:i:s');
            $data['register_time'] = $time;
            $data['register_ip'] = FunMethod::getIP();

            $result = D('Members')->addData($data);
            if ($result) {
                $this->success('操作成功', U('Admin/Member/index'));
            } else {
                $this->error('操作失败');
            }
        }
    }

    /**
     * 删除菜单
     */
    public function delete(){
        $id=I('get.id');
        $nowPage = I('get.now_page');
        $map=array(
            'member_id'=>$id
        );
        $result=D('Members')->deleteData($map);
        if($result){
            $this->success('操作成功',U('Admin/Member/index',array('p'=>$nowPage)));
        }else{
            $this->error('操作失败');
        }
    }
    public function batchDelete(){
        $ids=I('members');
        $nowPage = I('now_page');
        $map=array(
            'member_id'=>array('in',$ids)
        );
        $result=D('Members')->editData($map,array('is_deleted'=>1));
        if($result){
            $this->success('操作成功',U('Admin/Member/index',array('p'=>$nowPage)));
        }else{
            $this->error('操作失败');
        }
    }

    public function Frozen(){
        $id=I('get.id');
        $nowPage = I('get.now_page');
        $map=array(
            'member_id'=>$id
        );

        $result=D('Members')->editData($map,array('is_forbid'=>1));
        if($result){
            $this->success('操作成功',U('Admin/Member/index',array('p'=>$nowPage)));
        }else{
            $this->error('操作失败');
        }
    }

    public function Thaw(){
        $id=I('get.id');
        $nowPage = I('get.now_page');
        $map=array(
            'member_id'=>$id
        );
        $result=D('Members')->editData($map,array('is_forbid'=>0));
        if($result){
            $this->success('操作成功',U('Admin/Member/index',array('p'=>$nowPage)));
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * 城市列表
     */
    public function getCity()
    {
        $provinceId = I('provinceId');
        $resp = CApiResponse::instance();
        if (empty($provinceId)) {
            $resp->setCode(Error::ERR_MISS_PARAMETERS);
            $resp->pack();
        }
        $data = M("province_city_area")->where("pid=".$provinceId)->select();
        if ($data) {
            $resp->setData($data);
        } else {
            $resp->setCode(Error::ERR_GENERAL);
        }
        $resp->pack();
    }
}
