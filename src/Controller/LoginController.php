<?php

namespace App\Controller;

use App\Controller\Prototype\BaseController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends BaseController
{
//    #[Route('/login', name: 'appLogin', methods: ['get'])]
    #[Route('/login', name: 'appLogin')]
    public function index(AuthenticationUtils $authenticator): Response
    {
        return $this->renderer('login/index.html.twig', [
            'errors' => $authenticator->getLastAuthenticationError(),
            'lastUsername' => $authenticator->getLastUsername()
        ]);
    }

}
