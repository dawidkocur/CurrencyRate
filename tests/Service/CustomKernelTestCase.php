<?php

namespace App\tests\Service;

use App\Entity\CurrencyRate;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomKernelTestCase extends KernelTestCase
{
    protected function getEntityManager()
    {
        $entityManager = static::getContainer()->get('doctrine.orm.default_entity_manager');

        return $entityManager;
    }

    protected function getSerializer()
    {
        $serializer = static::getContainer()->get('serializer');

        return $serializer;
    }

    /**
     * @return User
     */
    protected function createUser()
    {
        $entityManager = $this->getEntityManager();

        $user = new User();
        $user
            ->setEmail('dawid@example.com')
            ->setName('Dawid')
            ->setSurname('Nowak')
            ->setPhoneNumber('398765432')
            ->setBirthDate(new \DateTimeImmutable('1992-04-21'))
            ->setCurrencies([
                [
                'currency' => 'euro',
                'min' => '4.5500',
                'max' => '5.0000'
                ],
                [
                'currency' => 'dolar',
                'min' => '3.5500',
                'max' => '4.3000'
                ],
                [
                'currency' => 'funt',
                'min' => '4.7000',
                'max' => '5.7000'
                ]
            ])
            ->setConfirmed(true);
        
            $entityManager->persist($user);
            $entityManager->flush();

        return $user;
    }

    protected function CreateCurrencyRate()
    {
        $entityManager = $this->getEntityManager();

        $currency1 = new CurrencyRate();
        $currency1
            ->setCurrency('euro')
            ->setCode('euo')
            ->setMid(4.5250);
        
        $currency2 = new CurrencyRate();
        $currency2
            ->setCurrency('funt')
            ->setCode('fnt')
            ->setMid(5.9000);

        $currency3 = new CurrencyRate();
        $currency3
            ->setCurrency('dolar')
            ->setCode('usd')
            ->setMid(4.1000);

        $currency4 = new CurrencyRate();
        $currency4
            ->setCurrency('bat')
            ->setCode('bta')
            ->setMid(1.9000);

        $entityManager->persist($currency1);
        $entityManager->persist($currency2);
        $entityManager->persist($currency3);
        $entityManager->persist($currency4);

        $entityManager->flush();
    }
}