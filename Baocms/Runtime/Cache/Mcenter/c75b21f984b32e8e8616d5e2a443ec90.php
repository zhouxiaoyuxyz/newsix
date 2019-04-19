<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): foreach($list as $key=>$var): ?><li class="line ">
	<dd class="zhong">
		<div class="12">
			<p class="text-small">金额：&yen;<?php echo round($var['money']/100,2);?>元， &nbsp;	备注：<?php echo ($var["intro"]); ?></p>
			<p class="text-small">时间：<?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></p>
		</div>
	</dd>
</li><?php endforeach; endif; ?>