<?php
class LifeAction extends CommonAction
{
    protected $lifecate = array();
    private $create_fields = array('title', 'city_id', 'cate_id', 'area_id', 'business_id', 'text1', 'text2', 'text3', 'num1', 'num2', 'select1', 'select2', 'select3', 'select4', 'select5', 'photo', 'contact', 'mobile', 'qq', 'addr', 'lng', 'lat');
    private $create_zpfields = array('title','city_id', 'cate_id', 'area_id', 'business_id','select1', 'select2', 'select3','photo', 'contact', 'mobile', 'weixin', 'addr', 'sfqz','full_salary','sfdr','depo_cash','sfjbx','half_salary','zwlb','worktime');
    // private $create_zpfields = array('title','cate_id','city_id','user_id','urgent_date','top_date','photo','contact','mobile','weixin','addr','create_time','create_ip','last_time','audit','sfqz','full_salary','sfdr','depo_cash','sfjbx','half_salary');

    public function _initialize()
    {
        parent::_initialize();
        $life = (int)$this->_CONFIG['operation']['life'];
        if ($life == 0) {
            $this->error('此功能已关闭');
            die;
        }
        $this->lifecate = D('Lifecate')->fetchAll();
        $this->lifechannel = D('Lifecate')->getChannelMeans();
        $this->assign('lifecate', $this->lifecate);
        $this->assign('channel', $this->lifechannel);
        $this->cates = D('Lifecate')->fetchAll();
        $this->assign('cates', $this->cates);
        $life_code = session('life_code');
        //获取life_code
    }

    public function index()
    {
        foreach ($this->lifechannel as $k => $channel) {
            foreach ($this->lifecate as $k1 => $cate) {
                if ($k == $cate['channel_id']) {
                    $list[$k]['cate'][] = $cate;
                    if (!isset($list[$k]['channel'])) {
                        $list[$k]['channel'] = $channel;
                    }
                }
            }
        }
        $this->assign('list', $list);
        $this->display();
        // 输出模板
    }

    //发布分类信息
    public function release()
    {
        foreach ($this->lifechannel as $k => $channel) {
            foreach ($this->lifecate as $k1 => $cate) {
                if ($k == $cate['channel_id']) {
                    $list[$k]['cate'][] = $cate;
                    if (!isset($list[$k]['channel'])) {
                        $list[$k]['channel'] = $channel;
                    }
                }
            }
        }
        $this->assign('list', $list);
        $this->display();
        // 输出模板
    }

