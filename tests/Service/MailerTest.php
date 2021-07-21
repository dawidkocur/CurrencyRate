<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\Mailer\UserRegistrationMailer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Mime\Address;

class MailerTest extends TestCase
{
    public function testUserRegistrationMailer(): void
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())
            ->method('send');

        $user = new User();
        $user->setName('Dawid')
            ->setEmail('dawid@example.com');

        $mailer = new UserRegistrationMailer($symfonyMailer);
        $email = $mailer->sendEmail($user);

        $this->assertSame('Witaj w naszej aplikacji', $email->getSubject());
        $this->assertCount(1, $email->getTo());
        
        /** @var Address[] $addresses */
        $addresses = $email->getTo();
        $this->assertInstanceOf(Address::class, $addresses[0]);
        $this->assertSame('Dawid', $addresses[0]->getName());
        $this->assertSame('dawid@example.com', $addresses[0]->getAddress());
    }
}
