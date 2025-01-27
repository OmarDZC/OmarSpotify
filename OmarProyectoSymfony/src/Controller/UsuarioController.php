<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioController.php',
        ]);
    }

    #[Route('/usuario/new', name: 'app_playlist_crear')]
    public function newUsuario(EntityManagerInterface $entity): JsonResponse
    {
        $perfil = new Perfil();
        $perfil->setFoto("foto1");
        $perfil->setDescripcion("perfil del usuario");

        $usuario = new Usuario();
        $usuario->setEmail("ejemplo@gmail.com");
        $usuario->setPassword("1234");
        $usuario->setNombre("usuario1");
        $usuario->setPerfil($perfil);

        //crear el nuevo Date de fecha nacimeinto y añadirlo a usuario
        $fechaNacimiento = new \DateTime('1994-01-01');
        $usuario->setFechaNacimiento($fechaNacimiento);
        

        //hacer persistencia
        $entity->persist($usuario);
        $entity->flush();
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }
}
