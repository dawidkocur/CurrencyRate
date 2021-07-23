<?php

namespace App\Service;

use App\Entity\CurrencyRate;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CheckCurrenciesRate
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function check()
    {
        $currencies = $this->entityManager->getRepository(CurrencyRate::class)->findAll();
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($currencies as $currency) {
            $rate = $currency->getMid();
            $name = $currency->getCurrency();
            
            foreach ($users as $user) {
                $userCurrencies = $user->getCurrencies();
                $currencyObjects = json_decode(json_encode($userCurrencies), false) ;
                    
                foreach ($currencyObjects as $object) {
                    $currencyObject = $object;
                    
                    if ($currencyObject->currency === $name) {
                        
                        if ($rate <= $currencyObject->rates->min) {
                            $array = $user->getCurrencyEventMin();
                            array_push($array, $name.' - '.$rate);
                            $user->setCurrencyEventMin($array);
                            $this->entityManager->persist($user);
                        
                        } else if ($rate >= $currencyObject->rates->max) {
                            $array = $user->getCurrencyEventMax();
                            array_push($array, $name.' - '.$rate);
                            $user->setCurrencyEventMax($array);
                            $this->entityManager->persist($user);
                        }  
                    }        
                }    
            }
        }
        $this->entityManager->flush();   
    }   
}