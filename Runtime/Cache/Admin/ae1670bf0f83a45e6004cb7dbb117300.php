<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/bootstrap.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/font-awesome.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-fonts.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-part2.css" class="ace-main-stylesheet"/><![endif]-->
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-ie.css"/><![endif]-->
    <script src="/Public/statics/ace/js/ace-extra.js"></script>
    <!--[if lte IE 8]>
    <script src="/Public/statics/ace/js/html5shiv.js"></script>
    <script src="/Public/statics/ace/js/respond.js"></script><![endif]-->
    <style>
        body{background-color: #fff !important;}
        table{width: 70%;margin:0 auto;}
        table,th,tr,td{border:1px solid #e2e2e2;padding: 5px 20px;}
        table th{line-height: 50px;}
        table td:first-child{width: 40%;}
        table td:last-child{width: 60%;}
    </style>
</head>
<body>
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row text-center">
                        <h3>欢迎来到微信红包后台管理系统v1.0</h3>
                        上次登录IP：222.35.131.79.1 上次登录时间：2014-6-14 11:19:5
                    </div>
                    <br><br>
                    <div class="row ">
                        <table>
                            <thead>
                                <th colspan="2">服务器信息</th>
                            </thead>
                            <tbody>
                                <tr><td>服务器计算机名</td><td><?php echo ($serverInfo["server_name"]); ?></td></tr>
                                <tr><td>服务器IP地址</td><td><?php echo ($serverInfo["server_ip"]); ?></td></tr>
                                <tr><td>服务器域名</td><td><?php echo ($serverInfo["server_host"]); ?></td></tr>
                                <tr><td>服务器端口</td><td><?php echo ($serverInfo["server_port"]); ?></td></tr>
                                <tr><td>服务器操作系统</td><td><?php echo ($serverInfo["server_os"]); ?></td></tr>
                                <tr><td>服务器脚本超时时间</td><td><?php echo ($serverInfo["server_gqtime"]); ?></td></tr>
                                <tr><td>服务器当前时间</td><td><?php echo ($serverInfo["server_time"]); ?></td></tr>
                                <tr><td>服务器上次启动到现在已运行</td><td><?php echo ($serverInfo["server_uptime"]); ?></td></tr>
                                <tr><td>CPU总数</td><td><?php echo ($serverInfo["server_cpu"]); ?></td></tr>
                                <tr><td>CPU类型</td><td><?php echo ($serverInfo["server_cpu_type"]); ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/statics/ace/js/jquery.js'>" + "<" + "/script>");
</script><!-- <![endif]--><!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/statics/ace/js/jquery1x.js'>" + "<" + "/script>");
</script><![endif]-->
<script type="text/javascript">
//    if ('ontouchstart' in document.documentElement) document.write("<script src='/Public/statics/ace/js/jquery.mobile.custom.js'>" + "<" + "/script>");
</script>
<script src="/Public/statics/ace/js/bootstrap.js"></script>
<!--[if lte IE 8]>
<script src="/Public/statics/ace/js/excanvas.js"></script>
<![endif]-->
<!--<script src="/Public/statics/ace/js/jquery-ui.custom.js"></script>-->
<!--<script src="/Public/statics/ace/js/flot/jquery.flot.js"></script>-->
<!--<script src="/Public/statics/ace/js/ace/elements.scroller.js"></script>-->
<script src="/Public/statics/ace/js/ace/elements.aside.js"></script>
<script src="/Public/statics/ace/js/ace/ace.js"></script>
<script src="/Public/statics/js/base.js"></script>

</body>
</html>