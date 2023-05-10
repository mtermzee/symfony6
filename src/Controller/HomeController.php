<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/index', name: 'app_home_index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function homepage(): Response
    {
        //return $this->render('home.html.twig');
        return new Response('Hello World');
    }

    //wildcard Routes
    #[Route('/browse/{slug}')]
    public function browse(string $slug = null): Response
    {
        if ($slug) {
            $title = str_replace('-', ' ', $slug);
        } else {
            $title = 'Browse our collection of Genres';
        }

        return new Response('Genre: ' . $title);
    }
}
