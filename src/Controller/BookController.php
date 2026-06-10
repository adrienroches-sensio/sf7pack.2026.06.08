<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    private function getBooks(): array
    {
        return [
            'the-lord-of-the-rings' => [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'year' => 1954,
                'genre' => 'Fantasy',
                'description' => 'The epic quest of the Fellowship to destroy the One Ring and defeat the dark lord Sauron in Middle-earth.',
            ],
            'the-eye-of-the-world' => [
                'title' => 'The Eye of the World',
                'author' => 'Robert Jordan',
                'year' => 1990,
                'genre' => 'Fantasy',
                'description' => 'The first book of the Wheel of Time series, following farm boy Rand al\'Thor as destiny pulls him far from his village.',
            ],
            'promise-of-blood' => [
                'title' => 'Promise of Blood',
                'author' => 'Brian McClellan',
                'year' => 2013,
                'genre' => 'Fantasy',
                'description' => 'A revolution has just overthrown the king — but the new government discovers a terrifying prophecy written in the blood of the dead.',
            ],
            'magician' => [
                'title' => 'Magician',
                'author' => 'Raymond E. Feist',
                'year' => 1982,
                'genre' => 'Fantasy',
                'description' => 'A kitchen boy discovers his remarkable magical abilities as his world is invaded by warriors from another realm.',
            ],
            'a-brief-history-of-time' => [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'year' => 1988,
                'genre' => 'Non-Fiction',
                'description' => 'An exploration of cosmology — black holes, the Big Bang, and the nature of time — written for the general reader.',
            ],
        ];
    }

    #[Route('/books', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->listAll(),
        ]);
    }

    #[Route('/books/{id}', name: 'app_book_show')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/books/new', name: 'app_book_new', priority: 1)]
    public function new(): Response
    {
        return new Response('New book form');
    }
}
