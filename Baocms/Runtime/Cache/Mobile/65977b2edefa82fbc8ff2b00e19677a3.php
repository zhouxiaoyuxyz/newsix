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
        <a class="top-addr" href="javascript:history.back();"><i class="icon-angle-left"></i></a>
    </div>
    <div class="top-title">
        订单支付
    </div>
</header>

<div class="tuan-order">
    <div class="blank-10 bg"></div>
    <div class="line border-top border-bottom">
        <div class="container">
            <div class="x12 row border-bottom">
					<span class="float-left">
						支付编号
					</span>
                <span class="float-right" id="orderId">
						<?php echo ($logs["log_id"]); ?>
					</span>
            </div>
            <div class="x12 row border-bottom">
					<span class="float-left">
						付款缘由
					</span>
                <span class="float-right">
						<?php echo ($types[$logs['type']]); ?>
					</span>
            </div>
            <div class="x12 row border-bottom">
					<span class="float-left">
						支付金额
					</span>
                <span class="float-right" id="payment">
						<?php echo round($logs['need_pay']/100,2);?>元
					</span>
            </div>
            <div class="x12 row" style="color:#FF3030">
					<span class="float-left">
						温馨提醒
					</span>
                <span class="float-right">
						如本订单有返现，请确认交易完成后查看记录
					</span>
            </div>
        </div>
    </div>
</div>

<div class="blank-50"></div>
<div class="container">
    <?php echo ($button); ?>
</div>
<script language="JavaScript" src="/static/default/wap/js/md5.js"></script>
<script>
    $(document).ready(function () {
        // $(".button-block").click();

    });

    function callccb() {

        var temp_New1;
        var INTER_FLAG = '3';
        var MERCHANTID = '105000073722562';
        var POSID = '031716071';
        var BRANCHID = '370000000';
        var ORDERID = document.getElementById("orderId").innerText;
        var PAYMENT = document.getElementById("payment").innerText.slice(0, -1);
        var CURCODE = '01';
        var TXCODE = "520100";
        var REMARK1 = '';
        var REMARK2 = '';
        var bankURL = 'https://ibsbjstar.ccb.com.cn/CCBIS/ccbMain';
        var INSTALLNUM = '';
        var ISSINSCODE = '';
        var PUB32TR2 = 'd2d0e213669bf28a0052db9b020111';
        var GATEWAY = 'W1Z1';
        var CLIENTIP = '';
        var REGINFO = '';
        var PROINFO = '';
        var MER_REFERER = '';
        var NoCredit = '';
        var NoDebit = '';
        var USERNAME = '';
        var IDNUMBER = '';

        var SMERID = '';
        var SMERNAME = '';
        var SMERTYPEID = '';
        var SMERTYPE = '';
        var TRADECODE = '';
        var TRADENAME = '';
        var PROTYPE = '';
        var PRONAME = '';
        var THIRDAPPINFO = 'THIRDAPPINFO=comccbpay000000000000000ccb';

        var TIMEOUT = '';

        var tmp = 'MERCHANTID=' + MERCHANTID + '&POSID=' + POSID + '&BRANCHID=' + BRANCHID + '&ORDERID=' + ORDERID + '&PAYMENT=' + PAYMENT + '&CURCODE=' + CURCODE + '&TXCODE=' + TXCODE + '&REMARK1=' + REMARK1 + '&REMARK2=' + REMARK2;
        // var tmp0 = 'MERCHANTID=' + MERCHANTID + '&POSID=' + POSID + '&BRANCHID=' + BRANCHID + '&ORDERID=' + ORDERID + '&PAYMENT=' + PAYMENT + '&CURCODE=' + CURCODE + '&TXCODE=520100' + '&REMARK1=' + REMARK1 + '&REMARK2=' + REMARK2;

        var index = INTER_FLAG;
        var temp_New = tmp;

        if (index == "3") {
            temp_New = tmp + '&TYPE=1&PUB=' + PUB32TR2 + '&GATEWAY=' + GATEWAY + '&CLIENTIP=' + CLIENTIP + '&REGINFO=' + escape(REGINFO) + '&PROINFO=' + escape(PROINFO) + '&REFERER=' + MER_REFERER;
            temp_New1 = tmp + '&TYPE=1&GATEWAY=' + GATEWAY + '&CLIENTIP=' + CLIENTIP + '&REGINFO=' + escape(REGINFO) + '&PROINFO=' + escape(PROINFO) + '&REFERER=' + MER_REFERER;
            if (INSTALLNUM != "") {
                temp_New = temp_New + '&INSTALLNUM=' + INSTALLNUM;
                temp_New1 = temp_New1 + '&INSTALLNUM=' + INSTALLNUM;
            }
            if (SMERID != "") {
                temp_New = temp_New + '&SMERID=' + SMERID + '&SMERNAME=' + escape(SMERNAME) + '&SMERTYPEID=' + SMERTYPEID + '&SMERTYPE=' + escape(SMERTYPE) + '&TRADECODE=' + TRADECODE + '&TRADENAME=' + escape(TRADENAME) + '&SMEPROTYPE=' + PROTYPE + '&PRONAME=' + escape(PRONAME);
                temp_New1 = temp_New1 + '&SMERID=' + SMERID + '&SMERNAME=' + escape(SMERNAME) + '&SMERTYPEID=' + SMERTYPEID + '&SMERTYPE=' + escape(SMERTYPE) + '&TRADECODE=' + TRADECODE + '&TRADENAME=' + escape(TRADENAME) + '&SMEPROTYPE=' + PROTYPE + '&PRONAME=' + escape(PRONAME);
            }
            if (THIRDAPPINFO != "") {
                temp_New = temp_New + '&THIRDAPPINFO=' + THIRDAPPINFO;
                temp_New1 = temp_New1 + '&THIRDAPPINFO=' + THIRDAPPINFO;
            }
            if (TIMEOUT != "") {
                temp_New = temp_New + '&TIMEOUT=' + TIMEOUT;
                temp_New1 = temp_New1 + '&TIMEOUT=' + TIMEOUT;
            }

            if (ISSINSCODE != "") {
                temp_New = temp_New + '&ISSINSCODE=' + ISSINSCODE;
                temp_New1 = temp_New1 + '&ISSINSCODE=' + ISSINSCODE;
            }
            if (NoCredit != "") {
                temp_New = temp_New + '&NoCredit=' + NoCredit;
                temp_New1 = temp_New1 + '&NoCredit=' + NoCredit;
            }
            if (NoDebit != "") {
                temp_New = temp_New + '&NoDebit=' + NoDebit;
                temp_New1 = temp_New1 + '&NoDebit=' + NoDebit;
            }
            if (USERNAME != "" && IDNUMBER != "") {
                temp_New = temp_New + '&USERNAME=' + escape(USERNAME);
                temp_New1 = temp_New1 + '&USERNAME=' + escape(USERNAME);
                temp_New = temp_New + '&IDNUMBER=' + escape(IDNUMBER);
                temp_New1 = temp_New1 + '&IDNUMBER=' + escape(IDNUMBER);
            }

        }
        var strMD5 = hex_md5(temp_New);
        var URL = bankURL + '?' + temp_New1 + '&MAC=' + strMD5;

        window.location.href= URL;
    }

</script>
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