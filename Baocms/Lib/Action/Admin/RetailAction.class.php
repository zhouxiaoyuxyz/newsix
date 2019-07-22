<?php

/*
 * 增加限购
 * by QQ 86313535
 */

class RetailAction extends CommonAction { //按逻辑  instructions  和  details 要分表出去

    private $create_fields = array('m_sn','m_way','shop_id', 'orderby', 'use_integral', 'cate_id', 'intro', 'title', 'photo', 'thumb', 'price', 'retail_price', 'settlement_price','third_profit','mobile_fan', 'num', 'sold_num', 'bg_date', 'end_date', 'fail_date', 'is_hot', 'is_new', 'is_chose', 'freebook','xiadan','xiangou', 'activity_id', 'branch_id','profit_enable','profit_rate1','profit_rate2','profit_rate3','profit_rank_id');
    private $edit_fields = array('m_sn','m_way','shop_id', 'orderby', 'use_integral', 'cate_id', 'intro', 'title', 'photo', 'thumb', 'price', 'retail_price', 'settlement_price','third_profit','mobile_fan', 'num', 'sold_num', 'bg_date', 'end_date', 'fail_date', 'is_hot', 'is_new', 'is_chose', 'freebook','xiadan','xiangou', 'activity_id', 'branch_id','profit_enable','profit_rate1','profit_rate2','profit_rate3','profit_rank_id');

