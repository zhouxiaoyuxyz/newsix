<?php
class RetailmachineAction extends CommonAction{
    private $create_fields = array('m_sn',  'm_name','create_time');
    private $edit_fields = array('m_sn',  'm_name');
	public function index(){
        $Retailmachine = D('Retailmachine');
        import('ORG.Util.Page');
        $map = array('closed'=>0);
      
        if($m_sn = $this->_param('m_sn','htmlspecialchars')){
            $map['m_sn'] = array('LIKE','%'.$m_sn.'%');
            $this->assign('m_sn', $m_sn);
        }
      
        if($m_name = $this->_param('m_name','htmlspecialchars')){
            $map['m_name'] = array('LIKE','%'.$m_name.'%');
            $this->assign('m_name', $m_name);
        }

        $count = $Retailmachine->where($map)->count();
        $Page = new Page($count, 15);
        $show = $Page->show();
        $list = $Retailmachine->where($map)->order(array('machine_id' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$admin_ids =  array();
      

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    public function create(){
        if ($this->isPost()) {
            $data = $this->createCheck();
            $obj = D('Retailmachine');
            if ($obj->add($data)) {
                $obj->cleanCache();
                $this->baoSuccess('添加成功', U('Retailmachine/index'));
            }
            $this->baoError('操作失败！');
        } else {
			$map['closed']=0;
            $this->display();
        }
    }
    private function createCheck(){
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['m_sn'] = htmlspecialchars($data['m_sn']);
        if (empty($data['m_sn'])) {
            $this->baoError('自动售货机编号不能为空');
        }        

		$data['m_name'] = htmlspecialchars($data['m_name']);
        if (empty($data['m_name'])) {
            $this->baoError('自动售货机名称不能为空');
        }

        return $data;
    }
    public function edit($machine_id = 0){
        if ($machine_id = (int) $machine_id) {
            $obj = D('Retailmachine');
            if (!($detail = $obj->find($machine_id))) {
                $this->baoError('请选择要编辑的自动售货机');
            }
            if ($this->isPost()) {
                $data = $this->editCheck();
                $data['machine_id'] = $machine_id;
                if (false !== $obj->save($data)) {
                    $obj->cleanCache();
                    $this->baoSuccess('操作成功', U('Retailmachine/index'));
                }
                $this->baoError('操作失败');
            } else {
				$map['closed']=0;
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的自动售货机');
        }
    }
    private function editCheck(){
        $data = $this->checkFields($this->_post('data', false), $this->edit_fields);
        $data['m_sn'] = htmlspecialchars($data['m_sn']);
        if (empty($data['m_sn'])) {
            $this->baoError('自动售货机编号不能为空');
        }
		$data['m_name'] = htmlspecialchars($data['m_name']);
		if (empty($data['m_name'])) {
            $this->baoError('自动售货机名称不能为空');
        }

        return $data;
    }
    public function delete($machine_id = 0){
        if (is_numeric($machine_id) && ($machine_id = (int) $machine_id)) {
            $obj = D('Retailmachine');
            $obj->save(array('machine_id' => $machine_id, 'closed' => 1));
            $this->baoSuccess('删除成功！', U('Retailmachine/index'));
        } else {
            $machine_id = $this->_post('machine_id', false);
            if (is_array($machine_id)) {
                $obj = D('Retailmachine');
                foreach ($machine_id as $id) {
                    $obj->save(array('machine_id' => $id, 'closed' => 1));
                }
                $this->baoSuccess('删除成功！', U('Retailmachine/index'));
            }
            $this->baoError('请选择要删除的饮水机');
        }
    }


}