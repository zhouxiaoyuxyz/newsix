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
      //print_r($user);
      if($user['money']>$shuiprice){
      	D('Users')->addMoney($user['user_id'],-$shuiprice,'易水源购水');
        print_r($shuiinfo);
      }else{
    	echo "NOMONEY";
   	  }      
    }

	
}