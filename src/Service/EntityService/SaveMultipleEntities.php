<?php

namespace App\Service\EntityService;

class SaveMultipleEntities extends EntityService
{
    /**
     * @param array $entities
     */
    public function save($entities)
    {
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
        }
                
        $this->entityManager->flush();
    }
}