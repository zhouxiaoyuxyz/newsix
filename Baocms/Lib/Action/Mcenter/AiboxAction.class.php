<?php



class AiboxAction extends CommonAction {

	public function index() {
		$u = D('Users');
		$ud = D('UserAddr');
                $bc = D('Connect');
		$map = array('user_id' => $this->uid);
		$res = $u-> where($map) -> find();
		$addr_count = $ud -> where($map) -> count();
                $rbc = $bc -> where('uid ='.($this->uid)) -> select();
                $bind = array();
                foreach($rbc as $val){
                    $bind[$val['type']] = $val;
                }
                //print_r($bind);
		$this->assign('res',$res);
		$this->assign('addr_count',$addr_count);
                $this->assign('bind',$bind);
		$this->display(); // 输出模板
	}

    public function main() {
        $u = D('Users');
        $ud = D('UserAddr');
        $bc = D('Connect');
        $map = array('user_id' => $this->uid);
        $res = $u-> where($map) -> find();
        $addr_count = $ud -> where($map) -> count();
        $rbc = $bc -> where('uid ='.($this->uid)) -> select();
        $bind = array();
        foreach($rbc as $val){
            $bind[$val['type']] = $val;
        }
        //print_r($bind);
        $this->assign('res',$res);
        $this->assign('addr_count',$addr_count);
        $this->assign('bind',$bind);
        $this->display(); // 输出模板
    }
  
  	public function voice() {
        $u = D('Users');
        $ud = D('UserAddr');
        $bc = D('Connect');
        $map = array('user_id' => $this->uid);
        $res = $u-> where($map) -> find();
        $addr_count = $ud -> where($map) -> count();
        $rbc = $bc -> where('uid ='.($this->uid)) -> select();
        $bind = array();
        foreach($rbc as $val){
            $bind[$val['type']] = $val;
        }
        //print_r($bind);
        $this->assign('res',$res);
        $this->assign('addr_count',$addr_count);
        $this->assign('bind',$bind);
        $this->display(); // 输出模板
    }

}