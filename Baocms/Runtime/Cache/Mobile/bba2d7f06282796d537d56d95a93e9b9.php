<?php if (!defined('THINK_PATH')) exit(); $mobile_title = $detail['name']; ?>
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
	<script src="/static/default/wap/other/roll.js"></script>
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			<?php echo ($detail["name"]); ?>
		</div>
		<div class="top-signed">
          <a href="<?php echo U('community/index',array('change'=>1));?>" class="top-addr icon-navicon"> 切换</a>
		</div>
	</header>

 
 
 
 <div class="tuan-detail">
<div class="line banner">	


<?php if(!empty($ads)): ?><div id="focus" class="focus">
		<div class="hd"><ul></ul></div>
		<div class="bd">
			<ul>
                <?php if(is_array($ads)): foreach($ads as $key=>$item): ?><li><a href="<?php echo U('app/ad/community_click',array('ad_id'=>$item['ad_id'],'aready'=>2));?>"><img src="__ROOT__/attachs/<?php echo ($item["photo"]); ?>" /></a></li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div>
<?php else: ?>    
    <div id="focus" class="focus">
		<div class="hd"><ul></ul></div>
		<div class="bd">
			<ul><li><a href="javascript:void(0);"><img src="__ROOT__/attachs/<?php echo ($detail[pic]); ?>" /></a></li>
			</ul>
		</div>
	</div><?php endif; ?>     
			<div class="title">
				<h1><?php echo bao_msubstr($detail['name'],0,10);?>
                <?php $village_ids = D('Village') -> where('village_id ='.$detail['village_id']) -> find(); $village_name = $village_ids['name']; ?>
              <?php if(!empty($detail['village_id'])): ?><a style="color:#FFF; font-size:12px;" href="<?php echo U('village/detail',array('village_id'=>$detail['village_id']));?>">(<?php echo ($village_name); ?>)</a>
              <?php else: ?>
            <!-- <a style="color:#FFF; font-size:12px;">（未加入社区）</a>--><?php endif; ?>   
                </h1>
				<p><?php echo bao_msubstr($detail['name'],0,10);?>有业主<?php echo ($user_owner); ?>人，邻居<?php echo ($counts); ?>人。
                <?php if(!empty($products_pay)): ?><a style="color:#FFF;" href="<?php echo U('mcenter/community/order');?>">您有待缴费<?php echo ($products_pay); ?>单</a>。
                <?php else: endif; ?>
                
                </p>
			</div>	
		</div>
