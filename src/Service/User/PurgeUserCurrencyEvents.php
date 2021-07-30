<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class PurgeUserCurrencyEvents
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function purge()
    {
        /** @var UserRepository @userRepo */
        $userRepo = $this->entityManager->getRepository(User::class);
        $users = $userRepo->searchUsersWithCurrencyEvent();
        
        foreach ($users as $user) {
            $user->setCurrencyEventMin(array());
            $user->setCurrencyEventMax(array());

            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }
}