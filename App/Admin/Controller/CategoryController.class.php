<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Common\Controller\CApiResponse;
use Common\Controller\Error;
use Common\Controller\FunMethod;


class CategoryController extends AdminBaseController
{
    public function index(){
        $data = D('Category')->getPage(M('Category'),array('is_deleted'=>0),'pid asc,sort asc');
        foreach($data['data'] as $key=>$value){
            // $shareImgUrl = FunMethod::resizeImgFixed($_SERVER['DOCUMENT_ROOT'].$value['icon'],80,80);
            // $list[$key]['icon'] = 'http://'.$_SERVER['HTTP_HOST'].$shareImgUrl;
            $list[$key]['icon'] = 'http://'.$_SERVER['HTTP_HOST'].$value['icon'];
        }
        $this->assign('ulist',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('now_page',$data['nowPage']);
        $this->display();
    }

    public function getCategoryList(){
        $resp = CApiResponse::instance();
        $list = M("category")->where("pid=0 and is_deleted=0")->field("id,name,pid")->select();
        if($list){
            $resp->setData($list);
        }else{
            $resp->setCode(Error::ERR_RECODE_NOT_FOUND_ERROR);
        }
        $resp->pack();
    }

    public function add(){
        if(IS_POST){
            $data = I('post.');
            $data['is_deleted'] = 0;
            $time = date('Y-m-d H:i:s');
            $data['created_at'] = $time;

            $result = D('Category')->addData($data);
            if ($result) {
                $this->success('操作成功', U('Admin/Category/index'));
            } else {
                $this->error('操作失败');
            }
        }
    }

    public function edit(){
        if(IS_POST){
            $data = I('post.');
            $id = I('id');
            $result = D('Category')->editData(array('id'=>$id),$data);
            if ($result) {
                $this->success('操作成功', U('Admin/Category/index'));
            } else {
                $this->error('操作失败');
            }
        }
    }

    public function delete(){
        $id=I('get.id');
        $nowPage = I('get.now_page');
        $map=array(
            'id'=>$id
        );
        $num = M("category")->where("is_deleted=0 and pid=".$id)->count();
        if($num==0){
            $result=D('Category')->deleteData($map);
            if($result){
                $this->success('操作成功',U('Admin/Category/index',array('p'=>$nowPage)));
            }else{
                $this->error('操作失败',U('Admin/Category/index'));
            }
        }else{
            $this->success('操作失败，该分类下不为空',U('Admin/Category/index',array('p'=>$nowPage)));
        }
    }
}
