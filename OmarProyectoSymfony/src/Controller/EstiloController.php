<?php

namespace App\Controller;

use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class EstiloController extends AbstractController
{
    #[Route('/estilo', name: 'app_estilo')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }


    #[Route('/estilo/new', name: 'new_estilo_crear')]
    public function newEstilo(EntityManagerInterface $entity)
    {
        $estilo = new Estilo();
        $estilo->setNombre("HipHop");
        $estilo->setDescripcion("Descripcion HipHop");
        
        //hacer persist
        $entity->persist($estilo);
        $entity->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CancionController.php',
        ]);
    }
}
