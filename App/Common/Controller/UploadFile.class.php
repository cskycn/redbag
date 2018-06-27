<?php
/**
 * Copyright (c) 2013-2015, All rights reserved.
 * Author: 未知
 * Create: 2015/10/22 17:33
 */
namespace Common\Controller;


class UploadFile{
    private $maxSize = '52428800';
    private $allowExtArr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'photo' => array('jpg', 'jpeg', 'png'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'csv','docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2', 'pdf')
        );

    function __construct()
    {
    }

    /**
     * 处理post上传的文件；并返回路径
     * @param  string $path 字符串 保存文件路径示例： /Upload/image/
     * @param  string $format 文件格式限制
     * @return array           返回ajax的json格式数据
     */
    public  function postUpload($path = 'file', $format = 'empty')
    {
        ini_set('max_execution_time', '0');
        if (!empty($_FILES)) {
            // 上传文件配置
            $config = array(
                'maxSize' => $this->maxSize,       //   上传文件最大为50M
                'rootPath' => './Upload/',           //文件上传保存的根路径
                'savePath' => $path . '/',         //文件上传的保存路径（相对于根路径）
                'saveName' => array('uniqid', ''),     //上传文件的保存规则，支持数组和字符串方式定义
                'autoSub' => true,                   //  自动使用子目录保存上传文件 默认为true
                'exts' => isset($this->allowExtArr[$format]) ? $this->allowExtArr[$format] : '',
            );
            // 实例化上传
            $upload = new \Think\Upload($config);
            // 调用上传方法
            $info = $upload->upload();
            $data = array();
            if (!$info) {
                // 返回错误信息
                $error = $upload->getError();
                $data['error_info'] = $error;
                return $data;
            } else {
                // 返回成功信息
                foreach ($info as $file) {
                    $data['name'] = trim($file['savepath'] . $file['savename'], '.');
                    return $data;
                }
            }
        }
    }
}