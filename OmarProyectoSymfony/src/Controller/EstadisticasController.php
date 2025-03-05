<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use App\Repository\CancionRepository;
use App\Repository\PlaylistCancionRepository;
use App\Repository\PlaylistRepository;
use App\Repository\UsuarioRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class EstadisticasController extends AbstractController
{
    #[Route('/manager/estadisticas', name: 'app_estadisticas')]
    public function index(PlaylistCancionRepository $playlistCancionRepo, LoggerInterface $log): Response
    {
        /* $datos = $playlistCancionRepo->obtenerReproduccionesPorPlaylist(); */
        $log->debug("Manager entró a estadisticas");

        return $this->render('estadisticas/estadisticas.html.twig', [
            'controller_name' => 'EstadisticasController',
        ]);
    }

    /* #[Route('/manager/estadisticas/datos', name: 'estadisticas_datos')]
    public function obtenerDatos(PlaylistCancionRepository $playlistCancionRepository): JsonResponse
    {
        $datos = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();
        return $this->json($datos); // convierte el array $datos en una respuesta JSON.
    } */

    //LIKES
    #[Route('/manager/estadisticas/likes', name: 'estadisticas_likes')]
    public function obtenerLikesPorPlaylist(PlaylistRepository $playlistRepo): JsonResponse
    {
        $likes = $playlistRepo->obtenerLikesPorPlaylist();
        return $this->json($likes);
    }

    //REPRODUCCIONES
    #[Route('/manager/estadisticas/reproducciones', name: 'estadisticas_reproducciones')]
    public function playlistMasReproducciones(PlaylistRepository $playlistRepo): JsonResponse
    {
        $reproducciones = $playlistRepo->playlistMasReproducciones();
        return $this->json($reproducciones);
    }

    //EDADES
    #[Route('/manager/estadisticas/edades', name: 'estadisticas_edades')]
    public function obtenerDistribucionDeEdades(UsuarioRepository $usuarioRepo): JsonResponse
    {
        // Obtener las fechas de nacimiento
        $usuarios = $usuarioRepo->obtenerFechasDeNacimiento();

        // Inicializar los rangos de edad
        $distribucionDeEdades = [
            'Menor de 18' => 0,
            '18-25' => 0,
            '26-30' => 0,
            'Mayor de 30' => 0,
        ];

        //Calcular la edad 
        foreach ($usuarios as $usuario) {
            if ($usuario['fechaNacimiento'] === null) {
                continue;
            }

            $edad = $this->calcularEdad($usuario['fechaNacimiento']);

            //Clasificar según la edad
            switch (true) {
                case $edad < 18:
                    $distribucionDeEdades['Menor de 18']++;
                    break;
                case $edad >= 18 && $edad <= 25:
                    $distribucionDeEdades['18-25']++;
                    break;
                case $edad >= 26 && $edad <= 30:
                    $distribucionDeEdades['26-30']++;
                    break;
                default:
                    $distribucionDeEdades['Mayor de 30']++;
                    break;
            }
        }

        return $this->json($distribucionDeEdades);
    }

    //Método para calcular la edad de una fecha de nacimiento
    private function calcularEdad(\DateTimeInterface $fechaNacimiento): int
    {
        $hoy = new \DateTime();
        $edad = $hoy->diff($fechaNacimiento);
        return $edad->y;  // Solo devolver los años
    }


    //CANCIONES MAS ESCUCHADA
    #[Route('/manager/estadisticas/topCanciones', name: 'estadisticas_canciones_reproducidas', methods: ['GET'])]
    public function cancionesMasReproducidas(CancionRepository $cancionRepo): JsonResponse
    {
        $canciones = $cancionRepo->topCancionesMasReproducidas();

        $cancionesData = [];
        foreach ($canciones as $cancion) {
            $cancionesData[] = [
                'id' => $cancion->getId(),
                'titulo' => $cancion->getTitulo(),
                'album' => $cancion->getAlbum(),
                'autor' => $cancion->getAutor(),
                'genero' => $cancion->getGenero()->getNombre(),
                'reproducciones' => $cancion->getReproducciones(),
                'likes' => $cancion->getLikes()
            ];
        }
        return $this->json($cancionesData);
    }

    //REPRODUCCIONES CANCIONES POR GENERO
    #[Route('/manager/estadisticas/cancionesGenero', name: 'estadisticas_canciones_genero', methods: ['GET'])]
    public function distribucionReproduccionesPorGenero(CancionRepository $cancionRepo): JsonResponse
    {
        $distribucion = $cancionRepo->reproduccionesPorGenero();
        return $this->json($distribucion);
    }
}
