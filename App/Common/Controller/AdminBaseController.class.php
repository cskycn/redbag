<?php
namespace Common\Controller;

use Think\Controller;

/**
 * admin 基类控制器
 */
class AdminBaseController extends Controller
{
    public $userId = 0;
    public $userType = 0;
    public $userName = '';
    /**
     * 初始化方法
     */
    public function _initialize()
    {
//        parent::_initialize();
        if (!session('user')) {
            $this->redirect(U('Admin/Login/index'));
            die;
        }
        session(array('name' => 'BYZL', 'expire' => 3600));
        $this->userId = $_SESSION['user']['uid'];
        $this->userType = $_SESSION['user']['utype'];
        $this->userName = $_SESSION['user']['name'];
    }

    //图像上传
    public function imgupfile()
    {
        $resp = CApiResponse::instance();
        if (empty($_FILES)) {
            $resp->setCode(Error::ERR_MISS_PARAMETERS);
            $resp->pack();
        }
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => './Upload/avatar/images/',
            'savePath' => '',
            'saveName' => array('uniqid', ''),
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub' => true,
            'subName' => array('date', 'Ymd'),
        );
        if(!is_dir($config['rootPath'])){
            FunMethod::mkDirs($config['rootPath']);
        }
        $upload = new \Think\Upload($config);
        $info = $upload->uploadOne($_FILES['upfile']);
        if (!$info) {
            $resp->setCode(Error::ERR_GENERAL);
            $resp->pack();
        } else {
            $mms_cover = substr($config['rootPath'] . $info['savepath'] . $info['savename'], 1);
            $resp->setData(array('filepath' => $mms_cover));
            $resp->pack();
        }
    }
}