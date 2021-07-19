<?php

namespace App\Service\EntityService;

use App\Service\EntityService\EntityService;

class RemoveEntity extends EntityService
{
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}