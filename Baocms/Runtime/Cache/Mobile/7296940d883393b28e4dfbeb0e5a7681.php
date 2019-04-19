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
<link rel="stylesheet" href="/static/default/wap/css/bootstrap.css">
<script src="/static/default/wap/js/jquery.js"></script>
<script src="/static/default/wap/js/bootstrap.js"></script>


<style>
    .line li {padding: 0px !important;}
    .cate-wrap{font-size:0;background-color:#FDF1DE;border-bottom:0;width:100%;overflow:hidden;}
    .cate-wrap li{box-sizing:border-box;width:20%;float:left}
    .icon2{color:#555;font-size:16px;text-align:center;display:block;padding:.6rem 0}
    .cate-img{background-size:6rem auto;display:inline-block}
    .cate-img img{width:2.6rem;height:2.6rem}
    .cate-desc{display:block}
    .cate-desc{padding-top:.4rem}
    .focus .hd {top: 40px;}
    .focus .bd li img {max-height: 60px;}
</style>
<header class="top-fixed bg-yellow bg-inverse">
    <div class="top-back">
        <a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
    </div>
    <?php if(empty($keyword)): ?><div class="top-title">六享直营</div><?php endif; ?>
    <div class="top-search" style="<?php if(empty($keyword)): ?>display:none;<?php endif; ?>">
    <form method="post" action="<?php echo U('tuan/index');?>">
        <input name="keyword" placeholder="<?php echo (($keyword)?($keyword):'输入商品的关键字'); ?>"  />
        <button type="submit" class="icon-search"></button>
    </form>
    </div>
    <?php if(empty($keyword)): ?><div class="top-signed">
            <a id="search-btn" href="javascript:void(0);"><i class="icon-search"></i></a>
        </div><?php endif; ?>
</header>
<!--39到61张义念加上的广告指引图片--><style type="text/css">
    * {
        margin: 0;
        padding: 0;
    }
    .demo {
        width: 100%;
        height: 100%;
        max-width: 760px;
    }
    .demo img{
        width: 100%;
        height: 62.5%;
    }
</style>

<body>
<div class="demo">
   <a href="http://www.enjoysix.cn/mobile/huodong/index/cat/10.html "><img src="http://img.027cgb.com/609575/%E7%94%B3%E8%AF%B7%E6%88%90%E4%B8%BA%E5%9B%A2%E9%95%BF.jpg
"/>
</div>
</body>

<!----><?php if(empty($cat) && empty($business_id) && empty($order) && empty($keyword)): ?><ul class="cate-wrap bbOnepx" style="margin-bottom: 0">
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>1));?>" tongji_tag="m_home_job_new">
                <span class="cate-img" id="job"><img src="/static/default/wap/image/tuan/tuan_cate_1.png" /></span>
                <span class="cate-desc">水果</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>6));?>" tongji_tag="m_home_house_new">
                <span class="cate-img" id="house"><img src="/static/default/wap/image/tuan/tuan_cate_2.png" /></span>
                <span class="cate-desc">奶类</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>35));?>" tongji_tag="m_home_car_new">
                <span class="cate-img" id="car"><img src="/static/default/wap/image/tuan/tuan_cate_3.png" /></span>
                <span class="cate-desc">米面粮油</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>33));?>" tongji_tag="m_home_sale_new">
                <span class="cate-img" id="sale"><img src="/static/default/wap/image/tuan/tuan_cate_4.png" /></span>
                <span class="cate-desc">乡情</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>42));?>" tongji_tag="m_home_jianzhi_new">
                <span class="cate-img" id="jianzhi"><img src="/static/default/wap/image/tuan/tuan_cate_5.png" /></span>
                <span class="cate-desc">零食</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>14));?>" tongji_tag="m_home_pets_new">
                <span class="cate-img" id="pets"><img src="/static/default/wap/image/tuan/tuan_cate_6.png" /></span>
                <span class="cate-desc">海产</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>12));?>" tongji_tag="m_home_shenghuo_new">
                <span class="cate-img" id="jiazheng"><img src="/static/default/wap/image/tuan/tuan_cate_7.png" /></span>
                <span class="cate-desc">日用</span>
            </a>
        </li>
        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>3));?>" tongji_tag="m_home_bendishenghuo_new">
                <span class="cate-img" id="shenghuo"><img src="/static/default/wap/image/tuan/tuan_cate_8.png" /></span>
                <span class="cate-desc">酒水饮料</span>
            </a>
        </li>

        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>16));?>" tongji_tag="m_home_bendishenghuo_new">
                <span class="cate-img" id="shenghuo"><img src="/static/default/wap/image/tuan/tuan_cate_9.png" /></span>
                <span class="cate-desc">肉禽</span>
            </a>
        </li>

        <li>
            <a class="icon2" href="<?php echo U('tuan/index',array('cat'=>2));?>" tongji_tag="m_home_bendishenghuo_new">
                <span class="cate-img" id="shenghuo"><img src="/static/default/wap/image/tuan/tuan_cate_10.png" /></span>
                <span class="cate-desc">年货</span>
            </a>
        </li>
    </ul><?php endif; ?>



