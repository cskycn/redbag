<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>系统管理 - 微信红包</title>
            <meta http-equiv="Cache-Control" content="no-transform" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/tpl/Public/css/base.css" />
</head>
<body>
<div class="bjy-admin-nav"><a href="javascript:location.reload();"><i class="fa fa-home"></i> 首页</a> &gt; 系统管理</div>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab">管理员列表</a></li>
    <li><a href="javascript:;" onclick="add()">添加管理员</a></li>
</ul>

    <div id="myTabContent" class="tab-content">
        <input type="hidden" name="now_page" value="<?php echo ($now_page); ?>">
        <div class="tab-pane fade in active" id="home">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <th>UID</th>
                    <th>头像</th>
                    <th>昵称</th>
                    <th>帐号</th>
                    <th>电话</th>
                    <th>注册时间</th>
                    <th>操作</th>
                </tr>
                <?php if(is_array($ulist)): foreach($ulist as $key=>$v): ?><tr>
                        <td><?php echo ($v['admin_id']); ?></td>
                        <td>
                            <?php if($v['header_url']): ?><img src="<?php echo ($v['header_url']); ?>" style="height: 50px;width:50px;border-radius:50%;border:1px solid #e2e2e2;overflow: hidden;">
                                <?php else: ?>
                                <img src="/Public/images/default_header_80_80.png" style="height: 50px;width:50px;border-radius:50%;border:1px solid #e2e2e2;overflow: hidden;"><?php endif; ?>

                        </td>
                        <td><?php echo ($v['nickname']); ?></td>
                        <td><?php echo ($v['name']); ?></td>
                        <td><?php echo ($v['tel']); ?></td>
                        <td><?php echo ($v['register_time']); ?></td>
                        <td>
                            <a href="javascript:layer.confirm('确定删除？', {btn: ['确定','取消']}, function(){location='<?php echo U('Admin/ManageUser/delete',array('id'=>$v['admin_id'],'now_page'=>$now_page));?>'});"><font color="red">删除</font>&emsp;</a>
                            <a href="javascript:void(0)" onclick="edit('<?php echo ($v['nickname']); ?>',<?php echo ($v['admin_id']); ?>,'<?php echo ($v['tel']); ?>','<?php echo ($v['header_url']); ?>')">编辑</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="9" style="line-height: 30px;text-align: right;padding-right: 10px;"><?php echo ($page); ?></td>
                </tr>
            </table>
        </div>
    </div>
