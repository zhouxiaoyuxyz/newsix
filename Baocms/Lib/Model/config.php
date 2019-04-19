<?php
require __DIR__ . '/autoload.php';

use JPush\Client as JPush;

$app_key = '9ec864a8da7a61e43f052217';
$master_secret = '858d5a26c8582840101248ad';
//$registration_id = getenv('registration_id');

$client = new JPush($app_key, $master_secret);
