<?php

namespace App\Tests\Service;

use App\Service\CurrencyAPI\RequestTokenAuth;
use App\Service\GetCurrencyObjects;
use PHPUnit\Framework\TestCase;
use stdClass;

class GetCurrencyObjectsTest extends TestCase
{
    public function testGetCurrencyObjects(): void
    {
        $requestTokenAuth = new RequestTokenAuth();
        $data = $requestTokenAuth->sendRequest('http://api.nbp.pl/api/exchangerates/tables/A/', 'GET');

        $currencyObjects = new GetCurrencyObjects();
        $objects = $currencyObjects->get($data);
        
        $this->assertInstanceOf(stdClass::class, $objects[0]);
        $this->assertSame('bat (Tajlandia)', $objects[0]->currency);
        $this->assertCount(35, $objects);
        
        $this->assertTrue(true);
    }#php bin/phpunit --filter=testGetCurrencyObjects
}
