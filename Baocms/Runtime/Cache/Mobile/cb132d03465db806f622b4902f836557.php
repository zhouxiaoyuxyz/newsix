<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title><?php if(!empty($mobile_title)): echo ($mobile_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?></title>
        <meta name="keywords" content="<?php echo ($mobile_keywords); ?>" />
        <meta name="description" content="<?php echo ($mobile_description); ?>" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/<?php echo ($ctl); ?>.css?V=2"/>
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>
	    <script src="/static/default/wap/js/mobile_common.js"></script>
        <script src="/static/default/wap/js/iscroll-probe.js"></script>
        <?php $lng = $_COOKIE['lng']; $lat = $_COOKIE['lat']; ?>
        <?php if(empty($lat) || empty($lng)){ ?> 
       <!---- <script>
            function bd_encrypt(gg_lat, gg_lon)   // 百度地图测距偏差 问题修复
            {
                var x_pi = 3.14159265358979324 * 3000.0 / 180.0;
                var x = gg_lon;
                var y = gg_lat;
                var z = Math.sqrt(x * x + y * y) + 0.00002 * Math.sin(y * x_pi);
                var theta = Math.atan2(y, x) + 0.000003 * Math.cos(x * x_pi);
                var bd_lon = z * Math.cos(theta) + 0.0065;
                var bd_lat = z * Math.sin(theta) + 0.006;
                dingwei('<?php echo U("mobile/index/dingwei",array("t"=>$nowtime,"lat"=>"llaatt","lng"=>"llnngg"));?>', bd_lat, bd_lon);
            }

            navigator.geolocation.getCurrentPosition(function (position) {
                //bd_encrypt(position.coords.latitude, position.coords.longitude);
            });
           
        </script>-->
         <?php } ?>
        
	</head>
	<body>

<link href="https://syy.freep.cn/609575/six/style.css" rel="stylesheet" type="text/css"/>
<script src="https://syy.freep.cn/609575/six/http_cdn-bootcss-com_countup-js_1-9-3_countUp.js"></script>
<style>
    .intro {
        display: inline-block;
        font-style: normal;
        border: 1px solid #ff8943;
        border-radius: 2px;
        padding: 0.2rem 0.4rem;
        color: #ff8943;
        font-size: 0.9rem;
        margin: 5px 10px;
    }
    .top-fixed {
        background: transparent;
    }
    .bg-yellow {
        background-color: transparent;
    }
</style>

<script>
    $(function () {
        var options = {
            useEasing: true,
            useGrouping: true,
            separator: ',',
            decimal: '.',
        };
        var demo = new CountUp('money', 0, $("#help_money").text(), 2, 3, options);
        if (!demo.error) {
            demo.start();
        } else {
            console.error(demo.error);
        }
    });

    function applyHelp() {
        console.log("apply help");
    }

</script>

<header class="top-fixed bg-yellow bg-inverse">
    <div class="top-back">
        <a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
    </div>
    <!--<div class="top-title">-->
        <!--互助金-->
    <!--</div>-->
</header>

<span id="help_money" style="display: none">
   <?php echo round($money/100,2);?>
</span>

<section class="aui-flexView">
    <section class="aui-scrollView">
        <div class="aui-head-body">
            <img src="https://syy.freep.cn/609575/six/head.png" alt="">
            <div class="aui-duct-text">
                <h2>医疗互助金</h2>
                <p>多一份参与 多一份保障 让社区温暖你我TA</p>
            </div>
        </div>
        <div class="aui-duct-body">
            <!--<p>互助金 总累积</p>-->
            <h1><span id="money"></span><em>元</em></h1>
            <span>
                <em>医疗互助</em>
                <em>免费门诊</em>
                <em>健康保障</em>
            </span>
            <button onclick="applyHelp()">我要申请</button>
        </div>
        <div class="aui-flex">
            <div class="aui-flex-box">
                <h2>项目介绍</h2>
            </div>
            <div class="aui-arrows">
                <p><a href="#">详细</a></p>
            </div>
        </div>
        <div class="aui-list-duct">
            <div class="aui-title-in">
                <div class="intro">限六享平台用户使用</div>
                <div class="intro">互助金满千元启用</div>
                <div class="intro">银行监管资金使用</div>
                <div class="intro">以社区为单位，由物业申报</div>
            </div>
        </div>

        <div class="aui-flex">
            <div class="aui-flex-box">
                <h2>报销额度</h2>
            </div>
        </div>
        <div class="aui-list-duct">
            <div class="aui-flex">
                <div class="aui-flex-box">
                    <h3>1000<em>元</em></h3>
                    <p>互助资金池</p>
                </div>
                <div class="aui-flex-box">
                    <h4>报销50%</h4>
                    <div class="aui-speed" style="width: 100%"></div>
                </div>
                <div class="aui-flex-box">
                    <span>额度</span>
                    <span>500<em>元</em></span>
                </div>
            </div>

            <div class="aui-flex">
                <div class="aui-flex-box">
                    <h3>5000<em>元</em></h3>
                    <p>互助资金池</p>
                </div>
                <div class="aui-flex-box">
                    <h4>报销45%</h4>
                    <div class="aui-speed" style="width: 90%"></div>
                </div>
                <div class="aui-flex-box">
                    <span>额度</span>
                    <span>2250<em>元</em></span>
                </div>
            </div>

            <div class="aui-flex">
                <div class="aui-flex-box">
                    <h3>10000<em>元</em></h3>
                    <p>互助资金池</p>
                </div>
                <div class="aui-flex-box">
                    <h4>报销40%</h4>
                    <div class="aui-speed" style="width: 80%"></div>
                </div>
                <div class="aui-flex-box">
                    <span>额度</span>
                    <span>4000<em>元</em></span>
                </div>
            </div>

            <div class="aui-flex">
                <div class="aui-flex-box">
                    <h3>30000<em>元</em></h3>
                    <p>互助资金池</p>
                </div>
                <div class="aui-flex-box">
                    <h4>报销35%</h4>
                    <div class="aui-speed" style="width: 70%"></div>
                </div>
                <div class="aui-flex-box">
                    <span>额度</span>
                    <span>10500<em>元</em></span>
                </div>
            </div>

            <div class="aui-flex">
                <div class="aui-flex-box">
                    <h3>50000<em>元</em></h3>
                    <p>互助资金池</p>
                </div>
                <div class="aui-flex-box">
                    <h4>报销30%</h4>
                    <div class="aui-speed" style="width: 60%"></div>
                </div>
                <div class="aui-flex-box">
                    <span>额度</span>
                    <span>15000<em>元</em></span>
                </div>
            </div>

            <div class="aui-flex">
                <div class="aui-flex-box">
                    <h3>100000<em>元</em></h3>
                    <p>互助资金池</p>
                </div>
                <div class="aui-flex-box">
                    <h4>报销20%</h4>
                    <div class="aui-speed" style="width: 50%"></div>
                </div>
                <div class="aui-flex-box">
                    <span>额度</span>
                    <span>20000<em>元</em></span>
                </div>
            </div>

            <div class="aui-flex">
                <div class="aui-flex-box">
                    <h3>500000<em>元</em></h3>
                    <p>互助资金池</p>
                </div>
                <div class="aui-flex-box">
                    <h4>报销10%</h4>
                    <div class="aui-speed" style="width: 40%"></div>
                </div>
                <div class="aui-flex-box">
                    <span>额度</span>
                    <span>50000<em>元</em></span>
                </div>
            </div>
        </div>

    </section>
</section>