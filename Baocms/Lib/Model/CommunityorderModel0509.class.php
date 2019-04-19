<?php



class CommunityorderModel extends CommonModel {

    protected $pk = 'order_id';
    protected $tableName = 'community_order';

    public function getType() {
        return array(
            //'1' => '水费',
           // '2' => '电费',
           // '3' => '燃气费',
            //'4' => '停车费',
            '5' => '物业费',
        );
    }

    public function orderpay($order_id, $user_id, $type, $total) {
        $order_id = (int) $order_id;
        $detail = $this->find($order_id);
        $user_id = (int) $user_id;
        $products = D('Communityorderproducts')->where(array('order_id' => $order_id))->select();
        $needs = array();
        foreach ($products as $k => $val) {
            foreach ($type as $kk => $v) {
                if ($kk == $val['type']) {
                    $needs[$k] = $val;
                }
            }
        }
           
           
        foreach ($needs as $k => $value) {
       	 $check =	D('Communityorderproducts')->find( $value['id']);
         	if($check[is_pay]==2)  return true;
         	}   
        $member = D('Users')->find($user_id);
        D('Users')->addMoney($user_id, -$total, '生活缴费，扣费');		
        foreach ($needs as $k => $val) {
            D('Communityorderproducts')->save(array('id' => $val['id'], 'paid' => $val['money'], 'is_pay' => 2));
            D('Communityorderlogs')->add(array(
                'user_id' => $user_id,
                'community_id' => $detail['community_id'],
                'money' => $total,
                'type' => $val['type'],
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip()
            ));
        }
        return true;
    }
	
	
	public function orderpaid($user_id, $type, $money) {
		
		$community_user=D('Communityusers')->where(array('user_id' => $user_id))->find();
		//print_r($community_user);
		$join = 'JOIN bao_community_order o on o.order_id = p.order_id' ;
		$map = array('o.owner_id' => $community_user['owner_id'], 'p.type' => $type,  'p.is_pay' =>array('IN','0,1'));
		$products = D('Communityorderproducts')->alias('p')->join($join)->where($map)->find();
		//print_r($products);
		if( !empty($products)){
			if($money>=($products['money']-$products['paid'])){
				$money=$products['money']-$products['paid'];
				D('Communityorderproducts')->save(array('id' => $products['id'], 'paid' => $products['paid']+$money, 'is_pay' => 2));
			}else{
				D('Communityorderproducts')->save(array('id' => $products['id'], 'paid' => $products['paid']+$money, 'is_pay' => 1));
			}
			D('Users')->addMoney($user_id, -$money, '返现抵扣物业费');
			
			$community = D('Community')->find($products['community_id']);
			//print_r($community);
			D('Admin')->Money($community['uid'], $money, '物业费结算');
			
            D('Communityorderlogs')->add(array(
                'user_id' => $user_id,
                'community_id' => $products['community_id'],
                'money' => $money,
                'type' => $type,
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip()
            ));
			return true;
		}
		
        
    }

}
