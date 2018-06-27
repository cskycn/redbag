<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>用户管理 - 微信红包</title>
            <meta http-equiv="Cache-Control" content="no-transform" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/Public/statics/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/tpl/Public/css/base.css" />
</head>
<body>
<div class="bjy-admin-nav"><a href="javascript:location.reload();"><i class="fa fa-home"></i> 首页</a> &gt; 用户管理</div>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab">用户列表</a></li>
    <!--<li><a href="javascript:;" onclick="add()">添加用户</a></li>-->
</ul>
<div class="col-xs-12" style="background-color: #e2e2e2;padding: 10px;">
    <form action="<?php echo U('Admin/Member/dosearch');?>" method="post">
        <input class="btn btn-success" type="submit" value="搜索" style="float: right;"><input type="text" name="tel" placeholder="请输入手机号码" value="<?php echo ($stel); ?>" maxlength="11" style="width: 200px;float: right;margin-right: 15px;" class="form-control" >
    </form>
</div>
<!--<form action="<?php echo U('Admin/Member/batchDelete');?>" method="post">-->
    <div id="myTabContent" class="tab-content">
        <input type="hidden" name="now_page" value="<?php echo ($now_page); ?>">
        <div class="tab-pane fade in active" id="home">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <!--<th style="width: 10px;text-align: center;"><input type="checkbox" id="all_check" onclick="checkAll(this)"></th>-->
                    <th>UID</th>
                    <th>头像</th>
                    <th>昵称</th>
                    <th>性别</th>
                    <!--<th>用户类型</th>-->
                    <!--<th>电话</th>-->
                    <!--<th>OPENID</th>-->
                    <!--<th>UNIONID</th>-->
                    <!--<th>国家</th>-->
                    <th>省份</th>
                    <!--<th>城市</th>-->
                    <!--<th>注册IP</th>-->
                    <th>积分数</th>
                    <th>注册时间</th>
                    <!--<th>状态</th>-->
                    <!-- <th>操作</th> -->
                </tr>
                <?php if(is_array($ulist)): foreach($ulist as $key=>$v): ?><tr>
                        <!--<td style="width: 10px;text-align: center;"><input type="checkbox" name="members[]" onclick="checkObj(this)"  value="<?php echo ($v['member_id']); ?>"></td>-->
                        <td><?php echo ($v['member_id']); ?></td>
                        <td>
                            <img src="<?php echo ($v['avatar_url']); ?>" style="height: 50px;width:50px;border-radius:50%;border:1px solid #e2e2e2;overflow: hidden;">
                        </td>
                        <td><?php echo ($v['nick_name']); ?></td>
                        <td><?php if($v['gender'] == 1): ?>男<?php else: ?>女<?php endif; ?></td>
                        <!--<td><?php if($v['type'] == 0): ?>普通用户<?php else: ?>员工<?php endif; ?></td>-->
                        <!--<td><?php echo ($v['tel']); ?></td>-->
                        <!--<td><?php echo ($v['openid']); ?></td>-->
                        <!--<td><?php echo ($v['unionid']); ?></td>-->
                        <!--<td><?php echo ($v['country']); ?></td>-->
                        <td><?php echo ($v['province']); ?></td>
                        <!--<td><?php echo ($v['city']); ?></td>-->
                        <!--<td><?php echo ($v['register_ip']); ?></td>-->
                        <td><?php echo ($v['score']); ?></td>
                        <td><?php echo ($v['register_time']); ?></td>
                        <!--<td>-->
                            <!--<?php if($v['is_forbid'] == 1): ?>-->
                                <!--<font color="red">冻结</font>-->
                            <!--<?php else: ?>-->
                                <!--<font color="green">正常</font>-->
                            <!--<?php endif; ?>-->
                        <!--</td>-->
            <!--             <td>
                            <a href="javascript:layer.confirm('确定删除？', {btn: ['确定','取消']}, function(){location='<?php echo U('Admin/Member/delete',array('id'=>$v['member_id'],'now_page'=>$now_page));?>'});"><font color="red">删除</font>&emsp;</a>
                            <a href="javascript:void(0)" onclick="add(<?php echo ($v['type']); ?>,<?php echo ($v['member_id']); ?>)">设置用户类型</a>
                            <a href="javascript:void(0)" onclick="registerTj(<?php echo ($v['member_id']); ?>)">注册统计</a>
                        </td> -->
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <!--<td><input class="btn btn-success" type="submit" value="批量删除"></td>-->
                    <td colspan="15" style="line-height: 30px;text-align: right;padding-right: 10px;"><?php echo ($page); ?></td>
                </tr>
            </table>
        </div>
    </div>
