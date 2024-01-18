<?php

namespace App\Controller;

use App\Controller\Prototype\BaseController;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use App\Service\PaginationService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route('/users')]
class UsersController extends BaseController
{
    /**/
    #[Route('/{page}', requirements: ['page' => '\d+'], name: 'app_users_index', methods: ['GET'])]
    public function index(Environment $twig, UsersRepository $usersRepository, int $page = 1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $limit = 2;

        $paginateServ = new PaginationService($twig);

        $paginateServ->initPagination(
            'app_users_index',
            $page,
            $usersRepository->count([]),
            $limit
        );

        return $this->renderer('users/index.html.twig', [
            'users' => $usersRepository->findBy([], null, $paginateServ->getLimit(), $paginateServ->getOffset($page)),
            'pagi' => $paginateServ->renderPagi()
        ]);
    }

    /**/
    #[Route('/new', name: 'app_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderer('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**/
    #[Route('/show/{id}', name: 'app_users_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->renderer('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**/
    #[Route('/{id}/edit', name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderer('users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADIMN');

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
