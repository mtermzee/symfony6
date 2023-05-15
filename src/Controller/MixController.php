<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    private EntityManagerInterface $em;
    private VinylMixRepository $vr;

    public function __construct(EntityManagerInterface $entityManagerInterface, VinylMixRepository $vinylMixRepository)
    {
        $this->em = $entityManagerInterface;
        $this->vr = $vinylMixRepository;
    }

    #[Route('/mix', name: 'app_mix')]
    public function index(): Response
    {
        return $this->render('mix/index.html.twig', [
            'controller_name' => 'MixController',
        ]);
    }

    #[Route('/mix/new', name: 'app_mix_new')]
    public function new(): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('1. The Prodigy - No Good (Start The Dance) (Bad For You Mix)');
        $mix->setDescription('The Prodigy');
        $genres = ['pop', 'rock'];
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $this->em->persist($mix);
        $this->em->flush();

        //return $this->redirectToRoute('app_mix');
        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80\'s heaven',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }

    /* #[Route('/mix/{id}', name: 'app_mix_getById')]
    public function show($id): Response
    {
        $mix = $this->vr->find($id);

        if (!$mix) {
            throw $this->createNotFoundException(sprintf('No mix for id %d', $id));
        }

        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }*/

    #[Route('/mix/{id}', name: 'app_mix_getById')]
    public function show(VinylMix $mix): Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request): Response
    {

        $direction = $request->request->get('direction', 'up');

        if ($direction === 'up') {
            $mix->setVotes($mix->getVotes() + 1);
        } else {
            $mix->setVotes($mix->getVotes() - 1);
        }

        $this->em->flush();

        return $this->redirectToRoute('app_mix_getById', [
            'id' => $mix->getId(),
        ]);
    }
}
