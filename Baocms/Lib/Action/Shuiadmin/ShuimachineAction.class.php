<?php
class ShuimachineAction extends CommonAction{
    private $create_fields = array('m_sn', 'city_id', 'area_id', 'model', 'price', 'fanxian', 'tg_fanxian','wy_fanxian', 'command', 'pic', 'admin_id', 'lng', 'lat', 'orderby','create_time');
    private $edit_fields = array('m_sn', 'city_id', 'area_id', 'model', 'price', 'fanxian', 'tg_fanxian', 'wy_fanxian', 'command', 'pic', 'admin_id', 'lng', 'lat', 'orderby');
	public function index(){
    $Shuimachine = D('Shuimachine');
    import('ORG.Util.Page');
    $map['closed'] = 0;
    $map['admin_id|hhr_id'] = $this->_admin['admin_id'];
    //print_r($map);
    $count = $Shuimachine->where($map)->count();
    $Page = new Page($count, 15);
    $show = $Page->show();
    $list = $Shuimachine->where($map)->order(array('orderby' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
   // echo "<pre>";echo print_r($list);echo"<pre>";
    $admin_ids =  array();
    foreach ($list as $key => $val) {
        if($val['admin_id']==$this->_admin['admin_id']){
            $admin_ids[$val['admin_id']] = $val['admin_id'];
            echo "admin_id";
            echo $val['admin_id'];
        }else if($val['hhr_id']==$this->_admin['admin_id']){
            $admin_ids[$val['hhr_id']] = $val['hhr_id'];
            echo "hhr_id";
            echo $val['hhr_id'];
        }

        /**if(D('Shuimachine')->checkonline($val['m_sn'])){
        $list[$key]['online']="在线";
        }else{
        $list[$key]['online']="离线";
        }**/
    }
    $admins=D('Admin')->itemsByIds($admin_ids);
   // echo "$admins";
   // echo "<pre>";echo print_r($admins);echo"<pre>";
    $this->assign('admins', D('Admin')->itemsByIds($admin_ids));
    $this->assign('list', $list);
    $this->assign('page', $show);
    $this->display();
}
     public function index20190509(){
        $Shuimachine = D('Shuimachine');
        import('ORG.Util.Page');
        $map['closed'] = 0;
        $map['admin_id|hhr_id'] = $this->_admin['admin_id'];
        //print_r($map);
        $count = $Shuimachine->where($map)->count();
        $Page = new Page($count, 15);
        $show = $Page->show();
        $list = $Shuimachine->where($map)->order(array('orderby' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
      //  echo "<pre>";echo print_r($list);echo"<pre>";
        $admin_ids =  array();
        foreach ($list as $key => $val) {
            if($val['admin_id']==$this->_admin['admin_id']){
                $admin_ids[$val['admin_id']] = $val['admin_id'];
                echo "admin_id";
                echo $val['admin_id'];
            }else if($val['hhr_id']==$this->_admin['admin_id']){
                $admin_ids[$val['hhr_id']] = $val['hhr_id'];
                echo "hhr_id";
                echo $val['hhr_id'];
            }

            /**if(D('Shuimachine')->checkonline($val['m_sn'])){
            $list[$key]['online']="在线";
            }else{
            $list[$key]['online']="离线";
            }**/
        }
        $admins=D('Admin')->itemsByIds($admin_ids);
      //  echo "$admins";
      //  echo "<pre>";echo print_r($admins);echo"<pre>";
        $this->assign('admins', D('Admin')->itemsByIds($admin_ids));
        $this->assign('list', $list);
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
		
		if ($data['fanxian']+$data['tg_fanxian']+$data['wy_fanxian']>=$data['price']) {
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
		if ($data['fanxian']+$data['tg_fanxian']+$data['wy_fanxian']>=$data['price']) {
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

}