<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>修改资料 - 智慧校园</title>
            <meta http-equiv="Cache-Control" content="no-transform" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/tpl/Public/css/base.css" />
</head>
<body>
<div class="bjy-admin-nav"><i class="fa fa-home"></i> 首页 &gt; 系统管理 &gt; 修改资料</div>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="<?php echo U('Admin/SysManage/updateInfo');?>">修改资料</a></li>
</ul>
<form class="form-inline" id="uInfoForm" method="post">
    <input type="hidden" name="admin_id" value="<?php echo ($uInfo['admin_id']); ?>">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th width="15%">头像：</th>
            <td style="position: relative;">
                <img src="<?php echo ($uInfo['header_url']); ?>" id="shurledit" style="overflow:hidden;width: 100px;height: 100px;border-radius: 50%;">
                <input type="hidden" name="header_url">
                <input class="form-control" id="fileToUploadedit" type='file' name='upfile' onclick="headerUpload('edit')"  style="width: 85px;height: 85px;border-radius: 50%;overflow: hidden;position: absolute;top: 11px;left: 11px;z-index: 99999;opacity: 0;">
            </td>
        </tr>
        <tr>
            <th>帐号</th>
            <td><input class="form-control" type="text" readonly name="name" value="<?php echo ($uInfo['name']); ?>"><font color="red" size="5">*</font></td>
        </tr>
        <tr>
            <th>昵称</th>
            <td><input class="form-control" type="text" name="nickname" value="<?php echo ($uInfo['nickname']); ?>"></td>
        </tr>
        <tr>
            <th>手机号</th>
            <td><input class="form-control" type="text"  name="tel" value="<?php echo ($uInfo['tel']); ?>"></td>
        </tr>
        <tr>
            <th>邮箱</th>
            <td><input class="form-control" type="text" name="email" value="<?php echo ($uInfo['email']); ?>"></td>
        </tr>
        <tr>
            <th></th>
            <td><input class="btn btn-success" type="button" value="提交" onclick="editSubmit()"></td>
        </tr>
    </table>
</form>
        <!-- <script src="/Public/statics/js/jquery-1.10.2.min.js"></script> -->
        <script src="/Public/statics/ace/js/jquery.js"></script>
        <script src="/Public/statics/bootstrap/js/bootstrap.min.js"></script>
        <script src="/Public/statics/js/base.js"></script>
         <script src="/Public/statics/js/byzl.pc.js"></script>
           <script src="/Public/statics/layer-v3.0.3/layer.js"></script>
<script src="/Public/statics/js/ajaxfileupload.js"></script>
<script>
    function headerUpload(obj) {
        var ass = '#uInfoForm';

        $('#fileToUpload' + obj).on('change', function () {
            $.ajaxFileUpload({
                url: "/Admin/SysManage/imgupfile",
                secureuri: false,
                fileElementId: 'fileToUpload' + obj,//file标签的id
                dataType: 'json',//返回数据的类型
                success: function (res) {
                    //把图片替换
                    if (res.code == 200) {
                        $(ass + " #shurl" + obj).attr('src', res.data['filepath']);
                        $(ass + " input[name='header_url']").val(res.data['filepath']);
                    }
                }
            });
        });
    }
    function editSubmit() {
        var name = $("input[name='name']").val();
        var nickname = $("input[name='nickname']").val();
        var email = $("input[name='email']").val();

        if (name == undefined || name == '') {
            layer.msg("请填写姓名");
            return false;
        }
//        if (nickname == undefined || nickname == '') {
//            layer.msg("请填写昵称");
//            return false;
//        }
        if(email !=""&&email != undefined&&!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
        {
            layer.msg("邮箱格式不正确！请重新输入");
            return false;
        }

        $.post('/Admin/SysManage/updateInfo',$('#uInfoForm').serialize(),function(res){
            if(res.code == 200){
                layer.msg("操作成功");
                setTimeout(function(){top.location.href='/Admin/Index/index';},2000);
            }else{
                layer.msg(res.message);
            }
        });
    }
</script>
</body>
</html>