<?php

namespace App\Service\User;

use App\Service\EntityService\SaveEntity;

class ConfirmUser
{
    private $saveEntity;

    /**
     * @param SaveEntity $saveEntity
     */
    public function __construct(SaveEntity $saveEntity)
    {
        $this->saveEntity = $saveEntity;
    }
    
    /**
     * @param User $user
     */
    public function confirm($user)
    {   
        $user->setConfirmed(true);
        $this->saveEntity->save($user);
    }
}