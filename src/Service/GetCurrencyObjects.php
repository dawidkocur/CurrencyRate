<?php

namespace App\Service;

use stdClass;

class GetCurrencyObjects
{
    /**
     * @param array $data
     * @return stdClass[]
     */
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