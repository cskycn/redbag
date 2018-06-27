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
        .rbg{/*background-image: url('/Public/images/m1-bg2.jpg');*/position: fixed;top:0;left:0;overflow: auto;}
        .res-bg{width: 17.778rem;/*height: 21.111rem;*//*background-color: #fff;*/margin:0rem auto 0.685rem auto;border-radius: 0.625rem;border:#ffe1a4 6px solid;background-color: #fff;padding:0.9rem;text-align: center;}
        /*.res-btn{width: 17.778rem;height: 2.259rem;line-height: 2.259rem;text-align:center;background-color: #ee6e00;border-radius: 0.185rem;margin: 1.556rem auto;color:#fff;font-family: MicrosoftYaHei;font-size: 0.889rem;}*/
        /*.res-btn{margin: 0.741rem auto;color:#fff;text-align:center;font-size: 0.889rem;	width: 17.778rem;  height: 2.259rem;line-height: 2.259rem;  background-image: linear-gradient(180deg, #d4002c 0%, #ea0046 59%, #ff0060 100%), linear-gradient(#e1003c, #e1003c);background-blend-mode: normal,normal;border-radius: 0.185rem;}*/
        .res-btn{margin: 0.72rem auto 1.147rem auto;	width: 15.093rem;height: 2.133rem;
            background-image: url("/Public/images/share.png");background-repeat: no-repeat;background-size: 100% 100%;}
        .res-qrcode{overflow: hidden;text-align: center;}
        .res-qrcode img{width:6.4rem;height: 6.4rem;display: block;margin: 0.2rem auto 0 auto;}
        .res-qrcode-title{width: 100%;text-align:center;font-size: 0.926rem;line-height: 1.333rem;color: #ff0069;}
        /*.res-bg table{border:0.056rem solid #fff;margin:0.3rem auto auto auto;width: 16rem;border-collapse: collapse;}
        .res-bg table tr{border: 0.056rem solid #fff;width: 16rem;margin: auto;height:1.1556rem;line-height: 1.1556rem;}
        .res-bg table th, .res-bg table td{color: #fff;	font-size: 0.556rem;text-align: center;border: 0.056rem solid #FBE837;}
        .res-bg table th{color:#FBE837;}*/
        .res-bg .jfen{text-align: center;width:100%;font-size: 0.8rem;line-height: 1rem;margin-bottom: 0.2rem;}
        .res-bg .remark{font-size: 0.556rem;padding-left: 1rem;margin-top: 0.5rem;}
        .res-bg .bg-img {display: block;width:100%;margin:auto;}
        .res-bg p{color:#fff;position: relative;}
        .res-bg span{color:red;}
        .res-bg .p-title{font-size: 1rem;font-weight:800;}
        .res-bg .p-info{font-size: 0.8rem;font-weight:600;}
        .res-bg .btn-invite{display: block;margin: -3rem auto 0 auto;width:85%;}
        .res-bg .res-qrtitle img{display:block;width:100%;}
        .wxshare, .rule-layer{background: rgba(000, 000, 000, 0.7);position: fixed;z-index: 11;top: 0;left: 0;width: 100%;height: 100%;display: none;}
        .wxshare .zzz {position: absolute;right: 20px;top: 10px;}
        .pm-header{height: 6.4rem;width: 16rem;margin: 1rem auto;}
        .pm-header img{width: 100%;}
        @media screen and (min-width: 375px) and (min-height: 750px) {
            /*.res-bg{margin-top:13rem;}*/
            /*.res-btn{margin: 1.741rem auto;}*/
            .pm-header{margin: 3rem auto;}
            .res-btn{margin: 1.741rem auto;}
        }
        .pred{background-image: url("/Public/images/red.png");background-size: 100% 100%;background-repeat: no-repeat;position: relative;    height: 5rem;
            width: 100%;
            text-align: center;
            margin-top: 4rem;}
        .pred img{height: 3.84rem;width: 3.84rem;border-radius: 50%;overflow: hidden;position: absolute;
            top: -3.125rem;left:0;right:0;margin: auto;}
        .pred span{position: absolute;
            bottom: 2.4375rem;
            display: block;
            width: 100%;
            text-align: center;
            left: 0;
            font-size: 1.067rem;
            color: #fff;}
        .pzt{	width: 18.293rem;height: 2.827rem;margin: -1.375rem auto 1.147rem auto;}
        .pzt img{width: 18.267rem;height: 2.8rem;}
        .rdesc{margin-top: 0.907rem;}
        .rdesc p{
            width: 100%;
            text-align: center;
            /*height: 2.853rem;*/
            font-size: 0.75rem;
            line-height: 1.053rem;
            color: #ffffff;}
        a{display: none !important;}

        .pm2{text-align: center;}
        .pm2 img{/*height: 15.36rem;*/width: 100%;}

        .rule-layer .zzz{position: absolute;left: 50%;top:4.5rem;width:16rem;margin-left:-8rem;text-align: center;}
    </style>
</head>
<body>
<div class="bimg100 rbg">

    <div class="pm2">
            <img src="/Public/images/head.png">
            <img src="/Public/images/rule.png" style="position: absolute;top:1.2rem;right:0;z-index:9;width:4.2rem;" onclick="showRule()">
    </div>


    
    
    <!--<div class="pzt">-->
        <!--<img src="/Public/images/zt4.png">-->
    <!--</div>-->

    
    <div class="res-bg">
            <img class="bg-img" src="/Public/images/bg-activity.png">

            <?php if($isover == 0): ?><span style="display: block;width: 100%;text-align: center;font-size: 0.7rem;color: red;position: relative;bottom: 4.3rem;">活动结束，19日中午12点准时开奖</span><?php endif; ?>

            <p class="p-title" style="top:-7.4rem;">您目前已获得<span>200</span>积分</p>
            <p class="p-info" style="top:-6.6rem;">邀请好友赚积分提升排名</p>
            <p class="p-info" style="top:-6.4rem;">赢<span>188元</span>现金红包</p>
            <p class="p-info" style="top:-6.2rem;">每邀请<span>1人</span>即可获得<span>5积分</span>奖励哦~</p>
            <img class="btn-invite" src="/Public/images/invite.png" onclick="doShare()">
       
    </div>
    <div class="res-bg">
        <div class="res-qrtitle">
            <img src="/Public/images/gongzhong-title.png">
        </div>
            
        <div class="res-qrcode">
            <img src="/Public/images/qrcode.jpg">
        </div>
        
    </div>

    <div style="text-align: center;width: 100%;margin: 1rem auto 1rem auto;">
            <small style="font-size: 0.6rem;color:#fff;font-weight: 600;">本活动最终解释权归北京微聚合信息技术有限公司所有</small>
    </div>
    
    <div class="wxshare" onclick="closeShare()">
        <div class="zzz"><img src="/Public/images/icon-wxshare.png" height="150"></div>
    </div>

    <div class="rule-layer" onclick="closeRule()">
            <div class="zzz"><img src="/Public/images/dialog-rule.png" style="width:16rem;"></div>
    </div>
</div>
<script src="/Public/js/jquery-1.9.1.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
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
//    console.log("aaa"+json_data.appId);
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
    function closeShare(){
        $(".wxshare").hide();
    }
    function doShare() {
        $(".wxshare").show();
    }
    function showRule(){
        $(".rule-layer").show();
    }
    function closeRule(){
        $(".rule-layer").hide();
    }
    function doShare1(){
        wx.showOptionMenu();
        /** 分享到朋友圈 */
        wx.onMenuShareTimeline({
            title: stitle,
            link: shttp_url,
            imgUrl: shttp_img_url,
            success: function () {
                closeShare();
            },
            cancel: function () {
                closeShare();
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
                closeShare();
            },
            cancel: function () {
                closeShare();
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
            doShare1();
        });
        wx.error(function (res) {
        });
    });

    $(document).ready(function(){
        showRule();
    });
</script>
<script src="https://s19.cnzz.com/z_stat.php?id=1273138391&web_id=1273138391" language="JavaScript"></script>
</body>
</html>