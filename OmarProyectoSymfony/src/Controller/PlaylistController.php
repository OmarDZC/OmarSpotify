<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Playlist;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistController extends AbstractController
{
    #[Route('/playlist', name: 'app_playlist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistController.php',
        ]);
    }

    #[Route('/playlist/new', name: 'app_playlist_new')]
    public function newPerfil(EntityManagerInterface $entity): JsonResponse
    {
        $usuarioRepo = $entity->getRepository(Usuario::class);
        $usuario = $usuarioRepo->findByNombre('UsuarioElPrimero');

        //playlist
        $playlist = new Playlist();
        $playlist->setNombre('Playlist1');
        $playlist->setVisibilidad('public');
        $playlist->setLikes(546);
        $playlist->setPropietario($usuario); //asociarlo al usurio

        //persist
        $entity->persist($playlist);
        $entity->flush();
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }

    
    #[Route('/mostrarPlaylist', name: 'listas_playlist', methods: ['GET'])]
    public function listarCanciones(EntityManagerInterface $entityManager): JsonResponse
    {
        $playlistRepo = $entityManager->getRepository(Playlist::class);
        $playlists = $playlistRepo->findAll();
    
        $data = [];
        foreach ($playlists as $playlist) {
            $data[] = [
                'nombre' => $playlist->getNombre(),
                'visibilidad' => $playlist->getVisibilidad(),
                'propietario' => $playlist->getPropietario() ? $playlist->getPropietario()->getId() : null,
                'likes' => $playlist->getLikes(),
                'canciones' => $playlist->getPlaylistCanciones()->count()
            ];
        }
        return $this->json($data);
    }

}
