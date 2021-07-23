<?php

namespace App\Tests\Service;

use App\Service\CheckCurrenciesRate;
use Zenstruck\Foundry\Test\ResetDatabase;

class CheckCurrenciesRateTest extends CustomKernelTestCase
{
    use ResetDatabase;

    public function testCheckCurrenciesRateTest(): void
    {
        $kernel = self::bootKernel();

        $entityManager = $this->getEntityManager();
        $user = $this->createUser();
        $this->CreateCurrencyRate();

        $checkCurrenciesRate = new CheckCurrenciesRate($entityManager);
        $checkCurrenciesRate->check();
       
        $entityManager->refresh($user);

        $this->assertSame('euro - 4.525', $user->getCurrencyEventMin()[0]);
        $this->assertEmpty($user->getCurrencyEventMax());
       
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }#php bin/phpunit --filter=testCheckCurrenciesRateTest
}
