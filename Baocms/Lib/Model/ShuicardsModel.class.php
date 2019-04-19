<?php
class ShuicardsModel extends CommonModel
{
    protected $pk = 'c_id';
    protected $tableName = 'shui_cards';
	
	
	
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