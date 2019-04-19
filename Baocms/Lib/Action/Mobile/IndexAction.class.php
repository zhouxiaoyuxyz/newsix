<?php
class IndexAction extends CommonAction {
      public function index() {
        $this->assign('lifecate', D('Lifecate')->fetchAll());
        $this->assign('channel', D('Lifecate')->getChannelMeans());
		//获取用户自定坐标

		$lat = cookie('lat_ok');
		$lng = cookie('lng_ok');
		if(empty($lat) || empty($lng)){
			$lat = cookie('lat');
			$lng = cookie('lng');
		}
        if (empty($lat) || empty($lng)) {
            $lat = $this->_CONFIG['site']['lat'];
            $lng = $this->_CONFIG['site']['lng'];
        }
        $orderby = " (ABS(lng - '{$lng}') +  ABS(lat - '{$lat}') ) asc ";
        $shoplist = D('Shop')->where(array('city_id'=>$this->city_id, 'closed' => 0, 'audit' => 1))->order($orderby)->limit(0, 5)->select();
		foreach ($shoplist as $k => $val) {
            $shoplist[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
            $shoplist[$k]['weidian'] = D('Weidiandetails')->where(array('shop_id' => $val['shop_id']))->find();
            $shoplist[$k]['weidian_id'] = $shoplist[$k]['weidian']['id'];
			$shopyouhui = D('Shopyouhui')->where(array('shop_id' => $val['shop_id'], 'is_open' => 1, 'audit' => 1))->find();
			if(!empty($shopyouhui)){
				$shoplist[$k]['fanxian']=100-$shopyouhui['discount']-$shopyouhui['deduction'];
			}
        }
        $news = D('Article')->where(array('city_id'=>$this->city_id, 'closed' => 0, 'audit' => 1))->order(array('orderby' => 'desc'))->limit(0, 5)->select();
		$community = D('Community')->where(array('city_id'=>$this->city_id, 'closed' => 0, 'audit' => 1,))->order($orderby)->limit(0, 5)->select();
		foreach ($community as $k => $val) {
            $community[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
        }
        $this->assign('shoplist', $shoplist);
        $this->assign('news', $news);
		$this->assign('community', $community);
		$maps = array('status' => 2,'closed'=>0);
		$this->assign('nav',$nav = D('Navigation') ->where($maps)->order(array('orderby' => 'asc'))->select());
		$bg_time = strtotime(TODAY);
		$this->assign('sign_day', $sign_day = (int) D('Usersign')->where(array('user_id' => $this->uid, 'create_time' => array(array('ELT', NOW_TIME), array('EGT', $bg_time))))->count());
        
        // 计算互助金总额
      $helpmoney = D('Shopmoney')->where(array('shop_id' => 72))->sum('money');
      $this->assign('helpmoney', $helpmoney);

      // 到家服务
      $Eleproduct = D('Eleproduct');
      $map = array('closed' => 0, 'audit' => 1, 'shop_id' => 71);
      $daojialist = $Eleproduct->where($map)->limit(0 . ',' . 5)->order(array('sold_num' => 'desc', 'price' => 'asc'))->select();
      // $daojialist = $Eleproduct->where($map)->order(array('sold_num' => 'desc', 'price' => 'asc'))->select();
      $this->assign('daojialist', $daojialist);
		
        
        $this->display();
    }
    public function search() {
        $keys = D('Keyword')->fetchAll();
        $keytype = D('Keyword')->getKeyType();
        $this->assign('keys',$keys);
        $this->display();
    }

	 public function dingwei() {
        $lat = $this->_get('lat', 'htmlspecialchars');
        $lng = $this->_get('lng', 'htmlspecialchars');
        cookie('lat', $lat);
        cookie('lng', $lng);
        echo NOW_TIME;
    }

	public function more() {
		$maps = array('status' => 2,'closed'=>0);
		$this->assign('nav',$nav = D('Navigation') ->where($maps)->order(array('orderby' => 'asc'))->select());
		$this->display();
	}
  
  public function new_index() {
        if (empty($this->uid)) {
            header('Location: ' . U('mobile/passport/login'));
            die;
        }
        //增加开始
        $this->assign('order', D('Tuanorder')->where(array('user_id' => $this->uid))->count());
        $this->assign('code', D('Tuancode')->where(array('user_id' => $this->uid, 'is_used' => 0, 'status' => 0))->count());
        $this->assign('goods_order', D('Order')->where(array('user_id' => $this->uid))->count());
        $this->assign('ele_order', D('Eleorder')->where(array('user_id' => $this->uid))->count());
        $this->assign('coupon', D('Coupondownload')->where(array('user_id' => $this->uid, 'is_used' => 0))->count());
        $this->assign('hd', D('Huodong')->where(array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1))->count());
        $this->assign('xiaoqu', D('Community')->where(array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1))->count());
        $this->assign('tieba', D('Post')->where(array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1))->count());
        $this->assign('lipin', D('Integralexchange')->where(array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1))->count());
        $this->assign('tongzhi', D('Msg')->where(array('user_id' => $this->uid))->count());
        $this->assign('yuehui', D('Usermessage')->where(array('user_id' => $this->uid))->count());
        //统计同城信息
        $this->assign('life', D('Life')->where(array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1))->count());
        $this->assign('shop_yuyue', D('Shopyuyue')->where(array('user_id' => $this->uid, 'closed' => 0, 'used' => 0))->count());
        //增加结束
        //检测是否有店铺
        $is_shop = D('Shop')->find(array('where' => array('user_id' => $this->uid)));
        $is_shop_name = $is_shop['shop_name'];
        $this->assign('is_shop_name', $is_shop_name);
        $this->assign('is_shop', $is_shop);
        //统计今日新的约会数量
        $counts = array();
        $bg_time = strtotime(TODAY);
        //今日时间，需要统计其他的下面写。
        $counts['yuhui'] = (int) D('Huodong')->where(array('user_id' => $this->user_id, 'create_time' => array(array('ELT', NOW_TIME), array('EGT', $bg_time))))->count();
        $counts['tieba'] = (int) D('Post')->where(array('user_id' => $this->user_id, 'create_time' => array(array('ELT', NOW_TIME), array('EGT', $bg_time))))->count();
        $this->assign('counts', $counts);
        $this->assign('user_id', $this->uid);
        $sf = D('ShopFavorites');
        $rsf = $sf->where('user_id =' . $this->uid)->count();
        $this->assign('rsf', $rsf);
    	
    	// 计算互助金总额
        $helpmoney = D('Shopmoney')->where(array('shop_id' => 72))->sum('money');
        $this->assign('helpmoney', $helpmoney);
    
    	 // 到家服务
        $Eleproduct = D('Eleproduct');
        $map = array('closed' => 0, 'audit' => 1, 'shop_id' => 71);
        $daojialist = $Eleproduct->where($map)->limit(0 . ',' . 5)->order(array('sold_num' => 'desc', 'price' => 'asc'))->select();
        // $daojialist = $Eleproduct->where($map)->order(array('sold_num' => 'desc', 'price' => 'asc'))->select();
        $this->assign('daojialist', $daojialist);

    
        $this->display();

    }
}

