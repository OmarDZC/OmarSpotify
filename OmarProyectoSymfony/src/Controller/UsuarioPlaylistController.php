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
        //crear perfil
        $usuario = new Usuario();
        $usuario->setEmail("usuario1@gmail.com");
        $usuario->setPassword("1234");
        $usuario->setNombre("usuario3");
        $fechaNacimiento = new \DateTime('1999-02-02');
        $usuario->setFechaNacimiento($fechaNacimiento);

        //crear perfil
        $perfil = new Perfil();
        $perfil->setFoto("foto 3 del perfil");
        $perfil->setDescripcion("descripcion del usuario 3");

        $usuario->setPerfil($perfil);

        //Crear la playlist
        $playlist = new Playlist();
        $playlist->setNombre("playlist Rap");
        $playlist->setVisibilidad("true");
        /* $playlist->setReproducciones(41234); */
        $playlist->setLikes(2342);
        $playlist->setPropietario($usuario);

        $usuarioPlaylist = new UsuarioPlaylist();
        $usuarioPlaylist->setReproducida(3523523);

        
        $usuarioPlaylist->setUsuario($usuario);
        $usuarioPlaylist->setPlaylist($playlist);


        $entity->persist($perfil);
        $entity->persist($usuario);
        $entity->persist($playlist);
        $entity->persist($usuarioPlaylist);
        $entity->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }
}
