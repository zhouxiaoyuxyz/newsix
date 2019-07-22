<?php
class ShuiorderModel extends CommonModel
{
    protected $pk = 'order_id';
    protected $tableName = 'shui_order';
    //更新优惠买水销售接口
    public function settlement($order_id)
    {
        $order_id = (int) $order_id;


        $logs = D('Paymentlogs')->where(array('type' => shui, 'order_id' => $order_id))->find();
        //支付日志
        $order = D('Shuiorder')->find($order_id);
        //查询订单信息
        $machine_id = $order['machine_id'];
        $machine = D('Shuimachine')->find($machine_id);
        $city=D('City')->where(array('city_id' => $machine['city_id']))->find();
        $admin=D('Admin')->where(array('city_id' => $machine['city_id'],'role_id' => 2))->find();
        //物业分成信息
        $community=D('Community')->where(array('business_id'=>$machine['business_id']))->find();
        //项目经理分成比例
        $community_manager=D('Communitymanager')->where(array('community_id'=>$community['community_id']))->find();

        static $CONFIG;
        if (empty($CONFIG)) {
            $CONFIG = D('Setting')->fetchAll();
        }

        //商家获得
        $money = $CONFIG['site']['shuiprice']-$CONFIG['site']['shuifanxian']-$CONFIG['site']['shuituijian'];

        //网站扣除金额，暂时写到购买的会员余额
        $intro = '用户买水，支付记录ID：' . $logs['log_id'];
        $ip = get_client_ip();


        //写入商户资金日志
        // D('Shopmoney')->add(array('shop_id' => $shop_id, 'city_id' => $shop['city_id'], 'area_id' => $shop['area_id'], 'money' => $money*100, 'type' => 'shui', 'order_id' => $logs['order_id'], 'create_time' => NOW_TIME, 'create_ip' => $ip, 'intro' => $intro));
        //$this->Shui_profit(2, $order['user_id'], $order['order_id'], $order['amount']);

        D('Users')->Money($shop['user_id'], $money*100, '用户买水结算金额，订单号:' . $order['order_id']);
        //用户买水返现

        //用户余额支付
        if (!empty($order['use_money'])){
            D('Users')->addMoney($order['user_id'], -$order['use_money']*100, '余额支付：订单ID' . $order['order_id']);
        }

        //用户返现
        D('Users')->addMoney($order['user_id'], $order['fx_money']*100, '买水返现：订单ID' . $order['order_id']);

        //推广返现
        if(!empty($machine['tg_fanxian'])){
            $this->Shui_tuiguang(2, $order['user_id'], $order['order_id'], $machine['tg_fanxian']);
        }

        //物业分润 改为物业分润和合伙人分润
        //D('Admin')->Money($machine['admin_id'], $machine['city_id'], $machine['wy_fanxian']*100, '购水物业分润,购水订单：'.$logs['log_id'],'shui',$order['user_id']);
        D('Admin')->Money($machine['admin_id'], $machine['city_id'], $machine['wy_fanxian']*100, '购水物业分润,购水订单：'.$logs['log_id'],'shui',$order['user_id']);
        D('Admin')->Money($machine['hhr_id'], $machine['city_id'], $machine['hhr_fanxian']*100, '购水合伙人分润,购水订单：'.$logs['log_id'],'shui',$order['user_id']);

        //平台分润
        D('Admin')->Money(1, $machine['city_id'], $order['amount']*$city['platform_rate'], '购水平台分润,购水订单：'.$logs['log_id'],'shui',$order['user_id']);

        //分站分润
        $fenzhanmoney=$order['amount']*100-$order['fx_money']*100-$machine['wy_fanxian']*100-$order['amount']*$city['platform_rate'];

        D('Admin')->Money($admin['admin_id'], $machine['city_id'], $fenzhanmoney, '购水分站分润,购水订单：'.$logs['log_id'],'shui',$order['user_id']);
        //抵扣物业费
        //print_r($config['site']);
        //if(!empty($CONFIG['site']['cut'])){
        // D('Communityorder')->orderpaid($order['user_id'], 5, $order['fx_money']*$CONFIG['site']['cut']*100);
        //}


        //第三方分成-物业分成
        //项目经理分成比例
        $ratio=$community_manager['third_profit']/10000;
        //项目经理分成
        $manager_profit=$machine['third_profit']*$ratio;
        D('Users')->addMoney($community_manager['user_id'],$manager_profit*100, '小区项目经理分成：水订单ID' . $order['order_id']);
        //小区物业分成
        $community_profit=$machine['third_profit']-$manager_profit;
        D('Admin')->Thirdgold($community_manager['wuye_id'], $community_manager['community_id'], $community_profit*100, '小区物业分成：水订单ID' . $order['order_id'],'shui', $order['user_id']);


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

    //买水推广分成
    private function Shui_tuiguang($order_type = 2, $uid = 0, $order_id = 0, $tg_fanxian)
    {
        static $CONFIG;
        if (empty($CONFIG)) {
            $CONFIG = D('Setting')->fetchAll();
        }
        $user_fuid = D('Users')->find($uid);
        //查询会员的fuid1
        $shuiorder = D('Shuiorder')->find($order_id);
        //查询订单信息
        if ($user_fuid) {
            $userModel = D('Users');
            //找到会员表
            if ($shuiorder['is_separate'] == 0) {
                if ($order_type === 2) {
                    $modelOrder = D('Shuiorder');
                    $orderTypeName = '买水返现';
                }
                if ($user_fuid['fuid1']) {
                    //如果一级会员不等于空
                    $money1 = round($tg_fanxian, 2);
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

                $modelOrder->save(array('order_id' => $order_id, 'deduction' => round($tg_fanxian * 100, 2), 'is_separate' => 1, 'is_profit' => 1));
                //更新状态
            }
        }
    }

    //买水三级分销
    private function Shui_profit($order_type = 2, $uid = 0, $order_id = 0, $deduction)
    {
        static $CONFIG;
        if (empty($CONFIG)) {
            $CONFIG = D('Setting')->fetchAll();
        }
        $user_fuid = D('Users')->find($uid);
        //查询会员的fuid1
        $shuiorder = D('Shuiorder')->find($order_id);
        //查询订单信息
        if ($user_fuid) {
            $userModel = D('Users');
            //找到会员表
            if ($shuiorder['is_separate'] == 0) {
                if ($order_type === 2) {
                    $modelOrder = D('Shuiorder');
                    $orderTypeName = '买水返现';
                }
                if ($user_fuid['fuid1']) {
                    //如果一级会员不等于空
                    $money1 = round($CONFIG['site']['shuituijian'], 2);
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
                /**if ($user_fuid['fuid1']) {
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
                }**/
                $modelOrder->save(array('order_id' => $order_id, 'deduction' => round($deduction * 100, 2), 'is_separate' => 0, 'is_profit' => 1));
                //更新状态
            }
        }
    }
}