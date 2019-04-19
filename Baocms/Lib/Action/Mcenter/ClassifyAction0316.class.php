<?php

class ClassifyAction extends Action
{

    public function money_add()
    {
        $post_data = $GLOBALS['HTTP_RAW_POST_DATA'];

        $obj = json_decode($post_data);
        $token = $obj->{'token'};
        echo $token;
        if($token == "enjoysix"){
          	echo PHP_EOL;
          	echo (int)$obj->{'user_id'} . PHP_EOL;
          	echo (int)$obj->{'gold'} . PHP_EOL;
          	echo $obj->{'intro'} . PHP_EOL;
          	echo (int)$obj->{'classify_id'} . PHP_EOL;
          
            D('Users')->AddClassifyGold( (int)$obj->{'user_id'}, (int)$obj->{'gold'}, $obj->{'intro'}, (int)$obj->{'classify_id'});
            D('Users')->MoveClassifyGold( (int)$obj->{'user_id'}, (int)$obj->{'gold'}, $obj->{'intro'}, (int)$obj->{'classify_id'});

//            $data = array("classify_id" => $obj->{'classify_id'}, "user_id" => $obj->{'user_id'}, "gold" => $obj->{'gold'}, "intro" => $obj->{'intro'}, "token" => "enjoysix");
//            $data_string = json_encode($data);
//            $ch = curl_init('http://enjoysix.cn/mcenter/classify/money_add');
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
//            curl_exec($ch);
        }

    }


}