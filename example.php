<?php

require_once 'vendor/autoload.php';

use ACX\Acx;

$key = '';
$secret = '';
$url = 'https://acx.io/api/v2/';

$acx = new Acx($key, $secret, $url);

// get ticker with all pairs
$res = $acx->ticker();

// get ticker with specific pair
$res = $acx->ticker('ethaud');

// get public markets list
$res = $acx->markets();

// get public orderbook of btcaud
$res = $acx->orderbook('btcaud');

// get public orderbook with limits
$res = $acx->orderbook('btcaud', ['asks_limit' => 10, 'bids_limit' => 10]);

// get market depth of btcaud
$res = $acx->depth('btcaud');

// get market depth of btcaud limit to 10 result
$res = $acx->depth('btcaud', ['limit' => 10]);

// get public trade data of btcaud
$res = $acx->trades('btcaud');

// get public trade data of btcaud with all supported parameters
$res = $acx->trades(
    'btcaud',
    [
        'limit' => 20,
        'timestamp' =>  time() - 3600,
        // 'from' => '', // order id from
        // 'to' => '',   // order id to
        'order_by' => 'desc'
    ]
);

// get k line of btc data
$res = $acx->k('btcaud');

// get current server timestamp
$res = $acx->timestamp();


########### private methods ###########

$key = ''; // set your api key here
$secret = ''; // set your api key here

$acx = new Acx($key, $secret);

$res = $acx->me();
//
// get public kkk
var_dump($res);
