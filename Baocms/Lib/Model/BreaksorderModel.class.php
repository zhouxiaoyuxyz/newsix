<?php
class BreaksorderModel extends CommonModel
{
    protected $pk = 'order_id';
    protected $tableName = 'breaks_order';
    //更新优惠买单销售接口
    public function settlement($order_id)
    {
        $order_id = (int) $order_id;
        $logs = D('Paymentlogs')->where(array('type' => breaks, 'order_id' => $order_id))->find();
        //支付日志
        $order = D('Breaksorder')->find($order_id);
        //查询订单信息
        $shopyouhui = D('Shopyouhui')->where(array('shop_id'=>$order['shop_id']))->find();
        //商家优惠信息
        $shop = D('Shop')->find($order['shop_id']);

        //物业分成信息
        $community= D('Community')->where(array('business_id'=>$shop['business_id']))->find();
        //项目经理分成比例
        $community_manager=D('Communitymanager')->where(array('community_id'=>$community['community_id']))->find();

        //商家信息
        $deduction = $this->get_deduction($shop['shop_id'], $order['amount'], $order['exception']);
        //商家获得
        $money = D('Shopyouhui')->get_amount($shop['shop_id'], $order['amount'], $order['exception']);

        //网站扣除金额，暂时写到购买的会员余额
        $intro = '优惠买单，支付记录ID：' . $logs['log_id'];
        $ip = get_client_ip();

        static $CONFIG;
        if (empty($CONFIG)) {
            $CONFIG = D('Setting')->fetchAll();
        }
        //IP
        /**if ($shopyouhui['type_id'] == 0) {
        //打折
        if (!empty($shopyouhui['deduction'])) {
        //$money = round(($order['need_pay'] - $deduction) * 100, 2);
        $money = round(($order['amount'] - $deduction) * 100, 2);
        //商户实际到账
        } else {
        $money = round($order['need_pay'] * 100, 2);
        }
        } else {
        //满减
        if (!empty($shopyouhui['vacuum'])) {
        $money = round(($order['need_pay'] - $deduction) * 100, 2);
        //商户实际到账
        } else {
        $money = round($order['need_pay'] * 100, 2);
        }
        }**/
        //会员买单实际支付日志
        //D('Usermoneylogs')->add(array('user_id' => $order['user_id'], 'money' => $logs['need_pay'], 'create_time' => NOW_TIME, 'create_ip' => $ip, 'intro' => $intro));

        //写入商户资金日志
        D('Shopmoney')->add(array('shop_id' => $order['shop_id'], 'city_id' => $shop['city_id'], 'area_id' => $shop['area_id'], 'branch_id' => $data['branch_id'], 'money' => $money*100, 'type' => 'breaks', 'order_id' => $logs['order_id'], 'create_time' => NOW_TIME, 'create_ip' => $ip, 'intro' => $intro));
        $this->Breaks_profit(2, $order['user_id'], $order['order_id'], $order['amount']);

        //写入分站资金
        $admin=D('Admin')->where(array('city_id' => $order['city_id'], 'role_id' => 2))->find();

        $city=D('City')->where(array('city_id' => $order['city_id']))->find();

        $rate['breaks_profit_rate']=($CONFIG['profit']['breaks_profit_rate1']+$CONFIG['profit']['breaks_profit_rate2']+$CONFIG['profit']['breaks_profit_rate3'])*100;
        $rate['platform_rate']=$city['platform_rate'];
        $rate['total'] = $rate['platform_rate']+$rate['breaks_profit_rate'];


        //分站分润
        $fenzhanmoney=$order['amount']*100-$order['fx_money']*100-$rate['total']*$order['amount']-$money*100;

        D('Admin')->Money($admin['admin_id'], $order['city_id'], $fenzhanmoney, '买单分站分润,买单订单：'.$logs['log_id'],'breaks',$order['user_id']);
        //平台分润
        $pingtaimoney=$order['amount']*$city['platform_rate'];
        D('Admin')->Money(1, $order['city_id'], $pingtaimoney, '买单平台分润,买单订单：'.$logs['log_id'],'breaks',$order['user_id']);

        D('Users')->Money($shop['user_id'], $money*100, '用户买单结算金额，订单号:' . $order['order_id']);
        //用户买单返现


        //用户余额支付
        /**
        if (!empty($order['use_money'])){
        D('Users')->addMoney($order['user_id'], -$order['use_money']*100, '余额支付：订单ID' . $order['order_id']);
        }
         **/

        // zhangdianlei 2018-12-09 用户余额支付，如果是物业费支付的话，扣除物业费。根据shop类型判断是否是物业费账户

        if (!empty($order['use_money'])){

            if($shop['cate_id'] == 62){
                D('Users')->AddWyFanxian($order['user_id'], -$order['use_money']*100, '支付物业费：订单ID' . $order['order_id']);
            }else{
                D('Users')->addMoney($order['user_id'], -$order['use_money']*100, '余额支付：订单ID' . $order['order_id']);
            }

        }


        // 返现到物业费 -- by: zhangdianlei  改买单折扣全部返现到物业费
        $wy_fanxian_money = $order['fx_money'];
        //注释 2019-06-13
        /*if (empty($CONFIG)) {
            $CONFIG = D('Setting')->fetchAll();
        }
        $wy_fanxian_money = $CONFIG["site"]["cut"] * $return_cash;
        $return_cash = $return_cash - $wy_fanxian_money;*/

        D('Users')->AddWyFanxian($order['user_id'], $wy_fanxian_money * 100, '买单返物业费：订单ID' . $order_id);

        // 买单助力互助金 -- by: zhangdianlei 2019-03-17
        // 超过10元，出0.1元作为互助金
        if($money*100 > 1000){
            D('Shopmoney')->add(array(
                'shop_id' => 72,
                'money' => 10,
                'city_id' => 1,
                'area_id' => 1,
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'type' => 'help',
                'order_id' => $order_id,
                'intro' => '买单助力互助金',
            ));
        }

        //用户返现  --买单折扣全部返现物业费，不返现余额
        //D('Users')->addMoney($order['user_id'], $return_cash*100, '买单返现：订单ID' . $order['order_id']);

        //抵扣物业费



        //第三方分成-物业分成
        //项目经理分成比例
        $ratio=$community_manager['third_profit']/10000;
        //项目经理分成
        $manager_profit=$shopyouhui['third_profit']/100*$ratio;
        D('Users')->addMoney($community_manager['user_id'],$manager_profit*100, '小区项目经理分成：订单ID' . $order['order_id']);
        //小区物业分成
        $community_profit=$shopyouhui['third_profit']/100-$manager_profit;
        D('Admin')->Thirdgold($community_manager['wuye_id'], $community_manager['community_id'], $community_profit*100, '小区物业分成：订单ID' . $order['order_id'],'breaks', $order['user_id']);

        //print_r($config['site']);
        if(!empty($CONFIG['site']['cut'])){
            D('Communityorder')->orderpaid($order['user_id'], 5, $order['fx_money']*$CONFIG['site']['cut']*100);
        }


        //写入商户资金
        return TRUE;
    }
    public function get_deduction($shop_id, $amount, $exception)
    {
        $shopyouhui = D('Shopyouhui')->where(array('shop_id' => $shop_id, 'is_open' => 1, 'audit' => 1))->find();
        $need = $amount - $exception;
        //应该计算的金额=消费总额-参与优惠
        if ($shopyouhui['type_id'] == 0) {
            $result_deduction = round($need * $shopyouhui['deduction'] / 100, 2);
            //减去金额=总金额-不参与优惠金额*点数
        } else {
            $t = (int) $need / $shopyouhui['vacuum'];
            //$T是应付款除以网站抽成金额，比如100元，网站抽3元，这里的t就是百分之3
            $result_deduction = round($t * $need / 100, 2);
            //实际付款金额*百分比
        }
        return $result_deduction;
        //返回网站扣除金额
    }



