<?php



class CommunityownerModel extends CommonModel{
    protected $pk   = 'owner_id';
    protected $tableName =  'community_owner';
	protected $orderby = array('orderby' => 'asc');

    public function _format($data) {
        static $area = null;
        if ($area == null) {
            $area = D('Area')->fetchAll();
        }
        $data['area_name'] = $area[$data['area_id']]['area_name'];
        return $data;
    }
    
    
}