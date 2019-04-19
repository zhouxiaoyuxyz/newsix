<?php if (!defined('THINK_PATH')) exit();?><script>
    function daojishi(id) {
        var t = Math.floor($("#" + id).attr('rel'));
        t--;
        var d = Math.floor(t / 60 / 60 / 24);
        var h = Math.floor(t / 60 / 60 % 24);
        var m = Math.floor(t / 60 % 60);
        var s = Math.floor(t % 60);
        if (d < 10) {
            d = '0' + d;
        }
        if (h < 10) {
            h = '0' + h;
        }
        if (m < 10) {
            m = '0' + m;
        }
        if (s < 10) {
            s = '0' + s;
        }
        $("#" + id).attr('rel', t);
        $("#" + id).html(d + '天' + h + ':' + m + ':' + s);
    }
</script>

<style>

    .price-span {
        color: white;
        margin-left: 3px;
        padding: 3px;
        background: #D91E3C;
        background: radial-gradient(circle at top left, transparent 3px, #D91E3C 0) top left,
        radial-gradient(circle at top right, transparent 3px, #D91E3C 0) top right,
        radial-gradient(circle at bottom right, transparent 3px, #D91E3C 0) bottom right,
        radial-gradient(circle at bottom left, transparent 3px, #D91E3C 0) bottom left;
        background-size: 60% 60%;
        background-repeat: no-repeat;
    }

    .li-radious {
        border-bottom: 0px;
        background: transparent;
        background: radial-gradient(circle at top left, transparent 7px, #FDF8F1 0) top left,
        radial-gradient(circle at top right, transparent 7px, #FDF8F1 0) top right,
        radial-gradient(circle at bottom right, transparent 7px, #FDF8F1 0) bottom right,
        radial-gradient(circle at bottom left, transparent 7px, #FDF8F1 0) bottom left;
        background-size: 60% 60%;
        background-repeat: no-repeat;
    }

    a{text-decoration: none;}
    a:visited{text-decoration: none;}
    a:hover {text-decoration: none;}
    a:active{text-decoration:none;}

</style>

<?php if(is_array($shops)): foreach($shops as $key=>$var): ?><div class="tuan-shop">
        <!--<div class="shop-con">
            <div class="shop-name"><a title="<?php echo ($var["shop_name"]); ?>" href="<?php echo U('shop/detail',array('shop_id'=>$var['shop_id']));?>"><?php echo ($var["shop_name"]); ?></a></div>
            <div class="shop-tags">
                <img class="distance_icon" src="/static/default/wap/image/tuan/distance.png" alt="" draggable="false">
                <dis class="shop-local"><?php echo ($var["d"]); ?></dis>
            </div>-->
    </div>


    <div class="main-tuan">
        <ul>
            <div style="display: flex; flex-direction: row; flex-wrap: wrap; background: #FDF1DE">

                <?php if(is_array($list)): foreach($list as $key=>$item): ?><div style="display: flex; width: 48%; border-radius: 10px; margin: 1%;">

                        <?php if(($item["shop_id"]) == $var['shop_id']): if($item['bg_date'] <= $today && $item['end_date'] > $today){ $tt = strtotime($item['end_date'])-time(); $item['djs_time'] = $tt; $item['djs_str'] = '距结束'; }elseif($item['bg_date'] >$today){ $tt = strtotime($item['bg_date'])-time(); $item['djs_time'] = $tt; $item['djs_str'] = '距开始'; } ?>
                            <script type="text/javascript" language="javascript">
                                setInterval(function () {
                                    daojishi("daojishi_<?php echo ($item["tuan_id"]); ?>");
                                }, 1000);
                            </script>

                            <li class="li-radious" style="margin: 0; border-bottom: 0; border-bottom: 0; background-color: transparent">
                                <a style="display: flex; flex-direction: column; " href="<?php echo U('tuan/detail',array('tuan_id'=>$item['tuan_id']));?>">
                                    <div style="width: 100%;">
                                        <img src="__ROOT__/attachs/<?php echo ($item["photo"]); ?>" alt="" style="width: 100%; height: 180px"/>
                                    </div>

                                    <div style="display: flex; flex-direction: column;">
                                        <!--标题-->
                                        <div style="text-align: center; font-size: 12px; color: black; min-height: 32px; margin-top: 5px">
                                            <span><?php echo ($item["title"]); ?></span>
                                        </div>

                                        <div style="height:1px; background:#B1AEA8; margin: 5px 10px 10px 10px"></div>

                                        <!--抢购时间-->
                                        <div style="text-align: center; font-size: 10px">
                                            <!--<span style="color :#35A7CD; "><?php echo ($item['djs_str']); ?></span>
                                            <span id="daojishi_<?php echo ($item["tuan_id"]); ?>" rel="<?php echo ($item['djs_time']); ?>" style="color: #35A7CD;">00:00:00:00</span>-->
                                            
                                             <span class="am-icon-thumbs-o-up">销售数:<?php echo ($item["sold_num"]); ?></span>
                                            <?php if($item['num'] > 0): ?><span style="font-size: 12px; background-color: #35A7CD; border-radius: 5px; color: white; padding: 0px 3px">剩余<?php echo round($item['num']/($item['sold_num'] + $item['num']),2)*100;?>%</span>
                                                <?php else: ?>
                                                <span style="font-size: 12px; background-color: #35A7CD; border-radius: 5px; color: white; padding: 0px 3px">已售罄</span><?php endif; ?>
                                        </div>

                                        <div style="height:1px; background:#B1AEA8; margin: 5px 10px 10px 10px"></div>

                                        <!--价格-->
                                        <div style="text-align: center; font-size: 12px; color: #D91E3C">
                                            <span>六享价￥<em style="font-size: 16px"><?php echo round($item['tuan_price']/100,2);?></em></span>

                                            <?php if($item['mobile_fan'] > 0): ?><span class="price-span">补贴<?php echo ($item['mobile_fan']/100); ?>元</span>
                                                <?php else: ?>
                                                <span class="price-span">无补贴</span><?php endif; ?>
                                        </div>

                                    </div>

                                </a>
                            </li>


                            <!--
                            <li>
                                <a class="line" href="<?php echo U('tuan/detail',array('tuan_id'=>$item['tuan_id']));?>">
                                    <div class="container">
                                        <img class="x4" src="__ROOT__/attachs/<?php echo ($item["photo"]); ?>"/>
                                        <div class="des x8">
                                            <h5><?php echo ($item["title"]); ?></h5>
                                            <p class="intro">
                                                <em class="clock_ico"></em>
                                                <?php echo ($item['djs_str']); ?>
                                                <span id="daojishi_<?php echo ($item["tuan_id"]); ?>"
                                                      rel="<?php echo ($item['djs_time']); ?>">00:00:00:00</span>

                                                <?php if($item['num'] > 0): ?><span class="text-little float-right badge bg-yellow margin-small-top padding-right remaining-percent">剩余<?php echo round($item['num']/($item['sold_num'] + $item['num']),2)*100;?>%</span>
                                                    <?php else: ?>
                                                    <span class="text-little float-right badge bg-yellow margin-small-top padding-right remaining-percent">已售罄</span><?php endif; ?>

                                            </p>
                                            <p class="info">
                                                <span>六享价￥<em><?php echo round($item['tuan_price']/100,2);?></em></span>

                                                <?php if($item['mobile_fan'] > 0): ?><span class="text-little float-right badge bg-yellow margin-small-top padding-right another-cut">赠送<?php echo ($item['mobile_fan']/100); ?>元</span>
                                                    <?php else: ?>
                                                    <span
                                                        class="text-little float-right badge bg-yellow margin-small-top padding-right remaining-percent">无赠送</span><?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            --><?php endif; ?>

                    </div><?php endforeach; endif; ?>

            </div>

        </ul>
    </div>
    </div><?php endforeach; endif; ?>