    public function _initialize() {
        parent::_initialize();
        $this->Tuancates = D('Retailcate')->fetchAll();
        $this->assign('cates', $this->Tuancates);
        $this->assign('ranks',D('Userrank')->fetchAll());
    }
    public function index() {
        $Retail = D('Retail');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        if ($cate_id = (int) $this->_param('cate_id')) {
            $map['cate_id'] = array('IN', D('Retailcate')->getChildren($cate_id));
            $this->assign('cate_id', $cate_id);
        }
        if ($shop_id = (int) $this->_param('shop_id')) {
            $map['shop_id'] = $shop_id;
            $shop = D('Shop')->find($shop_id);
            $this->assign('shop_name', $shop['shop_name']);
            $this->assign('shop_id', $shop_id);
        }
        if ($audit = (int) $this->_param('audit')) {
            $map['audit'] = ($audit === 1 ? 1 : 0);
            $this->assign('audit', $audit);
        }
        $count = $Retail->where($map)->count(); // 查询满足要求的总记录数
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Retail->where($map)->order(array('retail_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($list as $k => $val) {
            if ($val['shop_id']) {
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $val['create_ip_area'] = $this->ipToArea($val['create_ip']);
            $val = $Retail->_format($val);
            $list[$k] = $val;
        }
        if ($shop_ids) {
            $this->assign('shops', D('Shop')->itemsByIds($shop_ids));
        }
        $this->assign('cates', D('Retailcate')->fetchAll());
        $this->assign('list', $list); // 赋值数据集www.hatudou.com  二开开发qq  120585022
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function branch($shop_id){
        $shop_id = (int)$shop_id;
        $branch = D('Shopbranch')->where(array('shop_id' => $shop_id, 'closed' => 0, 'audit' => 1))->select();
        $str = "";
        foreach($branch as $k=>$val){
            $str += '<label style="margin-right: 10px;"><span><{$val.name}>：</span><input style="width: 20px; height: 20px;" type="checkbox" name="branch_id[]" value="<{$val.branch_id}>" /></label>';
        }
        $this->ajaxReturn(array('status'=>'0','str'=>$str));
    }

    public function create() {
        if ($this->isPost()) {
            $data = $this->createCheck();
            $obj = D('Retail');
            $details = $this->_post('details', 'SecurityEditorHtml');
            if (empty($details)) {
              //  $this->baoError('抢购详情不能为空');
            }
            if ($words = D('Sensitive')->checkWords($details)) {
                $this->baoError('详细内容含有敏感词：' . $words);
            }
            $instructions = $this->_post('instructions', 'SecurityEditorHtml');
            if (empty($instructions)) {
               // $this->baoError('购买须知不能为空');
            }
            if ($words = D('Sensitive')->checkWords($instructions)) {
                $this->baoError('购买须知含有敏感词：' . $words);
            }
            $branch_id = $this->_post('branch_id', false);
            /*foreach ($branch_id as $k => $val) {
                if (!$brdetail = D('Shopbranch')->find($val)) {
                    unset($branch_id[$k]);
                }
                if ($brdetail['shop_id'] != $this->shop_id) {
                    unset($branch_id[$k]);
                }
            }*/
            $branch = implode(',', $branch_id);
            $data['branch_id'] = $branch;
            $thumb = $this->_param('thumb', false);
            foreach ($thumb as $k => $val) {
                if (empty($val)) {
                    unset($thumb[$k]);
                }
                if (!isImage($val)) {
                    unset($thumb[$k]);
                }
            }
            $data['thumb'] = serialize($thumb);
            if ($retail_id = $obj->add($data)) {
                $wei_pic = D('Weixin')->getCode($retail_id, 2); //抢购类型是2
                $obj->save(array('retail_id' => $retail_id, 'wei_pic' => $wei_pic));
                D('Retaildetails')->add(array('retail_id' => $retail_id, 'details' => $details, 'instructions' => $instructions));
                $this->baoSuccess('添加成功', U('retail/index'));
            }
            $this->baoError('操作失败！');
        } else {
            $this->display();
        }
    }

    private function createCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
       // $data['shop_id'] = (int) $data['shop_id'];
       // if (empty($data['shop_id'])) {
       //     $this->baoError('商家不能为空');
       // }
        $data['m_sn'] = htmlspecialchars($data['m_sn']);
        if (empty($data['m_sn'])) {
            $this->baoError('机器编号不能为空');
        }
        $data['m_way'] = (int) $data['m_way'];
        if (empty($data['m_way'])) {
            $this->baoError('机器货道不能为空');
        }
       // $shop = D('Shop')->find($data['shop_id']);
       // if (empty($shop)) {
       //     $this->baoError('请选择正确的商家');
       // }
        $data['city_id'] = (int) $data['city_id'];
        $data['area_id'] = (int) $data['area_id'];
        if (empty($data['area_id'])) {
            $this->baoError('所在区域不能为空');
        }
        $data['business_id'] = (int) $data['business_id'];
        if (empty($data['business_id'])) {
            $this->baoError('所在商圈不能为空');
        }
        $data['cate_id'] = (int) $data['cate_id'];
        if (empty($data['cate_id'])) {
            $this->baoError('零售分类不能为空');
        }
        $Retailcate = D('Retailcate')->where(array('cate_id' => $data['cate_id']))->find();
        $parent_id = $Retailcate['parent_id'];
        if ($parent_id == 0) {
            $this->baoError('请选择二级分类');
        }

        //$data['lng'] = $shop['lng'];
        //$data['lat'] = $shop['lat'];
        // $data['city_id'] = $shop['city_id'];
        //$data['area_id'] = $shop['area_id'];
        //$data['business_id'] = $shop['business_id'];

        $data['title'] = htmlspecialchars($data['title']);
        if (empty($data['title'])) {
            $this->baoError('商品名称不能为空');
        }
        $data['intro'] = htmlspecialchars($data['intro']);
        if (empty($data['intro'])) {
            $this->baoError('副标题不能为空');
        }
        $data['photo'] = htmlspecialchars($data['photo']);
        if (empty($data['photo'])) {
            $this->baoError('请上传图片');
        }
        if (!isImage($data['photo'])) {
            $this->baoError('图片格式不正确');
        }
        $data['price'] = (int) ($data['price'] * 100);
        if (empty($data['price'])) {
            $this->baoError('市场价格不能为空');
        }
        $data['retail_price'] = (int) ($data['retail_price'] * 100);
        if (empty($data['retail_price'])) {
            $this->baoError('零售价格不能为空');
        }
        $data['settlement_price'] = (int) ($data['settlement_price'] * 100);
        //if (empty($data['settlement_price'])) {
        //    $this->baoError('结算价格不能为空');
        // }
        $data['third_profit'] = (int) ($data['third_profit'] * 100);
        $data['mobile_fan'] = (int) ($data['mobile_fan'] * 100);
        // if($data['mobile_fan'] < 0 || $data['mobile_fan'] >= $data['settlement_price']){
        //     $this->baoError('手机下单优惠金额不正确！');
        // }
        $data['use_integral'] = (int) $data['use_integral'];

        $data['num'] = (int) $data['num'];
        if (empty($data['num'])) {
            $this->baoError('库存不能为空');
        } $data['sold_num'] = (int) $data['sold_num'];

        $data['bg_date'] = htmlspecialchars($data['bg_date']);
        if (empty($data['bg_date'])) {
            $this->baoError('开始时间不能为空');
        }
        if (!isDate($data['bg_date'])) {
            $this->baoError('开始时间格式不正确');
        } $data['end_date'] = htmlspecialchars($data['end_date']);
        if (empty($data['end_date'])) {
            $this->baoError('结束时间不能为空');
        }
        if (!isDate($data['end_date'])) {
            $this->baoError('结束时间格式不正确');
        }
        $data['is_hot'] = (int) $data['is_hot'];
        $data['is_new'] = (int) $data['is_new'];
        $data['is_chose'] = (int) $data['is_chose'];
        $data['freebook'] = (int) $data['freebook'];
        $data['is_return_cash'] = (int) $data['is_return_cash'];
        $data['xiadan'] = (int) $data['xiadan'];
        $data['xiangou'] = (int) $data['xiangou'];
        $data['fail_date'] = htmlspecialchars($data['fail_date']);
        $data['create_time'] = NOW_TIME;
        $data['create_ip'] = get_client_ip();
        $data['orderby'] = (int) $data['orderby'];
        $data['profit_enable'] = (int) $data['profit_enable'];
        $data['profit_rate1'] = (int) $data['profit_rate1'];
        $data['profit_rate2'] = (int) $data['profit_rate2'];
        $data['profit_rate3'] = (int) $data['profit_rate3'];
        $data['profit_prestige'] = (int) $data['profit_prestige'];
        return $data;
    }

    public function edit($retail_id = 0) {
        if ($retail_id = (int) $retail_id) {
            $obj = D('Retail');
            if (!$detail = $obj->find($retail_id)) {
                $this->baoError('请选择要编辑的零售');
            }
            $retail_details = D('Retaildetails')->getDetail($retail_id);

            if ($this->isPost()) {
                $data = $this->editCheck();
                $details = $this->_post('details', 'SecurityEditorHtml');
                if (empty($details)) {
                    //$this->baoError('抢购详情不能为空');
                }
                if ($words = D('Sensitive')->checkWords($details)) {
                    $this->baoError('详细内容含有敏感词：' . $words);
                }
                $instructions = $this->_post('instructions', 'SecurityEditorHtml');
                if (empty($instructions)) {
                   // $this->baoError('购买须知不能为空');
                }
                if ($words = D('Sensitive')->checkWords($instructions)) {
                    $this->baoError('购买须知含有敏感词：' . $words);
                }
                $thumb = $this->_param('thumb', false);
                foreach ($thumb as $k => $val) {
                    if (empty($val)) {
                        unset($thumb[$k]);
                    }
                    if (!isImage($val)) {
                        unset($thumb[$k]);
                    }
                }
                $data['thumb'] = serialize($thumb);
                $branch_id = $this->_post('branch_id', false);
               /* foreach ($branch_id as $val) {
                    if (!$brdetail = D('Shopbranch')->find($val)) {
                        unset($val);
                    }
                    if ($brdetail['shop_id'] != $this->shop_id) {
                        unset($val);
                    }
                }*/
                $branch = implode(',', $branch_id);
                $data['branch_id'] = $branch;
                $data['retail_id'] = $retail_id;
                if (!empty($detail['wei_pic'])) {
                    if (true !== strpos($detail['wei_pic'], "https://mp.weixin.qq.com/")) {
                        $wei_pic = D('Weixin')->getCode($retail_id, 2);
                        $data['wei_pic'] = $wei_pic;
                    }
                } else {
                    $wei_pic = D('Weixin')->getCode($retail_id, 2);
                    $data['wei_pic'] = $wei_pic;
                }
                $ex = array(
                    'retail_id' => $retail_id,
                    'details' => $details,
                    'instructions' => $instructions,
                );
                if (false !== $obj->save($data)) {
                    D('Retaildetails')->save($ex);
                    $this->baoSuccess('操作成功', U('retail/index'));
                }
                $this->baoError('操作失败');
            } else {
                $branch = D('Shopbranch')->where(array('shop_id' => $detail['shop_id'], 'closed' => 0, 'audit' => 1))->select();
                $this->assign('branch', $branch);
                $hd = D('Activity')->order(array('orderby' => 'asc'))->where(array('shop_id'=>$detail['shop_id'],'bg_date' => array('ELT', TODAY), 'end_date' => array('EGT', TODAY), 'sign_end' => array('EGT', TODAY), 'closed' => 0, 'audit' => 1))->select();
                $this->assign('hd',$hd);
                $this->assign('detail', $obj->_format($detail));
                $thumb = unserialize($detail['thumb']);
                $this->assign('thumb', $thumb);
                $this->assign('shop', D('Shop')->find($detail['shop_id']));
                $this->assign('retail_details', $retail_details);
                $branch_id = explode(',', $detail['branch_id']);
                $this->assign('branch_id', $branch_id);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的零售');
        }
    }

    private function editCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->edit_fields);
        //$data['shop_id'] = (int) $data['shop_id'];
       // if (empty($data['shop_id'])) {
        //    $this->baoError('商家不能为空');
       // }
        $data['m_sn'] = htmlspecialchars($data['m_sn']);
        if (empty($data['m_sn'])) {
            $this->baoError('机器编号不能为空');
        }
        $data['m_way'] = (int) $data['m_way'];
        if (empty($data['m_way'])) {
            $this->baoError('机器货道不能为空');
        }
        $data['city_id'] = (int) $data['city_id'];
        $data['area_id'] = (int) $data['area_id'];
        if (empty($data['area_id'])) {
            $this->baoError('所在区域不能为空');
        }
        $data['business_id'] = (int) $data['business_id'];
        if (empty($data['business_id'])) {
            $this->baoError('所在商圈不能为空');
        }
        //$shop = D('Shop')->find($data['shop_id']);
        //if (empty($shop)) {
        //    $this->baoError('请选择正确的商家');
        //}
        $data['cate_id'] = (int) $data['cate_id'];
        if (empty($data['cate_id'])) {
            $this->baoError('零售分类不能为空');
        }

        $Retailcate = D('Retailcate')->where(array('cate_id' => $data['cate_id']))->find();
        $parent_id = $Retailcate['parent_id'];
        if ($parent_id == 0) {
            $this->baoError('请选择二级分类');
        }


        //$data['lng'] = $shop['lng'];
        //$data['lat'] = $shop['lat'];
        //$data['city_id'] = $shop['city_id'];
        //$data['area_id'] = $shop['area_id'];
        //$data['business_id'] = $shop['business_id'];
        $data['title'] = htmlspecialchars($data['title']);
        if (empty($data['title'])) {
            $this->baoError('商品名称不能为空');
        }
        $data['intro'] = htmlspecialchars($data['intro']);
        if (empty($data['intro'])) {
            $this->baoError('副标题不能为空');
        }
        $data['photo'] = htmlspecialchars($data['photo']);
        if (empty($data['photo'])) {
            $this->baoError('请上传图片');
        }
        if (!isImage($data['photo'])) {
            $this->baoError('图片格式不正确');
        }$data['price'] = (int) ($data['price'] * 100);
        if (empty($data['price'])) {
            $this->baoError('市场价格不能为空');
        } $data['retail_price'] = (int) ($data['retail_price'] * 100);
        if (empty($data['retail_price'])) {
            $this->baoError('零售价格不能为空');
        }
        $data['settlement_price'] = (int) ($data['settlement_price'] * 100);
        //if (empty($data['settlement_price'])) {
        //    $this->baoError('结算价格不能为空');
        //}
        $data['third_profit'] = (int) ($data['third_profit'] * 100);
        $data['mobile_fan'] = (int) ($data['mobile_fan'] * 100);
        //if($data['mobile_fan'] < 0 || $data['mobile_fan'] >= $data['settlement_price']){
        //    $this->baoError('手机下单优惠金额不正确！');
        //}
        $data['use_integral'] = (int) $data['use_integral'];
        $data['num'] = (int) $data['num'];
        if (empty($data['num'])) {
            $this->baoError('库存不能为空');
        } $data['sold_num'] = (int) $data['sold_num'];
        $data['bg_date'] = htmlspecialchars($data['bg_date']);
        if (empty($data['bg_date'])) {
            $this->baoError('开始时间不能为空');
        }
        if (!isDate($data['bg_date'])) {
            $this->baoError('开始时间格式不正确');
        } $data['end_date'] = htmlspecialchars($data['end_date']);
        if (empty($data['end_date'])) {
            $this->baoError('结束时间不能为空');
        }
        if (!isDate($data['end_date'])) {
            $this->baoError('结束时间格式不正确');
        }
        $data['is_hot'] = (int) $data['is_hot'];
        $data['is_new'] = (int) $data['is_new'];
        $data['is_chose'] = (int) $data['is_chose'];
        $data['freebook'] = (int) $data['freebook'];
        $data['is_return_cash'] = (int) $data['is_return_cash'];

        $data['xiadan'] = (int) $data['xiadan'];
        $data['xiangou'] = (int) $data['xiangou'];
        $data['fail_date'] = htmlspecialchars($data['fail_date']);
        $data['orderby'] = (int) $data['orderby'];
        $data['profit_enable'] = (int) $data['profit_enable'];
        $data['profit_rate1'] = (int) $data['profit_rate1'];
        $data['profit_rate2'] = (int) $data['profit_rate2'];
        $data['profit_rate3'] = (int) $data['profit_rate3'];
        $data['profit_prestige'] = (int) $data['profit_prestige'];
        return $data;
    }

    public function delete($retail_id = 0) {
        if (is_numeric($retail_id) && ($retail_id = (int) $retail_id)) {
            $obj = D('Retail');
            $obj->save(array('retail_id' => $retail_id, 'closed' => 1));
            $this->baoSuccess('删除成功！', U('retail/index'));
        } else {
            $retail_id = $this->_post('retail_id', false);
            if (is_array($retail_id)) {
                $obj = D('Retail');
                foreach ($retail_id as $id) {
                    $obj->save(array('retail_id' => $id, 'closed' => 1));
                }
                $this->baoSuccess('删除成功！', U('retail/index'));
            }
            $this->baoError('请选择要删除的零售');
        }
    }

    public function audit($retail_id = 0) {
        if (is_numeric($retail_id) && ($retail_id = (int) $retail_id)) {
            $obj = D('Retail');
            $obj->save(array('retail_id' => $retail_id, 'audit' => 1));
            $this->baoSuccess('审核成功！', U('retail/index'));
        } else {
            $retail_id = $this->_post('retail_id', false);
            if (is_array($retail_id)) {
                $obj = D('Retail');
                foreach ($retail_id as $id) {
                    $obj->save(array('retail_id' => $id, 'audit' => 1));
                }
                $this->baoSuccess('审核成功！', U('retail/index'));
            }
            $this->baoError('请选择要审核的零售');
        }
    }
    /**
     * 设置为爆款
     * @param int $retail_id
     */
    public function sethot($retail_id = 0) {
        if (is_numeric($retail_id) && ($retail_id = (int) $retail_id)) {
            $obj = D('Retail');
            $obj->save(array('retail_id' => $retail_id, 'hot_time' => NOW_TIME));
            $this->baoSuccess('设置爆款成功！', U('retail/index'));
        }
    }

    public function cancel($retail_id = 0) {
        if (is_numeric($retail_id) && ($retail_id = (int) $retail_id)) {
            $obj = D('Retail');
            $obj->save(array('retail_id' => $retail_id, 'is_seckill' => 0));
            $this->baoSuccess('秒杀活动取消成功！', U('retail/index'));
        } else {
            $retail_id = $this->_post('retail_id', false);
            if (is_array($retail_id)) {
                $obj = D('Tuan');
                foreach ($retail_id as $id) {
                    $obj->save(array('retail_id' => $id, 'audit' => 0));
                }
                $this->baoSuccess('秒杀活动取消成功！', U('retail/index'));
            }
            $this->baoError('请选择要取消秒杀的零售');
        }
    }

}
