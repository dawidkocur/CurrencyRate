<?php

namespace App\Service;

use App\Entity\CurrencyRate;
use App\Service\EntityService\SaveMultipleEntities;
use Symfony\Component\Serializer\SerializerInterface;

class GetCurrencyRates
{
    private $serializer;
    private $saveMultipleEntities;

    public function __construct(SerializerInterface $serializer, SaveMultipleEntities $saveMultipleEntities)
    {
     $this->serializer = $serializer;   
     $this->saveMultipleEntities = $saveMultipleEntities;   
    }

    /**
     * @param array $data
     */
    public function get($data)
    {
        foreach($data as $row) {
            foreach($row['rates'] as $actualCurrency) {
                $actualCurrencies[] = $actualCurrency;
            }
        };

        foreach ($actualCurrencies as $row) {
            $actualCurrency = json_encode($row);
            $currencyRate[] = $this->serializer->deserialize($actualCurrency, CurrencyRate::class, 'json');
        }

        $this->saveMultipleEntities->save($currencyRate);

        return $currencyRate;
    }
}