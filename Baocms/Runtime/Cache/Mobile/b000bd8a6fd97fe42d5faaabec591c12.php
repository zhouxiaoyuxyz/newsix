<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; chaRset=utf-8"/>
    <title>新首页</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <!--<link href="https://syy.freep.cn/609575/six/newindex_style.css" rel="stylesheet" type="text/css"/>-->
    <link href="https://syy.freep.cn/609575/six/newindex_style5.css" rel="stylesheet" type="text/css"/>
    <!--<link href="css/style.css" rel="stylesheet" type="text/css"/>-->

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>

    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">

    <!DOCTYPE html>
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

    <style>

        .main_menu img {
            height: 15vw;
            width: 15vw;
            border-radius: 15px;
            margin: 5px;
            /*background: #D8D8D8;*/
        }

        .tuan_bg {
            margin: 0 3vw 0;
            width: 94vw;
            height: 38vh;
            /*background: #D8D8D8;*/
            background: url("https://syy.freep.cn/609575/six/daojia_bg.jpg") no-repeat;
            background-size: 100% 100%;
        }

        .tuan_content {
            /*width: 84vw;*/
            height: 42vh;
            background: #F9F9F9;
            background: transparent;
            margin: 3vw 3vw 0 3vw;
            display: flex;
            flex-wrap: wrap;
        }

        .tuan_item {
            width: 31.33%;
            height: 20vh;
            margin: 1%;
            background: white;
            box-shadow: 0 3px 10px #D9D9D9;
            border-radius: 5px;
        }

        .tuan_first_item {
            width: 32.33%;
            height: 20vh;
            margin: 0 1% 1% 0;
            /*background: #D8D8D8;*/
            background: transparent;
        }

        .daojia {
            margin: 7vh 3vw 2vh;
        }

        .foot-fixed {
            height: 7vh;
        }
        body {
            padding: 0;
        }

    </style>


</head>
<body>

