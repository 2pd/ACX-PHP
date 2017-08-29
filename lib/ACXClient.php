<?php

namespace ACX;

class ACXAPIException extends \ErrorException {};

class ACXClient
{
    protected $key;     // API key
    protected $secret;  // API secret
    protected $url;     // API base URL
    protected $version; // API version
    protected $client;    // http request

    function __construct($key, $secret, $url = 'https://acx.io/api', $version = '2', $sslverify = true)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->url = $url;
        $this->version = $version;

        if (!$this->client) {
            $this->client = new \GuzzleHttp\Client();
        }
    }

    function QueryPublic($method, array $request = array())
    {
        // build the POST data string
        $postdata = http_build_query($request, '', '&');

        // // make request
        // curl_setopt($this->curl, CURLOPT_URL, );
        // curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postdata);
        // curl_setopt($this->curl, CURLOPT_HTTPHEADER, array());

        $request = $this->client->request('GET', $this->url . '/v' . $this->version . '/' . $method);

        if (){
            
        }

        $result = curl_exec($this->curl);
        if($result===false)
            throw new ACXAPIException('CURL error: ' . curl_error($this->curl));

        // decode results
        $result = json_decode($result, true);
        if(!is_array($result))
            throw new ACXAPIException('JSON decode error');

        return $result;
    }

    function __destruct()
    {
        curl_close($this->curl);
    }

}
