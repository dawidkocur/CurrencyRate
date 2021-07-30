<?php

namespace App\Service;

use App\DTO\UserCurrency;
use App\Entity\CurrencyRate;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CheckCurrenciesRate
{
    private $entityManager;
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    public function check()
    {
        $currencies = $this->entityManager->getRepository(CurrencyRate::class)->findAll();
        
        /** @var UserRepository @userRepo */
        $userRepo = $this->entityManager->getRepository(User::class);
        $users = $userRepo->searchConfirmedUsers();

        foreach ($currencies as $currency) {
            $rate = $currency->getMid();
            $name = $currency->getCurrency();
            
            foreach ($users as $user) {
                $userCurrencies = $user->getCurrencies();
                
                foreach ($userCurrencies as $userCurrency) {
                    $data = json_encode($userCurrency);
                    $userCurrencyObject = $this->serializer
                    ->deserialize($data, UserCurrency::class, 'json');
                    
                    if ($userCurrencyObject->currency === $name) {
                        
                        if ($rate <= $userCurrencyObject->min) {
                            $array = $user->getCurrencyEventMin();
                            array_push($array, $name.' - '.$rate);
                            $user->setCurrencyEventMin($array);
                            $this->entityManager->persist($user);
                        
                        } else if ($rate >= $userCurrencyObject->max) {
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