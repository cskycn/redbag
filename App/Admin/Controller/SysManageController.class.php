<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Common\Controller\CApiResponse;
use Common\Controller\Error;
use Common\Controller\FunMethod;

/**
 * 后台菜单管理
 */
class SysManageController extends AdminBaseController
{
    /**
     * 修改密码
     */
    public function uPwd()
    {
        if (IS_POST) {
            $map = I('post.');
            $passwd = md5($map['passwd']);
            $passwd2 = md5($map['passwd2']);
            $data = M('Admin')->find($map['admin_id']);
            if (empty($data)) {
                $this->error('异常，密码修改失败');
            } else {
                if ($passwd == $data['password']) {
                    if ($data['password'] == $passwd2) {
                        $this->error('操作失败：新密码与原密码相同');
                        die;
                    }
                    $k = D('Admin')->editData(array('admin_id' => $map['admin_id']), array('password' => $passwd2));
                    if ($k >= 0) {
                        $this->success('密码修改成功');
                    } else {
                        $this->error('密码修改失败');
                    }
                } else {
                    $this->error('原密码输入错误');
                }
            }
        } else {
            $result = M('Admin')->where("is_deleted=0 and admin_id=".$this->userId)->find();
            $this->assign('uInfo', $result);
            $this->display();
        }
    }

    /**
     * 修改资料
     */
    public function updateInfo()
    {
        if (IS_POST) {
            $resp = CApiResponse::instance();
            $map = I('post.');
            $data = M('Admin')->find($map['admin_id']);
            if (empty($data)) {
                $resp->setCode(300,'异常，资料修改失败');
                $resp->pack();
            } else {
                if (empty($map['header_url'])) {
                    unset($map['header_url']);
                }
                $k = D('Admin')->editData(array('admin_id' => $map['admin_id']), $map);
                if ($k >= 0) {
                    if (isset($map['header_url'])) {
                        $_SESSION['user']['uHeaderUrl'] = FunMethod::filterHeaderUrl($map['header_url']);
                    }
                    $_SESSION['user']['name'] = $map['name'];
                    $_SESSION['user']['nickname'] = $map['nickname'];
                    $resp->pack();
                } else {
                    $resp->setCode(301,'操作失败');
                    $resp->pack();
                }
            }
        } else {
            $result = M('Admin')->where("is_deleted=0 and admin_id=".$this->userId)->find();
            $result['header_url'] = FunMethod::filterHeaderUrl($result['header_url']);
            $this->assign('uInfo', $result);
            $this->display();
        }
    }
}
