<?php

namespace App\Service\EntityService;

use Doctrine\ORM\EntityManagerInterface;

abstract class EntityService
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}