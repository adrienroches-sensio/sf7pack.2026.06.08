<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BookController extends AbstractController
{
    #[IsGranted('ROLE_LIBRARIAN')]
    #[Route('/admin/books', name: 'admin_books_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'books' => $bookRepository->listAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/books/new', name: 'admin_book_new', methods: ['GET', 'POST'])]
    #[Route('/admin/books/{id}/edit', name: 'admin_book_edit', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Book|null $book = null): Response
    {
        $defaultBook = new Book();
        $defaultBook->setTitle('ChangeMe');

        $book ??= $defaultBook;
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', "Book titled \"{$book->getTitle()}\" successfully created.");

            return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }
}
