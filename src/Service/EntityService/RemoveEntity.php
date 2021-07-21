<?php

namespace App\Service\EntityService;

use App\Service\EntityService\EntityService;

class RemoveEntity extends EntityService
{
    /**
     * @param $entity
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}