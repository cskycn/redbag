<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Common\Controller\CApiResponse;
use Common\Controller\Error;
use Common\Controller\FunMethod;


class ManageUserController extends AdminBaseController
{
    public function index(){
        $data = D('Admin')->getPage(M('admin'),array('is_deleted'=>0),'register_time desc');
        $this->assign('ulist',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('now_page',$data['nowPage']);
        $this->display();
    }

    public function add(){
        if(IS_POST){
            $data = I('post.');
            $data['is_deleted'] = 0;
            $password = $data['password'];
            $data['password'] = md5($password);
            $time = date('Y-m-d H:i:s');
            $data['register_time'] = $time;
            $data['login_ip'] = FunMethod::getIP();
            $data['name'] = $data['tel'];
            $result = D('Admin')->addData($data);
            if ($result) {
                $this->success('操作成功', U('Admin/ManageUser/index'));
            } else {
                $this->error('操作失败', U('Admin/ManageUser/index'));
            }
        }
    }

    public function edit(){
        if(IS_POST){
            $data = I('post.');
            $id = I('admin_id');
            if(empty($data['password'])){
                unset($data['password']);
            }else{
                $password = $data['password'];
                $data['password'] = md5($password);
            }
            $data['name'] = $data['tel'];
            $result = D('Admin')->editData(array('admin_id'=>$id),$data);
            if ($result) {
                $this->success('操作成功', U('Admin/ManageUser/index'));
            } else {
                $this->error('操作失败', U('Admin/ManageUser/index'));
            }
        }
    }

    public function delete(){
        $id=I('get.id');
        $nowPage = I('get.now_page');
        $map=array(
            'admin_id'=>$id
        );
        $result=D('admin')->deleteData($map);
        if($result){
            $this->success('操作成功',U('Admin/ManageUser/index',array('p'=>$nowPage)));
        }else{
            $this->error('操作失败', U('Admin/ManageUser/index'));
        }
    }
}