<!--</form>-->
<div class="modal fade" id="bjy-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title" id="myModalLabel1">设置用户类型</h4></div>
            <div class="modal-body">
                <form id="bjy-form1" class="form-inline" action="<?php echo U('Admin/Member/setUserType');?>" method="post"
                      onsubmit="return add_submit()">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <input type="hidden" name="mid">
                        <!--<tr>-->
                            <!--<th width="15%">昵称：<font color="red">（*）</font></th>-->
                            <!--<td><input class="form-control" type="text" placeholder="请填写昵称" name="nickname" style="width: 200px;"></td>-->
                        <!--</tr>-->
                        <tr>
                            <!--<th>性别：<font color="red">（*）</font></th>-->
                            <td id="gghh">

                            </td>
                        </tr>
                        <!--<tr>-->
                            <!--<th>类型：<font color="red">（*）</font></th>-->
                            <!--<td>-->
                                <!--<input type="radio" name="type"  value="1" checked>普通&emsp;-->
                                <!--&lt;!&ndash;<input type="radio" name="type"  value="0">正常&ndash;&gt;-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<th>手机：<font color="red">（*）</font></th>-->
                            <!--<td><input class="form-control" type="text" name="tel" placeholder="请输入手机号码" maxlength="11" style="width: 200px;"><font color="red">&emsp;提示：该手机号码作为登录帐号</font></td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<th>密码：<font color="red">（*）</font></th>-->
                            <!--<td><input class="form-control" type="password" name="password" placeholder="请输入不少于6位的密码" maxlength="10" style="width: 200px;"></td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<th>生日：</th>-->
                            <!--<td><input type="text" class="Wdate form-control" name="birthday"-->
                                       <!--style="width: 200px;border-color:#ccc;height: 34px;"-->
                                       <!--onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"/></td>-->
                        <!--</tr>-->

                        <!--<tr>-->
                            <!--<th>情感：</th>-->
                            <!--<td>-->
                                <!--<select class="form-control" name="emotion" style="width: 200px;">-->
                                    <!--<option value="1">热恋</option>-->
                                    <!--<option value="2">单身</option>-->
                                    <!--<option value="3">已婚</option>-->
                                    <!--<option value="4">离婚</option>-->
                                    <!--<option value="5">丧偶</option>-->
                                <!--</select>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<th>状态：<font color="red">（*）</font></th>-->
                            <!--<td>-->
                                <!--<input  type="radio" name="is_forbid"  value="1">禁止&emsp;-->
                                <!--<input  type="radio" name="is_forbid"  value="0" checked>正常-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<th>省份：<font  color="red">(*)</font></th>-->
                            <!--<td><select class="form-control" name="province_id" onchange="changeCity()"-->
                                        <!--style="width: 258px;">-->
                                <!--<option value="0">请选择省份</option>-->
                                <!--<?php if(is_array($citys)): foreach($citys as $key=>$v): ?>-->
                                    <!--<option value="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?></option>-->
                                <!--<?php endforeach; endif; ?>-->
                            <!--</select> </td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<th>城市：<font  color="red">(*)</font></th>-->
                            <!--<td><select class="form-control" name="city_id" disabled style="width: 258px;">-->
                                <!--<option value="0">请选择城市</option>-->
                                <!--<option value="1">南京市</option>-->
                                <!--<option value="2">徐州市</option>-->
                                <!--<option value="3">苏州市</option>-->
                            <!--</select> </td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<th>详细地址：</th>-->
                            <!--<td><textarea class="form-control" name="address"-->
                                          <!--style="width: 258px;height: 80px;"></textarea></td>-->
                        <!--</tr>-->
                        <tr>
                            <!--<th></th>-->
                            <td><input class="btn btn-success" type="submit" value="提交"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bjy-rtj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title" id="myModalLabel2">注册统计</h4></div>
            <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover table-condensed">

                    </table>
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
<script src="/Public/statics/My97DatePicker/WdatePicker.js"></script>
<script>
    $(function(){
        $(".page a").click(function(){
            var stel = "<?php echo ($stel); ?>";
            if(this.href!='javascript:;'&&this.href!='') {
                this.href = this.href + '/tel/' + stel;
            }
        });
    });
    //省份切换
//    function changeCity() {
//        var province = $("#bjy-add select[name='province_id']").val();
//        $.post('/Admin/Member/getCity', {provinceId: province}, function (res) {
//            if (res.code == 200) {
//                var html = '<option value="0">请选择城市</option>';
//                for (var i = 0; i < res.data.length; i++) {
//                    html += '<option value="' + res.data[i].id + '">' + res.data[i].name + '</option>';
//                }
//                $("#bjy-add select[name='city_id']").html(html);
//                $("#bjy-add select[name='city_id']").removeAttr('disabled');
//            }
//        });
//    }

    function registerTj(mid){
        var html = '<tr><th>昵称</th><th>性别</th><th>用户类型</th><th>电话</th><th>注册IP</th><th>注册时间</th></tr>';
        $.get('/Admin/Member/getRtj', {mid: mid}, function (res) {
            if (res.code == 200) {
                for (var i = 0; i < res.data.length; i++) {
                    html +='<tr><td>'+res.data[i].nick_name+'</td><td>';
                    if(res.data[i].gender == 1){
                        html += '男';
                    }else{
                        html += '女';
                    }
                    html += '</td><td>';
                    if(res.data[i].type == 0){
                        html += '普通用户';
                    }else{
                        html += '员工';
                    }
                    html += '</td><td>'+res.data[i].tel+'</td><td>'+res.data[i].register_ip+'</td><td>'+res.data[i].register_time+'</td></tr>';
                }

                $("#bjy-rtj table").html(html);
            }
        });
        $('#bjy-rtj').modal('show');
    }
    // 添加菜单
    function add(type,mid) {
        var html = '<input type="radio" name="type"  value="0"';
        if(type ==0){
            html += 'checked';
        }
        html +=' >普通用户&emsp;<input type="radio" name="type"  value="1"';
        if(type ==1){
            html += 'checked';
        }
        html += '>员工';
        $("#gghh").html(html);
        $("#bjy-add input[name='mid']").val(mid);
        $('#bjy-add').modal('show');
    }
//    function checkAll(obj){
//        $("input[name='members[]']").prop('checked', $(obj).prop('checked'));
//    }
//    function checkObj(obj){
//        var ln1 = $("input[name='members[]']").length;
//        var ln = $("input[name='members[]']:checked").length;
//        console.log(ln1+'=='+ln);
//        if(ln1 == ln){
//            $('#all_check').prop('checked', $(obj).prop('checked'));
//        }else{
//            $('#all_check').attr('checked',false);
//        }
//    }
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