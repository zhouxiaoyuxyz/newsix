<?php
class RetailAction extends CommonAction
{
    public function _initialize()
    {
        parent::_initialize();
        //统计抢购分类数量代码开始
        $Retail = D('Retail');
        $tuancates = D('Retailcate')->fetchAll();
        foreach ($tuancates as $key => $v) {
            if ($v['cate_id']) {
                $catids = D('Retailcate')->getChildren($v['cate_id']);
                if (!empty($catids)) {
                    $count = $Retail->where(array('cate_id' => array('IN', $catids), 'closed' => 0, 'audit' => 1))->count();
                } else {
                    $count = $Retail->where(array('cate_id' => $cat, 'closed' => 0, 'audit' => 1))->count();
                }
            }
            $tuancates[$key]['count'] = $count;
        }
        $this->assign('tuancates', $tuancates);
    }
    public function main()
    {
        $aready = (int) $this->_param('aready');
        $this->assign('aready', $aready);
        $this->mobile_title = '抢购主页';
        $this->display();
    }
    public function mainload()
    {
        $aready = (int) $this->_param('aready');
        $t = D('Retail');
        if ($aready == 1) {
            $order = 'create_time desc';
        } elseif ($aready == 2) {
            $order = 'sold_num desc';
        } elseif ($aready == 3) {
            $order = 'views desc';
        }
        import('ORG.Util.Page');
        // 导入分页类
        $map = array('audit' => 1, 'closed' => 0, 'city_id' => $this->city_id, 'end_date' => array('EGT', TODAY));
        $count = $t->where($map)->count();
        // 查询满足要求的总记录数
        $Page = new Page($count, 10);
        // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();
        // 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $t->where($map)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('tuans', $list);
        // 赋值数据集www.hatudou.com  二开开发qq  120585022
        $this->assign('page', $show);
        // 赋值分页输出
        $this->display();
    }
    public function push()
    {
        // 这里的代码在mobile首页被调用。新版6.0重新编写
        $Tuan = D('Retail');
        import('ORG.Util.Page');
        // 导入分页类
        $lat = addslashes(cookie('lat'));
        $lng = addslashes(cookie('lng'));
        if (empty($lat) || empty($lng)) {
            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
        }
        $map = array('audit' => 1, 'closed' => 0, 'city_id' => $this->city_id, 'end_date' => array('EGT', TODAY));
        $count = $Tuan->where($map)->count();
        // 查询满足要求的总记录数
        $Page = new Page($count, 10);
        // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();
        // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $tuans = $Tuan->order(" (ABS(lng - '{$lng}') +  ABS(lat - '{$lat}') ) asc ")->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($tuans as $k => $val) {
            $tuans[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
        }
        $this->assign('tuans', $tuans);
        $this->assign('page', $show);
        // 赋值分页输出
        $this->display();
    }
    public function retailcate()
    {
        $this->display();
    }
    public function index()
    {
        import('ORG.Util.Page');
        $map = array('audit' => 1, 'closed' => 0, 'end_date' => array('EGT', TODAY));
        //获取产品分类
        $cat = (int) $this->_param('cat');
        $this->assign('cat', $cat);
        if($cat){
            $catids = D('Retailcate')->getChildren($cat);
            if (!empty($catids)) {
                $map['cate_id'] = array('IN', $catids);
            } else {
                $map['cate_id'] = $cat;
            }
        }
        // echo "cate:";
        // echo "$cat";

        //获取机器编号
        $m_sn = $this->_param('m_sn', 'htmlspecialchars');
        // echo "m_sn:";
        // echo "$m_sn";
        if($m_sn){
            $map['m_sn']=$m_sn;
            $this->assign('m_sn', $m_sn);
        }

        //添加首页分类列表
        $Retail = D('Retail');
        //水果
        $tansuanlist=$Retail->where(array('cate_id'=>2,'audit'=>1,'closed' => 0, 'city_id' => $this->city_id,'m_sn'=>$m_sn, 'end_date' => array('EGT', TODAY)))->select();
        //echo '<pre>';print_r($tansuanlist);echo '<pre>';
        $this->assign('tansuanlist',$tansuanlist);

        //肉禽
        $catids = D('Retailcate')->getChildren(15);
        $rouqinlist=$Retail->where(array('cate_id'=>array('IN',$catids),'audit'=>1,'closed' => 0, 'city_id' => $this->city_id, 'end_date' => array('EGT', TODAY)))->select();
        $this->assign('rouqinlist',$rouqinlist);

        // echo"chuandisn";
        // echo $m_sn;

        //产品列表
        $count = $Retail->where($map)->count();
        // 查询满足要求的总记录数
        $Page = new Page($count, 10);
        // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();
        // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Retail->where($map)->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->assign('list', $list);
        // 赋值数据集www.hatudou.com  二开开发qq  120585022
        $this->assign('page', $show);
        // 赋值分页输出

        $this->assign('nextpage', LinkTo('retail/loaddata', array('sn'=>$m_sn,'cat' => $cat, 'area' => $area, 'business' => $business, 'order' => $order, 't' => NOW_TIME, 'keyword' => $keyword, 'p' => '0000')));
        $this->display();
    }

