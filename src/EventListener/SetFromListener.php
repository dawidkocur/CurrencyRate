<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SetFromListener implements EventSubscriberInterface
{
    public function onMessage(MessageEvent $event)
    {
        $email = $event->getMessage();
        if (!$email instanceof Email) {
            return;
        }

        $email->from(new Address('currency_rate@example.com', 'CurrencyRate'));
    }

    public static function getSubscribedEvents()
    {
        return [
            MessageEvent::class => 'onMessage'
        ];
    }
}