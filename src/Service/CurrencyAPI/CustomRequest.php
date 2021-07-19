<?php

namespace App\Service\CurrencyAPI;

abstract class CustomRequest
{
    protected function execute($client, $url, $requestType, $data = '')
    {
        curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
        # CURLOPT_SSL_VERIFYPEER = false only for dev env while testing in localhost, to avoid
        # error: SSL certificate error: self signed certificate in certificate

        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client, CURLOPT_CUSTOMREQUEST, $requestType);
        curl_setopt($client, CURLOPT_POSTFIELDS, $data);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($client, CURLOPT_FAILONERROR, true);
 
        $response = curl_exec($client);
        $error = curl_error($client);
        $errorNumber = curl_errno($client);
 
        curl_close($client);
 
        if (0 !== $errorNumber) {
            throw new \RuntimeException($error, $errorNumber);
        }
 
        return json_decode($response, true);
    }
}