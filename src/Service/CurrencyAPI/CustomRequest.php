<?php

namespace App\Service\CurrencyAPI;

abstract class CustomRequest
{
    protected $client;

    public function __construct()
    {
        $this->client = curl_init();
    }

    abstract protected function sendRequest($url, $requestType, $credentials, $data = '');

    protected function execute($url, $requestType, $data)
    {
        curl_setopt($this->client, CURLOPT_SSL_VERIFYPEER, false);
        # CURLOPT_SSL_VERIFYPEER = false only for dev env while testing in localhost, to avoid
        # error: SSL certificate error: self signed certificate in certificate

        curl_setopt($this->client, CURLOPT_URL, $url);
        curl_setopt($this->client, CURLOPT_CUSTOMREQUEST, $requestType);
        curl_setopt($this->client, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->client, CURLOPT_POSTFIELDS, $data);
        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->client, CURLOPT_FAILONERROR, true);
 
        $response = curl_exec($this->client);
        $error = curl_error($this->client);
        $errorNumber = curl_errno($this->client);
 
        curl_close($this->client);
 
        if (0 !== $errorNumber) {
            throw new \RuntimeException($error, $errorNumber);
        }
 
        return json_decode($response, true);
    }
}