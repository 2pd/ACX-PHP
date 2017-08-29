<?php

require_once 'lib/ACXClient.php';

use ACX\ACXClient;

$key = '';
$secret = '';
$url = 'https://acx.io/api';
$version = 2;
$sslVerify = false;

$acx = new ACXClient($key, $secret, $url, $version, $sslVerify);

$res = $acx->QueryPublic('tickers.json');

var_dump($res);
