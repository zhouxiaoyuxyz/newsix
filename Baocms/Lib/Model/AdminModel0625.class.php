<?php
class AdminModel extends CommonModel{
    protected $pk   = 'admin_id';
    protected $tableName =  'admin';
    
     public function getAdminByUsername($username){
        $data = $this->find(array('where'=>array('username'=>$username)));
        return $this->_format($data);
    }
    
    public  function _format($data){
        static  $roles;
        if(empty($roles)) $roles = D('Role')->fetchAll();
        if(!empty($data)) $data['role_name'] = $roles[$data['role_id']]['role_name'];    
        return $data;
    }
	
	function ip_in_network($ip, $network){  
		$ip = (double) (sprintf("%u", ip2long($ip)));  
		$s = explode('/', $network);  
		$network_start = (double) (sprintf("%u", ip2long($s[0])));  
		$network_len = pow(2, 32 - $s[1]);  
		$network_end = $network_start + $network_len - 1;  
		
	   p($ip.'--'.$network_start.'--------'.$network_end);die;
		if ($ip >= $network_start && $ip <= $network_end)  {  
			return true;  
		}  
		return false;  
	}

		//写入管理员金块
	  public function Money($admin_id, $id, $num, $intro = '',$type, $user_id){
        if ($this->updateCount($admin_id, 'gold', $num)) {
			if($type=='breaks'){
				 $result=D('Fenzhangoldlogs')->add(array(
					'admin_id' => $admin_id, 
					'city_id' => $id, 
					'type' => $type, 
					'user_id' => $user_id, 
					'gold' => $num, 
					'intro' => $intro, 
					'create_time' => NOW_TIME, 
					'create_ip' => get_client_ip()
				));
				$fp = fopen('result233.txt','w+'); 
				fwrite($fp,var_export($result,true)); 
				fclose($fp);
				return $result;
			}else{
				return D('Wuyegoldlogs')->add(array(
					'admin_id' => $admin_id, 
					'community_id' => $id, 
					'gold' => $num, 
					'intro' => $intro, 
					'create_time' => NOW_TIME, 
					'create_ip' => get_client_ip()
				));
			}
        }
        return false;
    }
}