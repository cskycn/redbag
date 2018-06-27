<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>登录</title>
    <link href="/Public/statics/ace/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/font-awesome.css"/>
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/Public/statics/ace/css/font-awesome-ie7.css"/><![endif]-->
    <link rel="stylesheet" href="/Public/statics/ace/css/ace.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-rtl.css"/>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-skins.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/Public/statics/ace/css/ace-ie.css"/><![endif]-->
    <script src="/Public/statics/ace/js/ace-extra.js"></script>
    <!--[if lt IE 9]>
    <script src="/Public/statics/ace/js/html5shiv.js"></script>
    <script src="/Public/statics/ace/js/respond.js"></script><![endif]--></head>
<body style="background-image: url(/Public/images/nbg.png);background-size: 100% 100%;background-repeat: no-repeat;min-width: 1000px !important;">

    <div  style="overflow: hidden;padding: 15px 30px;width: 39%;height:43%;margin:auto;position: absolute;top:-12%;left:-1%;right:0;bottom: 0;">
        <div class="col-md-12"  style="clear:both;">
            <form role="form" id="form1" method="post">
                    <h2>微信红包管理系统</h2>
                    <div class="form-group">
                        <input class="form-control"  autocomplete="off"  placeholder="请输入手机号码" name="tel" type="text" autofocus   value="<?php if($_COOKIE['remember']){echo $_COOKIE['utel'];}?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control"  autocomplete="off" placeholder="请输入密码"   name="passwd" value="">
                    </div>
                    <div class="input-group"><input type="text" id="vcode" autocomplete="off"  class="form-control" placeholder="验证码">
                        <span class="input-group-btn" style="width:40%;" onclick="loadVerify()">
                            <img id="verifyimg"   src="" style="height: 34px;width: 100%;">
                        </span>
                    </div>
                    <div id="checkmsg" style="color:red;line-height: 30px;"></div>
                    <div class="checkbox">
                        <!--<label style="color:white;">-->
                            <!--<input name="remember"  type="checkbox" <?php if($_COOKIE['remember']=='on'){ echo 'checked';}?>>记住用户-->
                        <!--</label>-->
                    </div>
                    <input type="hidden" name="type">
                    <input type="button" value="登录" class="btn btn-lg btn-danger btn-block" onclick="checkVerify(1);"/>
            </form>
        </div>
    </div>

        <!--[if !IE]> -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script><!-- <![endif]--><!--[if IE]>
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script><![endif]--><!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/statics/js/jquery-2.0.3.min.js'>" + "<" + "script>");
</script><!-- <![endif]--><!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/statics/js/jquery-1.10.2.min.js'>" + "<" + "script>");
</script><![endif]-->
<script src="/Public/statics/ace/js/bootstrap.js"></script>
<script src="/Public/statics/js/base.js"></script>
<script>
    $(function () {
        if(window !=top){
            top.location.href=location.href;
        }
        loadVerify();
        $(document).keyup(function (event) {
            if (event.keyCode == 13) {
                checkVerify(1);
            }
        });
    });
    function loadVerify() {
        var time = new Date().getTime();
        var url = "/Admin/Login/verify";
        $('#verifyimg').attr('src', url + '?' + time);
    }

    function checkVerify(type) {
        $("#form1 input[name='type']").val(type);
        var code = $('#vcode').val();
        var tel = $("#form1 input[name='tel']").val();
        var passwd = $("#form1 input[name='passwd']").val();
        if (tel == '' || tel == undefined) {
            $('#checkmsg').html("请填写手机号码");
            setTimeout(function () {
                $('#checkmsg').html('');
                $('#vcode').val('');
            }, 2000);
            return false;
        }
        if (passwd == '' || passwd == undefined) {
            $('#checkmsg').html("请填写登录密码");
            setTimeout(function () {
                $('#checkmsg').html('');
                $('#vcode').val('');
            }, 2000);
            return false;
        }
        $.post("/Admin/Login/check_verify", {code: code}, function (res) {
            if (res.code == 200) {
                $('#form1').submit();
            } else {
                $('#checkmsg').html(res.message);
                setTimeout(function () {
                    $('#checkmsg').html('');
                    loadVerify();
                    $('#vcode').val('');
                }, 2000);
            }
        });
    }
</script>
</body>
</html>