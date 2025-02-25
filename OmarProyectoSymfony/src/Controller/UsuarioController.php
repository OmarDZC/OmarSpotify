<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;



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

    #[Route('/getUsuario', name: 'api_get_usuario', methods: ['GET'])]
    public function getUsuario(Request $request, UsuarioRepository $usuarioRepo): JsonResponse
    {
        // Obtener el correo electrónico del usuario desde el parámetro de consulta
        $email = $request->query->get('email');

        // Buscar el usuario por correo electrónico
        $usuario = $usuarioRepo->findByEmail($email);

        return new JsonResponse(['nombre' => $usuario->getNombre()]);
    }


    #[Route('/logeado', name: 'api_is_logged_in', methods: ['GET'])]
    public function isLoggedIn(Security $security): JsonResponse
    {
        $usuario = $security->getUser();

        if ($usuario) {
            return new JsonResponse([
                'isLoggedIn' => true,
                'nombre' => $usuario->getNombre(),
                'email' => $usuario->getEmail() //funciona y devuelve el nombre y email
            ]);
        }

        return new JsonResponse(['isLoggedIn' => false]);
    }
}
