<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Form\PlaylistFormType;
use App\Form\PlaylistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class PlaylistFormController extends AbstractController
{
    #[Route('/playlist/form', name: 'app_playlist_form')]
    public function index(): Response
    {
        return $this->render('playlist_form/index.html.twig', [
            'controller_name' => 'PlaylistFormController',
        ]);
    }

    #[Route('/crearPlayli', name: 'app_crearplaylist')]
    public function crearPlaylist(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        $playlist = new Playlist();
        $playlist->setPropietario($user); // Asigna el usuario autenticado como propietario

        // Crear el formulario
        $form = $this->createForm(PlaylistFormType::class, $playlist);
        $form->handleRequest($request);

        // Procesar el formulario
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($playlist);
            $entityManager->flush();

            return new RedirectResponse(url: '/index.html');
        }

        return $this->render('playlist_form/playlist.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