<div class="modal fade" id="bjy-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title" id="myModalLabel1">添加管理员</h4></div>
            <div class="modal-body">
                <form id="bjy_add" class="form-inline" action="<?php echo U('Admin/ManageUser/add');?>" method="post" onsubmit="return add_submit()">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th width="20%">管理员名称：<font color="red">（*）</font></th>
                            <td><input class="form-control" type="text" placeholder="请填写名称" name="nickname" style="width: 200px;"></td>
                        </tr>
                        <tr>
                            <th width="15%">头像：<font color="red">（*）</font></th>
                            <td style="position: relative;">
                                <img src="/Public/images/default_header_80_80.png" id="shurladd" style="overflow:hidden;width: 100px;height: 100px;border-radius: 50%;">
                                <input type="hidden" name="header_url">
                                <input class="form-control" id="fileToUploadadd" type='file' name='upfile' onclick="headerUpload('add')"  style="width: 85px;height: 85px;border-radius: 50%;overflow: hidden;position: absolute;top: 11px;left: 11px;z-index: 99999;opacity: 0;">
                            </td>
                        </tr>
                        <!--<tr>-->
                            <!--<th>类型：<font color="red">（*）</font></th>-->
                            <!--<td>-->
                                <!--<input type="radio" name="type"  value="1" checked>普通&emsp;-->
                                <!--&lt;!&ndash;<input type="radio" name="type"  value="0">正常&ndash;&gt;-->
                            <!--</td>-->
                        <!--</tr>-->
                        <tr>
                            <th>手机：<font color="red">（*）</font></th>
                            <td><input class="form-control" type="text" name="tel" placeholder="请输入手机号码" maxlength="11" style="width: 200px;"><font color="red">&emsp;提示：该手机号码作为登录帐号</font></td>
                        </tr>
                        <tr>
                            <th>密码：<font color="red">（*）</font></th>
                            <td><input class="form-control" type="password" name="password" placeholder="请输入不少于6位的密码" maxlength="10" style="width: 200px;"></td>
                        </tr>
                        <!--<tr>-->
                            <!--<th>状态：<font color="red">（*）</font></th>-->
                            <!--<td>-->
                                <!--<input  type="radio" name="is_forbid"  value="1">禁止&emsp;-->
                                <!--<input  type="radio" name="is_forbid"  value="0" checked>正常-->
                            <!--</td>-->
                        <!--</tr>-->
                        <tr>
                            <th></th>
                            <td><input class="btn btn-success" type="submit" value="提交"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bjy-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title" id="myModalLabel">编辑管理员</h4></div>
            <div class="modal-body">
                <form id="bjy_edit" class="form-inline" action="<?php echo U('Admin/ManageUser/edit');?>" method="post" onsubmit="return edit_submit()">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <input type="hidden" name="admin_id">
                        <tr>
                            <th width="20%">管理员名称：<font color="red">（*）</font></th>
                            <td><input class="form-control" type="text" placeholder="请填写名称" name="nickname" style="width: 200px;"></td>
                        </tr>
                        <tr>
                            <th width="15%">头像：<font color="red">（*）</font></th>
                            <td style="position: relative;">
                                <img src="/Public/images/default_header_80_80.png" id="shurledit" style="overflow:hidden;width: 100px;height: 100px;border-radius: 50%;">
                                <input type="hidden" name="header_url">
                                <input class="form-control" id="fileToUploadedit" type='file' name='upfile' onclick="headerUpload('edit')"  style="width: 85px;height: 85px;border-radius: 50%;overflow: hidden;position: absolute;top: 11px;left: 11px;z-index: 99999;opacity: 0;">
                            </td>
                        </tr>
                        <tr>
                            <th>手机：<font color="red">（*）</font></th>
                            <td><input class="form-control" type="text" name="tel" placeholder="请输入手机号码" maxlength="11" style="width: 200px;"><font color="red">&emsp;提示：该手机号码作为登录帐号</font></td>
                        </tr>
                        <tr>
                            <th>密码：</th>
                            <td>
                                <input class="form-control" type="password" name="password" placeholder="请输入不少于6位的密码" maxlength="10" style="width: 200px;">
                                <font color="red"> 注：不填为原密码</font>
                            </td>
                        </tr>
                        <!--<tr>-->
                            <!--<th>状态：<font color="red">（*）</font></th>-->
                            <!--<td>-->
                                <!--<input  type="radio" name="is_forbid"  value="1">禁止&emsp;-->
                                <!--<input  type="radio" name="is_forbid"  value="0" checked>正常-->
                            <!--</td>-->
                        <!--</tr>-->
                        <tr>
                            <th></th>
                            <td><input class="btn btn-success" type="submit" value="提交"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- <script src="/Public/statics/js/jquery-1.10.2.min.js"></script> -->
        <script src="/Public/statics/ace/js/jquery.js"></script>
        <script src="/Public/statics/bootstrap/js/bootstrap.min.js"></script>
        <script src="/Public/statics/js/base.js"></script>
         <script src="/Public/statics/js/byzl.pc.js"></script>
           <script src="/Public/statics/layer-v3.0.3/layer.js"></script>
<script src="/Public/statics/js/ajaxfileupload.js"></script>
<script>
    function headerUpload(obj) {
        var ass = '#bjy_'+obj;
        $('#fileToUpload' + obj).on('change', function () {
            $.ajaxFileUpload({
                url: "/Admin/ManageUser/imgupfile",
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

    function add() {
        $('#bjy-add').modal('show');
    }

    function edit(nickname,admin_id,tel,header_url) {
        $("#bjy-edit input[name='admin_id']").val(admin_id);
        $("#bjy-edit input[name='nickname']").val(nickname);
        $("#bjy-edit input[name='tel']").val(tel);
        header_url = header_url ||'/Public/images/default_header_80_80.png' ;
        $("#bjy-edit #shurledit").attr('src',header_url);
        $("#bjy-edit input[name='header_url']").val(header_url);
        $('#bjy-edit').modal('show');
    }

    function add_submit() {
//        var tel = $("#bjy-add input[name='school_id']").val();
//        var nickname = $("#bjy-add input[name='name']").val();
//        var password = $("#bjy-add input[name='grade_id']").val();
//        var leader = $("#bjy-add input[name='leader']").val();
//
//        if (schoolId == 0) {
//            layer.msg("请选择校区");
//            return false;
//        }
//        if (name == '' || name == undefined) {
//            layer.msg("请填写年级名称");
//            return false;
//        }
//        if (gradeId == 0) {
//            layer.msg("请选择年级");
//            return false;
//        }
//        if (leader == 0) {
//            layer.msg("请选择班主任");
//            return false;
//        }
//        if (leaders1.length == 0) {
//            layer.msg("请选择任课老师");
//            return false;
//        }
//        return true;
    }
</script>
</body>
</html>