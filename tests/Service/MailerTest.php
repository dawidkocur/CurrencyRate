<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\Mailer\CurrencyEventMailer;
use App\Service\Mailer\UserRegistrationMailer;
use App\tests\Service\CustomKernelTestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Zenstruck\Foundry\Test\ResetDatabase;

class MailerTest extends CustomKernelTestCase
{
    use ResetDatabase;

    public function testUserRegistrationMailer(): void
    {
        $kernel = self::bootKernel();
        
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())
            ->method('send');

        $user = new User();
        $user->setName('Dawid')
            ->setEmail('dawid@example.com');

        $mailer = new UserRegistrationMailer($symfonyMailer);
        $email = $mailer->send($user);
        $fromAddress = $email->getFrom()[0];

        $this->assertSame('Witaj w naszej aplikacji', $email->getSubject());
        $this->assertCount(1, $email->getTo());
        $this->assertIsObject($fromAddress);
        $this->assertInstanceOf(Address::class, $fromAddress);
        $this->assertSame('currency_rate@example.com', $fromAddress->getAddress());
        $this->assertSame('CurrencyRate', $fromAddress->getName());
        
        /** @var Address[] $addresses */
        $addresses = $email->getTo();
        $this->assertInstanceOf(Address::class, $addresses[0]);
        $this->assertSame('Dawid', $addresses[0]->getName());
        $this->assertSame('dawid@example.com', $addresses[0]->getAddress());
    }

    public function testCurrencyEventMailer()
    {
        $kernel = self::bootKernel();
        $entityManager = self::getContainer()->get('doctrine')->getManager();

        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())
            ->method('send');

        $user = $this->createUser()
            ->setCurrencyEventMax(['euro - 4.5542']);
        $entityManager->persist($user);
        $entityManager->flush();
 
        $currencyEventMailer =  new CurrencyEventMailer($symfonyMailer, $entityManager);
        $email = $currencyEventMailer->send();
        
        /** @var Address $fromAddress */
        $fromAddress = $email->getFrom()[0];

        $this->assertSame('Powiadomienie o zmianie wartości wybranej waluty', $email->getSubject());
        $this->assertCount(1, $email->getTo());
        $this->assertIsObject($fromAddress);
        $this->assertInstanceOf(Address::class, $fromAddress);
        $this->assertSame('currency_rate@example.com', $fromAddress->getAddress());
        $this->assertSame('CurrencyRate', $fromAddress->getName());
        
        /** @var Address[] $addresses*/
        $addresses = $email->getTo();
        $this->assertInstanceOf(Address::class, $addresses[0]);
        $this->assertSame('dawid@example.com', $addresses[0]->getAddress());
        $this->assertSame('Dawid', $addresses[0]->getName());
    }
}#php bin/phpunit --filter=testCurrencyEventMailer