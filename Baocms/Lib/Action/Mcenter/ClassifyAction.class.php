<?php

class ClassifyAction extends Action
{

    public function money_add()
    {
        $post_data = $GLOBALS['HTTP_RAW_POST_DATA'];

        $obj = json_decode($post_data);
        echo $obj;
        // $token = $obj->{'token'};
        if (1) {
            $a = D('Users')->AddClassifyGold((int)$obj->{'user_id'}, (int)$obj->{'gold'}, $obj->{'intro'}, (int)$obj->{'classify_id'});
            $b = D('Users')->MoveClassifyGold((int)$obj->{'user_id'}, (int)$obj->{'gold'}, $obj->{'intro'}, (int)$obj->{'classify_id'});

            // 小北积分消费
            if ($b) {
                $data = array(
                    "card_name" => $obj->{'classify_id'},
                    "tel" => $obj->{'mobile'},
                    "now_money" => $obj->{'gold'},
                    "cost_money" => $obj->{'gold'},
                    "cost_status" => 2
                );
                $url_string = '?card_name='. $obj->{'classify_id'} .'&tel='. $obj->{'mobile'} .'&now_money='. 0 .'&cost_money='. $obj->{'gold'} .'&cost_status=2';
                // $data_string = json_encode($data);
                $ch = curl_init('http://211.149.129.226:8080/XiaoBeiMgtsys/water/update' . $url_string);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));
                $return_content = curl_exec($ch);
                // echo $return_content;
            }

            if ($a && $b) {
                $data = [
                    'code' => '1000',
                    'message' => 'request success',
                    'state' => 'success'
                ];
            } else {
                $data = [
                    'code' => '1001',
                    'message' => 'server error',
                    'state' => 'error'
                ];
            }
            echo json_encode($data);

        } else {
            $data = [
                'code' => '1002',
                'message' => 'unknown error',
                'state' => 'error'
            ];
            echo json_encode($data);
        }

    }

}