<?php
/**
 * Created by PhpStorm.
 * User: Bob
 * Date: 2017/2/1
 * Time: 14:00
 */
namespace Common\Service;
use Think\Think;

class CommonService
{
    /**
     * 当前Service类的实例
     * @var self
     */
    private static $service = array();

    /**
     * 私有化构造函数，不允许外部调用
     */
    protected function __construct(){
    }

    /**
     * 获取当前模型的实例
     * @return self
     */
    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$service[$class]) || !(self::$service[$class] instanceof static)) {
            self::$service[$class] = new static;
        }
        return self::$service[$class];
    }
}