<!--<div id="filter2" class="filter2">
  <ul class="tab clearfix">
    <li class="item">
      <a href="javascript:void(0);">
      <?php if(!empty($cat)): ?><span id="str_b_node" style="color:#f60"> <?php echo ($tuancates[$cat]['cate_name']); ?></span>
      <?php else: ?>
      <span id="str_b_node">选择分类</span><?php endif; ?>

      <em></em>
      </a>
    </li>
    <li class="item">
      <a href="javascript:void(0);">
       <?php if(!empty($business_id)): ?><span id="str_b_node" style="color:#f60;"><?php echo ($bizs[$business_id]['business_name']); ?></span>
          <?php else: ?>
              <?php if(!empty($area_id)): ?><span id="str_b_node" style="color:#f60;"><?php echo ($areass[$area_id]['area_name']); ?></span>
              <?php else: ?>
              <span id="str_d_node">选择地区</span><?php endif; endif; ?>

          <em></em>
      </a>
    </li>
    <li class="item">
      <a href="javascript:void(0);">
      <?php if(empty($order)): ?><span id="str_e_node">选择排序</span>
      <?php elseif($order == 1): ?>
      <span id="str_b_node" style="color:#f60;">时间排序</span>
      <?php elseif($order == 2): ?>
      <span id="str_b_node" style="color:#f60;">销量排序</span>
      <?php elseif($order == 3): ?>
      <span id="str_b_node" style="color:#f60;">距离排序</span><?php endif; ?>
      <em></em>
      </a>
    </li>
  </ul>

  <div class="inner" style=" display:none">
    <ul>
      <li class="item">
      <a class="rights" href="<?php echo U('tuan/index');?>">全部分类</a>
      </li>
     <?php if(is_array($tuancates)): foreach($tuancates as $key=>$var): if($var["parent_id"] == 0): ?><li id="cat_<?php echo ($var['cate_id']); ?>"><a class="rights hasUlLink" title="<?php echo ($var["cate_name"]); ?>" href="javascript:void(0);>"><?php echo ($var["cate_name"]); ?><span class="num">(<?php echo ($var["count"]); ?>)</span></a>

             <ul id="items0">
              <?php if(is_array($tuancates)): foreach($tuancates as $key=>$product): if($product["parent_id"] == $var['cate_id']): ?><li><a title="<?php echo ($product["cate_name"]); ?>" href="<?php echo LinkTo('tuan/index',array('cat'=>$product['cate_id']));?>"> <?php echo ($product["cate_name"]); ?><span class="num">(<?php echo ($product["count"]); ?>)</span></a><?php endif; endforeach; endif; ?>
             </ul>

           </li><?php endif; endforeach; endif; ?>

    </ul><!--1级end-->

</div>

