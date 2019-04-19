<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): foreach($list as $key=>$var): ?><li>	
      <?php if($var[bsti] == 0){ ?>
<a class="item line" href="<?php echo U('ele/shop',array('shop_id'=>$var['shop_id']));?>">
		<div class="x3">
        
			<img src="<?php echo config_img($shops[$var['shop_id']]['photo']);?>">
		</div>
		<div class="x9">
				<h5><?php echo ($var['shop_name']); ?>
					<?php if(($var["is_pay"]) == "1"): ?><span class="fu">付</span><?php endif; ?>
					<?php if(($var["is_fan"]) == "1"): ?><span class="fan">返</span><?php endif; ?>
					 <span class="pei">配</span>
					<?php if(($var["is_new"]) == "1"): ?><span class="jian">减</span><?php endif; ?>
				</h5>				<p class="des-star">
					<span class="ui-starbar"><span style="width:<?php echo round($shops[$var['shop_id']]['score']*2,2);?>%"></span></span>
					<span class="float-right"><?php echo ($var["d"]); ?></span>
				</p>
				<p class="des-addr"><i class="mui-icon mui-icon-location"></i><?php echo ($shops[$var['shop_id']]['addr']); ?></p>
		</div>	</a>
        
           <?php }else{ ?>
           
           <a class="item line" href="javascript:;" style="background: #FBFAFA;">
		<div class="x3">
			<img src="<?php echo config_img($shops[$var['shop_id']]['photo']);?>">
		</div>
		<div class="x9">
				<h5><?php echo ($var['shop_name']); ?><b style="margin-left:5px; color:#F00; font-weight:normal;">(休息中)</b>
					<?php if(($var["is_pay"]) == "1"): ?><span class="fu">付</span><?php endif; ?>
					<?php if(($var["is_fan"]) == "1"): ?><span class="fan">返</span><?php endif; ?>
					 <span class="pei">配</span>
					<?php if(($var["is_new"]) == "1"): ?><span class="jian">减</span><?php endif; ?>
				</h5>				<p class="des-star">
					<span class="ui-starbar"><span style="width:<?php echo round($shops[$var['shop_id']]['score']*2,2);?>%"></span></span>
					<span class="float-right"><?php echo ($var["d"]); ?></span>
				</p>
				<p class="des-addr"><i class="mui-icon mui-icon-location"></i><?php echo ($shops[$var['shop_id']]['addr']); ?></p>
		</div>	</a>
           
           
           
               <?php } ?>
</li><?php endforeach; endif; ?>