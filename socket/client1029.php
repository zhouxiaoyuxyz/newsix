<?php
use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\ConnectionInterface;

require 'vendor/autoload.php';

$card=$_REQUEST['card'];
$loop = React\EventLoop\Factory::create();
$connector = new React\Socket\Connector($loop);

$connector->connect('0.0.0.0:2205')->then(function (ConnectionInterface $conn) use ($loop) {
    //$conn->pipe(new React\Stream\WritableResourceStream(STDOUT, $loop));
    $conn->write($GLOBALS['card'].",AT+WATER 57\r\n");
	
	$conn->on('data', function ($data) use ($conn) {
		print_r($data);
		});
		print_r(22222);
    $conn->end();
});

$loop->run();