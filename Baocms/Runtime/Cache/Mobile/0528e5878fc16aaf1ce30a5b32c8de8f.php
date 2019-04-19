<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): foreach($list as $key=>$item): ?><li class="line">	
        <a href="<?php echo U('huodong/detail',array('activity_id'=>$item['activity_id']));?>">		
        <div class="x12 dealcard">
        <style>
		.dealcard .dealcard-nobooking:after {content: "<?php echo bao_msubstr($cates[$item['cate_id']]['cate_name'],0,4,false);?>";}
		</style>
        <span class="dealcard-nobooking"></span>
        <img src="<?php echo config_img($item['photo']);?>">
        <div class="title">
				<h1><?php echo bao_msubstr($item['title'],0,26,false);?></h1>
			</div>
        </div>
            <div class="x12" style="padding:0 10px;">
             <div class="blank-10"></div>
                <p class="desc"><?php echo ($item['intro']); ?></p>	
                <p class="desc">具体活动时间：<?php echo ($item["time"]); ?>&nbsp;截止：<?php echo ($item["sign_end"]); ?></p>
                <p class="info">
                	<span class="text-dot">活动价：&yen;<?php echo ($item['price']); ?></span>
                    <?php if($item['sign'] == 1): ?><em class="button button-small bg-gray">已报名 <i class="icon-angle-right"></i></em>
                    <?php else: ?>
                        <em class="button button-small bg-yellow">立即报名 <i class="icon-angle-right"></i></em><?php endif; ?>
                </p>
                <div class="blank-10"></div>	
            </div>	
       </a>	
     </li>  
     <div class="blank-10 bg"></div><?php endforeach; endif; ?>