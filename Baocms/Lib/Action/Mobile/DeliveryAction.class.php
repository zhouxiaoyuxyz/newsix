<?php



class DeliveryAction extends CommonAction {

    public function index() {

        if(!cookie('DL')){
            header("Location: " . U('login/index'));
        }else{
            $cid = $this->reid();
            $dv = D('Deliverymode');
            $rdv = $dv -> where('delivery_id ='.$cid) -> find();
            $community = D('Community')->where(array('closed' => 0))->select();
            $servicecommunity = D('Deliverycommunity')->where(array('delivery_id' => $cid))->select();

            $this->assign('mode',$rdv['mode']);
            $this->assign('community',$community);
            $this->assign('servicecommunity',$servicecommunity);
            $this->display();
        }
    }


    public function ordermode(){
        if(!cookie('DL')){
            header("Location: " . U('login/index'));
        }else{
            $cid = $this->reid();
            $dv = D('Delivery');
            $rdv = $dv -> where('id ='.$cid) -> find();
            $selectmode=D('Deliverymode')->where('delivery_id ='.$cid)->find();
            $mode=(int)$this->_param('mode');
            echo "mode";
            echo $mode;
            $data=array(
                'delivery_id'=>  $cid,
                'mode'=>$mode,
                'create_time'=>NOW_TIME
            );
            if($selectmode){
                D('Deliverymode')->where('delivery_id ='.$cid)->save($data);
            }else{
                D('Deliverymode')->add($data);
            }
        }
    }
    public function add_commu(){
        if(!cookie('DL')){
            header("Location: " . U('login/index'));
        }else{
            $cid = $this->reid();

            $community_id=(int)$this->_param('community_id');
            echo 'community_id';
            echo $community_id;
            $community_name=$this->_param('community_name', 'htmlspecialchars');
            echo 'community_name';
            echo $community_name;

            if (!$community_id) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '小区必须选择！'));

            }
            $data=array(
                'delivery_id'=>  $cid,
                'community_id'=>$community_id,
                'community_name'=>$community_name,
                'create_time'=>NOW_TIME
            );
            $add=D('Deliverycommunity')->add($data);
            if ($add) {
                $this->ajaxReturn(array('status' => 'success', 'msg' => '添加成功！'));

            } else {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '添加失败！'));

            }
        }
    }
    public function edit_commu(){
        if(!cookie('DL')){
            header("Location: " . U('login/index'));
        }else{
            $cid = $this->reid();

            $id=(int)$this->_param('id');
            echo "id";
            echo $id;
            $community_id=(int)$this->_param('community_id');
            echo "community_id";
            echo $community_id;
            $community_name=$this->_param('community_name', 'htmlspecialchars');
            echo "community_name";
            echo $community_name;
            if (!$id) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '错误！'));
            }
            if (!$community_id) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '小区必须选择！'));
            }
            $data=array(
                'delivery_id'=>  $cid,
                'community_id'=>$community_id,
                'community_name'=>$community_name,
                'create_time'=>NOW_TIME
            );
            $edit=D('Deliverycommunity')->where(array('id'=>$id))->save($data);
            if ($edit) {
                $this->ajaxReturn(array('status' => 'success', 'msg' => '修改成功！'));
            } else {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '修改失败！'));
            }
        }
    }

    //资金

    public function money(){
        if(!cookie('DL')){
            header("Location: " . U('login/index'));
        }else{
            $cid = $this->reid();
            $dv = D('Delivery');
            $rdv = $dv -> where('id ='.$cid) -> find();
            if(!$rdv){
                header("Location: " . U('login/logout'));
            }else{
                $this->assign('rdv',$rdv);
            }

            $do = D('DeliveryOrder');
            $deliveryOrder = $do -> where('delivery_id ='.$cid) -> count();

            $ex = d( "Express" );
            $express = $ex -> where('cid ='.$cid) -> count();
            $statistics = $deliveryOrder+ $express;//一共配送多少
            $this->assign('statistics',$statistics);

            $price = $this->_CONFIG['mobile']['delivery_price'];//单价
            $this->assign('price',$price);
            $total= $statistics*$price;//总价
            $this->assign('total',$total);

            $this->display();
        }
    }


    public function lists( ){

        $id = i( "id", "", "intval,trim" );

        $cid = $this->reid();
        $dv = D('Delivery');
        $rdv = $dv -> where('id ='.$cid) -> find();
        if(!$rdv){
            header("Location: " . U('login/logout'));
        }else{
            $this->assign('rdv',$rdv);
        }


        if ( !$id ){
            $this->error( "没有选择！" );
        }
        else{


            $this->assign( "delivery", d( "Delivery" )->where( "id =".$id )->find( ) );
            $dvo = d( "DeliveryOrder" );
            import( "ORG.Util.Page" );

            $count = $dvo->where( "delivery_id =".$id )->count( );
            $Page = new Page( $count, 5 );
            $show = $Page->show( );
            $var = c( "VAR_PAGE" ) ? c( "VAR_PAGE" ) : "p";
            $p = $_GET[$var];
            if ( $Page->totalPages < $p ){
                exit( "0" );
            }

            $list = $dvo->where( "delivery_id =".$id )->order( "order_id desc" )->limit( $Page->firstRow.",".$Page->listRows )->select( );
            $this->assign( "list", $list );
            $this->assign( "page", $show );
            $this->assign( "count", $count );
            $this->display( );
        }
    }


}