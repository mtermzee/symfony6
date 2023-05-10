<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

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
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        //dd($tracks);
        //dump($tracks);

        return $this->render('home/homepage.html.twig', [
            'title' => 'Welcome to the Homepage',
            'tracks' => $tracks,
        ]);
        //return new Response('Hello World');
    }

    //wildcard Routes
    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        $mixes = $this->getMixes();

        return $this->render('home/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }

    private function getMixes(): array
    {
        return [
            ['title' => 'The Best Mix', 'trackCount' => 14, 'genre' => 'Rock', 'createdAt' => new \DateTime('2022-10-02')],
            ['title' => 'The Hottest Mix', 'trackCount' => 12, 'genre' => 'Pop', 'createdAt' => new \DateTime('2022-10-02')],
            ['title' => 'The Coolest Mix', 'trackCount' => 10, 'genre' => 'R&B', 'createdAt' => new \DateTime('2022-10-02')],
            ['title' => 'The Newest Mix', 'trackCount' => 8, 'genre' => 'Hip Hop', 'createdAt' => new \DateTime('2022-10-02')],
        ];
    }
}
