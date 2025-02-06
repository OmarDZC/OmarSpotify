<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Usuario;
use DateTime;
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
        $perfilRepo = $entity->getRepository(Perfil::class);
        $perfil = $perfilRepo->find('1');

        $usuario = new Usuario();
        $usuario->setEmail('usuario1@gmail.com');
        $usuario->setPassword('1234');
        $usuario->setNombre('UsuarioElPrimero');
        $fecha = new DateTime('1994-03-12'); //para que sea valida
        $usuario->setFechaNacimiento($fecha);
        //asociar al perfil encontrado
        $usuario->setPerfil($perfil);

        //persistir
        $entity->persist($usuario);
        $entity->flush();

        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }
}
