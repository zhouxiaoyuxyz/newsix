<?php
class IndexAction extends CommonAction
{
    public function index()
    {
      $shuicar_id = $this->_get('ID');
      $fp = fopen('shuicar_id.txt','w+'); 
			fwrite($fp,var_export($shuicar_id,true)); 
			fclose($fp);
	   $CODE = $this->_get('CODE');
	   $SN = $this->_get('SN');
	   if ($CODE){
		  
		 
		  $errorinfo="饮水机缺水，饮水机编号：".$SN;
			$fp = fopen('shuiinfo.txt','w+'); 
			fwrite($fp,var_export($errorinfo,true)); 
			fclose($fp);
			echo "NOWATER";
			die;
	   }
	   $shuimachine=D('Shuimachine')->where(array('m_sn' => $SN))->find();
      $shuiprice=$shuimachine['price']*100;
	  $shuiinfo=$shuimachine['command'];
      $map['shuicar1|shuicar2'] = $shuicar_id;
      $user=D('Users')->where($map)->find();
	   $machine_id=$shuimachine['machine_id'];
	   $fx_money=  $shuimachine['fanxian'];
      //print_r($user);
      if($user['money']>=$shuiprice){
      	D('Users')->addMoney($user['user_id'],-$shuiprice,'惠水源购水');
		 $data = array(
		 'machine_id' =>  $machine_id, 
		 'user_id' => $user['user_id'], 
		 'type' => 'card', 
		 'amount' => $shuimachine['price'], 
		 'fx_money' => $fx_money, 
		 'need_pay' => $shuimachine['price'], 
		 'status' => 1, 
		 'create_time' => NOW_TIME, 
		 'create_ip' => get_client_ip());
		 $order_id = D('Shuiorder')->add($data);
        //print_r($data);
        print_r($shuiinfo);
		
		$order = D('Shuiorder')->find($order_id);
		 $logs = array(
		 'type' => 'shui',
		 'user_id' => $user['user_id'], 
		 'order_id' => $order_id, 
		 'code' => 'money', 
		 'need_pay' => $order['need_pay'] * 100, 
		 'create_time' => NOW_TIME, 
		 'create_ip' => get_client_ip(), 
		 'is_paid' => 1);
         $logs['log_id'] = D('Paymentlogs')->add($logs);
		 
		 D('Shuiorder')->settlement($logs['order_id']);
		
      }else{
    	echo "NOMONEY";
   	  }      
    }
	public function machine()
    {
		
		$data = array(
		 'ip' =>  $this->_get('ip'),
		 'pt' => $this->_get('pt'), 
		 'sn' => $this->_get('sn'), 
		 'create_time' => NOW_TIME);
		 $data['machine_id']=D('Machine')->add($data);
		 print_r($data);
		 
		  $this->fangshui($data);
		
	}		public function control()    {
		if (!$this->uid) {
           $state = md5(uniqid(rand(), TRUE));
						session('state', $state);
						if (!empty($_SERVER['REQUEST_URI'])) {
							$backurl = $_SERVER['REQUEST_URI'];
						} else {
							$backurl = U('index/index');
						}
						session('backurl', $backurl);
						$login_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->_CONFIG['weixin']['appid'] . '&redirect_uri=' . urlencode(__HOST__ . U('/passport/wxstart')) . '&response_type=code&scope=snsapi_userinfo&state=' . $state . '#wechat_redirect';
						header("location:{$login_url}");
						echo $login_url;
						die;			
        }
				$sn=$this->_get('sn');
		$shuimachine=D('Shuimachine')->where(array('m_sn' => $sn))->find();
		$payment=D('Payment')->getPayments(true);
		 
		 if ($this->isPost()) {
			 $sn=$this->_post('sn'); 
			 if(!D('Shuimachine')->checkonline($sn)){				 
				 $this->error('饮水机不在线，请联系管理员！');
			 }
			$user=D('Users')->find($this->uid);
			$shuimachine=D('Shuimachine')->where(array('m_sn' => $sn))->find();
			$shuiprice=$shuimachine['price']*100;
			
			
			$code=$this->_post('code');
			if($code=="money"){
				if($user['money']>=$shuiprice){
					//放水指令
					D('Shuimachine')->fangshui($sn);
							//扣款
							D('Users')->addMoney($user['user_id'],-$shuiprice,'惠水源扫码购水');
							//扫码下单
							 $data = array(
							 'machine_id' =>  $shuimachine['machine_id'], 
							 'user_id' => $user['user_id'], 
							 'type' => 'qrcode', 
							 'amount' => $shuimachine['price'], 
							 'fx_money' => $shuimachine['fanxian'], 
							 'need_pay' => $shuimachine['price'], 
							 'status' => 1, 
							 'create_time' => NOW_TIME, 
							 'create_ip' => get_client_ip());
							 $order_id = D('Shuiorder')->add($data);
							//print_r($data);
							//print_r($shuiinfo);
							
							//支付日志
							$order = D('Shuiorder')->find($order_id);
							 $logs = array(
							 'type' => 'shui',
							 'user_id' => $user['user_id'], 
							 'order_id' => $order_id, 
							 'code' => 'money', 
							 'need_pay' => $order['need_pay'] * 100, 
							 'create_time' => NOW_TIME, 
							 'create_ip' => get_client_ip(), 
							 'is_paid' => 1);
							 $logs['log_id'] = D('Paymentlogs')->add($logs);
							 
							 //分润
							 D('Shuiorder')->settlement($logs['order_id']);
							$this->success('打水成功！', U('/mcenter/index'));
						
					  }else{
						  
						$this->error('余额不足，请充值！', U('/mcenter/money'));
						
					  }
			}else{
				$this->error('不支持该支付方式！');
			}
		 }else{
			//print_r($payment);
			$this->assign('sn', $sn);
			$this->assign('shuimachine', $shuimachine);
			$this->assign('payment', $payment);			$this->display();
		 }			}
	
