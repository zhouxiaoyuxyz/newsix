<?php



class CommunitymanagerModel extends CommonModel {

    protected $pk = 'id';
    protected $tableName = 'community_manager';

    public function _format($data) {
        static $area = null;
        if ($area == null) {
            $area = D('Area')->fetchAll();
        }
        $data['area_name'] = $area[$data['area_id']]['area_name'];
        return $data;
    }

    
}
