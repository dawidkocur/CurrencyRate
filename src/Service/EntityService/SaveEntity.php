<?php

namespace App\Service\EntityService;

use App\Service\EntityService\EntityService;

class SaveEntity extends EntityService
{
    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}