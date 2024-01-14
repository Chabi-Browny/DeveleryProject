<?php

namespace App\Controller;

use App\Controller\Prototype\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    #[Route('/')]
    #[Route('/home')]
    public function index(): Response
    {
        return $this->renderer('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
