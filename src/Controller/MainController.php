<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main_index')]
    public function index(): Response
    {
        return new Response('Homepage - Community Library');
    }

    #[Route('/about', name: 'app_main_about')]
    public function about(): Response
    {
        return new Response('About - Community Library');
    }

    #[Route('/contact', name: 'app_main_contact')]
    public function contact(): Response
    {
        return new Response('Contact - Community Library');
    }
}
