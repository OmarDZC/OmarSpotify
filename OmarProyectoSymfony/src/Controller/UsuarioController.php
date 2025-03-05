<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Playlist;
use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface; //se añade para hacer log
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
    public function isLoggedIn(Security $security, LoggerInterface $log): JsonResponse
    {
        $usuario = $security->getUser();
        //para hacer un log del usuario cuando se logee
        $log->debug($usuario->getNombre() . " se logeo");

        if ($usuario) {
            return new JsonResponse([
                'isLoggedIn' => true,
                'nombre' => $usuario->getNombre(),
                'email' => $usuario->getEmail() //funciona y devuelve el nombre y email
            ]);
        }

        return new JsonResponse(['isLoggedIn' => false]);
    }

    //DEVOLVER SUS PLAYLIST
    #[Route('/user/playlist/misPlaylist', name: 'api_mis_playlist', methods: ['GET'])]
    public function getMisPlaylists(Security $security, EntityManagerInterface $entity, LoggerInterface $log): JsonResponse
    {
        $usuario = $security->getUser(); //Obtiene el usuario autenticado

        //obtener playlist de usuario autenticado
        $playlistRepo = $entity->getRepository(Playlist::class);
        $playlists = $playlistRepo->findBy(['propietario' => $usuario]);

        $playlistsArray = array_map(function ($playlist) {
            return [
                'nombre' => $playlist->getNombre(),
                'visibilidad' => $playlist->getVisibilidad(),
                'likes' => $playlist->getLikes(),
                'propietario' => $playlist->getPropietario()->getNombre(),
            ];
        }, $playlists);

        $log->info("imprime las playlist de " . $usuario->getNombre());

        return new JsonResponse($playlistsArray);
    }

    
}
