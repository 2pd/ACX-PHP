<?php

namespace ACX;

use GuzzleHttp\Psr7\Uri;

class ACXAPIException extends \ErrorException {};

class Acx
{
    private $key;     // API key
    private $secret;  // API secret
    private $url;     // API base URL
    private $client;    // http request

    function __construct($key, $secret, $url = 'https://acx.io:443/api/v2/')
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->url = $url;

        if (!$this->client) {
            $this->client = new \GuzzleHttp\Client();
        }
    }

    public function timestamp()
    {
        return $this->query_public('timestamp.json');
    }

    public function k(string $pair, array $parameters = array())
    {
        $parameters['market'] = $pair;
        return $this->query_public('k.json', $parameters);
    }

    public function trades(string $pair, array $parameters = array())
    {
        $parameters['market'] = $pair;
        return $this->query_public('trades.json', $parameters);
    }

    public function depth(string $pair, array $parameters = array())
    {
        $parameters['market'] = $pair;
        return $this->query_public("depth.json", $parameters);
    }

    public function orderbook(string $pair, array $parameters = array())
    {
        $parameters['market'] = $pair;
        return $this->query_public("order_book.json", $parameters);
    }

    public function markets()
    {
        return $this->query_public('markets.json');
    }

    public function ticker(string $pair = '')
    {
        $method = empty($pair) ? 'tickers.json' : "tickers/{$pair}.json";
        return $this->query_public($method);
    }

    protected function query_public(string $method, array $parameters = array(), string $verb = 'GET')
    {
        $url = $this->url.$method;
        if (!empty($parameters)) {
            $url .= "?".http_build_query($parameters);
        }
        $response = $this->client->request($verb, $url);
        return json_decode($response->getBody(), true);
    }

    public function me()
    {
        $uri = new Uri($this->url . 'members/me.json');
        $data = $this->createAuth($uri->getPath(), [], 'GET' );
        $response = $this->client->request('GET', $uri->withQuery($data));
        return json_decode($response->getBody(), true);
    }

    private function createAuth($path, $apiParams, $verb)
    {
        if (empty($this->key) || empty($this->secret)) {
            throw new ACXAPIException("API key and secrect can't be empty");
        }

        static $i=0;
        $mt = explode(' ', microtime());
        $apiParams['tonce'] = $mt[1] . substr($mt[0], 2, 3);
        $apiParams['tonce'] += $i++%900;
        $apiParams['access_key'] = $this->key;
        ksort($apiParams);
        $query = http_build_query($apiParams, '', '&');
        // Server received decoded value
        $query = preg_replace('/%5B[0-9]*([a-z]+)?%5D/simU', '[\1]', $query);
        $signature = hash_hmac('sha256', "{$verb}|{$path}|{$query}", $this->secret);
        return $query .'&signature=' . $signature;
    }
}
