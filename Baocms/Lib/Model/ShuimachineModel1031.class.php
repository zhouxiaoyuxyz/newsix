<?php
class ShuimachineModel extends CommonModel
{
    protected $pk = 'm_id';
    protected $tableName = 'shui_machine';
	
	public function wxlogin()
    {
		
           $state = md5(uniqid(rand(), TRUE));
						session('state', $state);
						if (!empty($_SERVER['REQUEST_URI'])) {
							$backurl = $_SERVER['REQUEST_URI'];
						} else {
							$backurl = U('index/index');
						}
						session('backurl', $backurl);
						$login_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->_CONFIG['weixin']['appid'] . '&redirect_uri=' . urlencode(__HOST__ . U('passport/wxstart')) . '&response_type=code&scope=snsapi_userinfo&state=' . $state . '#wechat_redirect';
						header("location:{$login_url}");
						echo $login_url;
						die;			
        
	}
	
	public function checkonline($sn)
    {
		$url=__HOST__.'/socket/ask.php?card='.$sn;
		$html = file_get_contents($url);
		$fp = fopen('html.txt','w+'); 
				fwrite($fp,var_export($html,true)); 
				fclose($fp);
		if(strpos($html,"OK")){
			return true;
        }else{
			return false;
		}
	}
	
	public function fangshui($sn)
    {
		$url=__HOST__.'/socket/client.php?card='.$sn;
		$html = file_get_contents($url);
		
	}

}