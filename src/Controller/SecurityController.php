<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\CreateNewUser;
use App\Service\User\ConfirmUser;
use App\Service\EntityService\SaveEntity;
use App\Service\Mailer\UserRegistrationMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register_email", name="registerEmail")
     */
    public function registerEmail(Request $request, CreateNewUser $createNewUser, SaveEntity $saveEntity,
        UserRegistrationMailer $userRegistrationMailer)
    {
        $data = json_decode($request->getContent(), true);
        $user = $createNewUser->create($data);

        $saveEntity->save($user);
        $userRegistrationMailer->send($user);  

        return new JsonResponse('Perfect!');
    }

    /**
     * @Route("/confirm/{email}", name="confirm")
     */
    public function confirmRegistration(User $user, ConfirmUser $confirmUser)
    {
        $confirmUser->confirm($user);

        return new RedirectResponse('https://127.0.0.1:8000/');
    }
}
