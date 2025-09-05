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


#[Route('/status')]
final class StatusController extends AbstractController
{

    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/new', name: 'app_status_new', methods: ['GET', 'POST'])]
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
            $this->em->persist($status);
            $this->em->flush();

            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('status/new.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route(name: 'app_status_index', methods: ['GET'])]
    public function index(StatusRepository $statusRepository): Response
    {
        return $this->render('status/index.html.twig', [
            'statuses' => $statusRepository->findAll(),
        ]);
    }
}
