<?php

namespace App\Form;

use App\Entity\Cancion;
use App\Entity\PlaylistCancion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaylistCancionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cancion', EntityType::class, [
                'class' => Cancion::class,
                'choice_label' => 'titulo',  // Muestra el título de la canción
                'placeholder' => 'Selecciona una canción', 
                'expanded' => false,  // Si lo pones en true, será tipo checkbox
                'multiple' => false,  // Solo permite una canción por entrada
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlaylistCancion::class,
        ]);
    }
}
