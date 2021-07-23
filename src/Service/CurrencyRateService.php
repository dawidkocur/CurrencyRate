<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class CurrencyRateService
{
    protected $entityManager;
    protected $purgeCurrencyRate;
    protected $populateCurrencyRate;

    public function __construct(EntityManagerInterface $entityManager, PurgeCurrencyRate $purgeCurrencyRate,
        PopulateCurrencyRate $populateCurrencyRate)
    {
        $this->entityManager = $entityManager;
        $this->purgeCurrencyRate = $purgeCurrencyRate;
        $this->populateCurrencyRate = $populateCurrencyRate;
    }
}