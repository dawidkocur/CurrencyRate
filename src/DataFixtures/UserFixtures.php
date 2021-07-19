<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('email@email.com')
            ->setName('Dawid')
            ->setSurname('Kocur')
            ->setPhoneNumber('987654321')
            ->setBirthDate(new \DateTime('1992-04-21'))
            ->setCurrencies([
                array(
                'currency' => 'bat (Tajlandia)',
                'rates' => array(
                     'min' => '0.1190',
                     'max' => '1.0000'
                    )
                ),
                array('currency' => 'korona czeska',
                'rates' => array(
                    'min' => '0.1190',
                    'max' => '0.1780'
                    )   
                ),
                array('currency' => 'euro',
                "rates" => array(
                    'min' => '4.5000',
                    'max' => '4.6000'
                    )   
                ) 
            ]);
         
        $manager->persist($user);
        $manager->flush();
    }
}
