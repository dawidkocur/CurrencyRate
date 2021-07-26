<?php 

namespace App\Service;

use App\Entity\CurrencyRate;
use Doctrine\ORM\EntityManagerInterface;

class UpdateCurrencyRate
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param stdClass[] $objects
     */
    public function update($objects)
    {        
        $currencyRate = $this->entityManager->getRepository(CurrencyRate::class)->findAll();

        if (count($currencyRate) !== 0) {
            $objectsQuantity = count($objects);
            
            for ($i = 0; $i <= $objectsQuantity; $i++) {
                
                $currencyRate[$i]->setCurrency($objects[$i]->currency)
                    ->setCode($objects[$i]->code)
                    ->setMid($objects[$i]->mid);
                }
    
            $this->entityManager->flush();
        } else {
            return $this->populateCurrencyRate->populate($objects);
        }
    }
}