<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>修改密码 - 智慧校园</title>
            <meta http-equiv="Cache-Control" content="no-transform" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/tpl/Public/css/base.css" />
</head>
<body>
<div class="bjy-admin-nav"><i class="fa fa-home"></i> 首页 &gt; 系统管理 &gt; 修改密码</div>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="<?php echo U('Admin/SysManage/uPwd');?>">修改密码</a></li>
</ul>
<form class="form-inline" method="post" onsubmit="return uPasswd()"><input type="hidden" name="admin_id"
                                                                           value="<?php echo ($uInfo['admin_id']); ?>">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <!--<tr>-->
            <!--<th>姓名</th>-->
            <!--<td><input class="form-control" type="text" readonly name="name" value="<?php echo ($uInfo['name']); ?>"></td>-->
        <!--</tr>-->
        <tr>
            <th>帐号</th>
            <td><input class="form-control" type="text" readonly name="name" value="<?php echo ($uInfo['name']); ?>"></td>
        </tr>
        <tr>
            <th>原密码</th>
            <td><input class="form-control" type="password" name="passwd" placeholder="请输入不少于6位密码"><font color="red" size="5">*</font></td>
        </tr>
        <tr>
            <th>新密码</th>
            <td><input class="form-control" type="password" name="passwd2" placeholder="请输入不少于6位密码"><font color="red" size="5">*</font></td>
        </tr>
        <tr>
            <th></th>
            <td><input class="btn btn-success" type="submit" value="修改"></td>
        </tr>
    </table>
</form>
        <!-- <script src="/Public/statics/js/jquery-1.10.2.min.js"></script> -->
        <script src="/Public/statics/ace/js/jquery.js"></script>
        <script src="/Public/statics/bootstrap/js/bootstrap.min.js"></script>
        <script src="/Public/statics/js/base.js"></script>
         <script src="/Public/statics/js/byzl.pc.js"></script>
           <script src="/Public/statics/layer-v3.0.3/layer.js"></script>
<script>
    function uPasswd() {
        var pwd = $("input[name='passwd']").val();
        var pwd1 = $("input[name='passwd2']").val();
        if(pwd.length<6){
            layer.msg("请输入不少于6位密码");
            return false;
        }
        if (pwd == undefined || pwd == '') {
            layer.msg("请输入原密码");
            return false;
        }
        if(pwd1.length<6){
            layer.msg("请输入不少于6位密码");
            return false;
        }
        if (pwd1 == undefined || pwd1 == '') {
            layer.msg("请输入新密码");
            return false;
        }
        return true;
    }
</script>
</body>
</html>