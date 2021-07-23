<?php

namespace App\Service\Mailer;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class CurrencyEventMailer
{
    private $mailer;
    private $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    public function send()
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $currencyMin = $user->getCurrencyEventMin();
            $currencyMax = $user->getCurrencyEventMax();

            if ($currencyMin || $currencyMax) {
                $email = (new TemplatedEmail());
                $email
                    ->from(new Address('currency_rate@example.com', 'CurrencyRate'))
                    ->to(new Address($user->getEmail(), $user->getName()))
                    ->subject('Powiadomienie o zmianie wartości wybranej waluty')
                    ->htmlTemplate('Emails/CurrencyEventEmail.html.twig')
                    ->context([
                    'user' => $user
                    ]);
                
                $this->mailer->send($email);

                return $email;
            }
        }
    }
}