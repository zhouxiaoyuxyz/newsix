<?php
class ShuilocationmapModel extends CommonModel
{
    protected $pk = 'id';
    protected $tableName = 'shuilocation_map';
    public function Adddata($machine_id,$order_id){
        $shuimachine=D('Shuimachine')->find($machine_id);
        $result=D('Shuilocationmap')->add(array(
        'admin_id' => $shuimachine['admin_id'], 
        'machine_id' => $shuimachine['machine_id'], 
        'city_id' => $shuimachine['admin_id'], 
        'area_id' => $shuimachine['area_id'],  
        'model' => $shuimachine['model'], 
        'm_sn' => $shuimachine['m_sn'],  
        'order_id' => $order_id, 
        'type' => 'shui', 
        'create_time' => NOW_TIME
      ));
        return $result;
    }

}