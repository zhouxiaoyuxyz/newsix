<?php



class CommunityshowModel extends CommonModel {

    protected $pk = 'show_id';
    protected $tableName = 'community_show';

    public function _format($data) {
        static $area = null;
        static $business = null;
        if ($area == null) {
            $area = D('Area')->fetchAll();
        }
        if ($business == null) {
            $business = D('Business')->fetchAll();
        }
        $data['area_name'] = $area[$data['area_id']]['area_name'];
        $data['business_name'] = $business[$data['business_id']]['business_name'];
        return $data;
    }
}
