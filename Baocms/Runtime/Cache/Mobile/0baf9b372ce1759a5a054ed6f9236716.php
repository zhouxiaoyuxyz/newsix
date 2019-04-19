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
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('shop/breaks',array('shop_id'=>$shop['shop_id']));?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			买单订单
		</div>
	</header>

	<form class="pay-form" action="<?php echo U('shop/breakspay2',array('order_id'=>$order['order_id']));?>" method="post"  target="x-frame">
		<div class="row">
			<span class="float-left">消费金额：</span>
			<span class="float-right">&yen;<?php echo ($order["amount"]); ?>元</span>
		</div>
        <hr/>
        <!--<div class="row">
			<span class="float-left">不参与优惠金额：</span>
			<span class="float-right">&yen;<?php echo ($order["exception"]); ?>元</span>
		</div>
        <hr/>-->
        <div class="row">
			<span class="float-left">总需金额：</span>
			<span class="float-right">&yen;<?php echo ($order["need_pay"]); ?>元</span>
		</div>
        <hr/>
        <div class="row">
			<span class="float-left">返现金额：</span>
            <?php $zhekou = D('Shopyouhui')->get_amount($shop['shop_id'], $order['amount'], $order['exception']); ?>
			<span class="float-right">&yen;<?php echo ($order["fx_money"]); ?>元</span>
		</div>
	
        
        
		
       <!--填写END-->
		<ul id="pay-method" class="pay-method">
			<?php if(is_array($payment)): foreach($payment as $key=>$var): ?><li data-rel="<?php echo ($var["code"]); ?>" class="media media-x payment <?php if($var["code"] == weixin): ?>active<?php endif; ?>" <?php if($var["code"] == money): ?>style="display:none;"<?php endif; ?> >
				<a class="float-left"  href="javascript:;">
					<img src="/static/default/wap/image/pay/<?php echo ($var["mobile_logo"]); ?>">
				</a>
				<div class="media-body">
					<div class="line">
						<div class="x10">
						<?php echo ($var["name"]); ?><p>推荐已安装<?php echo ($var["name"]); echo ($var["id"]); ?>客户端的用户使用</p>
						</div>
						<div class="x2">
							<span class="radio txt txt-small radius-circle bg-green"><i class="icon-check"></i></span>
						</div>
					</div>
				</div>
			</li><?php endforeach; endif; ?>
         
          <!--
          <li data-rel="ccb" class="media media-x payment">
				<a class="float-left" href="javascript:;">
					<img src="/static/default/wap/image/pay/ccb_mobile.png">
				</a>
				<div class="media-body">
					<div class="line">
						<div class="x10">
							建行支付<p>推荐安装建行手机客户端的用户使用</p>
						</div>
						<div class="x2">
							<span class="radio txt txt-small radius-circle bg-green"><i class="icon-check"></i></span>
						</div>
					</div>
				</div>
			</li>
          -->
			<!--<li data-rel="wait" class="media media-x payment">
				<a class="float-left" href="javascript:;">
					<img src="/static/default/wap/image/pay/dao.png">
				</a>
				<div class="media-body">
					<div class="line">
						<div class="x10">
						货到付款<p>如果您没有网银，可以到店付</p>
						</div>
						<div class="x2">
							<span class="radio txt txt-small radius-circle bg-green"><i class="icon-check"></i></span>
						</div>
					</div>
				</div>
			</li>-->
		</ul>
		<input id="code" type="hidden" name="code" value="" />
		
		<div class="text-center padding-left padding-right margin-large-top">
			<button type="submit" id="submit" class="button button-big button-block bg-yellow  submit">提交订单</button>
		</div>
		
		<div class="blank-20"></div>
	</form>
</div>
<script>
		$("#pay-method li").click(function(){
			var code = $(this).attr("data-rel");
			$("#code").val(code);
			$("#pay-method li").each(function(){
				$(this).removeClass("active");
			});
			$(this).addClass("active");
			var needpay= <?php echo ($order["need_pay"]); ?>;
			if(needpay==0){
			$("#code").val('money');
			}
          
		});
  
  $("#submit").click(function(){
			var needpay= <?php echo ($order["need_pay"]); ?>;
			if(needpay==0){
			$("#code").val('money');
			}
    		if($("#code").val()==""){
			$("#code").val('weixin');
			}
		});
    </script>

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