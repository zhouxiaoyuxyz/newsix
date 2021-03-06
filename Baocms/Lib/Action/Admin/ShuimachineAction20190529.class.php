<?php
class ShuimachineAction extends CommonAction{
    private $create_fields = array('m_sn', 'city_id', 'area_id', 'model', 'price', 'fanxian', 'tg_fanxian','wy_fanxian','hhr_fanxian', 'command', 'pic', 'admin_id','hhr_id', 'lng', 'lat', 'orderby','create_time');
    private $edit_fields = array('m_sn', 'city_id', 'area_id', 'model', 'price', 'fanxian', 'tg_fanxian', 'wy_fanxian', 'hhr_fanxian','command', 'pic', 'admin_id','hhr_id', 'lng', 'lat', 'orderby');
	private $create_cards = array('c_sn', 'city_id', 'area_id', 'times', 'end_time', 'remark', 'closed',  'orderby','create_time');
	private $edit_cards = array('c_sn', 'city_id', 'area_id', 'times', 'end_time', 'remark', 'closed',  'orderby');
	public function index(){
        $Shuimachine = D('Shuimachine');
        import('ORG.Util.Page');
        $map = array('closed'=>0);
      
        if($m_sn = $this->_param('m_sn','htmlspecialchars')){
            $map['m_sn'] = array('LIKE','%'.$m_sn.'%');
            $this->assign('m_sn', $m_sn);
        }
      
        if($model = $this->_param('model','htmlspecialchars')){
            $map['model'] = array('LIKE','%'.$model.'%');
            $this->assign('model', $model);
        }

        $count = $Shuimachine->where($map)->count();
        $Page = new Page($count, 15);
        $show = $Page->show();
        $list = $Shuimachine->where($map)->order(array('machine_id' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$admin_ids =  array();
      
     
		foreach ($list as $key => $val) {
            $admin_ids[$val['admin_id']] = $val['admin_id'];
			 /**if(D('Shuimachine')->checkonline($val['m_sn'])){				 
				  $list[$key]['online']="在线";
			 }else{
				 $list[$key]['online']="离线";
			 }**/
			}
        $this->assign('list', $list);
		$this->assign('admins', D('Admin')->itemsByIds($admin_ids));
        $this->assign('page', $show);
        $this->display();
    }
    public function create(){
        if ($this->isPost()) {
            $data = $this->createCheck();
            $obj = D('Shuimachine');
            if ($obj->add($data)) {
                $obj->cleanCache();
                $this->baoSuccess('添加成功', U('Shuimachine/index'));
            }
            $this->baoError('操作失败！');
        } else {
			$map['role_id']=array('IN','11,3');
			$map['closed']=0;
			$admins = D('Admin')->where($map)->select();
			$this->assign('admins',$admins);
            $this->display();
        }
    }
    private function createCheck(){
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['m_sn'] = htmlspecialchars($data['m_sn']);
        if (empty($data['m_sn'])) {
            $this->baoError('饮水机编号不能为空');
        }        
        $data['price'] = $data['price'];
		if (empty($data['price'])) {
            $this->baoError('购水单价金额不能为空');
        }
        $data['fanxian'] = $data['fanxian'];
		if (empty($data['fanxian'])) {
             $this->baoError('返现金额不能为空');
        }
		
		if ($data['fanxian']+$data['tg_fanxian']+$data['wy_fanxian']+$data['hhr_fanxian']>=$data['price']) {
             $this->baoError('返现金额不得大于水单价！');
        }
		
		$data['command'] = htmlspecialchars($data['command']);
		if (empty($data['command'])) {
            //$this->baoError('出水指令不能为空');
        }
		$data['orderby'] = (int) $data['orderby'];
		if (empty($data['orderby'])) {
           // $this->baoError('等级权重不能为空');
        }
		if($detail = D('Shuimachine')->where(array('orderby'=>$data['orderby']))->find()) {
           // $this->baoError('等级权重重复，请调整后在提交');
        }
        return $data;
    }
    public function edit($machine_id = 0){
        if ($machine_id = (int) $machine_id) {
            $obj = D('Shuimachine');
            if (!($detail = $obj->find($machine_id))) {
                $this->baoError('请选择要编辑的饮水机');
            }
            if ($this->isPost()) {
                $data = $this->editCheck();
                $data['machine_id'] = $machine_id;
                if (false !== $obj->save($data)) {
                    $obj->cleanCache();
                    $this->baoSuccess('操作成功', U('Shuimachine/index'));
                }
                $this->baoError('操作失败');
            } else {
				$map['role_id']=array('IN','11,3');
				$map['closed']=0;
				$admins = D('Admin')->where($map)->select();
				$detail['admin']=D('Admin')->find($detail['admin_id']);
                $detail['hhr']=D('Admin')->find($detail['hhr_id']);
		
				$this->assign('admins',$admins);
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的饮水机');
        }
    }
    private function editCheck(){
        $data = $this->checkFields($this->_post('data', false), $this->edit_fields);
        $data['m_sn'] = htmlspecialchars($data['m_sn']);
        if (empty($data['m_sn'])) {
            $this->baoError('饮水机编号不能为空');
        }        
        $data['price'] = $data['price'];
		if (empty($data['price'])) {
            $this->baoError('购水单价金额不能为空');
        }
        $data['fanxian'] = $data['fanxian'];
		if (empty($data['fanxian'])) {
             $this->baoError('返现金额不能为空');
        }
		if ($data['fanxian']+$data['tg_fanxian']+$data['wy_fanxian']+$data['hhr_fanxian']>=$data['price']) {
             $this->baoError('返现金额不得大于水单价！');
        }
		$data['command'] = htmlspecialchars($data['command']);
		if (empty($data['command'])) {
            //$this->baoError('出水指令不能为空');
        }
		$data['orderby'] = (int) $data['orderby'];
		if (empty($data['orderby'])) {
            //$this->baoError('等级权重不能为空');
        }
        return $data;
    }
    public function delete($machine_id = 0){
        if (is_numeric($machine_id) && ($machine_id = (int) $machine_id)) {
            $obj = D('Shuimachine');
            $obj->save(array('machine_id' => $machine_id, 'closed' => 1));
            $this->baoSuccess('删除成功！', U('Shuimachine/index'));
        } else {
            $machine_id = $this->_post('machine_id', false);
            if (is_array($machine_id)) {
                $obj = D('Shuimachine');
                foreach ($machine_id as $id) {
                    $obj->save(array('machine_id' => $id, 'closed' => 1));
                }
                $this->baoSuccess('删除成功！', U('Shuimachine/index'));
            }
            $this->baoError('请选择要删除的饮水机');
        }
    }
	
	
	public function cards(){
        $Shuicards = D('Shuicards');
        import('ORG.Util.Page');
        $map = array();
      
      	if($card_no = $this->_param('card_no','htmlspecialchars')){
            $map['c_sn'] = array('LIKE','%'.$card_no.'%');
            $this->assign('card_no', $card_no);
        }
      
        $count = $Shuicards->where($map)->count();
        $Page = new Page($count, 15);
        $show = $Page->show();
        $list = $Shuicards->where($map)->order(array('card_id' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
		
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
	
	public function addcard(){
        if ($this->isPost()) {
			
            $data = $this->addcardCheck();
           $data['end_time']=strtotime($data['end_time']);
            $obj = D('Shuicards');
            if ($obj->add($data)) {
                $obj->cleanCache();
                $this->baoSuccess('添加成功', U('Shuimachine/cards'));
            }
            $this->baoError('操作失败！');
        } else {			
            $this->display();
        }
    }
  
  	public function searchcard(){
        $Shuicards = D('Shuicards');
        import('ORG.Util.Page');
        $map = array();

        if($card_no = $this->_param('$card_no','htmlspecialchars')){
            $map['c_sn'] = array('LIKE','%'.$card_no.'%');
            $this->assign('card_no',$card_no);
        }
        $count = $Shuicards->where($map)->count();
        $Page = new Page($count, 15);
        $show = $Page->show();
        $list = $Shuicards->where($map)->order(array('orderby' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
  
    private function addcardCheck(){
        $data = $this->checkFields($this->_post('data', false), $this->create_cards);
		$data['create_time'] = time();
        $data['c_sn'] = htmlspecialchars($data['c_sn']);
        if (empty($data['c_sn'])) {
            $this->baoError('饮水机编号不能为空');
        }        
        $data['times'] = $data['times'];
		if (empty($data['times'])) {
            $this->baoError('单日限制不能为空');
        }
		if (empty($data['end_time'])) {
            $this->baoError('神卡有效日期不能为空！');
        }
        
        return $data;
    }
	
	 public function editcard($card_id = 0){
        if ($card_id = (int) $card_id) {
            $obj = D('Shuicards');
            if (!($detail = $obj->find($card_id))) {
                $this->baoError('请选择要编辑的水卡');
            }
            if ($this->isPost()) {
				
                $data = $this->editcardCheck();
				$data['end_time']=strtotime($data['end_time']);
                $data['card_id'] = $card_id;
                if (false !== $obj->save($data)) {
                    $obj->cleanCache();
                    $this->baoSuccess('操作成功', U('Shuimachine/cards'));
                }
                $this->baoError('操作失败');
            } else {
				$detail['end_time']=date('Y-m-d', $detail['end_time']);
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的水卡');
        }
    }
    private function editcardCheck(){
        $data = $this->checkFields($this->_post('data', false), $this->edit_cards);
        $data['c_sn'] = htmlspecialchars($data['c_sn']);
        if (empty($data['c_sn'])) {
            $this->baoError('水卡编号不能为空');
        }        
        $data['times'] = $data['times'];
		if (empty($data['times'])) {
            $this->baoError('单日限制不能为空');
        }
		if (empty($data['end_time'])) {
            $this->baoError('神卡有效日期不能为空！');
        }
       
        return $data;
    }
    public function deletecard($card_id = 0){
        if (is_numeric($card_id) && ($card_id = (int) $card_id)) {
            $obj = D('Shuicards');
            $obj->delete($card_id);
            $this->baoSuccess('删除成功！', U('Shuimachine/cards'));
        } else {
            $card_id = $this->_post('card_id', false);
            if (is_array($card_id)) {
                $obj = D('Shuicards');
                foreach ($card_id as $id) {
                     $obj->delete($id);
                }
                $this->baoSuccess('删除成功！', U('Shuimachine/cards'));
            }
            $this->baoError('请选择要删除的饮水机');
        }
    }

}