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
<script src="/static/default/wap/other/roll.js"></script>
<header class="top-fixed bg-yellow bg-inverse">
	<div class="top-back">
		<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
	</div>
	<div class="top-title">
		生活信息
	</div>
	<div class="top-search" style="display:none;">
		<form method="post" action="<?php echo U('life/search');?>">
			<input name="keyword" placeholder="输入信息的关键字"  />
			<button type="submit" class="icon-search"></button> 
		</form>
	</div>
	<div class="top-signed">
		<a id="search-btn" href="javascript:void(0);"><i class="icon-search"></i></a>
	</div>
</header>
<div id="index-cate" class="index-cate">
	<script>
		$(function(){
			$("#search-btn").click(function(){
				if($(".top-search").css("display")=='block'){
					$(".top-search").hide();
					$(".top-title").show(200);
				}
				else{
					$(".top-search").show();
					$(".top-title").hide(200);
				}
			});
			$("#index-cate .cate-more").click(function(){
				$(this).parent().children().find(".more-content").toggle();
				if($(this).hasClass("active")){
					$(this).removeClass("active");
					$(this).children().find("span").html("展开更多");
				}
				else{
					$(this).addClass("active");
					$(this).children().find("span").html("点击收起");
				}
			});
		});
	</script>
    
    
  

    <ul class="cate-wrap bbOnepx">
        <li>
            <a class="icon2" href="/mobile/appoint/index.html" tongji_tag="m_home_job_new">
                <span class="cate-img" id="job"><img src="/static/default/wap/image/life/life_cate_1.png" /></span>
                <span class="cate-desc">维修服务</span>
            </a>
        </li>
        <li>
             <a class="icon2" href="/mobile/appoint/index.html" tongji_tag="m_home_job_new">
                <span class="cate-img" id="house"><img src="/static/default/wap/image/life/life_cate_2.png" /></span>
                <span class="cate-desc">家庭服务</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="/mobile/appoint/index.html" tongji_tag="m_home_car_new">
                <span class="cate-img" id="car"><img src="/static/default/wap/image/life/life_cate_3.png" /></span>
                <span class="cate-desc">汽车服务</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="/mobile/appoint/index.html" tongji_tag="m_home_sale_new">
                <span class="cate-img" id="sale"><img src="/static/default/wap/image/life/life_cate_4.png" /></span>
                <span class="cate-desc">婚庆服务</span>
            </a>
        </li>
        <!--<li>
            <a class="icon2" href="<?php echo U('life/channel',array('channel'=>6));?>" tongji_tag="m_home_jianzhi_new">
                <span class="cate-img" id="jianzhi"><img src="/static/default/wap/image/life/life_cate_5.png" /></span>
                <span class="cate-desc">兼职</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('life/channel',array('channel'=>10));?>" tongji_tag="m_home_pets_new">
                <span class="cate-img" id="pets"><img src="/static/default/wap/image/life/life_cate_6.png" /></span>
                <span class="cate-desc">宠物</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('life/channel',array('channel'=>9));?>" tongji_tag="m_home_shenghuo_new">
                <span class="cate-img" id="jiazheng"><img src="/static/default/wap/image/life/life_cate_7.png" /></span>
                <span class="cate-desc">家政</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('life/channel',array('channel'=>8));?>" tongji_tag="m_home_bendishenghuo_new">
                <span class="cate-img" id="shenghuo"><img src="/static/default/wap/image/life/life_cate_8.png" /></span>
                <span class="cate-desc">本地</span>
            </a>
        </li><!--分类开始-->
    </ul>
    <div class="blank-10 bg"></div>
    
	<div class="tie-ding">
		<ul>
		<?php  $cache = cache(array('type'=>'File','expire'=> 600)); $token = md5("Life,closed=0 AND audit=1 AND  city_id=$city_id,create_time desc,0,5,600,,"); if(!$items= $cache->get($token)){ $items = D("Life")->where("closed=0 AND audit=1 AND  city_id=$city_id")->order("create_time desc")->limit("0,5")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><li><em class="tag bg-dot">推荐</em><a href="<?php echo U('life/detail',array('life_id'=>$item['life_id']));?>"><?php echo bao_msubstr($item['title'],0,10,false);?></a><span class="icon-angle-right"></span></li> <?php endforeach; ?>	
		</ul>
	</div>
    
    <div class="blank-10 bg"></div>
	<?php $ii = 0; ?>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$arr): $mod = ($i % 2 );++$i; $ii++; ?>
	<ul>
		<li class="cate-name">
			<a href="<?php echo U('life/channel',array('channel'=>$key));?>">
				<img src="/static/default/wap/image/life/cate-<?php echo ($ii); ?>.png" />
				<span><?php echo ($arr['channel']); ?></span>
				<span class="float-right text-gray"><i class="icon-angle-right"></i></span>
			</a>
		</li>
		<li class="cate-list">
			<?php $on=false;$num=count($arr['cate']); ?>
			<?php if(is_array($arr['cate'])): $i = 0; $__LIST__ = $arr['cate'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i; if($key < 12): ?><a href="<?php echo U('life/lists',array('cat'=>$cate['cate_id']));?>"><?php echo ($cate["cate_name"]); ?></a>
				<?php else: ?>
					<?php if(!$on): ?><span class="more-content" style="display:none;">
						<?php $on=true; endif; ?>
					<a href="<?php echo U('life/lists',array('cat'=>$cate['cate_id']));?>"><?php echo ($cate["cate_name"]); ?></a>
					<?php if(count($arr['cate']) == $key+1): ?></span><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
		</li>
		<?php if(($key > 12) AND ($num > 12)): ?><li class="cate-more"><a href="javascript:;"><span>展开更多</span><i class="down icon-angle-down"></i><i class="up icon-angle-up"></i></a></li><?php endif; ?>
		<li class="blank-10 bg"></li>
	</ul><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div class="mall-cart">
		<a href="<?php echo u('life/release');?>">
		<div class="round radius-circle"><div class="badge-corner"><i class="icon-pencil-square-o"></i></div></div>
		</a>
	</div>
    
    

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