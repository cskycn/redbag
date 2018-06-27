<?php

namespace Common\Tag;

use Think\Template\TagLib;

class My extends TagLib
{
    // 定义标签
    protected $tags = array(
        'jquery' => array('', 'close' => 0),
        'bootstrapcss' => array('', 'close' => 0),
        'bootstrapjs' => array('', 'close' => 0)
    );

    /**
     * jquery
     */
    public function _jquery()
    {
        $str = <<<php
        <script src="__PUBLIC__/statics/js/jquery-1.10.2.min.js"></script>
php;
        return $str;
    }

    // bootstrapcss标签
    public function _bootstrapcss($tag, $content)
    {
        $link = <<<php
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="__PUBLIC__/statics/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="__PUBLIC__/statics/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="__PUBLIC__/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="__PUBLIC_CSS__/base.css" />
php;
        return $link;
    }

    // bootstrapjs标签
    public function _bootstrapjs($tag, $content)
    {
        $link = <<<php
        <!-- <script src="__PUBLIC__/statics/js/jquery-1.10.2.min.js"></script> -->
        <script src="__PUBLIC__/statics/ace/js/jquery.js"></script>
        <script src="__PUBLIC__/statics/bootstrap/js/bootstrap.min.js"></script>
        <script src="__PUBLIC__/statics/js/base.js"></script>
         <script src="__PUBLIC__/statics/js/byzl.pc.js"></script>
           <script src="__PUBLIC__/statics/layer-v3.0.3/layer.js"></script>
php;
        return $link;
    }
}

