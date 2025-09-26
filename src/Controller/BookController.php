<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\Security;

#[Route('/book')]
final class BookController extends AbstractController
{
    private RouterInterface $_router;
    private CsrfTokenManagerInterface $_csrfTokenManager;
    private $_em;
    public function __construct(EntityManagerInterface $em, CsrfTokenManagerInterface $csrf, RouterInterface $router){
        $this->_em = $em;
        $this->_router = $router;
        $this->_csrfTokenManager = $csrf;
    }

    #[Route(name: 'app_book_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $bookData = array_map(function ($book){
            return [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'pages' => $book->getNumPages(),
                'writer'=> $book->getWriter()->isBirthBeforeChrist() ? 
                                "{$book->getWriter()->getName()}, {$book->getWriter()->getBirthdate()->format('Y')} BC - ??" :
                                "{$book->getWriter()->getName()}, {$book->getWriter()->getBirthdate()->format('Y')} AD - ??",
                'deleteUrl' => $this->_router->generate('app_book_delete', ['id' => $book->getId()]),
                'csrfToken' => $this->_csrfTokenManager->getToken('delete' . $book->getId())->getValue(),
            ];
        }, $books);

        return $this->render('book/index.html.twig', [
            'bookJson'=> json_encode($bookData),
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Security $security): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->persist($book);
            $this->_em->flush();

            if ($security->isGranted('ROLE_ADMIN') || $security->isGranted('ROLE_MANAGER')) {
                return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
            }
            else {
                return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);

    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_book_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->getPayload()->getString('_token'))) {
            $this->_em->remove($book);
            $this->_em->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
