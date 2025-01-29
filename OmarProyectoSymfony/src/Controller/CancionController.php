<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CancionController extends AbstractController
{
    #[Route('/cancion', name: 'app_cancion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }

    #[Route('/cancion/new', name: 'new_cancion')]
    public function newCancion(EntityManagerInterface $entity, Request $request)
    {
        $cancion = new Cancion();
        $cancion->setTitulo('Misfit');
        $cancion->setDuracion(144);  // 2:39min
        $cancion->setAlbum('The Party Never Ends');
        $cancion->setAutor('Juice WRLD');
        $cancion->setReproducciones(500000);
        $cancion->setLikes(250000);

        $estilo = new Estilo();
        $estilo->setNombre("HipHop");
        $estilo->setDescripcion("Descripcion de HipHop");

        //coger en cancion el genero creado
        $cancion->setGenero($estilo);

        //hacer persist
        $entity->persist($cancion);
        $entity->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CancionController.php',
        ]);
    }
}
