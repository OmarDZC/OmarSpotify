<?php

namespace App\Controller;

use App\Entity\Estilo;
use App\Entity\Perfil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }

    #[Route('/perfil/new', name: 'app_perfil_crear')]
    public function newPerfil(EntityManagerInterface $entity): JsonResponse
    {
        $estilo = new Estilo();
        $estilo->setNombre("HipHop");
        $estilo->setDescripcion("Descripcion del HipHop");
        
        $perfil = new Perfil();
        $perfil->setFoto("foto");
        $perfil->addEstiloMusicalPreferido($estilo);
        $perfil->setDescripcion("Descripcion del perfil");

        //hacer persistencia
        $entity->persist($perfil);
        $entity->flush();
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }

}
