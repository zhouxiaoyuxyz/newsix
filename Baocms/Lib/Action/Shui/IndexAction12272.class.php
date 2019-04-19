<?php
class IndexAction extends CommonAction
{
    public function index()
    {
      $shuicar_id = $this->_get('ID');
		$fp = fopen('aa.txt','w+'); 
		fwrite($fp,var_export($shuicar_id,true)); 
		fclose($fp);
      $config = D('Setting')->fetchAll();
      	$shuiinfo=$config['site']['shuiinfo'];
      $shuiprice=$config['site']['shuiprice']*100;
      $map['shuicar1|shuicar2'] = $shuicar_id;
      $user=D('Users')->where($map)->find();
	   $shop_id=42;
	   $amount=$config['site']['shuiprice'];
	   $money = D('Shopyouhui')->get_amount($shop_id, $amount, $exception);
	   $fx_money=  round(($amount-$money) , 2);
      //print_r($user);
      if($user['money']>$shuiprice){
      	D('Users')->addMoney($user['user_id'],-$shuiprice,'易水源购水');
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
        print_r($data);
        print_r($order_id);
      }else{
    	echo "NOMONEY";
   	  }      
    }

	
}