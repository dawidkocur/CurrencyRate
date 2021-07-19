<?php

namespace App\Service\User;

use App\Entity\User;
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
        $users = $this->entityManager->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            $user->setCurrencyEventMin(array());
            $user->setCurrencyEventMax(array());

            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }
}