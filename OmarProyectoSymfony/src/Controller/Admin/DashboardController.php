<?php

namespace App\Controller\Admin;

use App\Entity\Cancion;
use App\Entity\Estilo;
use App\Entity\Perfil;
use App\Entity\Playlist;
use App\Entity\PlaylistCancion;
use App\Entity\Usuario;
use App\Entity\UsuarioPlaylist;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('OmarProyectoSymfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Cancion', 'fas fa-list', Cancion::class);
        yield MenuItem::linkToCrud('Estilo', 'fas fa-list', Estilo::class);
        yield MenuItem::linkToCrud('Perfil', 'fas fa-list', Perfil::class);
        yield MenuItem::linkToCrud('Usuario', 'fas fa-list', Usuario::class);
        yield MenuItem::linkToCrud('Playlist', 'fas fa-list', Playlist::class);
        yield MenuItem::linkToCrud('UsuarioPlaylist', 'fas fa-list', UsuarioPlaylist::class);
        yield MenuItem::linkToCrud('PlaylistCancion', 'fas fa-list', PlaylistCancion::class);
    }
}
