<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title>商家管理中心-<?php echo ($CONFIG["site"]["title"]); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/<?php echo ($ctl); ?>.css"/>
        <link rel="stylesheet" href="/static/default/wap/css/store.css">
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>


        <script src="/static/default/wap/js/dingwei.js"></script>
		 <script>
            function bd_encrypt(gg_lat, gg_lon)   // 百度地图测距偏差 问题修复
            {
                var x_pi = 3.14159265358979324 * 3000.0 / 180.0;
                var x = gg_lon;
                var y = gg_lat;
                var z = Math.sqrt(x * x + y * y) + 0.00002 * Math.sin(y * x_pi);
                var theta = Math.atan2(y, x) + 0.000003 * Math.cos(x * x_pi);
                var bd_lon = z * Math.cos(theta) + 0.0065;
                var bd_lat = z * Math.sin(theta) + 0.006;
               // dingwei('<?php echo U("mobile/index/dingwei",array("t"=>$nowtime,"lat"=>"llaatt","lng"=>"llnngg"));?>', bd_lat, bd_lon);

            }

            navigator.geolocation.getCurrentPosition(function (position) {
               // bd_encrypt(position.coords.latitude, position.coords.longitude);
            });
        </script>
	</head>
	<body>  
<script src="__PUBLIC__/js/my97/WdatePicker.js"></script>  
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			商家资金
		</div>
		<div class="top-share">
			<a href="javascript:void(0);" id="cate-btn"></a>
		</div>
	</header>
    <style>
.zhengwen { margin-top:2rem;}
.list-media-x { margin-top: 0.0rem;}
.list-media-x p {margin-top: .01rem; line-height:20px;font-size: 12px;}
</style>


<style>ul { padding-left: 0px;}</style>
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <li style="width:25%;"><a href="<?php echo U('money/index');?>"  class="on">商家资金</a></li>
        <li style="width:25%;"><a href="<?php echo U('money/detail');?>">资金日志</a></li>
        <li style="width:25%;"><a href="<?php echo U('money/cashlogs');?>">提现日志</a></li>
        <li style="width:25%;"><a href="<?php echo U('money/cash');?>">申请提现</a></li>

</ul>  
<div class="blank-10 bg"></div>


<style>
.panel-list li em { font-size:12px;}
</style>
<div class="container">
		<div class="blank-40"></div>
		<p><span>尊敬的：<?php echo ($SHOP["shop_name"]); ?>（<?php echo ($SHOP["shop_id"]); ?>）</span> 
               <?php if($counts['money'] > 0): ?>您总收入：<?php echo round($counts['money']/100,2);?>元，<?php endif; ?>
               当前余额：<?php echo round($MEMBER['gold']/100,2);?>元。
               <?php if(!empty($MEMBER['frozen'])): ?>冻结金：<?php echo round($MEMBER['frozen']/100,2);?>元。<?php endif; ?>
        </p>
</div>
<div class="blank-10 bg"></div>
	<div class="panel-list">
	<ul>
		<li><a>今日总收入：<?php echo round($counts['money_day']/100,2);?>元，昨日总收入：<?php echo round($counts['money_day_yesterday']/100,2);?>元。</a></li>
        <!--<li><a>今日商城收入：<?php echo round($counts['money_day_goods']/100,2);?>元，昨日商城收入：<?php echo round($counts['money_day_goods_yesterday']/100,2);?>元。</a></li>
        <li><a>今日团购收入：<?php echo round($counts['money_day_tuan']/100,2);?>元，昨日团购收入：<?php echo round($counts['money_day_tuan_yesterday']/100,2);?>元。</a></li>
        <li><a>今日外卖收入：<?php echo round($counts['money_day_ele']/100,2);?>元，昨日外卖收入：<?php echo round($counts['money_day_ele_yesterday']/100,2);?>元。</a></li>
        <li><a>今日订座收入：<?php echo round($counts['money_day_booking']/100,2);?>元，昨日订座收入：<?php echo round($counts['money_day_booking_yesterday']/100,2);?>元。</a></li>
        <li><a>今日酒店收入：<?php echo round($counts['money_day_hotel']/100,2);?>元，昨日酒店收入：<?php echo round($counts['money_day_hotel_yesterday']/100,2);?>元。</a></li>-->
      	</ul>
	</div>

    
  <!-- <div class="blank-10 bg"></div>
	<div class="panel-list">
	<ul>
		<li><a>商城（总）：<?php echo round($counts['money_goods']/100,2);?>元。</a></li>
        <li><a>团购（总）：<?php echo round($counts['money_tuan']/100,2);?>元。</a></li>
        <li><a>外卖（总）：<?php echo round($counts['money_ele']/100,2);?>元。</a></li>
        <li><a>商城（总）：<?php echo round($counts['money_goods']/100,2);?>元。</a></li>
        <li><a>订座（总）：<?php echo round($counts['money_booking']/100,2);?>元。</a></li>
        <li><a>酒店（总）：<?php echo round($counts['money_hotel']/100,2);?>元。</a></li>
      	</ul>
	</div>-->
   


    <footer class="foot-fixed">
			<?php $file = D('Weixin')->getCode($shop_id,5); ?>
           <a class="foot-item <?php if(($ctl == 'index') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo U('index/index');?>">		
    	    <span class="icon icon-home"></span>		
        	<span class="foot-label">首页</span>		
            </a>		

            <!--<a class="foot-item <?php if(($ctl) == "tuan"): ?>active<?php endif; ?>" href="<?php echo U('store/tuan/index');?>">		
            	<span class="icon icon-plus"></span>			
                <span class="foot-label">抢购</span>
            </a>	-->	
            
           <a class="foot-item <?php if(($ctl) == "mart"): ?>active<?php endif; ?>" href="<?php echo U('tuan/xiaofei');?>">		
            	<span class="icon icon-recycle"></span>			
                <span class="foot-label">余额买单</span>
            </a>
            
            <a class="foot-item <?php if(($ctl) == "money"): ?>active<?php endif; ?>" href="<?php echo U('store/money/index');?>">		
            	<span class="icon icon-calendar"></span>			
                <span class="foot-label">结算</span>
            </a>
            
            <a class="foot-item <?php if(($ctl) == "dianping"): ?>active<?php endif; ?>" href="<?php echo ($file); ?>">		
            	<span class="icon icon-qrcode"></span>			
                <span class="foot-label">买单码</span>
            </a>

            </footer>	
            <iframe id="x-frame" name="x-frame" style="display:none;"></iframe>
        </body>
 </html>