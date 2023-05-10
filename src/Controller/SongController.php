<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    #[Route('/api/song/{id}', name: 'app_song')]
    public function getSong($id): Response
    {
        $song = [
            'id' => $id,
            'title' => 'Song title',
            'artist' => 'Artist name',
            'album' => 'Album name',
            'duration' => 180,
            'year' => 2021,
            'genre' => 'Pop',
            'image' => 'https://via.placeholder.com/150',
            'url' => 'https://via.placeholder.com/150',
        ];

        return $this->json($song);
    }
}
