<?php

namespace App\Controller;
use App\Entity\Status;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class StatusController extends AbstractController
{
    private $_em;
    public function __construct(EntityManagerInterface $em){
        $this->_em = $em;
    }

    #[Route('/read/new', name: 'app_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if (!$user = $this->getUser()) {
            return $this->redirectToRoute('app_logout');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $status->setReader($user);
            $status->setCurrentPage(0);
            $status->setStartingDate(new DateTime());
            $status->setCompletionDate(null);
            $this->_em->persist($status);
            $this->_em->flush();

            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('status/new.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route(path:'/', name: 'app_status_index', methods: ['GET'])]
    public function index(StatusRepository $statusRepository): Response
    {
        return $this->render('status/index.html.twig', [
            'statuses' => $statusRepository->findBy(['reader' => $this->getUser()]),
        ]);
    }

    
    #[Route(path:'/read/{id}', name:'app_status_show', methods: ['GET'])]
    #[IsGranted('view', 'status', 'Read not found', 404)]
    public function show(Status $status): Response
    {
        return $this->render('status/show.html.twig', [
            'status' => $status,
        ]);
    }

    #[Route(path:'/read/{id}/edit', name:'app_status_edit', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'status', 'Read not found', 404)]
    public function edit(Request $request, Status $status): Response
    {
        $form = $this->createForm(StatusType::class, $status, ['updating' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->flush();

            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('status/edit.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route(path:'/read/{id}', name:'app_status_delete', methods: ['POST'])]
    #[IsGranted('delete', 'status', 'Read not found', 404)]
    public function delete(Request $request, Status $status): Response
    {
        if ($this->isCsrfTokenValid('delete'.$status->getId(), 
        $request->getPayload()->getString('_token'))) {
            $this->_em->remove($status);
            $this->_em->flush();
        }

        return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
