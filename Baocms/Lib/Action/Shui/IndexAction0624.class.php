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
	   if ($CODE){
		  $SN = $this->_get('SN');
		 
		  $errorinfo="饮水机缺水，饮水机编号：".$SN;
			$fp = fopen('shuiinfo.txt','w+'); 
			fwrite($fp,var_export($errorinfo,true)); 
			fclose($fp);
			echo "NOWATER";
			die;
	   }
      $config = D('Setting')->fetchAll();
      	$shuiinfo=$config['site']['shuiinfo'];
      $shuiprice=$config['site']['shuiprice']*100;
      $map['shuicar1|shuicar2'] = $shuicar_id;
      $user=D('Users')->where($map)->find();
	   $shop_id=42;
	   $amount=$config['site']['shuiprice'];
	   $fx_money=  $config['site']['shuifanxian'];
      //print_r($user);
      if($user['money']>=$shuiprice){
      	D('Users')->addMoney($user['user_id'],-$shuiprice,'惠水源购水');
		 $data = array(
		 'shop_id' =>  $shop_id, 
		 'user_id' => $user['user_id'], 
		 'amount' => $amount, 
		 'fx_money' => $fx_money, 
		 'need_pay' => $amount, 
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
		
	}		public function control()    {		$sn=$this->_get('sn');
		$shuimachine=D('Shuimachine')->where(array('m_sn' => $sn))->find();
		$payment=D('Payment')->getPayments(true);
		print_r($payment);
		$this->assign('sn', $sn);
		$this->assign('shuimachine', $shuimachine);
		$this->assign('payment', $payment);		$this->display();			}
	
	public function fangshui()
    {	
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
		$user=D('Users')->find($this->uid);
		$shuimachine=D('Shuimachine')->where(array('m_sn' => $sn))->find();
		$shuiprice=$shuimachine['price']*100;
		/**if($user['money']>=$shuiprice){
			D('Users')->addMoney($user['user_id'],-$shuiprice,'惠水源扫码购水');
			 $data = array(
			 'shop_id' =>  $shop_id, 
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
			  
			$this->baoSuccess('余额不足，请充值！', U('/mcenter/money'));
			
		  }
		  **/
		 print_r($user);
		 print_r($shuimachine);
		
	}
	
}