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
		
	}
	
	public function fangshui($data)
    {			 
		 $url='http://'.$data['ip'].':'.$data['pt'].'/AT+WATER=57';  
		 print_r($url);
		$html = file_get_contents($url);  
		 print_r($html);
		
	}
	
}