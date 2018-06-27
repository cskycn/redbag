<?php
return array(
    'ERROR_PAGE'=>'/404.html',
    'APP_SUB_DOMAIN_DEPLOY'=>1,//开启子域名
    'APP_SUB_DOMAIN_RULES'=>array(
 
    ),
//*************************************附加设置***********************************
    'SHOW_PAGE_TRACE' => false,                           // 是否显示调试面板
    'URL_CASE_INSENSITIVE' => false,                           // url区分大小写
    'TAGLIB_BUILD_IN' => 'Cx,Common\Tag\My',              // 加载自定义标签
    'LOAD_EXT_CONFIG' => 'db',               // 加载网站设置文件
    'TMPL_PARSE_STRING' => array(                           // 定义常用路径
        '__OSS__' => OSS_URL,
        '__PUBLIC__' => OSS_URL . __ROOT__ . '/Public',
        '__ACEADMIN__' => OSS_URL . __ROOT__ . '/Public/statics/ace',
        '__PUBLIC_CSS__' => __ROOT__ . trim(TMPL_PATH, '.') . 'Public/css',
        '__PUBLIC_JS__' => __ROOT__ . trim(TMPL_PATH, '.') . 'Public/js',
        '__PUBLIC_IMAGES__' => OSS_URL . trim(TMPL_PATH, '.') . 'Public/images',
    ),
    //***********************************URL设置**************************************
    'MODULE_ALLOW_LIST' => array('Admin', 'Api','Mobile'), //允许访问列表
    'URL_HTML_SUFFIX' => '',  // URL伪静态后缀设置
    'URL_MODEL' => 2,  //启用rewrite
    'DEFAULT_MODULE' => 'Admin',  // 默认模块
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称
    //'LOAD_EXT_CONFIG' => 'SiteConfig', //定义系统级别的附加常量
    'DB_SQL_BUILD_CACHE' => true,
    'DB_SQL_BUILD_QUEUE' => 'xcache',
    'DB_SQL_BUILD_LENGTH'             =>  30,
    'DATA_CRYPT_TYPE' => 'DES', // 数据加密方式
//***********************************SESSION设置**********************************
    'SESSION_OPTIONS' => array(
        'name' => 'BYZL',//设置session名
        'expire'             => 3600*24*15, //SESSION保存60分钟
        'use_trans_sid' => 1,//跨页传递
        'use_only_cookies' => 0,//是否只开启基于cookies的session的会话方式
    ),
//***********************************缓存设置**********************************
    'DATA_CACHE_TIME' => 1800,        // 数据缓存有效期
    'DATA_CACHE_PREFIX' => 'mem_',      // 缓存前缀
    'DATA_CACHE_TYPE' => 'File', // 数据缓存类型,
    'MEMCACHED_SERVER' => '127.0.0.1', // 服务器ip
);