    //买单三级分销
    private function Breaks_profit($order_type = 2, $uid = 0, $order_id = 0, $deduction)
    {
        static $CONFIG;
        if (empty($CONFIG)) {
            $CONFIG = D('Setting')->fetchAll();
        }
        $user_fuid = D('Users')->find($uid);
        //查询会员的fuid1
        $breaksorder = D('Breaksorder')->find($order_id);
        //查询订单信息
        if ($user_fuid) {
            $userModel = D('Users');
            //找到会员表
            if ($breaksorder['is_separate'] == 0) {
                if ($order_type === 2) {
                    $modelOrder = D('Breaksorder');
                    $orderTypeName = '买单返现';
                }
                if ($user_fuid['fuid1']) {
                    //如果一级会员不等于空
                    $money1 = round($CONFIG['profit']['breaks_profit_rate1'] * $deduction, 2);
                    //这里应该就是实际金额
                    if ($money1 > 0) {
                        $info1 = $orderTypeName . '订单ID:' . $order_id . ', 分成: ' . $money1;
                        $fuser1 = $userModel->find($user_fuid['fuid1']);
                        //查询会员是否存在
                        if ($fuser1) {
                            $userModel->addMoney($user_fuid['fuid1'], round($money1 * 100, 2), $info1);
                            //写入用户金额*100
                            $userModel->addProfit($user_fuid['fuid1'], $order_type, $order_id, round($money1 * 100, 2), 1);
                            //写入分销日志
                        }
                    }
                }
                if ($user_fuid['fuid2']) {
                    $money2 = round($CONFIG['profit']['breaks_profit_rate2'] * $deduction, 2);
                    //这里应该就是实际金额
                    if ($money2 > 0) {
                        $info2 = $orderTypeName . '订单ID:' . $order_id . ', 分成: ' . $money2;
                        $fuser2 = $userModel->find($user_fuid['fuid2']);
                        if ($fuser2) {
                            $userModel->addMoney($user_fuid['fuid2'], round($money2 * 100, 2), $info2);
                            //写入用户金额
                            $userModel->addProfit($user_fuid['fuid2'], $order_type, $order_id, round($money2 * 100, 2), 1);
                            //写入分销日志
                        }
                    }
                }
                if ($user_fuid['fuid3']) {
                    $money3 = round($CONFIG['profit']['breaks_profit_rate3'] * $deduction, 2);
                    //这里应该就是实际金额
                    if ($money3 > 0) {
                        $info3 = $orderTypeName . '订单ID:' . $order_id . ', 分成: ' . $money3;
                        $fuser3 = $userModel->find($user_fuid['fuid3']);
                        if ($fuser3) {
                            $userModel->addMoney($user_fuid['fuid3'], round($money3 * 100, 2), $info3);
                            $userModel->addProfit($user_fuid['fuid3'], $order_type, $order_id, round($money3 * 100, 2), 1);
                        }
                    }
                }
                $modelOrder->save(array('order_id' => $order_id, 'deduction' => round($deduction * 100, 2), 'is_separate' => 0, 'is_profit' => 1));
                //更新状态
            }
        }
    }
}