<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): foreach($list as $key=>$item): ?><li class="padding border-bottom">
		<a href="<?php echo U('community/tie',array('post_id'=>$item['post_id']));?>"><?php echo bao_Msubstr($item['title'],0,14,false);?><span><?php echo ($users[$item['user_id']]['nickname']); ?></span></a>
	</li><?php endforeach; endif; ?>