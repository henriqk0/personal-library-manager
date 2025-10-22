<?php

namespace App\Controller;
use App\Entity\Status;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use DateTime;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class StatusController extends AbstractController
{
    private RouterInterface $_router;
    private CsrfTokenManagerInterface $_csrfTokenManager;
    private $_em;
    public function __construct(EntityManagerInterface $em, CsrfTokenManagerInterface $csrf, RouterInterface $router){
        $this->_em = $em;
        $this->_router = $router;
        $this->_csrfTokenManager = $csrf;
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
        $statuses = $statusRepository->findBy(['reader' => $this->getUser()]);

        $statusesData = array_map(function ($status){
            return [
                'id' => $status->getId(),
                'title' => $status->getBook()->getTitle(),
                'pages' => $status->getBook()->getNumPages(),
                'current'=> $status->getCurrentPage(),
                'deleteUrl' => $this->_router->generate('app_status_delete', ['id' => $status->getId()]),
                'csrfToken' => $this->_csrfTokenManager->getToken('delete' . $status->getId())->getValue(),
            ];
        }, $statuses);

        return $this->render('status/index.html.twig', [
            'statusJson'=> json_encode($statusesData),
        ]);
    }

    
    #[Route(path:'/read/{id}', name:'app_status_show', methods: ['GET', 'POST'])]
    #[IsGranted('view', 'status', 'Read not found', 404)]
    public function show(Request $request, Status $status): Response
    {
        # duplicating the code of the method for editing in order to add an editing session on the same screen 
        # CHANGE EDIT TO API, LATER
        $form = $this->createForm(StatusType::class, $status, ['updating' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->flush();

            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('status/show.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path:'/read/{id}/edit', name:'app_status_edit', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'status', 'Read not found', 404)]
    public function edit(Request $request, Status $status): Response
    {
        ($status->getCompletionDate() != Null) ?
            $form = $this->createForm(StatusType::class, $status, ['updating' => true, 'empty_data' => false])
        : 
            $form = $this->createForm(StatusType::class, $status, ['updating' => true]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($status->getCurrentPage() === $status->getBook()->getNumPages()) {
                $status->setCompletionDate(new \DateTime());
            }
            else if ($status->getCompletionDate() != Null) {
                $status->setCompletionDate(null);
            }

            $this->_em->flush();

            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('status/edit.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path:'/read/{id}/delete', name:'app_status_delete', methods: ['POST'])]
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

    #[Route(path:'overview', name:'app_overview', methods: ['GET'])]
    public function dashboard(StatusRepository $statusRepository): Response
    {   
        return $this->render('status/overview.html.twig');
    }

    # starting change to api
    #[Route(path:'api/overview', name:'api_overview')]
    public function overviewApi(StatusRepository $statusRepository): JsonResponse
    {   
        $statuses = $statusRepository->findBy(['reader' => $this->getUser()]);

        $statusesData = array_map(function ($status){
            return [
                'title' => $status->getBook()->getTitle(),
                'pages' => $status->getBook()->getNumPages(),
                'current'=> $status->getCurrentPage(),
                'start_date'=> $status->getStartingDate(),
                'finish_date'=> $status->getCompletionDate(),
            ];
        }, $statuses);  # finished status number will be processed in frontend 

        usort($statusesData, function ($a, $b) {
            return $a['start_date'] <=> $b['start_date'];
        });

        return $this->json($statusesData);
    }
}
