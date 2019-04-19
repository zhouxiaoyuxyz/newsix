<?php
class  FenzhangoldlogsModel extends CommonModel{
    
     protected $pk   = 'log_id';
     protected $tableName =  'fenzhan_gold_logs';
	 
	   public function getType() {
        return array(
            'breaks' => '买单',
            'shui' => '直饮机',
            'community' => '物业费',
            //'4' => '停车费',
            '999' => '未知类型',
        );
    }
    
}