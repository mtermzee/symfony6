<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use App\Service\MixRepositrory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private EntityManagerInterface $em;
    private VinylMixRepository $vr;

    public function __construct(EntityManagerInterface $entityManagerInterface, VinylMixRepository $vinylMixRepository)
    {
        $this->em = $entityManagerInterface;
        $this->vr = $vinylMixRepository;
    }

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
    #[Route('/browse', name: 'app_browse')]
    public function browse(string $slug = null, Request $request): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        // or we can use VinylMixRepository to query
        /* $mixRepositrory = $this->em->getRepository(VinylMix::class);
        $mixes = $mixRepositrory->findAll();*/
        //$mixes = $this->vr->findBy([], ['votes' => 'DESC']);
        //$mixes = $this->vr->findAllOrderByVotes($slug);

        $queryBuilder = $this->vr->createOrderedByVotesQueryBuilder($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            9
        );

        return $this->render('home/browse.html.twig', [
            'genre' => $genre,
            'pager' => $pagerfanta,
        ]);
    }
}
