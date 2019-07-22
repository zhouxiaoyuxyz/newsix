<?php
class ActivityorderModel extends CommonModel
{
    protected $pk = 'order_id';
    protected $tableName = 'activity_order';

    public function settlement($order_id)
    {
        $order_id = (int) $order_id;

        $order = D('Activityorder')->find($order_id);

        $activity=D('Activity')->find($order['activity_id']);

        $shop = D('Shop')->find($activity['shop_id']);

        //用户返物业费
        D('Users')->AddWyFanxian($order['user_id'], $activity['wuye_fanxian'] , '活动支付返物业费：订单ID' . $order['order_id']);
        //用户返水费
        D('Users')->addMoney($order['user_id'], $activity['shui_fanxian'], '活动买单返现：订单ID' . $order['order_id']);

        //物业分成信息
        $community= D('Community')->where(array('business_id'=>$activity['business_id']))->find();
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
        $manager_profit=$activity['third_profit']/100*$ratio;
        D('Users')->addMoney($community_manager['user_id'],$manager_profit*100, '小区项目经理分成：活动订单ID' . $order['order_id']);
        //小区物业分成
        $community_profit=$activity['third_profit']/100-$manager_profit;
        D('Admin')->Thirdgold($community_manager['wuye_id'], $community_manager['community_id'], $community_profit*100, '小区物业分成：活动订单ID' . $order['order_id'],'activity', $order['user_id']);


        return TRUE;
    }

}