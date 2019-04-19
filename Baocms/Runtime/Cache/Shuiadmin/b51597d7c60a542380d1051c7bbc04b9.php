<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
<div class="mainBt">
    <!--<ul>
        <li class="li1">频道</li>
        <li class="li2">资金记录</li>
        <li class="li2 li3">资金列表</li>
    </ul>-->
</div>

<link href="__TMPL__statics/css/newstyle.css" rel="stylesheet" type="text/css" />

<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>这里查询的是平台收入明细。</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none; padding-bottom: 0px;">
            <div class="right">
                <form class="search_form" method="post" action="<?php echo U('tongji/income');?>"> 
                    <div class="seleHidden" id="seleHidden">
                        <div class="seleK"> 
                           
                            <label>
                                <span>类型</span>
                                <select name="type" class="select w100">
                                    <option value="999">请选择</option>
                                    <?php if(is_array($types)): foreach($types as $key=>$item): ?><option <?php if(($type) == $key): ?>selected="selected"<?php endif; ?>  value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endforeach; endif; ?>
                                </select>
                            </label>
                            <label>
								<input type="hidden" id="user_id" name="user_id" value="<?php echo (($user_id)?($user_id):''); ?>"/>
                                 <a mini="select"  w="1000" h="600" href="<?php echo U('user/select');?>" class="seleSj">选择用户</a>
							 </label>
							 <label>
                                <input type="submit" value="   搜索"  class="inptButton" />
                            </label>
                        </div>
                    </div> 
                </form>
                <a href="javascript:void(0);" class="searchG">高级搜索</a>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <form method="post" action="<?php echo U('tongji/income');?>">
            <div class="selectNr selectNr2">
                <div class="left">
                    <div class="seleK">
                        
                        <label>
                            <span>类型</span>
                            <select name="type" class="select w80">
                                <option value="999">请选择</option>
                                <?php if(is_array($types)): foreach($types as $key=>$item): ?><option <?php if(($type) == $key): ?>selected="selected"<?php endif; ?>  value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endforeach; endif; ?>

                            </select>
                        </label>
                        <label>
                            <span>开始时间</span>
                            <input type="text" name="bg_date" value="<?php echo (($bg_date)?($bg_date):''); ?>"  onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'});"  class="text w150" />
                        </label>
                        <label>
                            <span>结束时间</span>
                            <input type="text" name="end_date" value="<?php echo (($end_date)?($end_date):''); ?>" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'});"  class="text w150" />
                        </label>
                       
                    </div>
                </div>
                <div class="right">
                    <input type="submit" value="   搜索"  class="inptButton" />
                </div>
                <div class="clear"></div>
            </div>
        </form>
        <div class="tableBox">

            <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="log_id" /></td>
                        <td class="w50">ID</td>
                        <td>城市</td>
                        <td>用户</td>
                        <td>类型</td>
                        <td>金额(单位：元)</td>
						<td>备注</td>
                        <td>日志时间</td>
                    </tr>
                    <tr>
                        <td colspan="8">总计：<?php echo round($sum/100,2);?>元</td>
                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_log_id" type="checkbox" name="log_id[]" value="<?php echo ($var["log_id"]); ?>" /> </td>
                            <td><?php echo ($var["log_id"]); ?></td>
                            <td><?php echo ($citys[$var['city_id']]['name']); ?></td>
                            <td><?php echo ($users[$var['user_id']]['nickname']); ?></td>
                            <td><?php echo ($types[$var['type']]); ?></td>
                            <td><?php echo round($var['gold']/100,2);?></td>
                            <td><?php echo ($var["intro"]); ?></td>
                            <td><?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
        </form>
        </div>
        
</div>
</body>
</html>