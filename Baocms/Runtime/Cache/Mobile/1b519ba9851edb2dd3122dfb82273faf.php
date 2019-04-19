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
		<a class="top-addr" href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			优惠买单
		</div>
	<div class="top-signed">
	</div>
</header>
<div class="panel-list">
	<ul>
		<li>
        <?php $shop = D('Shop')->where(array('shop_id'=>$detail['shop_id']))->find(); ?>
			<a href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>"><span class="icon icon-paw" style="color:#1cb7ff"></span>当前商家<em class="text-gray"><?php echo ($shop['shop_name']); ?>></em></a>
		</li>
	</ul>
</div>
<div class="container" style="background-color: #F0F0F0;padding: 10px;">
	
	<form target="x-frame" id="nick-form" method="post" action="<?php echo U('shop/breaks',array('shop_id'=>$detail['shop_id']));?>" style=" background-color: #fff;">
	<div class="panel-detail">
	<ul>
		<li>
        			<a>请输入消费金额<em class="text-gray">确认后查看返现金额</em></a>
		</li>
	</ul>
	</div>
	<!--<p class="text-small text-dot">请输入消费金额： 确认后查看返现金额
    <?php if($detail['type'] == 0): ?>优惠方式：&nbsp;(<?php echo ($detail['discount']); ?>)折
    <?php else: ?>
    优惠方式：&nbsp;满 &yen;<?php echo ($detail['min_amount']); ?>元&nbsp;减 &yen;<?php echo ($detail['amount']); ?>元<?php endif; ?>
    
    
    
    </p>-->
	<div class="form-group">
		<div class="field">
			<div class="input-group" style="padding: 0 10px;">
				<input type="text" id="amount" class="input" style="background-color: #F0F0F0; font-size: 14px; color: #909090; height: 50px" name="amount" size="50" value="" placeholder="询问服务员后输入" />
			</div>
		</div>
	</div>
   <!-- <p class="text-small text-gray">输入不参与优惠金额（酒水、特价菜等）</p>
    <div class="form-group">
		<div class="field">
			<div class="input-group">
				<input type="text" id="exception" class="input" name="exception" size="50" value="" placeholder="询问服务员后输入" />
			</div>
		</div>
	</div>-->
	<div class="panel-detail" style="display: flex; align-items: center;">
      <ul>
          <li>
              <!--
              <a id="fxmoney"><span class="icon icon icon-cny" style="color:#1cb7ff"></span>余额￥<?php echo ($member['money']/100); ?></a> 
              -->
              <a id="fxmoney">
                  <span class="icon icon icon-cny" style="color:#1cb7ff">
                  <?php if($shop['cate_id'] == 62): ?></span>物业费返现金额￥<?php echo ($member['wy_fanxian']/100); ?>
                  <?php else: ?>
                      </span>余额￥<?php echo ($member['money']/100); endif; ?>
              </a>
          </li>
      </ul>
      <div>
        <img src="https://ws2.sinaimg.cn/large/006tNc79ly1fz2yditgakj30m805zdi8.jpg" width="150px">
      </div>
	</div>
    <!--<p class="text-small text-gray">可用余额￥<?php echo ($member['money']/100); ?></p>-->
    <div class="form-group" style=" padding-bottom: 30px;">
		<div class="field">
			<div class="input-group" style="padding: 0 10px;">
				<input type="text" id="use_money" style="background-color: #F0F0F0;font-size: 14px;color: #909090; height: 50px" class="input" name="use_money" size="50" value="" placeholder="输入余额抵扣金额" />
			</div>
		</div>
	</div>
	<div style="width:100%;height:10px;    background-color: #F0F0F0;"></div>
	<button id="check-form" type="submit" class="button button-block button-big bg-dot text-center">确认支付</button>
	</form>
</div>
<script>
        
        $(function () {
/**
			$("#use_money").click(function () {
				var fxrate=<?php echo ($fxrate); ?>;
            	var amount=$("#amount").val();
				var fxmoney=fxrate*amount*0.01;
				$("#use_money").val(fxmoney);
				$("#fxmoney").text('本次最多可用'+fxmoney);
        		
            });
**/          
          
            // zhangdianlei 2018-12-09
          
            $("#use_money").click(
                function () {

                    if(<?php echo ($shop['cate_id']); ?> === 62){
                        var wy_fanxian= <?php echo ($member['wy_fanxian']/100); ?>;
                        $("#use_money").val(fxmoney.toFixed(2));
                        $("#fxmoney").text('本次最多可用'+ wy_fanxian.toFixed(2));
                    }else{
                        var fxrate=<?php echo ($fxrate); ?>;
                        var amount=$("#amount").val();
                        var fxmoney=fxrate*amount*0.01;
                        $("#use_money").val(fxmoney.toFixed(2));
                        $("#fxmoney").text('本次最多可用'+ fxmoney.toFixed(2));
                    }

                }
            );
          
          

			// console.log('wy_fanxian', '<?php echo ($member['wy_fanxian']/100); ?>');
            // console.log('shop_cate_id', '<?php echo ($shop['cate_id']); ?>');
          
          /**
            $("#check-form").click(function () {
            	var use_money=$("#use_money").val();
        		var member_money=<?php echo ($member['money']/100); ?>;
				var fxrate=<?php echo ($fxrate); ?>;
            	var amount=$("#amount").val();
				var fxmoney=fxrate*amount*0.01;
                if (use_money > member_money || use_money<0) {
                    alert('可用金额错误，请重新填写');
                    return false;
                   
                }
				if (use_money > fxmoney) {
                    alert('超出最大使用限额，请重新填写');
                    return false;
                   
                }
            });
          **/
           
          $("#check-form").click(function () {


                if(<?php echo ($shop['cate_id']); ?> === 62){
                    var use_money=$("#use_money").val()*1;
                    var member_money=<?php echo ($member['wy_fanxian']/100); ?>;
                    
                    var amount=$("#amount").val()*1;
                  
                    if (use_money > member_money || use_money<0) {
                        alert('可用物业费金额错误，请重新填写');
                        return false;

                    }
                    if (use_money > amount.toFixed(2)) {
                        alert('超出物业费最大使用限额，请重新填写');
                        return false;

                    }

                }else{
                    var use_money=$("#use_money").val()*1;
                    var member_money=<?php echo ($member['money']/100); ?>;
                    var fxrate=<?php echo ($fxrate); ?>;
                    var amount=$("#amount").val()*1;
                    var fxmoney=fxrate*amount*0.01;
                    if (use_money > member_money || use_money<0) {
                        alert('可用金额错误，请重新填写');
                        return false;

                    }
                    if (use_money > fxmoney.toFixed(2)) {
                        alert('超出最大使用限额，请重新填写');
                        return false;

                    }
                }

            });
          
            
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