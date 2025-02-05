<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Perfil;
use App\Entity\Estilo;
use App\Entity\Usuario;
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
        
        $estilo = new Estilo();
        $estilo->setNombre("HipHop");
        $estilo->setDescripcion("Descripcion HipHop");

        $perfil = new Perfil();
        $perfil->setFoto('FotoPerfil1');
        $perfil->setDescripcion('Perfil de usuario 1');

        $usuario = new Usuario();
        $usuario->setNombre('Usuario1');
        $usuario->setEmail('usuario1@gmail.com');
        $usuario->setPassword('123');
        $usuario->setFechaNacimiento(new \DateTime('1999-02-02'));
        $usuario->setPerfil($perfil);
        
        $estiloRepo = $entity->getRepository(Estilo::class);
        $estilo = $estiloRepo->findOneByNombre('HipHop');
        $perfil->addEstiloMusicalPreferido($estilo);

        $entity->persist($perfil);
        $entity->persist($usuario);
        $entity->flush();

        return $this->json([
            'message' => 'Perfil creado!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }
}