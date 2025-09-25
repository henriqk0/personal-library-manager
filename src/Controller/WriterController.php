<?php

namespace App\Controller;

use App\Entity\Writer;
use App\Form\WriterType;
use App\Repository\WriterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/writer')]
final class WriterController extends AbstractController
{
    private RouterInterface $_router;
    private CsrfTokenManagerInterface $_csrfTokenManager;
    private $_em;
    public function __construct(
        EntityManagerInterface $em, 
        CsrfTokenManagerInterface $csrf,
        RouterInterface $router, 
        ){
        $this->_em = $em;
        $this->_router = $router;
        $this->_csrfTokenManager = $csrf;
    }

    #[Route(name: 'app_writer_index', methods: ['GET'])]
    public function index(WriterRepository $writerRepository): Response
    {
        $writers = $writerRepository->findAll();

        $writersData = array_map(function ($writer){
            return [
                'id' => $writer->getId(),
                'name' => $writer->getName(),
                'birthdate'=> $writer->isBirthBeforeChrist() ? 
                                "{$writer->getBirthdate()->format('Y-m-d')} BC" :
                                "{$writer->getBirthdate()->format('Y-m-d')} AD",
                'deleteUrl' => $this->_router->generate('app_writer_delete', ['id' => $writer->getId()]),
                'csrfToken' => $this->_csrfTokenManager->getToken('delete' . $writer->getId())->getValue(),
            ];
        }, $writers);

        return $this->render('writer/index.html.twig', [
            'writerJson'=> json_encode($writersData),
        ]);
    }

    #[Route('/new', name: 'app_writer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Security $security): Response
    {
        $writer = new Writer();
        $form = $this->createForm(WriterType::class, $writer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->persist($writer);
            $this->_em->flush();

            if ($security->isGranted('ROLE_ADMIN') || $security->isGranted('ROLE_MANAGER')) {
                return $this->redirectToRoute('app_writer_index', [], Response::HTTP_SEE_OTHER);
            }
            else {
                return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('writer/new.html.twig', [
            'writer' => $writer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_writer_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Writer $writer): Response
    {
        $form = $this->createForm(WriterType::class, $writer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->flush();

            return $this->redirectToRoute('app_writer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('writer/show.html.twig', [
            'writer' => $writer,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_writer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Writer $writer, ): Response
    {
        $form = $this->createForm(WriterType::class, $writer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->flush();

            return $this->redirectToRoute('app_writer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('writer/edit.html.twig', [
            'writer' => $writer,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_writer_delete', methods: ['POST'])]
    public function delete(Request $request, Writer $writer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$writer->getId(), $request->getPayload()->getString('_token'))) {
            $this->_em->remove($writer);
            $this->_em->flush();
        }

        return $this->redirectToRoute('app_writer_index', [], Response::HTTP_SEE_OTHER);
    }
}
