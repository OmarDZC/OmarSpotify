<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Estilo;
use App\Entity\Perfil;
use App\Entity\Playlist;
use App\Entity\PlaylistCancion;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistCancionController extends AbstractController
{
    #[Route('/playlist/cancion', name: 'app_playlist_cancion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistCancionController.php',
        ]);
    }

    #[Route('/playlistCancion/new', name: 'app_playlist_cancion_new')]
    public function newPlaylistCancion(EntityManagerInterface $entity): JsonResponse
    {
        $cancionRepo = $entity->getRepository(Cancion::class);
        $cancion = $cancionRepo->findByNombre('Misfit');

        $playlistRepo = $entity->getRepository(Playlist::class);
        $playlist = $playlistRepo->findByNombre('Playlist1');

        $playlistCancion = new PlaylistCancion();
        $playlistCancion->setPlaylist($playlist);
        $playlistCancion->setCancion($cancion);
        $playlistCancion->setReproducciones(4723);

        //persist
        $entity->persist($playlistCancion);
        $entity->flush();


        return $this->json([
            'message' => 'Playlist and song created successfully!',
            'path' => 'src/Controller/PlaylistCancionController.php',
        ]);
    }
}
