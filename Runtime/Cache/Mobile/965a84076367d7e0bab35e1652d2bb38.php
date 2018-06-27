<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>容易保▪关爱日</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content=" initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="format-detection" content="telephone=no">
    <link href="/Public/css/media.base.css" rel="stylesheet" type="text/css">
    <style>
        html,body{background-color: #f6d288;}
        .bimg100{background-size: 100% 100%;height: 100%;width: 100%;background-repeat: no-repeat;}
        .rbg{width: 18.72rem;margin: 2.427rem auto 0 auto;position: relative;border-radius: 0.625rem;border:#ffe1a4 6px solid;background-color: #fff;padding:0.9rem;top:-3rem;}
        .sub-bg{width: 15.387rem;margin: 0rem auto 0.685rem auto;overflow: hidden;border-radius: 0.625rem;}
        .sub-bg span{	font-size: 1.113rem;line-height: 2.053rem;line-height: 1rem;color: #E1B559;margin: 0rem 0; display: block;width:13.1rem;word-break: break-all;position:relative;top:-0.859rem;left:1.81rem;}
        .sub-bg .wenhao {display:block;width:1.25rem;height:1.25rem;position: relative;top:0.3rem;}
       /* .sub-bg ul{text-decoration: none;list-style: none;padding:0;}
        .sub-bg ul li{background-image: url("/Public/images/option-bg.png");	background-size: 100% 100%;background-repeat: no-repeat;font-size: 0.889rem;line-height: 1.293rem;color: #262626;margin-bottom: 1.227rem;position: relative;padding-left: 1.25rem;width: 15.387rem;height: 2.293rem;padding: 0.5rem 0.5rem 0.5rem 1.25rem}
        .sub-bg ul li::after{content: '';height: 0.6rem;width: 0.6rem;position: absolute;border-radius: 50%;border: 1px solid #999;left: 0;top: 0.1rem;}
        .sub-bg ul li.active::after{background-color: red;border: 1px solid red;}
        
        .sub-bg ul li img{max-width: 100%;width: 3.125rem;}
        */
        .sub-bg .choices{width:100%;padding:1rem 2rem;text-align: left;}
        .sub-bg .choices .so{margin-left:0.77rem;}
        .stitle{color:#fff;padding-top:1.92rem;line-height: 2.053rem;font-size:0.64rem;padding-left:1.573rem;}
        .s-score{line-height: 1.2rem;padding-top: 1rem;font-size: 0.64rem;position: absolute;top:-1.1875rem;right:-0.375rem;background-image: url("/Public/images/score.png");
            background-size: 100% 100%;background-repeat: no-repeat;width: 4.4rem;height: 4.267rem;text-align: center;color:#fff;}

        @media screen and (min-width: 375px) and (min-height: 750px) {
            .rbg{margin-top: 4rem;}
        }
        a{display: none !important;}

        .pm2{text-align: center;}
        .pm2 img{/*height: 15.36rem;*/width: 100%;}


        .radio-check { position: relative; height: 35px; } 
        .radio-check > input { position: absolute; left: 0; top: 0; width: 20px; height:20px; opacity: 0; } 
        .radio-check > label { position: absolute; left: 30px; line-height: 20px; top: 0px; } 
        .radio-check > label:before { content: ''; position: absolute; left: -30px; top: 0px; display: inline-block; width: 20px; height: 20px; border-radius: 50%; border: 1px solid #ddd; transition: all 0.3s ease; -webkit-transition: all 0.3s ease; -moz-transition: all 0.3s ease; } 
        .radio-check > label:after { content: ''; position: absolute; left: -30px; top: 0px; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-top: 6px; margin-left: 6px; transition: all 0.3s ease; -webkit-transition: all 0.3s ease; -moz-transition: all 0.3s ease; } 
        .radio-check input[type='radio']:checked + label:before { border-color: #E1B559; } 
        .radio-check input[type='radio']:checked + label:after { background: #E1B559; }

        .page {display: block;width:100%;text-align: center;font-size: 0.8rem;font-weight: 500;}
        .page p{display:inline;color:#aaa;}
        .page span{display: inline;color:#888;position: static;}

        .next-btn {display: block;width:100%;margin:0;}
        .next-btn img{display:block;width:12rem;height:2.088rem;margin:1.2rem auto;}
        
    </style>
</head>
<body>

<div class="pm2">
    <img src="/Public/images/test-head.png">
</div>

<div class="bimg100 rbg">
    <!-- 
    <div class="stitle">
        <?php echo ($currentPage-1); ?>/<?php echo ($countPage); ?> <span>（共计<?php echo ($countPage); ?>道，剩余<?php echo ($countPage-$currentPage+1); ?>道）</span>
    </div>
   <div class="s-score">
        得分<br><?php echo ($memberInfo['score']); ?>
    </div>

-->
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="sub-bg">
        <img class="wenhao" src="/Public/images/wenhao.png">
        <span><?php echo ($vo["title"]); ?>afgfdbegfdbef</span>
        <hr style="border: #f6d288 1px solid;opacity: 0.5;margin:0;">
        <div class="choices">
           <?php if(is_array($vo["optionList"])): $i = 0; $__LIST__ = $vo["optionList"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_option): $mod = ($i % 2 );++$i;?><div class='radio-check'>    
                <input type='radio' name='test' id='test'/>
                <label for='test' class><?php echo ($vo_option["option"]); ?>、<?php echo ($vo_option["name"]); ?></label>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

        <div class="next-btn">
            <?php if($countPage == $currentPage+1): ?><img src="/Public/images/test-sub.png" onclick="selOption(this,<?php echo ($vo["subject_id"]); ?>,<?php echo ($vo_option["subject_option_id"]); ?>)"><?php endif; ?>
            <?php if($currentPage+1 < $countPage): ?><img src="/Public/images/test-next.png" onclick="selOption(this,<?php echo ($vo["subject_id"]); ?>,<?php echo ($vo_option["subject_option_id"]); ?>)"><?php endif; ?>        
        </div>

        <div class="page">
                <p>第 <span><?php echo ($currentPage+1); ?></span> / <?php echo ($countPage); ?> 题</p>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<script src="/Public/js/jquery-1.9.1.min.js"></script>
<script src="/Public/statics/layer-v3.0.3/mobile/layer.js"></script>
<script type="text/javascript" src="https://cdn.webfont.youziku.com/wwwroot/js/wf/youziku.api.min.js"></script>
<script type="text/javascript">
    $youziku.load("*", "ab5a9cb589e84a8d8c9fc4d57cbd4f55", "YouYuan");
    $youziku.draw();
</script>
<script>
    var shttp_url='<?php echo ($http_url); ?>';
    var shttp_img_url='<?php echo ($http_img_url); ?>';
    var sremark='<?php echo ($remark); ?>';
    var stitle = '<?php echo ($title); ?>';
    var json_data = <?php echo ($jsonData); ?>;
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
    function doShare(){
        wx.showOptionMenu();
        /** 分享到朋友圈 */
        wx.onMenuShareTimeline({
            title: sremark,
            link: shttp_url,
            imgUrl: shttp_img_url,
            success: function () {

            },
            cancel: function () {

            }
        });
        /** 分享给朋友 */
        wx.onMenuShareAppMessage({
            title: stitle,
            desc: sremark,
            link: shttp_url,
            imgUrl: shttp_img_url,
            type: 'link',
            dataUrl: '',
            success: function () {

            },
            cancel: function () {

            }
        });
    }
    $.getScript('https://res.wx.qq.com/open/js/jweixin-1.2.0.js',function(){
        wx.config({
            debug: false,
            appId: json_data.appId, // 必填，公众号的唯一标识
            timestamp: json_data.timestamp, // 必填，生成签名的时间戳
            nonceStr: json_data.nonceStr, // 必填，生成签名的随机串
            signature: json_data.signature,
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'closeWindow',
                'hideOptionMenu',
                'showOptionMenu'
            ]
        });
        wx.ready(function (res) {
//            wx.hideOptionMenu();
            doShare();
        });
        wx.error(function (res) {
        });
    });
</script>
<script>
    var subject_id=0,subject_option_id=0;
    var currentPage = <?php echo ($currentPage); ?>;
    var isover = <?php echo ($isover); ?>;

    function nextSubject(){
        if(subject_id==0||subject_option_id==0){
            layer.open({
                content: '该题目尚未作答'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            return false;
        }
        layer.open({type: 2,shadeClose:false,shade: 'background-color: rgba(0,0,0,.1)'});
        $.post('/Mobile/Index/doSubject',{subid:subject_id,answer:subject_option_id},function(res){
            layer.closeAll();
            if(res.code == 200){
                if(isover==1) {
                    window.location.href='/Mobile/Index/result_share';
                }else{
                    window.location.href='/Mobile/Index/subjectList/page/'+currentPage;
                }
            }else{
                layer.open({
                    content: res.message
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
        });
    }
    function selOption(obj,subjectId,subjectOptionId){
//        $(".so").removeClass("active");
//        $(obj).addClass("active");
        subject_id = subjectId;
        subject_option_id = subjectOptionId;
        nextSubject();
    }
</script>
<script src="https://s19.cnzz.com/z_stat.php?id=1273138391&web_id=1273138391" language="JavaScript"></script>
</body>
</html>