<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
        .res-bg{width: 17.778rem;height: 23.611rem;background-color: #fff;margin: 0.722rem auto 0.685rem auto;    border-radius: 0.625rem;border:6px solid #ffe1a4;}
        /*.res-btn{width: 17.778rem;height: 2.259rem;line-height: 2.259rem;text-align:center;background-color: #ee6e00;border-radius: 0.185rem;margin: 1.556rem auto;color:#fff;font-family: MicrosoftYaHei;font-size: 0.889rem;}*/
        /*.res-btn{margin: 0.741rem auto;color:#fff;text-align:center;font-family: MicrosoftYaHei;font-size: 0.889rem;	width: 17.778rem;  height: 2.259rem;line-height: 2.259rem;  background-image: linear-gradient(180deg, #d4002c 0%, #ea0046 59%, #ff0060 100%), linear-gradient(#e1003c, #e1003c);background-blend-mode: normal,normal;border-radius: 0.185rem;}*/
        .res-btn{position: fixed;right: 0;bottom: 0;padding: 3px 5px;top: 0;margin: auto;    color: #fff;
            /*font-family: MicrosoftYaHei;*/
            /*font-size: 0.889rem;*/
            /*width: 1.778rem;*/
            /*height: 7.259rem;*/
            /*line-height: 1.259rem;*/
            font-size: 0.789rem;
            width: 1.378rem;
            height: 9.259rem;
            line-height: 1rem;
            background-image: linear-gradient(180deg, #d4002c 0%, #ea0046 59%, #ff0060 100%), linear-gradient(#e1003c, #e1003c);
            background-blend-mode: normal,normal;
            border-radius: 0.185rem;}
        .res-qrcode{overflow: hidden;text-align: center;margin-top:-2.35rem;z-index: 99999;}
        .res-qrcode img{width:2.8rem;height: 2.8rem;display: block;margin: 0.5rem auto 0 auto;border-radius:50%;overflow: hidden;border:6px solid #ffe1a4;}
        .res-qrcode-title{width: 100%;text-align:center;/*font-family: MicrosoftYaHei;*/font-size: 0.926rem;line-height: 1.333rem;color: #ff0069;}
        .res-bg table{border:0.056rem solid #ff0069;margin:1.1rem auto auto auto;width: 16rem;border-collapse: collapse;}
        .res-bg table tr{border: 0.056rem solid #ff0069;width: 16rem;margin: auto;height:1.1556rem;line-height: 1.1556rem;}
        .res-bg table th, .res-bg table td{color: #888787;	/*font-family: MicrosoftYaHei;*/font-size: 0.556rem;text-align: center;border: 0.056rem solid #ff0069;}
        .res-bg table th{color:#ff0069;}
        .res-bg .jfen{text-align: center;width:100%;/*font-family: MicrosoftYaHei;*/font-size: 0.8rem;line-height: 1rem;margin-bottom: 0.5rem;margin-top: 0.5rem;}
        .res-bg .remark{/*font-family: MicrosoftYaHei;*/font-size: 0.556rem;padding-left: 1rem;margin-top: 1.1rem;}
        .wxshare{background: rgba(000, 000, 000, 0.7);position: fixed;z-index: 11;top: 0;left: 0;width: 100%;height: 100%;display: none;}
        .wxshare .zzz {position: absolute;right: 20px;top: 10px;}
        .pm-header{/*height: 4.667rem;width: 18.667rem;*/margin: 0rem auto;text-align: center;}
        .pm-header img{width:100%;}
        @media screen and (min-width: 375px) and (min-height: 750px) {
            .pm-header{margin-top: 0rem;}
        }
        .res-bg ul{text-decoration: none;list-style: none;overflow: auto;height: 16rem;}
        .res-bg ul li{width: 16rem;display: flex;flex-wrap: nowrap;justify-content: space-between;margin: auto;border-bottom: 0.0625rem solid #ffe1a4;padding: 0.325rem 0;align-items: center;}
        .res-bg ul li:last-child {border-bottom:0;}
        .res-bg ul li img{display:inline-block;width:1.4rem;height:1.4rem;line-height: 2rem;border-radius: 50%;overflow: hidden;border:0.0625rem solid #ddd;margin-right: 0.2rem;}
        .res-bg ul li span{display:inline-block;height:1.4rem;line-height: 1.4rem;position:relative;top:-0.485rem;left:0;}
        .res-bg .pcenter{flex: 1;text-align: center;}
        .res-bg .pcenter p{display: inline-block;width:3.511rem;line-height: 1.65rem;height:1.4rem;font-size: 0.73rem;overflow: hidden;/*font-family: MicrosoftYaHei;*/}
        .res-bg .pright{width: 2rem;height: 2rem;}
        .res-bg .pright i{position:relative;display: block;width: 2rem;height:2rem;background-size: 100% 100%;background-repeat: no-repeat;}
        .res-bg .pright .pm1{background-image: url("/Public/images/medal-01.png");}
        .res-bg .pright .pm2{background-image: url("/Public/images/medal-02.png");}
        .res-bg .pright .pm3{background-image: url("/Public/images/medal-03.png");}
        .res-bg .pright span{width: 100%;display: block;text-align: center;font-size:0.7em;padding-top:0.4rem;color:#444;}
        .res-bg .pright img {display: block;width:1.2rem;height:1.2rem;padding-top:0.4rem;}

        .rr-btn{margin: 1.147rem auto;	width: 16rem;height: 2.133rem;
            background-image: url("/Public/images/share.png");background-repeat: no-repeat;background-size: 100% 100%;}
        a{display: none !important;}

        .form-title {font-size:0.8rem;display: block;width:16rem;height:2.2rem;background-color: #f6d288;margin:auto;border-radius: 1.1rem;border:2px solid #ffe1a4;color:#fff;padding:0.55rem 0.33rem;}
        .form-title label {display: inline-block;width:3.511rem;/*height:2.2rem;line-height: 2.2rem;*/text-align: center;border-right:#E0AF4A 1px solid;}
        .form-title label:last-child {border-right:0;}
    </style>
</head>
<body>
<div class="bimg100 rbg">
    <div class="pm-header">
        <img src="/Public/images/test-head.png">
    </div>
    <div class="res-bg">
        <div class="res-qrcode">
            <img src="<?php echo ($memberinfo['avatar_url']); ?>">
        </div>
        <div class="jfen"><?php echo ($memberinfo['nick_name']); ?></div>
        <div class="form-title">
            <label>用户名</label>
            <label>积分数</label>
            <label>转发数</label>
            <label>排名</label>
        </div>
        <ul class="pmore">
                <?php if(is_array($pmList)): $i = 0; $__LIST__ = $pmList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                          
                          <div class="pcenter">
                              <p><img src="<?php echo ($vo["avatar_url"]); ?>"><span><?php echo ($vo["nick_name"]); ?></span></p>
                              <p><?php echo ($vo["score"]); ?></p>
                              <p><?php echo ($vo["share"]); ?></p>
                              <p><?php echo ($vo["pm"]); ?></p>
                          </div>
                      </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
        
       <!-- <div class="remark">注：每邀请一位好友答题，可获得3积分</div>-->
    </div>
    <div class="rr-btn" onclick="doShare()"></div>
    <!--<div class="res-btn" onclick="doShare()">邀请更多好友领红包</div>-->
    <div class="wxshare" onclick="closeShare()">
        <div class="zzz"><img src="/Public/images/icon-wxshare.png" height="150"></div>
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
    var total_page = <?php echo ($count_page); ?>;
    var current_page = <?php echo ($current_page); ?>;
    var rflag = true;
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
    function closeShare(){
        $(".wxshare").hide();
    }
    function doShare() {
        $(".wxshare").show();
    }
    function lqhb(mid){
        $.post('/Mobile/Index/getRedPackage',{mid:mid},function(res){
            if(res.code == 200){
                alert("领取成功");
                window.location.reload();
            }else{
                alert(res.message);
            }
        });
    }
    function doShare1(){
        wx.showOptionMenu();
        /** 分享到朋友圈 */
        wx.onMenuShareTimeline({
            title: sremark,
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

    function nextMore(){
        if(total_page == current_page-1 || !rflag){
            return false;
        }
        rflag = false;
        $.get('/Mobile/Index/getList',{page:current_page},function(res){
            rflag = true;
            if(res.code == 200) {
                var html = '';
                var res_data = res.data.list;
                current_page = res.data.currentPage;

                for (var i = 0; i < res_data.length; i++) {
                    html += '<li><img src="' + res_data[i].avatar_url + '"><div class="pcenter"><span>昵称：';
                    html += res_data[i].nick_name + '</span><span>分数：' + res_data[i].score + '</span></div><div class="pright"><span>' + res_data[i].pm + '</span></div></li>';
                }
                $(".pmore").append(html);
            }
        })
    }
    $(document).ready(function (){
        var nScrollHight = 0; //滚动距离总长(注意不是滚动条的长度)
        var nScrollTop = 0;   //滚动到的当前位置
        var nDivHight = $(".pmore").height();

        $(".pmore").scroll(function(){
            nScrollHight = $(this)[0].scrollHeight;
            nScrollTop = $(this)[0].scrollTop;
            if(nScrollTop + nDivHight >= nScrollHight-50){
//                console.log(nScrollTop+' + '+nDivHight+' >= '+nScrollHight);
                nextMore();
            }
        });
    });
</script>
<script src="https://s19.cnzz.com/z_stat.php?id=1273138391&web_id=1273138391" language="JavaScript"></script>
</body>
</html>