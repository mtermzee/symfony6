<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    #[Route('/api/song/{id<\d+>}', name: 'api_songs_get_one', methods: ['GET'])]
    public function getSong(int $id, LoggerInterface $logger): Response
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
            'url' => 'https://symfonycasts.s3.amazonaws.com/sample.mp3',
        ];

        $logger->info('Returning API response for song {song}', [
            'song' => $id,
        ]);

        return $this->json($song);
    }
}
