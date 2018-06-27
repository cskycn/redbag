<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Common\Service\BaseService;
use Common\Service\CommonService;
use Common\Service\CookBookService;
use Common\Service\UserService;
use Think\Auth;

/**
 * 后台首页控制器
 */
class IndexController extends AdminBaseController
{
    public function index()
    {
        $this->assign('homeUrl', '/Admin/Nav/index');
		$this->display();
	}
}