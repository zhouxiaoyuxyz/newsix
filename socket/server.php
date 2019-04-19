<?php

use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\ConnectionInterface;

require 'vendor/autoload.php';

function getIP($address)
{
    return trim(parse_url($address, PHP_URL_HOST), '[]');
}

function delByValue($arr, $value)
{
    if (!is_array($arr)) {
        return $arr;
    }
    foreach ($arr as $k => $v) {
        if ($v == $value) {
            unset($arr[$k]);
        }
    }
    return $arr;
}

function delByKey($arr, $key)
{
    if (!is_array($arr)) {
        return $arr;
    }
    foreach ($arr as $k => $v) {
        if ($k == $key) {
            unset($arr[$k]);
        }
    }
    return $arr;
}

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server('0.0.0.0:2205', $loop);
$connections = array();
$cards = array();
$GLOBALS['conn'] = array();
$GLOBALS['local'] = null;

$socket->on('connection', function (ConnectionInterface $conn) {

    echo '----' . PHP_EOL;
    echo 'Start connection with: ' . getIP($conn->getRemoteAddress()) . '  Time: ' . date('Y-m-d h:i:s', time()) . PHP_EOL;

    $conn->on('data', function ($data) use ($conn) {
        $ip = getIP($conn->getRemoteAddress());

        //业务逻辑
        if ($ip == null && !strpos($data, ",")) {
            echo 'unknown ip send data:' . $data . date('Y-m-d h:i:s', time()) . PHP_EOL;
            return;
        }
        if (strcmp('127.0.0.1', $ip) == 0 || (strpos($data, ","))) {

//            $GLOBALS['conn'] = $conn;
            if (strpos($data, "CIP")) {
                echo 'Remote Data From ' . $ip . ' Send: ' . ' ' . $data . date('Y-m-d h:i:s', time()) . PHP_EOL;
                return;
            }
            $datas = explode(",", $data);

            if (strpos($data, "ONLINE")) {
                if ($GLOBALS['local'] != null) {
                    $GLOBALS['local']->end();
                    $GLOBALS['local'] = null;
                }
                $GLOBALS['local'] = $conn;
            } else {

                if ($GLOBALS['local'] != null) {
                    $GLOBALS['local']->end();
                    $GLOBALS['local'] = null;
                }
            }

            echo 'Local Data From ' . $ip . ' Data: ' . $datas[0] . ' ' . $datas[1];
            // var_dump(array_keys($GLOBALS['connections']));
            if (array_key_exists($datas[0], $GLOBALS['connections'])) {
                try {
                    $GLOBALS['connections'][$datas[0]]->write($datas[1] . "\r\n");
                } catch (Exception $e) {
                    echo 'Error Local Data From ' . $ip . ' Send: ' . $datas[0] . ' ' . $datas[1] . date('Y-m-d h:i:s', time()) . PHP_EOL;
                }

            } else {
                echo "No such Card No." . $datas[0] . date('Y-m-d h:i:s', time()) . PHP_EOL;
                if ($GLOBALS['local'] != null) {
                    $GLOBALS['local']->write("No such Card!\n");
                    $GLOBALS['local']->end();
                    $GLOBALS['local'] = null;
                }
            }


        } else {
            $data = str_replace("\n", "", $data);
            $data = str_replace("\r", "", $data);
            if (strcmp($data, "tick") == 0) {
                $conn->write("AT+OK" . "\r\n");
                return;
            }
            echo 'Conn From Water Client $data: ' . $data . ' ' . date('Y-m-d h:i:s', time()) . PHP_EOL;
            if (strpos($data, "OK")) {
                echo 'data is OK';
                if ($GLOBALS['local'] != null) {
                    echo 'local is not NULL: ' . date('Y-m-d h:i:s', time()) . PHP_EOL;

                    // 如果要改同一时间，不能两人同时扫码取水的问题，应该是改 local 所记录的connection
                    // zhangdianlei 2019-03-09 20:53

                    $GLOBALS['local']->write($data);
                    $GLOBALS['local']->end();

                    $GLOBALS['local'] = null;
                }
                return;
            } else {

                echo 'data is not OK, data is : '. $data . ' ' . date('Y-m-d h:i:s', time()) . PHP_EOL;
                if ($GLOBALS['local'] != null) {
                    $GLOBALS['local']->end();
                    $GLOBALS['local'] = null;
                }
            }


            if (array_key_exists($ip, $GLOBALS['cards'])) {
                $GLOBALS['cards'][$ip] = $data;
            }
            if (array_key_exists($data, $GLOBALS['connections'])) {
                // zhangdianlei add 2019-03-09
                $GLOBALS['connections'][$data]->end();
                $GLOBALS['connections'][$data] = $conn;
            }

            if (!array_key_exists($ip, $GLOBALS['cards']) && !array_key_exists($data, $GLOBALS['connections'])) {
                //记录卡号和连接
                $newconn = array($data => $conn);
                $GLOBALS['connections'] = array_merge($GLOBALS['connections'], $newconn);
                //记录IP和卡号
                $card = array($ip => $data);
                $GLOBALS['cards'] = array_merge($GLOBALS['cards'], $card);
                $conn->write("Receive " . $conn->getRemoteAddress() . ' CardNo: ' . $data . " !\r\n");
                echo 'Record Card: ' . $data . ' Time:' .date('Y-m-d h:i:s', time()) . PHP_EOL;
                return;
            } else {
                echo 'Refresh Card Data: ' . $ip . ' ' . $data . ' Time:' . date('Y-m-d h:i:s', time()) . PHP_EOL;
                return;
            }
        }

    });

    $conn->on('close', function () use ($conn) {
        $ip = getIP($conn->getRemoteAddress());
        if (strcmp('127.0.0.1', $ip) != 0 && !empty($ip)) {

//            $cardNO = $GLOBALS['cards'][$ip];
//            $GLOBALS['cards'] = delByKey($GLOBALS['cards'], $ip);
//            $GLOBALS['connections'] = delByKey($GLOBALS['connections'], $cardNO);
//
//            echo '----Close----' . PHP_EOL;
//            echo 'Cards:' . PHP_EOL;
//            var_dump(array_keys($GLOBALS['cards']));
//            echo 'Connections:' . PHP_EOL;
//            var_dump(array_keys($GLOBALS['connections']));
//            echo '----Close----' . PHP_EOL;
        }
        echo 'Disconnect ' . $ip . date('Y-m-d h:i:s', time()) . PHP_EOL;
    });
});

$loop->run();

