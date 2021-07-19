<?php 

namespace App\Service;

use App\Entity\CurrencyRate;
use Doctrine\ORM\EntityManagerInterface;

class PurgeCurrencyRate
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function purge()
    {
        $currencyRate = $this->entityManager->getRepository(CurrencyRate::class)->findAll();

        if (!empty($currencyRate)) {
            foreach ($currencyRate as $row) {
                $this->entityManager->remove($row);
            }
            $this->entityManager->flush();   
        } else {
            return;
        }
    }
}