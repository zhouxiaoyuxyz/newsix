<?php

use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\ConnectionInterface;

require 'vendor/autoload.php';

$card = $_REQUEST['card'];
$loop = React\EventLoop\Factory::create();
$connector = new React\Socket\Connector($loop);

$connector->connect('0.0.0.0:2205')->then(function (ConnectionInterface $conn) use ($loop) {
    // $conn->pipe(new React\Stream\WritableResourceStream(STDOUT, $loop));
    $conn->write($GLOBALS['card'] . ",AT+ONLINE\r\n");

    $conn->on('data', function ($data) use ($conn) {
        if (!empty($data)) {
            //$conn->end();
            print_r($data);
        }

        $conn->end();
    });



});

$loop->run();
