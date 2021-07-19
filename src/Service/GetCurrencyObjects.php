<?php

namespace App\Service;

class GetCurrencyObjects
{
    public function get($data)
    {
        $actualCurrencies = [];

        foreach($data as $row) {
            foreach($row['rates'] as $k) {
                 $actualCurrencies[] = $k;
            }
        };

        $objects = json_decode(json_encode($actualCurrencies), false);
        
        return $objects;
    }
}