    public function index_aibox()
    {
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        $cat = (int) $this->_param('cat');
        $this->assign('cat', $cat);
        $areas = D('Area')->fetchAll();
        $area = (int) $this->_param('area');
        $this->assign('area_id', $area);
        $this->assign('areas', $areas);
        $order = $this->_param('order', 'htmlspecialchars');
        $this->assign('order', $order);
        $biz = D('Business')->fetchAll();
        $business = (int) $this->_param('business');
        $this->assign('business_id', $business);
        $this->assign('biz', $biz);
        $m_sn = $this->_param('sn', 'htmlspecialchars');
        $this->assign('m_sn', $m_sn);


        $this->assign('nextpage', LinkTo('retail/loaddata', array('cat' => $cat, 'area' => $area,'sn'=>$m_sn , 'business' => $business, 'order' => $order, 't' => NOW_TIME, 'keyword' => $keyword, 'p' => '0000')));
        $this->display();
    }

    public function loaddata()
    {
        $Retail = D('Retail');
        import('ORG.Util.Page');
        // 导入分页类
        $map = array('audit' => 1, 'closed' => 0, 'end_date' => array('EGT', TODAY));
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
        }
        $cat = (int) $this->_param('cat');
        //echo"cat:";
        // echo $cat;
        if ($cat) {
            $catids = D('Retailcate')->getChildren($cat);
            if (!empty($catids)) {
                $map['cate_id'] = array('IN', $catids);
            } else {
                $map['cate_id'] = $cat;
            }
        }
        $area = (int) $this->_param('area');
        if ($area) {
            $map['area_id'] = $area;
        }
        $sn =  $this->_param('sn', 'htmlspecialchars');
        // echo"load_sn:";
        //echo $sn;
        if ($sn) {
            $map['m_sn'] = $sn;
        }

