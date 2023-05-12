<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
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
        $mix->setGenre('pop');
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
}
