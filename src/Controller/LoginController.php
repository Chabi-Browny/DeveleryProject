<?php

namespace App\Controller;

use App\Controller\Prototype\BaseController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends BaseController
{
    #[Route('/login', name: 'appLogin', methods: ['get'])]
    public function index(): Response
    {
        return $this->renderer('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/login', methods: ['post'])]
    public function login()
    {
        dd('?');
    }
}
