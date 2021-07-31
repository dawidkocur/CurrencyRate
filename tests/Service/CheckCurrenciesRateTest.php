<?php

namespace App\Tests\Service;

use App\Factory\UserFactory;
use App\Service\CheckCurrenciesRate;
use Zenstruck\Foundry\Test\ResetDatabase;

class CheckCurrenciesRateTest extends CustomKernelTestCase
{
    use ResetDatabase;

    public function testCheckCurrenciesRateTest(): void
    {
        $kernel = self::bootKernel();

        $entityManager = $this->getEntityManager();
        $serializer = $this->getSerializer();

        $user1 = $this->createUser();
        $user2 = UserFactory::createOne([
            'currencies' => array(
                [
                'currency' => 'euro',
                'min' => '4.2000',
                'max' => '5.0000',
                ],
                [
                'currency' => 'dolar',
                'min' => '3.5500',
                'max' => '4.0000'
                ]
            )
        ]);
        
        $user3 = UserFactory::createOne([
            'currencies' => array(
                [
                'currency' => 'bat',
                'min' => '1.5000',
                'max' => '2.0000',
                ]
            )
        ]);
        
        $this->CreateCurrencyRate();

        $checkCurrenciesRate = new CheckCurrenciesRate($entityManager, $serializer);
        $checkCurrenciesRate->check();
       
        $entityManager->refresh($user1);
        $user2->refresh();
        $user3->refresh();

        $this->assertSame('euro - 4.525', $user1->getCurrencyEventMin()[0]);
        $this->assertSame('funt - 5.9', $user1->getCurrencyEventMax()[0]);

        $this->assertSame('dolar - 4.1', $user2->getCurrencyEventMax()[0]);
        $this->assertEmpty($user2->getCurrencyEventMin());

        $this->assertEmpty($user3->getCurrencyEventMin());
        $this->assertEmpty($user3->getCurrencyEventMax());
       
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }#php bin/phpunit --filter=testCheckCurrenciesRateTest
}
