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
                'max' => '4.0000'
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

        $currency = new CurrencyRate();
        $currency
            ->setCurrency('euro')
            ->setCode('euo')
            ->setMid(4.525);

        $entityManager->persist($currency);
        $entityManager->flush();
    }
}