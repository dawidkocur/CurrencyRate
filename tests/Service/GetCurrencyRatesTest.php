<?php

namespace App\Tests\Service;

use App\Entity\CurrencyRate;
use App\Service\CurrencyAPI\RequestTokenAuth;
use App\Service\EntityService\SaveMultipleEntities;
use App\Service\GetCurrencyRates;
use App\tests\Service\CustomKernelTestCase;

class GetCurrencyRatesTest extends CustomKernelTestCase
{
    public function testGetCurrencyObjects(): void
    {
        $requestTokenAuth = new RequestTokenAuth();
        $data = $requestTokenAuth->sendRequest('http://api.nbp.pl/api/exchangerates/tables/A/', 'GET', null);

        $saveMultipleEntities = $this->createMock(SaveMultipleEntities::class);
        $saveMultipleEntities->expects($this->once())
            ->method('save');

        $currencyRates = new GetCurrencyRates($this->getSerializer(), $saveMultipleEntities);
        $result = $currencyRates->get($data);

        $this->assertInstanceOf(CurrencyRate::class, $result[0]);
        $this->assertSame('bat (Tajlandia)', $result[0]->getCurrency());
        $this->assertCount(35, $result);
        
        $this->assertTrue(true);
    }#php bin/phpunit --filter=testGetCurrencyObjects
}
