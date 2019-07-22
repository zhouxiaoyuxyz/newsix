<?php



class RetailorderModel extends CommonModel{
    protected $pk   = 'order_id';
    protected $tableName =  'retail_order';

    public function settlement($order_id)
    {
        $order_id = (int) $order_id;
        $logs = D('Paymentlogs')->where(array('type' => retail, 'order_id' => $order_id))->find();
        //支付日志
        $order = D('Retailorder')->find($order_id);

        $retail=D('Retail')->find($order['retail_id']);

        $shop = D('Shop')->find($order['shop_id']);

        //物业分成信息
        $community= D('Community')->where(array('business_id'=>$retail['business_id']))->find();
        //项目经理分成比例
        $community_manager=D('Communitymanager')->where(array('community_id'=>$community['community_id']))->find();


        static $CONFIG;
        if (empty($CONFIG)) {
            $CONFIG = D('Setting')->fetchAll();
        }

        $money=0;
       // D('Users')->Money($shop['user_id'], $money*100, '用户买单结算金额，订单号:' . $order['order_id']);
        //用户买单返现



        // 返现到物业费 -- by: zhangdianlei  改买单折扣全部返现到物业费
        //$wy_fanxian_money = $order['fx_money'];


       // D('Users')->AddWyFanxian($order['user_id'], $wy_fanxian_money * 100, '买单返物业费：订单ID' . $order_id);

        // 买单助力互助金 -- by: zhangdianlei 2019-03-17
        // 超过10元，出0.1元作为互助金
       /* if($money*100 > 1000){
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
        }*/


        //第三方分成-物业分成
        //项目经理分成比例
        $ratio=$community_manager['third_profit']/10000;
        //项目经理分成
        $manager_profit=$retail['third_profit']/100*$ratio;
        D('Users')->addMoney($community_manager['user_id'],$manager_profit*100, '小区项目经理分成：零售订单ID' . $order['order_id']);
        //小区物业分成
        $community_profit=$retail['third_profit']/100-$manager_profit;
        D('Admin')->Thirdgold($community_manager['wuye_id'], $community_manager['community_id'], $community_profit*100, '小区物业分成：零售订单ID' . $order['order_id'],'retail', $order['user_id']);


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
        $retailorder = D('Retailorder')->find($order_id);
        //查询订单信息
        if ($user_fuid) {
            $userModel = D('Users');
            //找到会员表
            if ($retailorder['is_separate'] == 0) {
                if ($order_type === 2) {
                    $modelOrder = D('Retailorder');
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