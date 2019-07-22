<?php
class ThirdgoldlogsModel extends CommonModel{
    
     protected $pk   = 'log_id';
     protected $tableName =  'third_gold_logs';

     public function getType()
     {
         return array(
             'breaks' => '优惠买单',
             'shui' => '直饮机',
             'activity' => '周末去哪',
             'retail' => '智能零售',
             'tuan' => '六享e仓',
             'other' => '其他活动'
         );
     }
}