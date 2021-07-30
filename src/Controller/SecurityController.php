<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\CreateNewUser;
use App\Service\User\ConfirmUser;
use App\Service\EntityService\SaveEntity;
use App\Service\Mailer\UserRegistrationMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register_email", name="registerEmail", methods={"POST"})
     */
    public function registerEmail(Request $request, SaveEntity $saveEntity,
        UserRegistrationMailer $userRegistrationMailer, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $violations = $validator->validate($user);
        if ($violations->count() > 0) {
            return $this->json($violations, 400);
        }
 
        $saveEntity->save($user);
        $userRegistrationMailer->send($user);  

        return $this->json($user, 201, []);
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
