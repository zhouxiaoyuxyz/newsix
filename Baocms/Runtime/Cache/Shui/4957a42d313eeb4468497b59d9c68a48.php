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
		<a class="top-addr" href="<?php echo U('/index/index');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			缴费打水
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

<div class="blank-10 bg"></div>
<form id="dashui_form" method="post" action="<?php echo U('index/control');?>">
<div class="line padding">
    <span class="x4">当前饮水机编号：</span>
	<span class="x8">
		<?php echo ($shuimachine["m_sn"]); ?>
	</span>
</div>
<div class="line padding">
    <span class="x4">当前饮水机单价：</span>
	<span class="x8">
		<?php echo ($shuimachine["price"]); ?>元
	</span>
</div>
<input id="sn" type="hidden" name="sn" value="<?php echo ($shuimachine["m_sn"]); ?>" />
<ul id="pay-method" class="pay-method">
	<?php if(is_array($payment)): foreach($payment as $key=>$var): if($var['code'] != 'weixin'): ?><li data-rel="<?php echo ($var["code"]); ?>" class="media media-x payment <?php if($var['code'] == 'money'): ?>active<?php endif; ?>">
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
<input id="code" type="hidden" name="code" value="money" />
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
<div class="container"><button id="immediate_open" type="button" class="button button-block button-big bg-dot">立即打水</button></div>
<div class="blank-30"></div>

</form>

<script>
  
  	$("#immediate_open").click(function () {
      	console.log("click open");
		$(this).attr('disabled',true);
        $("#dashui_form").submit();//提交表单
        setTimeout("$('#immediate_open').removeAttr('disabled')", 57000); //设置57秒后可点
    });
  
</script>
  
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