        $order = $this->_param('order', 'htmlspecialchars');
        $lat = addslashes(cookie('lat'));
        $lng = addslashes(cookie('lng'));
        if (empty($lat) || empty($lng)) {
            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
        }
        $orderby = '';
        switch ($order) {
            case 3:
                //$orderby = " (ABS(lng - '{$lng}') +  ABS(lat - '{$lat}') ) asc ";
                $orderby = array('create_time' => 'desc');
                break;
            case 2:
                $orderby = array('sold_num' => 'desc');

                break;
            default:
                // $orderby = array('orderby' => 'asc', 'tuan_id' => 'desc');
                $orderby = " (ABS(lng - '{$lng}') +  ABS(lat - '{$lat}') ) asc, create_time desc";
                break;
        }
        $count = $Retail->where($map)->count();
        // 查询满足要求的总记录数
        $Page = new Page($count, 10);
        // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();
        // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Retail->where($map)->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        // echo '<pre>';print_r($list);echo '<pre>';
        foreach ($list as $k => $val) {
            if ($val['shop_id']) {
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $val['end_time'] = strtotime($val['end_date']) - NOW_TIME + 86400;
            $list[$k] = $val;
        }

        if ($shop_ids) {
            foreach ($shop_ids as $k) {
                $shops[$k] = D('Shop')->getShopById($k);
            }

            //$shops = D('Shop')->itemsByIds($shop_ids);
            $ids = array();
            foreach ($shops as $k => $val) {
                $shops[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
                $d = getDistanceNone($lat, $lng, $val['lat'], $val['lng']);
                $ids[$d][] = $k;
            }
            ksort($ids);
            $showshops = array();
            foreach ($ids as $arr1) {
                foreach ($arr1 as $val) {
                    $showshops[$val] = $shops[$val];
                }
            }
            // print_r($shops);
            $this->assign('shops', $shops);
        }

        $this->assign('list', $list);
        // 赋值数据集www.hatudou.com  二开开发qq  120585022
        $this->assign('page', $show);
        // 赋值分页输出
        $this->display();
    }
    public function detail()
    {
        $retail_id = (int) $this->_get('retail_id');
        $this->assign('retail_id', $retail_id);
        if (empty($retail_id)) {
            $this->error('该抢购信息不存在！');
            die;
        }
        if (!($detail = D('Retail')->find($retail_id))) {
            $this->error('该抢购信息不存在！');
            die;
        }
        if ($detail['audit'] != 1) {
            $this->error('该抢购信息还在审核中哦');
            die;
        }
        if ($detail['closed']) {
            $this->error('该抢购信息不存在！');
            die;
        }

        $detail = D('Retail')->_format($detail);
        $this->assign('detail', $detail);

        $retaildetails = D('Retaildetails')->find($retail_id);
        $this->assign('retaildetails', $retaildetails);

        $this->display();
    }
    //团购图片详情
    public function pic()
    {
        $retail_id = (int) $this->_get('retail_id');
        if (!($detail = D('Retail')->find($retail_id))) {
            $this->error('没有该团购');
            die;
        }
        if ($detail['closed']) {
            $this->error('该团购已经被删除');
            die;
        }
        $thumb = unserialize($detail['thumb']);
        $this->assign('thumb', $thumb);
        $this->assign('detail', $detail);
        $this->display();
    }
    //团购图文详情
    public function tuwen()
    {
        $retail_id = (int) $this->_get('retail_id');
        if (!($detail = D('Retail')->find($retail_id))) {
            $this->error('没有该团购');
            die;
        }
        if ($detail['closed']) {
            $this->error('该团购已经被删除');
            die;
        }
        $detail = D('Retail')->_format($detail);
        $tuandetails = D('Retaildetails')->find($retail_id);
        $this->assign('tuandetails', $tuandetails);
        $this->assign('detail', $detail);
        $this->display();
    }
    public function order(){
        if (!$this->uid) {
            $this->fengmiMsg('登录状态失效!', U('passport/login'));
        }
        $retail_id = (int) $this->_get('retail_id');
        echo "retail_id";
        echo $retail_id;
        if (!($detail = D('Retail')->find($retail_id))) {
            $this->fengmiMsg('该商品不存在');
        }
        if ($detail['closed'] == 1 || $detail['end_date'] < TODAY) {
            $this->fengmiMsg('该商品已经结束');
        }
        $num = (int) $this->_post('num');

        if ($num <= 0 || $num > 99) {
            $this->fengmiMsg('请输入正确的购买数量');
        }

        if ($num > $detail['num']) {
            $this->fengmiMsg('亲，您最多购买' . $detail['num'] . '份哦！');
        }


        if ($num > $detail['xiangou'] && $detail['xiangou'] > 0) {
            $this->fengmiMsg('亲，每人只能购买' . $detail['xiangou'] . '份哦！');
        }
        if ($detail['xiadan'] == 1) {
            $where['user_id'] = $this->uid;
            $where['tuan_id'] = $tuan_id;
            $xdinfo = D('Retailorder')->where($where)->order('order_id desc')->Field('order_id')->find();
            if ($xdinfo) {
                $this->fengmiMsg('该商品只允许购买一次!');
                die;
            }
        }
        if ($detail['xiangou'] > 0) {
            $y = date('Y');
            $m = date('m');
            $d = date('d');
            $day_start = mktime(0, 0, 0, $m, $d, $y);
            $day_end = mktime(23, 59, 59, $m, $d, $y);
            $where['user_id'] = $this->uid;
            $where['retail_id'] = $retail_id;
            $xdinfo = D('Retailorder')->where($where)->order('order_id desc')->Field('create_time,num')->select();
            $order_num = 0;
            foreach ($xdinfo as $k => $val) {
                if ($val['create_time'] >= $day_start && $val['create_time'] <= $day_end) {
                    $order_num += $val['num'] + $num;
                    if ($order_num > $detail['xiangou']) {
                        $this->fengmiMsg('该商品每天每人限购' . $detail['xiangou'] . '份');
                        die;
                    }
                }
            }
        }

        /*$business_id=$this->_post('business_id');

        if (empty($business_id)) {
                $this->fengmiMsg('请选择自提地址!');
            }

            session('city_id',(int) $this->_post('city_id'));
            session('area_id', (int) $this->_post('area_id'));
            session('business_id', (int) $this->_post('business_id'));*/


        $data = array(
            'retail_id' => $retail_id,
            'num' => $num,
            'mobile' => $this->_post('mobile'),
            //'city_id' => (int) $this->_post('city_id'),
            //'area_id' => (int) $this->_post('area_id'),
            //'business_id' => (int) $this->_post('business_id'),
            'user_id' => $this->uid,
            'shop_id' => $detail['shop_id'],
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip(),
            'total_price' => $detail['retail_price'] * $num,
            'mobile_fan' => $detail['mobile_fan'] * $num,
            //'need_pay' => $detail['tuan_price'] * $num - $detail['mobile_fan'] * $num,
            'need_pay' => $detail['retail_price'] * $num,
            'settlement_price'=>$detail['settlement_price']* $num,
            'status' => 0,
            'is_mobile' => 1
        );
        if ($order_id = D('Retailorder')->add($data)) {
            $order = D('Retailorder')->find($order_id);
            $code ='weixin';
            $mobile = D('Users')->where(array('user_id' => $this->uid))->getField('mobile');
            if (!$mobile) {
                $this->fengmiMsg('请先绑定手机号码再提交！');
            }
            $payment = D('Payment')->checkPayment($code);
            if (empty($payment)) {
                $this->fengmiMsg('该支付方式不存在');
            }
            if (empty($order['use_integral'])) {
                $retail = D('Retail')->find($order['retail_id']);
                echo "retail";
                echo "<pre>"."print_r($retail)"."<pre>";
                if (empty($retail) || $retail['closed'] == 1 || $retail['end_date'] < TODAY) {
                    $this->fengmiMsg('该抢购不存在');
                    die;
                }
                $canuse = $retail['use_integral'] * $order['num'];
                if (!empty($this->member['integral'])) {
                    $member = D('Users')->find($this->uid);
                    $used = 0;
                    if ($member['integral'] < $canuse) {
                        $used = $member['integral'];
                        $member['integral'] = 0;
                    } else {
                        $used = $canuse;
                        $member['integral'] -= $canuse;
                    }
                    D('Users')->save(array('user_id' => $this->uid, 'integral' => $member['integral']));
                    D('Userintegrallogs')->add(array(
                        'user_id' => $this->uid,
                        'integral' => -$used,
                        'intro' => '订单' . $order_id . '积分抵用',
                        'create_time' => NOW_TIME,
                        'create_ip' => get_client_ip()
                    ));
                    $order['use_integral'] = $used;
                    //$order['need_pay'] = $order['total_price'] - $order['mobile_fan'] - ($used*$this->_CONFIG['integral']['buy']);
                    $order['need_pay'] = $order['total_price']  - ($used*$this->_CONFIG['integral']['buy']);
                    D('Retailorder')->save($order);
                }

                $logs = D('Paymentlogs')->getLogsByOrderId('retail', $order_id);
                if (empty($logs)) {
                    $logs = array(
                        'type' => 'retail',
                        'user_id' => $this->uid,
                        'order_id' => $order_id,
                        'code' => $code,
                        'need_pay' => $order['need_pay'],
                        'create_time' => NOW_TIME,
                        'create_ip' => get_client_ip(),
                        'is_paid' => 0
                    );
                    $logs['log_id'] = D('Paymentlogs')->add($logs);
                } else {
                    $logs['need_pay'] = $order['need_pay'];
                    $logs['code'] = $code;
                    D('Paymentlogs')->save($logs);
                }
                $codestr = join(',', $codes);
                $this->fengmiMsg('订单设置完毕，即将进入付款。', U('payment/payment', array('log_id' => $logs['log_id'])));
            }
        }else{
            $this->fengmiMsg('创建订单失败！');
        }

    }
    public function buy()
    {
        if (empty($this->uid)) {
            header('Location: ' . U('passport/login'));
            die;
        }
        $retail_id = (int) $this->_get('retail_id');
        if (!($detail = D('Retail')->find($retail_id))) {
            $this->error('该商品不存在');
            die;
        }
        if ($detail['bg_date'] > TODAY) {
            $this->error('该零售还未开始');
        }
        if ($detail['closed'] == 1 || $detail['end_date'] < TODAY) {
            $this->error('该商品已经结束');
            die;
        }
        $detail = D('Retail')->_format($detail);


        $this->assign('detail', $detail);
        $this->mobile_title = '支付订单';
        $this->display();
    }
    public function pay()
    {
        if (empty($this->uid)) {
            header('Location:' . U('passport/login'));
            die;
        }
        $this->check_mobile();
        $order_id = (int) $this->_get('order_id');
        $order = D('Retailorder')->find($order_id);
        if (empty($order) || $order['status'] != 0 || $order['user_id'] != $this->uid) {
            $this->error('该订单不存在');
            die;
        }
        $retail = D('Retail')->find($order['retail_id']);
        if (empty($retail) || $retail['closed'] == 1 || $retail['end_date'] < TODAY) {
            $this->error('该抢购不存在');
            die;
        }
        $this->assign('use_integral', $retail['use_integral'] * $order['num']);
        $this->assign('payment', D('Payment')->getPayments(true));
        $this->assign('retail', $retail);
        $this->assign('order', $order);
        $this->mobile_title = '订单支付';
        $this->display();
    }
    public function tuan_mobile()
    {
        $this->mobile();
    }
    public function tuan_mobile2()
    {
        $this->mobile2();
    }
    public function retail_sendsms()
    {
        $this->sendsms();
    }
    public function pay2()
    {
        if (empty($this->uid)) {
            $this->fengmiMsg('登录状态失效!', U('passport/login'));
        }
        $order_id = (int) $this->_get('order_id');
        $order = D('Retailorder')->find($order_id);
        if (empty($order) || (int) $order['status'] != 0 || $order['user_id'] != $this->uid) {
            $this->fengmiMsg('该订单不存在');
        }
        // if (!($code = $this->_post('code'))) {
        //    $this->fengmiMsg('请选择支付方式！');
        // }
        $code ='weixin';
        $mobile = D('Users')->where(array('user_id' => $this->uid))->getField('mobile');
        if (!$mobile) {
            $this->fengmiMsg('请先绑定手机号码再提交！');
        }
        $payment = D('Payment')->checkPayment($code);
        if (empty($payment)) {
            $this->fengmiMsg('该支付方式不存在');
        }
        if (empty($order['use_integral'])) {
            $retail = D('Retail')->find($order['retail_id']);
            if (empty($retail) || $retail['closed'] == 1 || $retail['end_date'] < TODAY) {
                $this->fengmiMsg('该抢购不存在');
                die;
            }
            $canuse = $retail['use_integral'] * $order['num'];
            if (!empty($this->member['integral'])) {
                $member = D('Users')->find($this->uid);
                $used = 0;
                if ($member['integral'] < $canuse) {
                    $used = $member['integral'];
                    $member['integral'] = 0;
                } else {
                    $used = $canuse;
                    $member['integral'] -= $canuse;
                }
                D('Users')->save(array('user_id' => $this->uid, 'integral' => $member['integral']));
                D('Userintegrallogs')->add(array(
                    'user_id' => $this->uid,
                    'integral' => -$used,
                    'intro' => '订单' . $order_id . '积分抵用',
                    'create_time' => NOW_TIME,
                    'create_ip' => get_client_ip()
                ));
                $order['use_integral'] = $used;
                //$order['need_pay'] = $order['total_price'] - $order['mobile_fan'] - ($used*$this->_CONFIG['integral']['buy']);
                $order['need_pay'] = $order['total_price']  - ($used*$this->_CONFIG['integral']['buy']);
                D('Retailorder')->save($order);
            }
        }
        $logs = D('Paymentlogs')->getLogsByOrderId('retail', $order_id);
        if (empty($logs)) {
            $logs = array(
                'type' => 'retail',
                'user_id' => $this->uid,
                'order_id' => $order_id,
                'code' => $code,
                'need_pay' => $order['need_pay'],
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'is_paid' => 0
            );
            $logs['log_id'] = D('Paymentlogs')->add($logs);
        } else {
            $logs['need_pay'] = $order['need_pay'];
            $logs['code'] = $code;
            D('Paymentlogs')->save($logs);
        }
        $codestr = join(',', $codes);

        //D('Weixintmpl')->weixin_notice_tuan_user($order_id,$this->uid,1);
        $this->success('订单设置完毕，即将进入付款。', U('payment/payment', array('log_id' => $logs['log_id'])));
        // $this->fengmiMsg('订单设置完毕，即将进入付款。', U('payment/payment', array('log_id' => $logs['log_id'])));
        $this->display();
    }
    public function delete()
    {
        $id = (int) $_GET['order_id'];
        if (is_numeric($id) && $id > 0) {
            $map = array('order_id' => $id);
            $findone = D('Retailorder')->where($map)->find();
            if (!empty($findone)) {
                $res = D('Retailorder')->delete($id);
                $this->success('删除成功!');
            }
        }
    }


    public function loadindex(){
        $Retail = D('Retail');
        import('ORG.Util.Page');
        $map = array('audit' => 1, 'closed' => 0, 'city_id' => $this->city_id, 'end_date' => array('EGT', TODAY));
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
        }
        $cat = (int) $this->_param('cat');
        if ($cat) {
            $catids = D('Retailcate')->getChildren($cat);
            if (!empty($catids)) {
                $map['cate_id'] = array('IN', $catids);
            } else {
                $map['cate_id'] = $cat;
            }
        }
        $area = (int) $this->_param('area');
        if ($area) {
            $map['area_id'] = $area;
        }
        $order = $this->_param('order', 'htmlspecialchars');
        $lat = addslashes(cookie('lat'));
        $lng = addslashes(cookie('lng'));
        if (empty($lat) || empty($lng)) {
            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
        }
        $orderby = array('orderby' => 'asc', 'tuan_id' => 'desc');
        $count = $Tuan->where($map)->count();
        $Page = new Page($count, 15);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Retail->where($map)->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($list as $k => $val) {
            if ($val['shop_id']) {
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $val['end_time'] = strtotime($val['end_date']) - NOW_TIME + 86400;
            $list[$k] = $val;
        }
        if ($shop_ids) {
            $shops = D('Shop')->itemsByIds($shop_ids);
            $ids = array();
            foreach ($shops as $k => $val) {
                $shops[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
                $d = getDistanceNone($lat, $lng, $val['lat'], $val['lng']);
                $ids[$d][] = $k;
            }
            ksort($ids);
            $showshops = array();
            foreach ($ids as $arr1) {
                foreach ($arr1 as $val) {
                    $showshops[$val] = $shops[$val];
                }
            }
            $this->assign('shops', $showshops);
        }
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
}