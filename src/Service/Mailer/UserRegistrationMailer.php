<?php

namespace App\Service\Mailer;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class UserRegistrationMailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param User $user
     * @return TemplatedEmail $email
     */
    public function send($user): TemplatedEmail
    {
        $email = (new TemplatedEmail())
        ->from(new Address('currency_rate@example.com', 'CurrencyRate'))
        ->to(new Address($user->getEmail(), $user->getName()))
        ->subject('Witaj w naszej aplikacji')
        ->htmlTemplate('Emails/UserRegistrationEmail.html.twig')
        ->context([
            'user' => $user
        ]);
    
        $this->mailer->send($email);

        return $email;
    }
}