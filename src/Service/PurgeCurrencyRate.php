<?php 

namespace App\Service;

use App\Entity\CurrencyRate;

class PurgeCurrencyRate extends CurrencyRateService
{
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