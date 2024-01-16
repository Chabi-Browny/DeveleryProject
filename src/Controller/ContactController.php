<?php

namespace App\Controller;

use App\Controller\Prototype\BaseController;
use App\Dto\ContactDto;
use App\Entity\Contact;
use App\Repository\ContactRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**/
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
    public function submitForm (
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    )
    {
        $retVal = null;
        $requestParams = $request->request->all();

        $contactData = new ContactDto(
            $requestParams['cName'],
            $requestParams['cEmail'],
            $requestParams['cMessage']
        );

        $validate = $validator->validate($contactData);

        if (count($validate) > 0)
        {
            $this->addFlash('errors', $validate);
        }
        else
        {
            $contact = new Contact();
            $contact->setName($contactData->name);
            $contact->setEmail($contactData->email);
            $contact->setMessage($contactData->message);

            $entityManager->persist($contact);

            $entityManager->flush();

            $this->addFlash('success', 'Köszönjük szépen a kérdésedet. Válaszunkkal hamarosan keresünk a megadott e-mail címen.');
        }

        return $this->redirectToRoute('contact');
    }

    #[Route('/messageList') ]
    public function listMessages(ContactRepository $contactRepo)
    {
        // checking authorization
        $this->denyAccessUnlessGranted('ROLE_USER');
        // get all message
        $messages = $contactRepo->findAll();

        ////////pagination...

        return $this->renderer('contact/messagesList.html.twig', [
            'messages' => $messages ///(array)$messages
        ]);

    }

}
