<?php

namespace App\Form;

use App\Entity\Aeroport;
use App\Entity\Avion;
use App\Entity\Vol;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numVol')
            ->add('duree', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('heureArrive', null, [
                'widget' => 'single_text',
            ])
            ->add('nbPassagers')
            ->add('prixVol')
            ->add('avion', EntityType::class, [
                'class' => Avion::class,
                'choice_label' => 'modele',
            ])
            ->add('aeroportDepart', EntityType::class, [
                'class' => Aeroport::class,
                'choice_label' => 'nom_aeroport',
            ])
            ->add('aeroportArrive', EntityType::class, [
                'class' => Aeroport::class,
                'choice_label' => 'nom_aeroport',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
