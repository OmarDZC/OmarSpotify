<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Perfil;
use App\Entity\Estilo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your Perfil controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }

    #[Route('/perfil/new', name: 'new_perfil_crear')]
    public function crearPerfil(EntityManagerInterface $entityManager): JsonResponse
    {
        //Crear o buscar un estilo
        $estiloRepo = $entityManager->getRepository(Estilo::class);
        $estilo = $estiloRepo->findByNombre('HipHop');

        //Crea el perfil
        $perfil = new Perfil();
        $perfil->setFoto('FotoPerfil1');
        $perfil->setDescripcion('Perfil de usuario 1');

        //Añadir el estilo al perfil
        $perfil->addEstiloMusicalPreferido($estilo);

        $entityManager->persist($perfil);
        $entityManager->flush();

        return $this->json([
            'message' => 'Perfil creado!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }

    
}
