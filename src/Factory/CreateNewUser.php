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
        $object = (object) $data;

        $user
        ->setEmail($object->email)
        ->setName($object->name)
        ->setSurname($object->surname)
        ->setPhoneNumber($object->phoneNumber)
        ->setBirthDate(new \DateTimeImmutable($object->birthDate))
        ->setCurrencies($object->currencies)
        ->setConfirmed(false);

        return $user;
    }
}