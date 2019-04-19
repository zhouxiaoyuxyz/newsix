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
		<a class="top-addr" href="<?php echo U('member/index');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			账户信息
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
<?php $mobile = substr_replace($res['mobile'],'****',3,4); ?>
<style>
.layui-layer-molv .layui-layer-title {background-color: #F8F8F8;border-bottom: 1px solid #eee;color: #333;}
</style>
<div class="container">
		<div class="blank-10"></div>
		<p><span class="text-dot">小提示：</span> 如果您是微信登录的用户，请绑定手机后都改登录密码，然后就可以登录APP端了！</p><!---->
	</div>
<div class="panel-list border-top">
	<ul>
		<li>
			<a href="<?php echo U('info/face');?>">
				上传头像
				<i class="icon-angle-right"></i>
			</a>
		</li>
		<li>
			<a href="<?php echo U('info/nickname');?>">
				用户昵称<em><?php echo ($res["nickname"]); ?> ID：<?php echo ($res["user_id"]); ?></em>
			</a>
		</li>
		<li>
			<a href="<?php echo u('addrs/index');?>">
				外卖收货地址<em><?php echo ($addr_count); ?>个</em>
			</a>
		</li>

	</ul>
</div>
<div class="blank-10 bg"></div>
<div class="panel-list">
	<ul>
        <!--<li><a href="<?php echo U('info/set');?>">基本设置<i class="icon-angle-right"></i></a></li>
		<li><a href="<?php echo U('money/index');?>">余额充值<i class="icon-angle-right"></i></a></li>-->
		<li><a href="<?php echo U('logs/moneylogs');?>">日志列表<i class="icon-angle-right"></i></a></li>
        <?php if($CONFIG[integral][integral_exchange] == 1): ?><li><a href="<?php echo U('money/exchange');?>">积分兑换余额<i class="icon-angle-right"></i></a></li><?php endif; ?>
	</ul>
</div>
<div class="blank-10 bg"></div>
<div class="panel-list border-top">
	<ul>
		<li>
			<a <?php if(!empty($res['mobile'])): ?>id="change_mobile"<?php else: ?>id="bind_mobile"<?php endif; ?> href="javascript:void(0);">
				绑定手机<?php if(!empty($res["mobile"])): ?><em class="text-green"><?php echo ($mobile); ?></em><?php else: ?><em class="text-gray">未绑定</em><?php endif; ?>
			</a>
		</li>
		<li>
			<a <?php if(!empty($res['ext_mobile'])): ?>id="change_ext_mobile"<?php else: ?>id="bind_ext_mobile"<?php endif; ?> href="javascript:void(0);">
				绑定副卡<?php if(!empty($res["ext_mobile"])): ?><em class="text-green"><?php echo substr_replace($res['ext_mobile'],'****',3,4); ?></em><?php else: ?><em class="text-gray">未绑定</em><?php endif; ?>
			</a>
		</li>
		<!--<li>
			<?php if(!isset($bind['weixin'])){?>
			<a href="<?php echo u('passport/wxlogin');?>">
				绑定微信<em class="text-gray">未绑定</em>
			</a>
			<?php }else{?>
			<a href="javascript:;">
				绑定微信<em class="text-green">已绑定</em>
			</a>
			<?php }?>
		</li>
		<li>
			<?php if(!isset($bind['qq'])){?>
			<a href="<?php echo u('mobile/passport/qqlogin');?>">
				绑定QQ<em class="text-gray">未绑定</em>
			</a>
			<?php }else{?>
			<a href="javascript:;">
				绑定QQ<em class="text-green">已绑定</em>
			</a>
			<?php }?>
		</li>
		<li>
			<?php if(!isset($bind['weibo'])){?>
			<a href="<?php echo u('mobile/passport/wblogin');?>">
				绑定微博<em class="text-gray">未绑定</em>
			</a>
			<?php }else{?>
			<a href="javascript:;">
				绑定微博<em class="text-green">已绑定</em>
			</a>
			<?php }?>
		</li>-->
          <li>
			<a href="<?php echo U('info/shuicar');?>">
				惠水源绑卡
				<i class="icon-angle-right"></i>
			</a>
		</li>
        <li>
			<a href="<?php echo U('info/password');?>">
				修改密码登录
				<i class="icon-angle-right"></i>
			</a>
		</li>
	</ul>
</div>
<div class="blank-10 bg"></div>


<?php if(!empty($res["mobile"])): ?><script>
	$('#change_mobile').click(function(){
		change_user_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile");?>');
	})
</script>
<?php else: ?>
<script>
	check_user_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile");?>');
	$('#bind_mobile').click(function(){
		check_user_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile");?>');
	})

</script><?php endif; ?>

<?php if(!empty($res["ext_mobile"])): ?><script>
	$('#change_ext_mobile').click(function(){
		change_ext_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile2");?>');
	})
</script>
<?php else: ?>
<script>
	
	$('#bind_ext_mobile').click(function(){
		check_ext_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile2");?>');
	})
</script><?php endif; ?>
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