	public function fangshui()
    {	
		
		$sn=$this->_post('sn'); 
		$user=D('Users')->find($this->uid);
		$shuimachine=D('Shuimachine')->where(array('m_sn' => $sn))->find();
		$shuiprice=$shuimachine['price']*100;
		if($user['money']>=$shuiprice){
			D('Users')->addMoney($user['user_id'],-$shuiprice,'惠水源扫码购水');
			 $data = array(
			 'machine_id' =>  $shuimachine['machine_id'], 
			 'user_id' => $user['user_id'], 
			 'type' => 'qrcode', 
			 'amount' => $shuimachine['price'], 
			 'fx_money' => $shuimachine['fanxian'], 
			 'need_pay' => $shuimachine['price'], 
			 'status' => 1, 
			 'create_time' => NOW_TIME, 
			 'create_ip' => get_client_ip());
			 $order_id = D('Shuiorder')->add($data);
			//print_r($data);
			//print_r($shuiinfo);
			$url=__HOST__.'/socket/client.php?card='.$sn;
			$html = file_get_contents($url);
			
			$order = D('Shuiorder')->find($order_id);
			 $logs = array(
			 'type' => 'shui',
			 'user_id' => $user['user_id'], 
			 'order_id' => $order_id, 
			 'code' => 'money', 
			 'need_pay' => $order['need_pay'] * 100, 
			 'create_time' => NOW_TIME, 
			 'create_ip' => get_client_ip(), 
			 'is_paid' => 1);
			 $logs['log_id'] = D('Paymentlogs')->add($logs);
			 
			 D('Shuiorder')->settlement($logs['order_id']);
			
		  }else{
			  
			$this->fengmiMsg('余额不足，请充值！', U('/mcenter/money'));
			
		  }
		  
		 print_r($user);
		 print_r($shuimachine);
		
	}
	
}