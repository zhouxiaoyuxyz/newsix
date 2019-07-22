<?php
class RetailModel extends CommonModel {



    protected $pk = 'retail_id';

    protected $tableName = 'retail';



    public function _format($data) {

        $data['save'] = round(($data['price'] - $data['retail_price']) / 100, 2);

        $data['price'] = round($data['price'] / 100, 2);

        $data['retail_price'] = round($data['retail_price'] / 100, 2);

        $data['mobile_fan'] = round($data['mobile_fan'] / 100, 2);

        $data['settlement_price'] = round($data['settlement_price'] / 100, 2);

        $data['discount'] = round($data['retail_price'] * 10 / $data['price'], 1);

        return $data;

    }

  public function  getParentsId($id){
        $data = $this->fetchAll();
        $parent_id = $data[$id]['parent_id'];
        $parent_id2 = $data[$parent_id]['parent_id'];
        if($parent_id2 == 0) return $parent_id;
        return  $parent_id2;
    }

    public function CallDataForMat($items) { //专门针对CALLDATA 标签处理的

        if (empty($items))

            return array();

        $obj = D('Shop');

        $shop_ids = array();

        foreach ($items as $k => $val) {

            $shop_ids[$val['shop_id']] = $val['shop_id'];

        }

        $shops = $obj->itemsByIds($shop_ids);

        foreach ($items as $k => $val) {

            $val['shop'] = $shops[$val['shop_id']];

            $items[$k] = $val;

        }

        return $items;

    }



}

