<?php

namespace App\Service\CurrencyAPI;

class RequestTokenAuth extends CustomRequest
{
    /**
     * @param string $url
     * @param string $requestType
     * @param mixed $data
     * @param array $credentials
     * 
     * @return json
     */
    public function sendRequest($url, $requestType, $data = '', $credentials)
    {
        curl_setopt($this->client, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        return $this->execute($url, $requestType, $data);
    }
}