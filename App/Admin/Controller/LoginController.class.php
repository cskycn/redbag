<?php
namespace Admin\Controller;

use Common\Controller\CApiResponse;
use Common\Controller\FunMethod;
use Think\Controller;
use Think\Verify;

/**
 * 后台首页控制器
 */
class LoginController extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
        if (IS_POST) {
            // 做一个简单的登录 组合where数组条件

            $map = I('post.');
            $map['is_deleted'] = 0;
            $remember = $map['remember'];
            $password = md5($map['passwd']);

       
            $data = M('Admin')->where(array('name'=>$map['tel']))->find();

            if (empty($data)) {
                $this->error('该账号未注册');
            }else if ($data['password'] != $password) {
                $this->error('密码输入错误');
            } else {
                if ($remember == 'on') {
                    cookie('remember', $remember, 3600 * 24);
                    cookie('uname', $data['name'], 3600 * 24);
                } else {
                    cookie('remember', null);
                    cookie('uname', null);
                }
                $_SESSION['user'] = array(
                    'uid' => $data['admin_id'],
                    'name' => $data['name']
                );

                $this->redirect(U('Admin/Index/index'));
            }
        } else {
            $data = FunMethod::check_login() ? $_SESSION['user']['tel'] . '已登录' : '未登录';
            if (FunMethod::check_login()) {
                $this->redirect('Admin/Index/index');
                die;
            }
            $assign = array(
                'data' => $data
            );
            $this->assign($assign);
            $this->display();
        }
    }

    /**
     * 退出
     */
    public function logout()
    {
        session('user', null);
        $this->redirect(U('Admin/Login/index'));
    }

    public function verify()
    {
        $Verify = new Verify();
        ob_clean();
        $Verify->entry();
    }

    public function check_verify()
    {
        $code = I('code', '', 'trim');
        $verify = new Verify();
        $resp = CApiResponse::instance();
        if ($verify->check($code)) {
            $resp->pack();
        } else {
            $resp->setCode(102, '验证码输入错误');
            $resp->pack();
        }
    }
}