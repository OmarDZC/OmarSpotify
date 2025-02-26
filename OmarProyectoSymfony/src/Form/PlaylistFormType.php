<?php

namespace App\Form;

use App\Entity\Playlist;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\PlaylistCancionFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaylistFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('visibilidad')
            ->add('likes')
            ->add('reproducciones')
            ->add('playlistCanciones', CollectionType::class, [
                'entry_type' => PlaylistCancionFormType::class,
                'allow_add' => true,  // Permite agregar canciones
                'allow_delete' => true, // Permite eliminar canciones
                'by_reference' => false,  
                'prototype' => true,  // Habilita el prototipo para JS
                'label' => 'Canciones en la Playlist'
            ]);            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
        ]);
    }
}
