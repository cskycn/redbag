<?php
namespace Common\Controller;

use Think\Controller;

/**
 * Base基类控制器
 */
class BaseController extends Controller
{
    public $postData = array();

    /**
     * 初始化方法
     * image/jpeg;image/png;multipart/form-data;
     */
    public function _initialize()
    {
        header('Access-Control-Allow-Origin:*');//允许指定的域名访问
        header('Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,AuthInfo');
        header('Access-Control-Allow-Methods:POST, PUT, GET, DELETE, OPTIONS');    //允许通过请求方法
        header('X-Request-With', null);
        header('Access-Control-Max-Age:180');//设置最大请求时间
        header('Content-Type:application/json;charset=UTF-8');
        $postStr = '';
        if (IS_POST) {
            $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
            if (empty($postStr)) {
                $postStr = file_get_contents('php://input');
            }
            if (strpos($_SERVER['CONTENT_TYPE'], 'image') !== false) {
                $this->postData = $postStr;
            } else {
                $this->postData = json_decode($postStr, true);
            }

        } else {
            $this->postData = I('get.');
            $postStr = I('get.');
        }
        if (empty($this->postData)) {
            $ss = str_replace("'", '"', $postStr);
            $this->postData = json_decode($ss, true);
        }
        $uedit = CONTROLLER_NAME . "_" . ACTION_NAME . '@' . date('YmdHis');
        F($uedit, $postStr);
    }
}
