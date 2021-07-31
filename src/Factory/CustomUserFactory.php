<?php

namespace App\Factory;

use App\Entity\User;

abstract class CustomUserFactory
{
    /**
     * @return User
     */
    protected function createUser(): User
    {
        /** @var User $user */
        $user = new User;
        
        return $user;
    }
}