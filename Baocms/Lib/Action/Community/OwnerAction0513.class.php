<?php



class OwnerAction extends CommonAction {

    public function index() {
        $owner = D('Communityowner');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('community_id' => $this->community_id);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['number|location'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword',$keyword);
        }
        $count = $owner->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 16); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $owner->order(array('owner_id' => 'desc'))->where($map)->select();
        $user_ids = array();
        foreach ($list as $k => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
        }
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('list', $list);
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板   
    }
	
	public function users() {
        $owner = D('Communityowner');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('community_id' => $this->community_id);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['number|location'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword',$keyword);
        }
        $count = $owner->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 16); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $owner->order(array('owner_id' => 'desc'))->where($map)->select();
        $user_ids = array();
        foreach ($list as $k => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
        }
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('list', $list);
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板   
    }
	
	 public function import(){
        if($this->isPost()){
          
            $file = fopen($_FILES['csv']['tmp_name'],'r');
            $list = array();
			$i = 0;
            while ($data = fgetcsv($file)) {
                
				//$data=iconv('gb2312','utf-8',$data); 
				$fanghao = explode('-',$data[0]); 
				$list[$i]['dong'] = $fanghao[0];
				$list[$i]['danyuan'] = $fanghao[1];
				$list[$i]['number'] = $fanghao[2];
				$list[$i]['name'] = iconv('gb2312','utf-8',$data[1]); 
				$list[$i]['mianji'] = $data[2];
				$list[$i]['danjia'] = $data[3];
				$list[$i]['order_date'] = $data[4];
				$list[$i]['money'] = $data[5];
				$list[$i]['bg_date'] = $data[6];
				$list[$i]['end_date'] = $data[7];
				$list[$i]['phone'] = (int)$data[8];
				
				
				
				
				$i++;
				
            }
			unset($list[0]);
			//print_r($list);
            if(empty($list)){
                $this->error('没有被识别的业主信息');
            }
            print_r(count($list));
            $this->assign('list',$list);
            $this->display('importok');
        }else{
            $this->display();
        }
        
    }
    
    
    public function importok(){
        $owners = $_POST['owners'];
        if(empty($owners)){
            $this->baoError('导入的业主不能为空');
        }
		//print_r($owners);
        $data = array(
            'community_id'   => $this->community_id,
            'audit'       => '1',
            'create_time'    => NOW_TIME,
            'create_ip'      => get_client_ip()
        );
        
        $obj = D('Communityowner');		print_r(count($owners));
        foreach($owners as $val){
            				//print_r(000000);
				//print_r($val);				foreach($val as $key =>$val1){
					$data[$key] = $val1;					
				}
				if (!$isowner = D('Communityowner')->where(array('dong' => $data['dong'],'danyuan' => $data['danyuan'],'number' => $data['number'],'community_id' => $this->community_id))->find()){					
					$owner=array(
						'community_id'   => $this->community_id,
						'audit'       => '1',
						'create_time'    => NOW_TIME,
						'create_ip'      => get_client_ip(),
						'name'      => $data['name'],
						'phone'      => $data['phone'],
						'dong'      => $data['dong'],
						'danyuan'      => $data['danyuan'],
						'number'      => $data['number'],
						'mianji'      => $data['mianji'],
						'danjia'      => $data['danjia']
						
					);
					//print_r(11111);
					//print_r($owner);
					$owner_id = $obj->add($owner);
					//print_r($owner_id);
					
						$data[owner_id]=$owner_id;
						
						$order=array(
						'community_id'   => $this->community_id,
						'create_time'    => NOW_TIME,
						'order_date'      => $data['order_date'],
						'create_ip'      => get_client_ip(),
						'owner_id'      => $data['owner_id']						
						);
						
						if ($order_id = D('Communityorder')->add($order)) {
							
								 D('Communityorderproducts')->add(array(
										 'order_id' => $order_id, 
										 'community_id' => $this->community_id,
										 'type' => 5,
										 'money' => $data['money'] * 100, 
										 'bg_date' => $data['bg_date'], 
										 'end_date' => $data['end_date']
									 ));
							
						}
					
				} else{
					//print_r($isowner);
					if (!$res = D('Communityorder')->where(array('owner_id' => $isowner[owner_id], 'order_date' => $data['order_date']))->find()) {
						print_r($res);
						$order=array(
						'community_id'   => $this->community_id,
						'create_time'    => NOW_TIME,
						'order_date'      => $data['order_date'],
						'create_ip'      => get_client_ip(),
						'owner_id'      => $isowner[owner_id]
						);
						if ($order_id = D('Communityorder')->add($order)) {
							D('Communityorderproducts')->add(array(
										 'order_id' => $order_id, 
										 'community_id' => $this->community_id,
										 'type' => 5,
										 'money' => $data['money'] * 100, 
										 'bg_date' => $data['bg_date'], 
										 'end_date' => $data['end_date']
									 ));
							
						}
					}
				}
                
            
        }
        $this->baoSuccess('导入成功！',U('owner/index'));
    }

    public function audit($owner_id) {

        $owner_id = (int) $owner_id;
        if (empty($owner_id)) {
            $this->error('该业主不存在');
        }
        if (!$detail = D('Communityowner')->find($owner_id)) {
            $this->error('该业主不存在');
        }
        if ($detail['community_id'] != $this->community_id) {
            $this->error('不能操作其他小区业主');
        }

        if ($this->isPost()) {
            $data['number'] = (int) $_POST['number'];
            if (empty($data['number'])) {
                $this->baoError('户号不能为空');
            }
            $data['owner_id'] = $owner_id;
            $data['audit'] = 1;
            $obj = D('Communityowner');
            if (false !== $obj->save($data)) {
                $this->baoSuccess('审核成功', U('owner/index'));
            }
            $this->baoError('操作失败！');
        } else {
            $this->assign('detail', $detail);
            $this->display();
        }
    }

    public function delete() {
        $owner_id = (int) $this->_get('owner_id');
        $obj = D('Communityowner');
        $detail = $obj->find($owner_id);
        if (!empty($detail) && $detail['community_id'] == $this->community_id) {
			$orders=D('Communityorder')->where(array('owner_id' => $owner_id))->select();
			foreach($orders as $val){
					D('Communityorderproducts')->where(array('order_id' => $val['order_id']))->delete();					
				}
			D('Communityorder')->where(array('owner_id' => $owner_id))->delete();
            $obj->delete($owner_id);
            $this->success('删除成功！', U('owner/index'));
        }
        $this->error('操作失败');
    }


}
