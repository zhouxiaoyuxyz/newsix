<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title><?php if(!empty($mobile_title)): echo ($mobile_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?></title>
        <meta name="keywords" content="<?php echo ($mobile_keywords); ?>" />
        <meta name="description" content="<?php echo ($mobile_description); ?>" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/<?php echo ($ctl); ?>.css?V=2"/>
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>
	    <script src="/static/default/wap/js/mobile_common.js"></script>
        <script src="/static/default/wap/js/iscroll-probe.js"></script>
        <?php $lng = $_COOKIE['lng']; $lat = $_COOKIE['lat']; ?>
        <?php if(empty($lat) || empty($lng)){ ?> 
       <!---- <script>
            function bd_encrypt(gg_lat, gg_lon)   // 百度地图测距偏差 问题修复
            {
                var x_pi = 3.14159265358979324 * 3000.0 / 180.0;
                var x = gg_lon;
                var y = gg_lat;
                var z = Math.sqrt(x * x + y * y) + 0.00002 * Math.sin(y * x_pi);
                var theta = Math.atan2(y, x) + 0.000003 * Math.cos(x * x_pi);
                var bd_lon = z * Math.cos(theta) + 0.0065;
                var bd_lat = z * Math.sin(theta) + 0.006;
                dingwei('<?php echo U("mobile/index/dingwei",array("t"=>$nowtime,"lat"=>"llaatt","lng"=>"llnngg"));?>', bd_lat, bd_lon);
            }

            navigator.geolocation.getCurrentPosition(function (position) {
                //bd_encrypt(position.coords.latitude, position.coords.longitude);
            });
           
        </script>-->
         <?php } ?>
        
	</head>
	<body>
<script src="/static/default/wap/other/cookie.js"></script>
<script src="/static/default/wap/js/elecart.js"></script>
<script src="/static/default/wap/js/dialog.js"></script>
<!--左侧可滑动特效-->
<script src="/static/default/wap/js/diyScroll.js"></script>
<script src="/static/default/wap/js/jquery.easing.min.js"></script>
<script src="/static/default/wap/js/function.js"></script>

<style>
    footer {
        height: 3rem;
        border-top: 1px #CCC solid;
        position: fixed;
        bottom: 0;
        z-index: 999;
        background: #EEE;
        width: 100%
    }

    .page-center-box {
        position: absolute;
        margin-top: 75px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        /*bottom: .5rem*/
    }

    .frame-set-left {
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        position: absolute;
        top: 7%;
        bottom: 0;
        left: 0;
        background: transparent;
    }

    .frame-set-left li {
        cursor: pointer;
        height: 2.3rem;
        line-height: 2.3rem;
        border-bottom: .1rem solid #dedede;
        display: inline-block
    }

    .frame-set-left li a {
        display: block;
        color: #333;
        padding: 0 .8rem;
        font-size: 12px
    }

    .frame-set-left .active {
        background: #FC445B;
        color: #FFF
    }

    .frame-set-left .active a {
        color: #fff
    }

    .frame-set-right {
        width: 100%;
        position: absolute;
        top: 10px;
        bottom: 0;
        left: 0;
        background: #FDF1DE;
    }

    .frame-set-right .list-have-pic .list-box {
        position: relative
    }

    .frame-set-right .list-have-pic .list-img {
        width: 5rem;
        height: 5rem
    }

    .frame-set-right .list-have-pic .list-content {
        margin-left: 6.06rem;
        height: auto;
        min-height: .8rem
    }

    .frame-set-right .list-have-pic .list-content .price del {
        color: #999;
        margin-left: .05rem
    }

    .frame-set-right .list-have-pic .num-input .btn {
        width: 1.4rem;
        height: 1.4rem;
        line-height: 1.4rem;
        text-align: center;
        border: .11rem #DEDEDE solid;
        color: #DEDEDE;
        border-radius: 100%;
        font-size: 14px
    }

    .frame-set-right .list-have-pic .num-input input {
        width: 1.3rem;
        height: 1.18rem;
        text-align: center;
        border: none 0;
        background-color: #fff;
        margin-left: .01rem
    }

    .frame-set-right .list-have-pic .num-input .active {
        border-color: #FC445B;
        color: #FC445B
    }


</style>

<header class="top-fixed bg-yellow bg-inverse">
    <div class="top-back">
        <a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
    </div>  
    <div class="top-title">
        <?php echo ($detail["weidian_name"]); ?>
    </div>
    <div class="top-search" style="display:none;">
        <form method="post" action="<?php echo U('mart/lists',array('id'=>$detail['id']));?>">
            <input name="keyword" placeholder="输入关键字"/>
            <button type="submit" class="icon-search"></button>
        </form>
         </div>
    <div class="top-signed">
        <a id="search-btn" href="javascript:void(0);"><i class="icon-search"></i></a>
    </div>
  
</header>

<script type="text/javascript">
    $(function () {
        $("#search-btn").click(function () {
            if ($(".top-search").css("display") == 'block') {
                $(".top-search").hide();
                $(".top-title").show(200);
            } else {
                $(".top-search").show();
                $(".top-title").hide(200);
            }
        });

    });
</script>

<!-- 筛选TAB 
   
<!--
<ul id="shangjia_tab">
        <li class="x4"><a href="<?php echo U('mart/lists',array('id'=>$detail['id']));?>" class="on">商品</a></li>
        <li class="x4"><a href="<?php echo U('mart/shopdetail',array('id'=>$detail['id']));?>">详情</a></li>
        <li class="x4"><a href="<?php echo U('mart/dianping',array('id'=>$detail['id']));?>">评价</a></li>
</ul>
 -->  
<script>
    $(function () {
        /*if ($('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
        /*{
            $('#shangjia_tab li').width(100 / $('#shangjia_tab li').length + '%');
            $('.page-center-box').css('top', '0.9rem');
        }//头部切换tab结束
        if ($('.elePrompt').length > 0 && $('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
        /*{
            $('#shangjia_tab').css('top', '0.9rem');
            $('.page-center-box').css('top', '1.3rem');
        /*} else if ($('.elePrompt').length > 0 || $('#shangjia_tab').length > 0) {
            $('.page-center-box').css('top', '6.0rem');
        }//头部提示结束*/
        $(".frame-set-left ul li").click(function () {
            $(".frame-set-left ul li").removeClass('active');
            $(this).addClass('active');
            var cate = $(this).attr('rel');
            if (cate == 'all') {
                $('.list-box').show();
            } else {
                $('.list-box').hide();
                $('.' + cate).show();
            }
        });
    });
 
</script>
  


<div>
  		<div class="demo" style="width: 100%; height:95px">
           <a href="https://www.enjoysix.cn/mobile/mart/lists/id/36.html ">
            <img src="http://img.027cgb.com/609575/1111.png" style="width: 100%; height: 95px;"/>
           </a>
        </div>
  
    <div class="frame-set-left">
      
        <ul style="margin-top:105px;white-space:nowrap;">
            <li class="active" rel="all"><a href="javascript:void(0);">左滑分类</a></li>
            <?php if(is_array($autocates)): foreach($autocates as $key=>$item): ?><li rel="cate_<?php echo ($item["cate_id"]); ?>"><a href="javascript:void(0);"><?php echo ($item["cate_name"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>
<div id="ele" class="page-center-box" style="top:100px">
    <div class="frame-set-right">
        <div id="scroll">
            <div class="">
                <div class="">
                    <div style="display: flex; flex-direction: row; flex-wrap: wrap; background: #FDF1DE">
                        <?php if(is_array($list)): foreach($list as $key=>$var): ?><div class="list-box cate_<?php echo ($var["shopcate_id"]); ?>" style="display: flex; width: 46%; border-radius: 10px; margin: 2%; background: white">
                                <?php $save = $var['price'] - $var['mall_price']; ?>
                                <div style="width: 100%">
                                    <div style="width: 100%">
                                        <img src="__ROOT__/attachs/<?php echo ($var["photo"]); ?>" width="100%" height="187px" style="margin-bottom: -40px; border-radius: 10px 10px 0 0">
                                        <div style="font-size: 0.8rem; color: white; margin-top: -20px; background-color: #FC445B; padding-right: 12px; height: 24px; line-height: 24px; display: inline-block; border-radius: 0 12px 12px 0">
                                            确认收货后补贴<?php echo round($var['return_cash']/100,1);?>元
                                        </div>
                                    </div>
                                    <div style="margin-top: 20px; display: flex; flex-direction: column; justify-content: space-between; height: auto">

                                        <div style="margin-left: 10px; margin-top: 0px; display: flex; flex-direction: column; justify-content: space-between; height: auto">
                                            <div>
                                                <p style="color: black; font-size: 14px; font-weight: bold; height: 48px; overflow: hidden" onclick="location='<?php echo U('mall/detail',array('goods_id'=>$var['goods_id']));?>'">
                                                    <?php echo ($var["title"]); ?>
                                                </p>
                                            </div>
                                            <div style="margin:5px 0 5px 0">
                                                <span style="font-size: 1rem; color: #FC445B; margin-right: 5px">&yen;<?php echo round($var['mall_price']/100,2);?></span><del style="font-size: 0.8rem; color: #bcbcbc">&yen;<?php echo round($var['price']/100,2);?></del>
                                            </div>
                                        </div>

                                        <div style="display: flex; flex-direction: row; justify-content: space-between; margin: 10px 0 15px 0">
                                            <div style="width: 15%"></div>
                                            <div class="btn" style="background:#E2E4E8; border-radius: 5px; text-align:center; width: 15%; height: 25px; line-height: 25px" val="<?php echo round($var['mall_price']/100,2);?>" gid="<?php echo ($var["goods_id"]); ?>" onclick="dec(this);">-</div>
                                            <div class="ordernum" style="width: 50%; text-align: center">
                                                <input style="background: white; width: 50%; border: white 0; border-radius: 5px; background: #E2E4E8; height: 25px; line-height: 25px; text-align: center" type="text" readonly="readonly" class="ordernum" value="<?php echo (($var["cart_num"])?($var["cart_num"]):'0'); ?>" />
                                            </div>
                                            <div class="btn active jq_addcart" style="background:#E2E4E8; border-radius: 5px; text-align:center; width: 15%; height: 25px; line-height: 25px" val="<?php echo round($var['mall_price']/100,2);?>" gid="<?php echo ($var["goods_id"]); ?>" onclick="addcart(this);">+</div>
                                            <div style="width: 15%"></div>
                                        </div>

                                    </div>
                                </div>

                                <!--<div class="list-img">-->
                                <!--<img src="__ROOT__/attachs/<?php echo ($var["photo"]); ?>">-->
                                <!--</div>-->
                                <!--<div class="list-content">-->
                                <!--<p class="overflow_clear" onclick="location='<?php echo U('mall/detail',array('goods_id'=>$var['goods_id']));?>'">-->
                                <!--<?php echo ($var["title"]); ?>-->
                                <!--</p>-->
                                <!--<p class="overflow_clear" style="background-color: #ff5000;color: #fff;padding: 3px;line-height: 12px;display: inline-block;">-->
                                <!--&lt;!&ndash;下单立减<?php echo round($var['mobile_fan']/100,2);?>元&ndash;&gt;&lt;!&ndash;送<?php echo round($var['return_cash']/300,1);?>桶山泉水&ndash;&gt;-->
                                <!--买就送<?php echo round($var['return_cash']/100,1);?>元山泉水费</p>-->
                                <!--<p class="price fontcl1">-->
                                <!--<?php echo round($var['mall_price']/100,2);?>元<del><?php echo round($var['price']/100,2);?>元</del>-->
                                <!--</p>-->
                                <!--<div class="num-input">-->
                                <!--<div class="btn" val="<?php echo round($var['mall_price']/100,2);?>" gid="<?php echo ($var["goods_id"]); ?>" onclick="dec(this);">-</div>-->
                                <!--<div class="input"><input type="text" readonly="readonly" class="ordernum" value="<?php echo (($var["cart_num"])?($var["cart_num"]):'0'); ?>" /></div>-->
                                <!--<div class="btn active jq_addcart" val="<?php echo round($var['mall_price']/100,2);?>" gid="<?php echo ($var["goods_id"]); ?>" onclick="addcart(this);" >+</div>-->
                                <!--</div>-->
                                <!--</div>-->
                            </div><?php endforeach; endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<footer class="footer-cart eleFooter-cart">
    <div class="cart">
        <a href="<?php echo U('mart/cart',array('id'=>$detail['id']));?>">
            <div class="cart-num" id="num"></div>
        </a>
    </div>
    <div class="price">￥<span id="total_price"></span></div>
    <div class="btn"><a href="<?php echo U('mart/cart',array('id'=>$detail['id']));?>" style="color:#FFFFFF;">确认下单</a></div>
</footer>


<!--JS 购物车-->
<script type="text/javascript">
    function addcart(o) {
        var data = {}, shop_id = "<?php echo ($detail['shop_id']); ?>";
        data['goods_id'] = $(o).attr('gid');
        data['price'] = $(o).attr('val');
        var v = $(o).parent().find(".ordernum").val();
        if (v < 99) {
            v++;
            $(o).parent().find(".ordernum").val(v);
        }
        window.mall.addcart(shop_id, data);
        $("#num").text(window.mall.count(shop_id));
        $("#total_price").html(window.mall.totalprice(shop_id));
    }

    function dec(e) {
        var goods_id = $(e).attr('gid'), shop_id = "<?php echo ($detail['shop_id']); ?>";
        window.mall.dec(shop_id, goods_id);
        var v = $(e).parent().find(".ordernum").val();
        if (v > 0) {
            v--;
            $(e).parent().find(".ordernum").val(v);
        }
        $("#num").text(window.mall.count(shop_id));
        $("#total_price").html(window.mall.totalprice(shop_id));
    }

    //初始化购物城数据
    ~function () {
        var count = window.mall.count("<?php echo ($detail['shop_id']); ?>");
        var totalprice = window.mall.totalprice("<?php echo ($detail['shop_id']); ?>");
        $("#num").text(count);
        $("#total_price").html(totalprice);
    }();

    //左侧可滑动特效
    /*	$(".frame-set-left:eq(0)").Frame({type:[0,0],background:"#efefef",color:"#999999",topfunc:"history.go(0)",botfunc:"",id:"left_Scroll",ScrollWidth:1});
        $(function(){
            if(PhoneType()=='Android'){
                setTimeout(function(){$(".frame-set-left:eq(0) .left_Scroll_to_top").css({marginTop:-50});},100);
            }
        });
        */


    /*
    $(".frame-set-right:eq(0)").Frame({type:[0,0],background:"#efefef",color:"#999999",topfunc:"history.go(0)",botfunc:"",id:"left_Scroll",ScrollWidth:1});
    $(function(){
        if(PhoneType()=='Android'){
            setTimeout(function(){$(".frame-set-right:eq(0) .left_Scroll_to_top").css({marginTop:-50});},100);
        }
    });*/


</script>
</body>
</div>

<script> var BAO_PUBLIC = '__PUBLIC__';
var BAO_ROOT = '__ROOT__';
var BAO_SURL = '<?php echo ($CONFIG['
site
']['
host
']); ?>__SELF__'</script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
<script>
    $(function () {
        var newurl = BAO_SURL.replace(/\\?\\S+/, '');
        var stitle = "<?php if( !empty($mobile_title) ): echo ($mobile_title); endif; echo ($detail["weidian_name"]); ?>_<?php echo ($CONFIG["site"]["sitename"]); ?>";
        var sdesc = "店铺地址：<?php echo ($detail["addr"]); ?>丨单单均送山泉水丨商品实惠丨泉水免费丨取货便捷丨";
        //alert(stitle);
        var shop_pic = "<?php echo ($CONFIG['site']['host']); ?>" + "/attachs/" + "<?php echo ($detail["pic"]); ?>";
        var surl = newurl + '?fuid=<?php echo getuid();?>';
        var catchpic = $('img');
        var lcatchpic = "<?php echo ($CONFIG['site']['host']); ?>" + $('img').eq(0).attr("src");
        $('img').each(function () {
            if ($(this).width() >= 60) {
                lcatchpic = $(this).attr("src");
                if (lcatchpic.indexOf("http://") < 0) {
                    lcatchpic = "<?php echo ($CONFIG['site']['host']); ?>" + lcatchpic;
                }
                return false;
            }
            ;
        });

        var spic = "<?php echo ($CONFIG['site']['host']); ?>" + BAO_PUBLIC + '/img/logo.jpg';
        if (catchpic.length > 0) {
            spic = lcatchpic;

        }
        if (shop_pic.length > 30) {
            spic = shop_pic;

        }
        console.log(lcatchpic);
        //alert(spic);
        wx.config({
            debug: false,
            appId: '<?php echo ($signPackage["appId"]); ?>',
            timestamp: '<?php echo ($signPackage["timestamp"]); ?>',
            nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
            signature: '<?php echo ($signPackage["signature"]); ?>',
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'onMenuShareQZone'
            ]
        });
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: stitle,
                link: surl,
                imgUrl: spic,
                success: function () {
                    alert("分享成功!");
                },
                cancel: function () {
                    alert("分享失败!");
                }
            });
            wx.onMenuShareAppMessage({
                title: stitle,
                desc: sdesc,
                link: surl,
                imgUrl: spic,
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    alert("分享给朋友成功!");
                },
                cancel: function () {
                    alert("分享给朋友失败!");
                }
            });
            wx.onMenuShareQQ({
                title: stitle,
                desc: sdesc,
                link: surl,
                imgUrl: spic,
                success: function () {
                    alert("分享到QQ成功!");
                },
                cancel: function () {
                    alert("分享到qq失败!");
                }
            });
            wx.onMenuShareWeibo({
                title: stitle,
                desc: sdesc,
                link: surl,
                imgUrl: spic,
                success: function () {
                    alert("分享到微博成功!");
                },
                cancel: function () {
                    alert("分享到微博失败!");
                }
            });
            wx.onMenuShareQZone({
                title: stitle,
                desc: sdesc,
                link: surl,
                imgUrl: spic,
                success: function () {
                    alert("分享到QQ空间成功!");
                },
                cancel: function () {
                    alert("分享到QQ空间失败!");
                }
            });
        });
    })
</script>