<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title><?php if(!empty($seo_title)): echo ($seo_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?>会员中心</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<?php if($CONFIG[site][concat] != 1): ?><link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/mcenter.css"/>
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>
		<?php else: ?>
		<link rel="stylesheet" href="/static/default/wap/css/??base.css,mcenter.css" />
		<script src="/static/default/wap/js/??jquery.js,base.js,roll.js,layer.js,public.js"></script><?php endif; ?>
	</head>
	<body>
<header class="top-fixed bg-yellow bg-inverse">
	<div class="top-back">
		<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			余额充值
		</div>
	<div class="top-signed">
		<?php if($msg_day > 0): ?><a href="<?php echo U('mcenter/message/index');?>">
<i class="icon-envelope"></i>
<span class="badge bg-red jiaofei"><?php echo ($msg_day); ?></span>
</a>
<?php else: ?>
    <?php if(empty($sign_day)): ?><!-- <a href="<?php echo U('mobile/sign/signed');?>" class="top-addr icon-plus"> 签到</a> -->
    <?php else: ?>
    <a href="<?php echo U('mobile/passport/logout');?>" class="top-addr icon-sign-out"></a><?php endif; endif; ?>
	</div>
</header>

 <!-- 筛选TAB -->
<style>ul{ padding-left:0px;}</style>
<!--<ul id="shangjia_tab">
		<li style="width:33.3333333367%;"><a href="<?php echo U('mcenter/money/index');?>"  class="on">余额充值</a></li>
        <li style="width:33.3333333367%;"><a href="<?php echo U('mcenter/cash/index');?>" >申请提现</a></li>
        <li style="width:33.3333333367%;"><a href="<?php echo U('mcenter/logs/moneylogs');?>" >日志管理</a></li>
</ul>

<div class="blank-40 bg"></div>-->
<!-- 筛选TAB -->
<!--<div class="line tab-bar">
	<div class="button-toolbar">
		<div class="button-group">
			<a class="block button bg-dot active" href="<?php echo U('money/index');?>">余额充值</a>
			<a class="block button" href="<?php echo U('money/recharge');?>">代金券充值</a>
		</div>
	</div>
</div>-->
<div class="member-charge">

</div>
<?php if(!empty($CONFIG[cash][is_recharge])): ?><div class="container">
<div class="blank-10"></div>
	<p>
        <?php if(!empty($CONFIG[cash][recharge_full_1]) && !empty($CONFIG[cash][recharge_give_1]) && ($CONFIG[cash][recharge_full_1] > $CONFIG[cash][recharge_give_1])): ?>单笔充值满：<a style="color:#F00">&yen;<?php echo ($CONFIG[cash][recharge_full_1]); ?> </a> 元,送：<?php echo ($CONFIG[cash][recharge_give_1]); ?> 元<?php endif; ?>
        <hr/>
        <?php if(!empty($CONFIG[cash][recharge_full_2]) && !empty($CONFIG[cash][recharge_give_2]) && ($CONFIG[cash][recharge_full_2] > $CONFIG[cash][recharge_give_2])): ?>单笔充值满：<a style="color:#F00">&yen;<?php echo ($CONFIG[cash][recharge_full_2]); ?> </a> 元,送：<?php echo ($CONFIG[cash][recharge_give_2]); ?> 元<?php endif; ?>
        <hr/>
        <?php if(!empty($CONFIG[cash][recharge_full_3]) && !empty($CONFIG[cash][recharge_give_3]) && ($CONFIG[cash][recharge_full_3] > $CONFIG[cash][recharge_give_3])): ?>单笔充值满：<a style="color:#F00">&yen;<?php echo ($CONFIG[cash][recharge_full_3]); ?> </a> 元,送：<?php echo ($CONFIG[cash][recharge_give_3]); ?> 元<?php endif; ?>
    </p>
</div><?php endif; ?>
<div class="blank-10 bg"></div>
<form method="post" action="<?php echo U('money/moneypay');?>">
<div class="line padding">
    <span class="x4" style="font-size: 16px;font-weight: bold;">输入充值金额：</span>
	<span class="x8">
		<input class="text-input" type="text" name="money" style="color: #b5b0b0; font-size: 15px;" placeholder="请输入充值金额" />
	</span>
</div>
<ul id="pay-method" class="pay-method">
	<?php if(is_array($payment)): foreach($payment as $key=>$var): if($var['code'] != 'money'): ?><li data-rel="<?php echo ($var["code"]); ?>" class="media media-x payment <?php if($var['code'] == 'weixin'): ?>active<?php endif; ?>">
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
	</li><?php endif; endforeach; endif; ?>
</ul>
<input id="code" type="hidden" name="code" value="weixin" />
<script>
	$("#pay-method li").click(function(){
		var code = $(this).attr("data-rel");
		$("#code").val(code);
		$("#pay-method li").each(function(){
			$(this).removeClass("active");
		});
		$(this).addClass("active");
	});
</script>

<div class="blank-30"></div>
<div class="container"><button type="submit" class="button button-block button-big bg-dot">提交充值</button></div>
<div class="blank-30"></div>

</form>

<style>

/*.item-list img{width:100%;padding:5px}*/
.item-list h5{font-size:16px;height:16px;overflow:hidden;color: black}
.item-list .desc{font-size:14px;color:#999;max-height:36px;line-height:18px;overflow:hidden;margin:5px 0}
.item-list .info{overflow:hidden;margin:0;margin:0}
.item-list .info span{font-size:18px;font-family:"PingFang SC",tahoma,arial,"Hiragino Sans GB",宋体,sans-serif;color:#FF5858}
.item-list .info del{font-size:14px;color:#999;margin-left:5px;margin-right: 5px}
/*.item-list .info em{color:#999;float:right}*/
/* 2017.11.07 modify start*/
.item-list li{padding:3px 0;border-bottom:thin solid #EEE; background: white; margin-bottom: 10px}
.item-list li:last-child{border:none}
ol,ul{list-style:none; background: #f5f5f5}
.x3_mall{width:100%;}
.x3_mall img{width:100%;}
.x9_mall{width:100%; height: auto}

.item-list .info em{color: white;font-size: 14px}
.item-list .fanxian_icon{width:25%; margin-top: 0px}
.item-list .fanxian_text{color: white;font-size: 14px;margin-left: -70px; display: inline-block; margin-bottom: 3px}
.item-list h5 {height: inherit;}

</style>
<div class="item-list" id="item-list">
		<ul>
	<?php  $cache = cache(array('type'=>'File','expire'=> 600)); $token = md5("Goods,goods_id=31 AND closed=0 ,0,1,600,,,"); if(!$items= $cache->get($token)){ $items = D("Goods")->where("goods_id=31 AND closed=0 ")->order("")->limit("0,1")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><li class="line">		
    <a href="<?php echo U('/mall/detail',array('goods_id'=>$item['goods_id']));?>">		
    <div class="x3_mall">
        <img src="<?php echo config_img($item['photo']);?>">
    </div>		
    <div class="x9_mall" style="margin-top:0.3rem; padding: 0 5px;"><h5><?php echo bao_msubstr($item['title'],0,8,false);?></h5>
    
    	        <p class="desc"><?php echo bao_msubstr($item['intro'],0,26);?></p>
             
        <div class="info"><span>¥<?php echo ($item['mall_price']/100); ?></span><del>¥<?php echo round($item['price']/100,2);?></del>
           
            <em class="text-little float-right badge bg-yellow margin-small-top padding-right mall_left">剩余<?php echo round($item['num']/($item['num'] + $item['sold_num']),2)*100;?>%</em>

            <!--<div class="progress progress-success">-->
                <!--<p class="bar" style="width:60%;"></p>-->
                <!--<span>剩余60%</span>-->
            <!--</div>-->

            <!--<em>剩余100%</em>-->
        </div>

                        	<p></p>
        	</div>
            </a>
       </li> <?php endforeach; ?>
	   </ul>
	</div>
	
<div class="blank-20"></div>
 <footer class="foot-fixed">
  <?php if($ctl == 'member'): ?><a class="foot-item  <?php if($ctl == 'member'): ?>active<?php endif; ?>" href="<?php echo u('mobile/index/index');?>">		
    <span class="icon icon-home"></span>
    <span class="foot-label">首页</span>
    </a>
  <?php else: ?>
  <a class="foot-item" href="<?php echo u('member/index');?>">		
    <span class="icon icon-home"></span>
    <span class="foot-label">首页</span>
    </a><?php endif; ?>
    
    <!--<a class="foot-item " href="<?php echo LinkTo('mobile/life/release');?>">			
    <span class="icon icon-plus"></span><span class="foot-label">发布</span></a>-->
    
     <a class="foot-item  <?php if(($ctl == 'goods')): ?>active<?php endif; ?>" href="<?php echo u('tuancode/index');?>">			
    <span class="icon icon-folder"></span><span class="foot-label">取货券</span></a>
    
    
    
    <a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('message/index');?>">			
    <span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>
    
    <a class="foot-item  <?php if(($ctl == 'money') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('information/index');?>">			
    <span class="icon icon-gear"></span><span class="foot-label">设置</span></a>
    
   
    </footer>


<iframe id="x-frame" name="x-frame" style="display:none;">
</iframe>
</body>
</html>