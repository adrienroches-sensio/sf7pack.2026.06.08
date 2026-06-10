<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class AuthorController extends AbstractController
{
    #[Route('/authors', name: 'app_authors', methods: ['GET'])]
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('author/list.html.twig', [
            'authors' => $authorRepository->listAll(),
        ]);
    }

    #[Route('/authors/{id}', name: 'app_author_show', methods: ['GET'], requirements: ['id' => Requirement::POSITIVE_INT])]
    public function show(AuthorRepository $authorRepository, int $id): Response
    {
        return $this->render('author/show.html.twig', [
            'author' => $authorRepository->getById($id),
        ]);
    }
}
