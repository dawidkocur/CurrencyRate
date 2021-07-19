<?php

namespace App\Service\Mailer;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class UserRegistrationMailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($user)
    {
        $email = (new TemplatedEmail())
        ->from('example@example.com')
        ->to($user->getEmail())
        ->subject('Witaj w naszej aplikacji')
        ->htmlTemplate('Emails/UserRegistrationEmail.html.twig')
        ->context([
            'user' => $user
        ]);
    
        $this->mailer->send($email);
    }
}