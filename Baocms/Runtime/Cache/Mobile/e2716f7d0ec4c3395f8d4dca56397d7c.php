<?php if (!defined('THINK_PATH')) exit(); $mobile_title = $detail['title'].'团购'; ?>
<html xmlns="http://www.w3.org/1999/xhtml" class="am-touch js cssanimations">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="no-cache">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title><?php if(!empty($seo_title)): echo ($seo_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?></title>

<link rel="stylesheet" href="/static/default/amazeui/css/amazeui.min.css">
<link rel="stylesheet" href="/static/default/amazeui/css/style.css"/>
<link rel="stylesheet" href="/static/default/amazeui/css/<?php echo ($ctl); ?>.css"/>
<script src="/static/default/amazeui/js/amazeui.min.js" type="text/javascript"></script>
<script src="/static/default/wap/other/layer.js"></script>
<script src="/static/default/wap/js/public.js"></script>

<!--<script>
      function bd_encrypt(gg_lat, gg_lon)   {
			var page =  "/wap/near/dingwei/lat/"+gg_lat+"/lng/"+gg_lon+".html";
				$.get(page, function (data) {
				}, 'html');
            }
            navigator.geolocation.getCurrentPosition(function (position) {
                bd_encrypt(position.coords.latitude, position.coords.longitude);
            });
        </script>-->
</head>    
<body class="bg am-with-fixed-navbar">
<div class="am-offcanvas user" id="offcanvas">
<div class="am-offcanvas-bar am-offcanvas-bar-overlay">
    <ul class="am-menu-nav">
        <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
        <?php if(empty($MEMBER)): ?><div class="am-u-sm-4 am-list-thumb"><img src="/static/default/amazeui/image/noavatar_small.gif"></div>
            <div class="am-u-sm-8 am-list-main">
                <h3 class="am-list-item-hd">
                 <a href="<?php echo U('passport/login');?>">您还未登录，立即登录?</a><span>
                 <a href="<?php echo U('passport/register');?>" class="d_nouid">还没有注册？ 立即注册</a></span> 
                </h3>
            </div>
        <?php else: ?>
            <div class="am-u-sm-4 am-list-thumb"><img src="<?php echo config_img($MEMBER['face']);?>"></div>
            <div class="am-u-sm-8 am-list-main">
                <h3 class="am-list-item-hd">
                 <a href="<?php echo U('mcenter/member/index');?>"><?php echo ($MEMBER['nickname']); ?></a><span>
                 <a class="d_nouid">余额：<?php echo round($MEMBER['money']/100,2);?></a></span> 
                </h3>
            </div><?php endif; ?>
        </li>
        <li class="am-parent"><a href="<?php echo U('mcenter/information/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>个人设置</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/money/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>账户余额</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/favorites/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>我的收藏</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/coupon/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>优惠券</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/tuan/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>団购</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/eleorder/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>外卖</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/goods/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>商品订单</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/exchange/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>积分兑换</a></li>
        <li class="am-parent"><a href="<?php echo U('mcenter/addrs/index');?>" class="am-icon-angle-right am-icon-sm"><span class="micon"></span>收货地址</a></li>
    </ul>
</div>
</div> 
<!--
<div data-am-widget="gotop" class="am-gotop am-gotop-fixed am-no-layout am-active">
	<a href="#top"><span class="am-gotop-title"></span><i class="am-gotop-icon am-icon-chevron-up"></i></a>
</div>
<header id="header" class="homeHeader page_view">
    <div class="left"><a class="ico-back" href="javascript:history.go(-1);"><span><i></i></span></a></div>
    <div class="cent">
    	<span class="shop_name">产品详情</span>	
    </div>
    <div class="head-icon">
        <a class="ico-search" data-am-collapse="{target: '#homeSearch'}"> <span><i></i></span></a>
        <a class="ico-my" data-am-offcanvas="{target: '#offcanvas'}"> <span><i></i></span></a>
    </div>
</header>
<div class="homeSearch am-collapse" id="homeSearch">
    <div id="new_searchtext">
        <form id="searchForm" method="get" action="<?php echo U('tuan/index');?>">
            <input id="keyword" class="inp-search" name="keyword" type="text" placeholder="请输入产品关键字搜索" x-webkit-speech="">
            <input class="btn-search" name="search-btn" type="submit">
        </form>
    </div>
</div>-->


<figure data-am-widget="figure" class="am am-figure am-figure-default "data-am-figure="{  pureview: 'true' }">
	<img src="<?php echo config_img($detail['photo']);?>" data-rel="<?php echo config_img($detail['photo']);?>" />
    <div class="hatudou_com_tuan_title">
        <h1><?php echo bao_Msubstr($detail['title'],0,100,false);?>  </h1>
    </div>
</figure>


<div class="detail">
    <div class="ontop">
    <h2><?php echo bao_Msubstr($detail['intro'],0,100,false);?></h2>
        <!--<ul class="am-avg-sm-2">
            <?php if(!empty($detail['use_integral'])): ?><li class="am-icon-check-circle">该抢购可以使用<?php echo ($detail["use_integral"]); ?>积分</li>
            <?php else: ?>
           	 	<li class="am-icon-check-circle">不支持积分兑换</li><?php endif; ?>
            <?php if(!empty($detail['xiangou'])): ?><li class="am-icon-eye">每人每天限：<?php echo ($detail["xiangou"]); ?> 份</li>
            <?php else: ?>
           	 	<li class="am-icon-eye">支持过期退</li><?php endif; ?>
            <?php if($detail['freebook'] == 1): ?><li class="am-icon-tty">免预约</li>
            <?php else: ?>
           	 	<li class="am-icon-tty">需要提前预约</li><?php endif; ?>
            <li class="am-icon-thumbs-o-up">销售数:<?php echo ($detail["sold_num"]); ?></li>
        </ul>
    </div>
</div>-->
<!--
<div class="blank-10 bg"></div>
<div class="hatudou_com_eval">
    <div class="info"> 
    	<a href="<?php echo U('tuan/dianping',array('tuan_id'=>$detail['tuan_id']));?>"> 
        <span>抢购评论</span> 
            <span class="am-fr"> 
            <em class="star"><i style="width:0%"></i></em> 
            <em><?php echo ($pingnum); ?></em> 条抢购评论 <i class="am-icon-angle-right"></i>
            </span> 
        </a>
    </div>
</div>
<div class="blank-10 bg"></div>-->

<!--<h1 class="tbtj">商家详情</h1>
<div class="detail-info"><div class="info am-cf">
    <div class="info-a">
    	<a href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>">
    <div class="details">
        <h4><?php echo ($shop["shop_name"]); ?>
            <?php if(!empty($shop['is_renzheng'])): ?>【已认证】<?php endif; ?>
        </h4>
        <?php $shopdetails = D('Shopdetails')->find($detail['shop_id']); ?>
        <div class="address">营业时间 : <?php echo ($shopdetails['business_time']); ?></div>
        <div class="address"><?php echo bao_Msubstr($shop['addr'],0,26,false);?></div>
    </div>
    </a>
    </div>
    <div class="am-avg-sm-2">
        <li><a class="am-icon-map-marker" href="<?php echo U('shop/gps',array('shop_id'=>$detail['shop_id']));?>"> 商家位置</a></li>
        <li><a class="am-icon-phone" href="tel:<?php echo ($shop["tel"]); ?>"> 拨打电话</a></li>
    </div>
    </div>
</div>-->

<div align="center"><h1 class="tbtj">今日单-次日达-每日零点截单</h1></div>
<div data-am-widget="gallery" class="detail_con" data-am-gallery="{ pureview: true }"><?php echo ($tuandetails['details']); ?></div>

<div align="center"><h1 class="tbtj">！自提地址请选择自己居住的小区！</h1></div>
<div class="detail_con"><?php echo ($tuandetails['instructions']); ?></div>


<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default  am-no-layout">
    <ul class="b_price am-cf">
      
        <li class="price am-fl"><a href="https://www.enjoysix.cn/mobile/tuan/index.html" class="am-btn am-btn-warning am-radius am-btn-sm">首页</a><div  style="    float: right;    font-size: 25px;    margin-left: 0.5rem;">&yen;<?php echo ($detail["tuan_price"]); ?> <del><!--&yen;<?php echo ($detail["price"]); ?></del>--> <div style="    float: right;    font-size: 13px;    margin-left: 0.5rem;">补生活费&yen;<?php echo ($detail["mobile_fan"]); ?>元</div></li>
        <li class="btn am-fr ">
          <?php if($detail['bg_date'] > $today): ?><a href="javascript:void(0);" class="am-btn am-btn-success am-radius am-btn-sm">即将开始</a>
          <?php else: ?>
            <?php if($detail["num"] < 1 ): ?><a href="javascript:void(0);" class="am-btn am-btn-default am-radius am-btn-sm">卖光了</a>
            <?php else: ?>
                <a href="<?php echo U('tuan/buy',array('tuan_id'=>$detail['tuan_id']));?>" class="am-btn am-btn-warning am-radius am-btn-sm">立即抢购</a><?php endif; endif; ?>  
        </li>
    </ul>
</div>
<!--[if lt IE 9]>
<script src="/static/default/amazeui/js/polyfill/rem.min.js"></script>
<script src="/static/default/amazeui/js/polyfill/respond.min.js"></script>
<script src="/static/default/amazeui/js/amazeui.legacy.js"></script>
<![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/static/default/amazeui/js/jquery.min.js"></script>
<script src="/static/default/amazeui/js/amazeui.min.js"></script>
<!--<![endif]-->

<style type="text/css">
   header.homeHeader {background-color: #06c1ae}
</style>
<script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__'; var BAO_SURL = '<?php echo ($CONFIG['site']['host']); ?>__SELF__'</script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
<script>
$(function(){
	var newurl = BAO_SURL.replace(/\\?\\S+/,'');
	var stitle = "<?php echo bao_Msubstr($detail['title'],0,20,false);?>"; 
	var sdesc = "抢购价：￥<?php echo ($detail["tuan_price"]); ?>                                            补贴水费、物业费：￥<?php echo ($detail["mobile_fan"]); ?>                 下单即送山泉水、消费即返物业费"; 
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
	
	var spic =  "<?php echo ($CONFIG['site']['host']); ?>"+"<?php echo config_img($detail['photo']);?>";
	//var spic = "<?php echo ($CONFIG['site']['host']); ?>"+BAO_PUBLIC+'/img/logo.jpg';
  if(catchpic.length > 0){
		//spic = lcatchpic;
		
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
</body>
</html>