</div>            
            
  
	<script type="text/javascript">
		TouchSlide({ 
			slideCell:"#focus",
			titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
			mainCell:".bd ul", 
			effect:"left", 
			autoPlay:true,//自动播放
			autoPage:true, //自动分页
			switchLoad:"_src" //切换加载，真实图片路径为"_src" 
		});
	</script>

	<!--小区广告结束-->
    




	<div class="cite-title padding border-bottom">
		<h5><i class="icon-building"></i><?php echo ($detail["name"]); ?> </h5>
         <?php if($isjoin != 0): ?><a href="<?php echo U('community/neighbor',array('community_id'=>$detail['community_id']));?>">找邻居 <i class="icon-angle-right"></i></a>
         <?php else: ?>
         <a href="<?php echo U('community/join',array('community_id'=>$detail['community_id']));?>">加入小区 <i class="icon-angle-right"></i></a><?php endif; ?>
	</div>
	<div class="xiaoqu-nav line">
		<!--<div class="x3 border-right">
           <a href="<?php echo U('mcenter/community/order');?>">
    			<img src="/static/default/wap/image/index/app-community.png" />
                
                <?php if(!empty($products_pay)): ?><span class="badge bg-red jiaofei" onclick="location='<?php echo U('mcenter/community/order');?>'"><?php echo ($products_pay); ?></span>
                <?php else: endif; ?>
                
    			<p>惠缴费</p>
    		</a>
		</div>-->

		<div class="x3 border-right">
    		<a href="<?php echo U('mobile/biz/index',array('type'=>2));?>">
    			<img src="/static/default/wap/image/index/app-near.png" />
    			<p>周边快递</p>
    		</a>
		</div>
		<!--<div class="x3 border-right">
        <a href="<?php echo U('community/feedback',array('community_id'=>$detail['community_id']));?>">
				<img src="/static/default/wap/image/community/admin.png" />
    			<p>报事报修</p>
    		</a> 
		</div>-->
        
       
        <?php if($isjoin != 0): ?><div class="x3 border-right">
        <a href="<?php echo U('mcenter/community/order');?>">
    			<img src="/static/default/wap/image/index/app-sqyz.png" />
    			<p>对账单</p>
    		</a> 
		</div>
		 <div class="x3 border-right">
        <a href="<?php echo U('community/out',array('community_id'=>$detail['community_id']));?>">
				<img src="/static/default/wap/image/community/exit.png" />
    			<p>撤离小区</p>
    		</a> 
		</div>
        <?php else: ?>
        <div class="x3 border-right">
        <a href="<?php echo U('community/owner',array('community_id'=>$detail['community_id']));?>">
    			<img src="/static/default/wap/image/index/app-nearwork.png" />
    			<p>申请业主</p>
    		</a> 
		</div><?php endif; ?>
        
		<div class="x3 border-right">
         <a href="<?php echo U('life/lists',array('cat'=>47));?>">
    			<img src="/static/default/wap/image/index/app-life.png" />
    			<p>便民信息</p>
    		</a>
            
    		
		</div>
		<div class="x3 border-right">
    		<a href="<?php echo U('community/contact',array('community_id'=>$detail['community_id']));?>">
				<img src="/static/default/wap/image/community/feed.png" />
    			<p>办事指南</p>
    		</a> 
		</div>
		<div class="x3 border-right">
        <a href="<?php echo U('mobile/community/pinche',array('community_id'=>$detail['community_id']));?>">
    			<img src="/static/default/wap/image/index/app-game.png" />
    			<p>小区拼车</p>
    		</a>
        
       
            
		</div>
		<!--<div class="x3 border-right">
    		 <?php if($isjoin != 0): ?><a href="<?php echo U('community/out',array('community_id'=>$detail['community_id']));?>">
				<img src="/static/default/wap/image/community/exit.png" />
    			<p>撤离邻居</p>
    		</a> 
			<?php else: ?>
    		<a href="<?php echo U('community/join',array('community_id'=>$detail['community_id']));?>">
				<img src="/static/default/wap/image/community/plus.png" />
    			<p>加入邻居</p>
    		</a><?php endif; ?> 
		</div>-->
        
        
        
       <!-- <div class="x3 border-right">
         <a href="<?php echo U('community/tuan',array('community_id'=>$detail['community_id']));?>">
    			<img src="/static/default/wap/image/index/app-tuan.png" />
    			<p>小区抢购</p>
    		</a>
		</div>
		<div class="x3 border-right">
    		<a href="<?php echo U('community/ele',array('community_id'=>$detail['community_id']));?>">
				<img src="/static/default/wap/image/index/app-ele.png" />
    			<p>小区外卖</p>
    		</a> 
		</div>
		<div class="x3 border-right">
        <a href="<?php echo U('community/weidian',array('community_id'=>$detail['community_id']));?>">
    			<img src="/static/default/wap/image/index/app-mart.png" />
    			<p>小区微店</p>
    	</a>
		</div>-->
		<div class="x3 border-right">
    		<a href="<?php echo U('mobile/appoint/index');?>">
				<img src="/static/default/wap/image/index/app-housekeeping.png" />
    			<p>小区家政</p>
    		</a> 
		</div>
        
        
        
        
        

	</div>
	
	<div class="blank-10 bg"></div>
	<!--<div class="cite-title padding border-bottom">
		<h5><i class="icon-bullhorn"></i> 物业通知</h5>
		<a href="<?php echo U('community/newslist',array('community_id'=>$detail['community_id']));?>">+ 更多</a>
	</div>-->
	<div class="text-list">
		<ul>
			<?php if(is_array($news)): foreach($news as $key=>$item): ?><li class="padding border-bottom">
				<a href="<?php echo U('community/news',array('news_id'=>$item['news_id']));?>"><?php echo bao_Msubstr($item['title'],0,14,false);?><span><?php echo (date('Y-m-d',$item["create_time"])); ?></span></a>
			</li><?php endforeach; endif; ?>
		</ul>
	</div>
	<div class="blank-10 bg"></div>
		
	<div class="cite-title padding border-bottom">
		<h5><i class="icon-phone"></i>  便民电话</h5>
		<a href="<?php echo U('community/together',array('community_id'=>$detail['community_id']));?>">+ 合作</a>
	</div>
	<div class="text-list">
		<ul>
			<?php if(is_array($phones)): $index = 0; $__LIST__ = $phones;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var): $mod = ($index % 2 );++$index;?><li class="padding border-bottom">
				<a class="line" title="<?php echo ($var["name"]); ?>" href="tel:<?php echo ($var["phone"]); ?>">
					<em class="x4"><?php echo bao_Msubstr($var['name'],0,4,false);?></em>
					<em class="x8"><?php echo ($var["phone"]); ?> <span><i class="icon-angle-right"></i></span></em>
				</a> 
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="blank-10 bg"></div>
	<div class="cite-title padding border-bottom">
		<h5><i class="icon-fire"></i>  小区生鲜</h5>
		<a href="javascript:void(0);" onclick="refresh();"><i class="icon-refresh"></i> 换一换</a>
	</div>
	<div class="mart-flush" id="flush">
		<div class="bd">
			<ul>
				<?php if(is_array($keys)): $i = 0; $__LIST__ = $keys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$k): $mod = ($i % 2 );++$i;?><li class="padding">
						<a class="line" href="<?php echo U('tuan/detail',array('tuan_id'=>$tuan[$k]['tuan_id']));?>">
							<div class="x5"><img src="/attachs/<?php echo ($tuan[$k]['photo']); ?>"></div>
							<div class="x7">
								<p><?php echo ($tuan[$k]['title']); ?></p>
								<p>
								<span class="text-yellow margin-right">￥<?php echo round($tuan[$k]['tuan_price']/100,2);?></span>
								<del class="text-gray text-small">￥<?php echo round($tuan[$k]['price']/100,2);?></del>
								</p>
							</div>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div><!---->
	<div class="blank-10 bg"></div>
	
	
	
	

	<script>	
		$(document).ready(function () {
			TouchSlide({ 
				slideCell:"#roll",
				titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
				mainCell:".bd ul", 
				effect:"left", 
				autoPlay:false,//自动播放
				autoPage:true, //自动分页
			});
			TouchSlide({ 
				slideCell:"#flush",
				mainCell:".bd ul", 
				effect:"left", 
				autoPlay:false,//自动播放
				autoPage:false, //自动分页
			});
			
			$(document).ready(function () {
				loaddata('<?php echo ($nextpage); ?>', $("#tie-list ul"), true);
			});

		});
		
		function refresh(){
			var width = $('#flush .bd li').width() + 20;
			var offset = 0 -( Math.ceil(Math.random()*9) * width );
			var css = "translateX("+offset+"px)";
			$('#flush .bd ul').css("transform",css);
		}

	</script>
		

	<div class="cite-title padding border-bottom">
		<h5><i class="icon-comments"></i> 小区交流</h5>
		<a href="<?php echo U('community/tieba',array('community_id'=>$detail['community_id']));?>">+ 进入</a>
	</div>
	<div id="tie-list" class="text-list">
		<ul>
		</ul>
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