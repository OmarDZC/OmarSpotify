<?php

namespace App\Controller;

use App\Repository\PlaylistCancionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class EstadisticasController extends AbstractController
{
    #[Route('/estadisticas', name: 'app_estadisticas')]
    public function index(PlaylistCancionRepository $playlistCancionRepo): Response
    {
        $datos = $playlistCancionRepo->obtenerReproduccionesPorPlaylist();

        return $this->render('estadisticas/index.html.twig', [
            'controller_name' => 'EstadisticasController',
        ]);
    }

    #[Route('/estadisticas/datos', name: 'estadisticas_datos')]
    public function obtenerDatos(PlaylistCancionRepository $playlistCancionRepository): JsonResponse
    {
        $datos = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();
        return $this->json($datos); // convierte el array $datos en una respuesta JSON.
    }
}
