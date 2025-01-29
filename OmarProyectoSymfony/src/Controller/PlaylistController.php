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
        $perfil = new Perfil();
        $perfil->setFoto("foto usuario1");
        $perfil->setDescripcion("Perfil de usuario1");

        $usuario = new Usuario();
        $usuario->setNombre("usuario1");
        $usuario->setEmail("usuario2@gmail.com");
        $usuario->setPassword("123");
        $fechaNacimiento = new \DateTime('1999-02-02');
        $usuario->setFechaNacimiento($fechaNacimiento);
        $usuario->setPerfil($perfil);

        
        $playlist = new Playlist();
        $playlist->setNombre("Mi Playlist HipHop");
        $playlist->setVisibilidad("true");
        //Para iniciar en 0
        $playlist->setReproducciones(10000);  
        $playlist->setLikes(500);  
        $playlist->setPropietario($usuario);
        
        
        //hacer persistencia
        $entity->persist($usuario);
        $entity->persist($perfil);
        $entity->persist($playlist);
        $entity->flush();
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }


}
