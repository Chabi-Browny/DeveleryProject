<?php

namespace App\Controller;

use App\Controller\Prototype\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends BaseController
{
    #[Route('/contact', name: 'contact')]
    public function index(): Response
    {
        return $this->renderer('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    #[Route('/submitContact', methods:['post'])]
    public function submitForm(Request $request)
    {
        dd($request);
    }
}
