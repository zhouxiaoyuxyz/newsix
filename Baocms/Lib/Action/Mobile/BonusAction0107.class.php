<?php
class BonusAction extends CommonAction{
    public function _initialize(){
        parent::_initialize();
        
    }
	public function index(){		
		       
		$bonus_id = (int) $this->_get('bonus_id');
		$bonus = D("bonus");
		$havebonus=$bonus->where(array('bonus_id' => $bonus_id))->find();
		if (!empty($havebonus)) {
        $map = array();        
        $map['bonus_id'] = $bonus_id;
        
        $join = 'JOIN bao_users u on u.user_id= b.user_id';
         $list = D("Bonuslog")->alias('b')->join($join)->where($map)->select();
        
		 if (empty($this->uid)) {
			 $this->display();
            $this->fengmiMsg('请先登陆', U('passport/login'));
		}else{
			$hadbonus=D("Bonuslog")->where(array('user_id' => $this->uid, 'bonus_id' => $bonus_id))->find();
			//print_r($hadbonus);
			
			if (empty($hadbonus) && $havebonus['remain']>0) {
				
				$this->display();
				$this->getbonus($bonus_id);
			}else{
				$amount=$hadbonus['amount'];
			}
		}
		
        }else{
			$this->display();
			$this->fengmiMsg('红包不存在', U('/mcenter/member'));
		}
		
		$this->assign('list', $list);
		//print_r($list);
		$this->assign('amount', $amount);
		$this->display();
    }
    
    public function getbonus($bonus_id) {
		 if (empty($this->uid)) {
            $this->fengmiMsg('请先登陆', U('passport/login'));
        }
		
      
        $bonus = D("bonus")->find($bonus_id);
		 if (empty($bonus)) {
            $this->fengmiMsg('红包不存在', U('/mcenter/member'));
        }
		$already_get=D('Bonuslog')->where(array('bonus_id' => $bonus_id, 'user_id' => $this->uid))->find();
		if (!empty($already_get)) {
			$this->fengmiMsg('您已领过该红包！', U('/mobile/bonus/index/bonus_id/'.$bonus_id));
		}
		 if ($bonus['remain']>0) {
            $bonus_details=json_decode($bonus['details'], true);
			$bonus_amount=$bonus_details[$bonus['remain']];
			
				$arr = array();
                $arr['user_id'] = $this->uid;
                $arr['bonus_id'] = $bonus_id;
                $arr['amount']   = $bonus_amount;
                $arr['get_time'] = NOW_TIME;
                D('Bonuslog')->add($arr);
			
			
			$Users = D('Users');
			$Users->addMoney($this->uid, $bonus_amount*100, '领取红包');
			
			
			 D('bonus')->where(array('bonus_id' => $bonus_id))->save(array('remain' => $bonus['remain']-1));
			$this->fengmiMsg('领取成功！', U('/mobile/bonus/index/bonus_id/'.$bonus_id));
			$url=U('/mobile/bonus/index/bonus_id/'.$bonus_id);
			header("Location: $url"); 
			//return 0;
        }else{
			$this->fengmiMsg('红包已领完', U('/mobile/bonus/index/bonus_id/'.$bonus_id));
		}
		 
		$this->display();
        
    }
   
}