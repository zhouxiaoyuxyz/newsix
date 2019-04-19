<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($CONFIG["site"]["title"]); ?>物业管理后台</title>
        <meta name="description" content="<?php echo ($CONFIG["site"]["title"]); ?>物业管理后台" />
        <meta name="keywords" content="<?php echo ($CONFIG["site"]["title"]); ?>物业管理后台" />
        <link href="__TMPL__statics/css/style.css" rel="stylesheet" type="text/css" />
        <link href="__TMPL__statics/css/land.css" rel="stylesheet" type="text/css" />
        <link href="__TMPL__statics/css/pub.css" rel="stylesheet" type="text/css" />
        <link href="__TMPL__statics/css/main.css" rel="stylesheet" type="text/css" />
        <link href="__PUBLIC__/js/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__'; </script>
        <script src="__PUBLIC__/js/jquery.js"></script>
        <script src="__PUBLIC__/js/jquery-ui.min.js"></script>
        <script src="__PUBLIC__/js/my97/WdatePicker.js"></script>
        <script src="__PUBLIC__/js/admin.js"></script>
        <link rel="stylesheet" type="text/css" href="/static/default/webuploader/webuploader.css">
		<script src="/static/default/webuploader/webuploader.min.js"></script>
    </head>
    <body>
         <iframe id="baocms_frm" name="baocms_frm" style="display:none;"></iframe>
         
        <style type="text/css">
		#ie9-warning{ background:#F00; height:38px; line-height:38px; padding:10px;
		position:absolute;top:0;left:0;font-size:12px;color:#fff;width:97%;text-align:left; z-index:9999999;}
		#ie6-warning a {text-decoration:none; color:#fff !important;}
		</style>
		
		<!--[if lte IE 9]>
		<div id="ie9-warning">您正在使用 Internet Explorer 9以下的版本，请用谷歌浏览器访问后台、部分浏览器可以开启极速模式访问！不懂点击这里！ <a href="http://www.hatudou.com/10478.html" target="_blank">查看为什么？</a>
		</div>
		<script type="text/javascript">
		function position_fixed(el, eltop, elleft){  
			   // check if this is IE6  
			   if(!window.XMLHttpRequest)  
					  window.onscroll = function(){  
							 el.style.top = (document.documentElement.scrollTop + eltop)+"px";  
							 el.style.left = (document.documentElement.scrollLeft + elleft)+"px";  
			   }  
			   else el.style.position = "fixed";  
		}
			   position_fixed(document.getElementById("ie9-warning"),0, 0);
		</script>
		<![endif]-->

   <div class="main">

     <?php $city_ids = D('City') -> where('city_id ='.$admin['city_id']) -> find(); $city = $city_ids['name']; ?>
     
     
<div class="main">
    <div class="mainBt">
        <ul>
            <li class="li1">首页</li>
            <li class="li2">物业首页</li>
            <li class="li2 li3">物业信息</li>
        </ul>
    </div>
    <div class="mainNr">
        <div class="left">
            <div class="mainLeftBox">
                <div class="title">您管理的物业：（<?php echo ($admin["username"]); ?>）&nbsp;&nbsp;&nbsp; 后台数据统计</div>
                <div class="titleNr">
                    <div class="nr">
                        <div class="lef">
                            <ul>
                                <li>小区数，共<span><?php echo ($counts["communities"]); ?></span>小区</li>
                                <li class="bg">会员数，共<span><?php echo ($counts["users"]); ?></span>会员</li>
                                <li>业主总数，共<span><?php echo ($counts["article"]); ?></span>户</li>
                                <li class="bg">小区数量，共<span><?php echo ($counts["community"]); ?></span>个小区</li>
                                <li>已绑定业主，共<span><?php echo ($counts["coupon"]); ?></span>人</li>
                              
                                
                                <li class="bg2"></li>
                            </ul>
                        </div>
                        <div class="lef">
                            <ul>
                                <li>物业费总数：<?php echo round($counts['wuyemoney']/100,2);?>元。</li>
                                <li class="bg">总缴纳：<span><?php echo round($counts['wuyepaid']/100,2);?></span>元。（含小区管理员减免<?php echo round($counts['reduction']/100,2);?>元）</li>
                                <li>总未缴纳：<span><?php echo round($counts['wuyeneedpay']/100,2);?></span>元。</li>
                                <li class="bg">今日缴纳：<span><?php echo round($counts['money_day_tuan']/100,2);?></span>元。</li>
                                <li>今日易水源交易：<span><?php echo round($counts['money_day_ele']/100,2);?></span>元。</li>
								<li class="bg">实际缴纳：<span><?php echo round($counts['wuyerealpaid']/100,2);?></span>元。</li>
                                
                                <li class="bg2"></li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="center">
            <div class="mainC1">
                <div class="title">官方动态</div>
                <div class="nr">
                    <div class="cen2">
                        <ul>
                        <?php $i=0; ?>
                        <?php if(is_array($list)): foreach($list as $key=>$var): $i++; ?>
                            <li> <?php echo ($i); ?>： <a href="<?php if(!empty($var['link_url'])): echo ($var['link_url']); else: echo U('msg/detail',array('msg_id'=>$var['msg_id'])); endif; ?>"><?php echo ($var['title']); ?></a> <span><?php echo (date("Y-m-d H:i:s",$var["create_time"])); ?></span></li><?php endforeach; endif; ?>  
                        </ul>
                        <?php echo ($page); ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            
        </div>
        <div class="clear"></div>
    </div>
</div>

</div>
</body>
</html>