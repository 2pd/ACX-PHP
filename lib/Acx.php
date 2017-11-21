<?php

namespace ACX;

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
    // function QueryPublic($method, array $request = array())
    // {
        // // build the POST data string
        // $postdata = http_build_query($request, '', '&');

        // // // make request
        // // curl_setopt($this->curl, CURLOPT_URL, );
        // // curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postdata);
        // // curl_setopt($this->curl, CURLOPT_HTTPHEADER, array());

        // $request = $this->client->request('GET', $this->url . '/v' . $this->version . '/' . $method);

        // if (){

        // }

        // $result = curl_exec($this->curl);
        // if($result===false)
            // throw new ACXAPIException('CURL error: ' . curl_error($this->curl));

        // // decode results
        // $result = json_decode($result, true);
        // if(!is_array($result))
            // throw new ACXAPIException('JSON decode error');

        // return $result;
    // }

    // function __destruct()
    // {
        // curl_close($this->curl);
    // }

}
