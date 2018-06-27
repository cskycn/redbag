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
        html,body{background-color:#f6d288;}
        .bimg100{background-size: 100% 100%;height: 100%;width: 100%;background-repeat: no-repeat;}
        .rbg{/*background-image: url('/Public/images/m1-bg2.jpg');*/position: fixed;top:0;left:0;overflow: auto;z-index:99999;}
        .rr-bg{width: 16.590rem;/*height: 20.611rem;*//*height:17rem;*/background-color:#fff;margin: 0 auto;border-radius: 0.625rem;border:#ffe1a4 6px solid;color: #fff;padding-bottom: 2rem;}
        .rr-btn{margin: 0.72rem auto 2.247rem auto;	width: 15.093rem;height: 2.645rem;
            background-image: url("/Public/images/ljcy.png");background-repeat: no-repeat;background-size: 100% 100%;}
        .rr-btn2{font-size: 0.7rem;margin: 0.72rem auto 1.147rem auto;	width: 16.093rem;height: 2.133rem;text-align: center;line-height: 2.133rem;color: #fff;background-color: #ddd;border-radius:0.3125rem;}
        .rr-gz{overflow: hidden;padding:0 0.72rem;margin-top:-0.7rem;}
        .rr-gz span{display: inline-block;	width:16rem;color: #f6d288;/*margin-bottom:0.5rem;*/
            font-size: 0.912rem;
            font-weight: bold;
            font-stretch: normal;
            line-height: 2.92rem;
            letter-spacing: 0rem;
            }
        /*.rr-gz span{background-image: url("/Public/images/hdsm.png");background-repeat: no-repeat;background-size: 100% 100%;	width: 16.693rem;height: 0.8rem;}*/
        .rr-gz li{/*width: 17rem;*/font-size: 0.741rem;line-height: 1.333rem;color:#666;margin: auto;margin-left:1.2rem;font-weight: 500;list-style-type:disc;}
        .rr-bg table{border:0.056rem solid #ff0069;margin:1.1rem auto auto auto;width: 16rem;border-collapse: collapse;}
        .rr-bg table tr{border: 0.056rem solid #ff0069;width: 16rem;margin: auto;height:1.1556rem;line-height: 1.1556rem;}
        .rr-bg table th, .rr-bg table td{color: #888787;	font-size: 0.556rem;text-align: center;border: 0.056rem solid #ff0069;}
        .rr-bg table th{color:#ff0069;}
        .rr-bg .info{display: block;width:6rem;height:1.790rem;position: relative;top: -1rem;left: 50%;margin-left: -3rem;}
        .pm-header{/*height: 4.667rem;*//*width: 18.667rem;*/margin: 1rem auto;text-align: center;}
        .pm-header img{height: 3.787rem;}
        @media screen and (min-width: 375px) and (min-height: 750px) {
            .pm-header{margin-top: 3rem;}
            .rr-btn{margin: 1.741rem auto;}
        }
        .pm2{text-align: center;}
        .pm2 img{/*height: 15.36rem;*/width: 100%;}
        a{display: none !important;}
    </style>
</head>
<body>
<div class="bimg100 rbg">
   <!-- <div class="pm-header">
        <img src="/Public/images/ztwz.png">
    </div>
    -->
    <div class="pm2">
        <img src="/Public/images/head.png">
    </div>
    <?php if($isover == 1): ?><div class="rr-btn" onclick="doanswer()"></div>
    <?php else: ?>
        <!--<div class="rr-btn2">活动结束，19日中午12点准时开奖</div>-->
        <div class="rr-btn" onclick="doanswer2()"></div><?php endif; ?>
    <div class="rr-bg">
            <img class="info" src="/Public/images/huodonginfo.png">
        <div class="rr-gz">
            <span>活动时间</span>
            <ul>
            <li>答题时间  ：2018年5月25日-5月27日</li>
            <li>奖品发放  ：2018年5月28日-5月31日</li>
            </ul>
            <ul>
            <span>活动规则</span>
            <li>参与趣味答题，答对一题得10分，每邀请1个好友答题得5分。100%有奖哦~</li>
            <li>得分越多排名越靠前，将以活动结束时最终排名发放奖励，最多可获得188元红包哦。</li>
            <li>关注"小云营销"微信公众号，查询排名并领取红包奖励。</li>            
            </ul>
            
        </div>
    </div>
    <div style="text-align: center;width: 100%;margin: 1rem auto 1rem auto;color:#fff;">
        <small style="font-size: 0.6rem;font-weight: 600;">本活动最终解释权归北京微聚合信息技术有限公司所有</small>
    </div>
</div>
<script src="/Public/js/jquery-1.9.1.min.js"></script>
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
    function doanswer(){
        window.location.href='/Mobile/Index/subjectList';
    }
    function doanswer2(){
        window.location.href='/Mobile/Index/result_share';
    }
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
<script src="https://s19.cnzz.com/z_stat.php?id=1273138391&web_id=1273138391" language="JavaScript"></script>
</body>
</html>