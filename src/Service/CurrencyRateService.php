<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class CurrencyRateService
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}