<div class="inner" style=" display:none">
    <ul id="inner2">
        <li class="item">
            <a class="rights" href="<?php echo LinkTo('tuan/index',array('cat'=>$cat));?>">全部地区</a>
        </li>
        <?php if(is_array($areas)): foreach($areas as $key=>$var): if($var['city_id'] == $city_id){ ?>
            <li id="cat_<?php echo ($var['cate_id']); ?>"><a class="rights hasUlLink" title="<?php echo ($var["cate_name"]); ?>" href="javascript:void(0);>"><?php echo ($var["area_name"]); ?></a>

                <ul id="items0">
                    <li><a href="<?php echo LinkTo('tuan/index',array('cat'=>$cat,'area'=>$area_id));?>" class="<?php if(empty($business_id)): ?>on<?php endif; ?>">全部商圈</a></li>
                    <?php if(is_array($bizs)): foreach($bizs as $key=>$product): if($product["area_id"] == $var['area_id']): ?><li><a title="<?php echo ($product["business_name"]); ?>" href="<?php echo LinkTo('tuan/index',array('cat'=>$cat,'area'=>$var['area_id'],'business'=>$product['business_id']));?>"> <?php echo ($product["business_name"]); ?></a><?php endif; endforeach; endif; ?>
                </ul>

            </li>
            <?php } endforeach; endif; ?>

    </ul><!--1级end-->

</div>

<div class="inner" style="display:none;">
    <ul>
        <li><a <?php if($order == 1): ?>style="color:red;"<?php endif; ?> href="<?php echo LinkTo('tuan/index',array('cat'=>$cat,'area'=>$area_id,'business'=>$business_id,'order'=>1));?>">销量优先</a></li>
        <li><a <?php if($order == 2): ?>style="color:red;"<?php endif; ?> href="<?php echo LinkTo('tuan/index',array('cat'=>$cat,'area'=>$area_id,'business'=>$business_id,'order'=>2));?>">推荐排序</a></li>
        <li <?php if($order == 3): ?>style="color:red;"<?php endif; ?>><a href="<?php echo LinkTo('tuan/index',array('cat'=>$cat,'area'=>$area_id,'business'=>$business_id,'order'=>3));?>">距离优先</a></li>
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
<style>.container {margin-top: 0rem;}</style>




<script type="text/javascript">
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




<div class="tuan-list" id="tuan-list"></div>
<script>
    $(document).ready(function () {
        showFilter({ibox:'filter2',content1:'parent_container',content2:'inner_container',fullbg:'fullbg'});
        loaddata('<?php echo ($nextpage); ?>', $("#tuan-list"), true);
    });
</script>
<!--[if lt IE 9]>
<script src="/static/default/amazeui/js/polyfill/rem.min.js"></script>
<script src="/static/default/amazeui/js/polyfill/respond.min.js"></script>
<script src="/static/default/amazeui/js/amazeui.legacy.js"></script>
<![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/static/default/amazeui/js/jquery.min.js"></script>
<script src="/static/default/amazeui/js/amazeui.min.js"></script>
<!--<![endif]-->

<div class="blank-20"></div>

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

<style type="text/css">
    header.homeHeader {background-color: #06c1ae}
</style>
<script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__'; var BAO_SURL = '<?php echo ($CONFIG['site']['host']); ?>__SELF__'</script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
<script>
    $(function(){
        var newurl = BAO_SURL.replace(/\\?\\S+/,'');
        var stitle = "<?php if(!empty($mobile_title)): echo ($mobile_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?>";
        var sdesc = "六享自营，买就送，送就折现、速来~!";
        //alert(stitle);
        var surl = newurl+'?fuid=<?php echo getuid();?>';


        //var spic =  "<?php echo ($CONFIG['site']['host']); ?>"+"<?php echo config_img($detail['photo']);?>";
        var spic = "<?php echo ($CONFIG['site']['host']); ?>"+BAO_PUBLIC+'/img/lxlogo.jpg';

        console.log(spic);
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