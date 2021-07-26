<?php

namespace App\Service\CurrencyAPI;

class RequestTokenAuth extends CustomRequest
{
    /**
     * @param string $url
     * @param string $requestType
     * @param mixed $data
     * @param string $token
     */
    public function sendRequest($url, $requestType, $data = '')
    {
        curl_setopt($this->client, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        return $this->execute($url, $requestType, $data);
    }
}