<?php



class LogsAction extends CommonAction {

    public function index() { //日志列表
        $logs = D('Communityorderlogs');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('community_id' => $this->community_id);
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        if ($number = $this->_param('number', 'htmlspecialchars')) {
            if (!empty($number)) {
                $owner = D('Communityowner')->where(array('number' => $number, 'community_id' => $this->community_id))->find();
                $map['user_id'] = $owner['user_id'];
                $this->assign('number',$number);
            }
        }
        if($type = (int)$this->_param('type')){
            if($type != 999){
                $map['type'] = $type;
                $this->assign('type',$type);
            }else{
                $this->assign('type',999);
            }
        }
        $count = $logs->where($map)->count(); // 查询满足要求的总记录数
        $Page = new Page($count, 16); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $logs->order(array('log_id' => 'desc'))->where($map)->select();
        $user_ids =  array();
        foreach ($list as $k => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            if( $val['money']==0 &&  $val['user_id'] != $val['admin_id']){
                $user_ids[$val['admin_id']] = $val['admin_id'];
            }
        }
        $sum = $logs->where($map)->sum('money');
        $this->assign('sum',$sum);
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('types',D('Communityorder')->getType());
        $this->assign('list', $list);
        $this->assign('page', $show); // 赋值分页输出
        $this->display();
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
                        if (!empty($val['money']) && !empty($val['bg_date']) && !empty($val['end_date'])) {
                            D('Communityorderproducts')->add(array('order_id' => $order_id, 'type' => $k, 'money' => $val['money'] * 100, 'bg_date' => $val['bg_date'], 'end_date' => $val['end_date']));
                        }
                    }
                    $this->baoSuccess('添加成功', U('order/index', array('user_id' => $user_id)));
                } else {
                    $this->baoError('添加失败');
                }
            }
            $this->baoError('该账单已存在');
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
        if ($this->isPost()) {
            $datas = $this->_post('data', false);
            foreach ($datas as $k => $val) {
                if ($val['is_pay'] != 1) {
                    D('Communityorderproducts')->save(array('id' => $val['id'], 'type' => $k, 'money' => $val['money'] * 100, 'bg_date' => $val['bg_date'], 'end_date' => $val['end_date']));
                }
            }
            $this->baoSuccess('修改成功', U('order/index', array('user_id' => $detail['user_id'])));
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
    public function moneylogs(){
        $Usermoneylogs = D('Usermoneylogs');
        import('ORG.Util.Page');
        $map = array('user_id' => $this->uid);
        $intro='小区项目经理分成';
        $map['intro']= array('LIKE', '%' . $intro . '%');
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_date=str_replace('+',' ',$bg_date);
            $end_date=str_replace('+',' ',$end_date);
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_date=str_replace('+',' ',$bg_date);
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_date=str_replace('+',' ',$end_date);
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        $moneysum = $Usermoneylogs->where($map)->sum('money');

        $count = $Usermoneylogs->where($map)->count();
        $Page = new Page($count, 20);
        $show = $Page->show();

        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Usermoneylogs->where($map)->order(array('log_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('moneysum', $moneysum);
        $this->display();
    }
    public function tixian(){
        $Users = D('Users');

        $map = array('user_id' => $this->uid);
        $intro='小区项目经理分成';
        $map['intro']= array('LIKE', '%' . $intro . '%');
        $list = $Users->where($map)->find();

        $shop = D('Shop')->where(array('user_id' => $this->uid))->find();
        if ($shop == '') {
            $cash_money = $this->_CONFIG['cash']['user'];
            $cash_money_big = $this->_CONFIG['cash']['user_big'];
        } elseif ($shop['is_renzheng'] == 0) {
            $cash_money = $this->_CONFIG['cash']['shop'];
            $cash_money_big = $this->_CONFIG['cash']['shop_big'];
        } elseif ($shop['is_renzheng'] == 1) {
            $cash_money = $this->_CONFIG['cash']['renzheng_shop'];
            $cash_money_big = $this->_CONFIG['cash']['renzheng_shop_big'];
        } else {
            $cash_money = $this->_CONFIG['cash']['user'];
            $cash_money_big = $this->_CONFIG['cash']['user_big'];
        }
        if (IS_POST) {
            $money = abs((int) ($_POST['money'] * 100));
            if ($money == 0) {
                $this->fengmiMsg('提现金额不能为0');
            }
            if ($money < $cash_money * 100) {
                $this->fengmiMsg('提现金额小于最低提现额度');
            }
            if ($money > $cash_money_big * 100) {
                $this->fengmiMsg('您单笔最多能提现' . $cash_money_big . '元');
            }
            if ($money > $this->member['money'] || $this->member['money'] == 0) {
                $this->fengmiMsg('余额不足，无法提现');
            }
            if (!($data['bank_name'] = htmlspecialchars($_POST['bank_name']))) {
                $this->fengmiMsg('开户行不能为空');
            }
            if (!($data['bank_num'] = htmlspecialchars($_POST['bank_num']))) {
                $this->fengmiMsg('银行账号不能为空');
            }
            if (!($data['bank_realname'] = htmlspecialchars($_POST['bank_realname']))) {
                $this->fengmiMsg('开户姓名不能为空');
            }
            $data['bank_branch'] = htmlspecialchars($_POST['bank_branch']);
            $data['user_id'] = $this->uid;
            $arr = array();
            $arr['user_id'] = $this->uid;
            $arr['money'] = $money;
            $arr['type'] = user;
            $arr['addtime'] = NOW_TIME;
            $arr['account'] = $this->member['account'];
            $arr['bank_name'] = $data['bank_name'];
            $arr['bank_num'] = $data['bank_num'];
            $arr['bank_realname'] = $data['bank_realname'];
            $arr['bank_branch'] = $data['bank_branch'];
            D('Userscash')->add($arr);
            D('Usersex')->save($data);
            //扣除余额
            $Users->addMoney($this->member['user_id'], -$money, '申请提现，扣款');

            $this->fengmiMsg('申请成功', U('logs/tixian'));
        } else {
            $this->assign('info', D('Usersex')->getUserex($this->uid));
            $this->assign('money', $list['money'] / 100);
            $this->assign('cash_money', $cash_money);
            $this->assign('cash_money_big', $cash_money_big);
            $this->display();
        }
    }
}
