<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Perfil;
use App\Entity\Estilo;
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

    #[Route('/perfil/new', name: 'new_perfil_crear')]
    public function crearEstilo(EntityManagerInterface $entity){
        $estiloRepo = $entity->getRepository(Estilo::class);
        $estilo = $estiloRepo->findOneByNombre('HipHop');

        $perfil=new Perfil();
        $perfil->setFoto('Foto');
        $perfil->setDescripcion('Perfil 1');
        $perfil->addEstiloMusicalPreferido($estilo);

        $entity->persist($perfil);
        $entity->flush();

        return $this->json([
            'message' => 'Perfil creado!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }
}