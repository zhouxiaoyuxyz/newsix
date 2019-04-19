<?php
use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\ConnectionInterface;

require 'vendor/autoload.php';

function getIP($address){
    return trim(parse_url($address, PHP_URL_HOST), '[]');
}

function delByValue($arr, $value){
    if(!is_array($arr)){
        return $arr;
    }
    foreach($arr as $k=>$v){
        if($v == $value){
            unset($arr[$k]);
        }
    }
    return $arr;
}

function delByKey($arr, $key){
    if(!is_array($arr)){
        return $arr;
    }
    foreach($arr as $k=>$v){
        if($k == $key){
            unset($arr[$k]);
        }
    }
    return $arr;
}

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server('0.0.0.0:2205', $loop);
$connections = array();
$cards =array();
$GLOBALS['conn'] =array();
$GLOBALS['ask'] =array();
$GLOBALS['local']=null;

$socket->on('connection', function (ConnectionInterface $conn) {

    //get remote IP address
    echo 'Connection with ' . getIP($conn->getRemoteAddress()) . PHP_EOL;
//    global $connections;
//    $newconn=array(getIP($conn->getRemoteAddress())=>$conn);
//    $GLOBALS['connections']=array_merge($GLOBALS['connections'],$newconn);

    $conn->write("Hello " . $conn->getRemoteAddress() . "!\n");

    $conn->on('data', function ($data) use ($conn) {
        //$conn->close();
        $ip=getIP($conn->getRemoteAddress());
//        if(strpos($data,",")){
//            echo "include";
//        }
			
        //业务逻辑
        if($ip==null && !strpos($data,",")){
            echo 'unknown ip send data:'.$data.PHP_EOL;
            return;
        }
        if(strcmp('127.0.0.1',$ip)==0||(strpos($data,","))){
			$fp = fopen('data2.txt','w+'); 
				fwrite($fp,var_export($data,true)); 
				fclose($fp);
				$GLOBALS['conn']=$conn;
            if(strpos($data,"CIP")){
                echo 'Remote Data From '.$ip.' Send: '.' '.$data.PHP_EOL;
                return;
            }
            $datas=explode(",",$data);

            //add for demo
            if(strpos($data,"ONLINE")){
                $GLOBALS['local']=$conn;
            }
				
            echo 'Local Data From '.$ip.' Send: '.$datas[0].' '.$datas[1].PHP_EOL;
            var_dump(array_keys($GLOBALS['connections']));
            if(array_key_exists($datas[0],$GLOBALS['connections'])){
                try{
                    $GLOBALS['connections'][$datas[0]]->write($datas[1]."\r\n");
                }catch (Exception $e){
                    echo 'Error Local Data From '.$ip.' Send: '.$datas[0].' '.$datas[1].PHP_EOL;
                }

            }else{
                echo "No such Card No.".$datas[0].PHP_EOL;
            }
//            $GLOBALS['connections'][$datas[0]]->write($datas[1]."\n");
//            $conn->close();
        }else{
            $data=str_replace("\n","",$data);
            $data=str_replace("\r","",$data);
            if(strcmp($data,"tick")==0){
                $conn->write("AT+OK"."\r\n");
                return;
            }
			
//			if(!empty($GLOBALS['conn'])){
//				$GLOBALS['conn']->write($data."\r\n");
//				$GLOBALS['ask']=$data;
//				$fp = fopen('data3.txt','w+');
//				fwrite($fp,var_export($data,true));
//				fclose($fp);
//			}
            //fix for demo
            echo '222';
            if(strpos($data,"OK")>0){
                echo '0000';
                if($GLOBALS['local']!=null){
                    echo '1111';
                    $GLOBALS['local']->write($data);
                    $GLOBALS['local']->end();
                    $GLOBALS['local']==null;
                }
                return;
            }
			
			
            if(array_key_exists($ip,$GLOBALS['cards'])){
                $GLOBALS['cards'][$ip]=$data;
            }
            if(array_key_exists($data,$GLOBALS['connections'])){
                $GLOBALS['connections'][$data]=$conn;
            }
			
			$fp = fopen('cards.txt','w+'); 
				fwrite($fp,var_export($GLOBALS['cards'],true)); 
				fclose($fp);

            if(!array_key_exists($ip,$GLOBALS['cards'])&&!array_key_exists($data,$GLOBALS['connections'])){
                //记录卡号和连接
                $newconn=array($data=>$conn);
                $GLOBALS['connections']=array_merge($GLOBALS['connections'],$newconn);
                //var_dump($newconn);
                //var_dump($GLOBALS['connections']);
                //记录IP和卡号
                $card=array($ip=>$data);
                $GLOBALS['cards']=array_merge($GLOBALS['cards'],$card);
                $conn->write("Receive " . $conn->getRemoteAddress() .' CardNo: '.$data. " !\r\n");
                echo 'Record Card '.$data.PHP_EOL;
            }else{
                //$GLOBALS['connections'][$ip]=$data;
                //$GLOBALS['cards'][$data]=$conn;
                //$conn->write("Error " . $conn->getRemoteAddress() .$data. " !\r\n");
                echo 'Refresh Card Data ' . $ip .$data. PHP_EOL;
            }
        }

    });

    $conn->on('close',function () use ($conn){
        $ip=getIP($conn->getRemoteAddress());
//        echo $conn->getRemoteAddress();
        if(strcmp('127.0.0.1',$ip)!=0&&!empty($ip)){

            $cardNO=$GLOBALS['cards'][$ip];
            //echo '---- '.$cardNO.PHP_EOL;
            $GLOBALS['cards']=delByKey($GLOBALS['cards'],$ip);
            $GLOBALS['connections']=delByKey($GLOBALS['connections'],$cardNO);

            echo '----'.PHP_EOL;
            var_dump(array_keys($GLOBALS['cards']));
            var_dump(array_keys($GLOBALS['connections']));
            echo '----'.PHP_EOL;
        }
        echo 'Disconnect ' . $ip . PHP_EOL;
    });
});

$loop->run();

