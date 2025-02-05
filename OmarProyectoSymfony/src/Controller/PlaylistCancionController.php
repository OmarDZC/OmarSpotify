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
    $perfil = new Perfil();
    $perfil->setFoto("foto 3 del perfil");
    $perfil->setDescripcion("descripcion del usuario 3");

    //crear usuario
    $propietario = new Usuario();
    $propietario->setEmail("usuario@ejemplo.com");
    $propietario->setPassword("12456");
    $propietario->setNombre("usuario4");
    $fechaNacimiento = new \DateTime('1999-02-02');
    $propietario->setFechaNacimiento($fechaNacimiento);
    $propietario->setPerfil($perfil);

    //crear playlist
    $playlist = new Playlist();
    $playlist->setNombre("playlist de Trap");
    $playlist->setVisibilidad("false");
    /* $playlist->setReproducciones(234); */
    $playlist->setLikes(44);
    $playlist->setPropietario($propietario);

    //crear genero
    $genero = new Estilo();
    $genero->setNombre("trap");
    $genero->setDescripcion("estilo de trap");

    //crear canción
    $cancion = new Cancion();
    $cancion->setTitulo("Conversations");
    $cancion->setDuracion(216);
    $cancion->setAlbum("Legends Never Die");
    $cancion->setAutor("Juice WRLD");
    $cancion->setGenero($genero);
    $cancion->setReproducciones(4324);
    $cancion->setLikes(867);

    //crear PlaylistCancion
    $playlistCancion = new PlaylistCancion();
    $playlistCancion->setPlaylist($playlist);
    $playlistCancion->setCancion($cancion);
    $playlistCancion->setReproducciones(234);

    //persistencia
    $entity->persist($propietario);
    $entity->persist($playlist);
    $entity->persist($genero);
    $entity->persist($cancion);
    $entity->persist($playlistCancion);
    $entity->flush();

    return $this->json([
        'message' => 'Playlist and song created successfully!',
        'path' => 'src/Controller/PlaylistCancionController.php',
    ]);
}

}
