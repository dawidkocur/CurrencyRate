<?php

namespace App\Service\Mailer;

use App\Entity\User;
use App\Repository\UserRepository;
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

    /**
     * @return TemplatedEmail $email
     */
    public function send()
    {
        /** @var UserRepository $userRepo  */
        $userRepo = $this->entityManager->getRepository(User::class);
        $users = $userRepo->searchUsersWithCurrencyEvent();

        foreach ($users as $user) {

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