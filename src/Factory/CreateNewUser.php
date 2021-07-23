<?php

namespace App\Factory;

use App\Entity\User;

class CreateNewUser extends UserFactory
{
    /**
     * @param array $data
     * 
     * @return User
     */
    public function create($data): User
    {
        $user = $this->createUser();
        
        $user
        ->setEmail($data[0]['email'])
        ->setName($data[0]['name'])
        ->setSurname($data[0]['surname'])
        ->setPhoneNumber($data[0]['phoneNumber'])
        ->setBirthDate(new \DateTimeImmutable($data[0]['birthDate']))
        ->setCurrencies($data[0]['currencies'])
        ->setConfirmed(false);

        return $user;
    }
}