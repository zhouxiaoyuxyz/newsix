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
			<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			六享到家
		</div>
		<div class="top-signed">
			<a href="<?php echo U('message/index');?>"><i class="icon-envelope"></i></a>
		</div>
	</header>
    <script>
		$(function(){
			$("#search-bar li").each(function(e){
				$(this).click(function(){
					if($(this).hasClass("on")){
						$(this).parent().find("li").removeClass("on");
						$(this).removeClass("on");
						$(".serch-bar-mask").hide();
					}
					else{
						$(this).parent().find("li").removeClass("on");
						$(this).addClass("on");
						$(".serch-bar-mask").show();
					}
					$(".serch-bar-mask .serch-bar-mask-list").each(function(i){
						
						if(e==i){
							$(this).parent().find(".serch-bar-mask-list").hide();
							$(this).show();
						}
						else{
							$(this).hide();
						}
						$(this).find("li").click(function(){
							$(this).parent().find("li").removeClass("on");
							$(this).addClass("on");
						});
					});
				});
			});
		});
    </script>
    
    
      
    <div id="filter2" class="filter2">
    <ul class="tab clearfix">
      <li class="item">
        <a href="javascript:void(0);"><span id="str_b_node">选择分类</span><em></em>
        </a>
      </li>
      <li class="item">
        <a href="javascript:void(0);"><span id="str_d_node">选择地区</span><em></em>
        </a>
      </li>
      <li class="item">
        <a href="javascript:void(0);"><span id="str_e_node">选择排序</span><em></em>
        </a>
      </li>
    </ul>
    
    <div class="inner" style=" display:none">
        <ul>
        <li <?php if(empty($cate)): ?>style="color:red;"<?php endif; ?> ><a href="<?php echo LinkTo('ele/index',$linkArr,array('cate'=>0));?>">全部</a></li>
         <?php if(is_array($elecate)): $index = 0; $__LIST__ = $elecate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($index % 2 );++$index;?><li <?php if($cate == $index): ?>style="color:red;"<?php endif; ?> ><a href="<?php echo LinkTo('ele/index',$linkArr,array('cate'=>$index));?>"><?php echo ($item); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
               

            </ul>
    
    </div>
    
    <div class="inner" style=" display:none">
      <ul id="inner2">
        <li class="item">
        <a class="rights" href="<?php echo LinkTo('ele/index',array('cat'=>$cat));?>">全部地区</a>
        </li>
       <?php if(is_array($areas)): foreach($areas as $key=>$var): if($var['city_id'] == $city_id){ ?>         
            <li id="cat_<?php echo ($var['cate_id']); ?>"><a class="rights hasUlLink" title="<?php echo ($var["cate_name"]); ?>" href="javascript:void(0);>"><?php echo ($var["area_name"]); ?></a>
             
               <ul id="items0">  
               <li><a href="<?php echo LinkTo('ele/index',array('cat'=>$cat,'area'=>$area_id));?>" class="<?php if(empty($business_id)): ?>on<?php endif; ?>">全部商圈</a></li>
                <?php if(is_array($bizs)): foreach($bizs as $key=>$product): if($product["area_id"] == $var['area_id']): ?><li><a title="<?php echo ($product["business_name"]); ?>" href="<?php echo LinkTo('ele/index',array('cat'=>$var['cate_id'],'area'=>$var['area_id'],'business'=>$product['business_id']));?>"> <?php echo ($product["business_name"]); ?></a><?php endif; endforeach; endif; ?>
               </ul>
                       
             </li>
                <?php } endforeach; endif; ?>
       
      </ul><!--1级end-->
    
    </div>
    
    <div class="inner" style="display:none;">
              <ul>
              
               <li <?php if(($order) == "a"): ?>style="color:red;"<?php endif; ?> ><a href="<?php echo LinkTo('ele/index',$linkArr,array('order'=>a));?>">智能排序</a></li>
                <li <?php if(($order) == "p"): ?>style="color:red;"<?php endif; ?> ><a href="<?php echo LinkTo('ele/index',$linkArr,array('order'=>q));?>">起送价最低</a></li>
                <li <?php if(($order) == "v"): ?>style="color:red;"<?php endif; ?> ><a href="<?php echo LinkTo('ele/index',$linkArr,array('order'=>v));?>">送餐速度最快</a></li>
                <li <?php if(($order) == "d"): ?>style="color:red;"<?php endif; ?> ><a href="<?php echo LinkTo('ele/index',$linkArr,array('order'=>d));?>">距离最近</a></li>
                <li <?php if(($order) == "s"): ?>style="color:red;"<?php endif; ?> ><a href="<?php echo LinkTo('ele/index',$linkArr,array('order'=>s));?>">销量最高</a></li>
                
          

            </ul>
      </div>
      
      <div id="parent_container" class="inner_parent" style="display:none;">
        <div class="innercontent"></div>
      </div>
      <div id="inner_container" class="inner_child" style="display:none;">
        <div class="innercontent"></div>
      </div>
    
</div>
<!--end-->    

<div id="fullbg" class="fullbg" style="display: none; height: 250px;">
<i class="pull2"></i>
</div>



	<ul id="shop-list" class="shop-list"></ul>

	<script>
	
		showFilter({ibox:'filter2',content1:'parent_container',content2:'inner_container',fullbg:'fullbg'});

		$(document).ready(function () {
			loaddata('<?php echo ($nextpage); ?>', $("#shop-list"), true);
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