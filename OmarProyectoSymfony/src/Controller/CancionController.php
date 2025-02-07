<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CancionController extends AbstractController
{
    #[Route('/cancion', name: 'app_cancion', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CancionController.php',
        ]);
    }

    #[Route('/cancion/new', name: 'new_cancion', methods: ['POST'])]
    public function newCancion(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $estiloRepo = $entityManager->getRepository(Estilo::class);
        $estilo = $estiloRepo->findByNombre('HipHop');

        $cancion = new Cancion();
        $cancion->setTitulo('Misfit');
        $cancion->setDuracion(144);  // 2:39 min
        $cancion->setAlbum('The Party Never Ends');
        $cancion->setAutor('Juice WRLD');
        /* $cancion->setReproducciones(500000); */
        $cancion->setLikes(250000);

        //Asignar el estilo encontrado
        $cancion->setGenero($estilo);

        $entityManager->persist($cancion);
        $entityManager->flush();


        return $this->json([
            'message' => 'Canción creada correctamente',
            'id' => $cancion->getId(),
            'titulo' => $cancion->getTitulo(),
            'duracion' => $cancion->getDuracion(),
            'album' => $cancion->getAlbum(),
            'autor' => $cancion->getAutor(),
            'estilo' => $estilo->getNombre(),
        ]);
    }

    #[Route('/canciones', name: 'listar_canciones', methods: ['GET'])]
    public function listarCanciones(EntityManagerInterface $entityManager): JsonResponse
    {
        $cancionesRepo = $entityManager->getRepository(Cancion::class);
        //obtener todas las canciones
        $canciones = $cancionesRepo->findAll();

        //envia como JSON
        $data = [];
        foreach ($canciones as $cancion) {
            $data[] = [
                'titulo' => $cancion->getTitulo(),
                'autor' => $cancion->getAutor(),
                'album' => $cancion->getAlbum(),
            ];
        }

        return $this->json($data);
    }
}
