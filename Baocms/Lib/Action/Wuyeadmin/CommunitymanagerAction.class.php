<?php
class CommunitymanagerAction extends CommonAction
{
    private $create_fields = array('community_id', 'community_name', 'wuye_id', 'wuye_name',  'user_id','third_profit');
    private $edit_fields = array('community_id', 'community_name', 'wuye_id', 'wuye_name',  'user_id','third_profit');

    public function index()
    {
        $Community = D('Communitymanager');
        import('ORG.Util.Page');
        // 导入分页类
        $map = array();
        $users = $this->_param('data', false);
        $user_id = $this->_param('user_id', false);
        if ($user_id) {
            $map['user_id'] = $user_id;
        }
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        if ($keyword) {
            $count = $Community->where($map)->count();
            $map['community_name'] = array('LIKE', '%' . $keyword . '%');
        }
        // 查询满足要求的总记录数
        $Page = new Page($count, 25);
        // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();
        // 分页显示输出
        $list = $Community->where($map)->order(array('id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $user_ids = array();
        foreach ($list as $k => $val) {
            $list[$k] = $Community->_format($val);
            $user_ids[$val['user_id']] = $val['user_id'];
        }
        if (!empty($user_ids)) {
            $this->assign('users', D('Users')->itemsByIds($user_ids));
        }
        //数据查询开始
        $Village = D('Village');
        $village_ids = array();
        foreach ($list as $k => $val) {
            $list[$k] = $Village->_format($val);
            $village_ids[$val['village_id']] = $val['village_id'];
        }
        if (!empty($village_ids)) {
            $this->assign('village', D('Village')->itemsByIds($village_ids));
        }
        //数据查询结束
        $this->assign('keyword', $keyword);
        $this->assign('list', $list);
        // 赋值数据集www.hatudou.com  二开开发qq  120585022
        $this->assign('page', $show);
        // 赋值分页输出
        $this->display();
        // 输出模板
    }


    public function create()
    {
        if ($this->isPost()) {
            $data = $this->createCheck();
            $obj = D('Communitymanager');
            if ($obj->add($data)) {
                $obj->cleanCache();
                $this->baoSuccess('添加成功', U('communitymanager/index'));
            }
            $this->baoError('操作失败！');
        } else {
            $admins = D('Admin')->where(array('role_id' => 11, 'closed' => 0))->select();
            $admin=$this->_admin;
            $community = D('Community')->where(array('uid'=>$admin['admin_id'],'closed' => 0))->select();
            //print_r($admins);
            $this->assign('areas', D('Area')->fetchAll());
            $this->assign('admins',$admins);
            $this->assign('community',$community);
            $this->display();
        }
    }
    private function createCheck()
    {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['community_name'] = htmlspecialchars($data['community_name']);
        if (empty($data['community_name'])) {
            $this->baoError('小区名称不能为空');
        }
        $data['wuye_name'] = htmlspecialchars($data['wuye_name']);
        if (empty($data['wuye_name'])) {
            $this->baoError('物业公司不能为空');
        }

        $data['user_id'] = (int) $data['user_id'];
        if (empty($data['user_id'])) {
            $this->baoError('物业管理员不能为空');
        }
        $data['third_profit'] = (int) ($data['third_profit']*100);
        if (empty($data['third_profit'])) {
            $this->baoError('项目经理分成不能为空');
        }
        $data['create_time'] = NOW_TIME;
        return $data;
    }
    public function edit($id = 0)
    {
        if ($id = (int) $id) {
            $obj = D('Communitymanager');
            if (!($detail = $obj->find($id))) {
                $this->baoError('请选择要编辑的小区管理');
            }
            if ($this->isPost()) {
                $data = $this->editCheck();
                $data['id'] = $id;
                if (false !== $obj->save($data)) {
                    $obj->cleanCache();
                    $this->baoSuccess('操作成功', U('communitymanager/index'));
                }
                $this->baoError('操作失败');
            } else {
                $admins = D('Admin')->where(array('role_id' => 11, 'closed' => 0))->select();
                $admin=$this->_admin;
                $community = D('Community')->where(array('uid'=>$admin['admin_id'],'closed' => 0))->select();
                //print_r($admins);
                $this->assign('detail', $detail);
                $this->assign('users', D('Users')->find($detail['user_id']));
                $this->assign('areas', D('Area')->fetchAll());
                $this->assign('admins',$admins);
                $this->assign('community',$community);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的商圈管理');
        }
    }

    private function editCheck()
    {
        $data = $this->checkFields($this->_post('data', false), $this->edit_fields);
        $data['community_name'] = htmlspecialchars($data['community_name']);
        echo "community_name".$data['community_name'];
        echo "community_id".$data['community_id'];
        if (empty($data['community_name'])) {
            $this->baoError('小区名称不能为空');
        }
        $data['wuye_name'] = htmlspecialchars($data['wuye_name']);
        echo "wuye_name".$data['wuye_name'];
        if (empty($data['wuye_name'])) {
            $this->baoError('物业公司不能为空');
        }

        $data['user_id'] = (int) $data['user_id'];
        if (empty($data['user_id'])) {
            $this->baoError('物业管理员不能为空');
        }
        $data['third_profit'] = (int) ($data['third_profit']*100);
        if (empty($data['third_profit'])) {
            $this->baoError('项目经理分成不能为空');
        }
        return $data;
    }
    public function delete($id = 0)
    {
        if (is_numeric($id) && ($id = (int) $id)) {
            $obj = D('Communitymanager');
            $obj->delete($id);
            $obj->cleanCache();
            $this->baoSuccess('删除成功！', U('communitymanager/index'));
        } else {
            $id = $this->_post('id', false);
            if (is_array($id)) {
                $obj = D('Communitymanager');
                foreach ($id as $child_id) {
                    $obj->delete($child_id);
                }
                $obj->cleanCache();
                $this->baoSuccess('删除成功！', U('communitymanager/index'));
            }
            $this->baoError('请选择要删除的小区管理');
        }
    }



    public function child($area_id = 0)
    {
        $datas = D('Communitymanager')->select();
        $str = '<option value="0">请选择</option>';
        foreach ($datas as $val) {
            if ($val['area_id'] == $area_id) {
                $str .= '<option value="' . $val['community_id'] . '">' . $val['name'] . '</option>';
            }
        }
        echo $str;
        die;
    }
    // 新增选择小区
    public function select()
    {
        $User = D('Community');
        import('ORG.Util.Page');
        // 导入分页类
        $map = array('closed' => array('IN', '0,-1'));
        if ($account = $this->_param('account', 'htmlspecialchars')) {
            $map['account'] = array('LIKE', '%' . $account . '%');
            $this->assign('account', $account);
        }
        if ($nickname = $this->_param('nickname', 'htmlspecialchars')) {
            $map['nickname'] = array('LIKE', '%' . $nickname . '%');
            $this->assign('nickname', $nickname);
        }
        if ($ext0 = $this->_param('ext0', 'htmlspecialchars')) {
            $map['ext0'] = array('LIKE', '%' . $ext0 . '%');
            $this->assign('ext0', $ext0);
        }
        $count = $User->where($map)->count();
        // 查询满足要求的总记录数
        $Page = new Page($count, 8);
        // 实例化分页类 传入总记录数和每页显示的记录数
        $pager = $Page->show();
        // 分页显示输出
        $list = $User->where($map)->order(array('Community_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        // 赋值数据集www.hatudou.com  二开开发qq  120585022
        $this->assign('page', $pager);
        // 赋值分页输出
        $this->display();
        // 输出模板
    }

    //生成红包
    public function bonus()
    {
        $bonus = D('Bonus');
        $community_id=$_SESSION['community_id'];
        if ($community_id ) {
            $bonus ->sendBonusByCid($community_id);
        } else {
            $this->baoError('请重新选择小区！');
        }
    }
}