<section class="aui-flexView">
    <section class="aui-scrollView">
        <div class="aui-head-body">
            <!--<img src="https://syy.freep.cn/609575/six/head.png" alt="">-->
            <img src="https://syy.freep.cn/609575/six/top_banner.jpg" alt="">
            <!--<div class="aui-duct-text">-->
            <!--<h2>我的生活费</h2>-->
            <!--<p>节约每一笔支出  享受更美好生活</p>-->
            <!--</div>-->
        </div>
        <div class="aui-duct-body">

            <div style="height: 10vh; width: 100%; display: flex; justify-content: space-between">
                <div style="width: 80%; height: 100%; display: flex">
                    <div>
                        <img style="height: 10vh; width: auto; margin: -20px 10px 0 10px; border-radius: 10px"
                             src="<?php echo config_img($MEMBER['face']);?>" alt="">
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-start; margin-top: 15px; margin-left: 5px   ">
                        <span style="font-size: 1.2rem; font-weight: bold"><?php echo bao_msubstr($MEMBER['nickname'],0,10,false);?></span>
                        <!--<span style="font-size: 0.9rem">市直一区</span>-->
                    </div>
                </div>

                <a href="http://www.enjoysix.cn/mobile/community/index" style="width: 20%; height: 100%; margin-top: 15px; margin-right: 5px">
                    <span style="font-size: 0.8rem">修改 <i class="fa fa-pencil-square-o fa-1x"></i></span>
                </a>

            </div>

            <div style="height: 13vh; width: 100%; display: flex; justify-content: space-between">
                <div style="margin-left:10px; width: 50%; height: 100%; display: flex; flex-direction: column; align-items: flex-start;">
                    <div>
                        <span style="font-size: 0.9rem">卡片ID:</span>
                        <span style="font-weight: bold; font-size: 0.9rem; color: #1D74AF">
                            <?php if(!empty($MEMBER['shuicar1'])): echo ($MEMBER["shuicar1"]); ?>
                            <?php else: ?>

                                <?php if(!empty($MEMBER['shuicar2'])): echo ($MEMBER["shuicar2"]); ?>
                                <?php else: ?>
                                    <a href="https://www.enjoysix.cn/mcenter/info/shuicar.html">请绑定水卡</a><?php endif; endif; ?>
                        </span>
                    </div>
                    <div>
                        <span style="font-size: 0.9rem">水余额:</span>
                        <span style="font-weight: bold; font-size: 0.9rem; color: #1D74AF"> <?php echo round($MEMBER['money']/300,0);?></span>
                        <span style="font-size: 0.9rem"> 桶</span>
                    </div>
                    <div>
                        <span style="font-size: 0.9rem">生活费:</span>
                        <span style="font-weight: bold; font-size: 0.9rem; color: #1D74AF"><?php echo round($MEMBER['wy_fanxian']/100,2);?></span>
                        <span style="font-size: 0.9rem"> 元</span>
                    </div>
                </div>
                <div style="width: 60%; height: 100%; display: flex; flex-direction: column; align-items: flex-end; margin-right: 25px; margin-top: -15px">
                    <div>慈善金：<span style="color: #F9872C; font-weight: bold"><?php echo round($helpmoney/100,2);?>元</span></div>
                    <div>
                        <img style="width: 12vw; margin: 5px 25px 0 auto"
                             src="http://tu1.027cgb.com/609575/six/medical2.png" alt="">
                    </div>

                </div>
            </div>

        </div>

        <div class="aui-flex">
            <a href="https://www.enjoysix.cn/mcenter/money/index.html?nav_id=56" class="main_menu">
                <img src="http://tu.027cgb.com/609575/six/recharge_131982393116020390.png" alt="">
                <div style="text-align: center; font-size: 0.8rem">水卡充值</div>
            </a>
            <a href="https://www.enjoysix.cn/mobile/ele/shop/shop_id/71.html?from=singlemessage" class="main_menu">
                <img src="http://tu.027cgb.com/609575/six/six2home_131982393117582890.png" alt="">
                <div style="text-align: center; font-size: 0.8rem">六享到家</div>
            </a>
            <a href="https://www.enjoysix.cn/mobile/shop/help.html?nav_id=59" class="main_menu">
                <img src="http://tu.027cgb.com/609575/six/medical_131982393113832890.png" alt="">
                <div style="text-align: center; font-size: 0.8rem">慈善互助</div>
            </a>
            <a href="" class="main_menu">
                <img src="http://tu.027cgb.com/609575/six/weekend_131982393118676640.png" alt="">
                <div style="text-align: center; font-size: 0.8rem">周末去哪</div>
            </a>
            <a href="http://www.enjoysix.cn/mobile/community/index" class="main_menu">
                <img src="http://tu.027cgb.com/609575/six/community_131982393112426640.png" alt="">
                <div style="text-align: center; font-size: 0.8rem">我的小区</div>
            </a>
        </div>

        <div class="tuan_bg">
            <div style="height:1px; width: 100%; background: white"></div>
            <div class="tuan_content">
                <a href="https://www.enjoysix.cn/mobile/ele/shop/shop_id/71.html?from=singlemessage" class="tuan_first_item"></a>
                <?php if(is_array($daojialist)): foreach($daojialist as $key=>$var): ?><a href="https://www.enjoysix.cn/mobile/ele/shop/shop_id/71.html?from=singlemessage" class="tuan_item">
                        <div style="height: 12vh">
                            <img style="height: 12vh; width: 100%; float: right" src="<?php echo config_img($var['photo']);?>" alt="">
                            <img style="width: 40%; float: right; margin-top: -7vh" src="http://tu1.027cgb.com/609575/six/WechatIMG42.png" alt="">
                        </div>
                        <div style="margin: 3px 3px 5px 3px">
                            <div style="display: flex; justify-content: space-between">
                                <div>
                                    <span style="font-size: 12px; color: #4ca5ef"><?php echo round($var['price']/100,2);?> 元</span>
                                </div>
                                <div>
                                    <span style="font-size: 8px; color: #8c8c8c">月售:<?php echo ($var["sold_num"]); ?>份</span>
                                </div>
                            </div>
                            <div>
                                <span style="font-size: 12px"><?php echo bao_msubstr($var['product_name'],0,7,false);?></span>
                            </div>
                        </div>
                    </a><?php endforeach; endif; ?>

            </div>
        </div>

        <div class="daojia">
            <div>
                <span style="font-size: 1.2rem; font-weight: bold">名牌到家</span>
                <span style="font-size: 0.8rem">品质甄选/今日单·次日达</span>
            </div>

            <div style="display: flex">
                <div style="width: 30vw; height: 45vw; margin-top: 1vw; border-radius: 10px">
                    <img style="width: 30vw; height: 45vw; margin-top: 1vw; border-radius: 10px" src="http://tu1.027cgb.com/609575/six/wherego.png" alt="">
                </div>
                <div style="margin-top: 1vw">
                    <div style="width: 40vw; height: 22vw; margin: 1vw; border-radius: 10px">
                        <img style="width: 40vw; height: 22vw; border-radius: 10px" src="http://tu1.027cgb.com/609575/six/huanxi.png" alt="">
                    </div>
                    <div style="width: 40vw; height: 22vw; margin: 1vw; border-radius: 10px">
                        <img style="width: 40vw; height: 22vw; border-radius: 10px" src="http://tu1.027cgb.com/609575/six/lingyun.png" alt="">
                    </div>
                </div>
                <div style="margin-top: 1vw">
                    <div style="width: 22vw; height: 22vw; margin-top: 1vw; border-radius: 10px">
                        <img style="width: 22vw; height: 22vw; border-radius: 10px" src="http://tu1.027cgb.com/609575/six/cute.png" alt="">
                    </div>
                    <div style="width: 22vw; height: 22vw; margin-top: 1vw; border-radius: 10px">
                        <img style="width: 22vw; height: 22vw; border-radius: 10px" src="http://tu1.027cgb.com/609575/six/more.png" alt="">
                    </div>
                </div>
            </div>
        </div>


        <div class="bottom-banner">
            <img src="http://tu1.027cgb.com/609575/six/bottom_banner.jpg" alt="">
        </div>

    </section>
