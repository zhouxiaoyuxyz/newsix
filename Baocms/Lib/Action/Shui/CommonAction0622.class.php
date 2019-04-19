<?php
class CommonAction extends Action{
	protected $uid = 0;
    protected $member = array();
    protected $_CONFIG = array();
    protected $citys = array();
    protected $areas = array();
    protected $city_id = 0;
    protected $city = array();
    protected function _initialize(){
        define('__HOST__', 'https://' . $_SERVER['HTTP_HOST']);
        $this->_CONFIG = D('Setting')->fetchAll();
        $this->citys = D('City')->fetchAll();
        $this->assign('citys', $this->citys);
        $this->city_id = cookie('city_id');
        if (empty($this->city_id)) {
            import('ORG/Net/IpLocation');
            $IpLocation = new IpLocation('UTFWry.dat');
            // 实例化类 参数表示IP地址库文件
            $result = $IpLocation->getlocation($_SERVER['REMOTE_ADDR']);
            foreach ($this->citys as $val) {
                if (strstr($result['country'], $val['name'])) {
                    $city = $val;
                    $this->city_id = $val['city_id'];
                    break;
                }
            }
            if (empty($city)) {
                $this->city_id = $this->_CONFIG['site']['city_id'];
                $city = $this->citys[$this->_CONFIG['site']['city_id']];
            }
        } else {
            $city = $this->citys[$this->city_id];
        }
        $this->city = $city;
        define('IN_MOBILE', true);
        $ctl = strtolower(MODULE_NAME);
        $act = strtolower(ACTION_NAME);
        $is_weixin = is_weixin();
        $is_weixin = $is_weixin == false ? false : true;
        define('IS_WEIXIN', $is_weixin);
        $this->uid = getUid();
        if (!empty($this->uid)) {
            $member = $MEMBER = $this->member = D('Users')->find($this->uid);
            //客户端缓存会员数据
            $member['password'] = '';
            $member['token'] = '';
            cookie('member', $member);
        }
      
        //这里主要处理推广链接入口！如果是用户推广进来的会增加到COOKIE
        $invite = (int) $this->_get('invite');
        if (!empty($invite)) {
            //这里改成了获得积分
            cookie('invite_id', $invite);
        }
        //三级分销开始
        $fuid = (int) $this->_get('fuid');
        if (!empty($fuid)) {
            $profit_expire = (int) $this->_CONFIG['profit']['profit_expire'];
            if ($profit_expire) {
                cookie('fuid', $fuid, $profit_expire * 60 * 60);
            } else {
                cookie('fuid', $fuid);
            }
        }
        //三级分销结束
        //全民推广员结束
        $tui_uid = (int) $this->_get('tui_uid');
        if ($tui_uid) {
            if ($goods_id = (int) $this->_get('goods_id')) {
                //两个条件都满足的情况下 COOKIE 存一个月
                cookie('tui', $tui_uid . '_' . $goods_id, 30 * 86400);
                //一个月有效果
            }
        }
        //商城推广推荐用户购买首次下单返现
        $tui_uids = (int) $this->_get('tui_uids');
        if ($tui_uids) {
            cookie('tuis', $tui_uids, 15 * 86400);
            //半个月有效果
        }
		
        $this->_CONFIG = D('Setting')->fetchAll();
        if (!empty($city['name'])) {
            $this->_CONFIG['site']['cityname'] = $city['name'];
        }
		if (empty($this->uid)) {
        //对微信用户是否登录进行判断
			if ($this->_CONFIG['site']['weixin'] == 1) {
				if ($is_weixin && !empty($this->_CONFIG['weixin']['appid'])) {
					if (!$this->uid && $act != 'wxstart') {
						$state = md5(uniqid(rand(), TRUE));
						session('state', $state);
						if (!empty($_SERVER['REQUEST_URI'])) {
							$backurl = $_SERVER['REQUEST_URI'];
						} else {
							$backurl = U('index/index');
						}
						session('backurl', $backurl);
						$login_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->_CONFIG['weixin']['appid'] . '&redirect_uri=' . urlencode(__HOST__ . U('passport/wxstart')) . '&response_type=code&scope=snsapi_userinfo&state=' . $state . '#wechat_redirect';
						header("location:{$login_url}");
						echo $login_url;
						die;
					}
				}
			}
		}
        $local = D('Near')->GetLocation();
        $this->assign('local', $local);
        $this->assign('CONFIG', $this->_CONFIG);
        $this->assign('MEMBER', $this->member);
        $this->areas = D('Area')->fetchAll();
        $areass = array();
        foreach ($this->areas as $key => $v) {
            if ($v['city_id'] == $this->city_id) {
                $areass[] = $this->areas[$key];
            }
        }
        $this->assign('areas', $areass);
        $limit_area = array();
        foreach ($this->areas as $k => $val) {
            if ($val['city_id'] == $this->city_id) {
                $limit_area[] = $val['area_id'];
            }
        }
		
        $this->assign('areass', $this->areas);
        $this->assign('today', TODAY);
        //兼容模版的其他写法
        $this->assign('nowtime', NOW_TIME);
        $this->assign('ctl', strtolower(MODULE_NAME));
        //主要方便调用
        $this->assign('act', ACTION_NAME);
        $this->assign('is_weixin', IS_WEIXIN);
        $this->assign('city_name', $city['name']);
        //您当前可能在的城市
        $this->assign('city_id', $this->city_id);
        $city_ids = array('0', $this->city_id);
        $city_ids = join(',', $city_ids);
        $this->assign('city_ids', $city_ids);
		
		
		
        //获取微信的PID全局

        import("@/Net.Jssdk");
        $jssdk = new JSSDK($this->_CONFIG['weixin']["appid"], $this->_CONFIG['weixin']["appsecret"]);
        $signPackage = $jssdk->GetSignPackage();
        $this->signPackage = $signPackage;
       
    }
   

    protected function baoSuccess($message, $jumpUrl = '', $time = 3000)
    {
        $str = '<script>';
        $str .= 'parent.success("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
        $str .= '</script>';
        die($str);
    }
    protected function baoErrorJump($message, $jumpUrl = '', $time = 3000)
    {
        $str = '<script>';
        $str .= 'parent.error("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
        $str .= '</script>';
        die($str);
    }
    protected function baoreturn($error, $message)
    {
        echo '{"success":"' . $error . '","message":"' . $message . '"}';
    }
    protected function baoError($message, $time = 3000, $yzm = false)
    {
        $str = '<script>';
        if ($yzm) {
            $str .= 'parent.error("' . $message . '",' . $time . ',"yzmCode()");';
        } else {
            $str .= 'parent.error("' . $message . '",' . $time . ');';
        }
        $str .= '</script>';
        die($str);
    }
	protected function fengmiMsg($message, $jumpUrl = '', $time = 3000)
    {
        $str = '<script>';
        $str .= 'parent.boxmsg("' . $message . '","' . $jumpUrl . '","' . $time . '");';
		$str .= 'setTimeout(function () {';
		$str .= 'window.location.reload();';
		$str .= '		}, 3000);';
        
        $str .= '</script>';
        die($str);
    }
    protected function checkFields($data = array(), $fields = array())
    {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }
    protected function ipToArea($_ip)
    {
        return IpToArea($_ip);
    }
}