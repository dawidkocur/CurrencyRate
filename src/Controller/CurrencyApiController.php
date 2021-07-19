<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CheckCurrenciesRate;
use App\Service\CurrencyAPI\RequestTokenAuth;
use App\Service\Mailer\CurrencyEventMailer;
use App\Service\EntityService\RemoveEntity;
use App\Service\GetCurrencyObjects;
use App\Service\PopulateCurrencyRate;
use App\Service\User\PurgeUserCurrencyEvents;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class CurrencyApiController extends AbstractController
{
    /**
     * @Route("/currency_api", name="currencyApi")
     */
    public function currencyApi(RequestTokenAuth $requestTokenAuth, GetCurrencyObjects $getCurrencyObjects,
        PopulateCurrencyRate $updateCurrencyRate, RouterInterface $router)
    {
        $data = $requestTokenAuth->sendRequest('http://api.nbp.pl/api/exchangerates/tables/A/', 'GET');
        
        $currencyObjects = $getCurrencyObjects->get($data);
        $updateCurrencyRate->populate($currencyObjects);

        return new RedirectResponse($router->generate('checkCurrency'));
    }

    /**
     * @Route("/check_currency", name="checkCurrency")
     */
    public function checkCurrencies(CheckCurrenciesRate $checkCurrenciesRate, CurrencyEventMailer $CurrencyEventMailer,
        PurgeUserCurrencyEvents $purgeUserCurrencyEvents)
    {
        $checkCurrenciesRate->check();        
        $CurrencyEventMailer->send();
        $purgeUserCurrencyEvents->purge();
        
        $data = 'lol';
        return $this->Json($data);
    }

    /**
     * @Route("/remove_user/{email}", name="removeUser")
     */
    public function removeUser(User $user, RemoveEntity $removeEntity)
    {
        $removeEntity->remove($user);

        return $this->json('done');
    }
}
