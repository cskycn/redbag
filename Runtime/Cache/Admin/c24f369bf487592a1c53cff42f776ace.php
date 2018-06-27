<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>微信红包管理后台</title>
    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/bootstrap.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/font-awesome.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-fonts.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-ie.css"/><![endif]--><!--[if lte IE 8]>
    <script src="/Public/statics/ace/js/html5shiv.js"></script>
    <script src="/Public/statics/ace/js/respond.js"></script><![endif]-->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/Public/statics/ace/js/jquery.js'>" + "<" + "/script>");
    </script><!-- <![endif]-->
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='/Public/statics/ace/js/jquery.mobile.custom.js'>" + "<" + "/script>");
    </script>
    <script src="/Public/statics/js/byzl.pc.js"></script>
</head>
<body class="no-skin"> <!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="navbar-container" id="navbar-container"> <!-- #section:basics/sidebar.mobile.toggle -->
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        <div class="navbar-header pull-left"> <!-- #section:basics/navbar.layout.brand --> <a href="#"
                                                                                              class="navbar-brand">
            <small>微信红包管理后台</small>
        </a></div> <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav"> <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue"><a data-toggle="dropdown" href="#" class="dropdown-toggle">
                    <!--<img class="nav-user-photo" style="width: 35px;height: 35px;overflow: hidden;" src="<?php echo ($_SESSION['user']['uHeaderUrl']); ?>" /> -->
                    <span class="user-info"><small>欢迎光临,</small><?php echo ($_SESSION['user']['nickname']?$_SESSION['user']['nickname']:$_SESSION['user']['name']); ?></span><i
                        class="ace-icon fa fa-caret-down"></i></a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li><a href="<?php echo U('Admin/SysManage/updateInfo');?>" target="right_content"><i
                                    class="ace-icon fa fa-pencil"></i> 修改资料</a></li>
                            <li><a href="<?php echo U('Admin/SysManage/uPwd');?>" target="right_content"><i
                                    class="ace-icon fa fa-user"></i> 修改密码</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo U('Admin/Login/logout');?>"><i class="ace-icon fa fa-power-off"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    </script> <!-- #section:basics/sidebar -->
    <div id="sidebar" class="sidebar responsive">
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'fixed')
            } catch (e) {
            }
        </script>
        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large"><font color="red">系统管理员</font> <?php echo ($_SESSION['user']['nickname']?$_SESSION['user']['nickname']:$_SESSION['user']['name']); ?> </div>
        </div>
        <ul class="nav nav-list">
            <li class="">
                <a href="<?php echo ($homeUrl); ?>" target="right_content">
                    <i class="menu-icon fa fa-home"></i>
                    <span class="menu-text">首页</span>
                </a>
                <b class="arrow"></b>
            </li>

            <!--<li class="">-->
                <!--<a href="<?php echo U($v['name']);?>" target="right_content">-->
                    <!--<i class="menu-icon fa fa-<?php echo ($v['ico']); ?>"></i>-->
                    <!--<span class="menu-text"><?php echo ($v['title']); ?></span>-->
                <!--</a>-->
                <!--<b class="arrow"></b>-->
            <!--</li>-->
            <!--<li class="">-->
                <!--<a href="#" class="dropdown-toggle">-->
                    <!--<i class="menu-icon fa fa-video-camera"></i>-->
                    <!--<span class="menu-text">视频管理</span>-->
                    <!--<b class="arrow fa fa-angle-down"></b>-->
                <!--</a>-->
                <!--<b class="arrow"></b>-->
                <!--<ul class="submenu">-->
                    <!--<li class="">-->
                        <!--<a href="/Admin/Category/index" target="right_content">-->
                            <!--<i class="menu-icon fa fa-caret-right"></i>-->
                            <!--分类管理-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li class="">-->
                        <!--<a href="/Admin/Video/index" target="right_content">-->
                            <!--<i class="menu-icon fa fa-caret-right"></i>-->
                            <!--视频列表-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li class="">-->
                        <!--<a href="/Admin/Comment/index" target="right_content">-->
                            <!--<i class="menu-icon fa fa-caret-right"></i>-->
                            <!--评论管理-->
                        <!--</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</li>-->
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-users"></i>
                    <span class="menu-text">用户管理</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="">
                        <a href="/Admin/Member/index" target="right_content">
                            <i class="menu-icon fa fa-caret-right"></i>
                            用户列表
                        </a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cog"></i>
                    <span class="menu-text">系统管理</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="">
                        <a href="/Admin/ManageUser/index" target="right_content">
                            <i class="menu-icon fa fa-caret-right"></i>
                            管理员列表
                        </a>
                    </li>
                    <li class="">
                        <a href="/Admin/SysManage/updateInfo" target="right_content">
                            <i class="menu-icon fa fa-caret-right"></i>
                            修改资料
                        </a>
                    </li>
                    <li class="">
                        <a href="/Admin/SysManage/uPwd" target="right_content">
                            <i class="menu-icon fa fa-caret-right"></i>
                            修改密码
                        </a>
                    </li>
                </ul>
            </li>
        </ul> <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse"><i class="ace-icon fa fa-angle-double-left"
                                                                              data-icon1="ace-icon fa fa-angle-double-left"
                                                                              data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'collapsed')
            } catch (e) {
            }
        </script>
    </div>
    <div class="main-content">
        <div class="page-content">
            <iframe id="content-iframe" src="<?php echo ($homeUrl); ?>" frameborder="0" width="100%" height="100%" name="right_content"
                    scrolling="auto" frameborder="0" scrolling="no"></iframe>
        </div>
    </div>
    <div class="footer">
        <div class="footer-inner"> <!-- #section:basics/footer -->
            <div class="footer-content"><span class="bigger-120"><span class="blue bolder">微信红包</span> &copy; 2013-2014</span>
                &nbsp; &nbsp;<span class="action-buttons"></span></div>
        </div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i
            class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a></div> <!--[if !IE]> -->

<script src="/Public/statics/ace/js/bootstrap.js"></script>
<!--[if lte IE 8]>
<script src="/Public/statics/ace/js/excanvas.js"></script><![endif]-->
<script src="/Public/statics/ace/js/ace/elements.scroller.js"></script>
<script src="/Public/statics/ace/js/ace/ace.js"></script>
<script src="/Public/statics/ace/js/ace/ace.sidebar.js"></script>
<script src="/Public/statics/js/base.js"></script>

<script type="text/javascript">
    $(function () {
        // 导航点击事件
        $('.b-nav-li').click(function (event) {
            $('.active').removeClass('active');
            var ulObj = $(this).parents('.b-has-child').eq(0);
            $(this).addClass('active');
            if (ulObj.length != 0) {
                $(this).parents('.b-has-child').eq(0).addClass('active');
            }
        });
        // 动态调整iframe的高度以适应不同高度的显示器
        $('.page-content,.main-content').height($(window).height() - 120);
//		$('.page-content').css('padding-bottom', 200);
        // 左侧菜单自动适应高度
//		$('#sidebar .nav-list').height($(window).height());
    })
</script>
</body>
</html>