<?php 

namespace App\Service;

use App\Entity\CurrencyRate;
use Doctrine\ORM\EntityManagerInterface;

class PopulateCurrencyRate
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param stdClass[]
     */
    public function populate($actualCurrencyRate)
    {
        $this->purgeCurrencyRate->purge();

        $quantity = count($actualCurrencyRate);

        for ($i = 0; $i < $quantity; $i++) {
            $currency = new CurrencyRate();

            $currency->setCurrency($actualCurrencyRate[$i]->currency)
                ->setCode($actualCurrencyRate[$i]->code)
                ->setMid($actualCurrencyRate[$i]->mid);
           
            $this->entityManager->persist($currency); 
        }
        $this->entityManager->flush();
    }
}