    public function channel()
    {
        $map = $linkArr = array();
        if ($channel = (int)$this->_param('channel')) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
            if (!empty($cates_ids)) {
                $map['cate_id'] = array('IN', $cates_ids);
            }
            $this->assign('cates_ids', $cates_ids);
            $this->assign('channel_id', $channel);
            $linkArr['channel'] = $channel;
        }
        $this->assign('linkArr', $linkArr);
        $linkArr['p'] = '0000';
        $this->assign('nextpage', U('life/load', $linkArr));
        $this->display();
        // 输出模板
    }

    public function load()
    {
        $Life = D('Life');
        import('ORG.Util.Page');
        // 导入分页类
        $map = array('audit' => 1, 'city_id' => $this->city_id, 'closed' => 0);
        if ($channel = (int)$this->_param('channel')) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
        }
        if (!empty($cates_ids)) {
            $map['cate_id'] = array('IN', $cates_ids);
        } else {
            die('0');
        }
        $count = $Life->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function lists()
    {
        $cat = (int)$this->_param('cat');
        $cate = $this->lifecate[$cat];
        if (empty($cate)) {
            $this->error('请选择分类！');
        }
        $linkArr = array('cat' => $cat, 'area' => 0, 's1' => 0, 's2' => 0, 's3' => 0, 's4' => 0, 's5' => 0);
        $this->assign('cate', $cate);
        $attrs = D('Lifecateattr')->getAttrs($cat);
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($cate['select' . $i])) {
                $s[$i] = (int)$this->_param('s' . $i);
                if ($attrs['select' . $i][$s[$i]]) {
                    $map['select' . $i] = $s[$i];
                    $this->assign('s' . $i, $s[$i]);
                    $linkArr['s' . $i] = $s[$i];
                }
            }
        }
        $area = (int)$this->_param('area');
        if (!empty($area)) {
            $linkArr['area'] = $area;
            $this->assign('area', $area);
        }
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('city_id', $this->city_id);
        //查询城市
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('attrs', $attrs);
        $this->assign('linkArr', $linkArr);
        $linkArr['p'] = '0000';
        $this->assign('nextpage', U('life/loaddata', $linkArr));
        $this->display();
        // 输出模板
    }

    public function loaddata()
    {
        $Life = D('Life');
        import('ORG.Util.Page');
        $map = array('city_id' => $this->city_id, 'audit' => 1, 'closed' => 0);
        $cat = (int)$this->_param('cat');
        $cate = $this->lifecate[$cat];
        if (empty($cate)) {
            $this->error('请选择分类！1');
        }
        $linkArr = array('cat' => $cat, 'area' => 0, 's1' => 0, 's2' => 0, 's3' => 0, 's4' => 0, 's5' => 0);
        $this->assign('cate', $cate);
        $map['cate_id'] = $cat;
        $attrs = D('Lifecateattr')->getAttrs($cat);
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($cate['select' . $i])) {
                $s[$i] = (int)$this->_param('s' . $i);
                if ($attrs['select' . $i][$s[$i]]) {
                    $map['select' . $i] = $s[$i];
                    //解决搜索问题
                    $this->assign('s' . $i, $s[$i]);
                    $linkArr['s' . $i] = $map['select' . $i] = $s[$i];
                }
            }
        }
        $area = (int)$this->_param('area');
        if (!empty($area)) {
            $map['area_id'] = $area;
            $this->assign('area', $area);
        }
        $count = $Life->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('attrs', $attrs);
        $this->assign('linkArr', $linkArr);
        $this->display();
        // 输出模板
    }

    public function detail($life_id)
    {
        if (empty($life_id)) {
            $this->error('参数错误');
        }
        if (!($detail = D('Life')->find($life_id))) {
            $this->error('该消息不存在或者已经删除！');
        }
        if ($detail['audit'] != 1) {
            $this->error('该消息不存在或者已经删除！');
        }
        if ($detail['closed'] != 0) {
            $this->error('该消息不存在或者已经删除！');
        }
        $cate = $this->lifecate[$detail['cate_id']];
        if (empty($cate)) {
            $this->error('该信息不能正常显示！');
        }
        D('Life')->updateCount($life_id, 'views');
        $this->assign('cate', $cate);
        $this->assign('city_id', $this->city_id);
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('detail', $detail);
        $this->assign('ex', D('Lifedetails')->find($life_id));
        $this->assign('attrs', $attrs = D('Lifecateattr')->getAttrs($detail['cate_id']));
        $ex = D('Lifedetails')->find($detail['life_id']);
        $chl = D('Lifecate')->getChannelMeans();
        $this->seodatas['title'] = $detail['title'];
        $this->seodatas['channel'] = $chl[$this->cates[$detail['cate_id']]['channel_id']];
        $this->seodatas['cate'] = $this->cates[$detail['cate_id']]['cate_name'];
        if (!empty($detail['num2'])) {
            $this->seodatas['num'] = $detail['num2'];
        } else {
            $this->seodatas['num'] = $detail['num1'];
        }
        if (!empty($detail['text1'])) {
            $this->seodatas['text1'] = $detail['text1'];
        } else {
            $this->seodatas['text1'] = '最新';
        }
        if (!empty($ex[details])) {
            $this->seodatas['desc'] = bao_Msubstr($ex['details'], 0, 200, false);
        } else {
            $this->seodatas['desc'] = $detail['title'];
        }
        //二次开发结束
        $this->assign('pics', D('Lifephoto')->getPics($detail['life_id']));
        //调用图片
        $this->display();
    }

    public function fabu($cat)
    {
        if (empty($this->uid)) {
            $this->error('您还未登录', U('passport/login'));
        }
        $cat = (int)$cat;
        $cate = $this->lifecate[$cat];
        if (empty($cate)) {
            $this->display('post');
        }
        if ($this->isPost()) {
            $data = $this->createCheck();
            $shop = D('Shop')->find(array("where" => array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1)));
            if ($shop) {
                $data['is_shop'] = 1;
            }
            $data['user_id'] = $this->uid;
            $data['city_id'] = $this->city_id;
            $data['cate_id'] = $cat;
            $details = $this->_post('details', 'SecurityEditorHtml');
            if ($words = D('Sensitive')->checkWords($details)) {
                $this->fengmiMsg('商家介绍含有敏感词：' . $words);
            }
            // 订阅发送短信
            $models = M('shop_dingyue_set');//这里按理应该用D函数好一点
            $sms_open = $models->getField('sms_open');
            $sms_number = $models->getField('sms_number');
            if ($life_id = D('Life')->add($data)) {
                if ($details) {
                    D('Lifedetails')->updateDetails($life_id, $details);
                }
                $photos = $this->_post('photo', false);
                if (!empty($photos)) {
                    D('Lifephoto')->upload($life_id, $photos);
                }

                // 订阅发送短信 start  2016/04/13
                if ($sms_open == 1) {//检索关键字cate_id  和 city_id
                    $attr_id = $data['select1'];
                    $business_id = $data['business_id']; //去检索，如果订阅的有
                    $mapd['status'] = 1; //未删除
                    $mapd['audit'] = 1; //审核通过的，发送
                    $mapd['catlist'] = array('LIKE', '%,' . $attr_id);
                    $mapd['sitelist'] = array('LIKE', '%,' . $business_id);
                    $modeld = M('shop_dingyue');
                    $dingyuelist = $modeld->where($mapd)->select();
                    $count = $modeld->where($mapd)->count();
                    if (empty($dingyuelist)) {
                        $attr_id = $data['select2'];
                        $business_id = $data['business_id'];//去检索，如果订阅的有
                        $mapd['status'] = 1; //未删除
                        $mapd['audit'] = 1; //审核通过的，发送
                        $mapd['catlist'] = array('LIKE', '%,' . $attr_id);
                        $mapd['sitelist'] = array('LIKE', '%,' . $business_id);
                        $modeld = M('shop_dingyue');
                        $dingyuelist = $modeld->where($mapd)->select();
                        $count = $modeld->where($mapd)->count();
                    }
                    if (empty($dingyuelist)) {
                        $attr_id = $data['select3'];
                        $business_id = $data['business_id'];
                        //去检索，如果订阅的有
                        $mapd['status'] = 1;//未删除
                        $mapd['audit'] = 1;//审核通过的，发送

                        $mapd['catlist'] = array('LIKE', '%,' . $attr_id);
                        $mapd['sitelist'] = array('LIKE', '%,' . $business_id);
                        $modeld = M('shop_dingyue');
                        $dingyuelist = $modeld->where($mapd)->select();
                        $count = $modeld->where($mapd)->count();
                    }
                    if ($count) {
                        foreach ($dingyuelist as $k => $v) {
                            //判断数目是否超过，管理员设定的短信数目
                            if ($v['sms_number'] < $sms_number) {
                                //循环判断该类是否开通短信
                                if ($v['sms'] == 1) {
                                    $modelu = M('users');
                                    $mapu['user_id'] = $v['uid'];
                                    $mobile = $modelu->where($mapu)->getField('mobile');
                                    if ($mobile) {
                                        //大鱼发送分类信息短信
                                        if ($this->_CONFIG['sms']['dxapi'] == 'dy') {
                                            D('Sms')->DySms($this->_CONFIG['site']['sitename'], 'sms_life_dingyue_tongzhi_user', $mobile, array(
                                                'sitename' => $this->_CONFIG['site']['sitename'],
                                                'title' => $data['title'],
                                                'user_name' => $data['contact'],
                                                'user_mobile' => $data['mobile']
                                            ));
                                        } else {
                                            D('Sms')->sendSms('sms_code', $mobile, array(
                                                'sitename' => $this->_CONFIG['site']['sitename'],
                                                'title' => $data['title'],
                                                'user_name' => $data['contact'],
                                                'user_mobile' => $data['mobile']
                                            ));
                                        }
                                        //发送短信，同时数目+1
                                        $model = M('shop_dingyue');
                                        $data['sms_number'] = $dingyuelist[$k]['sms_number'] + 1;
                                        $map['dingyue_id'] = $dingyuelist[$k]['dingyue_id'];
                                        $result = $model->where($map)->save($data);
                                        $this->fengmiMsg('手机发送成功！', U('members/life'));
                                    }

                                }

                            }

                        }
                    }
                }
                $this->fengmiMsg('发布信息成功，通过审核后将会显示！', U('life/index'));
            }
            $this->fengmiMsg('发布信息失败！');
        } else {
            $lat = cookie('lat');
            $lng = cookie('lng');
            if (empty($lat) || empty($lng)) {
                $lat = $this->_CONFIG['site']['lat'];
                $lng = $this->_CONFIG['site']['lng'];
            }
            $this->assign('areas', D('Area')->fetchAll());
            $this->assign('business', D('Business')->fetchAll());
            $this->assign('cate', $cate);
            $attrs = D('Lifecateattr')->getAttrs($cat);
            $this->assign('attrs', $attrs);
            $this->assign('lng', $lng);
            $this->assign('lat', $lat);
            if (!empty($cate)) {
                $this->display('');
            }
        }
    }

    private function createCheck()
    {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['title'] = htmlspecialchars($data['title']);
        if (empty($data['title'])) {
            $this->fengmiMsg('标题不能为空');
        }
        $data['area_id'] = (int)$data['area_id'];
        if (empty($data['area_id'])) {
            $this->fengmiMsg('地区不能为空');
        }
        $data['business_id'] = (int)$data['business_id'];
        if (empty($data['business_id'])) {
            $this->fengmiMsg('商圈不能为空');
        }
        $data['photo'] = htmlspecialchars($data['photo']);
        if (!empty($data['photo']) && !isImage($data['photo'])) {
            $this->fengmiMsg('缩略图格式不正确');
        }
        $data['lng'] = htmlspecialchars(trim($data['lng']));
        $data['lat'] = htmlspecialchars(trim($data['lat']));
        $data['text1'] = htmlspecialchars($data['text1']);
        $data['text2'] = htmlspecialchars($data['text2']);
        $data['text3'] = htmlspecialchars($data['text3']);
        $data['num1'] = (int)$data['num1'];
        $data['num2'] = (int)$data['num2'];
        $data['select1'] = (int)$data['select1'];
        $data['select2'] = (int)$data['select2'];
        $data['select3'] = (int)$data['select3'];
        $data['select4'] = (int)$data['select4'];
        $data['select5'] = (int)$data['select5'];
        $data['urgent_date'] = TODAY;
        $data['top_date'] = TODAY;
        $data['contact'] = htmlspecialchars($data['contact']);
        if (empty($data['contact'])) {
            $this->fengmiMsg('联系人不能为空');
        }
        $data['mobile'] = htmlspecialchars($data['mobile']);
        if (empty($data['mobile'])) {
            $this->fengmiMsg('电话不能为空');
        }
        if (!isMobile($data['mobile']) && !isPhone($data['mobile'])) {
            $this->fengmiMsg('电话格式不正确');
        }
        $data['qq'] = htmlspecialchars($data['qq']);
        $data['addr'] = htmlspecialchars($data['addr']);
        $data['views'] = (int)$data['views'];
        $data['create_time'] = NOW_TIME;
        $data['last_time'] = NOW_TIME + 86400 * 30;
        $data['create_ip'] = get_client_ip();
        return $data;
    }

    public function business($area_id)
    {
        $datas = D('Business')->fetchAll();
        $str = '<option value="0">请选择</option>';
        foreach ($datas as $val) {
            if ($val['area_id'] == $area_id) {
                $str .= '<option value="' . $val['business_id'] . '">' . $val['business_name'] . '</option>';
            }
        }
        echo $str;
        die;
    }

    public function report($life_id)
    {
        if (empty($this->uid)) {
            $this->fengmiMsg('请先登陆', U('passport/login'));
        }
        $life_id = (int)$life_id;
        if (!($detail = D('Life')->find($life_id))) {
            $this->fengmiMsg('该信息不存在');
        }
        if (D('Lifereport')->check($life_id, $this->uid)) {
            $this->fengmiMsg('您已经举报过了！');
        }
        $arr = array('user_id' => $this->uid, 'life_id' => $life_id, 'create_time' => NOW_TIME, 'create_ip' => get_client_ip());
        D('Lifereport')->add($arr);
        $this->fengmiMsg('举报成功', U('life/detail', array('life_id' => $life_id)));
    }
    public function reportzhaopin($life_id)
    {
        if (empty($this->uid)) {
            $this->fengmiMsg('请先登陆', U('passport/login'));
        }
        $life_id = (int)$life_id;
        if (!($detail = D('Liferecruit')->find($life_id))) {
            $this->fengmiMsg('该信息不存在');
        }
        if (D('Lifereport')->check($life_id, $this->uid)) {
            $this->fengmiMsg('您已经举报过了！');
        }
        $arr = array('user_id' => $this->uid, 'life_id' => $life_id, 'create_time' => NOW_TIME, 'create_ip' => get_client_ip());
        D('Lifereport')->add($arr);
        $this->fengmiMsg('举报成功', U('life/detailzhaopin', array('life_id' => $life_id)));
    }

    public function search()
    {
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        $cat = (int)$this->_param('cat');
        $this->assign('cat', $cat);
        $order = (int)$this->_param('order');
        $this->assign('order', $order);
        $area_id = (int)$this->_param('area_id');
        $this->assign('area_id', $area_id);
        $this->assign('nextpage', LinkTo('life/searchload', array('keyword' => $keyword, 'cat' => $cat, 'order' => $order, 't' => NOW_TIME, 'p' => '0000')));
        $this->display();
    }

    public function searchload()
    {
        $keyword = $this->_param('keyword');
        if ($keyword) {
            $map['qq|mobile|contact|title|num1|num2'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        $Life = D('Life');
        import('ORG.Util.Page');
        $count = $Life->where(array('audit' => 1, 'city_id' => $this->city_id, 'closed' => 0))->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function phonedelete()
    {
        $keyword = $this->_param('keyword');
        if ($keyword) {
            $map['mobile'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
            $linkArr['keyword'] = $keyword;
        }
        $Life = D('Life');
        import('ORG.Util.Page');
        $map['mobile'] = array('eq', $keyword);
        $map['audit'] = array('eq', 1);
        $map['closed'] = array('eq', 0);
        $count = $Life->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function life_mobile()
    {
        $this->life_yzm();
    }

    public function delete()
    {
        $life_id = (int)$this->_param('life_id');
        $yzm = $this->_post('yzm');
        $life_code = session('life_code');
        if (empty($yzm)) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '请输入验证码！'));
        }
        if ($yzm != $life_code) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '短信验证码不正确！'));
        }
        if (empty($life_id)) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '预约不存在'));
        }
        if (!($detail = D('Life')->find($life_id))) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '预约不存在'));
        }
        if (D('Life')->save(array('life_id' => $life_id, 'closed' => 1))) {
            $this->ajaxReturn(array('status' => 'success', 'msg' => '恭喜您删除成功'));
        } else {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '操作失败'));
        }
    }

    public function zhaopin()
    {
        //列表信息展示
        $map = $linkArr = array();
        if ($channel = 7) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
            if (!empty($cates_ids)) {
                $map['cate_id'] = array('IN', $cates_ids);
            }
            $this->assign('cates_ids', $cates_ids);
            $this->assign('channel_id', $channel);
            $linkArr['channel'] = $channel;
        }
        //工作信息展示
        $workinfo = D('Lifesignup');
        $map = array('sign_user_id'=>$this->uid,'status'=>1,'audit'=>1,'workstart'=>1);
        $workinfolist= $workinfo->where($map)->select();

        //累计工资显示
        $salarymap = array('sign_user_id'=>$this->uid,'status'=>1,'audit'=>1);
        $salarysum= $workinfo->where($salarymap)->sum('salary');

        $this->assign('linkArr', $linkArr);
        $linkArr['p'] = '0000';
        $this->assign('nextpage', U('life/loadzhaopin', $linkArr));
        $this->assign('channel', $channel);
        $this->assign('workinfolist', $workinfolist);
        $this->assign('salarysum', $salarysum);
        $this->display();
        // 输出模板
    }
    public function loadzhaopin()
    {
        $Life = D('Liferecruit');
        import('ORG.Util.Page');
        // 导入分页类
        $map = array('audit' => 1, 'city_id' => $this->city_id, 'closed' => 0);
        if ($channel = 7) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
        }
        if (!empty($cates_ids)) {
            $map['cate_id'] = array('IN', $cates_ids);
        } else {
            die('0');
        }
        $count = $Life->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        //$detail = D('Liferecruit')->find($life_id);
       // $this->assign('pics', D('Lifephoto')->getPics($list['life_id']));
        //调用图片
        $this->display();
    }
    public function fabuzhaopin($cat)
    {
        if (empty($this->uid)) {
            $this->error('您还未登录', U('passport/login'));
        }
        $cat = (int)$cat;
        $cate = $this->lifecate[$cat];
        if (empty($cate)) {
            $this->display('post');
        }
        if ($this->isPost()) {
            $data = $this->createCheckZP();
            $shop = D('Shop')->find(array("where" => array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1)));
            if ($shop) {
                $data['is_shop'] = 1;
            }
            $data['user_id'] = $this->uid;
            $data['city_id'] = $this->city_id;
            $data['cate_id'] = $cat;
            // 订阅发送短信
            $models = M('shop_dingyue_set');//这里按理应该用D函数好一点
            $sms_open = $models->getField('sms_open');
            echo $sms_open;
            $sms_number = $models->getField('sms_number');
            if ($life_id=D('Liferecruit')->add($data)) {
                echo "hello after";
                $photos = $this->_post('photo', false);
                if (!empty($photos)) {
                    D('Lifephoto')->upload($life_id, $photos);
                }
                // 订阅发送短信 start  2016/04/13
                if ($sms_open == 1) {//检索关键字cate_id  和 city_id
                    $attr_id = $data['select1'];
                    $business_id = $data['business_id']; //去检索，如果订阅的有
                    $mapd['status'] = 1; //未删除
                    $mapd['audit'] = 1; //审核通过的，发送
                    $mapd['catlist'] = array('LIKE', '%,' . $attr_id);
                    $mapd['sitelist'] = array('LIKE', '%,' . $business_id);
                    $modeld = M('shop_dingyue');
                    $dingyuelist = $modeld->where($mapd)->select();
                    $count = $modeld->where($mapd)->count();
                    if (empty($dingyuelist)) {
                        $attr_id = $data['select2'];
                        $business_id = $data['business_id'];//去检索，如果订阅的有
                        $mapd['status'] = 1; //未删除
                        $mapd['audit'] = 1; //审核通过的，发送
                        $mapd['catlist'] = array('LIKE', '%,' . $attr_id);
                        $mapd['sitelist'] = array('LIKE', '%,' . $business_id);
                        $modeld = M('shop_dingyue');
                        $dingyuelist = $modeld->where($mapd)->select();
                        $count = $modeld->where($mapd)->count();
                    }
                    if (empty($dingyuelist)) {
                        $attr_id = $data['select3'];
                        $business_id = $data['business_id'];
                        //去检索，如果订阅的有
                        $mapd['status'] = 1;//未删除
                        $mapd['audit'] = 1;//审核通过的，发送

                        $mapd['catlist'] = array('LIKE', '%,' . $attr_id);
                        $mapd['sitelist'] = array('LIKE', '%,' . $business_id);
                        $modeld = M('shop_dingyue');
                        $dingyuelist = $modeld->where($mapd)->select();
                        $count = $modeld->where($mapd)->count();
                    }
                    if ($count) {
                        foreach ($dingyuelist as $k => $v) {
                            //判断数目是否超过，管理员设定的短信数目
                            if ($v['sms_number'] < $sms_number) {
                                //循环判断该类是否开通短信
                                if ($v['sms'] == 1) {
                                    $modelu = M('users');
                                    $mapu['user_id'] = $v['uid'];
                                    $mobile = $modelu->where($mapu)->getField('mobile');
                                    if ($mobile) {
                                        //大鱼发送分类信息短信
                                        if ($this->_CONFIG['sms']['dxapi'] == 'dy') {
                                            D('Sms')->DySms($this->_CONFIG['site']['sitename'], 'sms_life_dingyue_tongzhi_user', $mobile, array(
                                                'sitename' => $this->_CONFIG['site']['sitename'],
                                                'title' => $data['title'],
                                                'user_name' => $data['contact'],
                                                'user_mobile' => $data['mobile']
                                            ));
                                        } else {
                                            D('Sms')->sendSms('sms_code', $mobile, array(
                                                'sitename' => $this->_CONFIG['site']['sitename'],
                                                'title' => $data['title'],
                                                'user_name' => $data['contact'],
                                                'user_mobile' => $data['mobile']
                                            ));
                                        }
                                        //发送短信，同时数目+1
                                        $model = M('shop_dingyue');
                                        $data['sms_number'] = $dingyuelist[$k]['sms_number'] + 1;
                                        $map['dingyue_id'] = $dingyuelist[$k]['dingyue_id'];
                                        $result = $model->where($map)->save($data);
                                        $this->fengmiMsg('手机发送成功！', U('members/life'));
                                    }

                                }

                            }

                        }
                    }
                }
                $this->fengmiMsg('发布信息成功，通过审核后将会显示！', U('life/zhaopin'));
            }
            $this->fengmiMsg('发布信息失败！');
        } else {
            $this->assign('cate', $cate);
            $this->assign('areas', D('Area')->fetchAll());
            $this->assign('business', D('Business')->fetchAll());
            $attrs = D('Lifecateattr')->getAttrs($cat);
            $this->assign('attrs', $attrs);
            if (!empty($cate)) {
                $this->display('');
            }
        }
    }
    private function createCheckZP()
    {
        $data = $this->checkFields($this->_post('data', false), $this->create_zpfields);

        $data['title'] = htmlspecialchars($data['title']);
        if (empty($data['title'])) {
            $this->fengmiMsg('标题不能为空');
        }
        $data['zwlb'] = htmlspecialchars($data['zwlb']);
        if (empty($data['zwlb'])) {
            $this->fengmiMsg('职位类别不能为空');
        }
        $data['worktime'] = htmlspecialchars($data['worktime']);
        if (empty($data['worktime'])) {
            $this->fengmiMsg('工作时间不能为空');
        }
        $data['photo'] = htmlspecialchars($data['photo']);
        if (!empty($data['photo']) && !isImage($data['photo'])) {
            $this->fengmiMsg('缩略图格式不正确');
        }
        $data['urgent_date'] = TODAY;
        $data['top_date'] = TODAY;
        $data['create_time'] = NOW_TIME;
        $data['last_time'] = NOW_TIME + 86400 * 30;
        $data['create_ip'] = get_client_ip();
        $data['select1'] = (int)$data['select1'];
        $data['select2'] = (int)$data['select2'];
        $data['select3'] = (int)$data['select3'];
        $data['area_id'] = (int)$data['area_id'];
        $data['views'] = (int)$data['views'];
//        if (empty($data['area_id'])) {
//            $this->fengmiMsg('地区不能为空');
//        }
//        $data['business_id'] = (int)$data['business_id'];
//        if (empty($data['business_id'])) {
//            $this->fengmiMsg('商圈不能为空');
//        }
        $data['sfqz'] = htmlspecialchars($data['sfqz']);
        if (empty($data['sfqz'])) {
            $this->fengmiMsg('是否全职不能为空');
        }
        if($data['sfqz']=="yes"){
            $data['full_salary'] = (int)$data['full_salary'];
            if (empty($data['full_salary'])) {
                $this->fengmiMsg('全职工资不能为空');
            }
            $data['contact'] = htmlspecialchars($data['contact']);
            if (empty($data['contact'])) {
                $this->fengmiMsg('联系人不能为空');
            }
            $data['mobile'] = htmlspecialchars($data['mobile']);
            if (empty($data['mobile'])) {
                $this->fengmiMsg('电话不能为空');
            }
            if (!isMobile($data['mobile']) && !isPhone($data['mobile'])) {
                $this->fengmiMsg('电话格式不正确');
            }
            $data['weixin'] = htmlspecialchars($data['weixin']);
            if (empty($data['weixin'])) {
                $this->fengmiMsg('微信不能为空');
            }
            $data['addr'] = htmlspecialchars($data['addr']);
            if (empty($data['addr'])) {
                $this->fengmiMsg('地址不能为空');
            }

        }
        else{
            $data['half_salary'] = (int)$data['half_salary'];
            if (empty($data['half_salary'])) {
                $this->fengmiMsg('兼职工资不能为空');
            }
            $data['sfdr'] = htmlspecialchars($data['sfdr']);
            if (empty($data['sfdr'])) {
                $this->fengmiMsg('是否多人不能为空');
            }
            $data['depo_cash'] = (int)$data['depo_cash'];
            if (empty($data['depo_cash'])) {
                $this->fengmiMsg('兼职保证金不能为空');
            }
            $data['sfjbx'] = htmlspecialchars($data['sfjbx']);
            if (empty($data['sfjbx'])) {
                $this->fengmiMsg('是否交保险不能为空');
            }
        }
        echo 'send data\n:';
        echo "<pre>";print_r($data);echo "<pre>";
        return $data;
    }
    public function detailzhaopin($life_id)
    {
        if (empty($life_id)) {
            $this->error('参数错误');
        }
        if (!($detail = D('Liferecruit')->find($life_id))) {
            $this->error('该消息不存在或者已经删除！');
        }
        if ($detail['audit'] != 1) {
            $this->error('该消息不存在或者已经删除！');
        }
        if ($detail['closed'] != 0) {
            $this->error('该消息不存在或者已经删除！');
        }
        $cate = $this->lifecate[$detail['cate_id']];
        if (empty($cate)) {
            $this->error('该信息不能正常显示！');
        }
        D('Liferecruit')->updateCount($life_id, 'views');
        $this->assign('cate', $cate);
        $this->assign('city_id', $this->city_id);
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('detail', $detail);
       // $this->assign('ex', D('Lifedetails')->find($life_id));
       // $this->assign('attrs', $attrs = D('Lifecateattr')->getAttrs($detail['cate_id']));
      //  $ex = D('Lifedetails')->find($detail['life_id']);
        $chl = D('Lifecate')->getChannelMeans();
        $this->seodatas['title'] = $detail['title'];
        $this->seodatas['channel'] = $chl[$this->cates[$detail['cate_id']]['channel_id']];
        $this->seodatas['cate'] = $this->cates[$detail['cate_id']]['cate_name'];
//        if (!empty($detail['num2'])) {
//            $this->seodatas['num'] = $detail['num2'];
//        } else {
//            $this->seodatas['num'] = $detail['num1'];
//        }
//        if (!empty($detail['text1'])) {
//            $this->seodatas['text1'] = $detail['text1'];
//        } else {
//            $this->seodatas['text1'] = '最新';
//        }
//        if (!empty($ex[details])) {
//            $this->seodatas['desc'] = bao_Msubstr($ex['details'], 0, 200, false);
//        } else {
            $this->seodatas['desc'] = $detail['title'];
//        }
        //二次开发结束
        $this->assign('pics', D('Lifephoto')->getPics($detail['life_id']));
        //调用图片
        $this->display();
    }
    public function channeljianzhi()
    {
        $map = $linkArr = array();
        if ($channel = (int)$this->_param('channel')) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
            if (!empty($cates_ids)) {
                $map['cate_id'] = array('IN', $cates_ids);
            }
            $this->assign('cates_ids', $cates_ids);
            $this->assign('channel_id', $channel);
            $linkArr['channel'] = $channel;
        }
        $this->assign('linkArr', $linkArr);
        $linkArr['p'] = '0000';
        $this->assign('nextpage', U('life/loaddatajianzhi', $linkArr));
        $this->display();
        // 输出模板
    }
    public function channelwhole()
    {
        $map = $linkArr = array();
        if ($channel = (int)$this->_param('channel')) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
            if (!empty($cates_ids)) {
                $map['cate_id'] = array('IN', $cates_ids);
            }
            $this->assign('cates_ids', $cates_ids);
            $this->assign('channel_id', $channel);
            $linkArr['channel'] = $channel;
        }
        $this->assign('linkArr', $linkArr);
        $linkArr['p'] = '0000';
        $this->assign('nextpage', U('life/loaddatawhole', $linkArr));
        $this->display();
        // 输出模板
    }
    public function loaddatajianzhi()
    {
        $Life = D('Liferecruit');
        import('ORG.Util.Page');
        // 导入分页类
        $map = array('audit' => 1, 'city_id' => $this->city_id, 'closed' => 0,'sfqz'=>'no');
        if ($channel = 7) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
        }
        if (!empty($cates_ids)) {
            $map['cate_id'] = array('IN', $cates_ids);
        } else {
            die('0');
        }
        $count = $Life->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    public function loaddatawhole()
    {
        $Life = D('Liferecruit');
        import('ORG.Util.Page');
        // 导入分页类
        $map = array('audit' => 1, 'city_id' => $this->city_id, 'closed' => 0);
        if ($channel = 7) {
            $cates_ids = array();
            foreach ($this->lifecate as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
        }
        if (!empty($cates_ids)) {
            $map['cate_id'] = array('IN', $cates_ids);
        } else {
            die('0');
        }
        $count = $Life->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    public function myfabu()
    {
        if (empty($this->uid)) {
            $this->error('您还未登录', U('passport/login'));
        }
        $fabu_info = D('Liferecruit');
        $map = array('city_id' => $this->city_id,'user_id'=>$this->uid, 'closed' => 0);
        $list= $fabu_info->where($map)->select();
        $this->assign('list', $list);
        $this->display();
    }
    public function mysignup()
    {
        if (empty($this->uid)) {
            $this->error('您还未登录', U('passport/login'));
        }
        $sign_info = D('Lifesignup');
        $map = array('user_id'=>$this->uid);
        $list= $sign_info->where($map)->select();
        $this->assign('list', $list);
        $this->display();
    }
    public function signupdetail($cat)
    {
        $cat=(int)$cat;
        $sign_detail = D('Lifesignup');
        $map = array('life_id'=>$cat);
        $list= $sign_detail->where($map)->select();
        $this->assign('list', $list);
        $this->display();
    }
    public function signaudit($cat)
    {
        $cat=(int)$cat;
        $sign_detail = D('Lifesignup');
        $map = array('sign_id'=>$cat);
        $list= $sign_detail->where($map)->select();
        if($sign_detail->where($map)->setField('audit',1)){
            $this->success('审核成功，已通过!  ', U('life/signupdetail',array('cat'=>$list[0]['life_id'])));
        }else{
            $this->error('审核失败!  ', U('life/signupdetail',array('cat'=>$list[0]['life_id'])));
        }
    }
    public function signdecline($cat)
    {
        $cat=(int)$cat;
        $sign_detail = D('Lifesignup');
        $map = array('sign_id'=>$cat);
        $list= $sign_detail->where($map)->select();
        if($sign_detail->where($map)->setField('audit',2)){
            $this->success('审核成功，未通过! ', U('life/signupdetail',array('cat'=>$list[0]['life_id'])));
        }else{
            $this->error('审核失败!  ', U('life/signupdetail',array('cat'=>$list[0]['life_id'])));
        }
    }
    public function signup($cat)
    {
        if (empty($this->uid)) {
            $this->error('您还未登录', U('passport/login'));
        }
        $cat = (int)$cat;
        $sign_info = D('Lifesignup');
        $signmap = array('sign_user_id' => $this->uid,'status'=>1,'audit'=>1);
        $count=$sign_info->where($signmap)->count();
        $checkmap=array('sign_user_id' => $this->uid,'life_id'=>$cat);
        $checkcount=$sign_info->where($checkmap)->count();
        $fabu_info = D('Liferecruit');
        $map = array('life_id' => $cat);
        $list= $fabu_info->where($map)->select();
        $data['sign_user_id'] = $this->uid;
        $data['life_id']=$list[0]['life_id'];
        $data['job_title']=$list[0]['title'];
        if($list[0]['sfqz']=='yes'){
            $data['salary']=$list[0]['full_salary'];
        }else{
            $data['salary']=$list[0]['half_salary'];
        }
        $data['sign_time']=date("Y-m-d H:i:s");
        $data['status']=1;
        $data['job_count']=$count;
        if($this->isPost()) {
            if ($checkcount<=0) {
                if ($sign_id = D('Lifesignup')->add($data)) {
                    $this->success('报名成功，通过审核后将会显示！ ', U('life/detailzhaopin',array('life_id'=>$list[0]['life_id'])));
                } else {
                    $this->error('报名失败！ ', U('life/detailzhaopin',array('life_id'=>$list[0]['life_id'])));
                }
            } else{
                $this->success('你已经报名，请勿重复报名！', U('life/detailzhaopin',array('life_id'=>$list[0]['life_id'])));
            }
        }
    }
    public function gotowork(){
        $startwork = D('Lifesignup');
        $map = array('sign_user_id'=>$this->uid,'status'=>1,'audit'=>1);
        $liststart= $startwork->where($map)->setField('workstart',1);
        $listend= $startwork->where($map)->setField('workend',0);
        if($liststart&&$listend){
            $this->fengmiMsg('打卡上班成功',U('life/zhaopin'));
        }else{
            $this->fengmiMsg('打卡下班失败',U('life/zhaopin'));
        }
    }
    public function endwork(){
        $startwork = D('Lifesignup');
        $map = array('sign_user_id'=>$this->uid,'status'=>1,'audit'=>1);
        $listend= $startwork->where($map)->setField('workend',1);
        $liststart= $startwork->where($map)->setField('workstart',0);
        if($liststart&&$listend){
            $this->fengmiMsg('打卡下班成功',U('life/zhaopin'));
        }else{
            $this->fengmiMsg('打卡下班失败',U('life/zhaopin'));
        }
    }
}