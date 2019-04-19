<?php



class  TongjiAction extends CommonAction{
    
    
    public function  index(){
        
        $showdata =  D('Tuanorder')->source();
        $weeks = D('Tuanorder')->weeks();
        $this->assign('weeks',$weeks);
        $this->assign('showdata',$showdata);
        $this->display();
    }
    
    
    public function quanming(){
         if(($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))){
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date)+86400;
           
        }else{
            $bg_date = date('Y-m-d',NOW_TIME-86400*30);
            $bg_time = strtotime($bg_date);
            $end_time = NOW_TIME;
            $end_date = TODAY;
        }
        $this->assign('bg_date',$bg_date);
        $this->assign('end_date',$end_date);

        $this->assign('tongji1',D('Quanming')->tongjiComm($bg_time,$end_time));
        $this->assign('tongji2',D('Quanming')->tongjiNum($bg_time,$end_time));
        $this->display();
    }
    
    public function money(){
        if(($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))){
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date)+86400;
           
        }else{
            $bg_date = date('Y-m-d',NOW_TIME-86400*30);
            $bg_time = strtotime($bg_date);
            $end_time = NOW_TIME;
        }
        $this->assign('bg_date',$bg_date);
        $this->assign('end_date',$end_date);
        $this->assign('money',D('Tuanorder')->money($bg_time,$end_time));
        $this->assign('money_yue',D('Tuanorder')->money_yue());
        $this->display();
    }
    
    
    public function  laiyuan(){
        $bg_date = $this->_param('bg_date', 'htmlspecialchars');
        $end_date = $this->_param('end_date', 'htmlspecialchars');
        if(empty($bg_date) || empty($end_date)){
            $bg_date = date('Y-m-d',NOW_TIME-86400*30);
            $end_date = TODAY;
        }
        $this->assign('bg_date',$bg_date);
        $this->assign('end_date',$end_date);
        
        $this->assign('laiyuan',D('Tongji')->laiyuan($bg_date,$end_date));
        
        $this->display();
    }
    
    public function lmoney(){
        
        $bg_date = $this->_param('bg_date', 'htmlspecialchars');
        $end_date = $this->_param('end_date', 'htmlspecialchars');
        if(empty($bg_date) || empty($end_date)){
            $bg_date = date('Y-m-d',NOW_TIME-86400*30);
            $end_date = TODAY;
        }
        $this->assign('bg_date',$bg_date);
        $this->assign('end_date',$end_date);
        
        $this->assign('laiyuan',D('Tongji')->lmoney($bg_date,$end_date));
        
        $this->display();
        
    }
    
    
    public function tuiguan(){
        
        $bg_date = $this->_param('bg_date', 'htmlspecialchars');
        $end_date = $this->_param('end_date', 'htmlspecialchars');
        if(empty($bg_date) || empty($end_date)){
            $bg_date = date('Y-m-d',NOW_TIME-86400*30);
            $end_date = TODAY;
        }
        $this->assign('bg_date',$bg_date);
        $this->assign('end_date',$end_date);
    
        $this->assign('tuiguan',D('Tongji')->tuiguan($bg_date,$end_date));
        $this->assign('tmoney',D('Tongji')->tmoney($bg_date,$end_date));
        $this->display();
    }
    
    public function keyword(){
        
        $bg_date = $this->_param('bg_date', 'htmlspecialchars');
        $end_date = $this->_param('end_date', 'htmlspecialchars');
        if(empty($bg_date) || empty($end_date)){
            $bg_date = date('Y-m-d',NOW_TIME-86400*30);
            $end_date = TODAY;
        }
        $this->assign('bg_date',$bg_date);
        $this->assign('end_date',$end_date);
    
        $this->assign('keyword',D('Tongji')->keyword($bg_date,$end_date));
        $this->assign('kmoney',D('Tongji')->kmoney($bg_date,$end_date));
        $this->display();
    }
	
	public function income(){
        
        $logs = D('Fenzhangoldlogs');
        import('ORG.Util.Page'); // 导入分页类
        $map = array();
        if ($city_id = (int) $this->_param('city_id')) {
           
            $map['city_id'] = $city_id;
            $city = D('City')->find($city_id);
            $this->assign('name', $city['name']);
            $this->assign('city_id', $city_id);
        }
		
		if ($user_id = (int) $this->_param('user_id')) {
           
            $map['user_id'] = $user_id;
            $user = D('Users')->find($user_id);
            $this->assign('nickname', $user['nickname']);
            $this->assign('user_id', $user_id);
        }
       
        if($type = (int)$this->_param('type')){
            if($type != 999){
                $map['type'] = $type;
                $this->assign('type',$type);
            }else{
                $this->assign('type',999);
            }
        }
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
         $map['admin_id'] = $this->_admin['admin_id'];
		
        $count = $logs->where($map)->count(); // 查询满足要求的总记录数 
        $sum = $logs->where($map)->sum('gold');
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $logs->where($map)->order(array('log_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $user_ids = $city_ids =  array();
        foreach ($list as $key => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $city_ids[$val['city_id']] = $val['city_id'];
			}
			//print_r($user_ids);
        $this->assign('sum',$sum);
        $this->assign('citys',D('City')->itemsByIds($city_ids));
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('types', D('Fenzhangoldlogs')->getType());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }
    
    
}