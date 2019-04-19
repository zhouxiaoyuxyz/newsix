<?php

class OrderpaidAction extends CommonAction {

    public function index() { //业主账单列表
	
		
        D('Communityorder')->orderpaid(2110, 5, 500);
    }

    public function create($user_id) {
        $user_id = (int) $user_id;
        $obj = D('Communityorder');
        if (empty($user_id)) {
            $this->error('该用户不存在');
        }
        if (!$detail = D('Communityowner')->where(array('user_id' => $user_id, 'community_id' => $this->community_id))->find()) {
            $this->error('该业主不存在');
        }
        if ($detail['audit'] != 1 || empty($detail['number'])) {
            $this->error('该业主不符合条件');
        }
		$community_id = $this->community_id;
        if ($this->isPost()) {
            $data['order_date'] = htmlspecialchars($_POST['order_date']);
            $data['community_id'] = $this->community_id;
            $data['user_id'] = $user_id;
            $data['create_time'] = NOW_TIME;
            $data['create_ip'] = get_client_ip();
            $datas = $this->_post('data', false);
            if (!$res = $obj->where(array('user_id' => $user_id, 'order_date' => $data['order_date']))->find()) {
                if ($order_id = $obj->add($data)) {
                    foreach ($datas as $k => $val) {
                         D('Communityorderproducts')->add(array(
								 'order_id' => $order_id, 
								 'community_id' => $community_id,
								 'type' => $val['type'],
								 'money' => $val['money'] * 100, 
								 'bg_date' => $val['bg_date'], 
								 'end_date' => $val['end_date']
							 ));
                    }
                    $this->fengmiMsg('添加成功', U('order/index', array('user_id' => $user_id)));
                } else {
                    $this->fengmiMsg('添加失败');
                }
            }
            $this->fengmiMsg('该账单已存在',U('order/index', array('user_id' => $user_id)));
        } else {
            $this->assign('types', D('Communityorder')->getType());
            $this->assign('detail', $detail);
            $this->display();
        }
    }

    public function edit($order_id) {
        $order_id = (int) $order_id;
        $obj = D('Communityorder');
        if (empty($order_id)) {
            $this->error('该账单不存在');
        }
        if (!$detail = D('Communityorder')->find($order_id)) {
            $this->error('该账单不存在');
        }
        if ($detail['community_id'] != $this->community_id) {
            $this->error('不能操作其他小区账单');
        }
        $products = D('Communityorderproducts')->where(array('order_id' => $order_id))->select();
        foreach ($products as $k => $val) {
            $products[$val['type']] = $val;
        }
		unset($products[0]);
        if ($this->isPost()) {
            $datas = $this->_post('data', false);
			print_r($datas);
            foreach ($datas as $k => $val) {
				if ($val['paid'] == 0 ) {
                    D('Communityorderproducts')->save(array('id' => $val['id'], 'type' => $k, 'money' => $val['money'] * 100,'paid' => $val['paid'] * 100,'is_pay' => 0 ,'bg_date' => $val['bg_date'], 'end_date' => $val['end_date']));
                }
                if ($val['paid'] > 0 && $val['paid'] <$val['money']) {
                    D('Communityorderproducts')->save(array('id' => $val['id'], 'type' => $k, 'money' => $val['money'] * 100,'paid' => $val['paid'] * 100,'is_pay' => 1 ,'bg_date' => $val['bg_date'], 'end_date' => $val['end_date']));
                }
				if ($val['paid'] >= $val['money']) {
                    D('Communityorderproducts')->save(array('id' => $val['id'], 'type' => $k, 'money' => $val['money'] * 100,'paid' => $val['paid'] * 100,'is_pay' => 2 ,'bg_date' => $val['bg_date'], 'end_date' => $val['end_date']));
                }
            }
            $this->fengmiMsg('修改成功', U('order/index', array('user_id' => $detail['user_id'])));
        } else {
            $this->assign('products', $products);
            $this->assign('types', D('Communityorder')->getType());
            $this->assign('detail', $detail);
            $this->display();
        }
    }

    public function edpay($owner_id, $pay_id) {
        $owner_id = (int) $owner_id;
        $pay_id = (int) $pay_id;
        $obj = D('Communitypay');
        if (empty($owner_id)) {
            $this->error('该业主不存在');
        }
        if (!$detail = D('Communityowner')->find($owner_id)) {
            $this->error('该业主不存在');
        }
        if ($detail['community_id'] != $this->community_id) {
            $this->error('不能操作其他小区的业主');
        }
        if ($detail['audit'] != 1 || empty($detail['number'])) {
            $this->error('该业主不符合条件');
        }
        if (empty($pay_id)) {
            $this->error('该账单不存在');
        }
        if (!$result = $obj->find($pay_id)) {
            $this->error('该账单不存在');
        }
        if ($result['owner_id'] != $owner_id) {
            $this->error('该账单不存在');
        }
        if ($this->isPost()) {
            $data['electric'] = intval($_POST['electric'] * 100);
            $data['water'] = intval($_POST['water'] * 100);
            $data['gas'] = intval($_POST['gas'] * 100);
            $data['property'] = intval($_POST['property'] * 100);
            $data['parking'] = intval($_POST['parking'] * 100);
            $data['pay_id'] = $pay_id;
            if (false !== $obj->save($data)) {
                $this->baoSuccess('编辑成功', U('owner/pays', array('owner_id' => $owner_id)));
            } else {
                $this->baoError('编辑失败');
            }
        } else {
            $this->assign('detail', $detail);
            $this->assign('result', $result);
            $this->display();
        }
    }
	
	 public function is_pay($id=0) {
		$id = (int) $id;//账单ID
		$obj = D('Communityorderproducts');
        if (empty($id)) {
            $this->error('该账单不存在1');
        }
        if (!$detail = D('Communityorderproducts')->find($id)) {
            $this->error('该账单不存在2');
        }
		$order_id = $detail['order_id'];
		$Communityorder= D('Communityorder')->where(array('order_id' => $order_id))->find();
		$community_id= $Communityorder['community_id'];

        if ($community_id != $this->community_id) {
            $this->error('不能操作其他小区账单');
        }
        $total=1;
		$user_id = $Communityorder['user_id'];
		$obj->save(array('id' => $id, 'is_pay' => 1));
		
		
		//写入会员日志
		D('Users')->addMoney($user_id, -$total, '物业设置为已缴费，未扣费');
		//写入日志
		D('Communityorderlogs')->add(array(
                'user_id' => $Communityorder['user_id'],//ID
                'community_id' => $community_id,//小区ID
                'money' => 0,//金额
                'type' => $detail['type'],
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip()
       ));
		$this->error('您已成功修改成已缴费状态', U('order/edit', array('order_id' => $order_id)));
	
	
		 
  }

}
