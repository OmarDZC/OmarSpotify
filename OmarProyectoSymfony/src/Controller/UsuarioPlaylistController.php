<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Playlist;
use App\Entity\Usuario;
use App\Entity\UsuarioPlaylist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioPlaylistController extends AbstractController
{
    #[Route('/usuario/playlist', name: 'app_usuario_playlist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioPlaylistController.php',
        ]);
    }

    #[Route('/usuarioPlaylist/new', name: 'app_usuarioPlaylist_new')]
    public function newUsuarioPlaylist(EntityManagerInterface $entity): JsonResponse
    {
        $usuarioRepo = $entity->getRepository(Usuario::class);
        $usuario = $usuarioRepo->findByNombre('UsuarioElPrimero');

        $playlistRepo = $entity->getRepository(Playlist::class);
        $playlist = $playlistRepo->findByNombre('Playlist1');

        $usuarioPlaylist = new UsuarioPlaylist();
        $usuarioPlaylist->setPlaylist($playlist);
        $usuarioPlaylist->setUsuario($usuario);
        $usuarioPlaylist->setReproducida(5732);

        //persist
        $entity->persist($usuarioPlaylist);
        $entity->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }
}