</section>


<style>
.footer-search{padding:15px;background:#fff;border-bottom:thin solid #eee;padding-bottom:5px}
</style>
<div class="footer">
    <!--<a href="<?php echo U('mcenter/member/index');?>">客户端</a> &nbsp;  &nbsp;-->
    <?php if(!empty($is_shop)): ?><a href="<?php echo U('store/index/index');?>" title="管理商家">管理商家</a>   &nbsp; &nbsp; 
    <?php else: ?>
    <a href="<?php echo U('mcenter/apply/index');?>" title="商家入驻">商家入驻</a>   &nbsp; &nbsp;<?php endif; ?>
    城市：<a class="button button-small text-yellow" href="<?php echo U('city/index');?>"  title="<?php echo bao_msubstr($city_name,0,4,false);?>"><?php echo bao_msubstr($city_name,0,4,false);?></a>                          
</div>

<div class="blank-20"></div>
<?php if($CONFIG[other][footer] == 1): ?><footer class="foot-fixed">
<a class="foot-item <?php if(($ctl) == "index"): ?>active<?php endif; ?>"  href="<?php echo U('index/index');?>">		
<span class="icon icon-home"></span>
<span class="foot-label">首页</span>
</a>



<a class="foot-item <?php if(($ctl) == "shop"): ?>active<?php endif; ?>" href="<?php echo U('community/index');?>">			

<span class="icon icon-paw"></span><span class="foot-label">我的小区</span></a>



<!--<a class="foot-item <?php if(($ctl) == "mall"): ?>active<?php endif; ?>" href="<?php echo U('/mobile/mart/lists/id/36.html');?>">-->			
<a class="foot-item <?php if(($ctl) == "mall"): ?>active<?php endif; ?>" href="https://www.enjoysix.cn/mobile/ele/index.html">	
<span class="icon icon-map-marker"></span><span class="foot-label">六享到家</span></a>



<a class="foot-item <?php if(($ctl) == "mcenter"): ?>active<?php endif; ?>" href="<?php echo U('mcenter/index/index');?>">			

<span class="icon icon-user"></span><span class="foot-label">我的</span></a>



<!--<a class="foot-item <?php if(($ctl) == "biz"): ?>active<?php endif; ?>" href="<?php echo U('index/more');?>">			

<span class="icon icon-ellipsis-h"></span><span class="foot-label">更多</span></a>-->







</footer>

<?php else: endif; ?>



<iframe id="x-frame" name="x-frame" style="display:none;"></iframe>

<script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__'; var BAO_SURL = '<?php echo ($CONFIG['site']['host']); ?>__SELF__'</script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
<script>
$(function(){
	var newurl = BAO_SURL.replace(/\\?\\S+/,'');
	var stitle = "<?php if(!empty($mobile_title)): echo ($mobile_title); endif; echo ($config['title']); ?>_<?php echo ($CONFIG["site"]["sitename"]); ?>"; 
	var sdesc = "<?php echo ($config['sdesc']); ?>"; 
	//alert(stitle);
	var surl = newurl+'?fuid=<?php echo getuid();?>';	
	var catchpic = $('img');
	var lcatchpic = "<?php echo ($CONFIG['site']['host']); ?>" + $('img').eq(0).attr("src");
	$('img').each(function(){
		if($(this).width() >= 60){
			lcatchpic = $(this).attr("src");
			if(lcatchpic.indexOf("http://") < 0){
				lcatchpic = "<?php echo ($CONFIG['site']['host']); ?>" + lcatchpic;
			}
			return false;
		};
	});
	
	var spic = "<?php echo ($CONFIG['site']['host']); ?>"+BAO_PUBLIC+'/img/logo.jpg';
	if(catchpic.length > 0){
		spic = lcatchpic;
		
	}
	console.log(lcatchpic);
	//alert(spic);
	wx.config({
	debug: false,
	appId: '<?php echo ($signPackage["appId"]); ?>',
    timestamp: '<?php echo ($signPackage["timestamp"]); ?>',
    nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
    signature: '<?php echo ($signPackage["signature"]); ?>',
	jsApiList: [
	'checkJsApi',
	'onMenuShareTimeline',
	'onMenuShareAppMessage',
	'onMenuShareQQ',
	'onMenuShareWeibo',
	'onMenuShareQZone'
	]
	});
	wx.ready(function(){
		wx.onMenuShareTimeline({
			title: stitle, 
			link: surl, 
			imgUrl: spic,
			success: function () { 
				alert("分享成功!");
			},
			cancel: function () { 
				alert("分享失败!");
			}
		});
		wx.onMenuShareAppMessage({		
			title: stitle,
			desc: sdesc, 
			link: surl, 
			imgUrl: spic,
			type: '', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () { 
				alert("分享给朋友成功!");
			},
			cancel: function () { 
				alert("分享给朋友失败!");
			}
		});
		wx.onMenuShareQQ({
			title: stitle,
			desc: sdesc, 
			link: surl, 
			imgUrl: spic,
			success: function () { 
			   alert("分享到QQ成功!");
			},
			cancel: function () { 
			   alert("分享到qq失败!");
			}
		});
		wx.onMenuShareWeibo({
			title: stitle,
			desc: sdesc, 
			link: surl, 
			imgUrl: spic,
			success: function () { 
			  alert("分享到微博成功!");
			},
			cancel: function () { 
				alert("分享到微博失败!");
			}
		});	
		wx.onMenuShareQZone({
			title: stitle,
			desc: sdesc, 
			link: surl, 
			imgUrl: spic,
			success: function () { 
			   alert("分享到QQ空间成功!");
			},
			cancel: function () { 
				alert("分享到QQ空间失败!");
			}
		});	
	});
})	
</script>	 

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?03df3b3159a744adbb89c10a959f5e24";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>

</html>


</body>
</html>