<?php

namespace App\Controller\Admin;

use App\Entity\Playlist;
use App\Entity\PlaylistCancion; // Asegúrate de importar la entidad PlaylistCancion
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlaylistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Playlist::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
            TextField::new('visibilidad'),
            IntegerField::new('likes'),
            IntegerField::new('reproducciones'),
            /* AssociationField::new('propietario', 'Propietario')->setFormTypeOption('by_reference', true), */
            CollectionField::new('playlistCanciones', 'Canciones')->useEntryCrudForm(PlaylistCancionCrudController::class),
        ];
    }
}
